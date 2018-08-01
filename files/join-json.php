<?php
$dir = "../files/";
$files= scandir($dir);

// Create/re-write JSON file
$fpath = "all-videos.json";
$file = fopen($fpath, "w");

echo $fpath."<br>";
// fwrite($file, "[");

$i = 0;
// $_obj=array();;
while ($i<sizeof($files)) {
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime_type = finfo_file($finfo, $dir.$files[$i]);
  if (preg_match('/text*/', $mime_type)) {
    // fwrite($file, "[");
    echo $files[$i]."  ".$mime_type."<br>";
    // $mime_type;
    // echo $files[$i]."<br>";
  }
  $i++;
}
