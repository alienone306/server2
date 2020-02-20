<?php
/**
 * This file includes helper functions used throughout the theme.
 *
 * @package Urchenko
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
=======================================
:: TABLE OF CONTENTS
=======================================
* TOPBAR
* HEADER
* TYPOGRAPHY
* FOOTER
* BLOG
*/

/*
=======================================
TOPBAR
=======================================
*/

/**
 * Top bar layout connection function
 *
 * @since 1.0.3
 */
add_action( 'skywp_topbar', 'skywp_topbar_template' );
function skywp_topbar_template() {

	if ( true == get_theme_mod( 'sky_topbar', false ) ) {
		get_template_part( 'template-parts/topbar/layout' );
	}

}

/**
 * Add topbar visibility classes
 *
 * @since 1.0.8
 */
function skywp_topbar_visibility_classes() {
	if ( 'all-devices' == get_theme_mod( 'sky_topbar_visibility', 'all-devices' ) ) {
		$classes[] = 'all-devices';
	}
	elseif ( 'hide-tablet' == get_theme_mod( 'sky_topbar_visibility', 'hide-tablet' ) ) {
		$classes[] = 'hide-tablet';
	}
	elseif ( 'hide-mobile' == get_theme_mod( 'sky_topbar_visibility', 'hide-mobile' ) ) {
		$classes[] = 'hide-mobile';
	}
	elseif ( 'hide-tablet-mobile' == get_theme_mod( 'sky_topbar_visibility', 'hide-tablet-mobile' ) ) {
		$classes[] = 'hide-tablet-mobile';
	}
	$classes = implode( ' ', $classes );

	return esc_attr( $classes );
}

/**
 * Top bar style
 *
 * @since 1.0.8
 */
function skywp_topbar_style_classes() {
	if ( 'space-between' == get_theme_mod( 'sky_topbar_style_', 'space-between' ) ) {
		$classes[] = 'top-bar-style-space-between';
	}
	elseif ( 'space-around' == get_theme_mod( 'sky_topbar_style_', 'space-around' ) ) {
		$classes[] = 'top-bar-style-space-around';
	}
	elseif ( 'center' == get_theme_mod( 'sky_topbar_style_', 'center' ) ) {
		$classes[] = 'top-bar-style-center';
	}
	elseif ( 'flex-start' == get_theme_mod( 'sky_topbar_style_', 'flex-start' ) ) {
		$classes[] = 'top-bar-style-flex-start';
	}
	elseif ( 'flex-end' == get_theme_mod( 'sky_topbar_style_', 'flex-end' ) ) {
		$classes[] = 'top-bar-style-flex-end';
	}

	$classes = implode( ' ', $classes );
	return esc_attr( $classes );
}

/**
 * Get content first
 *
 * @since 1.0.8
 */
add_action( 'skywp_topbar_content_before', 'skywp_get_topbar_content_first' );
function skywp_get_topbar_content_first() {
	if ( true == get_theme_mod( 'sky_topbar_content_one', true ) ) {
		get_template_part( 'template-parts/topbar/content-one' );
	}
}

/**
 * Get content second
 *
 * @since 1.0.8
 */
add_action( 'skywp_topbar_content', 'skywp_get_topbar_content_second' );
function skywp_get_topbar_content_second() {
	if ( true == get_theme_mod( 'sky_topbar_content_two', true ) ) {
		get_template_part( 'template-parts/topbar/content-two' );
	}
}

/**
 * Custom styles
 *
 * @since 1.1.4
 */
