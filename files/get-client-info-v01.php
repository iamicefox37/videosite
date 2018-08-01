<?php
// Get Real IP ADDRESS
date_default_timezone_set("Asia/Singapore");
session_start();
// Simplest way
$ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);


// Using function
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// ----------------Functions to get the client ip address
// Using php environment variables
function get_client_ip_env() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}
// Obtain values from the web server
function get_client_ip_server() {
    $ipaddress = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(!empty($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(!empty($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(!empty($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

// echo get_client_ip_env()
// echo get_client_ip_server();

//Geo location
// $user_ip = getenv('REMOTE_ADDR');
$user_ip = get_client_ip_env();
$date = date("Y/m/d");
$geo = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$user_ip));
$city = $geo["geoplugin_city"];
$region = $geo["geoplugin_regionName"];
$country = $geo["geoplugin_countryName"];
$location = "$city, $region, $country";

include_once "includes/dbh.inc.php";
if ($conn) {
  $checkEntry = "SELECT * FROM visitor_records WHERE visitor_ip = '$user_ip' AND visit_location = '$location'";
  $res = $conn->query($checkEntry);
  if ($res->num_rows < 1) {
    //Upload new visitor data
    $newVisitorEntry = "INSERT INTO visitor_records (visitor_ip, visit_date, visit_location, total_visits) VALUES ('$user_ip', '$date', '$location', 1)";
    if ($conn->query($newVisitorEntry) === true) {
      echo "uploaded to visitor_records";
    } else {
      echo "failed to upload to visitor_records";
    }
  } else {
    $row = $res->fetch_assoc();
    if (!isset($_SESSION["sessionId$user_ip"])) {
      //Update total visit for the sessions
      $_SESSION["sessionId$user_ip"] = $user_ip;
      $totalVisit = $row["total_visits"] + 1;
      $updateEntry = "UPDATE visitor_records SET total_visits = '$totalVisit' WHERE visitor_ip = '$user_ip' AND visit_location = '$location'";
      $conn->query($updateEntry) === true;
      // if ($conn->query($updateEntry) === true) {
      //   echo "updated<br>";
      // } else {
      //   echo "failed to update";
      // }
    }
    //Log watch records to the database
    $visitorId = $row["visitor_id"];
    if (isset($_REQUEST['id'])) {
      $vidId = $_REQUEST['id'];
      $newWatchEntry = "INSERT INTO watch_records (vid_id, visitor_id) VALUES ('$vidId', '$visitorId')";
      $conn->query($newWatchEntry) === true;
      // if ($conn->query($newWatchEntry) === true) {
      //   echo "uploaded to watch_records";
      // } else {
      //   echo "failed to upload to watch_records";
      // }
    }
  }
}
else {
  echo "error: " . $conn->error;
}



// echo $user_ip."<br>".$city."<br>".$region."<br>".$country;Ad-
// echo var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])));
// echo $user_ip;

// $in_addr = inet_pton('127.0.0.1');
// $in6_addr = inet_pton('8ab8:7f70::');
// $ipv4 = hexdec(substr($ipv6, 0, 2)). "." . hexdec(substr($ipv6, 2, 2)). "." . hexdec(substr($ipv6, 5, 2)). "." . hexdec(substr($ipv6, 7, 2));
  // echo "<input type='text' value='$ipv4'>";
