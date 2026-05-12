	$(document).ready(function() {
	  //open navigation
//       $('.openmenu').click(function() {
//       $('.openmenu').css('display','none');
// 	  $('.closemenu').css('display','block');
// 	  //$('.navbx').css({'left':'0', 'box-shadow': '0px 0px 0px 2000px rgba(0, 0, 0, 0.52)'});
// 	  $('.navbx').addClass('slidenav');
// 	  //Close navigation
// 	  $('.closemenu').click(function() {
// 	  $('.openmenu').css('display','block');
// 	  $('.closemenu').css('display','none');
// 	  $('.navbx').removeAttr("style");
// 	  $('.navbx').removeClass("slidenav");
// 	  });
// 	});
	
	//Top Navigation
// 	$("ul.menu > li ul").addClass("sub-menu");
// 	$("ul.menu > li").find("ul").before("<span class=dropdown>");
// 	$("ul.menu li span").on('click', function(e) {
// 	e.preventDefault();
// 	$(this).next("ul").slideToggle();
// 	});
	
	//Wow Effect
	//new WOW().init();
	
	//Request meha menu	
	  
	 //Popup//
   $('#login').click(function(e) {	
 
	$('<div class="loginoverlay"></div>').insertBefore('.loginpopup');
    $('.loginpopup').addClass('showup');
    });
   $('.login').click(function(e) {	 
	$('<div class="loginoverlay"></div>').insertBefore('.loginpopup');
    $('.loginpopup').addClass('showup');
    });


   $('#loginPopup').click(function(e) {	
 
	$('<div class="loginoverlay"></div>').insertBefore('.loginpopup');
    $('.loginpopup').addClass('showup');
    });


   $('.closebtn').click(function(e) {
	 $('.loginpopup').removeClass('showup');
	 $('.loginoverlay').fadeOut();
	 $('input[type="reset"]').click();
});


 //Gallery//
   $('.lightBox').click(function(e) {
	$('<div class="loginoverlay"></div>').insertBefore('.galleryPopup');
	var t_img = $(this).data('t_img');
	$('#p_count').html(t_img);
	$('a[href="'+t_img+'"]').click();
    $('.galleryPopup').addClass('showup');
    });
	
	$('.thumb').click(function(e){
		e.preventDefault();
		$('#p_count').html($(this).attr('href'));
	});
	
	$(document).on('click','.next,.prev',function(e){
		e.preventDefault();
		$('#p_count').html($('.selected').find('a').attr('href'));
	});
	
   $('.closebtn').click(function(e) {
	 $('.galleryPopup').removeClass('showup');
	 $('.loginoverlay').fadeOut();
	 $('input[type="reset"]').click();
});

$('.bottom-icon a').click(function(e) {
	/* $('.tab-content > #rewandrate').removeClass('active in');
    $('.tab-content > #wrt').addClass('active in');
	$('.newtab > li').removeClass('active');
	$('.newtab > li:last-child').addClass('active'); */
	$('.tab-content > div').removeClass('active in');
    $('.tab-content > #wrt').addClass('active in');
	$('.newtab > li').removeClass('active');
	$('.newtab > li > a[href="#wrt"]').parents('li').addClass('active');
});

		// ***********************************
		// APPROACHING RATINGS AND REVIEWS TAB
			var hash = window.location.hash;
			if(hash!=''){
				$('.tab-content > div').removeClass('active in');
				$('.tab-content > #rewandrate').addClass('active in');
				$('.newtab > li').removeClass('active');
				$('.newtab > li > a[href="#rewandrate"]').parents('li').addClass('active');
			}
		// APPROACHING RATINGS AND REVIEWS TAB
		// ***********************************
	});
	
	//Window Resize Function
	jQuery(window).resize(function(){
	var w = jQuery(window).width();
	if (w > 991) {
	jQuery('.colaspbtn').removeAttr("style");
	jQuery('ul.menu, .sub-menu').removeAttr("style");
	}
	});
	
	
	// Page Scroll Event
	//$(window).scroll(function() {
//        if($(window).scrollTop() > 90) {
//           $('#header').addClass('sticyhead')
//        } else {
//            $('#header').removeClass('sticyhead')
//        }
//    });

$(window).scroll(function() {
	if($(window).scrollTop() > 400) {
			$('.searchform').addClass('scrollsearch'),
			$('.scrollheadsearch').addClass('showform'),
			 $('#header').addClass('scrollHd')
        } else {
			$('.searchform').removeClass('scrollsearch'),
			$('.scrollheadsearch').removeClass('showform'),
			$('#header').removeClass('scrollHd')
      }
    });
	
