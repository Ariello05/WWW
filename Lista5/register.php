<?php

$username = $_POST["username"];
$password = hash("sha256", $_POST["password"]);

if ($username == "" || $_POST["password"] == "") {
  echo ("Pola nie mogą być puste!");
  header("Location: index.php");
  exit();
}

$db = new PDO('sqlite:./app.db');

$result = $db->query("insert into users (username, password) values ('$username' , '$password');");

header("Location: index.php");
