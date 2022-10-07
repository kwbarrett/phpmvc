<?php
namespace Core;

class Router {
    /**
     * Associative array of routes (the routing table)
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $params = [];

    /**
     * Add a route to the routing table
     * 
     * @param string $route The route URL
     * @param array $params Parameters (controller, action, etc)
     * 
     * @return void
     */
    public function add( $route, $params=[] ){
        // Convert the route to a regular expressioin: escape the forward slashes
        $route = preg_replace( '/\//', '\\/', $route );

        //  Convert variables e.g. {controller}
        $route = preg_replace( '/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route );

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace( '/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route );

        // Add start and ending delimiters, and the case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     *  Get all the routes from the routing table
    * @return array
    */
    public  function getRoutes(){
        return $this->routes;
    }

    /**
     * Match the route to the routes in the routing table, setting the $params
     * property if a route is found
     * 
     * @param string $url The route URL
     * 
     * @return boolean true if a match found, false otherwise
     */
    public function match( $url ){

        // Match to the fixed URL format /controller/action
        // $reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";
        foreach( $this->routes as $route => $params ){
            if( preg_match( $route, $url, $matches ) ){
                //get named capture groups
                // $params = [];
                foreach( $matches as $key => $match ){
                    if( is_string( $key ) ){
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Get the currently matched parameters
     * 
     * @return array
     */
    public function getParams(){
        return $this->params;
    }

    /**
     * Dispatch the route, creating the controller object and running the
     * action method
     *
     * @param string $url The route URL
     *
     * @return void
     */
    public function dispatch( $url ){
        $url = $this->removeQueryStringVariables( $url );

        if( $this->match( $url ) ){
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps( $controller );
            // $controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace() . $controller;
            if( class_exists( $controller ) ){
                $controller_object = new $controller( $this->params );

                $action = $this->params['action'];
                $action = $this->convertToCamelCase( $action );
                // var_dump( $controller_object );die;
                // if( is_callable( [$controller_object, $action] ) ){
                //     $controller_object->$action();
                // }else{
                //     echo "Method $action (in controller $controller) was not found";
                // }
                if (preg_match('/action$/i', $action) == 0) {
                    $controller_object->$action();
                } else {
                    throw new \Exception("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
                }
                // $controller_object->$action();
            }else{
                // echo "Controller class $controller not found";
                throw new \Exception( "Controller class $controller not found" );
            }
        }else{
            // echo 'No route matched';
            throw new \Exception( 'No route matched', 404 );
        }
    }

    protected function convertToStudlyCaps( $string ){
        return str_replace( ' ', '', ucwords( str_replace( '-',' ', $string ) ) );
    }

    protected function convertToCamelCase( $string ){
        return lcfirst( $this->convertToStudlyCaps( $string ) );
    }

    public function removeQueryStringVariables( $url ){
        if( $url != '' ){
            $parts = explode( '&', $url, 2 );

            if( strpos( $parts[0], '=' ) == false ){
                $url = $parts[0];
            }else{
                $url = '';
            }
        }
        return $url;
    }
    
    public  function getNamespace(){
        $namespace = 'App\Controllers\\';
        if( array_key_exists( 'namespace', $this->params ) ){
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}