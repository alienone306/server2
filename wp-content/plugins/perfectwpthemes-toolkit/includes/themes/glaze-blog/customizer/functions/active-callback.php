<?php
/**
 * Collection of active callback functions for customizer fields.
 *
 * @package Perfectwpthemes_Toolkit
 */

/**
 * Active callback function for when top header is active.
 */
if( ! function_exists( 'perfectwptheme_toolkit_active_global_share' ) ) {

	function perfectwptheme_toolkit_active_global_share( $control ) {

		if ( $control->manager->get_setting( 'glaze_blog_field_display_social_share_global' )->value() == true ) {

			return true;
		} else {
			
			return false;
		}		
	}
}