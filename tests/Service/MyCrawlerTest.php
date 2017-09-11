<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use MyApp\Service\MyCrawler;

/**
 * Description of MyCrawlerTest
 *
 * @author tomasz
 */
class MyCrawlerTest extends TestCase
{
    private $html;
    private $prop = 'td.tdAvailable.lowercase';
    private $testFolder = __DIR__ . '/../../data/tests/';

    public function __construct()
    {
        parent::__construct();
        $this->html = file_get_contents($this->testFolder . 'page.html');
    }

    public function testParsePreviousSiblingWithWebsite()
    {
        $crawler = new MyCrawler(new Crawler);
        $parsedData = $crawler->parsePreviousSibling($this->html, $this->prop);
        $this->assertArrayHasKey('title', $parsedData[0]);
        $this->assertArrayHasKey('value', $parsedData[0]);
    }
    
    public function testParsePreviousSiblingNoWebsite()
    {
        
    }
}
