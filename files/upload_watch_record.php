<?php
// include_once "includes/dbh.inc.php";
include_once "get_client_info.php";
if ($conn) {
  //Log watch records to the database
  if (isset($_REQUEST['id'])) {
    $vidId = $_REQUEST['id'];
    $visitorId = $_SESSION["videositeSessionId"];

    $checkEntry = "SELECT * FROM watch_records WHERE vid_id = '$vidId' AND visitor_id = '$visitorId'";
    $entryResult = $conn->query($checkEntry);
    if ($entryResult->num_rows == 0 ) {
      $newWatchEntry = "INSERT INTO watch_records (vid_id, visitor_id) VALUES ('$vidId', '$visitorId')";
      $conn->query($newWatchEntry) === true;
    }
    // Get video total views
    $countQuery = "SELECT vid_id FROM watch_records WHERE vid_id = '$vidId'";
    $countRes = $conn->query($countQuery);
    $totalViews = $countRes->num_rows;
    echo $totalViews;
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
