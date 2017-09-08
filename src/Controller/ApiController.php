<?php

namespace MyApp\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Turtle\Controller\TurtleController;

class ApiController extends TurtleController
{

    protected $myPageParsing;
    protected $dependencies = [
        'myPageParsing',
        'myMailer'
    ];

    public function prepareLayoutData(Request $request)
    {
        return true;
    }

    public function dataAction()
    {
        $apiAnswer = $this->myPageParsing->getApiData();

        $response = new Response();
        $response->setContent(json_encode($apiAnswer));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Myheader', 'true');
        return $response;
    }

    public function mailAction()
    {
        $this->myMailer->sendMail();
        $answer = $this->myMailer->emailWasSent();
        $response = new JsonResponse();
        return $response->setData($answer);
    }

}

?>
