( function ( $ ) {
	"use strict";


jQuery(document).ready(function($) {

  /************ Mobile menu, script HC Off-canvas Nav ************/
  var position = sky_header_position_mobile_menu.sky_header_position_mobile_menu,
      levelOpen = sky_header_opening_mobile_menu.sky_header_opening_mobile_menu;
  $('#site-navigation-wrap').hcOffcanvasNav({
    maxWidth: 1025,
    position: position,
    levelOpen: levelOpen,
    
  });
  // Function for the correct operation of the mobile menu from the keyboard using the TAB key
  // Works in conjunction with skip-link-focus-fix.js
  $(".button-nav-next").keyup( function( event ) {
    if( event.keyCode == 13 ){
      $( this ).click();
    }
  });



  /************ Show the menu in the header ************/
  $( '#icom-search .menu_toggle_class' ).on( 'click', function() {
    $( '#searchform-dropdown' ).toggleClass( 'show' );
  });
  // Close search
  $( '#top-bar-wrap, #content' ).on( 'click', function() {
    $( '#searchform-dropdown' ).removeClass( 'show' );
  });



  /************ Gradually scroll to top ************/
  $("#scroll-top").mPageScroll2id({
    forceSingleHighlight: true,
    offset: 30,
  });



  /************ Alignment of records in style masonry ************/
  var enable_masonry = skywp_post_style.skywp_post_style;
  if ( 'masonry' == enable_masonry ) {
    $('.style-masonry').masonry({
      itemSelector: '.item'
    });
  }



  /************ Scroll up button ************/
  var nav = $('#scroll-top');
  $(window).scroll(function () {
    if ($(this).scrollTop() > 500) {
      nav.addClass("block");
    } else {
      nav.removeClass("block");
    }
  });



  /************ Header fixed menu navigation ************/
  var inner = $( '#site-header' );
  if ( true == sky_header_sticky_value.sky_header_sticky ) {
    $( window ).scroll( function () {
      if ( $( this ).scrollTop() > 500 ) {
        inner.addClass( "fixed" );
      } else {
        inner.removeClass( "fixed" );
      }
    });
  }



});


$( window ).load(function() {
 
});


  




})(jQuery);