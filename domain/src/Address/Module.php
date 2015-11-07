<?php

namespace Domain\Address;

use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = null)
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces([
            __NAMESPACE__ => __DIR__ . DS . 'src' . DS . 'Address',
        ]);
        $loader->register();
    }

    public function registerServices(\Phalcon\DiInterface $di)
    {
        if(is_null($di)){
            $di = \Phalcon\DI::getDefault();
        }

        $di->setShared('Domain\Address\Service\StreetPersist', function() use ($di){

            return new \Domain\Address\Service\StreetPersist($di->get('entityManager'));
        });

        $di->setShared('Domain\Address\Service\StatePersist', function() use ($di){

            return new \Domain\Address\Service\StatePersist($di->get('entityManager'));
        });

        $di->setShared('Domain\Address\Service\CityPersist', function() use ($di){

            return new \Domain\Address\Service\CityPersist($di->get('entityManager'));
        });

        $di->setShared('Domain\Address\Service\HoodPersist', function() use ($di){

            return new \Domain\Address\Service\HoodPersist($di->get('entityManager'));
        });

        $di->setShared('Domain\Address\Service\StreetNumberPersist', function() use ($di){

            return new \Domain\Address\Service\StreetNumberPersist($di->get('entityManager'));
        });

    }
 
}
