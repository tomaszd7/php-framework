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
        $props = $this->yaml->getYamlData()['events']['reactJs'];
        $this->myPageParsing->setProps($props);
        $data = $this->myPageParsing->getData();

        $this->layout['curl'] = $data;


        if ($data['sendEmail'] === 'true') {
//            $this->myMailer->sendMail('reactJs', $data);
            $this->layout['mails_sent'] = 1;
        }

        $content = $this->theme->render('summit.html', $this->layout);
        return new Response($content);
    }

}

?>
