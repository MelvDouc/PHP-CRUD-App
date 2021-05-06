<?php

try {
  $host = "localhost";
  $db_name = "crud";
  $user = "root";
  $password = "";

  $db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $user, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = file_get_contents("users.sql");
  $db->exec($query);
} catch (PDOException $e) {
  echo $e->getMessage();
}
