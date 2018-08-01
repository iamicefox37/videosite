<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PHP Thumbnail Generator</title>

    <style>
      body {
        padding: 0;
        margin: 0;
        background-color: rgba(25,25,25,1);
      }
      .main {
        color: #ddd;
        width: 640px;
        margin: auto;

      }
    </style>
  </head>
  <body>
    <!-- echo $_SERVER["PHP_SELF"]  -->
    <!-- <form action="<?php ?>" method="post" enctype="multipart/form-data">
      <input type="file" name="file"><input type="submit" name="submit" value="Upload">
    </form> -->
    <div class="main">
      <?php
        //Get the playlist name
        if ($_SERVER["SERVER_NAME"] === "localhost" ) {
      		$path = "http://".$_SERVER["HTTP_HOST"]."/projects/webclient-videosite";
      	} else {
      		$path = (isset($_SERVER['HTTPS']) ? "https:" : "http") . "://$_SERVER[HTTP_HOST]" . $_SERVER["PHP_SELF"];
      	}
        if (isset($_GET["playlist"])) {
          $playlist = $_GET["playlist"];
        } else {
          headers("Location: ".$path."?playlist=latest");
        }
        // if (isset($_POST['submit'])) {
        $dir = "C:/Xampp/htdocs/Projects/webclient-videosite";
        $ffmpeg = "$dir/ffmpeg/bin/ffmpeg.exe";

        //---directory of the videos to make images/thumbnails from
        $vid_dir = "videosite/watch/".$playlist."/";
        $vid= scandir($vid_dir);

        //---thumbnail directory
        $img_dir = "images/thumbnails/".$playlist."/";
        $img = scandir($img_dir);
        // $videoFile = "$dir/$vid_dir/BatmanNinja.mp4";
        $i=2;

        while ($i < sizeof($vid)) {
          //Get the video name
          $videoFile = "$dir/$vid_dir/$vid[$i]";
          $_ext = strtolower(pathinfo($videoFile, PATHINFO_EXTENSION));
          $videoName = basename($videoFile, ".".$_ext);

          // $ii=2;
          // while ($ii < sizeof($img)) {
          //   //Get the image name
          //   $imgFile = "$dir/$img_dir/$img[$ii]";
          //   $i_ext = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
          //   $imgName = basename($imgFile, ".".$i_ext);
          //
          //   if ($imgName == $videoName) {
          //     $i++;
          //     echo "$imgName already exists<br>";
          //     break;
          //
          //   } else {
          //     $ii++;
          //   }
          //
          // }
          //---the full path to which the thumbnail will be created
          $newImage = "$dir/$img_dir/$videoName.jpg";

          //Set dimension of the thumnail as desired
          $width = 640;
          $height = 360;
          $size = "$width*$height";
          // $size = "1280x720";
          $getFromSec =3;
          $cmd = "\"$ffmpeg\" -i \"$videoFile\" -an -ss $getFromSec -s $size \"$newImage\"";
          // echo $cmd;

          //run the command in shell
          if (!shell_exec($cmd)) {
            $img_path = str_replace("$dir/", "", $newImage);
            echo '<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"><br>';
          } else {
            echo '<img alt="error" width="120" height="90"><br>';
            echo 'Error creating thumbnail';
          }
          // echo "$videoName is just created<br>";
          $i++;
        }



      // }
      ?>
    </div>
  </body>
</html>
