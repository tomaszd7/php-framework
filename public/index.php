<?php
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Debug\Debug;

require __DIR__ . '/../vendor/autoload.php';
Debug::enable();
$request = Request::createFromGlobals();

$app = new MyApp\MyApp();

$app->addRoute('/dog', 'get', 'dog_page_controller');
$app->addRoute('/template', 'get', 'template_controller');

$response = $app->run($request);
$response->send();

 ?>
