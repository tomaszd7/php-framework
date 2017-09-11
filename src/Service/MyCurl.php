<?php

namespace MyApp\Service;

use Curl\Curl;

/**
 * Description of MyCurl
 *
 * @author tomasz
 */
class MyCurl
{
    private $curl;
    
    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }
    
    public function getUrl(string $url)
    {
        $this->curl->get($url);
        if ($this->curl->error) {
            throw new \Exception($this->curl->error_message);
        } else {
            return $this->curl->response;
        }
    }
}
