<?php
class Route {

  private $routes = [
    '/' => [
      'file' => 'index.html',
      'title' => 'Strona główna',
      'roles' => ['guest'],
      'redirect' => '/cogni'
    ],
    '/logowanie' => [
      'file' => 'login.html',
      'title' => 'Logowanie',
      'roles' => ['guest']
    ], 
    '/rejestracja' => [
      'file' => 'register.html',
      'title' => 'Rejestracja',
      'roles' => ['guest']
    ],
    'notfound' => [
      'file' => 'notfound.html',
      'title' => 'Nie znaleziono',
      'roles' => ['guest']
    ],
    '/cogni' => [
      'file' => 'main.html',
      'title' => 'Strona główna',
      'roles' => ['user', 'admin'],
      'redirect' => '/logowanie'
    ]
  ];

  private $postRoutes = [
    '/logowanie' => [
      'function' => 'login',
      'roles' => ['guest'],
      'redirect' => '/'
    ]
  ];

  public function render($requestedRoute) {
    if(!isset($this->routes[$requestedRoute])) {
      $requestedRoute = 'notfound';
      header("HTTP/1.1 404 Not Found");
    } else {

      if(!in_array($_SESSION['role'],$this->routes[$requestedRoute]['roles'])) {
        $this->redirectTo($this->routes[$requestedRoute]['redirect']);
      }

      $functionToCall = $this->routes[$requestedRoute]['function'] ?? null;
      if($functionToCall != null) $this->$functionToCall();
    }

    require_once $_SESSION['publicPath'].'/views/'.$this->routes[$requestedRoute]['file'];
  }

  public function post($requestedRoute) {
    if(!isset($this->postRoutes[$requestedRoute])) {
      die();
    } else {

      if(!in_array($_SESSION['role'],$this->postRoutes[$requestedRoute]['roles'])) {
        $this->redirectTo($this->postRoutes[$requestedRoute]['redirect']);
      }

      $functionToCall = $this->postRoutes[$requestedRoute]['function'] ?? null;
      if($functionToCall != null) $this->$functionToCall();
    }
  }

  public function getPageTitle($requestedRoute) {
    return $this->routes[$requestedRoute]['title'] ?? 'Nie znaleziono';
  }

  private function redirectTo($route = null) {
    header('Location: '.($route ?? '/'));
    die();
  }

  // POST FUNCTIONS
  private function login() {
    if(!(isset($_POST['btnSubmit'])&&isset($_POST['username'])&&isset($_POST['password']))) {
      $this->redirectTo('/logowanie');
    }
    // TODO AUTORYZACJA
    $_SESSION['role'] = 'user';
    $this->redirectTo('/');
  }
}