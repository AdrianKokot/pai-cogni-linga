<?php
define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DATABASE", "cognilinga");

class DB {
  private static $db = null;
  public static function configure() {
    self::$db = new PDO('mysql:host='.HOST.';dbname='.DATABASE.'', USER, PASSWORD, [
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ]);
  }

  public static function fillData() {
    require_once 'Prepare.php';
    DBInsertData();
  }

  public static function select($sql, Array $data = []) {
    $query = self::$db->prepare($sql);
    $query->execute($data);
    return [
      'rows' => $query->rowCount(),
      'data' => $query->fetchAll()
    ];
  }

  public static function selectOne($sql, Array $data = []) {
    $query = self::$db->prepare($sql);
    $query->execute($data);
    return [
      'rows' => $query->rowCount(),
      'data' => $query->fetch()
    ];
  }

  public static function insert($sql, Array $data = []) {
    $query = self::$db->prepare($sql);
    $query->execute($data);
    return self::$db->lastInsertId();
  }
}