/**** Scroll To Top ***/
jQuery(document).ready(function($) {
	$(".scroll_To_Top").click(function() {
	    $("html, body").animate({ 
	        scrollTop: 0 
	    }, "slow");
	    return false;
	});
	var scrollBtn = document.getElementById("scrollTop");
	$(window).scroll(function() {    
	    var scroll = $(window).scrollTop();    
	    if (scroll <= 100) {
	    	scrollBtn.style.display = "none";
	        $(".scroll_To_Top").removeClass("scrollDiv").addClass("noScroll");
	    } else {
	    	scrollBtn.style.display = "block";
	    	$(".scroll_To_Top").removeClass("noScroll").addClass("scrollDiv");
	    }
	});
});
/**** Scroll To Top end ***/