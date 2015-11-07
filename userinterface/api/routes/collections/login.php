<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $autocompleteCollection
 */


return call_user_func(function(){

    $loginCollection = new \Phalcon\Mvc\Micro\Collection();

    $loginCollection
        // VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
        ->setPrefix('/v1/login')
        // Must be a string in order to support lazy loading
        ->setHandler('\Api\Controllers\LoginController')
        ->setLazy(true);

    // Set Access-Control-Allow headers.
    $loginCollection->options('/', 'optionsBase');
//    $loginCollection->options('/{access_token}', 'optionsOne');

    // First paramter is the route, which with the collection prefix here would be GET /autocomplete/
    // Second paramter is the function name of the Controller.
    $loginCollection->get('/', 'get', 'login-allow');

    $loginCollection->get('/me', 'me', 'login-me-allow');
    $loginCollection->get('/out', 'out', 'login-out-allow');

    $loginCollection->post('/', 'post', 'login-post--allow');
    // This is exactly the same execution as GET, but the Response has no body.
    $loginCollection->head('/', 'get', 'login-head-allow');

    return $loginCollection;
});
