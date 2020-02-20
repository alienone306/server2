<?php

/**
 * Function to get post and page sidebar position.
 */
if( ! function_exists( 'perfectwpthemes_toolkit_single_sidebar_position' ) ) {

	function perfectwpthemes_toolkit_single_sidebar_position() {

		$theme_prefix = perfectwpthemes_toolkit_theme_prefix();

		$sidebar_position_key = $theme_prefix . '_sidebar_position';

		$single_sidebar_position = get_post_meta( get_the_ID(), $sidebar_position_key, true );

		return $single_sidebar_position;
	}
}