add_action( 'wp_enqueue_scripts', 'skywp_custom_styles_customizer' );
function skywp_custom_styles_customizer() {
	// BASE
	$sky_default_color = esc_attr( get_theme_mod( 'sky_default_color', '#333333' ) );
	$skywp_typography_body = skywp_typography_body() .', sans-serif';
	$general_width = absint( get_theme_mod( 'general_width', '1200' ) ) .'px';
	$sky_links_color_hover = esc_attr( get_theme_mod( 'sky_links_color_hover', '#0ba6e6' ) );
	$skywp_outer_bg = esc_attr( get_theme_mod( 'skywp_outer_bg', '#ffffff' ) );
	$skywp_inner_bg = esc_attr( get_theme_mod( 'skywp_inner_bg', '#ffffff' ) );
	$skywp_links_color = esc_attr( get_theme_mod( 'skywp_links_color', '#00b4ff' ) );
	$skywp_color_header_all_pages = esc_attr( get_theme_mod( 'skywp_color_header_all_pages', '#333333' ) );

	// TOPBAR
	$topbar_width = absint( get_theme_mod( 'topbar_width', '1200' ) ) .'px';
	$sky_topbar_padding = esc_attr( get_theme_mod( 'sky_topbar_padding', '0px 0px 0px 0px' ) );
	$sky_topbar_position = esc_attr( get_theme_mod( 'sky_topbar_position', 'relative' ) );
	$skywp_bg_topbar = esc_attr( get_theme_mod( 'skywp_bg_topbar', '#ffffff' ) );
	$sky_topbar_text_color = esc_attr( get_theme_mod( 'sky_topbar_text_color', '#c7c7c7' ) );
	$sky_topbar_font_size = absint( get_theme_mod( 'sky_topbar_font_size', '15' ) ) .'px';
	$skywp_social_links_color_topbar = esc_attr( get_theme_mod( 'skywp_social_links_color_topbar', '#333333' ) );

	// HEADER
	$header_width = absint( get_theme_mod( 'header_width', '1200' ) ) .'px';
	$skywp_header_position = esc_attr( get_theme_mod( 'skywp_header_position', 'relative' ) );
	$skywp_bg_header = esc_attr( get_theme_mod( 'skywp_bg_header', '#ffffff' ) );
	$sky_header_offset_top = esc_attr( get_theme_mod( 'sky_header_offset_top', '0' ) ) .'px';
	$skywp_header_offset_top_tablet = esc_attr( get_theme_mod( 'skywp_header_offset_top_tablet', '0' ) ) .'px';
	$skywp_header_offset_top_mobile = esc_attr( get_theme_mod( 'skywp_header_offset_top_mobile', '0' ) ) .'px';
	$skywp_bg_sticky_header = esc_attr( get_theme_mod( 'skywp_bg_sticky_header', '#ffffff' ) );
	$sky_header_text_color = esc_attr( get_theme_mod( 'sky_header_text_color', '#333333' ) );
	$skywp_accent_color = esc_attr( get_theme_mod( 'skywp_accent_color', '#00b4ff' ) );
	$sky_header_font_size = esc_attr( get_theme_mod( 'sky_header_font_size', '14' ) ) .'px';
	$sky_header_font_weight = esc_attr( get_theme_mod( 'sky_header_font_weight', '700' ) );
	$sky_header_letter_spacing = esc_attr( get_theme_mod( 'sky_header_letter_spacing', '1' ) ) .'px';
	$sky_header_text_transform = esc_attr( get_theme_mod( 'sky_header_text_transform', 'uppercase' ) );
	$sky_header_button_color = esc_attr( get_theme_mod( 'sky_header_button_color', '#212121' ) );
	$sky_header_background_mobile = esc_attr( get_theme_mod( 'sky_header_background_mobile', '#212121' ) );
	$sky_header_border_mobile_color = esc_attr( get_theme_mod( 'sky_header_border_mobile_color', '#484848' ) );
	$sky_header_mobile_color = esc_attr( get_theme_mod( 'sky_header_mobile_color', '#ffffff' ) );
	$sky_header_background_hover = esc_attr( get_theme_mod( 'sky_header_background_hover', '#484848' ) );
	$sky_header_color_hover = esc_attr( get_theme_mod( 'sky_header_color_hover', '#ffffff' ) );

	// SUBHEADER
	$sky_subheader_bg_color = esc_attr( get_theme_mod( 'sky_subheader_bg_color', '#fafafa' ) );
	$sky_subheader_padding = esc_attr( get_theme_mod( 'sky_subheader_padding', '30px 0px 30px 0px' ) );
	$sky_subheader_color = esc_attr( get_theme_mod( 'sky_subheader_color', '#333333' ) );
	$sky_subheader_font_weight = esc_attr( get_theme_mod( 'sky_subheader_font_weight', '400' ) );
	$sky_subheader_text_transform = esc_attr( get_theme_mod( 'sky_subheader_text_transform', 'capitalize' ) );
	$sky_subheader_letter_spacing = esc_attr( get_theme_mod( 'sky_subheader_letter_spacing', '0' ) ) .'px';

	// SCROLL TOP
	$skywp_scroll_top_bg = esc_attr( get_theme_mod( 'skywp_scroll_top_bg', '#212121' ) );
	$sky_scroll_up_button_color = esc_attr( get_theme_mod( 'sky_scroll_up_button_color', '#fff' ) );
	$skywp_scroll_top_border_radius = esc_attr( get_theme_mod( 'skywp_scroll_top_border_radius', '3' ) ) .'px';
	$sky_scroll_up_button_color_hover = esc_attr( get_theme_mod( 'sky_scroll_up_button_color_hover', '#fff' ) );

	// WIDGETS
	$sky_tag_link_color = esc_attr( get_theme_mod( 'sky_tag_link_color', '#919191' ) );
	$sky_tag_border_color = esc_attr( get_theme_mod( 'sky_tag_border_color', '#c7c7c7' ) );
	$sky_tag_bg_color = esc_attr( get_theme_mod( 'sky_tag_bg_color', 'rgba(255,255,255, 0)' ) );
	$sky_tag_letter_spacing = esc_attr( get_theme_mod( 'sky_tag_letter_spacing', '1' ) ) .'px';
	$sky_tag_text_transform = esc_attr( get_theme_mod( 'sky_tag_text_transform', 'capitalize' ) );
	$sky_tag_font_weight = esc_attr( get_theme_mod( 'sky_tag_font_weight', '400' ) );
	$sky_tag_link_color_hover = esc_attr( get_theme_mod( 'sky_tag_link_color_hover', '#ffffff' ) );
	$skywp_widget_title_color = esc_attr( get_theme_mod( 'skywp_widget_title_color', '#333333' ) );

	// BUTTON
	$sky_buttons_font_size = esc_attr( get_theme_mod( 'sky_buttons_font_size', '14' ) ) .'px';
	$sky_buttons_font_weight = esc_attr( get_theme_mod( 'sky_buttons_font_weight', '400' ) );
	$sky_buttons_letter_spacing = esc_attr( get_theme_mod( 'sky_buttons_letter_spacing', '0.5' ) ) .'px';
	$sky_buttons_link_color = esc_attr( get_theme_mod( 'sky_buttons_link_color', '#ffffff' ) );
	$sky_buttons_bg_color = esc_attr( get_theme_mod( 'sky_buttons_bg_color', '#00b4ff' ) );
	$sky_theme_buttons_padding = esc_attr( get_theme_mod( 'sky_theme_buttons_padding', '10px 25px 10px 25px' ) );
	$sky_border_buttons = esc_attr( get_theme_mod( 'sky_border_buttons', '0' ) ) .'px';
	$sky_border_buttons_color = esc_attr( get_theme_mod( 'sky_border_buttons_color', '#00b4ff' ) );
	$sky_border_buttons_radius = esc_attr( get_theme_mod( 'sky_border_buttons_radius', '0' ) ) .'px';
	$sky_buttons_text_transform = esc_attr( get_theme_mod( 'sky_buttons_text_transform', 'uppercase' ) );
	$sky_buttons_link_color_hover = esc_attr( get_theme_mod( 'sky_buttons_link_color_hover', '#ffffff' ) );
	$sky_buttons_bg_color_hover = esc_attr( get_theme_mod( 'sky_buttons_bg_color_hover', '#0ba6e6' ) );
	$sky_border_buttons_color_hover = esc_attr( get_theme_mod( 'sky_border_buttons_color_hover', '#00b4ff' ) );

	// INPUT / TEXTAREA
	$sky_forms_border_color_focus = esc_attr( get_theme_mod( 'sky_forms_border_color_focus', '#00b4ff' ) );
	$skywp_form_color = esc_attr( get_theme_mod( 'skywp_form_color', '#c7c7c7' ) );
	$skywp_form_border_color = esc_attr( get_theme_mod( 'skywp_form_border_color', '#c7c7c7' ) );
	$skywp_form_label_color = esc_attr( get_theme_mod( 'skywp_form_label_color', '#333333' ) );
	$sky_forms_placeholder_color = esc_attr( get_theme_mod( 'sky_forms_placeholder_color', '#c7c7c7' ) );

	// PAGINATION
	$sky_pagination_align = esc_attr( get_theme_mod( 'sky_pagination_align', 'center' ) );
	$sky_pagination_color = esc_attr( get_theme_mod( 'sky_pagination_color', '#9a9393' ) );
	$sky_pagination_border_color = esc_attr( get_theme_mod( 'sky_pagination_border_color', '#9a9393' ) );
	$sky_pagination_border_radius = esc_attr( get_theme_mod( 'sky_pagination_border_radius', '3' ) ) .'px';

	// POST
	$sky_post_bg = esc_attr( get_theme_mod( 'sky_post_bg', '#fafafa' ) );
	$sky_post_title_color = esc_attr( get_theme_mod( 'sky_post_title_color', '#333333' ) );
	$sky_post_meta_color = esc_attr( get_theme_mod( 'sky_post_meta_color', '#555555' ) );
	$sky_article_page = esc_attr( get_theme_mod( 'sky_article_page', '#333333' ) );
	$skywp_article_page_bg_prev_next = esc_attr( get_theme_mod( 'skywp_article_page_bg_prev_next', '#fafafa' ) );

	// FOOTER
	$footer_width = absint( get_theme_mod( 'footer_width', '1200' ) ) .'px';
	$sky_footer_bg = esc_attr( get_theme_mod( 'sky_footer_bg', '#212121' ) );
	$skywp_footer_padding = esc_attr( get_theme_mod( 'skywp_footer_padding', '85px 0px 85px 0px' ) );
	$sky_footer_title_color = esc_attr( get_theme_mod( 'sky_footer_title_color', '#ffffff' ) );
	$sky_footer_border_color = esc_attr( get_theme_mod( 'sky_footer_border_color', '#c7c7c7' ) );
	$sky_footer_text_color = esc_attr( get_theme_mod( 'sky_footer_text_color', '#c7c7c7' ) );

	// COPYRIGHT
	$footer_copyright_width = absint( get_theme_mod( 'footer_copyright_width', '1200' ) ) .'px';
	$sky_copyright_bg = esc_attr( get_theme_mod( 'sky_copyright_bg', '#191c1e' ) );
	$skywp_footer_padding_copyright = esc_attr( get_theme_mod( 'skywp_footer_padding_copyright', '25px 0px 25px 0px' ) );
	$skywp_copyright_alignment = esc_attr( get_theme_mod( 'skywp_copyright_alignment', 'center' ) );
	

	$custom_css = "

		/*** BASE ***/
		body { color: $sky_default_color; font-family: $skywp_typography_body; }
		.site_widget,
		.site_widget select { color: $sky_default_color; }
		.wrapper { width: $general_width; }
		a { color: $skywp_accent_color; }
		#wrap.outer-wrapper { background: $skywp_outer_bg }
		#content #content-wrap { background: $skywp_inner_bg }

		.site_widget ul li a,
		.widget_calendar .calendar_wrap a,
		#content-wrap  .navigation.post-navigation .nav-links a,
		#comments .comment-list .comment .comment-body .comment-meta .comment-author .fn,
		#comments .comment-list .comment .comment-body .comment-meta .comment-author .fn a,
		#comments .comment-list .comment .comment-body .comment-meta .comment-metadata a,
		#comments .comment-list .comment .comment-body .reply a,
		#respond .logged-in-as a,
		.page-attachment .image-navigation .nav-links a,
		.page-attachment .entry-footer a { color: $skywp_links_color; }

		a:hover,
		#content-wrap .navigation.post-navigation .nav-links a:hover,
		#comments .comment-list .comment .comment-body .comment-meta .comment-author .fn a:hover,
		#comments .comment-list .comment .comment-body .comment-meta .comment-metadata a:hover,
		#comments .comment-list .comment .comment-body .reply a:hover,
		#respond .logged-in-as a:hover,
		.page-attachment .image-navigation .nav-links a:hover,
		.page-attachment .entry-footer a:hover,
		#footer-area .author-theme a:hover,
		.page-attachment .image-navigation .nav-links a:hover,
		.page-attachment .entry-footer a:hover { color: $sky_links_color_hover; }

		#content-wrap .post-content-wrap .entry-title,
		#comments .comments-title,
		#respond .comment-reply-title,
		.no-results .page-header .page-title,
		.no-results .content-wrap .column-first .oops,
		.no-results .content-wrap .column-second h3,
		.error-404 .content-page .site_widget .error,
		.page-attachment .entry-header .entry-title { color: $skywp_color_header_all_pages; }
		


		/*** TOPBAR ***/
		#top-bar-wrap .wrapper { width: $topbar_width; }
		#top-bar { padding: $sky_topbar_padding; }
		#top-bar-wrap { position: $sky_topbar_position; background: $skywp_bg_topbar; }
		#top-bar-inner { color: $sky_topbar_text_color; }
		#top-bar-inner #top-bar-content-one,
		#top-bar-inner #top-bar-content-two { font-size: $sky_topbar_font_size; }
		.social-navigation .social-links-menu li a { color: $skywp_social_links_color_topbar; }

		/*** HEADER ***/
		#site-header .wrapper { width: $header_width; }
		#site-header { position: $skywp_header_position; background: $skywp_bg_header; top: $sky_header_offset_top; }
		@media screen and (min-width: 425px) and (max-width: 768px) { #site-header.resize-offset-top-tablet { top: $skywp_header_offset_top_tablet; }}
		@media screen and (max-width: 425px) { #site-header.resize-offset-top-mobile { top: $skywp_header_offset_top_mobile; }}
		#site-header.fixed { background: $skywp_bg_sticky_header; }
		#site-logo .site-title,
		#site-logo .site-description,
		#site-navigation-wrap #site-navigation #menu-all-pages .menu-item a,
		#icom-search .menu_toggle_class { color: $sky_header_text_color; }

		#site-logo .site-title:hover,
		.standard-current-menu #site-navigation-wrap #site-navigation #menu-all-pages .menu-item a:hover,
		#site-navigation-wrap #site-navigation #menu-all-pages .menu-item .sub-menu .menu-item a:hover,
		#site-navigation-wrap #site-navigation #menu-all-pages .menu-item .sub-menu .menu-item a:focus,
		.social-navigation .social-links-menu li a:hover::before,
		#icom-search .menu_toggle_class:focus,
		#icom-search .menu_toggle_class:hover { color: $skywp_accent_color; }

		#site-header .hc-nav-trigger:focus span,
		#site-header .hc-nav-trigger:focus span::before,
		#site-header .hc-nav-trigger:focus span::after { background: $skywp_accent_color; }

		#site-navigation-wrap #site-navigation #menu-all-pages .menu-item a { 
			font-size: $sky_header_font_size; font-weight: $sky_header_font_weight; letter-spacing: $sky_header_letter_spacing; text-transform: $sky_header_text_transform; }
		#site-header.standard-current-menu #site-navigation-wrap #site-navigation .current-menu-item a { color: $skywp_accent_color; }

		#site-header .hc-nav-trigger span,
		#site-header .hc-nav-trigger span::before,
		#site-header .hc-nav-trigger span::after { background: $sky_header_button_color; }
		body .hc-offcanvas-nav .nav-container, .hc-offcanvas-nav .nav-wrapper, .hc-offcanvas-nav ul { background: $sky_header_background_mobile; }
		body .hc-offcanvas-nav li.nav-close a, .hc-offcanvas-nav li.nav-back a { background: $sky_header_background_mobile; border-top: 1px solid $sky_header_border_mobile_color; border-bottom: 1px solid $sky_header_border_mobile_color; }
		body .hc-offcanvas-nav a,
		body .hc-offcanvas-nav .nav-item { color: $sky_header_mobile_color; border-bottom: 1px solid $sky_header_border_mobile_color; }
		body .hc-offcanvas-nav span.nav-next::before,
		body .hc-offcanvas-nav li.nav-back span::before { border-top: 2px solid $sky_header_mobile_color; border-left: 2px solid $sky_header_mobile_color; }
		body .hc-offcanvas-nav li.nav-close span::before,
		body .hc-offcanvas-nav li.nav-close span::after { border-top: 2px solid $sky_header_mobile_color; border-left: 2px solid $sky_header_mobile_color; }
		body .hc-offcanvas-nav a[href]:not([href=".'"#"'."]) > span.nav-next { border-left: 1px solid $sky_header_border_mobile_color; }
		body .hc-offcanvas-nav li.nav-close a:hover, .hc-offcanvas-nav li.nav-back a:hover { background: $sky_header_background_hover; }
		body .hc-offcanvas-nav:not(.touch-device) a:hover { color: $sky_header_color_hover; background: $sky_header_background_hover; }


		/*** SUBHEADER ***/
		#site-subheader { background: $sky_subheader_bg_color; padding: $sky_subheader_padding; }
		#site-subheader .content ul li { color: $sky_subheader_color; 
		font-weight: $sky_subheader_font_weight; 
		text-transform: $sky_subheader_text_transform; 
		letter-spacing: $sky_subheader_letter_spacing; }
		#site-subheader .content ul li a,
		#site-subheader .content ul li i.arrows-right { color: $sky_subheader_color; }
		#site-subheader .content ul li a:hover { color: $sky_links_color_hover; }
		#site-subheader .content ul li a i:hover { color: $sky_links_color_hover; }


		/*** SCROLL TOP ***/
		#scroll-top { background: $skywp_scroll_top_bg; color: $sky_scroll_up_button_color; border-radius: skywp_scroll_top_border_radius; }
		#scroll-top:hover { background: $skywp_accent_color; color: $sky_scroll_up_button_color_hover; }


		/*** WIDGETS ***/
		.site_widget a:hover { color: $sky_links_color_hover; }
		.site_widget .tagcloud a { color: $sky_tag_link_color; border: 1px solid $sky_tag_border_color; background: $sky_tag_bg_color; letter-spacing: $sky_tag_letter_spacing; text-transform: $sky_tag_text_transform; font-weight: $sky_tag_font_weight; }
		.site_widget .tagcloud a:hover,
		.site_widget .tagcloud a:focus { background: $skywp_accent_color; color: $sky_tag_link_color_hover; border: 1px solid $skywp_accent_color; }
		.site_widget  ul li:before { background: $skywp_accent_color; }
		.site_widget h2 { color: $skywp_widget_title_color; }


		/*** BUTTON ***/
		button, [type=" .'"button"'. "], [type=" .'"reset"'. "], [type=" .'"submit"'. "], .skywp-button, #infinite-handle span { font-size: $sky_buttons_font_size; font-weight: $sky_buttons_font_weight; letter-spacing: $sky_buttons_letter_spacing; color: $sky_buttons_link_color; background: $sky_buttons_bg_color; padding: $sky_theme_buttons_padding; border: $sky_border_buttons solid $sky_border_buttons_color; border-radius: $sky_border_buttons_radius; text-transform: $sky_buttons_text_transform; }

		button:hover, 
		button:focus, 
		[type=" .'"button"'. "]:hover, 
		[type=" .'"button"'. "]:focus, 
		[type=" .'"reset"'. "]:hover, 
		[type=" .'"reset"'. "]:focus, 
		[type=" .'"submit"'. "]:hover, 
		[type=" .'"submit"'. "]:focus, 
		.skywp-button:hover, 
		.skywp-button:focus, 
		#infinite-handle span:hover,
		#infinite-handle span:focus { color: $sky_buttons_link_color_hover; background: $sky_buttons_bg_color_hover; 
		border: $sky_border_buttons solid $sky_border_buttons_color_hover; }


		/*** INPUT / TEXTAREA ***/
		input[type=" .'"text"'. "]:focus, input[type=" .'"checkbox"'. "]:focus, input[type=" .'"email"'. "]:focus, input[type=" .'"url"'. "]:focus, input[type=" .'"password"'. "]:focus, input[type=" .'"search"'. "]:focus, input[type=" .'"number"'. "]:focus, input[type=" .'"tel"'. "]:focus, input[type=" .'"range"'. "]:focus, input[type=" .'"date"'. "]:focus, input[type=" .'"month"'. "]:focus, input[type=" .'"week"'. "]:focus, input[type=" .'"time"'. "]:focus, input[type=" .'"datetime"'. "]:focus, input[type=" .'"datetime-local"'. "]:focus, input[type=" .'"color"'. "]:focus, textarea:focus { border-color: $sky_forms_border_color_focus; }
		input:not([type=" .'"submit"'. "]),
		textarea { color: $skywp_form_color; border: 1px solid $skywp_form_border_color; }
		label { color: $skywp_form_label_color; }
		input::-webkit-input-placeholder, textarea::-webkit-input-placeholder { color: $sky_forms_placeholder_color; }
		input::-moz-placeholder, textarea::-moz-placeholder { color: $sky_forms_placeholder_color; }
		input:-ms-input-placeholder, textarea:-ms-input-placeholder { color: $sky_forms_placeholder_color; }
		input::-ms-input-placeholder, textarea::-ms-input-placeholder { color: $sky_forms_placeholder_color; }
		input::placeholder, textarea::placeholder { color: $sky_forms_placeholder_color; }


		/*** PAGINATION ***/
		nav.navigation.pagination { text-align: $sky_pagination_align; }
		nav.navigation.pagination .page-numbers { color: $sky_pagination_color; border-color: $sky_pagination_border_color; border-radius: $sky_pagination_border_radius; }
		nav.navigation.pagination .page-numbers:hover { color: $skywp_accent_color; border-color: $skywp_accent_color; }
		nav.navigation.pagination .page-numbers.current { color: $skywp_accent_color; border-color: $skywp_accent_color; }


		/*** POST ***/
		#content-wrap #primary #main-style article .blog-wrap { background: $sky_post_bg; }
		#content-wrap #primary #main-style article .blog-wrap .post-content-wrap .entry-title a { color: $sky_post_title_color; }
		#content-wrap #primary #main-style article .blog-wrap .post-content-wrap .entry-title a:hover { color: $sky_links_color_hover; }
		
		/* Blog page */
		#content-wrap .blog-page article .blog-wrap .post-content-wrap .entry-meta,
		#content-wrap .blog-page article .blog-wrap .post-content-wrap .entry-meta a { color: $sky_post_meta_color; }

		/* Article page */
		#content-wrap .article-page article .blog-wrap .post-content-wrap .entry-meta,
		#content-wrap .article-page article .blog-wrap .post-content-wrap .entry-meta a { color: $sky_article_page; }

		#content-wrap #primary #main-style article .blog-wrap .post-content-wrap .entry-meta ul li a:hover { color: $sky_links_color_hover; }
		#wrap blockquote { border-left: 3px solid $skywp_accent_color; }
		#content-wrap #primary article .blog-wrap .post-content-wrap .entry-meta a:hover { color: $sky_links_color_hover; }

		#content-wrap .navigation.post-navigation .nav-links { background: $skywp_article_page_bg_prev_next; }


		/*** FOOTER ***/
		#footer-wrapper .wrapper { width: $footer_width; }
		#footer-wrapper { background: $sky_footer_bg; padding: $skywp_footer_padding; }
		#footer-area .site_widget h2 { color: $sky_footer_title_color; border-bottom: 1px solid $sky_footer_border_color; }
		#footer-area .site_widget,
		#footer-area .site_widget a,
		#footer-area .author-theme a { color: $sky_footer_text_color; }
		#footer-area .site_widget a:hover { color: $sky_tag_link_color_hover; }


		/*** COPYRIGHT ***/
		#copyright .wrapper { width: $footer_copyright_width; }
		#copyright { background: $sky_copyright_bg; }
		#copyright .container { padding: $skywp_footer_padding_copyright;
		-webkit-box-pack: $skywp_copyright_alignment;
	    -ms-flex-pack: $skywp_copyright_alignment;
	        justify-content: $skywp_copyright_alignment; }

		";
	wp_add_inline_style( 'skywp-main-style', $custom_css );
}



