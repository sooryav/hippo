<?hh

namespace Core;

// Router class is responsible for routing the given request to
// the corresponding controller.
// It expects the routing mapping as follows:
// $routerMap = [
//     "/reqeustUrl" => "ControllerClass name",
//     ...
// ];
// 
// For example, if you have the following:
//    "/example" => "Controller1",
// it will load \Controller\Controller1 class.
// Note that all the string comparions are case-sensitive.
class Router {

  // Router class constructor that takes route map as an input.
  public function __construct(
    private Map<string, string> $m_routeMap) {
  }

  // $controllerDir: the base directory where the controller php files exist.
  //   TODO: Controllers will be loaded using autoload, thus this field
  //         will be deprecated once autoload is implemented.
  // $requestUrl: the request URI without the query string.
  //   If the original request URI was /foo/?bar=1,
  //   the $requestUrl passed in should be /foo.
  //   Note that it is the key to the $m_routeMap (case-sensitive).
  // $requestParams: request parameters (such as from $_GET or $_POST).
  public function route(
    string $controllerDir,
    string $requestUrl,
    Map<string, mixed> $requestParams) {

    if (!array_key_exists($requestUrl, $this->m_routeMap)) {
      throw new \Exception("The route [$requestUrl] is unknown.");
    }

    // The controller file we will be loading.
    $controllerName = $this->m_routeMap[$requestUrl];
    $filePath = "$controllerDir/$controllerName.php";

    if (!file_exists($filePath)) {
      throw new \Exception("The contoller file [$filePath] does not exist."); 
    }

    // Load the controller file.
    require_once($filePath);

    $controllerClassName = '\\Controller\\' . $controllerName;
    $controller = new $controllerClassName($requestUrl);

    // Validate the controller's path is same as the one specified
    // in the $m_routeMap.
    if ($requestUrl != $controller->getPath()) {
      throw new \Exception("Route map is out of sync for $requestUrl.");
    }
   
    $controller->execute($requestParams);
  }	

}

