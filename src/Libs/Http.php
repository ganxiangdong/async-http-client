<?php
namespace AsyncHttp\Libs;

/**
 * Class Http
 * @package AsyncHttp\Libs
 */
abstract class Http
{
    /**
     * 请求的URL
     * @var string
     */
    public $url;

    /**
     * 超时秒数
     * @var int
     */
    public $timeout = 8;

    /**
     * 请求的头
     * @var array
     */
    public $requestHeaders;

    /**
     * 请求方式
     * @var
     */
    protected $requestMethod;


    /**
     * 请求body数据
     * @var string
     */
    public $requestBody = '';

    /**
     * 响应信息
     * @var Response
     */
    protected $response;

    /**
     * 协程
     * @var \Generator
     */
    protected $coroutine;


    public function __construct($url)
    {
        $this->url = $url;

    }

    public function request()
    {
        if (!empty($this->response)) { //已经请求过了
            return $this;
        }
        $this->coroutine = $this->writeAndRead();
        $this->coroutine->current();
        return $this;
    }

    /**
     * 读取服务器返回的数据
     * @return Response
     */
    public function getResponse()
    {
        if ($this->response) {
            return $this->response;
        }
        $this->coroutine->next();
        $this->response = $this->coroutine->current();
        return $this->response;
    }

    /**
     * 向服务器写入请求数据
     * @return \Generator
     */
    public function writeAndRead()
    {
        $mh = curl_multi_init();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 7);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->requestMethod);

        //设置请求body
//        这种方式有bug：在POST时，实际并没有write到服务器，所以采用下面的方式解决了此bug
//        if (!empty($this->requestBody)) {
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody);
//            if (is_string($this->requestBody)) {
//                $this->requestHeaders['Content-Length'] = strlen($this->requestBody);
//            }
//        }
        if (!empty($this->requestBody) && (is_array($this->requestBody) || is_string($this->requestBody))) {
            $requestBody = $this->requestBody;
            if (is_array($requestBody)) {
                $requestBody = '';
                foreach ($this->requestBody as $k => $v) {
                    $requestBody .= "{$k}={$v}&";
                }
                $requestBody = rtrim($requestBody, '&');
            } elseif (!isset($this->requestHeaders['Content-Type'])) {
                $this->requestHeaders['Content-Type'] = 'application/json';//默认为json
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
            $this->requestHeaders['Content-Length'] = strlen($requestBody);
        }

        if (!empty($this->requestHeaders)) {
            $headers = [];
            foreach ($this->requestHeaders as $k => $v) {
                $headers[] = "{$k}:{$v}";
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_multi_add_handle($mh, $ch);

        //write 数据
        $active = null;
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        yield $this;

        //read数据
        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($mh) != -1) {
                do {
                    $mrc = curl_multi_exec($mh, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }

        $requestInfo = curl_getinfo($ch);
        $responseRaw = curl_multi_getcontent($ch);
        curl_multi_remove_handle($mh, $ch);
        curl_multi_close($mh);

        $responseArr = $this->parseResponseRaw($responseRaw, $requestInfo);

        $response = new Response($requestInfo, $responseArr['headers'], $responseArr['body']);
        yield $response;
    }

    /**
     * 添加header头
     * @param $key
     * @param $val
     * @return $this
     */
    public function addHeader($key, $val)
    {
        $this->requestHeaders[$key] = $val;
        return $this;
    }

    /**
     * 设置超时
     * @param $timeout
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * 设置请求body
     * @param $requestBody
     */
    public function setRequestBody($requestBody)
    {
        $this->requestBody = $requestBody;
    }

    /**
     * 解析返回数据的body和header
     * @param $raw
     * @param $resInfo
     * @return array|void
     */
    private function parseResponseRaw($raw, $resInfo)
    {
        if (empty($raw) || empty($resInfo)) {
            return ['body' => null, 'headers' => []];
        }
        $headerRaw= substr($raw, 0, $resInfo['header_size']);
        $body = substr($raw, $resInfo['header_size']);
        $headerLines = explode("\r\n", $headerRaw);
        $headers = [];
        foreach ($headerLines as $v) {
            if (empty(trim($v))) {
                break;
            }
            $header = explode(':', $v);
            if (count($header) == 2) {
                $key = trim($header[0]);
                $val = trim($header[1]);
                $headers[$key] = $val;
            }
        }
        return ['body' => $body, 'headers' => $headers];
    }

}