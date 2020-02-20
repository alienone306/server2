<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://perfectwpthemes.com
 * @since      1.0.0
 *
 * @package    Perfectwpthemes_Toolkit
 * @subpackage Perfectwpthemes_Toolkit/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Perfectwpthemes_Toolkit
 * @subpackage Perfectwpthemes_Toolkit/includes
 * @author     perfectwpthemes <perfectwpthemes@gmail.com>
 */
class Perfectwpthemes_Toolkit_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'perfectwpthemes-toolkit',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
