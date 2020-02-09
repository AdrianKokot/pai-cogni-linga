<?php
define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DATABASE", "cognilinga");

class DB {
  private static $db = null;
  public static $vPublicID = null;
  public static $sActive = null;

  public static function configure() {
    self::$db = new PDO('mysql:host='.HOST.';dbname='.DATABASE.'', USER, PASSWORD, [
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ]);

    self::$vPublicID = DB::selectOne("SELECT id FROM visibilities WHERE name = 'publiczny'")['data']['id'];
    self::$sActive = DB::selectOne("SELECT id FROM statuses WHERE name = 'active'")["data"]['id'];
  }

  public static function fillData() {
    if(self::selectOne("SELECT * FROM statuses")["rows"] == 0) {
      require_once 'Prepare.php';
      DBInsertData();
    }
  }

  public static function select($sql, Array $data = []) {
    $query = self::$db->prepare($sql);
    $query->execute($data);
    return [
      'rows' => $query->rowCount(),
      'data' => $query->fetchAll(PDO::FETCH_ASSOC)
    ];
  }

  public static function selectOne($sql, Array $data = []) {
    $query = self::$db->prepare($sql);
    $query->execute($data);
    return [
      'rows' => $query->rowCount(),
      'data' => $query->fetch(PDO::FETCH_ASSOC)
    ];
  }

  public static function insert($sql, Array $data = []) {
    $query = self::$db->prepare($sql);

    // $dataFile = file_get_contents('queries.txt');
    // $dataFile .= "\n\n$sql\n\n";
    // foreach($data as $key => $item) {
    //   $dataFile .= "$key = $item\n";
    // }
    // file_put_contents('queries.txt', $dataFile);
    
    if($query->execute($data))
      return self::$db->lastInsertId();
    return null;
  }

  public static function update($sql, Array $data = []) {
    $query = self::$db->prepare($sql);
    return $query->execute($data);
  }
}