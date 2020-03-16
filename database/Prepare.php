<?php

require_once 'Connection.php';

function DBInsertData() {
  DB::insert("INSERT INTO statuses (`name`) VALUES ('active'), ('deleted')");
  DB::insert("INSERT INTO roles (`name`) VALUES ('user'), ('admin'), ('teacher')");
  DB::insert("INSERT INTO languages (`lang`) VALUES ('angielski'), ('polski'), ('niemiecki')");
  DB::insert("INSERT INTO categories (`name`) VALUES ('informatyka')");
  DB::insert("INSERT INTO register_codes VALUES ('admin', 2), ('teacher', 3)");
  DB::insert("INSERT INTO visibilities (`name`) VALUES ('prywatny'), ('publiczny')");
}