<?php
namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 */
class Home extends \Core\Controller{

    /**
     * Before filter
     * 
     * @return void
     */
    protected function before(){
        // echo "(before)";
    }

    /**
     * After filter
     * 
     * @return void
     */
    protected function after(){
        // echo "(after)";
    }

    /**
     * Show the index page
     * 
     * @return void
     */
    public function indexAction(){
        // echo 'Hello from the index action on the Home controller';
        // View::render( 'Home/index.php', [
        //     'name' => 'Kenneth',
        //     'colours' => ['red', 'black', 'green']
        // ] );

        View::renderTemplate( 'Home/index.html', [
            'name'  => 'Kenneth',
            'colors'=> ['red', 'white', 'blue']
        ] );
    }
}