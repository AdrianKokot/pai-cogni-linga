<?php


class Guard {
  public static function getRole($id) {
    return DB::selectOne("SELECT name FROM roles WHERE id = $id")['data']['name'];
  }
  public static function getStatus($id) {
    return DB::selectOne("SELECT name FROM statuses WHERE id = $id")['data']['name'];
  }

  public static function checkAccess($role, $rolesArr) {
    return in_array($role,$rolesArr) && ($_SESSION['status'] ?? 'active') == 'active';
  }

  public static function isAdmin() {
    return $_SESSION['role'] == "admin";
  }

  public static function getUsername() {
    return DB::selectOne("SELECT login FROM users WHERE id = $_SESSION[userId]")['data']['login'];
  }
}