<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $autocompleteCollection
 */

// This is an Immeidately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('autocomplete.php');
return call_user_func(function () {

    $userCollection = new \Phalcon\Mvc\Micro\Collection();

    $userCollection
        // VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
        ->setPrefix('/v1/user')
        // Must be a string in order to support lazy loading
        ->setHandler('\Api\Controllers\UserController')
        ->setLazy(true);

    // Set Access-Control-Allow headers.
    $userCollection->options('/', 'optionsBase');
    $userCollection->options('/{id,email,images}', 'optionsOne');

    // First paramter is the route, which with the collection prefix here would be GET /autocomplete/
    // Second paramter is the function name of the Controller.
    $userCollection->get('/', 'get');
    $userCollection->post('/', 'post');
    $userCollection->put('/{id:[a-zA-Z0-9_-]+}','put');

    // This is exactly the same execution as GET, but the Response has no body.
    $userCollection->head('/', 'get');

    return $userCollection;
});
