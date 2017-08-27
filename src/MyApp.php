<?php

namespace MyApp;

use Turtle\TurtleApp;

class MyApp extends TurtleApp
{
    public function __construct()
    {
        parent::__construct();

        $this->loader->load('src/hide_myapp_mailer.yml');
        $this->loader->load('src/myapp_services.yml');
    }

}

?>
