<?php

// $dbServername = "localhost";
// $dbUsername = "id5890464_videosite";
// $dbPassword = "4JsV8@JY";
// $dbName = "id5890464_videosite";

// Database Username root (local computer)
// $dbServername = "localhost";
// $dbUsername = "root";
// $dbPassword = "wildones88";
// $dbName = "videosite";

$dbServername = "localhost";
$dbUsername = "paragpiq_chris";
$dbPassword = "wildones88paragpiq";
$dbName = "paragpiq_videosite";

$conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
  die("Connection failed: ".$conn->connect_error);
}
