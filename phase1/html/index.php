<?hh

require_once(__DIR__ . '/../core/Context.php');
require_once(__DIR__ . '/../core/logger/LoggerFactory.php');
require_once(__DIR__ . '/../core/Router.php');
require_once(__DIR__ . '/../config/RouteMap.php');

define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');

// Set up context for this request.
$context = new \Core\Context(
  (new \Core\LoggerFactory())->create('log'));

$request_url = isset($_SERVER['REQUEST_URI'])
  ? $_SERVER['REQUEST_URI']
  : $argv[1];

// Just an example for now.
$context->m_logger->info("Request url is " . $request_url);

// Handle the request using the router.
$router = new Core\Router(Config\RouteMap::$s_map);
$controllerDir = ROOT_DIR . '../controller';

try {
  $router->route(
    $controllerDir,
    rtrim(strtok($request_url, '?'), "/"),
    new Map<string, mixed>($_REQUEST));
}
catch (Exception $e) {
  $router->route(
    $controllerDir,
    '/error',
    Map<string, mixed>{'message' => $e->getMessage()});
}

