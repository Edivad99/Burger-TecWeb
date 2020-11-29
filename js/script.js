/* 
=================================
        MENU 
=================================
*/

function openSideNav() {

	let apriNav = document.querySelector('.open-button');
	let chiudiNav = document.querySelector('.chiudi-nav');
	let nav = document.querySelector('.nav');

	apriNav.addEventListener("click", function () {
		nav.classList.add("menu-active");
		chiudiNav.classList.add("chiudi-nav-active");
	});

	chiudiNav.addEventListener("click", function () {
		nav.classList.remove("menu-active");
		nav.classList.add("menu-disable");
		chiudiNav.classList.remove("chiudi-nav-active");
		chiudiNav.classList.add("chiudi-nav-disable");
	});

}

/* 
=================================
        CHIAMATE FUNZIONI 
=================================
*/

openSideNav();