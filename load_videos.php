<?php
require_once "files/includes/dbh.inc.php";
function loadVideo($conn, $vid) {
  echo '
  <div class="box">
    <h3>'.$vid.'</h3>
    <div class="videoslides-container">
      <div class="videoboxwrap">';
    $vid = strtolower($vid);
    $i = 0;
    $sql = "SELECT * FROM video_absolute_data WHERE vid_dir LIKE '%$vid%' ORDER BY vid_name";
    $query = $conn->query($sql);
    $numRows = $query->num_rows;
    while ($row = $query->fetch_assoc()) {
      // Get the image, name,date, and extension of the video
      $imgUrl = str_replace("../", "", $row["img_url"]);
      $name = $row["vid_name"];
      $date = $row["vid_date"];
      $ext = $row["vid_ext"];
      $vid_dir = $row["vid_dir"];

      // Get video total views
      $vidId = $row["vid_id"];
      $countQuery = "SELECT vid_id FROM watch_records WHERE vid_id = '$vidId'";
      $countRes = $conn->query($countQuery);
      $totalViews = $countRes->num_rows;

      // Videolink
      // $vidLink = "videosite/?watch=".$vid."&v=".$name.".".$ext;
      $playlist = str_replace("../videosite/watch/","",$vid_dir);
      $imgBox = '<div class="videobox">
                      <a href="videosite/?watch='.$playlist.'&v="><img class="slidevideo" src="'.$imgUrl.'" alt="Image of the video"></a>
                    <div class="text">
                      <h4>'.$name.'</h4>
                      <span class="dateposted">'.$date.'</span><i class="fa views">&#xf06e; '.$totalViews.'</i>
                    </div>
                  </div>';
      echo $imgBox;
  }
echo ' </div>
    </div>
  <span class="prev" onclick="prevSlide(this)">&#10094;</span>
  <span class="next" onclick="nextSlide(this)">&#10095;</span>
</div>';

}
