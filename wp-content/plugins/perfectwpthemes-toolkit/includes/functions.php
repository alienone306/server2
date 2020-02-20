<?php
/**
 * Function that gets currently activated theme.
 */
if( ! function_exists( 'perfectwpthemes_toolkit_theme' ) ) :

	function perfectwpthemes_toolkit_theme() {

		$theme = wp_get_theme();

        if( $theme->parent() == true ) {

            $theme = $theme->parent();
        }

        return $theme;
	}
endif;


/**
 * Function that gets text-domain of currently activated theme.
 */
if( ! function_exists( 'perfectwpthemes_toolkit_theme_text_domain' ) ) :

	function perfectwpthemes_toolkit_theme_text_domain() {

		$theme = perfectwpthemes_toolkit_theme();

		$theme_text_domain = $theme->get( 'TextDomain' );

        return $theme_text_domain;
	}
endif;


/**
 * Function that sets prefix for currently activated theme.
 */
if( ! function_exists( 'perfectwpthemes_toolkit_theme_prefix' ) ) :

	function perfectwpthemes_toolkit_theme_prefix() {

		$theme_text_domain = perfectwpthemes_toolkit_theme_text_domain();

		if( $theme_text_domain == 'glaze-blog-lite' ) {

			return 'glaze_blog_lite';
		}

		if( $theme_text_domain == 'glaze-blog' ) {

			return 'glaze_blog';
		}

		if( $theme_text_domain == 'masonry-blog' ) {

			return 'masonry_blog';
		}
	}
endif;


/**
 * Function that gets all the themes by perfectwpthemes.
 */
if( ! function_exists( 'perfectwpthemes_toolkit_theme_array' ) ) :

    function perfectwpthemes_toolkit_theme_array() {

        return array( 'glaze-blog', 'glaze-blog-lite', 'masonry-blog' );
    }
endif;


/**
 * Function that includes dependencies for currently activated theme.
 */
if( ! function_exists( 'prefectwpthemes_toolkit_theme_dependencies' ) ) :

	function prefectwpthemes_toolkit_theme_dependencies() {

		$theme_text_domain = perfectwpthemes_toolkit_theme_text_domain();

		if( $theme_text_domain == 'glaze-blog-lite' ) {
			
			require_once plugin_dir_path( __FILE__ ) . 'themes/glaze-blog-lite/class-glaze-blog-lite-theme.php';

			$glaze_blog_lite_theme = new Prefectwpthemes_Toolkit_Glaze_Blog_Lite_Theme();

			add_action( 'admin_notices', 'perfectwpthemes_toolkit_admin_notice' );

			add_action( 'admin_init', 'perfectwpthemes_toolkit_notice_ignore' );		
		}

		if( $theme_text_domain == 'glaze-blog' ) {
			
			require_once plugin_dir_path( __FILE__ ) . 'themes/glaze-blog/class-glaze-blog-theme.php';

			$glaze_blog_theme = new Prefectwpthemes_Toolkit_Glaze_Blog_Theme();

			add_action( 'admin_notices', 'perfectwpthemes_toolkit_admin_notice' );

			add_action( 'admin_init', 'perfectwpthemes_toolkit_notice_ignore' );		
		}

		if( $theme_text_domain == 'masonry-blog' ) {
			
			require_once plugin_dir_path( __FILE__ ) . 'themes/masonry-blog/info.php';

			add_action( 'admin_notices', 'perfectwpthemes_toolkit_admin_notice' );

			add_action( 'admin_init', 'perfectwpthemes_toolkit_notice_ignore' );		
		}
	}
endif;