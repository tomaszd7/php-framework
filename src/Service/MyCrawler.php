<?php

namespace MyApp\Service;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Description of MyCrawler
 *
 * @author tomasz
 */
class MyCrawler
{
    private $crawler;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;        
    }

    public function parsePreviousSibling(string $html, $prop)
    {
        $this->crawler->addContent($html);
        $elements = $this->crawler->filter($prop)
                ->each(function ($node, $i) {
            $title = substr(trim($node->previousAll()->text()), 0, 40);
            $status = trim($node->text());
            return [
                'title' => $title,
                'value' => $status];
        });
        return $elements;
    }
}
