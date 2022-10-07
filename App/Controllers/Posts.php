<?php
namespace App\Controllers;

use \Core\View;
use App\Models\Post;
/**
 * Posts controller
 */
class Posts extends \Core\Controller{
    /**
     * Before filter
     * 
     * @return voide
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
        $posts = Post::getAll();
        
        View::renderTemplate( 'Posts/index.html',[
            'posts' => $posts
        ] );
    }

    /**
     * Show the add new page
     * 
     * @return void
     */
    public function addNewAction(){
        echo 'Hello from the addNew action in the Posts controller';
    }

    public function showAction(){
        echo 'Hello from the show action in the Posts controller';
        echo '<p>Route parameters: <pre>' . 
        htmlspecialchars( print_r( $this->route_params, true ) ) . '</pre></p>';
    }

    public function editAction(){
        echo 'Hello from the edit action in the Posts controller';
        echo '<p>Route parameters: <pre>' . 
        htmlspecialchars( print_r( $this->route_params, true ) ) . '</pre></p>';
    }
}