<?php

namespace Turtle\Service;

use League\Flysystem\FilesystemInterface;

class LayoutService
{

    protected $config;

    public function __construct(FilesystemInterface $fs)
    {
        $this->config = json_decode($fs->read('menu.json'), true);
    }

    public function getLayoutData()
    {
        return $this->config;
    }

}

?>
