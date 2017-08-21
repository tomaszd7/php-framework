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
    // protected $twig;
    // protected $filesystem;

    protected $container;
    protected $loader;
    protected $routes;

    public function __construct()
    {
        $this->container = new ContainerBuilder();
        $this->loader = new YamlFileLoader($this->container,
            new FileLocator(__DIR__. '/../../'));
        $this->loader->load('services.yml');

        $this->addRoute('/', 'get', 'basic_page_controller');
        $this->addRoute('/index', 'get', 'basic_page_controller');
    }

    public function addRoute($path, $method, $controller)
    {
        $this->routes[$path][$method] = $controller;
    }

    public function run(Request $request)
    {
        $path = $request->getPathInfo();
        $method = strtolower($request->getMethod());

        if (isset($this->routes[$path][$method]))
        {
            $controllerName = $this->routes[$path][$method];
            $controller = $this->container->get($controllerName);
            // if (is_callable([$controller, $method]))
            // {
            
            // uruchamianie controlera
            // najpierw constructor
            // poziej dodac dependency 
            // pozniej metoda z requestu
            if (method_exists($controller, 'assignDependencies')) 
            {
                $controller->assignDependencies($this->container);
            }
            
            return call_user_func_array([$controller, $method], [$request]);
            // }
        }
        return Response::create("not found", 404);

    }

}
 ?>
