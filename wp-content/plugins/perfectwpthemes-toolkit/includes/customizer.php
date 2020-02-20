<?php
/**
 * Perfectwpthemes Toolkit Customizer Loader
 *
 * @package Perfectwpthemes_Toolkit
 */
$theme_text_domain = perfectwpthemes_toolkit_theme_text_domain();

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function perfectwpthemes_toolkit_customize_register( $wp_customize ) {

	/**
	 * Load custom customizer control for alpha color picker
	 */
	require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/customizer/controls/class-customizer-alpha-color-control.php';

	/**
	 * Load custom customizer control for slider
	 */
	require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/customizer/controls/class-customizer-slider-control.php';

	/**
	 * Load custom customizer control for multiple dropdown select
	 */
	require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/customizer/controls/class-customizer-multiple-select-control.php';

	/**
	 * Load custom customizer control for radio image control
	 */
	require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/customizer/controls/class-customizer-radio-image-control.php';

	/**
	 * Load custom customizer control for toggle control
	 */
	require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/customizer/controls/class-customizer-toggle-control.php';

	/**
	 * Load custom customizer control for repeater fields control
	 */
	require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/customizer/controls/class-customizer-repeater-control.php';

	/**
	 * Load customizer functions for intializing panel, section, and control fields
	 */
	require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/customizer/functions/reuseable-callback.php';

	/**
	 * Load customizer functions for sanitization of input values of contol fields
	 */
	require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/customizer/functions/sanitize-callback.php';

	/**
	 * Load customizer functions for loading control field's choices, declaration of panel, section 
	 * and control fields
	 */
	$theme_text_domain = perfectwpthemes_toolkit_theme_text_domain();

	require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/themes/' . $theme_text_domain . '/customizer/functions/customizer-fields.php';

}
add_action( 'customize_register', 'perfectwpthemes_toolkit_customize_register' );



/**
 * Load active callback functions.
 */
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/themes/' . $theme_text_domain . '/customizer/functions/active-callback.php';

/**
 * Load function to load customizer field's default values.
 */
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/themes/' . $theme_text_domain . '/customizer/functions/customizer-defaults.php';


/**
 * Load function to load dynamic style.
 */
require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/themes/' . $theme_text_domain . '/customizer/functions/dynamic-style.php';


/**
 * Enqueue Customizer Scripts and Styles
 */
function perfectwpthemes_toolkit_enqueues() {

	wp_enqueue_style( 'chosen', plugin_dir_url( __FILE__ ) . 'customizer/assets/css/chosen.css' );

	wp_enqueue_style( 'perfectwpthemes-toolkit-main-styles', plugin_dir_url( __FILE__ ) . 'customizer/assets/css/main-styles.css' );

	$theme_text_domain = perfectwpthemes_toolkit_theme_text_domain();

	wp_enqueue_script( 'chosen', plugin_dir_url( __FILE__ ) . 'customizer/assets/js/chosen.js', array( 'jquery' ), PERFECTWPTHEMES_TOOLKIT_VERSION, true );

	wp_enqueue_script( 'perfectwpthemes-toolkit-scripts', plugin_dir_url( __FILE__ ) . 'themes/' . $theme_text_domain . '/customizer/assets/js/scripts.js', array( 'jquery' ), PERFECTWPTHEMES_TOOLKIT_VERSION, true );
}
add_action( 'customize_controls_enqueue_scripts', 'perfectwpthemes_toolkit_enqueues' );

/**
 * Function to get customizer options.
 */
if ( ! function_exists( 'perfectwpthemes_toolkit_get_option' ) ) {

    /**
     * Get theme option.
     *
     * @since 1.0.0
     *
     * @param string $key Option key.
     * @return mixed Option value.
     */
    function perfectwpthemes_toolkit_get_option( $key ) {

        if ( empty( $key ) ) {
            return;
        }

        $theme_prefix = perfectwpthemes_toolkit_theme_prefix();

        $fullkey = $theme_prefix . '_field_'. $key;

        $value = '';

        $default = perfectwpthemes_toolkit_get_default_theme_options();

        $default_value = null;

        if ( is_array( $default ) && isset( $default[ $key ] ) ) {
            $default_value = $default[ $key ];
        }

        if ( null !== $default_value ) {
            $value = get_theme_mod( $fullkey, $default_value );
        }
        else {
            $value = get_theme_mod( $fullkey );
        }

        return $value;
    }
}