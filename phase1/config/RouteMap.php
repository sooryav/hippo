<?php

namespace Config;

class RouteMap
{

// Defines the routing mapping from the request URI to the controller.
public static $s_map = [
    "/example" => "ExampleController",

    "/example/example2" => "Example2Controller",

    "/error" => "ErrorController"
];

}

?>
