<?php
/**
 * Customizer active callbacks
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

if ( ! function_exists( 'music_freak_is_breadcrumb_enable' ) ) :
	/**
	 * Check if breadcrumb is enabled.
	 *
	 * @since Music Freak 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function music_freak_is_breadcrumb_enable( $control ) {
		return $control->manager->get_setting( 'music_freak_theme_options[breadcrumb_enable]' )->value();
	}
endif;

if ( ! function_exists( 'music_freak_is_pagination_enable' ) ) :
	/**
	 * Check if pagination is enabled.
	 *
	 * @since Music Freak 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function music_freak_is_pagination_enable( $control ) {
		return $control->manager->get_setting( 'music_freak_theme_options[pagination_enable]' )->value();
	}
endif;

/**
 * Front Page Active Callbacks
 */

/**
 * Check if slider section is enabled.
 *
 * @since Music Freak 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function music_freak_is_slider_section_enable( $control ) {
	return ( $control->manager->get_setting( 'music_freak_theme_options[slider_section_enable]' )->value() );
}

/**
 * Check if about section is enabled.
 *
 * @since Music Freak 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function music_freak_is_about_section_enable( $control ) {
	return ( $control->manager->get_setting( 'music_freak_theme_options[about_section_enable]' )->value() );
}

/**
 * Check if music video section is enabled.
 *
 * @since Music Freak 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function music_freak_is_music_video_section_enable( $control ) {
	return ( $control->manager->get_setting( 'music_freak_theme_options[music_video_section_enable]' )->value() );
}

/**
 * Check if service section is enabled.
 *
 * @since Music Freak 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function music_freak_is_service_section_enable( $control ) {
	return ( $control->manager->get_setting( 'music_freak_theme_options[service_section_enable]' )->value() );
}

/**
 * Check if blog section is enabled.
 *
 * @since Music Freak 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function music_freak_is_blog_section_enable( $control ) {
	return ( $control->manager->get_setting( 'music_freak_theme_options[blog_section_enable]' )->value() );
}

/**
 * Check if blog section content type is category.
 *
 * @since Music Freak 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function music_freak_is_blog_section_content_category_enable( $control ) {
	$content_type = $control->manager->get_setting( 'music_freak_theme_options[blog_content_type]' )->value();
	return music_freak_is_blog_section_enable( $control ) && ( 'category' == $content_type );
}

/**
 * Check if blog section content type is recent.
 *
 * @since Music Freak 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function music_freak_is_blog_section_content_recent_enable( $control ) {
	$content_type = $control->manager->get_setting( 'music_freak_theme_options[blog_content_type]' )->value();
	return music_freak_is_blog_section_enable( $control ) && ( 'recent' == $content_type );
}

/**
 * Check if cta section is enabled.
 *
 * @since Music Freak 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function music_freak_is_cta_section_enable( $control ) {
	return ( $control->manager->get_setting( 'music_freak_theme_options[cta_section_enable]' )->value() );
}
