<?php

namespace MyApp\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
// use Twig_Environment;
use Weekend\Service\ConfigService;
use \Twig_Environment;
use Weekend\Service\TemplateService;
use Curl\Curl;

class SummitController
{
    protected $config;
    // protected $twig;
    protected $theme;

    // public function __construct(Twig_Environment $twig, ConfigService $config)
    // {
    //     $this->twig = $twig;
    //     $this->config = $config;
    // }

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
            $curlResponse = $this->getCurl();
            $data = json_encode($curlResponse);
            $menu[$page]['curl'] = $data;
            
            $content = $this->theme->render('summit.html', $menu[$page]);
            return new Response($content);
        }
        return Response::create("not found", 404);
    }
    
    protected function getCurl() 
    {
        
        $curl = new Curl();
//        $curl->set
        $curl->get('https://phpers-summit-2017.evenea.pl/');
        $response = ($curl->error) ? $curl->error_message : $curl->response;
        return $response;        
    }
}

 ?>
