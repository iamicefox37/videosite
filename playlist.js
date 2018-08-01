var videoboxOuter = document.querySelectorAll(".videoslides-container");
//The number of videobox to show in each videobox
var vboxDivider = 4;
var screenWidth = document.documentElement.offsetWidth;
if (screenWidth < 1120) {
  vboxDivider = 3;
  if (screenWidth < 720) {
    vboxDivider = 1;
  }
} else {
  vboxDivider = 4;
}
var vbox, vboxwrap, vboxWidth, vboxCount;

//To get the info for each videobox container
function getVideoboxInfo(s_outer) {
  vboxwrap = s_outer.querySelector(".videoboxwrap");
  vbox = s_outer.querySelectorAll(".videobox");
  vboxCount = vbox.length;
  //The full width of the videoboxwrap
  vboxFullWidth = s_outer.offsetWidth;
  //The width of each videobox
  vboxWidth = vboxFullWidth / vboxDivider;

}
var setvboxWidth;
(setvboxWidth = function () {
   videoboxOuter.forEach((s_outer) => {
    getVideoboxInfo(s_outer);
    // vboxwrap.style.cssText = "width: " + sliderFullWidth + "px";
    for (i=0; i<vboxCount; i++) {
      vbox[i].style.cssText = "width: " + vboxWidth + "px;";
    }
  });
})();
window.onresize = function () {
  screenWidth = document.documentElement.offsetWidth;
  if (screenWidth < 940) {
    vboxDivider = 3;
    if (screenWidth < 425) {
      vboxDivider = 1;
    }
  } else {
    vboxDivider = 4;
  }
  setvboxWidth();
}
