<?php
/**
 * Este é o bootstrap para os testes podeia ser  chamado de bootstrap.php
 * @author Ariana Kataoka
 */
use Phalcon\DI,
    Phalcon\DI\FactoryDefault;
ini_set('display_errors',1);
error_reporting(E_ALL);
define('ROOT_PATH', __DIR__);

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);
// Verificar diretório correto
include __DIR__ . "/../../autoloader.php";
// $teste = get_declared_classes();
// asort($teste);
#print_r($teste);die;
// use the application autoloader to autoload the classes
// autoload the dependencies found in composer
// $loader = new \Phalcon\Loader();
// $loader->registerNamespaces(
//     array(
//         'BaseDomain'    => '../BaseDomain',
//         'CatalogDomain'    => '../CatalogDomain',
//         'GeographicDomain'    => '../GeographicDomain',
//         'UserDomain'    => '../UserDomain',
//         'OfferDomain'    => '../OfferDomain',
//         'LeadDomain'    => '../LeadDomain',
//         'SeoDomain'    => '../SeoDomain',
//         'AddressDomain'    => '../AddressDomain',
//         'Helpers'   => '../../helpers',
//         'Infra' => '../../infra',
//         'Michelf' => '../../userinterface/www/vendor/michelf/php-markdown/Michelf'
//    )
// );
// $loader->registerDirs(array(
//     ROOT_PATH
// ));
// $loader->register();
// $di = new FactoryDefault();
// DI::reset();
// // add any needed services to the DI here
// DI::setDefault($di);