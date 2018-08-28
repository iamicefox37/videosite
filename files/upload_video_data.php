
<!DOCTYPE html>
<html lang="eng" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Upload Video Data</title>
    <style>
      .main {
        width: 640px;
        margin: auto;
      }
      * {
        margin: 0;
        padding: 0;
        border: .8px solid #555;
      }
      .videobox {
        position: relative;
      }
      .slidevideo {
        width: 240px;
        /* height: 135px;*/
        height: auto;
      }
      .videobox h4 {
        font-size: 16px;
        width: 360px;
        height: 65px;
        position: absolute;
        top: 35px;
        right: 20px;
      }

    </style>
  </head>
  <body>
    <div class="main">
      <?php
        //Connect to the database
        include_once('includes/dbh.inc.php');
        //Get the playlist name
        if ($_SERVER["SERVER_NAME"] === "localhost" ) {
      		$path = "http://".$_SERVER["HTTP_HOST"]."/projects/webclient-videosite";

      	} else {
      		$path = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . $_SERVER["PHP_SELF"];
      	}
        if (isset($_GET["playlist"])) {
          $playlist = $_GET["playlist"];
        } else {
          header("Location: ".$path."?playlist=latest");
        }        
        //videos and video directory
        $dir = "../videosite/watch/".$playlist."/";
        $videos= scandir($dir);
        //getID3
        include_once('../getID3-master/getid3/getid3.php');
        $getID3 = new getID3;
                
        $i = 0;
        // $_obj=array();;
        while ($i<sizeof($videos)) {
          $finfo = finfo_open(FILEINFO_MIME_TYPE);
          $mime_type = finfo_file($finfo, $dir.$videos[$i]);
          if (preg_match('/video\/*/', $mime_type)) {
            // Get the duration of the video
            $video = $getID3->analyze($dir.$videos[$i]);
            // $_dir = $video['filepath'];
            $_time = $video['playtime_string'];
            // Get id, extension, name, date, size, and directory of video
            $vid = $videos[$i];
            $_id = date("ymdhis", filemtime($dir.$vid));
            $_ext = strtolower(pathinfo($vid, PATHINFO_EXTENSION));
            $_name = (trim(basename($vid, ".".$_ext)));
            //Escape the string to upload on the database
            $_name = mysqli_real_escape_string($conn, $_name);
            // $_date = date("Y-m-d", filemtime($dir.$vid));
            $_date = date("Y-m-d");
            $_size = filesize($dir.$vid);
            $_dir = dirname($dir.$vid);
            $img_url = "../images/thumbnails/".strtolower($playlist)."/$_name.jpg";            

            // $_name = split("''", $_name);
            // $_name = join("''''", $_name);
            // Create table to store the data
            // Insert a complete data of a video
            // Apply the logic here
            $checkEntry = "SELECT vid_id FROM video_absolute_data WHERE vid_id = '$_id'";
            $res = $conn->query($checkEntry);
            if ($res->num_rows < 1) {
              $sql = "INSERT INTO video_absolute_data (vid_id, vid_name, vid_ext, vid_dir, img_url, vid_time, vid_size, vid_date) VALUES ('$_id', '$_name', '$_ext', '$_dir', '$img_url', '$_time', '$_size', '$_date')";
              if ($conn->query($sql) === TRUE) {
                echo "<b>Uploaded video: </b>".stripslashes($_name).".<br><br>";
              } else {
                echo "<b>Error uploading: </b>".stripslashes($_name).".<br><em>".$conn->error."</em><br><br>";
              }
            } else {
              echo "<b><em>Already uploaded: </em></b>".stripslashes($_name).".<br><br>";
            }
            $i++;

          } else {
            $i++;
          }
        }
        echo "<h4>Completed</h4>";
      ?>
    </div>
  </body>
</html>
