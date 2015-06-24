<?php

namespace Config;

class RouteMap
{

// Defines the mapping from request uri to the controller.
public static $s_map = [
    "/example" => "ExampleController",

    "/example/example2" => "Example2Controller",

    "/error" => "ErrorController"
    ];

}

?>
