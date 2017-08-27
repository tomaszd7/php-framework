<?php

namespace Turtle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Turtle\Controller\TurtleController;

class BasicPageController extends TurtleController
{

    public function indexAction()
    {

        $content = $this->theme->render('basic.html', $this->layout);
        return new Response($content);
    }

}

?>
