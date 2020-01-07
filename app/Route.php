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
      'file' => 'login.php',
      'title' => 'Logowanie',
      'roles' => ['guest']
    ], 
    '/rejestracja' => [
      'file' => 'register.php',
      'title' => 'Rejestracja',
      'roles' => ['guest']
    ],
    'notfound' => [
      'file' => 'notfound.html',
      'title' => 'Nie znaleziono',
      'roles' => ['guest']
    ],
    '/cogni' => [
      'file' => 'main.php',
      'title' => 'Strona główna',
      'roles' => ['user', 'admin'],
      'redirect' => '/logowanie'
    ],
    '/wyloguj' => [
      'function' => 'logout',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/test' => [
      'function' => 'test',
      'roles' => ['guest', 'user', 'admin']
    ]
  ];

  private $postRoutes = [
    '/logowanie' => [
      'function' => 'login',
      'roles' => ['guest'],
      'redirect' => '/'
    ],
    '/rejestracja' => [
      'function' => 'register',
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

      if(!in_array($_SESSION['role'],$this->postRoutes[$requestedRoute]['roles']) || ($_SESSION['status'] ?? 'active') != 'active') {
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
  
  // FUNKCJA DO TESTÓW
  private function test() {
    die();
  }

  // POST FUNCTIONS
  private function login() {
    if(!(isset($_POST['btnSubmit'])&&isset($_POST['username'])&&isset($_POST['password']))) {
      $this->redirectTo('/logowanie');
    }

    require_once 'Auth.php';
    $authData = Auth::login($_POST['username'], $_POST['password']);
    
    if($authData == null) {
      Session::setFlash('Nazwa użytkownika lub hasło jest nieprawidłowe.');
      $this->redirectTo('/logowanie');
    } 

    require_once 'Guard.php';
    $_SESSION['role'] = Guard::getRole($authData['role']);
    $_SESSION['status'] = Guard::getStatus($authData['role']);
    $_SESSION['userId'] = $authData['id'];

    $this->redirectTo('/');
  }

  private function register() {
    if(!(isset($_POST['btnSubmit'])&&isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['password-confirm']))) {
      Session::setFlash('Proszę wypełnić wszystkie pola.');
      $this->redirectTo('/rejestracja');
    }

    if($_POST['password'] !== $_POST['password-confirm']){
      Session::setFlash('Hasła nie zgadzają się ze sobą.');
      $this->redirectTo('/rejestracja');
    }

    require_once 'Auth.php';
    $authData = Auth::register($_POST['username'], $_POST['password'], $_POST['register-code'] ?? null);
    
    require_once 'Guard.php';
    $_SESSION['role'] = Guard::getRole($authData['role']);
    $_SESSION['status'] = Guard::getStatus($authData['role']);
    $_SESSION['userId'] = $authData['id'];

    $this->redirectTo('/');
  }

  private function logout() {
    require_once 'Auth.php';
    Auth::logout();
    $this->redirectTo('/');
  }
}