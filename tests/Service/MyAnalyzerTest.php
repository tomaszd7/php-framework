<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use MyApp\Service\MyAnalyzer;

/**
 * Description of MyPageAnalyzerTest
 *
 * @author tomasz
 */
class MyAnalyzerTest extends TestCase
{
    private $myProps;
    private $myFields;
    private $testFolder = __DIR__ . '/../../data/tests/';

    public function __construct()
    {
        parent::__construct();
        $this->myProps = Yaml::parse(file_get_contents($this->testFolder . 'testProps.yml'));
        $this->myFields = json_decode(file_get_contents($this->testFolder . 'fields.json'), true);
    }

    public function testAnalyzeTextExists()
    {
        $analyzer = new MyAnalyzer($this->myProps['events']['exists']);
        $this->assertTrue($analyzer->analyze($this->myFields['exists']));
        $this->assertFalse($analyzer->analyze($this->myFields['existsNot']));
    }

    public function testAnalyzeTextExistsNot()
    {
        $analyzer = new MyAnalyzer($this->myProps['events']['existsNot']);
        $this->assertTrue($analyzer->analyze($this->myFields['existsNot']));
        $this->assertFalse($analyzer->analyze($this->myFields['exists']));
    }

}
