
var container = document.getElementsByClassName("videoslides-container");

var prevBtn = document.getElementsByClassName("prev");

var nxtBtn = document.getElementsByClassName("next");

var slideIndex = 1;



//-----Video-Slider-------//
  //All of the slidebox containers
	var sliderOuter = document.querySelectorAll(".videoslides-container");
	//The number of slidebox to show in each slide
  var slideDivider = 4;
  var screenWidth = document.documentElement.offsetWidth;
  //responsive sliders
  if (screenWidth < 1120) {
    slideDivider = 3;
    if (screenWidth < 720) {
      slideDivider = 1;
    }
  } else {
    slideDivider = 4;
  }

	var slides, slideCount, slideWidth, sliderFullWidth;

	//To get the info for each sliderbox container
	function getSliderInfo(s_outer) {
		slider = s_outer.querySelector(".videoboxwrap");
		slides = slider.querySelectorAll(".videobox");
		slideCount = slides.length;
		//The width of each slidebox
		slideWidth = s_outer.offsetWidth / slideDivider;
		//The full width of the sliderwrap
		sliderFullWidth = slideCount * slideWidth;
	}
	var setSliderWidth;
  (setSliderWidth = function () {
	   sliderOuter.forEach((s_outer) => {
		  getSliderInfo(s_outer);
			slider.style.cssText = "width: " + sliderFullWidth + "px";
			for (i=0; i<slideCount; i++) {
				slides[i].style.cssText = "width: " + slideWidth + "px;";
			}
		});
	})();

	var count = 0;
	function nextSlide(id) {
		count++;
		runSlide(id);
	}
	function prevSlide(id) {
		count--;
		runSlide(id);
	}
	function runSlide(id) {
		//re-assign slider as the box wrap
		var sliderOuter = id.parentElement.querySelector(".videoslides-container");
		getSliderInfo(sliderOuter);

		var lengthMoved = Math.abs(Number(slider.style.transform.substr(10).replace("(", "").replace(")", "").replace("px","")));

		// Detect where the slide is by comparing to the entire width of the slider
		if (lengthMoved < sliderFullWidth - slideWidth*slideDivider*count) {
			//Move the length based on the current left-offset length, move it by one sliderOuter width
			//var moveLength = slideWidth * slideNum * slideDivider;
			var moveLength = lengthMoved + slideWidth*slideDivider*count;
			slider.style.cssText = "width:" + sliderFullWidth + "px; transform: translateX(-" + moveLength +"px); transition: all 800ms ease";

			if (lengthMoved > 0) {
				//sliderOuter.parentElement.querySelector(".prev").style.display = "block";
			} else {
				//sliderOuter.parentElement.querySelector(".prev").style.display = "none";
			}
			if (lengthMoved >= sliderFullWidth - slideWidth*slideDivider*count) {
				//sliderOuter.parentElement.querySelector(".next").style.display = "none";
			} else {
				//sliderOuter.parentElement.querySelector(".next").style.display = "block";
			}

		} else {

			slider.style.cssText = "width:" + sliderFullWidth + "px; transform: translateX(0); transition: all 800ms ease";

		}
	count = 0;
	}
window.onresize = function () {
  screenWidth = document.documentElement.offsetWidth;
  if (screenWidth < 1120) {
    slideDivider = 3;
    if (screenWidth < 655) {
      slideDivider = 1;
    }
  } else {
    slideDivider = 4;
  }
  resetWidth_Header();

  setDimensions_Header();

  setSliderWidth();
}
