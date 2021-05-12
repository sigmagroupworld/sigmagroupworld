jQuery(document).ready(function($) {
	/**** Scroll To Top ***/
	$(".scroll-to-top").click(function() {
	    $("html, body").animate({ 
	        scrollTop: 0 
	    }, "slow");
	    return false;
	});
	var scroll_btn = document.getElementById("scroll-top");
	$(window).scroll(function() {    
	    var scroll = $(window).scrollTop();    
	    if (scroll <= 100) {
	    	scroll_btn.style.display = "none";
	        $(".scroll-to-top").removeClass("scroll_div").addClass("no_scroll");
	    } else {
	    	scroll_btn.style.display = "block";
	    	$(".scroll-to-top").removeClass("no_scroll").addClass("scroll_div");
	    }
	});
	/**** Scroll To Top ***/

	/**** Testimonial Slider ***/
  	$(".testimonial-slide").slick({
    	slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 1500,
        arrows: true,
        responsive: [{
        	breakpoint: 850,
        	settings: {
        		slidesToShow: 1,
        		slidesToScroll: 1,
        		infinite: true,
        	}
    	}]
 	});
	/**** Testimonial Slider end ***/

	/**** Video pop up ***/
	$(".js-video-button").modalVideo({
		youtube:{
			controls:0,
			nocookie: true
		}
	});
	/**** Video pop up end ***/
	
	/**** Search Autocomplete ***/
	$('.search-form .search-field').autocomplete({
		source: function(request, response) {
			$.ajax({
				dataType: 'json',
				url: AutocompleteSearch.ajax_url,
				data: {
					term: request.term,
					action: 'autocompleteSearch',
					security: AutocompleteSearch.ajax_nonce,
				},
				success: function(data) {
					response(data);
				}
			});
		},
		select: function(event, ui) {
			window.location.href = ui.item.link;
		},
	});
	/**** Search Autocomplete end ***/

});