<?php
session_start();
error_reporting(E_ALL);

use Phalcon\Loader;
use Phalcon\Mvc\Router;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application as BaseApplication;

class Application extends BaseApplication
{

    private $modules = array(
        'frontend' => array(
            'className' => 'Multiple\Frontend\Module',
            'path' => '../apps/frontend/Module.php'
        ),
        'backend' => array(
            'className' => 'Multiple\Backend\Module',
            'path' => '../apps/backend/Module.php'
        ),
        'api' => array(
            'className' => 'Multiple\Api\Module',
            'path' => '../apps/api/Module.php'
        )
    );
	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	protected function registerServices()
	{

		$di = new FactoryDefault();

        require '../../../autoloader.php';


		$loader = new Loader();

		/**
		 * We're a registering a set of directories taken from the configuration file
		 */
		$loader->registerDirs(
			array(
				__DIR__ . '/../apps/library/'
			)
		)->register();

        $router = new Router();
        $router->setDefaultModule("frontend");

		//Registering a router
		$di->set('router', function() use ($router){

			return $router;

		});

       $this->setDI($di);
	}

	public function main()
	{

		$this->registerServices();

		//Register the installed modules
		$this->registerModules($this->modules);

        $this->routers($this->getDI());

        echo $this->handle()->getContent();
	}

    //cada modulo resolve suas rotas
    public function routers($di){
        foreach($this->modules as $v){
            require $v['path'];
            $module = new $v['className']();
            $module->registerRoutes($di);
        }
    }

}

$application = new Application();
$application->main();
