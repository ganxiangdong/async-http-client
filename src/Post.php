<?php
namespace Xd\AsyncHttp;

use Xd\AsyncHttp\Libs\Http;

/**
 * Class Post
 * @package AsyncHttp
 */
class Post extends Http
{
    protected $requestMethod = 'POST';

    /**
     * Post constructor.
     * @param $url
     * @param $body 请求的数据
     */
    public function __construct($url, $body = null)
    {
        $this->url = $url;
        $this->requestBody = $body;
    }
}