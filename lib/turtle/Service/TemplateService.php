<?php

namespace Turtle\Service;

use Twig_Environment;
use Turtle\Service\LayoutService;

/**
 *
 */
class TemplateService
{
    protected $twig;
    protected $menu;

    function __construct(Twig_Environment $twig, LayoutService $config)
    {
        $this->twig = $twig;
        $this->menu = $config->getLayoutData();
    }

    public function render($templateName, $variables)
    {
//        bulding nav menu structure
        foreach ($this->menu as $path => $menuItem)
        {
            $variables['nav'][] = [
                'title' => $menuItem['title'],
                'url' => '/' . $path,
            ];
        }
        return $this->twig->render($templateName, $variables);
    }

}

 ?>
