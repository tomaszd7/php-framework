<?php

namespace MyApp\Service;

use Symfony\Component\DomCrawler\Crawler;
use Curl\Curl;
use MyApp\Service\MyPageAnalyzer;

/**
 * Description of MyPageParsing
 *
 * @author tomasz
 */
class MyPageParsing
{
    private $curl;
    private $crawler;
    private $analyzer;
    private $html;
    private $response;
    private $props = [];
//    private $url;
//    private $parseElementCss;
//    private $parseTitle;
//    private $parseValue;
    private $phpSummit2017 = [
        'url' => 'https://phpers-summit-2017.evenea.pl/',
        'parseElementCss' => 'td.tdAvailable.lowercase',
        'parseTitle' => 'Symfony',
        'parseValue' => 'Wyprzedane',
        'analyzer' => 'not exists'
    ];
    private $reactJs = [
        'url' => 'https://warsawjs-workshop-10.evenea.pl/',
        'parseElementCss' => 'td.tdAvailable.lowercase',
        'parseTitle' => 'Bilet',
        'parseValue' => 'Jeszcze niedostępne',
        'analyzer' => 'not exists'
    ];

    public function __construct(Curl $curl, Crawler $crawler)
    {
        $this->curl = $curl;
        $this->crawler = $crawler;
        $this->createProperties($this->reactJs);
        $this->analyzer = new MyPageAnalyzer($this->props);
    }

    private function createProperties(array $event)
    {
        $this->props = $event;
    }

    protected function askWebsite()
    {
        $this->curl->get($this->props['url']);
        if ($this->curl->error) {
            throw new Exception($this->curl->error_message);
        } else {
            $this->html = $this->curl->response;
        }
    }

    protected function parseWebsite()
    {
        $this->crawler->addContent($this->html);
        $elements = $this->crawler->filter($this->props['parseElementCss'])
                ->each(function ($node, $i) {
            $title = substr(trim($node->previousAll()->text()), 0, 40);
            $status = trim($node->text());
            return [
                'title' => $title,
                'value' => $status];
        });

        $sendEmail = $this->analyzer->analyze($elements);
        $this->response = $this->arrayIntoAssocArray($elements);
        $this->response['sendEmail'] = json_encode($sendEmail);
    }

    public function getApiData(): array
    {
        $this->askWebsite();
        $this->parseWebsite();
        $time = date('Y-m-d H:i:s');
        return [
            'time' => $time,
            'data' => $this->response
        ];
    }

    public function getData(): array
    {
        $this->askWebsite();
        $this->parseWebsite();
        return $this->response;
    }

    private function arrayIntoAssocArray($arr): array
    {
        $response = [];
        foreach ($arr as $pair) {
            $response[$pair['title']] = $pair['value'];
        }
        return $response;
    }

}
