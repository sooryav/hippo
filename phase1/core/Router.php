<?hh

namespace Core;

require_once(__DIR__ . '/Context.php');
require_once(__DIR__ . '/Request.php');

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
  // $context: Context object for this request.
  // $request: Request object that captures request information.
  public function route(
    string $controllerDir,
    Context $context,
    Request $request) {

    $requestUrl = $request->m_url;

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
    $controller = new $controllerClassName($context, $request->m_params);

    // Validate the controller's path is same as the one specified
    // in the $m_routeMap.
    if ($requestUrl != $controller->getPath()) {
      throw new \Exception("Route map is invalid for $requestUrl.");
    }

    $controller->execute();
  }

}
