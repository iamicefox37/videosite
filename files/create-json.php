
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
        include_once('includes/dbh.inc.php');
        // Create JSON file if the file doesn't exist
        // If file exist, append only info for new videos
        if (isset($_REQUEST["file"])) {
          $dir = $_REQUEST["file"];
        } else {
          header("Location: ".$_SERVER['PHP_SELF']."?file=exampleName");
          break;
        }
        $fpath = "watch-".$dir.".json";
        $file = fopen($fpath, "w");
        echo $fpath."<br>";

        // $_obj=array();
        $i = 0;
        $sql = "SELECT * FROM video_absolute_data WHERE vid_dir LIKE '%$dir%' ORDER BY vid_name";
	      $query = $conn->query($sql);
	      $numRows = $query->num_rows;
        if ($numRows > 0) {
          fwrite($file, "[");
          while ($row = $query->fetch_assoc()) {
            $_id = $row["vid_id"];
            $_ext = $row["vid_ext"];
            $_name = $row["vid_name"];
            $_date = $row["vid_date"];
            $_size = $row["vid_size"];
            $_dir = $row["vid_dir"];
            $_time = $row["vid_time"];
            $img_url = $row["img_url"];
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
            if ($i<$numRows-1) {
              fwrite($file, $_info.",\n");
              $i++;
            } else {
              fwrite($file, $_info."\n]");
              break;
            }
          }
        } else {
          echo "Sorry, the directory \"".$dir."\" doesn't exist.";
        }

        fclose($file);
        //Display the json data
        $file = fopen($fpath, "r");
        while (!feof($file)) {
          echo fgets($file)."<br>";
        }
      ?>
    </div>
  </body>
</html>
