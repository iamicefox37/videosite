<div class="box">
  <h3>Latest</h3>
  <div class="videoslides-container">
    <?php
      include_once "files/get_client_info.php";
      $i = 0;
      $sql = "SELECT * FROM video_absolute_data WHERE vid_dir LIKE '%latest%' ORDER BY vid_name";
      $query = $conn->query($sql);
      $numRows = $query->num_rows;
      while ($row = $query->fetch_assoc()) {
        // Get the image, name, and date of the video
        $imgUrl = str_replace("../", "", $row["img_url"]);
        $name = $row["vid_name"];
        $date = $row["vid_date"];

        // Get video total views
        $vidId = $row["vid_id"];
        $countQuery = "SELECT vid_id FROM watch_records WHERE vid_id = '$vidId'";
        $countRes = $conn->query($countQuery);
        $totalViews = $countRes->num_rows;

        $imgBox = '<div class="videobox">
                        <a><img class="slidevideo" src="'.$imgUrl.'" alt="Image of the video"></a>
                      <div class="text">
                        <h4>'.$name.'</h4>
                        <span class="dateposted">'.$date.'</span><i class="fa views">&#xf06e; '.$totalViews.'</i>
                      </div>
                    </div>';

        if ($i%4 == 0) {
          echo '<div class="videoboxwrap">';
            echo $imgBox;
            if ($i == $numRows - 1) {
              echo '</div>';
              break;
            }
          $i++;

        }	else if ($i%4 < 3) {
          echo $imgBox;
          if ($i == $numRows - 1) {
            echo '</div>';
            break;
          }
          $i++;
        }	else {
            echo $imgBox;
          echo '</div>';
          $i++;
        }
      }
    ?>
  </div>
  <span class="prev">&#10094;</span>
  <span class="next">&#10095;</span>
</div>
