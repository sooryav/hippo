<?php

namespace Core;

// Router class is responsible for routing the given request to
// the corresponding controller.
// It expects the routing mapping as follows:
// $routerMap = [
//     "/Identifier[/subDirs]" => "ControllerClass name",
//     ...
// ];
// 
// For example, if you have the following:
//    "/example" => "Controller1",
// it will load \Controller\Controller1 class from
// CONTROLLER_DIR/Controller1.php file where CONTROLLER_DIR is the base
// directory of controller files.
// If you have the following:
//    "/example/foo" => "bar",
// it will load \Controller\bar class from CONTROLLER_DIR/foo/bar.php file.
// Note that all the string comparions are case-sensitive.
class Router
{
    // Stores the given route map.
    private $routeMap;

    // Router class constructor that takes route map as an input.
    public function __construct(array $routeMap)
    {
        $this->routeMap = $routeMap;
    }

    // $controllerDir: the base directory where the controller php files exist.
    // $requestUrl: the request URI without the query string.
    //     If the original request URI was /foo/?bar=1,
    //     the $requestUrl passed in should be /foo.
    //     Note that it is the key to the $routeMap (case-sensitive).
    // $inputs: input data array (such as from $_GET or $_POST).
    public function route($controllerDir, $requestUrl, array $inputs)
    {
        if (!array_key_exists($requestUrl, $this->routeMap)) {
            throw new \Exception("The route [$requestUrl] is unknown.");
        }

        // The controller file we will be loading.
        $controllerName = $this->routeMap[$requestUrl];
        $filePath = $this->getControllerSubDir($controllerDir, $requestUrl)
            . "$controllerName.php";

        if (!file_exists($filePath)) {
            throw new \Exception(
                "The contoller file [$filePath] does not exist."); 
        }

        // Load the controller file.
        require_once($filePath);

        $controllerClassName = '\\Controller\\' . $controllerName;
        $controller = new $controllerClassName($requestUrl);
        $controller->execute($inputs); 
    }	

    private function getControllerSubDir($controllerDir, $requestUrl)
    {
        // The implode/explode operations below just strip the "Identifier"
        // and construct the "subDir". For example, 
        // $requestUrl = /example => "",
        // $requestUrl = /example/foo => "foo",
        // $requestUrl = /example/foo/bar => "foo/bar",
        return "$controllerDir/"
            . implode('/', array_slice(explode('/', $requestUrl), 2))
            . "/";
    }
}

?>
