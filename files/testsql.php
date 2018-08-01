<?php
include_once('includes/dbh.inc.php');


//Get the video data
$_id= 15104426;
$_name="test";
$_ext="mp4";
$_dir="../videosite/watch/latest";
$img_url="../thumbnails/latest/test.jpg";
$_time= date("h:i:sa");
$_size= 7819114;
$_date= date("Y/m/d");


//Get the IP ADDRESS of the user


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

echo getRealIpAddr();
echo "<br>".$_SERVER['SERVER_ADDR'];
echo "<br>".$_SERVER['REMOTE_ADDR'];

// $sql = "INSERT INTO video_absolute_data (vid_id, vid_name, vid_ext, vid_dir, img_url, vid_time, vid_size, vid_date) VALUES ('$_id', '$_name', '$_ext', '$_dir', '$img_url', '$_time', '$_size', '$_date')";
//
// if ($conn->query($sql) === TRUE) {
//   echo "Video data is successfully uploaded";
// } else {
//   echo "Error: ".$sql."<br><br>".$conn->error;
// }
