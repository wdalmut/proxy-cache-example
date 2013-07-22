<?php
namespace My\Controller;

class EgControllerTest extends \PHPUnit_Framework_TestCase
{
    private $object;

    public function setUp()
    {
        $this->object = new EgController();
    }

    public function testTheMethod()
    {
        $this->assertEquals(array("hello" => "world"), $this->object->getData());
    }
}
