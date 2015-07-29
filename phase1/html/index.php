<?hh

require_once(__DIR__ . '/../core/Context.php');
require_once(__DIR__ . '/../core/logger/LoggerFactory.php');
require_once(__DIR__ . '/../core/Request.php');
require_once(__DIR__ . '/../core/Router.php');
require_once(__DIR__ . '/../config/RouteMap.php');

use \Core\Context;
use \Core\LoggerFactory;
use \Core\Request;
use \Core\RequestParams;
use \Core\Router;

class Application {

  private Map<int, string> $m_argv;

  public function __construct(Map<int, string> $argv) {
    $this->m_argv = $argv;
  }

  public function main(): void {
    $this->startSession();

    $logger = (new LoggerFactory())->create('log');
    $context = new Context($logger, $this->createRequest());

    // Just an example how the logging can be done.
    $context->getLogger()->info(
      "Request url is " . $context->getRequest()->getUri() . "."
    );

    // Handle the request using the router.
    $router = new Router(\Config\RouteMap::$s_map);
    $controllerDir = __DIR__ . '/../controller';

    try {
      $router->route($controllerDir, $context);
    }
    catch (Exception $e) {
      $_SERVER['REQUEST_URI'] = '/error';
      $_SERVER['REQUEST_METHOD'] = 'GET';
      $_GET['message'] = $e->getMessage();

      $router->route(
        $controllerDir,
        new Context($logger, $this->createRequest())
      );
    }
  }

  private function createRequest(): Request {
    $request_url = isset($_SERVER['REQUEST_URI'])
      ? $_SERVER['REQUEST_URI']
      : ($this->m_argv != null && ($this->m_argv->count() > 1)
          ? $this->m_argv[1]
          : '');

    $params = !isset($_SERVER['REQUEST_METHOD'])
      ? Map{}
      : ($_SERVER['REQUEST_METHOD'] === 'GET'
          ? Map::fromArray($_GET)
          : Map::fromArray($_POST));

    return new Request(
      rtrim(strtok($request_url, '?'), "/"),
      new RequestParams($params)
    );
  }

  private function startSession(): void {
    session_save_path(
      realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session')
    );
    session_start();
  }

}


// The main driver of the application.
(new Application(new Map($argv)))->main();
