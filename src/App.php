<?php

namespace Weekend;

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
// use Weekend\Controller\BasicPageController;
// use Weekend\Controller\ContactController;
// use League\Flysystem\Adapter\Local;
// use League\Flysystem\Filesystem;
// use Twig_Environment;
// use Twig_Loader_Filesystem;
use Symfony\Component\DependencyInjection\ContainerBuilder;
    use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class App {
    protected $twig;
    protected $filesystem;

    protected $container;

    public function __construct()
    {
        $this->container = new ContainerBuilder();
        $loader = new YamlFileLoader($this->container,
            new FileLocator(__DIR__. '/../'));
        $loader->load('services.yml');

        // $adapter = new Local(__DIR__ . '/../data');
        // $this->filesystem = new Filesystem($adapter);
        //
        // $loader = new Twig_Loader_Filesystem(__DIR__.'/../templates');
        // $this->twig = new Twig_Environment($loader);
    }

    private function getMenuConfig()
    {
        return json_decode($this->filesystem->read('menu.json'),  true);
    }

    public function run(Request $request)
    {
        $path = $request->getPathInfo();
        $method = strtolower($request->getMethod());
        $routes = [
            '/' => 'basic_page_controller',
            '/index' => 'basic_page_controller',
            '/about' => 'basic_page_controller',
            '/contact' => 'contact_controller',
            '/template' => 'template_controller',

        ];

        if (isset($routes[$path]))
        {
            $controller = $this->container->get($routes[$path]);
            if (is_callable([$controller, $method]))
            {
                return call_user_func_array([$controller, $method], [$request]);
            }
        }
        return Response::create("not found", 404);

        // $method = $request->getMethod();
        // switch ($path)
        // {
        //     case '/':
        //     case '/index':
        //     case '/about':
        //         $controller = $this->container->get('basic_page_controller');
        //         // $controller = new BasicPageController($this->twig, $menu);
        //         return $controller->get($path);
        //     case '/contact':
        //         $controller = $this->container->get('contact_controller');
        //         // $twig = $this->container->get('twig');
        //         // $controller = new ContactController($this->twig);
        //         if ($method == 'POST')
        //         {
        //             return $controller->post($request);
        //         }
        //         return $controller->get();
        // }
        // return Response::create("not found", 404);
    }

}
 ?>
