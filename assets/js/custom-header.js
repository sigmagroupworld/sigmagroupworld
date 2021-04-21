// Custom JS for header
jQuery(document).ready(function() {
	jQuery('.header-cmenu nav.hfe-dropdown').on('click', function(){
		alert('click');
	    jQuery('body').toggleClass('add-menu');
	});

});