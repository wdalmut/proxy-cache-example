<?php
namespace My\Controller;

use UpCloo\App;
use Zend\Http\PhpEnvironment\Response;
use Zend\EventManager\Event;

class ErrorControllerTest extends \PHPUnit_Framework_TestCase
{
    private $object;

    public function setUp()
    {
        $this->object = new ErrorController();
    }

    /**
     * Test that the error page generate an error json package
     */
    public function testErrorPageSetTheBodyContent()
    {
        $app = new App(array());
        $event = new Event();
        $event->setTarget($app);

        $this->object->error($event);

        $response = $app->response();
        $this->assertJsonStringEqualsJsonString(
            json_encode(array("error" => "404")), $app->response()->getContent()
        );
    }
}
