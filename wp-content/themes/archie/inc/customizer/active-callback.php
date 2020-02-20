<?php
/**
 * Customizer active callbacks
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

if ( ! function_exists( 'archie_is_loader_enable' ) ) :
	/**
	 * Check if loader is enabled.
	 *
	 * @since Archie 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function archie_is_loader_enable( $control ) {
		return $control->manager->get_setting( 'archie_theme_options[loader_enable]' )->value();
	}
endif;

if ( ! function_exists( 'archie_is_breadcrumb_enable' ) ) :
	/**
	 * Check if breadcrumb is enabled.
	 *
	 * @since Archie 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function archie_is_breadcrumb_enable( $control ) {
		return $control->manager->get_setting( 'archie_theme_options[breadcrumb_enable]' )->value();
	}
endif;

if ( ! function_exists( 'archie_is_pagination_enable' ) ) :
	/**
	 * Check if pagination is enabled.
	 *
	 * @since Archie 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function archie_is_pagination_enable( $control ) {
		return $control->manager->get_setting( 'archie_theme_options[pagination_enable]' )->value();
	}
endif;

if ( ! function_exists( 'archie_is_static_homepage_enable' ) ) :
	/**
	 * Check if static homepage is enabled.
	 *
	 * @since Archie 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function archie_is_static_homepage_enable( $control ) {
		return ( 'page' == $control->manager->get_setting( 'show_on_front' )->value() );
	}
endif;

/**
 * Front Page Active Callbacks
 */

/**
 * Check if topbar section is enabled.
 *
 * @since Archie 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function archie_is_topbar_section_enable( $control ) {
	return ( $control->manager->get_setting( 'archie_theme_options[topbar_section_enable]' )->value() );
}

/**
 * Check if slider section is enabled.
 *
 * @since Archie 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function archie_is_slider_section_enable( $control ) {
	return ( $control->manager->get_setting( 'archie_theme_options[slider_section_enable]' )->value() );
}

/**
 * Check if about section is enabled.
 *
 * @since Archie 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function archie_is_about_section_enable( $control ) {
	return ( $control->manager->get_setting( 'archie_theme_options[about_section_enable]' )->value() );
}

/**
 * Check if latest section is enabled.
 *
 * @since Archie 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function archie_is_latest_section_enable( $control ) {
	return ( $control->manager->get_setting( 'archie_theme_options[latest_section_enable]' )->value() );
}

/**
 * Check if service section is enabled.
 *
 * @since Archie 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function archie_is_service_section_enable( $control ) {
	return ( $control->manager->get_setting( 'archie_theme_options[service_section_enable]' )->value() );
}

/**
 * Check if blog section is enabled.
 *
 * @since Archie 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function archie_is_blog_section_enable( $control ) {
	return ( $control->manager->get_setting( 'archie_theme_options[blog_section_enable]' )->value() );
}

/**
 * Check if blog section content type is category.
 *
 * @since Archie 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function archie_is_blog_section_content_category_enable( $control ) {
	$content_type = $control->manager->get_setting( 'archie_theme_options[blog_content_type]' )->value();
	return archie_is_blog_section_enable( $control ) && ( 'category' == $content_type );
}

/**
 * Check if blog section content type is recent.
 *
 * @since Archie 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function archie_is_blog_section_content_recent_enable( $control ) {
	$content_type = $control->manager->get_setting( 'archie_theme_options[blog_content_type]' )->value();
	return archie_is_blog_section_enable( $control ) && ( 'recent' == $content_type );
}

/**
 * Check if cta section is enabled.
 *
 * @since Archie 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function archie_is_cta_section_enable( $control ) {
	return ( $control->manager->get_setting( 'archie_theme_options[cta_section_enable]' )->value() );
}

/**
 * Check if testimonial section is enabled.
 *
 * @since Archie 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function archie_is_testimonial_section_enable( $control ) {
	return ( $control->manager->get_setting( 'archie_theme_options[testimonial_section_enable]' )->value() );
}

/**
 * Check if client section is enabled.
 *
 * @since Archie 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function archie_is_client_section_enable( $control ) {
	return ( $control->manager->get_setting( 'archie_theme_options[client_section_enable]' )->value() );
}

/**
 * Check if video section is enabled.
 *
 * @since Archie 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function archie_is_video_section_enable( $control ) {
	return ( $control->manager->get_setting( 'archie_theme_options[video_section_enable]' )->value() );
}
