<?php
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Debug\Debug;

require __DIR__ . '/../vendor/autoload.php';
Debug::enable();

// Weekend app and custom routing impementation
// $request = Request::createFromGlobals();
// $app = new \Weekend\App();
// $response = $app->weekendRouting($request);
// $response->send();

// League Route implementation
$app = new \Weekend\App();
$app->leagueRouting();


 ?>
