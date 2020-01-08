<?php
$path = 'count.log';

$file  = fopen($path, 'r');
$count = fgets($file, 1000);
fclose($file);
if ($count == 1)
  echo "Strona została odwiedzona raz! \n";
else if ($count > 1)
  echo "Strona została odwiedzona {$count} razy! \n";

$time = new DateTime("now");

if (!isset($_COOKIE["visited"])) {
  $db = new PDO('sqlite:./app.db');

  $ip = "";
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }

  $result = $db->query("select timestamp from ips where ip='$ip'");
  $tab = $result->fetchAll();

  if ($tab != null) {
    $yesterday = new DateTime("yesterday");

    foreach ($tab as $row) {
      $row_datetime = new DateTime($row['timestamp']);

      if ($yesterday > $row_datetime) { #24h passed
        $time_text = $time->format('Y-m-d H:i:s');
        $db->query("update ips set timestamp = '$time_text' where ip ='$ip'");
      } else {
        exit();
      }
    }
  } else {
    $time_text = $time->format('Y-m-d H:i:s');
    $db->query("insert into ips values('$ip','$time_text')");
  }

  $count = abs(intval($count)) + 1;
  $file = fopen($path, 'w');
  fwrite($file, $count);
  fclose($file);
  setcookie("visited", "visited", time() + 24 * 60 * 60, "/");
}
