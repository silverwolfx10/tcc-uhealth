<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $autocompleteCollection
 */


return call_user_func(function(){

    $collection = new \Phalcon\Mvc\Micro\Collection();

    $collection
        // VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
        ->setPrefix('/v1/linkedinCallback')
        // Must be a string in order to support lazy loading
        ->setHandler('\Api\Controllers\LinkedinCallbackController')
        ->setLazy(true);

    // Set Access-Control-Allow headers.
//    $collection->options('/', 'optionsBase');
//    $collection->options('/{access_token}', 'optionsOne');

    // First paramter is the route, which with the collection prefix here would be GET /autocomplete/
    // Second paramter is the function name of the Controller.
    $collection->get('/', 'get', 'login-linkedin-allow');
    $collection->get('/{aacess}', 'get', 'login-linkedin-authenticating-allow');

//    $collection->post('/', 'post');
    // This is exactly the same execution as GET, but the Response has no body.
//    $collection->head('/', 'get');

    return $collection;
});