/*
=======================================
HEADER
=======================================
*/

/**
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 *
 * @since 1.1.4
 */
if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Triggered after the opening <body> tag.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

/**
 * Header layout template
 *
 * @since 1.0.3
 */
add_action( 'skywp_header', 'skywp_header_template' );
function skywp_header_template() {

	if ( 'standard' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) {
		get_template_part( 'template-parts/header/layout' );
	}
	elseif ( 'centered' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) {
		get_template_part( 'template-parts/header/layout' );
	}
	elseif ( 'left_aligned' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) {
		get_template_part( 'template-parts/header/layout' );
	}
	elseif ( 'standard_2' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) {
		get_template_part( 'template-parts/header/layout' );
	}
	elseif ( 'banner' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) {
		get_template_part( 'template-parts/header/layout' );
	}
	
}

/**
 * Change styles headers
 *
 * @since 1.1.4
 */
function skywp_change_styles_headers() {

	if ( 'standard' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) {
		$classes[] = 'standard-menu';
	}
	elseif ( 'centered' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) {
		$classes[] = 'centered-menu';
	}
	elseif ( 'left_aligned' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) {
		$classes[] = 'left-aligned-menu';
	}
	elseif ( 'standard_2' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) {
		$classes[] = 'standard-2-menu';
	}
	elseif ( 'banner' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) {
		$classes[] = 'banner-menu';
	}

	$classes = implode( ' ', $classes );
	return esc_attr( $classes );
	
}

