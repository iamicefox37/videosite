
<!DOCTYPE html>
<html lang="eng" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Text PHP</title>
    <style>
      .main {
        width: 640px;
        margin: auto;
        min-height: 480px;
      }
      * {
        margin: 0;
        padding: 0;
        border: .8px solid #555;
      }

    </style>
  </head>
  <body>
    <div class="main">
      <?php
      echo '<form action="" method="post">
              <input type="text" name="file_text_name" value="" placeholder="file name..."><span>.txt</span><br><br>
              <textarea name="file_text" rows="8" cols="50" placeholder="write sth..."></textarea><br><br>
              <input type="submit" name="save" value="Save"><br><br>
            </form>';

      if (isset($_POST["save"])) {
        $dir = "files/";
        $file_name = trim($_POST["file_text_name"]);
        $file_value = $_POST["file_text"];

        // The full path of the file
        $path = $dir.$file_name.".txt";

        //To write/edit file
        $file_a = fopen($path, "a") or die("cannot write");
        fwrite($file_a, $file_value."\n");

        // To read and echo the file content
        $file_r = fopen($path, "r") or die("cannot read");
        echo "<h3>".$file_name."</h3>";
        echo "<p>";
          while(!feof($file_r)) {
            echo fgets($file_r). "<br>";
          }
        echo "</p>";

        fclose($file_a);
      }

      ?>
    </div>
  </body>
</html>
