<?php
namespace My\Factory;

use My\Controller\EgController;
use Zend\Cache\PatternFactory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EgControllerFactory implements FactoryInterface
{
    /**
     * Create a proxy for EgController
     *
     * @todo use the $sl in order to set up the caching system
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $objectCache = PatternFactory::factory('object', array(
            'object'  => new EgController(),
            'storage' => 'apc',
            "class_cache_methods" => array(
                "getData"
            )
        ));
        return $objectCache;
    }
}
