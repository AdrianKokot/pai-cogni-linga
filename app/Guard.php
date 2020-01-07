<?php


class Guard {
  public static function getRole($id) {
    return DB::selectOne("SELECT name FROM role WHERE id = $id")['data'][0];
  }
  public static function getStatus($id) {
    return DB::selectOne("SELECT name FROM status WHERE id = $id")['data'][0];
  }

  public static function checkAccess($role, $rolesArr) {
    return in_array($role,$rolesArr) && ($_SESSION['status'] ?? 'active') == 'active';
  }
}