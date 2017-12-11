<?php
namespace Xd\AsyncHttp;

use Xd\AsyncHttp\Libs\Http;

/**
 * Class Delete
 * @package AsyncHttp
 */
class Delete extends Http
{
    protected $requestMethod = 'DELETE';

    public function __construct($url)
    {
        $this->url = $url;
    }
}