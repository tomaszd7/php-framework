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
    protected $routes;

    protected $psr7Request;
    protected $psr7Response;


    public function __construct()
    {
        $this->container = new ContainerBuilder();
        $loader = new YamlFileLoader($this->container,
            new FileLocator(__DIR__. '/../../'));
        $loader->load('services.yml');
        $loader->load('src/services.yml');
        // $adapter = new Local(__DIR__ . '/../data');
        // $this->filesystem = new Filesystem($adapter);
        //
        // $loader = new Twig_Loader_Filesystem(__DIR__.'/../templates');
        // $this->twig = new Twig_Environment($loader);

        // converting symfony request and reponse into psr7
        $this->initLeagueRoute();
    }

    private function initLeagueRoute()
    {
        $psr7Factory = $this->container->get('diactoros_factory');
        $symfonyRequest = Request::createFromGlobals();
        $this->psr7Request = $psr7Factory->createRequest($symfonyRequest);

        $symfonyResponse = new Response();
        $this->psr7Response = $psr7Factory->createResponse($symfonyResponse);
    }

    // public function addRoute($path, $method, $controller)
    // {
    //     $this->routes[$path][$method] = $controller;
    // }

    public function weekendRouting(Request $request)
    {
        $path = $request->getPathInfo();
        $method = strtolower($request->getMethod());

        // $routes = [
        //     '/' => 'basic_page_controller',
        //     '/index' => 'basic_page_controller',
        //     '/about' => 'basic_page_controller',
        //     '/contact' => 'contact_controller'
        // ];

        if (isset($this->routes[$path][$method]))
        {
            $controllerName = $this->routes[$path][$method];
            $controller = $this->container->get($controllerName);
            // if (is_callable([$controller, $method]))
            // {
            return call_user_func_array([$controller, $method], [$request]);
            // }
        }
        return Response::create("not found", 404);
    }

    public function leagueRouting()
    {
        $route = $this->container->get('route_collection');

        $route->map('GET', '/', [$this->container->get('basic_page_controller'), 'actionIndex']);
        $route->map('GET', '/index', [$this->container->get('basic_page_controller'), 'actionIndex']);
        $route->map('GET', '/about', [$this->container->get('basic_page_controller'), 'actionIndex']);

        // ten dispatch przechwytuje response po mapowaniu z funkcji map
        $response = $route->dispatch($this->psr7Request, $this->psr7Response);

        $this->container->get('diactoros_emiter')->emit($response);
        return true;
    }

}
 ?>
