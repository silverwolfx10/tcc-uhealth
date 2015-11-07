<?php

namespace Domain\Ad;

use Domain\Ad\Service\AvailablePersist;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = null)
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces([
            __NAMESPACE__ => __DIR__ . DS . 'src' . DS . 'Ad',
        ]);
        $loader->register();
    }

    public function registerServices(\Phalcon\DiInterface $di)
    {
        if(is_null($di)){
            $di = \Phalcon\DI::getDefault();
        }

        $di->setShared('Domain\Ad\Service\AdPersist', function() use ($di){

            return new \Domain\Ad\Service\AdPersist($di->get('entityManager'));
        });

        $di->setShared('Domain\Ad\Service\AvailablePersist', function() use ($di){

            return new \Domain\Ad\Service\AvailablePersist($di->get('entityManager'));
        });

        $di->setShared('Domain\Ad\Service\AddressPersist', function() use ($di){

            return new \Domain\Ad\Service\AddressPersist($di->get('entityManager'));
        });

    }
 
}
