<?php
use Cake\Routing\Router;

Router::scope('/', ['plugin' => 'FrontEngine'], function ($routes) {
    $routes->connect('/', ['controller' => 'Home', 'action' => 'index']);
});

Router::prefix('admin', function($routes) {
    $routes->plugin('FrontEngine', function($routes){
        $routes->fallbacks('DashedRoute');
    });
    $routes->connect('/menus', ['plugin' => 'FrontEngine', 'controller' => 'Menus', 'action' => 'index']);
    $routes->connect('/menus/:action/*', ['plugin' => 'FrontEngine', 'controller' => 'Menus']);
    $routes->connect('/links', ['plugin' => 'FrontEngine', 'controller' => 'Links', 'action' => 'index']);
    $routes->connect('/links/:action/*', ['plugin' => 'FrontEngine', 'controller' => 'Links']);
});
