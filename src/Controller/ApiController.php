<?php

namespace MyApp\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Turtle\Controller\TurtleController;

class ApiController extends TurtleController
{

    protected $myPageParsing;
    protected $dependencies = [
        'myPageParsing'
    ];

    public function apiData()
    {
        $apiAnswer = $this->myPageParsing->getApiData();

        $response = new Response();
        $response->setContent(json_encode($apiAnswer));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Myheader', 'true');
        return $response;
    }

}

?>
