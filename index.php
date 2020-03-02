<?php 
session_start();

define('ROOT_DIR',__DIR__);
define('ROOT_URL', substr($_SERVER["PHP_SELF"], 0, strpos($_SERVER["PHP_SELF"], "/index.php")));

$uri = str_replace(ROOT_URL, "",$_SERVER["REQUEST_URI"]);
$uri = str_replace("/index.php", "", $uri);
$uri = $uri != "" ? $uri : "/";

require_once 'app/Session.php';
require_once 'database/DB.php';
DB::configure();
DB::fillData();

if(!isset($_SESSION['role'])) $_SESSION['role'] = 'guest';

require_once 'app/Route.php';
$router = new Route();

$requestedRoute = explode('/', $uri);
$_SESSION['routeOther'] = array_slice($requestedRoute, 2) ?? null;

if($_SERVER['REQUEST_METHOD'] == 'GET') {
  $router->render('/'.$requestedRoute[1]);
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $router->render('/'.$requestedRoute[1], 'post');
}