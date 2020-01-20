<?php 
session_start();

$uri = substr($_SERVER["PHP_SELF"], strpos($_SERVER["PHP_SELF"], "/index.php")); //tekst z /index.php

define('ROOT_DIR',__DIR__);
define('ROOT_URL', substr($_SERVER["PHP_SELF"], 0, -strlen($uri)));

$uri = str_replace("/index.php", "", $uri);
$uri = $uri != "" ? $uri : "/";

require_once 'app/Session.php';
require_once 'database/Connection.php';
DB::configure();
DB::fillData();

if(!isset($_SESSION['role'])) $_SESSION['role'] = 'guest';

require_once 'app/Route.php';
$router = new Route();

if($_SERVER['REQUEST_METHOD'] == 'GET') {

  $requestedRoute = explode('/', $uri);
  $_SESSION['routeOther'] = array_slice($requestedRoute, 2) ?? null;

  $router->render('/'.$requestedRoute[1]);
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $router->render($uri, 'post');
}