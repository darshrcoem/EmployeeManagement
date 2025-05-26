<?php
/**
 
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;


Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    // Register scoped middleware for in scopes.
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true,
    ]));

    /*
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered through `Application::routes()` with `registerMiddleware()`
     */
    $routes->applyMiddleware('csrf');
    $routes->connect('/', ['controller' => 'Admin', 'action' => 'display']);
    $routes->connect('/login', ['controller' => 'Admin', 'action' => 'login']);
    $routes->connect('/signup', ['controller' => 'Admin', 'action' => 'signup']);
    $routes->connect('/logout', ['controller' => 'Admin', 'action' => 'logout']);
  // $routes->connect('/attendence/mark', ['controller' => 'Attendence', 'action' => 'view']);


    //$routes->connect('/dashboard', ['controller' => 'EmpData', 'action' => 'display']);
    $routes->fallbacks(DashedRoute::class);
});