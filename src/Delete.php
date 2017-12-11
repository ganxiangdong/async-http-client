<?php
namespace AsyncHttp;

/**
 * Class Delete
 * @package AsyncHttp
 */
class Delete extends Libs\Http
{
    protected $requestMethod = 'DELETE';

    public function __construct($url)
    {
        $this->url = $url;
    }
}