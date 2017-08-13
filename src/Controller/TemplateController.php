<?php

namespace Weekend\Controller;

// use Twig_Environment;
// use Twig_Loader_Filesystem;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;
use Weekend\Service\TemplateService;

class TemplateController
{
    protected $theme;

    public function __construct(TemplateService $theme)
    {
        $this->theme = $theme;
    }

    public function get()
    {
        // $form = $this->twig->render('forms/contact.html');
        $content = $this->theme->render('template.html', [
            'title' => 'Template'
        ]);
        return new Response($content);
    }

}
 ?>
