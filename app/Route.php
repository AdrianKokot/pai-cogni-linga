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
      'roles' => ['user', 'admin'],
      'redirect' => '/logowanie',
      'controller' => 'HomeController',
      'function' => 'main'
    ],
    '/wyloguj' => [
      'controller' => 'AuthController',
      'function' => 'logout',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/dodaj' => [
      'controller' => 'FlashSetsController',
      'function' => 'index',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/edytuj' => [
      'controller' => 'FlashSetsController',
      'function' => 'edit',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/usun' => [
      'controller' => 'FlashSetsController',
      'function' => 'delete',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/wszystkie-fiszki' => [
      'controller' => 'HomeController',
      'function' => 'allsets',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/szukaj' => [
      'controller' => 'HomeController',
      'function' => 'search',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/moje-fiszki' => [
      'controller' => 'HomeController',
      'function' => 'usersets',
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
      'redirect' => '/'
    ],
    '/test' => [
      'function' => 'test',
      'roles' => ['guest', 'user', 'admin']
    ],
    '/kategoria' => [
      'function' => 'category',
      'controller' => 'HomeController',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
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
      'controller' => 'AuthController',
      'function' => 'register',
      'roles' => ['guest'],
      'redirect' => '/'
    ],
    '/dodaj' => [
      'controller' => 'FlashSetsController',
      'function' => 'postCreate',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/edytuj' => [
      'controller' => 'FlashSetsController',
      'function' => 'postEdit',
      'roles' => ['user', 'admin'],
      'redirect' => '/'
    ],
    '/ustawienia' => [
      'controller' => 'UserController',
      'function' => 'settings',
      'roles' => ['user', 'admin'],
      'redirect' => '/ustawienia'
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