<?php
/**
 * Theme Palace basic theme structure hooks
 *
 * This file contains structural hooks.
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

$options = music_freak_get_theme_options();


if ( ! function_exists( 'music_freak_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since Music Freak 1.0.0
	 */
	function music_freak_doctype() {
	?>
		<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
	<?php
	}
endif;

add_action( 'music_freak_doctype', 'music_freak_doctype', 10 );


if ( ! function_exists( 'music_freak_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif;
	}
endif;
add_action( 'music_freak_before_wp_head', 'music_freak_head', 10 );

if ( ! function_exists( 'music_freak_page_start' ) ) :
	/**
	 * Page starts html codes
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_page_start() {
		?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'music-freak' ); ?></a>

		<?php
	}
endif;
add_action( 'music_freak_page_start_action', 'music_freak_page_start', 10 );

if ( ! function_exists( 'music_freak_page_end' ) ) :
	/**
	 * Page end html codes
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'music_freak_page_end_action', 'music_freak_page_end', 10 );

if ( ! function_exists( 'music_freak_header_start' ) ) :
	/**
	 * Header start html codes
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_header_start() { ?>
		<header id="masthead" class="site-header" role="banner">
			<div class="wrapper">
		<?php
	}
endif;
add_action( 'music_freak_header_action', 'music_freak_header_start', 10 );

if ( ! function_exists( 'music_freak_site_branding' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_site_branding() {
		$options  = music_freak_get_theme_options();
		$header_txt_logo_extra = $options['header_txt_logo_extra'];		
		?>
		<div class="site-menu">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <?php
				echo music_freak_get_svg( array( 'icon' => 'menu' ) );
				echo music_freak_get_svg( array( 'icon' => 'close' ) );
				?>	
                <span class="menu-label"><?php esc_html_e( 'Menu', 'music-freak' ); ?></span>
            </button><!-- .menu-toggle -->

			<div class="site-branding">
				<?php if ( in_array( $header_txt_logo_extra, array( 'show-all', 'logo-title', 'logo-tagline' ) )  ) { ?>
					<div class="site-logo">
						<?php the_custom_logo(); ?>
					</div>
				<?php } 
				if ( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title', 'show-all', 'tagline-only', 'logo-tagline' ) ) ) : ?>
					<div id="site-identity">
						<?php
						if( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title' ) )  ) {
							if ( music_freak_is_latest_posts() ) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php
							endif;
						} 
						if ( in_array( $header_txt_logo_extra, array( 'show-all', 'tagline-only', 'logo-tagline' ) ) ) {
							$description = get_bloginfo( 'description', 'display' );
							if ( $description || is_customize_preview() ) : ?>
								<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
							<?php
							endif; 
						}?>
					</div>
				<?php endif; ?>
			</div><!-- .site-branding -->
		<?php
	}
endif;
add_action( 'music_freak_header_action', 'music_freak_site_branding', 20 );

if ( ! function_exists( 'music_freak_site_navigation' ) ) :
	/**
	 * Site navigation codes
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_site_navigation() { 
		$options  = music_freak_get_theme_options(); ?>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<?php  
                $search = '';
				if ( $options['nav_search_enable'] ) :
					$search = '<li class="search-menu">';
					$search .= get_search_form( $echo = false );
	                $search .= '</li>';
                endif;

                $social = '';
                if ( $options['nav_search_enable'] ) :
					$social_defaults = array(
	        			'theme_location' => 'social',
	        			'container' => 'div',
	    				'container_class' => 'social-icons',
	        			'menu_class' => '',
	        			'menu_id' => '',
	        			'echo' => false,
	        			'depth' => 1,
	        			'link_before' => '<span class="screen-reader-text">',
						'link_after' => '</span>',
	        		);
					$social .= '<li class="social-menu-item">';
					$social .= wp_nav_menu( $social_defaults );
					$social .= '</li>';
				endif;

        		$defaults = array(
        			'theme_location' => 'primary',
        			'container' => 'div',
        			'menu_class' => 'menu nav-menu',
        			'menu_id' => 'primary-menu',
        			'echo' => true,
        			'fallback_cb' => 'music_freak_menu_fallback_cb',
        			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s' . $search . $social . '</ul>',
        		);
        	
        		wp_nav_menu( $defaults );
        	?>
		</nav><!-- #site-navigation -->
		</div><!-- .site-menu -->

		<?php
	}
endif;
add_action( 'music_freak_header_action', 'music_freak_site_navigation', 30 );

if ( ! function_exists( 'music_freak_header_end' ) ) :
	/**
	 * Header end html codes
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_header_end() {
		?>
			</div><!-- .wrapper -->
		</header><!-- #masthead -->
		<?php
	}
endif;

add_action( 'music_freak_header_action', 'music_freak_header_end', 40 );

if ( ! function_exists( 'music_freak_content_start' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_content_start() {
		?>
		<div id="content" class="site-content">
		<?php
	}
endif;
add_action( 'music_freak_content_start_action', 'music_freak_content_start', 10 );

if ( ! function_exists( 'music_freak_header_image' ) ) :
	/**
	 * Header Image codes
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_header_image() {
		if ( music_freak_is_frontpage() )
			return;
		$header_image = get_header_image();
		if ( is_singular() ) :
			$header_image = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : $header_image;
		endif;
		?>

		<div id="page-site-header" class="relative" style="background-image: url('<?php echo esc_url( $header_image ); ?>');">
            <div class="overlay"></div>
            <div class="wrapper">
                <header class="page-header">
                    <h2 class="page-title"><?php echo music_freak_custom_header_banner_title(); ?></h2>
                </header>

                <?php music_freak_add_breadcrumb(); ?>
            </div><!-- .wrapper -->
        </div><!-- #page-site-header -->

	<?php
	}
endif;
add_action( 'music_freak_header_image_action', 'music_freak_header_image', 10 );

if ( ! function_exists( 'music_freak_add_breadcrumb' ) ) :
	/**
	 * Add breadcrumb.
	 *
	 * @since Music Freak 1.0.0
	 */
	function music_freak_add_breadcrumb() {
		$options = music_freak_get_theme_options();

		// Bail if Breadcrumb disabled.
		$breadcrumb = $options['breadcrumb_enable'];
		if ( false === $breadcrumb ) {
			return;
		}
		
		// Bail if Home Page.
		if ( music_freak_is_frontpage() ) {
			return;
		}

		echo '<div id="breadcrumb-list" >';
				/**
				 * music_freak_simple_breadcrumb hook
				 *
				 * @hooked music_freak_simple_breadcrumb -  10
				 *
				 */
				do_action( 'music_freak_simple_breadcrumb' );
		echo '</div><!-- #breadcrumb-list -->';
	}
endif;

if ( ! function_exists( 'music_freak_content_end' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_content_end() {
		?>
			<div class="menu-overlay"></div>
		</div><!-- #content -->
		<?php
	}
endif;
add_action( 'music_freak_content_end_action', 'music_freak_content_end', 10 );

if ( ! function_exists( 'music_freak_footer_start' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_footer_start() {
		?>
		<footer id="colophon" class="site-footer" role="contentinfo">
		<?php
	}
endif;
add_action( 'music_freak_footer', 'music_freak_footer_start', 10 );

if ( ! function_exists( 'music_freak_footer_site_info' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_footer_site_info() {
		$options = music_freak_get_theme_options();
		$theme_data = wp_get_theme();
		$search = array( '[the-year]', '[site-link]' );

        $replace = array( date( 'Y' ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );

        $options['copyright_text'] = str_replace( $search, $replace, $options['copyright_text'] );
        $options['poweredby_text'] = esc_html( $theme_data->get( 'Name') ) . '&nbsp;' . esc_html__( 'by', 'music-freak' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_html( ucwords( $theme_data->get( 'Author' ) ) ) .'</a>';

		$copyright_text = $options['copyright_text']; 
		$poweredby_text = $options['poweredby_text']; 

		?>
		<div class="site-info col-3">
            <div class="wrapper">
                <span>
                	<?php 
                	echo music_freak_santize_allow_tag( $copyright_text ); 
                	echo music_freak_santize_allow_tag( $poweredby_text ); 
                	if ( function_exists( 'the_privacy_policy_link' ) ) {
						the_privacy_policy_link( ' | ' );
					}
                	?>
            	</span>

            	<?php  
            		$defaults = array(
	        			'theme_location' => 'footer',
	        			'container' => 'div',
	        			'container_class' => 'custom-menu',
	        			'menu_class' => false,
	        			'menu_id' => false,
	        			'echo' => true,
	        			'fallback_cb' => 'music_freak_menu_fallback_cb',
	        		);
	        	
	        		wp_nav_menu( $defaults );

	        		$defaults = array(
	        			'theme_location' => 'social',
	        			'container' => 'div',
	    				'container_class' => 'social-icons',
	        			'menu_class' => '',
	        			'menu_id' => '',
	        			'echo' => true,
	        			'fallback_cb' => 'music_freak_menu_fallback_cb',
	        			'depth' => 1,
	        			'link_before' => '<span class="screen-reader-text">',
						'link_after' => '</span>',
	        		);
	        		
	        		wp_nav_menu( $defaults );
            	?>
            </div><!-- .wrapper -->    
        </div><!-- .site-info -->

		<?php
	}
endif;
add_action( 'music_freak_footer', 'music_freak_footer_site_info', 40 );

if ( ! function_exists( 'music_freak_footer_scroll_to_top' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_footer_scroll_to_top() {
		$options  = music_freak_get_theme_options();
		if ( true === $options['scroll_top_visible'] ) : ?>
			<div class="backtotop"><?php echo music_freak_get_svg( array( 'icon' => 'up' ) ); ?></div>
		<?php endif;
	}
endif;
add_action( 'music_freak_footer', 'music_freak_footer_scroll_to_top', 40 );

if ( ! function_exists( 'music_freak_footer_end' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Music Freak 1.0.0
	 *
	 */
	function music_freak_footer_end() {
		?>
		</footer>
		<div class="popup-overlay"></div>
		<?php
	}
endif;
add_action( 'music_freak_footer', 'music_freak_footer_end', 100 );

