<?php

namespace MyApp;


class MyApp extends \Weekend\App {

    public function __construct()
    {       
        parent::__construct();

        $this->loader->load('src/myapp_services.yml');
    }
}
 ?>