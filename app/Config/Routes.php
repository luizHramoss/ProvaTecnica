<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('login', 'AuthController::login');

$routes->group('api', ['filter' => 'jwt'], function($routes) {
    $routes->get('clientes', 'ClientesController::index');
    $routes->get('clientes/(:segment)', 'ClientesController::show/$1');
    $routes->post('clientes', 'ClientesController::create');
    $routes->put('clientes/(:segment)', 'ClientesController::update/$1');
    $routes->delete('clientes/(:segment)', 'ClientesController::delete/$1');
    
    $routes->get('produtos', 'ProdutosController::index');
    $routes->get('produtos/(:segment)', 'ProdutosController::show/$1');
    $routes->post('produtos', 'ProdutosController::create');
    $routes->put('produtos/(:segment)', 'ProdutosController::update/$1');
    $routes->delete('produtos/(:segment)', 'ProdutosController::delete/$1');
    
    $routes->get('pedidos', 'PedidosController::index');
    $routes->get('pedidos/(:segment)', 'PedidosController::show/$1');
    $routes->post('pedidos', 'PedidosController::create');
    $routes->put('pedidos/(:segment)', 'PedidosController::update/$1');
    $routes->delete('pedidos/(:segment)', 'PedidosController::delete/$1');
});


