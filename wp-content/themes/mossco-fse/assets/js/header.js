//STICKY HEADER
const $header = document.querySelector('.mossco-header')
const $fakeHeader = document.querySelector('.false-header')
const $logo = document.querySelector('.mos-logo')
const $navHover = document.querySelector('.nav-hover')

window.addEventListener('scroll', () => {
	if (window.scrollY > 64) {
		$navHover.classList.remove('lg:hover:bg-Mossco-grey-background')
		$header.classList.add('mossco-header-top')
		$logo.classList.remove('mos-logo-top')

		$fakeHeader.classList.add('scale-y-75')
		$fakeHeader.classList.add('bg-opacity-75')
		$fakeHeader.classList.add('shadow-xl')

		return
	}
	
	$navHover.classList.add('lg:hover:bg-Mossco-grey-background')
	$header.classList.remove('-translate-y-4')
	$logo.classList.add('scale-125')
	
	$fakeHeader.classList.remove('scale-y-75')
	$fakeHeader.classList.remove('bg-opacity-75')
	$fakeHeader.classList.remove('shadow-xl')
});

//MOBILE SIDE MENU
// var sideMenu = document.getElementById('side-menu');
// function openMenu() {
// 		sideMenu.classList.remove('left-[-250px]');
// 		sideMenu.classList.add('left-0');
// }

// function closeMenu() {
// 		sideMenu.classList.remove('left-0');
// 		sideMenu.classList.add('left-[-250px]');
// }