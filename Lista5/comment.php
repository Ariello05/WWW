<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST" and isset($_SESSION["username"])) {
  $db = new PDO("sqlite:./app.db");
  $user = $_SESSION["username"];
  $article_id = $_POST["article"];
  $content = $_POST["content"];

  $stmt = $db->query(
    "INSERT INTO comments VALUES ('$article_id', '$user', '$content')"
  );

  header("location:javascript://history.go(-1)");
  exit();
}
