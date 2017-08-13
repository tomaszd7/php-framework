<?php
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Debug\Debug;

require __DIR__ . '/../vendor/autoload.php';
Debug::enable();
$request = Request::createFromGlobals();
$app = new \Weekend\App();
$response = $app->run($request);
$response->send();

 ?>
