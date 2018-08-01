// ------------COOKIE CONTROLLERS-------------//


function setCookie(cname, cval) {
  document.cookie= cname + "=" + cval;
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


//--------------MAIN DOM REFERENCES-----------------//
var searchVid = document.getElementById("search");
var run = document.getElementById("run");
var playlist = document.getElementById("playlist");
var videos = document.getElementsByClassName("videos");
// var vidcont = document.getElementsByClassName("video-container");
var videoplay = document.getElementById("videoplay");
var vidName = document.getElementById("videoplayName");
var overlayBtn = document.getElementById("playpauseOverlay");
var controls = document.querySelector(".controls");
var sliders = document.querySelectorAll(".sliderBtn");

// -------------------- VIDEO CONTROLS -------------------//
// DOM Object references
var vid, playBtn, videoslider, soundBtn;
vid = document.getElementById("videoplay");
playBtn = document.getElementById("playpause");
volumeslider = document.getElementById("volumeslider");
videoslider = document.getElementById("videoslider");

volProgress = document.getElementById("volProgress");
soundBtn = document.getElementById("sound");
zoomBtn = document.getElementById("zoom");

// DOM Object events
playBtn.addEventListener("click", playpause, false);
volumeslider.addEventListener("change", setvolume, false);
videoslider.addEventListener("change", videoseek, false);

// volProgress.addEventListener("change", setvolume, false);
vid.addEventListener("timeupdate", seektimeupdate, false);
soundBtn.addEventListener("click", soundonoff, false);
zoomBtn.addEventListener("click", togglefullscreen, false);


// Set a fixed ratio for videoplaybox
var playBox = document.getElementById("videoplaybox");
var marginWidth = videoplaybox.offsetWidth - videoplay.offsetWidth;
function setDimensions() {
  //set the height based on the width
  playBox.style.height = playBox.offsetWidth*(9/16) + "px";
  //Set the position of videoplay in the center
  // marginWidth = videoplaybox.offsetWidth - videoplay.offsetWidth;
  // videoplay.style.marginLeft = marginWidth/2 + "px";

}


window.onresize = function() {
  setDimensions();
}
// ----SearchVideo---------//
function searchVideo() {
  location.href = location.origin + "/projects/webclient-videosite/search.php#"+searchVid.value;
}

// -------------- play the video using set COOKIES ------------ //
volumeslider.value = 100;
videoslider.value = 0;
if(getCookie("volume")) {
  volumeslider.value = getCookie("volume") * 100;
}


// Toggle the control box when mouse enters or leaves
videoplaybox.addEventListener("mouseover", function() {
  controls.classList.add("toggleIn");
  sliders.forEach(function (slider) {
    slider.classList.add("toggleSliders");
  })
  // for (var i = 0; i < sliders.length; i++) {
  //   sliders[i]
  // }
});
videoplaybox.addEventListener("mouseleave", function() {
  controls.classList.remove("toggleIn");
});
controls.classList.add("hidden");
// ---------- playpause the video:
function playpause() {
  var btn_i = document.getElementById("playpause_i");
  //If is the video is playing
  if (!vid.paused) {
    vid.pause();
    vid.classList.add('darken');
    overlayBtn.style.display = "block";
    btn_i.classList.replace('fa-pause', 'fa-play');
    //show the controls
    controls.classList.remove("hidden");
    controls.classList.add("reveal");
    videoplaybox.addEventListener("mouseover", function() {
      controls.classList.remove("toggleIn");
    });

  } else {
      vid.play();
      vid.classList.remove('darken');
      overlayBtn.style.display = "none";
      btn_i.classList.replace('fa-play', 'fa-pause');
      //toggle the controls
      controls.classList.remove("reveal");
      controls.classList.add("hidden");
      videoplaybox.addEventListener("mouseover", function() {
        controls.classList.add("toggleIn");
      });

  }
}

// document.getElementsByClassName("controls")[0].addEventListener("hover", function() {
//   controls.classList.add("toggleIn");
// })
// window.onkeypress = (e) => {
//   var keyVal = e.key;
//   if (keyVal == " ") console.log(keyVal);
//
// }
vid.addEventListener("keypress", function(e) {
  var keyVal = e.key;
  if (keyVal == " ") console.log(keyVal);
})
// ---------- ----------VOLUME:

// ---------- turn sound on or off:
function soundonoff() {
  var btn_i = document.getElementById("sound_i");
  if (!vid.muted) {
    vid.muted = true;
    volumeslider.value = 0;
    btn_i.classList.remove('fa-volume-up');
    btn_i.classList.add('fa-volume-off');
    volProgress.style.width = 0;
  } else {
      vid.muted = false;
      volumeslider.value = getCookie("volume") * 100;
      btn_i.classList.remove('fa-volume-off');
      btn_i.classList.add('fa-volume-up');
      //volume progress effect
      var moveVol = volumeslider.offsetWidth * (volumeslider.value / 100);
      document.getElementById("volProgress").style.width = moveVol + "px";
  }
}
// ----------- adjust volume:
function setvolume() {
  //when user clicks any point along the slider the volume changes
  if (vid.muted) {
    soundonoff();
  }
  var setto = volumeslider.value / 100;
  vid.volume = setto;

  //volume progress effect
  var moveVol = volumeslider.offsetWidth * (volumeslider.value / 100);
  document.getElementById("volProgress").style.width = moveVol + "px";


  setCookie("volume", setto);
  // document.cookie= "volume=" + setto;
}
setvolume();
//volume progress effect
function volProgress() {
  var moveVol = volumeslider.offsetWidth * (volumeslider.value / 100);
  document.getElementById("volProgress").style.width = moveVol + "px";
}

// ---------- skip or reverse video:
function vidProgress() {
  //video progress effect
  var sliderWidthRatio = videoslider.offsetWidth / document.querySelector(".controls").offsetWidth;
  var progressTo = (videoslider.value) * sliderWidthRatio;
  document.getElementById("vidProgress").style.width = progressTo + "%";
}
function videoseek() {
  //when user clicks any point along the slider the current video time changes
  var seekto = vid.duration * (videoslider.value / 100);
  vid.currentTime = seekto;
}
function seektimeupdate() {
  //move the slider thumb as video play
  var slideTo = 100*(vid.currentTime / vid.duration);
  videoslider.value = slideTo;
  vidProgress();
  //display current time against video duration
  var curmins = Math.floor(vid.currentTime / 60);
  var cursecs = Math.floor(vid.currentTime - curmins * 60);
  var durmins = Math.floor(vid.duration / 60);
  var dursecs = Math.floor(vid.duration - durmins * 60);
  if (cursecs < 10) {
    cursecs = "0" + cursecs;
  }
  if (dursecs < 10) {
    dursecs = "0" + dursecs;
  }
  curtimetext.innerHTML = curmins + ":" + cursecs;
  durtimetext.innerHTML = durmins + ":" + dursecs;

  document.cookie = "curtime=" + vid.currentTime;

  // Play next video when video ends
  if (videoslider.value == 100 || vid.ended == true) {
    setTimeout(runVideo(x+=1), 2000)

  }
}

// -----------TOGGLE FULLSCREEN:
function togglefullscreen() {
  vid.removeAttribute("controls");
  if(vid.requestFullScreen) {
    vid.requestFullScreen();
  } else if (vid.webkitRequestFullScreen) {
    vid.webkitRequestFullScreen();
  } else if (vid.mozRequestFullScreen) {
    vid.mozRequestFullScreen();
  }
}

//---------------------------------SLIDE_VIDEO_PLAYLIST-------------------------------//
var nextBtn = document.getElementById("next");
var backBtn = document.getElementById("back");
//Take the video file names from the full path
// var videolinks = [];
// for (i=0; i<videos.length; i++) {
// 	videolinks.push(videos[i].firstElementChild.src.replace("http://localhost:1234/projects/webclient-videosite/videosite/", ""));
//
// }
function get(url){
  return new Promise(function(resolve, reject){

    var xhttp;
    if (window.XMLHttpRequest)
      xhttp = new XMLHttpRequest();
    else if (window.ActiveXObject)
      xhttp = new ActiveXObject("Msxml2.XMLHTTP");
    else
      throw new Error("Ajax is not supported by your browser");

    xhttp.onreadystatechange = function() {
      if (this.readyState < 4) {
        console.log("loading...")
      }
      else if (this.readyState == 4){
        console.log("success");
        resolve(videoData(this));
      } else {
        reject(this.statusText);
      }
    };
    xhttp.onerror = function() { // when it is not loaded
      reject(xhttp.statusText); // return the problem
    };
    xhttp.open("GET", url, true);
    xhttp.send();
  });
}
var url = "";
var params = new URL(window.location).searchParams;
var search = params.get("watch");
var dir = "watch/";
if (search != "") {
    url = "../files/watch-" + search + ".json";
    dir += search +"/";
}
get(url)
.then(function(){
  // setLinks();
})
.catch(function(error){
  console.log(error);
  get("../files/watch-latest.json")
  .then(function(){
  })
})
var videoId = [];
var videonames = [];
var videolinks   = [];
// var imglinks = [];
function videoData(xhttp) {
  var obj = JSON.parse(xhttp.responseText);
  for (t=0; t<obj.length; t++) {
    videoId.push(obj[t].vid_id);
    videonames.push(obj[t].vid_name);
    videolinks.push(obj[t].vid_name+"."+obj[t].vid_ext);
    // imglinks.push(obj[t].img_url);

  }
  //Replace spaces from the videolinks with "%20"
  for (i=0; i<videolinks.length; i++) {
    videolinks[i] = escape(videolinks[i]);
    // imglinks[i] = escape(imglinks[i]);
  }
}
// Share the current link to Facebook
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=299001533969350&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// --------VIDEO SLIDER--------//
function slideVideo(n) {
  runVideo(x+=n);
}
function runVideo(n) {
  if (n > videos.length) {
    x = 1;
  }
  if (n < 1) {
    x = videos.length;
  }

  var newSearch = "watch="+search+"&v="+escape(videonames[x-1]);
  if (history.pushState) {
      window.history.pushState({page:newSearch},'','?'+newSearch);
  } else {
    location.search = '?'+newSearch;
  }
  loadVideo();
}
// -------- LOAD VIDEO BASED ON "v" SEARCH PARAMETER ---------------//
var vidname, vidlink, vidIndex, x;

vidIndex = 0;
x = vidIndex + 1;
// let params = new URL(document.location).searchParams;
vidname = "";
function loadVideo() {
  params = new URL(window.location).searchParams;
  vidname = params.get("v");
  if (videonames.includes(vidname)) {
    vidIndex = videonames.indexOf(vidname);
    x = vidIndex + 1;
    videoplay.src = dir+videolinks[vidIndex];
    // videoplay.play();
    // playpause();
    activeVideo();
    // Display the currently playing video name
    vidName.innerHTML = videonames[vidIndex];
  }
}
window.onload = function() {
  loadVideo();
}
window.onpopstate = function () {
  loadVideo();
}
// --------- PLAY ANY VIDEO from the PLAYLIST---------//
window.onclick = function (e) {
  for (i = 0; i < videos.length; i++) {
    if (e.target == videos[i]) {
      runVideo(x=i+1);
    }
  }
  // playpause toggle
  if (e.target == videoplay || e.target == overlayBtn) {
    playpause();
  }
}
function  activeVideo() {
  // Unset border from every video in playlist
  for (var i = 0; i < videos.length; i++) {
    videos[i].parentElement.parentElement.style.borderRight = "0";
  }
  //Set the border to the video that is playing
  videos[x-1].parentElement.parentElement.style.borderRight = "4px solid rgb(78, 112, 148)";
  //Scroll the active video to the top (deactivate this for non-pc devices);
  var scrollTo = videos[x-1].parentElement.parentElement.parentElement.offsetTop;
  playlist.scroll({
    top: scrollTo,
    left: 0,
    behavior: 'smooth'
  })
  //Change the main background image
  var changeImgTo = videos[x-1].src;
  document.querySelector(".backgroundImage_section1").style.backgroundImage = "url(\'"+changeImgTo+"\')";
  //Reset the videoplay box dimensions
  setDimensions();
  //Update the views onto the database
  updateView(videoId[x-1]);
  //Reset the FB Share link to current URL
  document.getElementById("shareFB").setAttribute("data-href", location.href);
}
// Function to update watch record when any video is clicked
function updateView(id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var date = videos[x-1].parentElement.parentElement.parentElement.querySelectorAll("p span")[0];
            var views = videos[x-1].parentElement.parentElement.parentElement.querySelectorAll("p span")[1];
            views.innerHTML = this.responseText;
            document.querySelectorAll("#videoDBInfo span")[0].innerHTML = "Posted on: " + date.innerHTML + " | ";
            document.querySelectorAll("#videoDBInfo span")[1].innerHTML = "Views: " + views.innerHTML;
            console.log(this.responseText);
        }
    };
    //call to update view
    xmlhttp.open("GET", "../files/upload_watch_record.php?id=" + id, true);
    xmlhttp.send();
}

// function setLinks() {
//   for (i = 0; i < videos.length; i++) {
//     var url = location.origin + location.pathname + "?watch=" + search + "&id=" + videoId[i] + "#" + videolinks[i];
//     // videos[i].parentElement.parentElement.setAttribute("href", url);
//     console.log(url)
//   }
// };
