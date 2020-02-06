<?php
class Auth {
  // rejestracja nowego użytkownika
  public static function register($login, $password, $code = null) {
    $role = DB::selectOne("SELECT role FROM register_codes WHERE code = '$code'")["data"]['role'] ?? DB::selectOne("SELECT id FROM roles WHERE name = 'user'")["data"]['id'];

    $enc_password = password_hash($password, PASSWORD_ARGON2ID);
    $id = DB::insert("INSERT INTO users (login, password, role, status) VALUES (:login, :password, $role, :status)", ["login" => $login, "password" => $enc_password, 'status' => DB::$sActive]);

    return [
      'role' => $role, //id roli
      'status' => DB::$sActive, //id statusu
      'id' => $id //id uzytkownika
    ];
  }
  // autoryzacja użytkownika
  public static function login($login, $password) {
    $query = DB::selectOne("SELECT * FROM users WHERE login=:login and status = :status", ['login' => $login, 'status' => DB::$sActive]);
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

  public static function changePassword($id, $password) {
    return DB::update("UPDATE users SET `password` = :pwd WHERE id = :id", ['pwd' => password_hash($password, PASSWORD_ARGON2ID), 'id' =>$id]);
  }

  public static function deleteUser($id) {
    return DB::update("UPDATE users SET `status` = :status WHERE id =:id", ['status' => DB::selectOne("SELECT * FROM statuses WHERE name = 'deleted'")["data"]["id"],'id' => $id]);
  }

  public static function logout() {
    session_destroy();
  }
}