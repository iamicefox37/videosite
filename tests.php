<?php
// echo "Your Input:\n";
//
// echo '<div class="results">';
// if (isset($_GET['v'])) {
//   echo '<p>You: <span>'.$_GET['v'].'</span></p>';
// }
// else {
//   echo 'Couldn\'t get the name';
// }

// echo '</div>';
if (isset($_GET['q']) && isset($_GET['v'])) {
  echo '<video controls id="videoplay" src="videosite/watch/'.$_REQUEST["q"].'/'.$_REQUEST["v"].'.mp4" autoplay></video>';
}
