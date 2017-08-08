<?php

namespace Weekend\Controller;

use Twig_Environment;
use Twig_Loader_Filesystem;
use \Symfony\Component\HttpFoundation\Response;
// use \Symfony\Component\HttpFoundation\Request;

class ContactController
{
    protected $twig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__.'/../../templates');
        $this->twig = new Twig_Environment($loader);
    }

    public function get()
    {
        $form = $this->twig->render('forms/contact.html');
        $content = $this->twig->render('index.html', [
            'title' => 'Contact',
            'content' => $form,
        ]);
        return new Response($content);
    }

    public function post(Request $request)
    {
        // TODO validate input and send mail
        $content = $this->twig->render('index.html', [
            'title' => 'Contect',
            'content' => 'Thank you for your message'
        ]);
        return new Response($content);
    }
}
 ?>
