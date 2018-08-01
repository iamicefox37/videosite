
<!DOCTYPE html>
<html lang="eng" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Video PHP</title>
    <meta id="ogSite_name" 			class="og_fb" property="og:site_name" content="Paragonia"/>
		<meta id="ogType" 					class="og_fb" property="og:type" content="article"/>
    <!-- 299001533969350 -->
    <meta id="ogAppId" 					class="og_fb" property="fb:app_id" content="299001533969350"/>


    <?php
      $path = (isset($_SERVER["HTTPS"]) ? "https:" : "http") . "://$_SERVER[HTTP_HOST]";
      if (isset($_REQUEST['q']) && isset($_REQUEST['v'])) {
      echo'<meta id="ogUrl" 			class="og_fb" property="og:url" content="'.$path.$_SERVER["PHP_SELF"].'?'.$_SERVER["QUERY_STRING"].'"/>
      <meta id="ogTitle" 			class="og_fb" property="og:title" content="'.$_REQUEST["v"].'"/>
  		<meta id="ogImage" 					class="og_fb" property="og:image" content="'.$path.'/images/thumbnails/'.$_REQUEST["q"].'/'.$_REQUEST["v"].'.jpg"/>';
      }
    ?>

    <style>
      .main {
        width: 640px;
        margin: auto;
        border: .8px solid #555;
      }
      * {
        margin: 0;
        padding: 0;
      }
      #videoplay {
        width: 100%;
      }
      .videos {
        position: relative;
        height: 135px;
        overflow: hidden;
        background-color: rgba(10,10,10,0.1);
      }
      .videos img {
        width: 240px;
        /* height: 135px;*/
        position: absolute;
        left:0;
        top: 0;
        cursor: pointer;
      }
      .videos h4 {
        font-size: 16px;
        width: 360px;
        /* height: 65px; */
        position: absolute;
        top: 35px;
        right: 20px;
        cursor: pointer;
      }

    </style>
  </head>
  <body>
    <div class="main">
      <?php
        $pageUrl = (isset($_SERVER['HTTPS']) ? "https:" : "http") . "://$_SERVER[HTTP_HOST]" . $_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"];
        echo '<div id="shareFB" class="fb-share-button"
        data-href="'.$pageUrl.'"
        data-size="small"
        data-mobile_iframe="true"
        data-layout="button">

      </div>';
      ?>

      <script type="text/javascript">
      // Share the current link to Facebook
      document.getElementById("shareFB").setAttribute("data-href", location.href);
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=299001533969350&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

      </script>
      <div class="section1">
        <?php
        // include_once "files/get_client_info.php";
        // include_once "files/upload_watch_record.php";

        if (isset($_GET['q']) && isset($_GET['v'])) {
          echo '<video controls id="videoplay" src="videosite/watch/'.$_GET["q"].'/'.$_GET["v"].'.mp4" autoplay></video>';
        } else {
          $dir = "videosite/watch/latest/";
          $vid = scandir($dir);
          echo '<video controls id="videoplay" src="'.$dir.$vid[2].'"></video>';
        }
      ?>
      </div>
    </div>

    <script type="text/javascript">
      //DOM References
      var main = document.getElementsByClassName("main");
      var videoplay = document.getElementById("videoplay");
      url = ["files/watch-funny.json", "files/watch-most-popular.json", "files/watch-latest.json"]
      fetch(url[0])
      .then((res) => res.json())
      .then((data) => {
        videoData(data);
        return fetch(url[1]);
      })
      .then((res) => res.json())
      .then((data) => {
        videoData(data);
        return fetch(url[2]);
      })
      .then((res) => res.json())
      .then((data) => {
        videoData(data);
        playlist();
      })
      .catch((err) => {
        console.log(err);
      });

      var videoId = [];
      var videodir = [];
      var videonames = [];
      var videoext = [];
      // var videolinks = [];
      var imglinks = [];
      function videoData(xhttp) {
        // var obj = JSON.parse(xhttp.responseText);
        var obj = xhttp;
        for (t=0; t<obj.length; t++) {
          videoId.push(obj[t].vid_id);
          videonames.push(obj[t].vid_name);
          // videolinks.push(obj[t].vid_dir.replace("../", "")+"/"+obj[t].vid_name+"."+obj[t].vid_ext);
          videodir.push(obj[t].vid_dir.replace("../videosite/watch/", ""));
          videoext.push(obj[t].vid_ext);
          imglinks.push(obj[t].img_url.replace("../", ""));

        }
      }
      function make_videoplay() {
        main[0].innerHTML = '<video id= "videoplay" controls>'+ '<source src="" type="video/mp4"></source>' + '</video>';
        document.querySelector("#videoplay source").setAttribute("src", video_dir[0].replace("../videosite/watch/latest", ""));
      }
      function playlist() {
        var makediv = document.createElement("div");
        makediv.className = "playlist-container";
        // Display the elements in html
        main[0].appendChild(makediv);
        // makediv.insertAdjacentElement("afterbegin", makeul);
        for (var i = 0; i < videonames.length; i++) {
          imgbox = '<img class="thumbnails" src="'+imglinks[i]+'">';
          videobox =
            '<div class="videos">' +
                imgbox +
                '<h4>'+videonames[i]+'</h4>' +
            '</div><br>';
          makediv.innerHTML += videobox;
        }
      }
      var newsearch = "";
      var videos = document.getElementsByClassName("videos");
      window.onclick = function (e) {
        for (i = 0; i < videos.length; i++) {
          if (e.target == videos[i].querySelector("img") || e.target == videos[i].querySelector("h4")) {
            newsearch = "q="+escape(videodir[i])+"&v="+escape(videonames[i]);
            loadVideo(newsearch);
            updateURL(newsearch);
          }
        }
      }
      function getVideo(search) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              console.log(this.responseText);
              document.getElementById("videoplay").parentElement.innerHTML = this.responseText;
            }
        };
        //call async to get the video
        xmlhttp.open("GET", "tests.php?"+search, true);
        xmlhttp.send();
      }
      function updateURL(params) {
        if (history.pushState) {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+params;
            window.history.pushState({page:newurl},'new page','?'+params);
        } else {
          location.search = '?'+params;
        }
      }
      function loadVideo(v) {
        scrollToVideo();
        getVideo(v);
        document.getElementById("shareFB").setAttribute("data-href", location.href);
      }
      function scrollToVideo () {
        // var scrollTo = document.getElementById("videoplay").offsetTop;
        window.scroll({
          top: 0,
          left: 0,
          behavior: 'smooth'
        })
      }
      window.onpopstate = function () {
        newsearch = location.search.replace("?", "");
        loadVideo(newsearch);
      }
    </script>
  </body>
</html>
