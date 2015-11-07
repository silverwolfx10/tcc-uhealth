<?php

namespace Domain\QuestionAndAnswer;

use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = null)
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces([
            __NAMESPACE__ => __DIR__ . DS . 'src' . DS . 'QuestionAndAnswer',
        ]);
        $loader->register();
    }

    public function registerServices(\Phalcon\DiInterface $di)
    {       

    }
 
}
