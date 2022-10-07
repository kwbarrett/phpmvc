<?php
namespace App\Controllers;

/**
 * Comments controller
 */

 class Comments extends \Core\Controller{
    /**
     * Show the index page
     */
    public function index(){
        echo 'Hello from the index page in the Comments controller';
    }

    public function show(){
        echo 'Hello from the show page in the Comments controller';
        echo '<p>Route parameters: <pre>' . 
        htmlspecialchars( print_r( $this->route_params, true ) ) . '</pre></p>';
    }
 }