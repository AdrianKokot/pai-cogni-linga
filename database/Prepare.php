<?php

require_once 'Connection.php';

function DBInsertData() {
  DB::insert("INSERT INTO status (`name`) VALUES ('active'), ('deleted')");
  DB::insert("INSERT INTO role (`name`) VALUES ('user'), ('admin')");
  DB::insert("INSERT INTO language (`lang`) VALUES ('angielski'), ('polski')");
  DB::insert("INSERT INTO category (`name`) VALUES ('informatyka')");
  DB::insert("INSERT INTO visibility (`name`) VALUES ('prywatny'), ('publiczny')");
}