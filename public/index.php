<?php

/**
 * Front controller
 * 
 * 
 */

/**
 * Composer
 */
require '../vendor/autoload.php';


/**
 * Twig
 */
Twig_Autoloader::register();

/**
 * Autoloader
 */
// spl_autoload_register( function( $class ){
//     $root = dirname( __DIR__ ); //get the parent directory
//     $file = $root . '/' . str_replace( '\\', '/', $class ) . '.php';
//     if( is_readable( $file ) ){
//         require $root . '/' . str_replace( '\\', '/', $class ) . '.php';
//     }
// });

/**
 * Error and Exception handling
 */
error_reporting( E_ALL );
set_error_handler( 'Core\Error::errorHandler' );
set_exception_handler( 'Core\Error::exceptionHandler' );

/**
 * Routing
 */
// require '../Core/Router.php';

$router = new Core\Router();

// echo get_class( $router );

//Add the routes
$router->add( '', ['controller' => 'Home', 'action' => 'index'] );
$router->add( '{controller}/{action}' );
$router->add( '{controller}/{id:\d+}/{action}' );
$router->add( 'admin/{controller}/{action}', ['namespace' => 'Admin'] );

//Display the routing table
// echo '<pre>';
// // var_dump( $router->getRoutes() );
// echo htmlspecialchars( print_r( $router->getRoutes(), true ) );
// echo '</pre>';

// Match the requested route
$url = $_SERVER['QUERY_STRING'];

// if( $router->match( $url ) ){
//     echo '<pre>';
//     var_dump( $router->getParams() );
//     echo '</pre>';
// }else{
//     echo "No route found for URL '{$url}'";
// }

$router->dispatch( $_SERVER['QUERY_STRING'] );