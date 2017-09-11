<?php

use PHPUnit\Framework\TestCase;
use Curl\Curl;
use MyApp\Service\MyCurl;
/**
 * Description of MyCurlTest
 *
 * @author tomasz
 */
class MyCurlTest extends TestCase
{    
    public function testValidWebsite()
    {
        $url = 'http://www.google.com';
        $curl = new MyCurl(new Curl);
        $this->assertNotEmpty($curl->getUrl($url));        
    }
    
    public function testInValidWebsite()
    {
        $this->expectException(\Exception::class);
                
        $curl = new MyCurl(new Curl);
        $curl->getUrl('wrong url');        
    }
    
}
