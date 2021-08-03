(function($){
	$(document).ready(function(){

		/* For news menu start */
		$('div.mobile-pick div.btn').click(function(){
		    $('div.news-menu').toggleClass('open');
		    $('div.mobile-pick div.btn').toggleClass('open');
		    $('div.news-menu > ul').toggleClass('open');
		});
		/* For news menu end */

		/* Serch form start */
		$('form#searchform').click(function(event) {
	        $('div.s-form').addClass('open');
	        $('div.home-news-menu').addClass('opacity');
	        event.stopPropagation();
	    });
	    $(document).click(function(event){
	        if (!$(event.target).hasClass('link')) {
	            $('div.s-form').removeClass('open');
	            $('div.home-news-menu').removeClass('opacity');
	        }
	    });
		/* Serch form end */

		/**** Video pop up ***/
	$(".js-video-button").modalVideo({
		youtube:{
			controls:0,
			nocookie: true
		}
	});
		$('.article-wrapper-slider').slick({
			dots: true,
			// autoplay: true,
		});

		$('.single-news').slick({
  		autoplay: true,
    		autoplaySpeed: 2000,
		prevArrow: false,
    		nextArrow: false,
    		dots: false,
    		infinite: false,
    		speed: 1000,
    		fade: true,
    		slide: 'div',
    		cssEase: 'linear'
	});
	/**** Video pop up end ***/

	});
})(jQuery);