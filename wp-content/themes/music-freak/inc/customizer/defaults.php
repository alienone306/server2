<?php
/**
 * Customizer default options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 * @return array An array of default values
 */

function music_freak_get_default_theme_options() {
	$music_freak_default_options = array(
		// Color Options
		'header_title_color'			=> '#000',
		'header_tagline_color'			=> '#000',
		'header_txt_logo_extra'			=> 'show-all',
		'theme_color'					=> 'dark-version',
		
		// breadcrumb
		'breadcrumb_enable'				=> true,
		'breadcrumb_separator'			=> '/',
		
		// layout 
		'site_layout'         			=> 'wide',
		'sidebar_position'         		=> 'right-sidebar',
		'post_sidebar_position' 		=> 'right-sidebar',
		'page_sidebar_position' 		=> 'right-sidebar',
		'menu_sticky'					=> false,
		'nav_search_enable'				=> true,
		'nav_social_enable'				=> false,

		// excerpt options
		'long_excerpt_length'           => 25,
		
		// pagination options
		'pagination_enable'         	=> true,
		'pagination_type'         		=> 'default',

		// footer options
		'copyright_text'           		=> sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'music-freak' ), '[the-year]', '[site-link]' ) . esc_html__( ' All Rights Reserved | ', 'music-freak' ),
		'scroll_top_visible'        	=> true,

		// reset options
		'reset_options'      			=> false,
		
		// homepage options
		'enable_frontpage_content' 		=> false,

		// homepage sections sortable
		'sortable' 						=> 'slider,about,music_video,service,blog,cta',

		// blog/archive options
		'your_latest_posts_title' 		=> esc_html__( 'Blogs', 'music-freak' ),
		'read_more_text' 				=> esc_html__( 'Read Full Article', 'music-freak' ),
		'hide_date' 					=> false,
		'hide_category'					=> false,

		// single post theme options
		'single_post_hide_date' 		=> false,
		'single_post_hide_author'		=> false,
		'single_post_hide_category'		=> false,
		'single_post_hide_tags'			=> false,

		/* Front Page */

		// Slider
		'slider_section_enable'			=> true,
		'slider_btn_title'				=> esc_html__( 'Play All', 'music-freak' ),

		// About
		'about_section_enable'			=> true,
		'about_btn_title'				=> esc_html__( 'Read More', 'music-freak' ),

		// music video
		'music_video_section_enable'	=> true,
		'music_video_title'				=> esc_html__( 'Recently Played', 'music-freak' ),
		'music_video_list_title'		=> esc_html__( 'Trending Video', 'music-freak' ),

		// service
		'service_section_enable'		=> true,
		'service_title'					=> esc_html__( 'We provide melodious services to you', 'music-freak' ),

		// blog
		'blog_section_enable'			=> true,
		'blog_content_type'				=> 'category',
		'blog_title'					=> esc_html__( 'Our Latest Blog', 'music-freak' ),

		// Call to action
		'cta_section_enable'			=> true,
		'cta_btn_title'					=> esc_html__( 'Read More', 'music-freak' ),

	);

	$output = apply_filters( 'music_freak_default_theme_options', $music_freak_default_options );

	// Sort array in ascending order, according to the key:
	if ( ! empty( $output ) ) {
		ksort( $output );
	}

	return $output;
}