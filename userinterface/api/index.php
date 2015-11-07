<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);

use Phalcon\Config\Adapter\Ini as IniConfig;
use Phalcon\DI\FactoryDefault as DefaultDI;
use Phalcon\Loader;
use Phalcon\Mvc\Micro\Collection;

/**
 * By default, namespaces are assumed to be the same as the path.
 * This function allows us to assign namespaces to alternative folders.
 * It also puts the classes into the PSR-0 autoLoader.
 */
$loader = new Loader();
$loader->registerNamespaces(array(
    'Api\Controllers' => __DIR__ . '/controllers/',
    'Api\Services' => __DIR__ . '/services/',
    'Api\Exceptions'  => __DIR__ . '/exceptions/',
    'Api\Responses'   => __DIR__ . '/responses/',
))->register();

/**
 * The DI is our direct injector.  It will store pointers to all of our services
 * and we will insert it into all of our controllers.
 * @var DefaultDI
 */
$di = new DefaultDI();
require __DIR__.'/../../autoloader.php';
require __DIR__.'/vendor/autoload.php';
/**
 * Return array of the Collections, which define a group of routes, from
 * routes/collections.  These will be mounted into the app itself later.
 */
$di->set('collections', function() {
    return include('./routes/routeLoader.php');
});


//$di->set('modelsCache', function() {
//
//    //Cache data for one day by default
//    $frontCache = new \Phalcon\Cache\Frontend\Data(array(
//        'lifetime' => 3600
//    ));
//
//    //File cache settings
//    $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, array(
//        'host' => '127.0.0.1',
//        'port' => 11211,
//        'persistent' => false
//    ));
//    return $cache;
//});


/**
 * If our request contains a body, it has to be valid JSON.  This parses the
 * body into a standard Object and makes that vailable from the DI.  If this service
 * is called from a function, and the request body is nto valid JSON or is empty,
 * the program will throw an Exception.
 */
$di->setShared('requestData', function() {

    $in = file_get_contents('php://input');
    $json = json_decode($in, true);

   // se nao foi enviado um json retorna o que foi enviado
    if($json === null){
       parse_str($in,$post_vars);
       return $post_vars;
    }

    return $json;
});

/**
 * Out application is a Micro application, so we mush explicitly define all the routes.
 * For APIs, this is ideal.  This is as opposed to the more robust MVC Application
 * @var $app
 */
$app = new Phalcon\Mvc\Micro();
$app->setDI($di);

/**
 * Before every request, make sure user is authenticated.
 * Returning true in this function resumes normal routing.
 * Returning false stops any route from executing.
 */


$app->before(function() use ($app, $di) {


    $matchedRoute = $app->getRouter()->getMatchedRoute()->getName();

    // All options requests get a 200, then die
    if($app->__get('request')->getMethod() == 'OPTIONS'){
        $app->response->setStatusCode(200, 'OK')->sendHeaders();
        exit;
    }

    if(preg_match("/-allow/", $matchedRoute)){
        return true;
    }

    //    @todo adicionar uma tabela com chaves de acesso basico

    if($app->request->getHeader('BasicAuthorization') === 'uHealth1235486tcc') {
        //validar acesso a recursos basicos
        if (preg_match("/-authbasic/", $matchedRoute)) {
            return true;
        }

        if(strlen($app->request->getHeader('Token'))){
            if($app->getDi()->get('entityManager')->getRepository('Domain\User\Entity\Login')->findOneBy(['token'=>$app->request->getHeader('Token'), 'status' => 'active'])){
                return true;
            }

        }

    }

    $app->response->setStatusCode(401, 'OK')->sendHeaders();

    $app->response = new \Api\Responses\JSONResponse();
    $app->response->useEnvelope(true) //this is default behavior
    ->convertSnakeCase(false) //this is also default behavior
    ->send(
        [
            'messages'=> ['Você não tem permissão para acessar esse recurso']
        ]
    );

    return false;

});


/**
 * Mount all of the collections, which makes the routes active.
 */
foreach($di->get('collections') as $collection){
    $app->mount($collection);
}


/**
 * The base route return the list of defined routes for the application.
 * This is not strictly REST compliant, but it helps to base API documentation off of.
 * By calling this, you can quickly see a list of all routes and their methods.
 */
/*
Indice*/
$app->get('/', function() use ($app){
    $routes = $app->getRouter()->getRoutes();
    $routeDefinitions = array('GET'=>[], 'POST'=>[], 'PUT'=>[], 'PATCH'=>[], 'DELETE'=>[], 'HEAD'=>[], 'OPTIONS'=>[]);
    foreach($routes as $route){
        $method = $route->getHttpMethods();
        $routeDefinitions[$method][] = $route->getPattern();
    }
    return $routeDefinitions;
});

/**
 * After a route is run, usually when its Controller returns a final value,
 * the application runs the following function which actually sends the response to the client.
 *
 * The default behavior is to send the Controller's returned value to the client as JSON.
 * However, by parsing the request querystring's 'type' paramter, it is easy to install
 * different response type handlers.  Below is an alternate csv handler.
 */
$app->after(function() use ($app) {

    // OPTIONS have no body, send the headers, exit
    if($app->request->getMethod() == 'OPTIONS'){
        $app->response->setStatusCode('200', 'OK');
        $app->response->send();
        return;
    }
    // Respond by default as JSON
    if(!$app->request->get('format') || $app->request->get('format') == 'json'){

        // Results returned from the route's controller.  All Controllers should return an array
        $records = $app->getReturnedValue();

        $response = new \Api\Responses\JSONResponse();
        $response->useEnvelope(true) //this is default behavior
        ->convertSnakeCase(false) //this is also default behavior
        ->send($records);

        return;
    } else if($app->request->get('format') == 'javascript'){
        // Results returned from the route's controller.  All Controllers should return an array
        $records = $app->getReturnedValue();

        $response = new \Api\Responses\JavascriptResponse();
        $response->useEnvelope(true) //this is default behavior
            ->convertSnakeCase(false) //this is also default behavior
            ->send($records);

        return;
    }
    else if($app->request->get('format') == 'csv'){

        $records = $app->getReturnedValue();
        $response = new \Api\Responses\CSVResponse();
        $response->useHeaderRow(true)->send($records);

        return;
    }
    else {
        throw new \Api\Exceptions\HTTPException(
            'Could not return results in specified format',
            403,
            array(
                'dev' => 'Could not understand format specified by format paramter in query string.',
                'internalCode' => 'NF1000',
                'more' => 'Type may not be implemented. Choose either "csv" or "json"'
            )
        );
    }
});

/**
 * The notFound service is the default handler function that runs when no route was matched.
 * We set a 404 here unless there's a suppress error codes.
 */
$app->notFound(function () use ($app) {
    throw new \Api\Exceptions\HTTPException(
        'Not Found.',
        404,
        array(
            'dev' => 'That route was not found on the server.',
            'internalCode' => 'NF1000',
            'more' => 'Check route for mispellings.'
        )
    );
});

/**
 * If the application throws an HTTPException, send it on to the client as json.
 * Elsewise, just log it.
 */
//set_exception_handler(function($exception) use ($app){
//    //HTTPException's send method provides the correct response headers and body
//    if(is_a($exception, 'Api\\Exceptions\\HTTPException')){
//        $exception->send();
//    }
//    echo '<pre>';
//    print_r($exception);
//    print_r($exception->getTraceAsString());
//    echo '</pre>';
//});

$app->handle();

