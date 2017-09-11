<?php

namespace Turtle\Service;

use League\Flysystem\FilesystemInterface;
use Symfony\Component\Yaml\Yaml;

class YamlService
{

    protected $yaml;

    public function __construct(FilesystemInterface $fs)
    {
        $this->yaml = Yaml::parse($fs->read('parseData.yml'));
    }

    public function getYamlData()
    {
        return $this->yaml;
    }

}

?>
