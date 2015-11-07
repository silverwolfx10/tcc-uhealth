<?php

namespace Application\Address;

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

        $em = $di->get('entityManager');

        $di->setShared('Application\Address\Service\Address', function() use($em) {

            $streetRepository = $em->getRepository('Domain\Address\Entity\Street');
            $hoodRepository = $em->getRepository('Domain\Address\Entity\Hood');
            $cityRepository = $em->getRepository('Domain\Address\Entity\City');

            return new \Application\Address\Service\Address($streetRepository, $hoodRepository, $cityRepository);

        });

        $di->setShared('Application\Address\Service\GeographicCoordenates', function() use($em, $di) {

            $streetRepository = $em->getRepository('Domain\Address\Entity\Street');
            $streetNumberRepository = $em->getRepository('Domain\Address\Entity\StreetNumber');
            $stateRepository = $em->getRepository('Domain\Address\Entity\State');
            $cityRepository = $em->getRepository('Domain\Address\Entity\City');
            $hoodRepository = $em->getRepository('Domain\Address\Entity\Hood');

            $streetPersist = $di->get('Domain\Address\Service\StreetPersist');
            $statePersist = $di->get('Domain\Address\Service\StatePersist');
            $cityPersist = $di->get('Domain\Address\Service\CityPersist');
            $hoodPersist = $di->get('Domain\Address\Service\HoodPersist');
            $streetNumberPersist = $di->get('Domain\Address\Service\StreetNumberPersist');

            $addressService = $di->get('Application\Address\Service\Address');
            $geocodeApi = $di->get('geocodeApi');

            return new \Application\Address\Service\GeographicCoordenates(
                $streetNumberRepository,
                $streetRepository,
                $stateRepository,
                $cityRepository,
                $hoodRepository,
                $streetPersist,
                $statePersist,
                $cityPersist,
                $hoodPersist,
                $streetNumberPersist,
                $addressService,
                $geocodeApi
            );

        });




    }
 
}