/**
 * Header layout template logo
 *
 * @since 1.0.3
 */
add_action( 'skywp_header_logo', 'skywp_header_template_logo' );
function skywp_header_template_logo() {

	get_template_part( 'template-parts/header/logo' );

}

/**
 * Header banner
 *
 * @since 1.1.4
 */
add_action( 'skywp_header_banner', 'skywp_header_template_banner' );
function skywp_header_template_banner() {

	if ( 'banner' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) {
		
		get_template_part( 'template-parts/header/header-banner' );

	}

}

/**
 * Custom Header
 *
 * @since 1.2.0
 */
add_action( 'skywp_custom_header', 'skywp_custom_header_template' );
function skywp_custom_header_template() {

	if ( has_custom_header() ) {
		get_template_part( 'template-parts/header/custom-header' );
	}
	
}

/**
 * Header layout template menu navigation
 *
 * @since 1.0.3
 */
add_action( 'skywp_header_nav', 'skywp_header_template_nav' );
function skywp_header_template_nav() {

	get_template_part( 'template-parts/header/nav' );

}

/**
 * Current menu item style
 *
 * @since 1.0.3
 */
function skywp_current_menu_item_style() {
	if ( 'standard' == get_theme_mod( 'skywp_header_links_effect', 'standard' ) ) {
		$classes[] = 'standard-current-menu';
	} 
	else if ( 'style-second' == get_theme_mod( 'skywp_header_links_effect', 'standard' ) ) {
		$classes[] = 'style-second-current-menu';
	}
	$classes = implode( ' ', $classes );
	return esc_attr( $classes );
}

