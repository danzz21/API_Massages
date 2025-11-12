<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get(from: '/', to: 'Home::index');
$routes->group(name: 'api', params: function($routes): void {
    $routes->get('messages','api::index');
    $routes->get('messages/(:num)','api::show/$1');
    $routes->put('messages/(:num)','api::update/$1');
    $routes->post('messages','api::create');


//tambahkan option method untuk CORS preflight request
    $routes->options('messages', function() {
        $response = service('response');
        return $response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With')
            ->setStatusCode(200);
    });

});
