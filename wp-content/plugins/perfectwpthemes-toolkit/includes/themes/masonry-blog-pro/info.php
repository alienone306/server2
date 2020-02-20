<?php
/**
 * Masonry Blog Pro Theme Info Configurations
 *
 * @package Perfectwpthemes_Toolkit
 */

if( ! function_exists( 'perfectwpthemes_toolkit_masonry_blog_pro_config'  ) ) {

	function perfectwpthemes_toolkit_masonry_blog_pro_config() {

		$config = array(
			'menu_name' => esc_html__( 'Masonry Blog Pro Info', 'perfectwpthemes-toolkit' ),
			'page_name' => esc_html__( 'Masonry Blog Pro Info', 'perfectwpthemes-toolkit' ),

			/* translators: theme version */
			'welcome_title' => sprintf( esc_html__( 'Welcome to %s - ', 'perfectwpthemes-toolkit' ), 'Masonry Blog Pro' ),

			'notification' => '',

			/* translators: 1: theme name */
			'welcome_content' => sprintf( esc_html__( 'We hope this page will help you to setup %1$s with few clicks. We believe you will find it easy to use and perfect for your website.', 'perfectwpthemes-toolkit' ), 'perfectwpthemes-toolkit' ),

			// Quick links.
			'quick_links' => array(
				'demo_import_url' => array(
					'text' => esc_html__( 'Import Demo','perfectwpthemes-toolkit' ),
					'url'  => esc_url( admin_url( 'themes.php?page=perfectwpthemes-demo-importer' ) ),
					'button' => 'primary',
					),
				'theme_url' => array(
					'text' => esc_html__( 'Theme Details','perfectwpthemes-toolkit' ),
					'url'  => 'https://perfectwpthemes.com/themes/masonry-blog-pro/',
					),
				'demo_url' => array(
					'text' => esc_html__( 'View Demo','perfectwpthemes-toolkit' ),
					'url'  => 'https://demo.perfectwpthemes.com/01/masonry-blog-pro/',
					),
				'documentation_url' => array(
					'text'   => esc_html__( 'View Documentation','perfectwpthemes-toolkit' ),
					'url'    => 'https://perfectwpthemes.com/masonry-blog-theme-documentation/',
					),
				),

			// Tabs.
			'tabs' => array(
				'getting_started'     => esc_html__( 'Getting Started', 'perfectwpthemes-toolkit' ),
				'recommended_actions' => esc_html__( 'Recommended Actions', 'perfectwpthemes-toolkit' ),
			),

			// Getting started.
			'getting_started' => array(
				array(
					'title'               => esc_html__( 'Import Demo Content', 'perfectwpthemes-toolkit' ),
					'text'                => esc_html__( 'Setup theme easily by importing demo contents.', 'perfectwpthemes-toolkit' ),
					'button_label'        => esc_html__( 'Import Demo', 'perfectwpthemes-toolkit' ),
					'button_link'         => esc_url( admin_url( 'themes.php?page=perfectwpthemes-demo-importer' ) ),
					'is_button'           => true,
					'recommended_actions' => false,
					'is_new_tab'          => false,
				),
				array(
					'title'               => esc_html__( 'Theme Documentation', 'perfectwpthemes-toolkit' ),
					'text'                => esc_html__( 'Find step by step instructions with video documentation to setup theme easily.', 'perfectwpthemes-toolkit' ),
					'button_label'        => esc_html__( 'View documentation', 'perfectwpthemes-toolkit' ),
					'button_link'         => 'https://perfectwpthemes.com/masonry-blog-theme-documentation/',
					'is_button'           => true,
					'recommended_actions' => false,
					'is_new_tab'          => true,
				),
				array(
					'title'               => esc_html__( 'Customize Everything', 'perfectwpthemes-toolkit' ),
					'text'                => esc_html__( 'Start customizing every aspect of the website with customizer.', 'perfectwpthemes-toolkit' ),
					'button_label'        => esc_html__( 'Go to Customizer', 'perfectwpthemes-toolkit' ),
					'button_link'         => esc_url( wp_customize_url() ),
					'is_button'           => true,
					'recommended_actions' => false,
					'is_new_tab'          => false,
				),

				array(
					'title'        			=> esc_html__( 'Youtube Video Tutorials', 'perfectwpthemes-toolkit' ),
					'text'         			=> esc_html__( 'Please check our youtube channel for video instructions of perfectwpthemes-toolkit setup and customization.', 'perfectwpthemes-toolkit' ),
					'button_label' 			=> esc_html__( 'Video Tutorials', 'perfectwpthemes-toolkit' ),
					'button_link'  			=> 'https://www.youtube.com/',
					'is_button'    			=> true,
					'recommended_actions' 	=> false,
					'is_new_tab'   			=> true,
				)
			),
		);

		Perfectwpthemes_Toolkit_Theme_Info::init( $config );
	}
}
add_action( 'after_setup_theme', 'perfectwpthemes_toolkit_masonry_blog_pro_config' );