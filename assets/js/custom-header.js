// Custom JS for header
jQuery(document).ready(function() {
	jQuery("div.header-cmenu nav.hfe-dropdown").on('click', function(){
		alert('click');
	    jQuery("body").toggleClass("add-menu");
	});

	jQuery("div.hfe-nav-menu-icon").click(function(){
	    jQuery("body").toggleClass("menu-hide");
	});
});