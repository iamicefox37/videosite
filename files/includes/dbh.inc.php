<?php

// $dbServername = "localhost";
// $dbUsername = "id5890464_videosite";
// $dbPassword = "4JsV8@JY";
// $dbName = "id5890464_videosite";

// $dbServername = "localhost";
// $dbUsername = "id6672662_paragonia";
// $dbPassword = "paragonia7GECanfrmsRx";
// $dbName = "id6672662_paragonia_records";

// Database Username root (local computer)
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "wildones88";
$dbName = "videorecords";

// $dbServername = "localhost";
// $dbUsername = "paragpiq_chris";
// $dbPassword = "wildones887GECanfrmsRx";
// $dbName = "paragpiq_videosite";

$conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
  die("Connection failed: ".$conn->connect_error);
}