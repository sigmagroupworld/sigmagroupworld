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

	/**** Related Articles Slider ***/
  	$(".articles-slide").slick({
		slidesToShow: 2,
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
	/**** Related Articles Slider end ***/
	
	/**** Search Autocomplete ***/
	var search_term = $('.search-field.search-autocomplete').val();
	if(search_term == '') {
		$('.s-form.open .hs-search-field__suggestions').css('display', 'none');
	} else {
		$('.s-form.open .hs-search-field__suggestions').css('display', 'inline-block');
	}
	$(function() {
		$("body").click(function(e) {
			if (e.target.class != "s-form") {
				$('.search-field').val('');
				$('.s-form.open #search-results li').remove();
			}
		});
	})
	$('.search-form .search-field').keyup( function(){
		if( $(this).val().length < 1 ) {
			$('.s-form.open #search-results li').remove();
		}
	} );
	$('.search-form .search-field').autocomplete({
		minChars: 4,
		minLength: 4,
		source: function(request, response) {
			$.ajax({
				dataType: 'json',
				url: AjaxRequest.ajax_url,
				data: {
					term: request.term,
					action: 'autocompleteSearch',
					security: AjaxRequest.ajax_nonce,
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
	                    if(search_term == '') {
	                    	$('.s-form.open #search-results').empty();
	                    	$('.s-form.open .hs-search-field__suggestions').css('display', 'none');
	                    } else {
	                    	$('.s-form.open .hs-search-field__suggestions').css('display', 'inline-block');
	                    	for(var i = 0; i < 1; i++) {
	                    		$('.s-form.open #search-results li').remove();
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

	/**** Search Autocomplete end ***/

	/** Load more people ***/
	let page = 2;
	$("#load-more").click(function(){
				let term_id = typeof $("#termID").val() !== undefined ? $("#termID").val() : '';
				let posts_per_page = typeof $("#posts_per_page").val() !== undefined ? $("#posts_per_page").val() : '';
				let person_image = typeof $("#person_image").val() !== undefined ? $("#person_image").val() : '';
				let person_position = typeof $("#person_position").val() !== undefined ? $("#person_position").val() : '';
				let person_name = typeof $("#person_name").val() !== undefined ? $("#person_name").val() : '';
				let person_company = typeof $("#person_company").val() !== undefined ? $("#person_company").val() : '';
	      let data = {
		        'action' : 'load_people_by_ajax',
		        'page' : page,
		        'term_id' : term_id,
		        'posts_per_page' : posts_per_page,
		        'person_image' : person_image,
		        'person_name' : person_name,
		        'person_position' : person_position,
		        'person_company' : person_company,
		        'security': AjaxRequest.security
		};
		$('html, body').css("cursor", "wait");
		$('#load-more').css("cursor", "wait");
	        $.post(AjaxRequest.ajax_url, data, function(response) {
	        	page++;
	        	$('html, body').css("cursor", "auto");
	        	$('#load-more').css("cursor", "pointer");
	        	if (response == "") {
	        		$('#load-more').hide();
	        	} else {
	        		$('.all-speakers').append(response);
	        	}
		});
	});
	/** Load more people ***/

});

/** Casino Provider Details Tab ***/
function opendetails(evt, cityName) {
	var i, tabcontent, tablinks;
  	tabcontent = document.getElementsByClassName("tabcontent");
  	for (i = 0; i < tabcontent.length; i++) {
    	tabcontent[i].style.display = "none";
  	}
  	tablinks = document.getElementsByClassName("tablinks");
  	for (i = 0; i < tablinks.length; i++) {
    	tablinks[i].className = tablinks[i].className.replace(" active", "");
  	}
  	document.getElementById(cityName).style.display = "block";
  	evt.currentTarget.className += " active";
}
/** Casino Provider Details Tab end ***/

/** Sponsors modal popup Detail ***/

let toggles = document.getElementsByClassName("toggle");
let contentDiv = document.getElementsByClassName("content");
let icons = document.getElementsByClassName("icon");
let sell = document.getElementsByClassName("sell");

for (let i = 0; i < toggles.length; i++) {
	toggles[i].addEventListener("click", () => {
	  if (parseInt(contentDiv[i].style.height) != contentDiv[i].scrollHeight) {
	    contentDiv[i].style.height = contentDiv[i].scrollHeight + "px";
	    icons[i].classList.remove("fa-plus");
	    icons[i].classList.add("fa-minus");
	    sell[i].style.display = "flex";
	  } else {
	    contentDiv[i].style.height = "0px";
	    icons[i].classList.remove("fa-minus");
	    icons[i].classList.add("fa-plus");
	    sell[i].style.display = "none";
	  }

	  for (let j = 0; j < contentDiv.length; j++) {
	    if (j !== i) {
	      contentDiv[j].style.height = 0;
	      icons[j].classList.remove("fa-minus");
	      icons[j].classList.add("fa-plus");
	    }
	  }
	});
}

function openModal(elementId, modalId, closeId) {
    let popup = document.getElementById(elementId);
    let modal = document.getElementById(modalId);
	let span = document.getElementById(closeId);
	modal.style.display = "block";
	/*popup.onclick = function() {
	  modal.style.display = "block";
	}*/
	span.onclick = function() {
	  modal.style.display = "none";
	}
	window.onclick = function(event) {
	  if (event.target == modal) {
	    modal.style.display = "none";
	  }
	}
}
/** Sponsors modal popup Detail end ***/

/** Book Hotel Toggle ***/
function openHotel(elementId, expandDivId) {
	jQuery('#'+expandDivId).addClass('open');
    jQuery('#'+elementId).addClass('full');
}
function closeHotel(elementId, expandDivId) {
	jQuery('#'+expandDivId).removeClass('open');
    jQuery('#'+elementId).removeClass('full');
}
/** Book Hotel Toggle end ***/

/** Europe Gaming Page **/
	/** Hosts script start **/
	function openHostsDiv(elementId) {
		jQuery('#'+elementId).toggleClass('person-open');
	}
	/** Hosts script start end **/
	// charity auction script start
	function openCharityDiv(elementId) {
		jQuery('#'+elementId).toggleClass('full');
	}
	// charity auction script end 
	// sitting down script start
	  function tabArrangments(evt, down) {
	    var i, itemcontent, iconbtn;
	    itemcontent = document.getElementsByClassName("itemcontent");
	    for (i = 0; i < itemcontent.length; i++) {
	      itemcontent[i].style.display = "none";
	    }
	    iconbtn = document.getElementsByClassName("iconbtn");
	    for (i = 0; i < iconbtn.length; i++) {
	      iconbtn[i].className = iconbtn[i].className.replace(" active", "");
	    }
	    document.getElementById(down).style.display = "block";
	    evt.currentTarget.className += " active";
	  }
	  // sitting down script end
/** Europe Gaming Page end **/