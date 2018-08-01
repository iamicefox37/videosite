<?php
	include_once "header.php";
?>
	<div class="header-slider-wrap">
		<div class="header-slider">
			<!-- <div class="header-slides">
				<a><div class="slide-image" style="background-image: url('images/thumbnails/header-videos/BatmanNinja.jpg')">
					<span>BatmanNinja</span>
				</div></a>
			</div> -->
			<?php
				$dir = "images/thumbnails/header-videos/";
				$img = scandir($dir);
				$i = 0;
				while ($i < sizeof($img)) {
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$mime_type = finfo_file($finfo, $dir.$img[$i]);
					if (preg_match('/jpg|jpeg|png\/*/', $mime_type)) {
						$imageUrl = htmlspecialchars($dir.$img[$i]);
						echo '<div class="header-slides">
							<a><div class="slide-image" style="background-image: url(\''.$imageUrl.'\')">
								<span>'.basename($img[$i], ".jpg").'</span>
							</div></a>
						</div>';
						$i++;
					}	else {
						$i++;
					}
				}
			?>
		</div>
	</div>
		<div class="main">
				<div class="boxWrap">
					<?php
						include_once 'load_videos.php';
						if (isset($_REQUEST["playlist"])) {
							$p_list = ucfirst($_REQUEST["playlist"]);
							loadVideo($conn, $p_list);
						} else {
							loadVideo($conn, "Latest");
							loadVideo($conn, "Funny");
							loadVideo($conn, "Most-popular");
							loadVideo($conn, "Got Talents");
							loadVideo($conn, "Compassion");
						}

					?>
				</div>
		</div>
<?php
	include_once "footer.php";
?>
