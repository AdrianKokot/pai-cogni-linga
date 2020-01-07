<?php 
define('ROOT_DIR',__DIR__);
session_start();
require_once 'app/Session.php';
require_once 'database/Connection.php';
DB::configure();
// DB::fillData();

if(!isset($_SESSION['role'])) $_SESSION['role'] = 'guest';

require_once 'app/Route.php';
$router = new Route();

if($_SERVER['REQUEST_METHOD'] == 'GET') {

  $requestedRoute = explode('/', $_SERVER["REQUEST_URI"]);
  $_SESSION['routeOther'] = array_slice($requestedRoute, 2) ?? null;

  $router->render('/'.$requestedRoute[1]);
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $router->render($_SERVER["REQUEST_URI"], 'post');
}
