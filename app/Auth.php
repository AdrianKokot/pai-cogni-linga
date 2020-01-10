<?php
class Auth {
  // rejestracja nowego użytkownika
  public static function register($login, $password, $code = null) {
    $role = DB::selectOne("SELECT role FROM register_codes WHERE code = '$code'")["data"][0] ?? DB::selectOne("SELECT id FROM role WHERE name = 'user'")["data"][0];
    $status = DB::selectOne("SELECT id FROM status WHERE name = 'active'")["data"][0];

    $enc_password = password_hash($password, PASSWORD_ARGON2ID);
    $id = DB::insert("INSERT INTO user (login, password, role, status) VALUES (:login, :password, $role, $status)", ["login" => $login, "password" => $enc_password]);

    return [
      'role' => $role, //id roli
      'status' => $status, //id statusu
      'id' => $id //id uzytkownika
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