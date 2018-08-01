//START--------------------Toggle the sideNav
//when clicked


var sideNav = document.getElementById("sideNav");
var openSideNav = document.getElementById("openSideNav");
function opensidenav() {
	if (sideNav.style.display !== "none") {
		sideNav.style.display = "none";
	}
	else {
		sideNav.style.display = "block";
	}

}

openSideNav.addEventListener("click", opensidenav);
