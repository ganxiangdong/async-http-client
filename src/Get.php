<?php
namespace AsyncHttp;

/**
 * Class Get
 * @package AsyncHttp
 */
class Get extends Libs\Http
{
    protected $requestMethod = 'GET';

    /**
     * Get constructor.
     * @param string $url
     * @param array $query
     */
    public function __construct($url, $query = [])
    {
        $this->url = $url;
        if (!empty($query) && is_array($query)) {
            $queryStr = http_build_query($query);
            $this->url .= strpos($url, '?') ? "&{$queryStr}" : "?{$queryStr}";
        }
    }
}