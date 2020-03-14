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
      'roles' => ['guest', 'user', 'admin']
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
    $methodArray = $method == 'get' ? "routes" : "postRoutes";

    if(!isset($this->{$methodArray}[$requestedRoute])) {

      $requestedRoute = 'notfound';
      header("HTTP/1.1 404 Not Found");

    } else {

      if(!Guard::checkAccess($_SESSION["role"], $this->{$methodArray}[$requestedRoute]['roles'])) {
        $this->redirectTo($this->{$methodArray}[$requestedRoute]['redirect']);
      }

      $controllerToRequire = $this->{$methodArray}[$requestedRoute]['controller'] ?? null;

      if($controllerToRequire != null) {
        
        require_once (ROOT_DIR.'/controllers/'.$controllerToRequire.'.php');

        class_alias($controllerToRequire, 'PageController');
        $pageController = new PageController();

        $functionToCall = $this->{$methodArray}[$requestedRoute]['function'] ?? null;
        if($functionToCall != null) $pageController->$functionToCall();

      } else {
        $functionToCall = $this->{$methodArray}[$requestedRoute]['function'] ?? null;
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