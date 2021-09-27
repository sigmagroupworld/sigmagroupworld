
    jQuery(document).ready(function(){

      jQuery('.sec-point .single-point .single-point-desc').fadeOut();

       // jQuery('.sec-point .single-point a').click(function(e){
       //  e.preventDefault();
       //  jQuery(this).next().fadeToggle();
       // })

          jQuery('.red-more-para').click(function(e){
             e.preventDefault();
             jQuery('.about-casino-tx p').fadeToggle();
             jQuery('.about-casino-tx h3 + p').toggleClass('open');
          });
 
        // INTIAL CHECK IF ANY ACTIVE TABS 
      function checkActivetab(){
        var activeTab = jQuery('.tab-o-btn.active').attr('data-open');
      jQuery('.casino-tabz').each(function(){
          var matchTo = jQuery(this).attr('data-tab');
          if(activeTab == matchTo){
              jQuery(this).fadeIn();
          }
      })

      }
      checkActivetab();

        jQuery('.tab-o-btn').each(function(){
            jQuery(this).click(function(e){
                // e.preventDefault();
                jQuery('.tab-o-btn').removeClass('active');
                jQuery(this).addClass('active');
                var match = jQuery(this).attr('data-open');
               openEr(match);
            //    console.log(match);
            })
        })
        function openEr(e){
            var matchh = e;
            jQuery('.casino-tabz').each(function(e){
                var matchTo = jQuery(this).attr('data-tab');
                  
                  if(matchh == matchTo){
                    //   $(this).addClass('open');
                    jQuery(this).fadeIn();
                  }
                  else{
                    //   $(this).removeClass('open');
                    jQuery(this).fadeOut();

                  }
                })
        }
        // SHOW ALL SCRIPTS
        jQuery('.show-all-btn-global').click(function(e){
          e.preventDefault();
          var toCheck = jQuery(this).attr('data-open');
          jQuery('.connector-show-all').each(function(){
            var checkr = jQuery(this).attr('data-open');
            if(toCheck == checkr){
              jQuery(this).find('.hide-all').fadeToggle();
            }
          })
        })

    });


   