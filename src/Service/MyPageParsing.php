<?php

namespace MyApp\Service;

use MyApp\Service\MyAnalyzer;
use MyApp\Service\MyCurl;
use MyApp\Service\MyCrawler;

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
    private $response;
    private $props;

//    private $url;
//    private $parseElementCss;
//    private $parseTitle;
//    private $parseValue;

    public function __construct(MyCurl $curl, MyCrawler $crawler, MyAnalyzer $analyzer)
    {
        $this->curl = $curl;
        $this->crawler = $crawler;
        $this->analyzer = $analyzer;
    }

    public function setProps(array $props)
    {
        $this->props = $props;
        $this->analyzer->setProps($props);
    }

    private function process()
    {
        $html = $this->curl->getUrl($this->props['url']);
        $elements = $this->crawler->parsePreviousSibling($html, $this->props['parseElementCss']);

        $this->response = $this->arrayIntoAssocArray($elements);

        $sendEmail = $this->analyzer->analyze($elements);
        $this->response['sendEmail'] = json_encode($sendEmail);
    }

    public function getApiData(): array
    {
        $this->process();
        $time = date('Y-m-d H:i:s');
        return [
            'time' => $time,
            'data' => $this->response
        ];
    }

    public function getData(): array
    {
        $this->process();
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
