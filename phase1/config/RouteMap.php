<?hh

namespace Config;

class RouteMap
{

// Defines the routing mapping from the request URI to the controller.
public static $s_map = Map<string, string> {
    "/example" => "ExampleController",

    "/error" => "ErrorController"
};

}

