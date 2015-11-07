<?php

 use Phalcon\DI\FactoryDefault\CLI as CliDI,
     Phalcon\CLI\Console as ConsoleApp,
     Phalcon\DI;

//Using the CLI factory default services container
$di = DI::setDefault(new CliDI());

require __DIR__ . '/../../autoloader.php';

 /**
  * Register the autoloader and tell it to register the tasks directory
  */
 $loader = new \Phalcon\Loader();

 $dirs = [];
 $dirs[] = __DIR__ . '/tasks';

 //registra diretorios que serao lidos
 $loader->registerDirs(
     $dirs
 )->register();

 //Create a console application
 $console = new ConsoleApp();
 $console->setDI($di);

$di->setShared('console', $console);

$di->setShared('consoleDispatcher', function () use ($di){

    $dispatcher = new \Phalcon\CLI\Dispatcher();
    $dispatcher->setDI($di);

    return $dispatcher;
});

 /**
 * Process the console arguments
 */
 $arguments = array();
 foreach($argv as $k => $arg) {
     if($k == 1) {
         $arguments['task'] = $arg;
     } elseif($k == 2) {
         $arguments['action'] = $arg;
     } elseif($k >= 3) {
        $arguments['params'][] = $arg;
     }
 }

 try {
     // handle incoming arguments
     $console->handle($arguments);
 }
 catch (\Phalcon\Exception $e) {
     echo $e->getMessage();
     exit(255);
 }
