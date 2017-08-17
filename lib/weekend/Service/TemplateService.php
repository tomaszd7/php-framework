<?php

namespace Weekend\Service;

use Twig_Environment;
use Weekend\Service\ConfigService;

/**
 *
 */
class TemplateService
{
    protected $twig;
    protected $menu;

    function __construct(Twig_Environment $twig, ConfigService $config)
    {
        $this->twig = $twig;
        $this->menu = $config->getConfig();
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
