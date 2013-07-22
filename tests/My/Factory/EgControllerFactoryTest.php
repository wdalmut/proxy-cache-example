<?php
namespace My\Factory;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config;

class EgControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testObjectGeneration()
    {
        $conf = new Config(array(
            "services" => array(
                "factories" => array(
                    "My\\Factory\\EgControllerFactory" => "My\\Factory\\EgControllerFactory"
                ),
                "aliases" => array(
                    "exampleController" => "My\\Factory\\EgControllerFactory"
                )
            )
        ));
        $sl = new ServiceManager($conf);
        $object = EgControllerFactory::createService($sl);
        $this->assertInstanceOf("Zend\Cache\Pattern\ObjectCache", $object);
        $options = $object->getOptions();
        $this->assertInstanceOf("My\\Controller\\EgController", $options->getObject());
    }
}
