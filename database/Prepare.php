<?php

require_once 'Connection.php';

function DBInsertData() {
  DB::insert("INSERT INTO status (`name`) VALUES ('active'), ('deleted')");
  DB::insert("INSERT INTO role (`name`) VALUES ('user'), ('admin')");
}