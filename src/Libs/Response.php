<?php
namespace AsyncHttp\Libs;

/**
 * Class Response
 * @package AsyncHttp\Libs
 */
class Response
{
    /**
     * 响应状态码
     * @var int
     */
    public $statusCode;

    /**
     * 响应的头
     * @var
     */
    public $headers;

    /**
     * 响应数据
     * @var string
     */
    public $body;

    /**
     * 网络请求状态的一些信息
     * @var array
     */
    public $info;

    /**
     * 网络请求状态
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * 头信息
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * body的内容
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * CURL请求的相关信息
     * @return array
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Response constructor.
     * @param $info
     * @param $headers
     * @param $body
     */
    public function __construct($info, $headers, $body)
    {
        $this->info = $info;
        $this->headers = $headers;
        $this->body = $body;
        $this->statusCode = $info['http_code'];
    }

    /**
     * 获取某header
     * @param $key
     * @return string
     */
    public function getHeader($key)
    {
        if (empty($this->headers[$key])) {
            return '';
        }
        return $this->headers[$key];
    }
}