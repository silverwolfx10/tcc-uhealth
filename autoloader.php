<?php
use \Phalcon\DI;
if(!defined('DS')){ 
	define('DS', DIRECTORY_SEPARATOR);
}
$di = is_null(DI::getDefault()) ? new DI() : DI::getDefault();

$config = require __DIR__ . DS . 'config' . DS . 'app.config.php';

$di->set('App\Config', function () use ($config) {
    return $config;
});

$modulesConfig = [];

//percorre estrutura base 
foreach($config['structure'] as $structure){
    $structureConfig =  require file_exists(__DIR__ . DS . $structure . DS . 'config/local.config.php') ? __DIR__ . DS . $structure . DS . 'config/local.config.php' : __DIR__ . DS . $structure . DS . 'config/global.config.php';

    if(file_exists(__DIR__ . DS . $structure . DS . 'vendor/autoload.php')) {
        include __DIR__ . DS . $structure . DS . 'vendor/autoload.php';
    }

    //disponbiliza as configs de cada estrutura
    $di->set(ucfirst($structure).'\Config', function () use ($structureConfig) {
        return $structureConfig;
    });

    //inicializa os modulos
    foreach($structureConfig['namespace'] as $namespace => $path){
        require  $path .'/Module.php';

        $class = $namespace . '\Module';
        $module = new $class();
        
        $module->registerAutoloaders();
        $module->registerServices($di);

    }
}