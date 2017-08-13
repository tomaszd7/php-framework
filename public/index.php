<?php
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Debug\Debug;

require __DIR__ . '/../vendor/autoload.php';
Debug::enable();
$request = Request::createFromGlobals();

$app = new \Weekend\App();
$app->addRoute('/', 'get', 'basic_page_controller');
$app->addRoute('/index', 'get', 'basic_page_controller');
$app->addRoute('/about', 'get', 'basic_page_controller');

$response = $app->run($request);
$response->send();

 ?>
