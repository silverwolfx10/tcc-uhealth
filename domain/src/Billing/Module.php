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
            $di = Phalcon\DI::getDefault();
        }
        $di->setShared('UserDomainV2\Services\UserPersistService', function() use ($di){
            
            $repository = new UserRepository();
            $gearmanConfig[] = $di->get('gearmanMumm-ra');
            $gearmanClient = GearmanClient::connect($gearmanConfig);

            return new UserPersistService($repository, $gearmanClient);
        });

        $di->setShared('UserDomainV2\Services\BehaviorPersistService', function() {
            
            $behaviorRepository = new Repositories\BehaviorRepository();
            $entity = $di->get('UserDomain\Services\Behavior');
            return new BehaviorPersistService($behaviorRepository, $entity);
        });

        $di->set('teste', function($var){
            return $var . time();
        });

        $di->setShared('testeS', function($var){
            return $var . time();
        });

        $di->setShared('teste2', function(){
            return time();
        });
    }
 
}
