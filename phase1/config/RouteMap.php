<?hh

namespace Config;

class RouteMap
{

  // Defines the routing mapping from the request URI to the controller.
  public static ImmMap<string, string> $s_map = ImmMap {
    '/dashboard' => 'DashboardController',

    '/example' => 'ExampleController',

    '/error' => 'ErrorController',

    '/venues' => 'VenueController'
  };

}

