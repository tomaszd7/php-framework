<?php

// ob_start();
// include 'public/index.php';
//
// $output = ob_get_clean();
// echo strpos($output, 'Hello World'), PHP_EOL;


use Weekend\Controller\BasicPageController;

require_once('vendor/autoload.php');
$templates = ['index.html' => '{{ title }}'];

$twig = new Twig_Environment(new Twig_Loader_Array($templates));

$menu = ['test' => [
    'title' => 'Hello World',
    'content' => 'Test content'
    ]];

$controller = new BasicPageController($twig, $menu);

$output = $controller->get('/test');
if (strpos($output, "Hello World"))
{
    echo 'Test passed' , PHP_EOL;
}

 ?>
