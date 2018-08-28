<?php
	include_once "../header.php";
?>
	<script type="text/javascript">

	</script>
	<div class="main">
		<div id="video-all-wrapper" class="section1 section">
			<div class="backgroundImage_section1">
				<!-- image added with javascript -->
			</div>
			<div id="videobox" class="box1 box">
				<div id="videoplaybox" class="box1-section1 fade">
						<video id="videoplay" class="fade" autoplay autobuffer>
							<!-- <source type="video/mp4"> -->
						</video>
					<i id="playpauseOverlay" class="fa fa-play-circle"></i>

					<div class="sliders">
						<button id="previous" class="slideBtn" onclick="slideVideo(-1)"><i class="fa fa-chevron-left"></i></button>
						<button id="next" class="slideBtn" onclick="slideVideo(1)"><i class="fa fa-chevron-right"></i></button>
					</div>
					<div class="controls">
						<button id="playpause" class="controlboxbtn"><i id="playpause_i" class="fa fa-pause"></i></button>
						<div class="soundbox">
							<button id="sound" class="controlboxbtn"><i id="sound_i" class="fa fa-volume-up"></i></button>
							<div class="volumesliderBox">
								<span id="volProgress"></span>
								<input id="volumeslider" type="range" min="0" max="100" step="1">
							</div>
						</div>
						<div class="videosliderbox">
							<span id="vidProgress"></span>
							<input id="videoslider" type="range" min="0" max="100" step="0.5">
						</div>
						<div class="timetext">
							<span id="curtimetext">00:00</span> / <span id="durtimetext">00:00</span>
						</div>
						<button id="zoom" class="controlboxbtn"><i id="zoom_i" class="fa fa-expand"></i></button>
					</div>
				</div>
				<div id="videoplayinfo" class="box1-section2">
					<span id="videoplayName"></span>
					<!-- <span id="shareFB" class="fa fa-facebook">&nbsp;&nbsp;Share on Facebook</span> -->
					<div id="shareFB" class="fb-share-button"
				    data-href=""
						data-size="small"
						data-mobile_iframe="true"
				    data-layout="button">

				  </div>
					<div id="videoDBInfo">
						<span class="vidDate"></span><span class="vidViews"></span>
					</div>
				</div>
			</div>
			<div id="playlist" class="box2 box">
				<?php

					if ($_SERVER["QUERY_STRING"]) {
						if (isset($_REQUEST["watch"])) {
							// $q = $_REQUEST["watch"];
							// $watch = "../images/thumbnails/";
							// $d = array("latest", "most-popular", "funny");
							// $d = scandir($watch);
							// if ($q == $d[0] || $q == $d[1] || $q == $d[2]) {
							// 	$dir = $q;
							// }	else {
							// 	$dir = "latest";
							// }
							$dir = $_REQUEST["watch"];
						} else {
							$dir = "latest";
						}
					} else {
						$dir = "latest";
					}
					$sql = "SELECT * FROM video_absolute_data WHERE vid_dir LIKE '%$dir%' ORDER BY vid_name";
		      $query = $conn->query($sql);
		      $numRows = $query->num_rows;
		      while ($row = $query->fetch_assoc()) {
		        // Get the image, name, date, and extension of the video
		        $imgUrl = $row["img_url"];
		        $name = $row["vid_name"];
		        $date = $row["vid_date"];
						$ext = $row["vid_ext"];
		        // Get video total views
				$vidId = $row["vid_id"];
				$countQuery = "SELECT vid_id FROM watch_records WHERE vid_id = '$vidId'";
				$countRes = $conn->query($countQuery);
				$totalViews = $countRes->num_rows;

					// Videolink
				    $vidLink = "#".$name.".".$ext;
							echo '<div class="video-container">
								<div class="videobox">
									<a><img class="videos" src="'.$imgUrl.'"></a>
								</div>
									<p class="videoname">'.$name.'<br><br><span class="vidDate">'.$date.'</span><br><span class="vidViews">'.$totalViews.'</span></p>
							</div>';
					}
				?>
			</div>
		</div>
	</div>


<?php
	include_once "../footer.php";
?>
