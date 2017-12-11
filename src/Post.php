<?php
namespace AsyncHttp;

/**
 * Class Post
 * @package AsyncHttp
 */
class Post extends Libs\Http
{
    protected $requestMethod = 'POST';

    /**
     * Post constructor.
     * @param $url
     * @param $postData 请求的数据
     */
    public function __construct($url, $postData = null)
    {
        $this->url = $url;
        $this->requestBody = $postData;
    }
}