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
        ->setPrefix('/v1/address')
        // Must be a string in order to support lazy loading
        ->setHandler('\Api\Controllers\AddressController')
        ->setLazy(true);

    // Set Access-Control-Allow headers.
    $collection->options('/', 'optionsBase');
//    $collection->options('/{access_token}', 'optionsOne');

    // First paramter is the route, which with the collection prefix here would be GET /autocomplete/
    // Second paramter is the function name of the Controller.
    $collection->get('/', 'get', 'address-authbasic');
    $collection->get('/uf', 'uf', 'address-uf-authbasic');
    $collection->get('/city/{uf}', 'city', 'address-city-authbasic');
    $collection->get('/hood/{city_id}', 'hood', 'address-hood-authbasic');
    $collection->get('/street/{hood_id}', 'street', 'address-street-authbasic');
    $collection->get('/zipcode/{zip_code}', 'zipcode', 'address-zipcode-authbasic');
    $collection->get('/geographic/{zip_code}/{number}', 'geographicByZipCode', 'geographic-zipcode-number-authbasic');
    $collection->get('/geographic/{zip_code}', 'geographicByZipCode', 'geographic-zipcode-authbasic');
    $collection->post('/geographic', 'geographicByPost', 'geographic-post-authbasic');


    $collection->post('/', 'post');
    $collection->put('/', 'put');
    // This is exactly the same execution as GET, but the Response has no body.
    $collection->head('/', 'get');

    return $collection;
});
