<?php

namespace MyApp\Controller;

use Symfony\Component\HttpFoundation\Response;
use \Turtle\Controller\TurtleController;

class SummitController extends TurtleController
{

    protected $curl;
    protected $crawler;
    protected $myMailer;
    protected $myPageParsing;
    protected $dependencies = [
        'curl',
        'crawler',
        'myMailer',
        'myPageParsing'
    ];

    public function indexAction()
    {
        //        $this->myMailer->sendMail();
//        var_dump($this->myMailer->emailWasSent());

        $data = $this->myPageParsing->getData();

        $this->layout['curl'] = $data;

        $content = $this->theme->render('summit.html', $this->layout);
        return new Response($content);
    }

}

?>
