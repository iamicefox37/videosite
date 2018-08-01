
<!DOCTYPE html>
<html lang="eng" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create Videos Info JSON PHP</title>
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

        // get array of video files from directory
        // display the videos into the html video boxes

        //videos and video directory
        $dir = "../videosite/watch/funny/";
        $videos= scandir($dir);
        //getID3
        include_once('../getID3-master/getid3/getid3.php');
        $getID3 = new getID3;

        // Create/re-write JSON file
        $fpath = "watch-funny.json";
        $file = fopen($fpath, "w");

        echo $fpath."<br>";
        fwrite($file, "[");

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
            $_name = basename($vid, ".".$_ext);
            $_date = date("d/M/Y", filemtime($dir.$vid));
            $_size = filesize($dir.$vid);
            $_dir = dirname($dir.$vid);
            $img_url = "../images/thumbnails/funny/$_name.jpg";

            $_info =
              "\t{\n\t\t\"vid_id\":\"$_id\", \n\t\t\"vid_name\":\"$_name\", \n\t\t\"vid_ext\":\"$_ext\",\n \t\t\"vid_dir\":\"$_dir\",\n\t\t\"img_url\":\"$img_url\",\n\t\t\"vid_time\":\"$_time\",\n \t\t\"vid_size\":\"$_size\",\n\t\t\"vid_date\":\"$_date\"\n\t}"
            ;
            // Store in JSON file for the video data
            // $_obj->vid_dir = $_dir;
            // $_obj->vid_time = $_time;
            // $_obj->vid_ext = $_ext;
            // $_obj->vid_name = $_name;
            // $_obj->vid_date = $_date;
            // $_obj->vid_size = $_size;
            // $_JSON = json_encode($_obj);
            // echo $_JSON;
            // $i++;
            if ($i<sizeof($videos)-1) {
              fwrite($file, $_info.",\n");
              $i++;
            } else {
              fwrite($file, $_info."\n]");
              break;
            }
          } else {
            $i++;
          }
        }
        fclose($file);
        //Read the file and display
        $file = fopen($fpath, "r");
        while (!feof($file)) {
          echo fgets($file)."<br>";
        }
      ?>
    </div>
  </body>
</html>
