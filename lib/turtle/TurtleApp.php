<?php

namespace Turtle;

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader as DiYamlLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader as RouteYamlLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class TurtleApp
{
    protected $container;
    protected $loader;
    protected $routes;

    public function __construct()
    {
        $this->container = new ContainerBuilder();
        $fileLocator = new FileLocator(__DIR__ . '/../../');

        // load services
        $this->loader = new DiYamlLoader($this->container, $fileLocator);
        $this->loader->load('services.yml');

        // load routings
        $routeLoader = new RouteYamlLoader($fileLocator);
        $this->routes = $routeLoader->load('routing.yml');
    }

    public function run(Request $request)
    {

        $routing = $this->resolveRouting($request);
        if ($routing) {
            $response = $this->resolveController($routing, $request);
        } else {
            $response = Response::create("Routing not found", 404);
        }
        return $response;
    }

    protected function resolveRouting($request)
    {
        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($this->routes, $context);
        $exceptionFlag = true;

        try {
            $matcher = $matcher->matchRequest($request);
            $exceptionFlag = false;
        } catch (Exception $e) {
            
        } finally {
            if ($exceptionFlag) {
                return false;
            }
        }
        return $matcher['_controller'];
    }

    protected function resolveController($routing, $request)
    {
        $controllerArray = explode('::', $routing);

        $controller = $this->container->get($controllerArray[0]);

        if (!$controller->prepareLayoutData($request)) {
            return Response::create("Layout data not found", 404);
        }

        if ($controller->areDependencies()) {
            $controller->assignDependencies($this->container);
        }

        $method = $controllerArray[1];

        return call_user_func_array([$controller, $method], []);
    }

}

?>
