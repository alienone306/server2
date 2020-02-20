<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://perfectwpthemes.com
 * @since             1.0.0
 * @package           Perfectwpthemes_Toolkit
 *
 * @wordpress-plugin
 * Plugin Name:       Perfectwpthemes Toolkit
 * Plugin URI:        https://perfectwpthemes.com/perfectwpthemes-toolkit
 * Description:       An essential toolkit for themes made by perfectwpthemes.
 * Version:           1.0.4
 * Author:            perfectwpthemes
 * Author URI:        https://perfectwpthemes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       perfectwpthemes-toolkit
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PERFECTWPTHEMES_TOOLKIT_VERSION', '1.0.4' );

// Define PERFECTWPTHEMESTOOLKIT_PLUGIN_FILE.
if ( ! defined( 'PERFECTWPTHEMESTOOLKIT_PLUGIN_FILE' ) ) {

	define( 'PERFECTWPTHEMESTOOLKIT_PLUGIN_FILE', __FILE__ );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-perfectwpthemes-toolkit-activator.php
 */
function activate_perfectwpthemes_toolkit() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-perfectwpthemes-toolkit-activator.php';
	Perfectwpthemes_Toolkit_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-perfectwpthemes-toolkit-deactivator.php
 */
function deactivate_perfectwpthemes_toolkit() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-perfectwpthemes-toolkit-deactivator.php';
	Perfectwpthemes_Toolkit_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_perfectwpthemes_toolkit' );
register_deactivation_hook( __FILE__, 'deactivate_perfectwpthemes_toolkit' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-perfectwpthemes-toolkit.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_perfectwpthemes_toolkit() {

	$plugin = new Perfectwpthemes_Toolkit();
	$plugin->run();

}
run_perfectwpthemes_toolkit();


// Include the main Demo Importer class.
if ( ! class_exists( 'Perfectwpthemes_Demo_Importer' ) ) {
	include_once dirname( __FILE__ ) . '/includes/demo-importer/class-perfectwpthemes-demo-importer.php';
}

/**
 * Main instance of Perfectwpthemes_Demo_Importer.
 *
 * Returns the main instance of PWPT to prevent the need to use globals.
 *
 * @since 1.0.0
 * @return Perfectwpthemes_Demo_Importer
 */
function PWPT() {
	
	return Perfectwpthemes_Demo_Importer::instance();
}

$theme = perfectwpthemes_toolkit_theme();

$themes = perfectwpthemes_toolkit_theme_array();

if( $theme->get('Author') === 'perfectwpthemes' && in_array( $theme->get('TextDomain'), $themes ) ) {

	// Global for backwards compatibility.
	$GLOBALS['perfectwpthemes-demo-importer'] = PWPT();
}
