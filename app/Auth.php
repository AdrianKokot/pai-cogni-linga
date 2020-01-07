<?php
class Auth {
  // rejestracja nowego użytkownika
  public static function register($login, $password, $code = null) {
    $db = DB();
    $role = $db->query("SELECT role FROM register_codes WHERE code = '$code'")->fetch()[0] ?? $db->query("SELECT id FROM role WHERE name = 'user'")->fetch()[0];
    $status = $db->query("SELECT id FROM status WHERE name = 'active'")->fetch()[0];

    $query = $db->prepare("INSERT INTO user (login, password, role, status) VALUES (:login, :password, $role, $status)");
    $query->bindParam("login", $login, PDO::PARAM_STR);
    $enc_password = password_hash($password, PASSWORD_ARGON2ID);
    $query->bindParam("password", $enc_password, PDO::PARAM_STR);
    $query->execute();
    return [
      'role' => $role, //id roli
      'status' => $status, //id statusu
      'id' => $db->lastInsertId() //id użytkownika
    ];
  }
  // autoryzacja użytkownika
  public static function login($login, $password) {
    $query = DB::selectOne("SELECT * FROM user WHERE login=:login", ['login' => $login]);
    if ($query['rows'] > 0) {
        $result = $query['data'];
        if(password_verify($password, $result['password'])){
            return [
              'role' => $result['role'],
              'status' => $result['status'],
              'id' => $result['id']
            ];
        } else {
            return null;
        }
    } else {
        return null;
    }
  }

  public static function logout() {
    session_destroy();
  }
}