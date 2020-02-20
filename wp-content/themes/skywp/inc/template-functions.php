<?php
/**
 * @package Urchenko Technologies
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
add_filter( 'body_class', 'skywp_body_classes' );
function skywp_body_classes( $classes ) {
	// Adding a site color scheme class
	if ( 'scheme-light' == get_theme_mod( 'skywp_color_scheme', 'scheme-light' ) ) {
		$classes[] = 'scheme-light';
	}
	elseif ( 'scheme-dark' == get_theme_mod( 'skywp_color_scheme', 'scheme-light' ) ) {
		$classes[] = 'scheme-dark';
	}

	return $classes;
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
add_action( 'wp_head', 'skywp_pingback_header' );
function skywp_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
