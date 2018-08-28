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
// if (isset($_GET['q']) && isset($_GET['v'])) {
//   echo '<video controls id="videoplay" src="videosite/watch/'.$_REQUEST["q"].'/'.$_REQUEST["v"].'.mp4" autoplay></video>';
// }


// Check if video file is a actual video or fake video
if(isset($_POST["UploadVideoSubmit"])) {
  $uploadOk = 1;
  // Check if file already exists 
  if (isset($_POST["playlist"])) {
    $target_dir = "videosite/watch/" . $_POST["playlist"] . "/";
    $uploadOk = 1;
  } else {
    echo "You haven't chosen a playlist.";
    break;
  }
  
  $vid = $_FILES["vidToUpload"];
  $vidName = basename($vid["name"]);
  $target_file = $target_dir . $vidName;
  $vidType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  print_r($vid); echo "<br>";

  if (isset($_POST["vidName"])) {
    $vidName = $_POST["vidName"];
    $target_file = $target_dir . $vidName . "." . $vidType;
  }

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "File already exists.";
    $uploadOk = 0;
  }
  // Check file size
  if ($vid["size"]/1024 > 200000) {
    echo "Sorry, video size cannot exceed 500MB.";
    $uploadOk = 0;
  }
  // Allow certain file formats
  if($vidType != "mp4") {
    echo "Your file format is " . $vidType . ". ";
    echo "Sorry, your video must be in mp4 format. ";
    $uploadOk = 0;
  }
  @set_time_limit(172800);
  // Check if there is an error
  if ($vid["error"] > 0) {
    echo "Error code: " . $vid["error"] . "<br>";
  } else {
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "<b>Your video was not uploaded.</b>";
    // if everything is ok, try to upload file
    } else {    
      if (move_uploaded_file($vid["tmp_name"], $target_file)) {
          echo "<b>The video '$vidName' has been uploaded.</b>";
      } else {
        echo "<b>Your video was not uploaded.</b>";
      } 
    } 
  }
  

} 

?>