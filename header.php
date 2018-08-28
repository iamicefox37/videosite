<?php
	// session_start();
	include_once "files/get_client_info.php";
	if (isset($_POST['userID'])) {
		$_SESSION['userID'] = $_POST['userID'];
		$_SESSION['name'] = $_POST['name'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['picture'] = $_POST['picture'];
		$_SESSION['accessToken'] = $_POST['accessToken'];
		exit("success");
	}
	if ($_SERVER["SERVER_NAME"] === "localhost" ) {
		$path = "http://".$_SERVER["HTTP_HOST"]."/projects/webclient-videosite";
	} else {
		$path = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	}
?>
<!DOCTYPE html>
<html lang="eng">
	<head>
		<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8"> -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Facebook OpenGraph tags -->
		<meta id="ogSite_name" 			class="og_fb" property="og:site_name" content="Paragonia"/>
		<meta id="ogType" 					class="og_fb" property="og:type" content="article"/>
    <!-- 299001533969350 -->
    <meta id="ogAppId" 					class="og_fb" property="fb:app_id" content="299001533969350"/>

    <?php
      if (isset($_REQUEST['watch']) && isset($_REQUEST['v'])) {
      echo'<meta id="ogUrl" 			class="og_fb" property="og:url" content="'.$path.$_SERVER["PHP_SELF"].'?'.$_SERVER["QUERY_STRING"].'"/>
      <meta id="ogTitle" 			class="og_fb" property="og:title" content="'.$_REQUEST["v"].'"/>
  		<meta id="ogImage" 					class="og_fb" property="og:image" content="'.$path.'/images/thumbnails/'.$_REQUEST["watch"].'/'.$_REQUEST["v"].'.jpg"/>';
      }
    ?>


		<title>Paragonia</title>
		<link rel="icon" href="" type="image/png" sizes="16x16">
		<link rel="stylesheet" href="style.css">
		<?php if (isset($_REQUEST["playlist"])): ?>
			<link rel="stylesheet" href="playlist.css">
		<?php endif; ?>
		<!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href='https://fonts.googleapis.com/css?family=Barrio' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=Baumans' rel='stylesheet'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</head>
	<body>
	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '299001533969350',
	      cookie     : true,
	      xfbml      : true,
	      version    : 'v3.0'
	    });
			FB.getLoginStatus(function(response) {
	    	statusChangeCallback(response);
			});
	  };
		function statusChangeCallback(response){
			if (response.status === 'connected') {
				console.log('Authenticated!');
			} else {
				console.log('Not Authenticated');
			}
		}
		function checkLoginState() {
			FB.getLoginStatus(function(response) {
			  statusChangeCallback(response);
			});
		}
		// var user = {userID: "", name: "", accessToken: "", picture: "", email: ""};
		// function FbLogIn() {
		// 	FB.login(function (response) {
		// 		if (response.status == "connected") {
		// 			user.userID = response.authResponse.userID;
		// 			user.accessToken = response.authResponse.accessToken;
		// 			FB.api('/me?fields=id, name, email, picture.type(large)', function (userData) {
		// 				user.name = userData.name;
		// 				user.email = userData.email;
		// 				user.picture = user.picture.data.url;
		//
		// 				$.ajax({
		// 					url: "index.php",
		// 					method: "POST",
		// 					dataType: "text",
		// 					success: function (serverResponse) {
		// 						if (serverResponse == "success") {
		// 							window.location = "index.php";
		// 						}
		// 					}
		// 				});
		// 			});
		// 		}
		// 	}, {scope: 'public_profile, email'});
		// }
	</script>
		<div class="content">
			<header>
				<div id="topnav">
					<span id="openSideNav">&#9776;</span>
					<div id="brand">
						<?php
							echo '<a href="'.$path.'"><h3>Paragonia</h3></a>';
						?>
					</div>
					<div id="searchbox">
						<form id="searchForm" action="" method="post">
	            <input id="search" type="search" placeholder="Search" autofocus>
	            <button id="run" type="submit" onclick="searchVideo()"><i class="fa fa-search"></i></button>
	          </form>
					</div>
					<!-- <fb:login-button
						scope="public_profile,email"
						onlogin="checkLoginState();">
					</fb:login-button> -->
					<!-- <button type="button" name="button" onclick="FbLogIn()">Log in with facebook</button> -->
				</div>
			</header>
			<div id="sideNav" class="sidenav">
					<!-- <span id="closeSideNav"><a href="javascript:void(0)" class="closebtn">&times;</a></span> -->
					<div id="posts">
						<!-- <span>Connect</span>
						<span>Blog</span> -->
					</div>
					<nav>
						<ul id="playlists">
							<?php
								echo '
								<li><img class="icons" src="'.$path.'/images/icons/hilarious.svg"><a class="listLink" href="'.$path.'?playlist=funny">Funny</a></li>
								<li><img class="icons" src="'.$path.'/images/icons/lion-face-outlined-front.svg"><a class="listLink" href="'.$path.'?playlist=Got Talents">Got Talents</a></li>
								<li><img class="icons" src="'.$path.'/images/icons/trending.svg"><a class="listLink" href="'.$path.'?playlist=Compassion">Compassion</a></li>';
							?>

								<!--<li><img class="icons" src="'.$path.'/images/icons/passage-of-time.svg"><a class="listLink" href="'.$path.'?playlist=latest">Latest</a></li>
								<li><img class="icons" src="'.$path.'/images/icons/top-games-star.svg"><a class="listLink" href="'.$path.'?playlist=most-popular">Most-Popular</a></li>
								<li><img class="icons" src="'.$path.'/images/icons/walrus-head-frontal-outline.svg"><a class="listLink" href="#">Ridiculous</a></li> -->
							<!-- <li><img class="icons" src="images/icons/"><a class="listLink" href="#">Favourites</a></li> -->
						</ul>
					</nav>
					<!-- <button type="submit" name="accept" id="accept" class="btn btn-default"></button> -->
			</div>