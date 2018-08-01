<?php
	include_once "header.php";
?>
<div class="header-slider-wrap" style="display: none">
  <div class="header-slider">
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
						}

					?>
				</div>
		</div>
<?php
	include_once "footer.php";
?>
