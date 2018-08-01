//SearchData from the hash onload
//SearchData updates hash from user input, to keep track of search

window.onload = function () {
  if (location.hash) {
    searchData();
  }
}
var hashname = location.hash.replace("#", "");
var vid_results = "";
var videonames = [];
var videolinks   = [];
var search = document.getElementById('search');
var results = document.getElementsByClassName('results');
function searchData() {
  url = new Request("files/watch-videosite.json");
  fetch(url)
  .then((res) => {
    res.json()
    .then((data) => {
      processData(data);
      setLink();
      footerPlace()
    });
  })
  .catch((err) => console.log(err));
}
function processData(vid) {
  videonames = [];
  videolinks = [];
  var count = 0;
  function clean(val) {
    return val.toLowerCase().match(/[a-z0-9]/g).join("");
  }
  if (hashname) {
    if (clean(hashname) != "") {
      let output = '<h4>Search results for "'+hashname+'"</h4><br>';
      for (var i = 0; i < vid.length; i++) {
        if (clean(vid[i].vid_name).match(clean(hashname))) {
          output += `
            <a><img class="vid_results" width="240" class="thumbnails" alt="The Image is not available" src="${vid[i].img_url.replace("../", "")}"></a><br>
            <span class="desc"><strong>${vid[i].vid_name}</span><br><br>
          `;
          count++;
          videonames.push(escape(vid[i].vid_name) + "." + vid[i].vid_ext);
          videolinks.push(vid[i].vid_dir.replace("../videosite/watch/", ""));
        }
      }
      // function searchArray(str, val) {
      //   t = "";
      //   var i = 0;
      //   arr1 = str.split("");
      //   arr2 = val.split("");
      //   while (i<arr1.length) {
      //   	arr2.forEach(x => {
      //   		if(arr1[i] == x){
      //   			t += x
      //   			i++;
      //       	}
      //       })
      //     	if (t.length==arr2.length) break;
      //   }
      //   return t;
      // }
      if (count < 1) {
        output += `
          <span class="error-msg">Sorry we couldn't find a video by that name.</span><br><br>
        `;
      } else {
        vid_results = document.getElementsByClassName("vid_results");
      }
      results[0].innerHTML = output;
    }
  } else {
    let output = `
      <span class="error-msg">Type in a video name or tag name.</span><br><br>
    `;
    results[0].innerHTML = output;
  }
}
function setLink() {
  for (i = 0; i < vid_results.length; i++) {
    url = "videosite/?watch=" + videolinks[i] + "#" + videonames[i];
    vid_results[i].parentNode.setAttribute("href", url);
  }
}
window.onclick = (e) => {
  if (e.target == run) {
    console.log(run);
    e.preventDefault();
  }

}
// searchData();
function changeHash() {
  hashname = search.value.match(/\S/g).join("");
  location.hash = hashname;
}
window.onhashchange = function() {
  hashname = location.hash.replace("#", "");
  searchData();

  footerPlace();
}

//Seting the footer position
function footerPlace() {
  var footer = document.querySelector(".footer");
  var footerPlace = document.querySelector(".main").offsetHeight - document.querySelector(".main").offsetTop;
  footer.style.cssText = "position: absolute; top:" + footerPlace + "px; width: 100%";
}
