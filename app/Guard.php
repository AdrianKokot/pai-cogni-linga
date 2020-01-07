<?php


class Guard {
  public static function getRole($id) {
    $db = DB();
    return $db->query("SELECT name FROM role WHERE id = $id")->fetch()[0];
  }
  public static function getStatus($id) {
    $db = DB();
    return $db->query("SELECT name FROM status WHERE id = $id")->fetch()[0];
  }
}