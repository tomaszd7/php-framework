<?php

namespace MyApp\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
// use Twig_Environment;
use Weekend\Service\ConfigService;
use Weekend\Service\TemplateService;
use Curl\Curl;
use Symfony\Component\DomCrawler\Crawler;

class SummitController
{
    protected $config;
    protected $theme;
    protected $curl;
    protected $crawler;
    
    protected $dependencies = ['curl', 'crawler'];

    public function assignDependencies($container)
    {
        foreach ($this->dependencies as $dependency) {
            $this->$dependency = $container->get($dependency);
        }        
    }

    public function __construct(TemplateService $theme, ConfigService $config)
    {
        $this->theme = $theme;
        $this->config = $config;
    }

    public function get(Request $request)
    {
        $path = $request->getPathInfo();
        $page = ($path == '/') ? 'index' : substr($path, 1);
        $menu = $this->config->getConfig();
        if (isset($menu[$page]))
        {
            $website = $this->askWebsite();
            $data = $this->parseWebsite($website);
            
            $menu[$page]['curl'] = $data;
            $content = $this->theme->render('summit.html', $menu[$page]);
            return new Response($content);
        }
        return Response::create("not found", 404);
    }
    
    protected function askWebsite() 
    {              
        $this->curl->get('https://phpers-summit-2017.evenea.pl/');
        $response = ($this->curl->error) ? $this->curl->error_message : $this->curl->response;
        return $response;        
    }
        
    protected function parseWebsite($htmlString)
    {        
        $this->crawler->addContent($htmlString);
        $elements = $this->crawler->filter('td.tdAvailable.lowercase')
                ->each(function ($node, $i) {
                    $title = substr(trim($node->previousAll()->text()), 0, 40);
                    $status = trim($node->text());
                    return [$title, $status];
                });                   
        $response = [];
        foreach ($elements as $pair)
        {
            $response[$pair[0]] = $pair[1];
        }                        
        return $response;
    }
    
    public function apiAccess()
    {        
        $website = $this->askWebsite();
        $data = $this->parseWebsite($website);
//        $time = new \DateTime();
//        $time->format('Y-m-d H:i:s');
        $time = date('Y-m-d H:i:s');
        return [
            'time' => $time,
            'data' => $data
            ];
    }
    
    public function setCurl(Curl $curl)
    {
        $this->curl = $curl;
    }

    public function setCrawler(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }
}

 ?>
