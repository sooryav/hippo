<?php

require_once('../core/Router.php');
require_once('../config/RouteMap.php');

define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');

$request_url = isset($_SERVER['REQUEST_URI'])
    ? $_SERVER['REQUEST_URI']
    : $argv[1];

$router = new Core\Router(Config\RouteMap::$s_map);
$controllerDir = ROOT_DIR . '../controller';

try
{
    $router->route(
        $controllerDir,
        rtrim(strtok($request_url, '?'), "/"),
        $_REQUEST);
}
catch (Exception $e)
{
    $router->route(
        $controllerDir,
        '/error',
        [ 'message' => $e->getMessage() ]);
}

?>
