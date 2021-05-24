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
	
	/**** Search Autocomplete ***/
	/*$(document).click(function(event){
        if ($(event.target).hasClass('open')) {
        	alert('okk');
    		$('.s-form.open .hs-search-field__suggestions').css('display', 'none');
        }
    });*/
	var search_term = $('.search-field.search-autocomplete').val();
	if(search_term == '') {
    	$('.s-form.open .hs-search-field__suggestions').css('display', 'none');
    } else {
    	$('.s-form.open .hs-search-field__suggestions').css('display', 'inline-block');
    }
	$('.search-form .search-field').autocomplete({
		minChars: 4,
		minLength: 4,
		source: function(request, response) {
			$.ajax({
				dataType: 'json',
				url: AutocompleteSearch.ajax_url,
				data: {
					term: request.term,
					action: 'autocompleteSearch',
					security: AutocompleteSearch.ajax_nonce,
				},
				beforeSend: function() {
			        $('.s-form.open .hs-search-field__suggestions').hide();
			        $('.s-form.open .hs-search-field__suggestions').css('display', 'none');
			    },
				success: function(data) {
					$('.hs-search-field__suggestions').show();
					var content = '';
					var len = data.length;
					var search_term = $('.search-field.search-autocomplete').val();
					if (data.length == 0){
	                    content += 'No results';
	                }
	                else {
						content += '<li class="highlight">Results for ' + search_term + '</li>';
	                    $.each(data, function(i, post) {
	                    	var result= post.label.split(' ');
	                    	var string = $('jqueryselector').val(search_term.toLowerCase());
	                    	var highlight_term = post.label.replace(search_term, '<span class="highlight"> ' + search_term + ' </span>');
	                        content += '<li class="highlight-term"><a href=' + post.link + '>' + highlight_term + '</a></li>';
	                    });
	                    //$('#search-results').append(content);
	                    if(search_term == '') {
	                    	$('.s-form.open #search-results').empty();
	                    	$('.s-form.open .hs-search-field__suggestions').css('display', 'none');
	                    } else {
	                    	$('.s-form.open .hs-search-field__suggestions').css('display', 'inline-block');
	                    	for(var i = 0; i < 1; i++) {
								$('.s-form.open #search-results').append(content);
							}
	                    }
	                }
				},
				error: function(xhr) { // if error occured
			        $('.s-form.open .hs-search-field__suggestions').hide();
			        $('.s-form.open .hs-search-field__suggestions').css('display', 'none');
			    },
			    complete: function() {
			    	//$('#search-results').html(content);
			        $('.s-form.open .hs-search-field__suggestions').show();
			    }
			});
		},
		select: function(event, ui) {
			window.location.href = ui.item.link;
		}
	});


	/*var searchRequest;
	$('.search-autocomplete').autoComplete({
		minChars: 4,
		source: function(term, suggest){
			try { 
				searchRequest.abort(); 
			} catch(e){}
			searchRequest = $.post(global.ajax, { search: term, action: 'autocompleteSearch' }, function(res) {
				suggest(res.data);
			});
		},
		select: function(event, ui) {
			alert('okkk');
			console.log(ui);
			window.location.href = ui.item.link;
		}
	});*/

	/**** Search Autocomplete end ***/

});