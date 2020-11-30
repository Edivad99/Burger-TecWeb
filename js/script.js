/* 
=================================
        MENU 
=================================
*/

function apri_nav() {

    let chiudiNav = document.querySelector('.chiudi-nav');
    let nav = document.querySelector('.nav');

    nav.classList.add("menu-active");
    chiudiNav.classList.add("chiudi-nav-active");
}

function chiudi_nav() {

    let chiudiNav = document.querySelector('.chiudi-nav');
    let nav = document.querySelector('.nav');

    nav.classList.remove("menu-active");
    chiudiNav.classList.remove("chiudi-nav-active");
    chiudiNav.classList.add("chiudi-nav-disable");
}