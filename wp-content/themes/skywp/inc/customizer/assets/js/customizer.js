/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

	/***** TOPBAR *****/

	// Topbar background
	wp.customize( 'skywp_bg_topbar', function( value ){
		value.bind( function( newval ){
			$( '#top-bar-wrap' ).css({ 'background': newval });
		});
	});

	// Topbar social links color
	wp.customize( 'skywp_social_links_color_topbar', function( value ){
		value.bind( function( newval ){
			$( '.social-navigation .social-links-menu li a' ).css({ 'color': newval });
		});
	});

	// First content area
	wp.customize( 'sky_topbar_content_textarea_one', function( value ) {
		value.bind( function( newval ) {
			$( '#top-bar-content-one' ).html( newval );
		});
	});

	// Second content area
	wp.customize( 'sky_topbar_content_textarea_two', function( value ) {
		value.bind( function( newval ) {
			$( '#top-bar-content-two' ).html( newval );
		});
	});

	/***** HEADER *****/

	// Background header
	wp.customize( 'skywp_bg_header', function( value ){
		value.bind( function( newval ){
			$( '#site-header' ).css({ 'background': newval });
		});
	});

	// Background sticky header  
	wp.customize( 'skywp_bg_sticky_header', function( value ){
		value.bind( function( newval ){
			$( '#site-header.fixed' ).css({ 'background': newval });
		});
	});

	/***** BLOG *****/

	// Background
	wp.customize( 'sky_post_bg', function( value ) {
		value.bind( function( newval ) {
			$( '#content-wrap #primary #main-style article .blog-wrap' ).css({'background': newval} );
		});
	});

	// Title
	wp.customize( 'sky_post_title_color', function( value ) {
		value.bind( function( newval ) {
			$( '#content-wrap #primary #main-style article .blog-wrap .post-content-wrap .entry-title a' ).css({'color': newval} );
		});
	});

	// Meta
	wp.customize( 'sky_post_meta_color', function( value ) {
		value.bind( function( newval ) {
			$( '#content-wrap #primary #main-style article .blog-wrap .post-content-wrap .entry-meta ul li, #content-wrap #primary #main-style article .blog-wrap .post-content-wrap .entry-meta ul li a' ).css({'color': newval} );
		});
	});

	/***** BASE *****/

	// Outer Background
	wp.customize( 'skywp_outer_bg', function( value ) {
		value.bind( function( newval ) {
			$( '#wrap.outer-wrapper' ).css({'background': newval} );
		});
	});

	// Inner Background
	wp.customize( 'skywp_inner_bg', function( value ) {
		value.bind( function( newval ) {
			$( '#content #content-wrap' ).css({'background': newval} );
		});
	});

	


	





} )( jQuery );
