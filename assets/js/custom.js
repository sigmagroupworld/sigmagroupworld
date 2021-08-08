jQuery(document).ready(function($) {

	$('.img-gallery').slickLightbox({
		itemSelector        : 'img',
  		navigateByKeyboard  : true,
  		src		    : 'src',
  		//itemSelector: '.img-gallery img'
	});

	$('.video-slider-mo').slick({
      		slidesToScroll: 1,
      		autoplay: true,
      		autoplaySpeed: 3000,
      		dots: false,
      		infinite: true,
      		adaptiveHeight: true,
      		arrows: true
	  });

	/**** Scroll To Top ***/
	$(".scroll-to-top").click(function() {
	    $("html, body").animate({ 
	        scrollTop: 0 
	    }, "slow");
	    return false;
	});
	$(".calendarswitcher").click(function(){
		$(".calendarswitcher").each(function(){
			$(this).removeClass('active');
		});
		$(this).addClass('active');
		var attrTarget = $(this).attr("data-target");
		$(".date-outerbox").each(function(){
			$(this).hide();
		});
		$(".box_" + attrTarget).show();
	});
	$(".agenda-header-link").click(function(){
		$(".agenda-header-link").each(function(){
			$(this).removeClass('active');
		});
		$(this).addClass('active');
		var attrTarget = $(this).attr("data-target");
		$(".dailyWrapper").each(function(){
			$(this).hide();
			if($(this).attr("data-element") == attrTarget){
				$(this).show();
			}
		});
	});
	$(".action-expand").click(function(){
		$(".action-expand").each(function(){
			$(this).removeClass('active');
		});
		$(this).addClass('active');
		var childIsActive = $(this).parent().find(".confdedtails").is(':visible');
		$(".confdedtails").each(function(){
			$(this).hide();
		});
		if(!childIsActive){
			$(this).parent().find(".confdedtails").show();
		}
	});
	$(".row-top").click(function(){
		$(".row-top").each(function(){
			$(this).removeClass('active');
		});
		$(this).addClass('active');
		var childIsActive = $(this).parent().find(".description").is(':visible');
		$(".description").each(function(){
			$(this).hide();
		});
		if(!childIsActive){
			$(this).parent().find(".description").show();
		}
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

	$( '.home-page.popup .close' ).on( 'click', function() {
		$( '.home-page.popup' ).removeClass( 'open' );
		$( '.home-page.popup' ).addClass( 'close' );
	} );
	setTimeout( function(){
		$( '.home-page.popup' ).removeClass( 'close' );
		$( '.home-page.popup' ).addClass( 'open' );
	}, 30000);

	/** Sponsors Exhibitors Toggle ***/
	openSponsorsExhibitors = (elementId) => {
	    $('.'+elementId).toggleClass('full');
	}
	/** Sponsors Exhibitors Toggle end ***/

	/**** Testimonial Slider ***/
  	$(".testimonial-slider").slick({
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
 	$(".testimonial-slide-home").slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: false,
		autoplaySpeed: 1500,
		infinite: false,
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

	//deep tech insights slider start
	  $('.deep-insights-slider').slick({
	      infinite: true,
	      slidesToShow: 3,
	      slidesToScroll: 3,
	      dots: true,
	      responsive: [
	      	{
	          breakpoint: 1024,
	          settings: {
	            slidesToShow: 2,
	            slidesToScroll: 2,
	            infinite: true,
	          }
	        },
	        {
	          breakpoint: 768,
	          settings: {
	            slidesToShow: 1,
	            slidesToScroll: 1,
	            infinite: true,
	          }
	        },
	      ]
	  });
	  //deep tech insights slider end
	  //expert slider start
	  $('.expert-slider').slick({
	      infinite: true,
	      slidesToShow: 4,
	      autoplay: true,
	      autoplaySpeed: 2000,
	      slidesToScroll: 1,
	      responsive: [
	        {
	          breakpoint: 1024,
	          settings: {
	            slidesToShow: 3,
	            slidesToScroll: 3,
	            infinite: true,
	          }
	        },
	        {
	          breakpoint: 768,
	          settings: {
	            slidesToShow: 1,
	            slidesToScroll: 1
	          }
	        },
	      ]
	  });
	  //expert slider end

	  $('.video-slider').slick({
	      infinite: true,
	      slidesToShow: 3,
	      slidesToScroll: 1,
	      autoplay: true,
	      centerPadding: 10,
	      responsive: [
	        {
	          breakpoint: 1024,
	          settings: {
	            slidesToShow: 2,
	            slidesToScroll: 1,
	            infinite: true,
	          }
	        },
	        {
	          breakpoint: 768,
	          settings: {
	            slidesToShow: 1,
	            slidesToScroll: 1,
	            infinite: true,
	          }
	        }
	      ]
	  });

	$('.winner-slider').slick({
      		infinite: true,
      		slidesToShow: 1,
      		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 2000,
  	});

	/**** Related Articles Slider ***/
  	$(".casino .articles-slide").slick({
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
	$(".pitch-articles .articles-slide").slick({
		slidesToShow: 3,
	    	slidesToScroll: 3,
	    	autoplay: false,
	    	autoplaySpeed: 1500,
	    	arrows: true,
		dots: true,
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

	//investor-slider slider start
	  $('.investor-slider').slick({
	      infinite: true,
	      slidesToShow: 4,
	      slidesToScroll: 1,
	      dots: false,
	      responsive: [
	        {
	          breakpoint: 1025,
	          settings: {
	            slidesToShow: 3,
	            slidesToScroll: 1,
	            infinite: true,
	          }
	        },
	        {
	          breakpoint: 768,
	          settings: {
	            slidesToShow: 1,
	            slidesToScroll: 1,
	            infinite: true,
	          }
	        },
	      ]
	  });
	  //investor-slider slider end

	/** Book Hotel Toggle ***/
	openHotel = (elementId, expandDivId) => {
		$('#'+expandDivId).addClass('open');
	    $('#'+elementId).addClass('full');
	}
	closeHotel = (elementId, expandDivId) => {
		$('#'+expandDivId).removeClass('open');
	    $('#'+elementId).removeClass('full');
	}
	/** Book Hotel Toggle end ***/

	/** Hosts script start **/
	openHostsDiv = (elementId) => {
		$('.'+elementId).toggleClass('person-open');
		$(".person-item-inner."+elementId).css("margin-right", "0");
		$(".person-item-inner").css("margin-right", "20px");
	}
	openSpeakersDiv = (elementId) => {
		$('.'+elementId + ' .title').toggleClass('open');
		$('.'+elementId + ' .body').toggleClass('show');
		//$('.'+elementId).toggle('person-open');
	}
	/** Hosts script start end **/

	$( '.podcast-popup' ).on( 'click', function() {
            $( '.podcast-popup' ).addClass( 'close' );
        } );

	// Awards script start
	openAward = (elementId) => {
		//$( '.awards .container .awards-wrapper .award-box' ).removeClass( 'open' );
		$('#'+elementId).toggleClass('open');
	}	
	closeAward = (elementId) => {
		//alert(elementId);
		$('#'+elementId).toggleClass('open');
	}

	openExpanDiv = (elementId, openId) => {
		$('#'+elementId).toggleClass('open');
		$('#'+openId).toggleClass('open');
	}
	closeExpanDiv = (elementId, openId) => {
		//$('#'+elementId).removeClass('open');
		$('.'+openId).removeClass('open');
	}
  	//Awards script end

	// sitting down script start
	tabArrangments = (evt, down) => {
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

	// charity auction script start
	openCharityDiv = (elementId) => {
		$('#'+elementId).toggleClass('full');
	}
	// charity auction script end 

	/**** Search Autocomplete ***/
	var search_term = $('.search-field.search-autocomplete').val();
	if(search_term == '') {
		$('.s-form.open .hs-search-field__suggestions').css('display', 'none');
	} else {
		$('.s-form.open .hs-search-field__suggestions').css('display', 'inline-block');
	}
	$("body").click(function(e) {
		if (e.target.class != "s-form") {
			$('.search-field').val('');
			$('.s-form.open #search-results li').remove();
			$('.s-form.open .hs-search-field__suggestions').hide();
		    $('.s-form.open .hs-search-field__suggestions').css('display', 'none');
		}
	});
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
						content += '<li class="highlight">Results for <span>"' + search_term + '"</span></li>';
	                    $.each(data, function(i, post) {
	                    	var result= post.label.split(' ');
	                    	//var string = $('jqueryselector').val(search_term.toLowerCase());

	                    	var newText = String(post.label).replace(
					                new RegExp(search_term, "gi"),
					                "<span class='ui-state-highlight'>$&</span>");

			                content += '<li class="highlight-term"><a href=' + post.link + '>' + newText + '</a></li>';
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
		let posts_per_page = typeof $("#posts_per_page").val() !== undefined ? $("#posts_per_page").val() : '-1';
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

	/*** Gallery load more ****/
	$( '.gallery-load-more' ).click( function(e) {
		$( this ).attr( "disabled", true );
		var button_term_id = $( this ).data( 'button-term-id' );
		var i = 1;
		$( '.gallery-directories > div[data-div-term-id='+button_term_id+']' ).not(":visible").each( function () {
			if( i < 2 ) {
				$( this ).show();
				i = i + 1;
				if( $( ".gallery-directories > div[data-div-term-id="+button_term_id+"]:hidden" ).length == 0 ){
					$( ".gallery-load-more[data-button-term-id="+button_term_id+"]" ).hide();
				}
			}
		});
		$( this ).attr( "disabled", false );
	} );
	/*** Gallery load more ****/

	// Elementor Year Slider
	if( window.elementorFrontend.config.environmentMode.edit == false ) {
		setTimeout( function(){
			$( '#slider_2018' ).hide();
			$( '#slider_2017' ).hide();
			$( '#slider_btn_2017' ).click( function(){
				$( '#slider_btn_2017' ).addClass( 'active' );
				$( '#slider_2017' ).show();

				$( '#slider_btn_2018' ).removeClass( 'active' );
				$( '#slider_2018' ).hide();

				$( '#slider_btn_2019' ).removeClass( 'active' );
				$( '#slider_2019' ).hide();
			} );

			$( '#slider_btn_2018' ).click( function(){
				$( '#slider_btn_2017' ).removeClass( 'active' );
				$( '#slider_2017' ).hide();

				$( '#slider_btn_2018' ).addClass( 'active' );
				$( '#slider_2018' ).show();

				$( '#slider_btn_2019' ).removeClass( 'active' );
				$( '#slider_2019' ).hide();
			} );

			$( '#slider_btn_2019' ).click( function(){
				$( '#slider_btn_2017' ).removeClass( 'active' );
				$( '#slider_2017' ).hide();

				$( '#slider_btn_2018' ).removeClass( 'active' );
				$( '#slider_2018' ).hide();

				$( '#slider_btn_2019' ).addClass( 'active' );
				$( '#slider_2019' ).show();
			} );
		} , 500);
	}
	// 2020 Startup filter start
	// var numToDisplay = $("#meet_startup_last_year").val();
	var numToDisplay = 9;
	$( '.startup-filter-last-year ul li' ).click( function(){
		if( $(this).hasClass( 'active' ) ) {
			return;
		} else {
			var load_time_total_displayed = $( '.charity-items > div.displayed:visible' );
			var load_time_total = $( '.charity-items > div.displayed' );
			if( load_time_total_displayed.length == load_time_total.length ) {
				$( '#startup-filter-load-more-btn' ).hide();
			} else {
				$( '#startup-filter-load-more-btn' ).show();
			}
		}
		$( '.startup-filter-last-year ul li.active' ).removeClass( 'active' );
		var i = 0;
		var li_class = $( this ).attr( 'class' );
		$( '.'+ li_class ).addClass( 'active ');
		var regex_data = $(this).data('regex');
		$( '.charity-items > div' ).each(function () {
			if ( $( this ).data( 'title' ).search( regex_data ) > -1) {
				$(this).addClass( 'displayed' );
				if( i < numToDisplay ) {
					$(this).show();
					i = i + 1;
				} else {
					$( '#startup-filter-load-more-btn' ).show();
				}
			} else {
				$(this).removeClass( 'displayed' );
				$(this).hide();
			}
		});
	} );

	var j = 0;
	$( '.charity-items > div' ).each(function () {
		if ( $( this ).data( 'title' ).search( '^[0-9a-gA-G].*' ) > -1) {
			$(this).addClass( 'displayed' );
			if( j < numToDisplay ) {
				$(this).show();
				j = j + 1;
			} else {
				$(this).hide();
			}
		} else {
			$(this).hide();
		}
	});

	var load_time_total_displayed = $( '.charity-items > div.displayed:visible' );
	var load_time_total = $( '.charity-items > div.displayed' );
	if( load_time_total_displayed.length == load_time_total.length ) {
		$( '#startup-filter-load-more-btn' ).hide();
	}

	$( '#startup-filter-load-more-btn' ).click( function(e) {
		e.preventDefault();
		var loop = 0;
		var total_displayed = $( '.charity-items > div.displayed:visible' );
		var total = $( '.charity-items > div.displayed' );
		var total_hidden = $( '.charity-items > div.displayed:hidden' );
		$( total_hidden ).each( function(){
			if( loop < numToDisplay ) {
				$( this ).show();
				loop = loop + 1;
				if( ( total_displayed.length ) + 1 == total.length ) {
					$( '#startup-filter-load-more-btn' ).hide();
				}
			}
		} );
	} );
	// 2020 Startup filter end

	/** Vacancies Filter **/
	if( document.location.href.includes( '?' ) ) {
		var current_url = document.location.href;
	} else {
		var current_url = document.location.href + '?';
	}
	
	$('#filter-country').on('change', function(){
		var country_val = $( this ).val();
		var url = current_url + "&country="+country_val;
		var new_url = new URL(url);
		new_url.searchParams.set("country", country_val);
      		document.location = new_url.href;
	});
	$('#filter-department').on('change', function(){
		var department_val = $( this ).val();
		var url = current_url + "&department="+department_val;
		var new_url = new URL(url);
		new_url.searchParams.set("department", department_val);
      		document.location = new_url;
	});
	$('#filter-job-type').on('change', function(){
		var job_type_val = $( this ).val();
		var url = current_url + "&job-type="+job_type_val;
		var new_url = new URL(url);
		new_url.searchParams.set("job-type", job_type_val);
      		document.location = new_url;
	});
    	/** Vacancies Filter end **/

    // Sigma college form full time fields
    $( "input[name='wpforms[fields][9]']" ).on( 'click', function() {
    	var job_status_val = $( "input[name='wpforms[fields][9]']:checked" ).val();
    	if( job_status_val == 'Full-time' ){
    		$( '.full_time_fields' ).css( 'display', 'block' );
    		$( '.full_time_fields input' ).prop( 'required',true );
    	} else {
    		$( '.full_time_fields' ).css( 'display', 'none' );
    		$( '.full_time_fields input' ).prop( 'required',false );
    	}
    } );

	/** Air Malta Form ***/
	
	
	$("#departuredate").datepicker({
		dateFormat : "mm-dd-yy",
		minDate: 0,
        onSelect: function(dateStr) {
            var min = $(this).datepicker('getDate') || new Date(); // Selected date or today if none
            $('#returndate').datepicker('option', {minDate: min});
        }
    });

	$("#returndate").datepicker({     
		dateFormat : "mm-dd-yy",
		minDate: 0,
        onSelect: function(dateStr) {
            var max = $(this).datepicker('getDate'); // Selected date or null if none
            $('#departuredate').datepicker('option', {maxDate: max});
        }
    });
	$("#returnWay").click(function(event){
		console.log('prop: ' + $(this).prop('checked'));
		if($(this).prop('checked')){
			$("#returndate").prop('disabled', false);
		}
	})
	$("#oneWay").click(function(event){
		console.log('prop oneway: ' + $(this).prop('checked'));
		if($(this).prop('checked')){
			$("#returndate").prop('disabled', true);
		}
	})
	
	$("#airlineRegForm").submit(function(event) {
		event.preventDefault();
		let values = {};
		$("#airlineRegForm :input").each(function() {
			let thisType = $(this).attr('type');
			if(thisType && (typeof $(this).prop('disabled') == 'undefined' || $(this).prop('disabled') !== true) && ( (thisType !== 'radio' && thisType !== 'checkbox' ) ||  $(this).prop('checked') === true) ){
				values[this.name] = $(this).val().toString();
			}
		});
		
		$("#airlineRegForm select").each(function() {
			values[this.name] = $(this).val().toString();
		});
		
		let adt = 'ADT' in values && values['ADT'] != '' ? values['ADT'] : 0;
		let chd = 'CHD' in values && values['CHD'] != '' ? values['CHD'] : 0;
		let inf = 'INF' in values && values['INF'] != '' ? values['INF'] : 0;
		let totalPersons = parseInt(adt) + parseInt(chd) + parseInt(inf);
		console.log(totalPersons);
		console.log(values);
		// Note: "Flexible Dates" parameter is not working in the old page - the URLs generated with / without Flexible Dates are identical
		if( totalPersons > 0 && 'journeyType' in values  && values['journeyType'] != '' && 'travellingClass' in values  && values['travellingClass'] != '' && 'origin' in values  && values['origin'] != 'select' && 'destination' in values  && values['destination'] != 'select' && 'date' in values  && values['date'] != '' && (values['journeyType'] != 'round-trip' || (values['journeyType'] == 'round-trip'  && values['date1'] != '' && 'date1' in values) ) ) {
			let finalUrlPartOne = 	'https://flight.airmalta.com/dx/KMDX/#/flight-selection?journeyType=' + values['journeyType'] 
									+ '&locale=en-GB&searchType=BRANDED&class=' + values['travellingClass']  
									+ '&ADT=' + adt + '&CHD=' + chd + '&INF=' + inf 
									+ '&YTH=0&origin=' + values['origin'] 
									+ '&destination=' + values['destination'] + '&date=' + values['date'];
			let finalUrlPartTwo = 	values['journeyType'] == 'round-trip'
									? '&origin1=' + values['destination'] + '&destination1=' + values['origin'] + '&date1=' + values['date1'] + '&promoCode=MKMSIGMA20&execution=e1s1'
									: '&promoCode=MKMSIGMA20&execution=e1s1';
			let finalUrl = finalUrlPartOne + finalUrlPartTwo;
			window.open(finalUrl);
		} else {
			alert('Please complete required fields!');
		}
	});
	/** Air Malta Form End ***/

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