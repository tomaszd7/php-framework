<?php

namespace Turtle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Turtle\Service\LayoutService;
use Turtle\Service\TemplateService;

abstract class TurtleController
{
    protected $config;
    protected $theme;
    protected $request;
    protected $layout;
    protected $dependencies;

    public function __construct(TemplateService $theme, LayoutService $config)
    {
        $this->theme = $theme;
        $this->config = $config;
    }

    public function prepareLayoutData(Request $request)
    {
        $this->request = $request;
        $path = $this->request->getPathInfo();
        $page = ($path == '/') ? 'index' : substr($path, 1);
        $menu = $this->config->getLayoutData();

        if (isset($menu[$page])) {
            $this->layout = $menu[$page];
            return true;
        } else {
            return false;
        }
    }

    public function assignDependencies($container)
    {
        foreach ($this->dependencies as $dependency) {
            $this->$dependency = $container->get($dependency);
        }
    }

    public function areDependencies()
    {
        return (bool) count($this->dependencies);
    }

}

?>
