<?php

namespace Application\Ad;

use Phalcon\Mvc\ModuleDefinitionInterface;
use \Domain\Ad\Service\AdPersist;

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

        $di->setShared('Application\Ad\Service\Ad', function() use($di) {
            $adPersist = $di->get('Domain\Ad\Service\AdPersist');
            $adRepository = $di->get('entityManager')->getRepository('Domain\Ad\Entity\Ad');
            $hydrator = new \Infrastructure\Service\Hydrator();


            return function ($type) use($adPersist, $adRepository, $hydrator, $di) {
                $adForm = new Form\Ad($type);
                $availableService = $di->get('Application\Ad\Service\Available');
                $addressService = $di->get('Application\Ad\Service\Address');
                return new \Application\Ad\Service\Ad($adPersist, $addressService('insert'), $availableService('insert'), $adRepository, $hydrator, $adForm);
            };
        });

        $di->setShared('Application\Ad\Service\Available', function() use($di) {
            $availablePersist = $di->get('Domain\Ad\Service\AvailablePersist');
            $availableRepository = $di->get('entityManager')->getRepository('Domain\Ad\Entity\Available');
            $hydrator = new \Infrastructure\Service\Hydrator();


            return function ($type) use($availablePersist, $availableRepository, $hydrator) {
                $availableForm = new Form\Available($type);
                return new \Application\Ad\Service\Available($availablePersist, $availableRepository, $hydrator, $availableForm);
            };
        });

        $di->setShared('Application\Ad\Service\Address', function() use($di) {
            $addressService = $di->get('Application\Address\Service\Address');
            $addressPersist = $di->get('Domain\Ad\Service\AddressPersist');
            $addressRepository = $di->get('entityManager')->getRepository('Domain\Ad\Entity\Address');
            $hydrator = new \Infrastructure\Service\Hydrator();
            $geographicService = $di->get('Application\Address\Service\GeographicCoordenates');

            return function ($type) use($addressPersist, $addressRepository, $hydrator, $addressService, $geographicService) {
                $addressForm = new Form\Address($type);
                return new \Application\Ad\Service\Address(
                    $addressPersist,
                    $addressRepository,
                    $hydrator,
                    $addressForm,
                    $addressService,
                    $geographicService

                );
            };
        });
    }
 
}
