//Header slideShow

var h_slider= document.querySelector(".header-slider");

var h_slides = document.querySelectorAll(".header-slides");

var h_slideCount = h_slides.length;

var h_slideHeight = document.querySelector(".header-slider-wrap").offsetHeight;

var h_slideWidth = document.querySelector(".header-slider-wrap").offsetWidth;

var h_sliderFullWidth = h_slideCount * h_slideWidth;

function resetWidth_Header() {

  h_slideWidth = document.querySelector(".header-slider-wrap").offsetWidth;

  h_sliderFullWidth = h_slideCount * h_slideWidth;

}

function setDimensions_Header() {

  h_slider.style.cssText = "width:" + h_sliderFullWidth + "px";

  // slides.forEach((slide) => {

  //   slide.style.cssText  = "width: " + slideWidth + "px; height: " + slideHeight +"px";

  // })

  for (var i = 0; i < h_slides.length; i++) {

    h_slides[i].style.cssText  = "width: " + h_slideWidth + "px; height: " + h_slideHeight + "px; background-position: " + h_slideWidth*[i] + "px 0";

    //setLink

    var slideImage = document.querySelectorAll(".slide-image")[i];

    var videoName =  slideImage.firstElementChild.innerHTML;

    var url = "videosite/?watch=funny&v=" + escape(videoName);

    slideImage.parentNode.setAttribute("href", url);

    // console.log(url);

  }

};

setDimensions_Header();

var h_count = 1;

function runSlide_Header() {

  var slideNum = h_count++;

  if (slideNum < h_slideCount) {

    var moveLength = h_slideWidth * slideNum;

    h_slider.style.cssText = "width:" + h_sliderFullWidth + "px; -webkit-transform: translate3d(-"+ moveLength +"px, 0px, 0px); -moz-transform: translate3d(-"+ moveLength +"px, 0px, 0px); -o-transform: translate3d(-"+ moveLength +"px, 0px, 0px); transform: translate3d(-"+ moveLength +"px, 0px, 0px); -webkit-transition: all 800ms ease; transition: all 800ms ease; -moz-transition: all 800ms ease; -o-transition: all 800ms ease; transition: all 800ms ease";



  } else {

    h_count = 1;

    h_slider.style.cssText = "width:" + h_sliderFullWidth + "px; -webkit-transform: translate3d(0px, 0px, 0px); -moz-transform: translate3d(0px, 0px, 0px); -o-transform: translate3d(0px, 0px, 0px); transform: translate3d(0px, 0px, 0px); -webkit-transition: all 800ms ease; transition: all 800ms ease; -moz-transition: all 800ms ease; -o-transition: all 800ms ease; transition: all 800ms ease";

  }

}

setInterval(() => runSlide_Header(), 3000);



// Click video to watch (go to the videosite and play that video)

location.hash = "";

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

      else if (this.readyState == 4) {

        console.log("success");

        resolve(this);

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

url = ["files/watch-latest.json", "files/watch-funny.json", "files/watch-most-popular.json"];



get(url[0])

.then((data) => {

  videoData(data);

  return get(url[1]);

})

.then((data) => {

  videoData(data);

  return get(url[2]);

})

.then((data) => {

  videoData(data);

  setLinks();
})

.catch((err) => {

  console.log(err);

});



var videonames = [];

var videolinks   = [];

var imglinks = [];

var videoext = [];
function videoData(xhttp) {

  var obj = JSON.parse(xhttp.responseText);

  for (t=0; t<obj.length; t++) {

    videonames.push(obj[t].vid_name);

    videolinks.push(obj[t].vid_dir);

    imglinks.push(obj[t].img_url);



  }

  //Replace spaces from the videolinks with "%20"

  for (i=0; i<videolinks.length; i++) {

    videolinks[i] = videolinks[i].replace("../videosite/watch/", "");

  	// videolinks[i] = videolinks[i].split(" ").join("%20");

    // videonames[i] = escape(videonames[i]);

  }

}

window.onclick = function(e) {

  if (e.target == run) {

    e.preventDefault();

  }

}



// ----Go to the video clicked ---------//

var search = document.getElementById("search");

var run = document.getElementById("run");
function searchVideo() {

  location.href = "search.php#"+search.value;

}

var slidevid = document.getElementsByClassName("slidevideo");
function setLinks() {

  for (i = 0; i < slidevid.length; i++) {

    var playlist = "";
    var name = slidevid[i].parentElement.parentElement.querySelector("h4").innerText;
    // var url = "videosite/?watch=" + videolinks[i] + "&v=" + escape(videonames[i]);

    var url = slidevid[i].parentElement.href + escape(name);
    slidevid[i].parentNode.setAttribute("href", url);

  }

}

