<?php

require_once (ROOT_DIR.'/app/Controller.php');
require 'Guard.php';

class Route extends Controller {

  // file - plik do wygenerowania, 
  // title - tytuł strony, 
  // roles - role ktore maja dostep do tego routu, 
  // redirect - route do ktorego ma przekierowac jesli rola jest niepoprawna
  private $routes = [
    '/' => [
      'file' => 'index.php',
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
      'controller' => 'AuthController',
      'function' => 'logout',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/dodaj' => [
      'file' => 'create.php',
      'title' => 'Tworzenie zestawu',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/wszystkie-fiszki' => [
      'file' => 'allsets.php',
      'title' => 'Wszystkie fiszki',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/szukaj' => [
      'file' => 'search.php',
      'title' => 'Szukaj fiszek',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/moje-fiszki' => [
      'file' => 'usersets.php',
      'title' => 'Moje fiszki',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/ustawienia' => [
      'file' => 'settings.php',
      'title' => 'Moje konto',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/nauka' => [
      'controller' => 'LearnController',
      'function' => 'learn',
      'roles' => ['user', 'admin'],
      'redirect' => 'notfound'
    ],
    '/test' => [
      'function' => 'test',
      'roles' => ['guest', 'user', 'admin']
    ]
  ];

  // routy używane gdy metodą jest POST
  private $postRoutes = [
    '/logowanie' => [
      'controller' => 'AuthController',
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

  public function render($requestedRoute, $method = 'get') {
    if($method == 'get' ? !isset($this->routes[$requestedRoute]) : !isset($this->postRoutes[$requestedRoute])) {

      $requestedRoute = 'notfound';
      header("HTTP/1.1 404 Not Found");

    } else {

      if($method == 'get' ? !Guard::checkAccess($_SESSION['role'],$this->routes[$requestedRoute]['roles']) : !Guard::checkAccess($_SESSION['role'],$this->postRoutes[$requestedRoute]['roles'])) {
        $method == 'get' ? $this->redirectTo($this->routes[$requestedRoute]['redirect']) : $this->redirectTo($this->postRoutes[$requestedRoute]['redirect']);
      }

      $controllerToRequire = $method == 'get' ? ($this->routes[$requestedRoute]['controller'] ?? null) : ($this->postRoutes[$requestedRoute]['controller'] ?? null);

      if($controllerToRequire != null) {
        
        require_once (ROOT_DIR.'/controllers/'.$controllerToRequire.'.php');

        class_alias($controllerToRequire, 'PageController');
        $pageController = new PageController();

        $functionToCall = $method == 'get' ? ($this->routes[$requestedRoute]['function'] ?? null) : ($this->postRoutes[$requestedRoute]['function'] ?? null);
        if($functionToCall != null) $pageController->$functionToCall();

      } else {
        $functionToCall = $method == 'get' ? ($this->routes[$requestedRoute]['function'] ?? null) : ($this->postRoutes[$requestedRoute]['function'] ?? null);
        if($functionToCall != null) $this->$functionToCall();
      }

    }
    return $this->view($this->routes[$requestedRoute]['file'], ['pageTitle' => $this->routes[$requestedRoute]['title']]);
  }
  
  // FUNKCJA DO TESTÓW
  private function test() {
    die();
  }

}