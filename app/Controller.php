<?php

class Controller {
  public function redirectTo($route = null) {
    header('Location: '.ROOT_URL.($route ?? '/'));
    die();
  }

  public function view($file, Array $options = []) {
    $pageTitle = $options['pageTitle'] ?? 'Nie znaleziono';
    $web = $options['web'] ?? null;
    require_once ROOT_DIR.'/layout/head.php';
    require_once ROOT_DIR.'/views/'.$file;
    require_once ROOT_DIR.'/layout/footer.php';
    die();
  }

  public function abort(){
    return $this->view('notfound.html');
  }
}