/**
 * Connect icon-search to the header
 *
 * @since 1.0.0
 */
add_action( 'skywp_right_hook', 'skywp_header_icon_search_template' );
function skywp_header_icon_search_template() {

	if ( true == get_theme_mod( 'skywp_header_show_search', true ) ) {
		get_template_part( 'template-parts/header/icon-search' );
	}

}

/**
 * Connect search to the header
 *
 * @since 1.0.3
 */
add_action( 'skywp_header_search', 'skywp_header_search_template' );
function skywp_header_search_template() {

	if ( true == get_theme_mod( 'skywp_header_show_search', true ) ) {
		if ( 'dropdown' == get_theme_mod( 'skywp_header_search_menu_style', 'dropdown' ) ) {
			get_template_part( 'template-parts/header/search-dropdown' );
		}
	}

}

/**
 * Remove 'no-border-bottom' class if setting = 'true'
 *
 * @since 1.0.8
 */
function skywp_border_bottom_class() {
	$classes[] = '';
	if ( true == get_theme_mod( 'sky_header_border_bottom', false ) ) {
		$classes[] = 'border-bottom';
	}
	$classes = implode( ' ', $classes );
	return esc_attr( $classes );
}

/*
=======================================
TYPOGRAPHY
=======================================
*/

/**
 * Typography Select
 *
 * @since 1.0.0
 */
