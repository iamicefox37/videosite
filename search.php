<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Search</title>
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- <script src="fuse-master/dist/fuse.js"></script> -->
    <script src="search.js"></script>

  </head>
  <body>
    <header>
      <div id="topnav">
        <span id="openSideNav">&#9776;</span>
        <div id="brand">
          <a href="https://ilovemyanmar.000webhostapp.com/index.php"><h3>Parogama</h3></a>
        </div>
        <div id="searchbox">
          <form id="searchForm" action="" method="post">
            <input id="search" type="search" placeholder="Search" autofocus>
            <button id="run" type="submit" onclick="changeHash()"><i class="fa fa-search"></i></button>
          </form>
        </div>
      </div>
    </header>
    <div class="content">
      <div class="main">
        <div class="results">
          <h4>Search for a video</h4>
        </div>
      </div>      
    </div>


    <script src="search.js"></script>
  </body>
</html>
