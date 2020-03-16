<?php

require_once (ROOT_DIR.'/app/Controller.php');
require_once (ROOT_DIR.'/app/Guard.php');

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
      'roles' => ['guest', 'user', 'admin', 'teacher']
    ],
    '/cogni' => [
      'roles' => ['user', 'admin', 'teacher'],
      'redirect' => '/logowanie',
      'controller' => 'HomeController',
      'function' => 'main'
    ],
    '/wyloguj' => [
      'controller' => 'AuthController',
      'function' => 'logout',
      'roles' => ['user', 'admin', 'teacher'],
      'redirect' => '/'
    ],
    '/dodaj' => [
      'controller' => 'FlashSetsController',
      'function' => 'index',
      'roles' => ['user', 'admin', 'teacher'],
      'redirect' => '/'
    ],
    '/edytuj' => [
      'controller' => 'FlashSetsController',
      'function' => 'edit',
      'roles' => ['user', 'admin', 'teacher'],
      'redirect' => '/'
    ],
    '/usun' => [
      'controller' => 'FlashSetsController',
      'function' => 'delete',
      'roles' => ['user', 'admin', 'teacher'],
      'redirect' => '/'
    ],
    '/wszystkie-fiszki' => [
      'controller' => 'HomeController',
      'function' => 'allsets',
      'roles' => ['user', 'admin', 'teacher'],
      'redirect' => '/'
    ],
    '/szukaj' => [
      'controller' => 'HomeController',
      'function' => 'search',
      'roles' => ['user', 'admin', 'teacher'],
      'redirect' => '/'
    ],
    '/moje-fiszki' => [
      'controller' => 'HomeController',
      'function' => 'usersets',
      'roles' => ['user', 'admin', 'teacher'],
      'redirect' => '/'
    ],
    '/ustawienia' => [
      'file' => 'settings.php',
      'title' => 'Moje konto',
      'roles' => ['user', 'admin', 'teacher'],
      'redirect' => '/'
    ],
    '/nauka' => [
      'controller' => 'LearnController',
      'function' => 'learn',
      'roles' => ['user', 'admin', 'teacher'],
      'redirect' => '/'
    ],
    '/test' => [
      'function' => 'test',
      'roles' => ['guest', 'user', 'admin', 'teacher']
    ],
    '/kategoria' => [
      'function' => 'category',
      'controller' => 'HomeController',
      'roles' => ['user', 'admin', 'teacher'],
      'redirect' => '/'
    ],
    '/uzytkownicy' => [
      'function' => 'users',
      'controller' => 'AdminController',
      'roles' => ['admin'],
      'redirect' => '/'
    ],
    '/kategorie' => [
      'function' => 'categories',
      'controller' => 'AdminController',
      'roles' => ['admin', 'teacher'],
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
      'roles' => ['user', 'admin','teacher'],
      'redirect' => '/'
    ],
    '/edytuj' => [
      'controller' => 'FlashSetsController',
      'function' => 'postEdit',
      'roles' => ['user', 'admin','teacher'],
      'redirect' => '/'
    ],
    '/ustawienia' => [
      'controller' => 'UserController',
      'function' => 'settings',
      'roles' => ['user', 'admin','teacher'],
      'redirect' => '/ustawienia'
    ],
    '/postep' => [
      'controller' => 'LearnController',
      'function' => 'progress',
      'roles' => ['user', 'admin','teacher'],
      'redirect' => '/'
    ],
    '/kategorie' => [
      'controller' => 'AdminController',
      'function' => 'postcategory',
      'roles' => ['admin','teacher'],
      'redirect' => '/'
    ]
  ];

  public function render($requestedRoute, $method = 'get') {
    $method = $method == 'get' ? "routes" : "postRoutes";

    if(!isset($this->{$method}[$requestedRoute])) {

      $requestedRoute = 'notfound';
      header("HTTP/1.1 404 Not Found");

    } else {

      if(!Guard::checkAccess($_SESSION["role"], $this->{$method}[$requestedRoute]['roles'])) {
        $this->redirectTo($this->{$method}[$requestedRoute]['redirect']);
      }

      $controllerToRequire = $this->{$method}[$requestedRoute]['controller'] ?? null;

      if($controllerToRequire != null) {
        
        require_once (ROOT_DIR.'/controllers/'.$controllerToRequire.'.php');

        class_alias($controllerToRequire, 'PageController');
        $pageController = new PageController();

        $functionToCall = $this->{$method}[$requestedRoute]['function'] ?? null;
        if($functionToCall != null) $pageController->$functionToCall();

      } else {
        $functionToCall = $this->{$method}[$requestedRoute]['function'] ?? null;
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