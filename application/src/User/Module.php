<?php

namespace Application\User;

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

        $userPersist = $di->get('Domain\User\Service\UserPersist');
        $em = $di->get('entityManager');
        $userRepository = $em->getRepository('\Domain\User\Entity\User');
        $loginRepository = $em->getRepository('\Domain\User\Entity\Login');
        $hydrator = new \Infrastructure\Service\Hydrator();
        $loginPersist = $di->get('Domain\User\Service\LoginPersist');

        $di->setShared('Application\User\Service\UserFacebook', function() use ($userPersist, $userRepository, $hydrator, $loginPersist){

            return new \Application\User\Service\UserFacebook($userPersist, $userRepository, $hydrator, $loginPersist);
        });

        $di->setShared('Application\User\Service\UserTwitter', function() use ($userPersist, $userRepository, $hydrator, $loginPersist){

            return new \Application\User\Service\UserTwitter($userPersist, $userRepository, $hydrator, $loginPersist);
        });

        $di->setShared('Application\User\Service\UserLinkedin', function() use ($userPersist, $userRepository, $hydrator, $loginPersist){

            return new \Application\User\Service\UserLinkedin($userPersist, $userRepository, $hydrator, $loginPersist);
        });

        $di->setShared('Application\User\Service\Register', function() use  ($userPersist, $userRepository, $hydrator, $loginPersist){

            return function ($type = 'insert') use ($userPersist, $userRepository, $hydrator, $loginPersist){

                $registerForm = new Form\Register($type);

                return new \Application\User\Service\Register($userPersist, $userRepository, $hydrator, $registerForm, $loginPersist);
            };
        });

        $di->setShared('Application\User\Service\Login', function() use  ($loginPersist, $loginRepository, $userRepository){
                $cryptService = new \Infrastructure\Service\Crypt();
                $loginForm = new \Application\User\Form\Login();
                return new \Application\User\Service\Login($loginPersist, $loginRepository, $loginForm, $userRepository, $cryptService);
        });

        $di->setShared('Application\User\Service\RegisterPersonal', function() use ($di, $userRepository, $userPersist, $hydrator){

                $adPersist = $di->get('Domain\Ad\Service\AdPersist');

                $registerPersonalForm = new Form\RegisterPersonal();

                return new \Application\User\Service\RegisterPersonal(
                    $userPersist,
                    $userRepository,
                    $hydrator,
                    $registerPersonalForm,
                    $adPersist
                );

        });

    }
 
}
