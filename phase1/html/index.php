<?hh

require_once(__DIR__ . '/../core/Context.php');
require_once(__DIR__ . '/../core/logger/LoggerFactory.php');
require_once(__DIR__ . '/../core/Router.php');
require_once(__DIR__ . '/../config/RouteMap.php');

use Core\Context;
use Core\LoggerFactory;
use Core\Request;
use Core\Router;

class Application {

  public function __construct(
    private Map<int, string> $m_argv) {
  }

  public function main(): void {
    $context = $this->createContext();  
    $request = $context->m_request;

    // Just an example how the logging can be done.
    $context->m_logger->info("Request url is $request->m_url.");

    // Handle the request using the router.
    $router = new Router(Config\RouteMap::$s_map);
    $controllerDir = __DIR__ . '/../controller';

    try {
      $router->route($controllerDir, $context);
    }
    catch (Exception $e) {
      $request->m_url = '/error';
      $request->m_params =
        Map{ 'message' => $e->getMessage() };

      $router->route($controllerDir, $context);
    }
  }

  private function createContext(): Context {
    return new Context(
      (new LoggerFactory())->create('log'),
      $this->createRequest());
  }

  private function createRequest(): Request {
    $request_url = isset($_SERVER['REQUEST_URI'])
      ? $_SERVER['REQUEST_URI']
      : ($this->m_argv != null && ($this->m_argv->count() > 1)
          ? $this->m_argv[1]
          : '');

    return new Request(
      rtrim(strtok($request_url, '?'), "/"),
      new Map($_REQUEST));
  }
}


// The main driver of the application.
(new Application(new Map($argv)))->main();
