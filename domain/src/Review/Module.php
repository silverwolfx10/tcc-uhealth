<?php

namespace Domain\Review;

use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = null)
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces([
            __NAMESPACE__ => __DIR__ . DS . 'src' . DS . 'Review',
        ]);
        $loader->register();
    }

    public function registerServices(\Phalcon\DiInterface $di)
    {       

    }
 
}
