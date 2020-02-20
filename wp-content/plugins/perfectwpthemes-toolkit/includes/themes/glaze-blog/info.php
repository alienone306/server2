<?php
/**
 * Glaze Blog Theme Info Configurations
 *
 * @package Perfectwpthemes_Toolkit
 */

if( ! function_exists( 'perfectwpthemes_toolkit_glaze_blog_config'  ) ) {

	function perfectwpthemes_toolkit_glaze_blog_config() {

		$config = array(
			'menu_name' => esc_html__( 'Glaze Blog Info', 'perfectwpthemes-toolkit' ),
			'page_name' => esc_html__( 'Glaze Blog Info', 'perfectwpthemes-toolkit' ),

			/* translators: theme version */
			'welcome_title' => sprintf( esc_html__( 'Welcome to %s - ', 'perfectwpthemes-toolkit' ), 'Glaze Blog' ),

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
					'url'  => 'https://perfectwpthemes.com/themes/glaze-blog-lite/',
					),
				'demo_url' => array(
					'text' => esc_html__( 'View Demo','perfectwpthemes-toolkit' ),
					'url'  => 'https://perfectwpthemes.com/themes/glaze-blog-lite',
					),
				'documentation_url' => array(
					'text'   => esc_html__( 'View Documentation','perfectwpthemes-toolkit' ),
					'url'    => 'https://perfectwpthemes.com/glaze-blog-theme-documentation/',
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
					'button_link'         => 'https://perfectwpthemes.com/glaze-blog-theme-documentation/',
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
				),
				array(
					'title'        			=> esc_html__( 'Contact Support', 'perfectwpthemes-toolkit' ),
					'text'         			=> esc_html__( 'If you have any problem, feel free to create ticket on our dedicated Support forum.', 'perfectwpthemes-toolkit' ),
					'button_label' 			=> esc_html__( 'Contact Support', 'perfectwpthemes-toolkit' ),
					'button_link'  			=> 'https://perfectwpthemes.com/support-forum/',
					'is_button'    			=> true,
					'recommended_actions' 	=> false,
					'is_new_tab'   			=> true,
				),
			),

			// Recommended actions.
			'recommended_actions' => array(
				'content' => array(
					'contact-form-7' => array(
						'title'       => esc_html__( 'Contact Form 7', 'perfectwpthemes-toolkit' ),
						'description' => esc_html__( 'Contact Form 7 can manage multiple contact forms, plus you can customize the form and the mail contents flexibly with simple markup. The form supports Ajax-powered submitting, CAPTCHA, Akismet spam filtering and so on.', 'perfectwpthemes-toolkit' ),
						'check'       => class_exists( 'WPCF7' ),
						'plugin_slug' => 'contact-form-7',
						'id'          => 'contact-form-7',
					),
					'elementor' => array(
						'title'       => esc_html__( 'Elementor Page Builder', 'perfectwpthemes-toolkit' ),
						'description' => esc_html__( 'The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.', 'perfectwpthemes-toolkit' ),
						'check'       => defined( 'ELEMENTOR_VERSION' ),
						'plugin_slug' => 'elementor',
						'id'          => 'elementor',
					),
					'woocommerce' => array(
						'title'       => esc_html__( 'Woocommerce', 'perfectwpthemes-toolkit' ),
						'description' => esc_html__( 'WooCommerce is a free eCommerce plugin that allows you to sell anything, beautifully. Built to integrate seamlessly with WordPress, WooCommerce is the world’s favorite eCommerce solution that gives both store owners and developers complete control.', 'perfectwpthemes-toolkit' ),
						'check'       => class_exists( 'Woocommerce' ),
						'plugin_slug' => 'woocommerce',
						'id'          => 'woocommerce',
					),
				),
			),
		);

		Perfectwpthemes_Toolkit_Theme_Info::init( $config );
	}
}
add_action( 'after_setup_theme', 'perfectwpthemes_toolkit_glaze_blog_config' );