<?php

namespace MyApp\Service;

use Symfony\Component\DomCrawler\Crawler;
use Curl\Curl;

/**
 * Description of MyPageParsing
 *
 * @author tomasz
 */
class MyPageParsing
{

    private $curl;
    private $crawler;
        private $url = 'https://phpers-summit-2017.evenea.pl/';
    private $html;
    private $response;

    public function __construct(Curl $curl, Crawler $crawler)
    {
        $this->curl = $curl;
        $this->crawler = $crawler;
    }

    protected function askWebsite()
    {
        $this->curl->get($this->url);
        if ($this->curl->error) {
            throw new Exception($this->curl->error_message);
        } else {
            $this->html = $this->curl->response;
        }
    }

    protected function parseWebsite()
    {
        $this->crawler->addContent($this->html);
        $elements = $this->crawler->filter('td.tdAvailable.lowercase')
                ->each(function ($node, $i) {
            $title = substr(trim($node->previousAll()->text()), 0, 40);
            $status = trim($node->text());
            return [$title, $status];
        });
        $response = [];
        foreach ($elements as $pair) {
            $response[$pair[0]] = $pair[1];
        }
        $this->response = $response;
    }

    public function getApiData()
    {
        $this->askWebsite();
        $this->parseWebsite();
        $time = date('Y-m-d H:i:s');
        return [
            'time' => $time,
            'data' => $this->response
        ];
    }

    public function getData()
    {
        $this->askWebsite();
        $this->parseWebsite();
        return $this->response;
    }

}
