<?php

/**
 * Router class
 */
class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = require_once('./config/routes.php');
    }

    private function getURI()
    {
        if ( ! empty( $_SERVER['REQUEST_URI'] ))
        {
            return trim( $_SERVER['REQUEST_URI'], '/' );
        }
    }

    public function run()
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path)
        {
            if (preg_match("~$uriPattern~", $uri)) 
            {
                if ($uriPattern !== '')
                {
                    $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                } 
                else 
                {
                    $internalRoute = $path;
                }
                $segments = explode('/', $internalRoute);
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);
                $actionName = array_shift($segments) . 'Action';
                $parameters = $segments;
                $controllerObject = new $controllerName();
                $result = @call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != null) 
                {
                    break;
                }
            }
        }
    }
}
