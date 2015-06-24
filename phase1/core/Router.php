<?php

namespace Core;

class Router
{
    // Stores the route map.
    private $routeMap;

    // Router class constructor that takes route map as an input.
    public function __construct(array $routeMap)
    {
        $this->routeMap = $routeMap;
    }

    // $controllerDir: directory where the controller php files exist.
    // $requestUrl: the request URI without the query string.
    //     If the original request URI was /foo/?bar=1,
    //     the $requestUrl passed in should be /foo.
    //     Note that this is the key to the $config (case-sensitive).
    // $inputs: input data array (such as from $_GET or $_POST).
    public function route($controllerDir, $requestUrl, array $inputs)
    {
        if (!array_key_exists($requestUrl, $this->routeMap)) {
            throw new \Exception("The route [$requestUrl] is unknown.");
        }

        // The controller file we will be loading.
        $controllerName = $this->routeMap[$requestUrl];
        $path = $this->getControllerSubDir($controllerDir, $requestUrl)
            . "$controllerName.php";

        if (!file_exists($path)) {
            throw new \Exception("The contoller file [$path] does not exist."); 
        }

        require_once($path);

	$controllerClassName = '\\Controller\\' . $controllerName;
        $controller = new $controllerClassName($requestUrl);
        $controller->execute($inputs); 
    }	

    private function getControllerSubDir($controllerDir, $requestUrl)
    {
        return "$controllerDir/"
            . implode('/', array_slice(explode('/', $requestUrl), 2))
            . "/";
    }
}

?>
