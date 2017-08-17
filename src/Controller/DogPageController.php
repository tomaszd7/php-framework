<?php

namespace MyApp\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
// use Twig_Environment;
use Weekend\Service\ConfigService;
use \Twig_Environment;
use Weekend\Service\TemplateService;

class DogPageController
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
            $content = $this->theme->render('dog.html', $menu[$page]);
            return new Response($content);
        }
        return Response::create("not found", 404);
    }
}

 ?>
