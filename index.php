<?php 
session_start();
require_once 'database/Connection.php';
if(!isset($_SESSION['role'])) $_SESSION['role'] = 'guest';

require_once 'controllers/Route.php';
$router = new Route();

if($_SERVER['REQUEST_METHOD'] == 'GET') {

  $_SESSION['publicPath'] = __DIR__;

  $requestedRoute = explode('/', $_SERVER["REQUEST_URI"]);
  $_SESSION['routeOther'] = array_slice($requestedRoute, 2) ?? null;

  require_once 'layout/head.php';

  $router->render('/'.$requestedRoute[1]);

  require_once 'layout/footer.php';
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $router->post($_SERVER["REQUEST_URI"]);
}