add_action('wp_enqueue_scripts', 'skywp_typography_body');
function skywp_typography_body() {

	if ( 'roboto' == get_theme_mod( 'sky_typography_font_family', 'roboto' ) ) {
		wp_register_style( 'skywp-google-fonts', '//fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap&subset=cyrillic-ext,greek-ext' );
		$classes[] = 'Roboto';
		
	} else if ( 'open-sans' == get_theme_mod( 'sky_typography_font_family', 'roboto' ) ) {
		wp_register_style( 'skywp-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap&subset=cyrillic-ext,greek-ext' );
		$classes[] = 'Open Sans';
	} else if ( 'montserrat' == get_theme_mod( 'sky_typography_font_family', 'roboto' ) ) {
		wp_register_style( 'skywp-google-fonts', '//fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800,900&display=swap&subset=cyrillic' );
		$classes[] = 'Montserrat';
	} 
	wp_enqueue_style( 'skywp-google-fonts' );

	// Turn classes array into space seperated string
	$classes = implode( ' ', $classes );

	// Return classes
	return esc_attr( $classes );
}

/*
=======================================
FOOTER
=======================================
*/

/**
 * Footer layout templates
 *
 * @since 1.0.3
 */
add_action( 'skywp_footer_layout', 'skywp_footer_layout_templates' );
function skywp_footer_layout_templates() {

	// Footer 4 | 25%
	if ( '4_25' == get_theme_mod('sky_footer_layout', '4_25' ) ) {
		get_template_part( 'template-parts/footer/footer-4-25' );
	}

}

