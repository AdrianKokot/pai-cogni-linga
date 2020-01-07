<?php

class Controller {
  public function redirectTo($route = null) {
    header('Location: '.($route ?? '/'));
    die();
  }

  public function view($file, Array $options = []) {
    $pageTitle = $options['pageTitle'] ?? 'Nie znaleziono';
    require_once ROOT_DIR.'/layout/head.php';
    require_once ROOT_DIR.'/views/'.$file;
    require_once ROOT_DIR.'/layout/footer.php';
    die();
  }
}