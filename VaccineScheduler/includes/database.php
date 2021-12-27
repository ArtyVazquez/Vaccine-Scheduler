<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpwd = "root";
$dbname = "vaccineuih";

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpwd, $dbname);
// Check connection
if ($conn->connect_error) {
  echo "<p>ERROR</p>";
}
 ?>
