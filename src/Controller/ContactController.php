<?php

namespace MyApp\Controller;

// use Twig_Environment;
// use Twig_Loader_Filesystem;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;
use Weekend\Service\TemplateService;

class ContactController
{
    protected $theme;

    public function __construct(TemplateService $theme)
    {
        $this->theme = $theme;
    }

    public function get()
    {
        // $form = $this->twig->render('forms/contact.html');
        $content = $this->theme->render('contact.html', [
            'title' => 'Contact'
        ]);
        return new Response($content);
    }

    public function post(Request $request)
    {
        // TODO validate input and send mail
        $content = $this->theme->render('basic.html', [
            'title' => 'Contect',
            'content' => 'Thank you for your message'
        ]);
        return new Response($content);
    }
}
 ?>
