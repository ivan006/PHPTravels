
//------------------------------
//Custom Select
//------------------------------
jQuery(document).ready(function(){
"use strict";
	jQuery('.mySelectBoxClass').customSelect();

	/* -OR- set a custom class name for the stylable element */
	//jQuery('.mySelectBoxClass').customSelect({customClass:'mySelectBoxClass'});
});

function mySelectUpdate(){
"use strict";
	setTimeout(function (){
		jQuery('.mySelectBoxClass').trigger('update');
	}, 200);
}

jQuery(window).resize(function() {
"use strict";
	mySelectUpdate();
});


//------------------------------
//CaroufredSell
//------------------------------
jQuery(document).ready(function(jQuery){
"use strict";
	jQuery("#foo").carouFredSel({
		width: "100%",
		height: 240,
		items: {
			visible: 5,
			minimum: 1,
			start: 2
		},
		scroll: {
			items: 1,
			easing: "easeInOutQuad",
			duration: 500,
			pauseOnHover: true
		},
		auto: false,
		prev: {
			button: "#prev_btn",
			key: "left"
		},
		next: {
			button: "#next_btn",
			key: "right"
		},
		swipe: true
	});


	jQuery("#foo2").carouFredSel({
		width: "100%",
		height: 240,
		items: {
			visible: 5,
			minimum: 1,
			start: 2
		},
		scroll: {
			items: 1,
			easing: "easeInOutQuad",
			duration: 500,
			pauseOnHover: true
		},
		auto: false,
		prev: {
			button: "#prev_btn2",
			key: "left"
		},
		next: {
			button: "#next_btn2",
			key: "right"
		},
		swipe: true
	});


});

//------------------------------
//Nice Scroll
//------------------------------
		jQuery(document).ready(function() {
		"use strict";
			var nice = jQuery("html").niceScroll({
				cursorcolor:"#ccc",
				cursorborder :"0px solid #fff",
				railpadding:{top:0,right:0,left:0,bottom:0},
				cursorwidth:"5px",
				cursorborderradius:"0px",
				cursoropacitymin:0,
				cursoropacitymax:0.7,
				boxzoom:true,
				autohidemode:false
			});

			jQuery(".hotelstab").niceScroll({horizrailenabled:false});
			jQuery(".flightstab").niceScroll({horizrailenabled:false});
			jQuery(".vacationstab").niceScroll({horizrailenabled:false});
			jQuery(".carstab").niceScroll({horizrailenabled:false});
			jQuery(".cruisestab").niceScroll({horizrailenabled:false});
			jQuery(".flighthotelcartab").niceScroll({horizrailenabled:false});
			jQuery(".flighthoteltab").niceScroll({horizrailenabled:false});
			jQuery(".flightcartab").niceScroll({horizrailenabled:false});
			jQuery(".hotelcartab").niceScroll({horizrailenabled:false});

			jQuery('html').addClass('no-overflow-y');

		});




//------------------------------
//Slider parallax effect
//------------------------------

jQuery(document).ready(function(jQuery){
"use strict";
var jQueryscrollTop;
var jQueryheaderheight;
var jQueryloggedin = false;

if(jQueryloggedin == false){
  jQueryheaderheight = jQuery('.navbar-wrapper2').height() - 20;
} else {
  jQueryheaderheight = jQuery('.navbar-wrapper2').height() + 100;
}


jQuery(window).scroll(function(){
"use strict";
  var jQueryiw = jQuery('body').innerWidth();
  jQueryscrollTop = jQuery(window).scrollTop();
	  if ( jQueryiw < 992 ) {

	  }
	  else{
	   jQuery('.navbar-wrapper2').css({'min-height' : 110-(jQueryscrollTop/2) +'px'});
	  }

  //jQuery(".sboxpurple").css({'opacity' : 1-(jQueryscrollTop/300)});
  jQuery(".scrolleffect").css({'top': ((- jQueryscrollTop / 5)+ jQueryheaderheight) + 30  + 'px' });
  jQuery(".tp-leftarrow").css({'left' : 20-(jQueryscrollTop/2) +'px'});
  jQuery(".tp-rightarrow").css({'right' : 20-(jQueryscrollTop/2) +'px'});
});

});



//------------------------------
//SCROLL ANIMATIONS
//------------------------------

	jQuery(window).scroll(function(){
"use strict";
		var jQueryiw = jQuery('body').innerWidth();


		//Social
		if(jQuery(window).scrollTop() >= 300){
			jQuery('.social1').stop().animate({top:'0px'}, 100);

			setTimeout(function (){
				jQuery('.social2').stop().animate({top:'0px'}, 100);
			}, 100);

			setTimeout(function (){
				jQuery('.social3').stop().animate({top:'0px'}, 100);
			}, 200);

			setTimeout(function (){
				jQuery('.social4').stop().animate({top:'0px'}, 100);
			}, 300);

			setTimeout(function (){
				jQuery('.gotop').stop().animate({top:'0px'}, 200);
			}, 400);

		}
		else {
			setTimeout(function (){
				jQuery('.gotop').stop().animate({top:'100px'}, 200);
			}, 400);
			setTimeout(function (){
				jQuery('.social4').stop().animate({top:'-120px'}, 100);
			}, 300);
			setTimeout(function (){
				jQuery('.social3').stop().animate({top:'-120px'}, 100);
			}, 200);
			setTimeout(function (){
			jQuery('.social2').stop().animate({top:'-120px'}, 100);
			}, 100);

			jQuery('.social1').stop().animate({top:'-120px'}, 100);

		}


	});






//------------------------------
//ROLLOVER
//------------------------------

var theSide = 'marginLeft';
var options = {};
options[theSide] = jQuery('.one').width()/2-15;
jQuery(".one")
	.mouseenter(function() {
	"use strict";
		jQuery(".mhover", this).addClass( "block" );
		jQuery(".mhover", this).removeClass( "none" );
		jQuery(".icon", this).stop().animate(options, 100);
	})
jQuery(".one").mouseleave(function() {
"use strict";
		jQuery(".mhover", this).addClass( "none" );
		jQuery(".mhover", this).removeClass( "block" );
		jQuery(".icon", this).stop().animate({marginLeft:"0px"}, 100);
	});









jQuery(document).ready(function(){
"use strict";
/* GETS 100% HEIGHT FOR FILTERS BG*/
//var jQuerypgc = jQuery('.pagecontainer').height();
//jQuery('.filters').css({'height':jQuerypgc+'px'});



});

// ########################
// BACK TO TOP FUNCTION
// ########################


jQuery(document).ready(function(){
"use strict";

	// hide #back-top first
	jQuery("#back-top").hide();

	// fade in #back-top
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 700) {
				jQuery('#back-top').fadeIn();
			} else {
				jQuery('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		jQuery('#back-top a').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 500);
			return false;
		});

				// scroll body to 0px on click
		jQuery('a#gotop2').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 500);
			return false;
		});

		var jQueryih = jQuery('body').innerHeight();

		jQuery(".scroll").click(function(event){
			event.preventDefault();
			jQuery('html,body').animate({scrollTop:jQuery(this.hash).offset().top - jQueryih}, 1500);
		});





	});
});



