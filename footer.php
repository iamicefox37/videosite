
  <footer>
    <div class="footer">
      <h4>&copy; Copyright Paragonia </h4>
    </div>
  </footer>
</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="script.js"></script>
    <?php if (empty($_REQUEST["playlist"])): ?>
			<script src="run-slider.js"></script>
    <?php elseif (isset($_REQUEST["playlist"])): ?>
      <script src="playlist.js"></script>
		<?php endif; ?>
    <?php echo '<script src="'.$path.'/header.js"></script>'; ?>

    <span></span><span></span><span></span><span></span>
    <script type="text/javascript">
    // window.onload = function () {
    //   //Remove the logo
    //   document.body.lastElementChild.previousElementSibling.previousElementSibling.style.display = "none";
    //   document.body.lastElementChild.previousElementSibling.style.display = "none";
    //   document.body.lastElementChild.style.display = "none";
    //   document.body.lastElementChild.previousElementSibling.style.cssText = "display: none";
    // }
    </script>
	</body>
</html>
