<?php

namespace Multiple\Api;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql;

class Module
{

	public function registerAutoloaders()
	{

		$loader = new Loader();

		$loader->registerNamespaces(array(
			'Multiple\Api\Controllers' => '../apps/api/controllers/',
			'Multiple\Api\Models' => '../apps/api/models/',
		));

		$loader->register();
	}

    public function registerRoutes($di){

        $router = $di->get('router');

        $router->add('/api', array(
            'module' => 'api',
            'controller' => 'index',
            'action' => 'index',
        ));

        $router->add('/api/authorization', array(
            'module' => 'api',
            'controller' => 'authorization',
            'action' => 'index',
        ));

        $router->add('/api/authorization/:action', array(
            'module' => 'api',
            'controller' => 'authorization',
            'action' => 1,
        ));

        $router->add('/api/register', array(
            'module' => 'api',
            'controller' => 'register'
        ));

        $router->add('/api/:controller', array(
            'module' => 'api',
            'controller' => 1
        ));

        $router->add('/api/ad/myuri/:myuri', array(
            'module' => 'api',
            'controller' => 'ad',
            'action' => 'myuri',
            'myuri' => 1
        ));

        $router->add('/api/:controller/:action', array(
            'module' => 'api',
            'controller' => 1,
            'action' => 2
        ));

        $router->add('/api/:controller/:action/:params', array(
            'module' => 'api',
            'controller' => 1,
            'action' => 2,
            'params' => 3
        ));

        $router->add('/api/:controller', array(
            'module' => 'api',
            'controller' => 1,
            'action' => 'index'
        ));

        $router->add('/api/address/address/:address', array(
            'module' => 'api',
            'controller' => 'address',
            'action' => 'address',
            'address' => 1
        ));

        $router->add('/api/address/location/:lat/:lng/:distance', array(
            'module' => 'api',
            'controller' => 'address',
            'action' => 'location',
            'lat' => 1,
            'lng' => 2,
            'distance' => 3,

        ));

    }
	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	public function registerServices($di)
	{

		//Registering a dispatcher
		$di->set('dispatcher', function () {
			$dispatcher = new Dispatcher();

			//Attach a event listener to the dispatcher
			$eventManager = new \Phalcon\Events\Manager();
//			$eventManager->attach('dispatch', new \Acl('frontend'));

			$dispatcher->setEventsManager($eventManager);
			$dispatcher->setDefaultNamespace("Multiple\Api\Controllers\\");
			return $dispatcher;
		});

		//Registering the view component
		$di->set('view', function () {
			$view = new \Phalcon\Mvc\View();
			$view->setViewsDir('../apps/api/views/');
			return $view;
		});

		$di->set('db', function () {
			return new Database(array(
				"host" => "localhost",
				"username" => "root",
				"password" => "secret",
				"dbname" => "invo"
			));
		});

        $router = $di->get('router');

	}
}
