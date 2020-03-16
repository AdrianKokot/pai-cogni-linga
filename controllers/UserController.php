<?php
require_once (ROOT_DIR.'/app/Auth.php');
class UserController extends Controller {
  public function settings() {
    if(isset($_POST['pwdchange'])) {
      if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['password_confirmation']) || empty($_POST['user'])) {
        Session::setFlash('Proszę uzupełnić wszystkie pola.');
        return $this->redirectTo('/ustawienia');
      }

      if($_POST['user'] != $_SESSION['userId']) {
        Session::setFlash("Wystąpił błąd.");
        return $this->redirectTo('/ustawienia');
      }

      $oldPwd = $_POST['old_password'];
      $pwd = $_POST['password'];
      $cPwd = $_POST['password_confirmation'];

      if($pwd != $cPwd) {
        Session::setFlash("Potwierdzenie hasła nie zgadza się.");
        return $this->redirectTo('/ustawienia');
      }

      $user = DB::selectOne("SELECT * FROM users WHERE id = :id and status = :status", ['id' => $_SESSION["userId"], 'status' => DB::$sActive]);
      if($user['rows'] != 1) {
        Session::setFlash("Użytkownik nie istnieje.");
        return $this->redirectTo('/ustawienia');
      }

      if(Auth::login($user["data"]["login"], $oldPwd) != null) {
        if(Auth::changePassword($user["data"]["id"], $pwd)) Session::setFlash('Hasło zostało zmienione.');
        else Session::setFlash("Wystąpił błąd przy zmianie hasła.");
      } else {
        Session::setFlash("Niepoprawne hasło.");
      }

      return $this->redirectTo('/ustawienia');

    } else if(isset($_POST["acdel"])) {
      if(empty($_POST['user']) || empty($_POST["password"]) || $_POST['user'] != $_SESSION['userId']) {
        Session::setFlash("Wystąpił błąd.");
        return $this->redirectTo('/ustawienia');
      }

      $pwd = $_POST["password"];

      $user = DB::selectOne("SELECT * FROM users WHERE id = :id and status = :status", ['id' => $_SESSION["userId"], 'status' => DB::$sActive]);
      if($user['rows'] != 1) {
        Session::setFlash("Użytkownik nie istnieje.");
        return $this->redirectTo('/ustawienia');
      }

      if(Auth::login($user["data"]["login"], $pwd) != null) {
        if(Auth::deleteUser($_SESSION["userId"])) {
          Auth::logout();
          return $this->redirectTo("/");
        } else {
          Session::setFlash("Wystąpił błąd.");
        }
      }

      return $this->redirectTo('/ustawienia');

    } else {
      return $this->abort();
    }
  }

  //TODO nauczyciel może dodawać kategorie - przy dodawaniu kategorii może wybrać zdjęcie fiszek

}