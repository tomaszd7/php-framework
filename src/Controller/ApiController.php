<?php

namespace MyApp\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
// use Twig_Environment;
use Weekend\Service\ConfigService;
use Weekend\Service\TemplateService;

class ApiController
{

    protected $config;
    protected $theme;
    protected $summit_controller;
    protected $myPageParsing;
    protected $dependencies = [
        'myPageParsing'
    ];

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
        if (isset($menu[$page])) {

            $apiAnswer = $this->myPageParsing->getApiData();

            $response = new Response();
            $response->setContent(json_encode($apiAnswer));
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Myheader', 'true');
            return $response;
        }
        return JsonResponse::create("not found", 404);
    }

}

?>
