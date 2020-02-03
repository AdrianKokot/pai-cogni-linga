<?php

require_once 'Connection.php';

function DBInsertData() {
  DB::insert("INSERT INTO statuses (`name`) VALUES ('active'), ('deleted')");
  DB::insert("INSERT INTO roles (`name`) VALUES ('user'), ('admin')");
  DB::insert("INSERT INTO languages (`lang`) VALUES ('angielski'), ('polski'), ('niemiecki')");
  DB::insert("INSERT INTO categories (`name`) VALUES ('informatyka'), ('jedzenie'), ('podróże')");
  DB::insert("INSERT INTO register_codes VALUES ('admin', 2)");
  DB::insert("INSERT INTO visibilities (`name`) VALUES ('prywatny'), ('publiczny')");
}