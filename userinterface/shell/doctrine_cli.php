<?php

 use Phalcon\DI\FactoryDefault\CLI as CliDI,
     Phalcon\CLI\Console as ConsoleApp,
     Phalcon\DI;

//Using the CLI factory default services container
$di = DI::setDefault(new CliDI());

require __DIR__ . '/../../autoloader.php';

$helperSet = \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($di->get('entityManager'));

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet, []);