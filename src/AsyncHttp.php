<?php
namespace Xd\AsyncHttp;

/**
 * 对请求的一个包封，主要为了方便调用
 * Class AsyncHttp
 * @package AsyncHttp
 */
class AsyncHttp
{
    /**
     * get 请求
     * @param $url
     * @param array $query
     * @return Get
     */
    public static function get($url, $query = [])
    {
        return new Get($url, $query);
    }

    /**
     * delete 请求
     * @param $url
     * @return Delete
     */
    public static function delete($url)
    {
        return new Delete($url);
    }

    /**
     * post 请求
     * @param $url
     * @param null $body
     * @return Post
     */
    public static function post($url, $body = null)
    {
        return new Post($url, $body);
    }

    /**
     * put 请求
     * @param $url
     * @param null $body
     * @return Put
     */
    public static function put($url, $body = null)
    {
        return new Put($url, $body);
    }
}