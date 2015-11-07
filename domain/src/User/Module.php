<?php

namespace Domain\User;

use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = null)
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces([
            __NAMESPACE__ => __DIR__ . DS . 'src' . DS . 'User',
        ]);
        $loader->register();
    }

    public function registerServices(\Phalcon\DiInterface $di)
    {       
        if(is_null($di)){
            $di = \Phalcon\DI::getDefault();
        }
        $di->setShared('Domain\User\Service\UserPersist', function() use ($di){
            $generateMyUri = new \Domain\User\Service\GenerateMyUri($di->get('entityManager'));
            $cryptService = new \Infrastructure\Service\Crypt();

            return new \Domain\User\Service\UserPersist($di->get('entityManager'), $generateMyUri, $cryptService);
        });

        $di->setShared('Domain\User\Service\LoginPersist', function() use ($di){
            $cryptService = new \Infrastructure\Service\Crypt();

            return new \Domain\User\Service\LoginPersist($di->get('entityManager'), $cryptService);
        });

    }
 
}
