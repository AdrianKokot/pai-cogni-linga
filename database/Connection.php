<?php
function DB() {
  define("HOST", "localhost");
  define("USER", "root");
  define("PASSWORD", "");
  define("DATABASE", "cognilinga");

  $db = new PDO('mysql:host='.HOST.';dbname='.DATABASE.'', USER, PASSWORD, [
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
  ]);
  return $db;
}