/**
 * Add classes for footer layout
 *
 * @since 1.0.3
 */
if ( ! function_exists( 'skywp_footer_classes' ) ) {

	function skywp_footer_classes() {

	if ( '4_25' == get_theme_mod('sky_footer_layout', '4_25' ) ) {
		$classes[] = 'four-columns';
	}

	$classes = implode( ' ', $classes );

	return $classes;

}

}

/**
 * Write who the author of the theme
 *
 * @since 1.0.3
 */
add_action( 'skywp_copyright_template', 'skywp_footer_copyright_text' );
function skywp_footer_copyright_text() {
	?>
	<div class="column">
		<div class="author-theme">
			<a href="<?php echo esc_url( 'https://urchenko.ru' ); ?>" target="_blank"><?php esc_html_e( 'SkyWP Theme WordPress', 'skywp' ); ?></a>
		</div>
	</div>
	<?php
}

/*
=======================================
BLOG
=======================================
*/

/**
 * Select post style
 *
 * @since 1.0.8
 */
function skywp_select_post_style() {
	if ( 'default' == get_theme_mod( 'skywp_post_style', 'default' ) ) {
		$classes[] = 'style-default';
	} else if ( 'masonry' == get_theme_mod( 'skywp_post_style', 'default' ) ) {
		$classes[] = 'style-masonry';
	}
	$classes = implode( ' ', $classes );
	return esc_attr( $classes );
}

/**
 * Number of columns posts
 * 
 * @since 1.0.8
 */
function skywp_number_columns_posts() {
	if ( 'one' == get_theme_mod( 'skywp_post_number_columns', 'one' ) ) {
		$classes[] = 'number-columns-one';
	} else if ( 'two' == get_theme_mod( 'skywp_post_number_columns', 'one' ) ) {
		$classes[] = 'number-columns-two';
	} else if ( 'three' == get_theme_mod( 'skywp_post_number_columns', 'one' ) ) {
		$classes[] = 'number-columns-three';
	}
	$classes = implode( ' ', $classes );
	return esc_attr( $classes );
}




