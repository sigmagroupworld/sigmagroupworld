/**** Scroll To Top ***/
jQuery(document).ready(function($) {
	$(".scroll_to_top").click(function() {
	    $("html, body").animate({ 
	        scrollTop: 0 
	    }, "slow");
	    return false;
	});
	var scroll_btn = document.getElementById("scroll_top");
	$(window).scroll(function() {    
	    var scroll = $(window).scrollTop();    
	    if (scroll <= 100) {
	    	scroll_btn.style.display = "none";
	        $(".scroll_To_Top").removeClass("scroll_div").addClass("no_scroll");
	    } else {
	    	scroll_btn.style.display = "block";
	    	$(".scroll_To_Top").removeClass("no_scroll").addClass("scroll_div");
	    }
	});
});
/**** Scroll To Top ***/

/**** Testimonial Slider ***/
jQuery(document).ready(function($) {
  	$(".testimonial_slide").slick({
    	slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        responsive: [{
        	breakpoint: 850,
        	settings: {
        		slidesToShow: 1,
        		slidesToScroll: 1,
        		infinite: true,
        	}
    	}]
 	});
});
/**** Testimonial Slider end ***/