<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class PWPT_Theme_Demo_Glaze_Blog_Lite extends PWPT_Theme_Demo {

	public static function import_files() {

		$server_url = 'https://perfectwpthemes.com/demo-contents/glaze-blog-lite/';

		$demo_urls  = array(
			array(
				'import_file_name'           => esc_html__( 'Demo One', 'perfectwpthemes-toolkit' ),
				'import_file_url'            => $server_url . 'demo-one/contents.xml',
				'import_widget_file_url'     => $server_url . 'demo-one/widgets.wie',
				'import_customizer_file_url' => $server_url . 'demo-one/customizer.dat',
				'import_preview_image_url'   => $server_url . 'demo-one/screenshot.png',
				'demo_url'                   => 'https://demo.perfectwpthemes.com/01/glaze-blog-lite/',
			),
			array(
				'import_file_name'           => esc_html__( 'Demo Two', 'perfectwpthemes-toolkit' ),
				'import_file_url'            => $server_url . 'demo-two/contents.xml',
				'import_widget_file_url'     => $server_url . 'demo-two/widgets.wie',
				'import_customizer_file_url' => $server_url . 'demo-two/customizer.dat',
				'import_preview_image_url'   => $server_url . 'demo-two/screenshot.png',
				'demo_url'                   => 'https://demo.perfectwpthemes.com/01/glaze-blog-lite-two/',
			),
		);

		return $demo_urls;
	}

	public static function after_import( $selected_import ) {

		$primary_menu 	= get_term_by('name', 'Main Menu', 'nav_menu');  
	    $header_menu 	= get_term_by('name', 'Top Menu', 'nav_menu');

	    set_theme_mod(
	     	'nav_menu_locations', 
	     	array( 
	     		'menu-1' => $primary_menu->term_id, 
	     		'menu-2' => $header_menu->term_id,
	     	)
	    );

		update_option( 'perfetwpthemes_themes', $installed_demos );
	}
}