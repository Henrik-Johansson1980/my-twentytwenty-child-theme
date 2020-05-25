/**
 * File to handle fixed top menu.
 */

 document.addEventListener( 'DOMContentLoaded', function(){
	const adminBar = document.getElementById( 'wpadminbar' );
	const topMenu = document.getElementById( 'site-header' );

	//Offset the page body by the height of the top menu.
	if(adminBar){
		document.body.style.marginTop = ( topMenu.offsetHeight + 32 ) + "px";
		topMenu.style.top = "32px";
	} else {
		document.body.style.marginTop = ( topMenu.offsetHeight ) + "px";
	}

	// On Scroll down, hide top menu
	let lastScrollPosition = 0;

	window.onscroll = function() {
		
		let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

		//If scrolling down and past the height of the menu
		if (scrollTop > lastScrollPosition && scrollTop > topMenu.offsetHeight) {
			topMenu.style.top = '-200px';
		}else { 
			//Scroll up - Show menu
			if(!adminBar) {
				topMenu.style.top = '0';
			} else {
				topMenu.style.top = '32px';
			}
		}
		lastScrollPosition = scrollTop <= 0 ? 0 : scrollTop;
	};

 }, false );