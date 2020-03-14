<?php

require_once (ROOT_DIR.'/app/Controller.php');
require_once (ROOT_DIR.'/app/Auth.php');
require_once (ROOT_DIR.'/app/Guard.php');

class AuthController extends Controller {
  public function login() {
    if(!(isset($_POST['btnSubmit'])&&isset($_POST['username'])&&isset($_POST['password']))) {
      $this->redirectTo('/logowanie');
    }

    $authData = Auth::login($_POST['username'], $_POST['password']);
    
    if($authData == null) {
      Session::setFlash('Nazwa użytkownika lub hasło jest nieprawidłowe.');
      $this->redirectTo('/logowanie');
    } 

    $_SESSION['role'] = Guard::getRole($authData['role']);
    $_SESSION['status'] = Guard::getStatus($authData['status']);
    $_SESSION['userId'] = $authData['id'];

    $this->redirectTo('/');
  }

  public function register() {
    if(!(isset($_POST['btnSubmit'])&&isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['password-confirm']))) {
      Session::setFlash('Proszę wypełnić wszystkie pola.');
      $this->redirectTo('/rejestracja');
    }

    if($_POST['password'] !== $_POST['password-confirm']){
      Session::setFlash('Hasła nie zgadzają się ze sobą.');
      $this->redirectTo('/rejestracja');
    }

    if(DB::selectOne("SELECT * FROM users WHERE login = :login", ["login" => $_POST['username']])["rows"] > 0) {
      Session::setFlash('Nazwa użytkownika jest już w użyciu.');
      $this->redirectTo('/rejestracja');
    }

    $authData = Auth::register($_POST['username'], $_POST['password'], $_POST['register-code'] ?? null);
    
    $_SESSION['role'] = Guard::getRole($authData['role']);
    $_SESSION['status'] = Guard::getStatus($authData['role']);
    $_SESSION['userId'] = $authData['id'];

    $this->redirectTo('/');
  }

  public function logout() {
    Auth::logout();
    $this->redirectTo('/');
  }
}