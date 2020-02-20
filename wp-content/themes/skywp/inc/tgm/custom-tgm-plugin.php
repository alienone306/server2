<?php
/**
 * Recommended plugins for theme operation
 *
 * @package Urchenko Technologies
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */
add_action( 'tgmpa_register', 'skywp_tgm_register' );
function skywp_tgm_register() {

	// Get array of recommended plugins
	$plugins = array(

		array(
			'name'				=> 'Elementor',
			'slug'				=> 'elementor',
			'required'			=> false,
			'force_activation'	=> false,
		),

		array(
			'name'				=> 'Contact Form 7',
			'slug'				=> 'contact-form-7',
			'required'			=> false,
			'force_activation'	=> false,
		),

		array(
			'name'				=> 'One Click Demo Import',
			'slug'				=> 'one-click-demo-import',
			'required'			=> false,
			'force_activation'	=> false,
		),

	);
	
	// Register notice
	$config = array(
		'id'           => 'sky',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'is_automatic' => false,
	);

	tgmpa( $plugins, $config );
}

