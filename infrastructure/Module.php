<?php

namespace Infrastructure;

use Phalcon\Mvc\ModuleDefinitionInterface;
use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;


class Module implements ModuleDefinitionInterface
{   

    public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = null)
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces([
            __NAMESPACE__ => __DIR__ . DS . 'src',
        ]);
        $loader->register();
    }

    public function registerServices(\Phalcon\DiInterface $di)
    {

        //registrando annotations
        $this->registerAnnotationsFiles([
            'Column',
            'Entity',
            'GeneratedValue',
            'HasLifecycleCallbacks',
            'Id',
            'PrePersist',
            'PreUpdate',
            'Table',
            'ManyToOne',
            'ManyToMany',
            'JoinTable',
            'JoinColumn'
        ]);


        //configurando entity manager 
        $di->setShared('entityManager', function () use ($di) {

            $infraConfig = $di->get('Infrastructure\Config');

//            $doctrine_config = Setup::createAnnotationMetadataConfiguration($infraConfig['ormMapper'], $di->get('App\Config')['devmode']);


            $config = Setup::createConfiguration($di->get('App\Config')['devmode']);
            $driver = new AnnotationDriver(new AnnotationReader(), $infraConfig['ormMapper']);

            // registering noop annotation autoloader - allow all annotations by default
            AnnotationRegistry::registerLoader('class_exists');
            $config->setMetadataDriverImpl($driver);


            $entityManager = EntityManager::create($infraConfig['databases'][0], $config);

            $platform = $entityManager->getConnection()->getDatabasePlatform();
            $platform->registerDoctrineTypeMapping('enum', 'string');

            return $entityManager;
        });

        $di->setShared('api', function () use ($di){
            $infraConfig = $di->get('Infrastructure\Config');

            return new Service\RESTClient($infraConfig['baseUrl']['api'], $infraConfig['credentials']);
        });

        $di->setShared('geocodeApi', function () use ($di){
            return new Service\RESTClient('https://maps.googleapis.com/maps/api/geocode/json?&key=AIzaSyBwFWzpssaahZ7SfLZt6mv7PeZBFXImpmo&address=');
        });
        
    }

    private function registerAnnotationsFiles(array $files){
        foreach($files as $key => $value){
//            AnnotationRegistry::registerFile(__DIR__ . '/src/Orm/' . $value .'.php');
        }
    }
}
