<?php

namespace MyApp\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
// use Twig_Environment;
use Weekend\Service\ConfigService;
use Weekend\Service\TemplateService;
use Curl\Curl;
use Symfony\Component\DomCrawler\Crawler;

class SummitController
{

    protected $config;
    protected $summitPage;
    protected $theme;
    protected $curl;
    protected $crawler;
    protected $myMailer;
    protected $myPageParsing;
    protected $dependencies = [
        'curl',
        'crawler',
        'myMailer',
        'myPageParsing'
    ];

    public function assignDependencies($container)
    {
        foreach ($this->dependencies as $dependency) {
            $this->$dependency = $container->get($dependency);
        }
    }

    public function __construct(TemplateService $theme, ConfigService $config)
    {
        $this->theme = $theme;
        $this->config = $config;
    }

    public function get(Request $request)
    {
        $path = $request->getPathInfo();
        $page = ($path == '/') ? 'index' : substr($path, 1);
        $menu = $this->config->getConfig();
        $this->summitPage = $menu[$page];

        if (isset($this->summitPage)) {

            $this->process();

            $content = $this->theme->render('summit.html', $this->summitPage);
            return new Response($content);
        }
        return Response::create("not found", 404);
    }

    protected function process()
    {

//        $this->myMailer->sendMail();
//        var_dump($this->myMailer->emailWasSent());

        $data = $this->myPageParsing->getData();

        $this->summitPage['curl'] = $data;
    }

    public function setCurl(Curl $curl)
    {
        $this->curl = $curl;
    }

    public function setCrawler(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

}

?>
