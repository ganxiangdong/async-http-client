<?php
namespace AsyncHttp;

/**
 * Class Put
 * @package AsyncHttp
 */
class Put extends Libs\Http
{
    protected $requestMethod = 'PUT';

    /**
     * Put constructor.
     * @param $url
     * @param $body
     */
    public function __construct($url, $body = null)
    {
        $this->url = $url;
        $this->requestBody = $body;
    }
}