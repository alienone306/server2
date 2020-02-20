<?php
/**
 * Theme Palace basic theme structure hooks
 *
 * This file contains structural hooks.
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

$options = archie_get_theme_options();


if ( ! function_exists( 'archie_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since Archie 1.0.0
	 */
	function archie_doctype() {
	?>
		<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
	<?php
	}
endif;

add_action( 'archie_doctype', 'archie_doctype', 10 );


if ( ! function_exists( 'archie_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif;
	}
endif;
add_action( 'archie_before_wp_head', 'archie_head', 10 );

if ( ! function_exists( 'archie_page_start' ) ) :
	/**
	 * Page starts html codes
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_page_start() {
		?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'archie' ); ?></a>

		<?php
	}
endif;
add_action( 'archie_page_start_action', 'archie_page_start', 10 );

if ( ! function_exists( 'archie_page_end' ) ) :
	/**
	 * Page end html codes
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'archie_page_end_action', 'archie_page_end', 10 );

if ( ! function_exists( 'archie_header_start' ) ) :
	/**
	 * Header start html codes
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_header_start() {
		$options = archie_get_theme_options();
		?>
		<header id="masthead" class="site-header" role="banner">
		<?php
	}
endif;
add_action( 'archie_header_action', 'archie_header_start', 10 );

if ( ! function_exists( 'archie_site_branding' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_site_branding() {
		$options  = archie_get_theme_options();
		$header_txt_logo_extra = $options['header_txt_logo_extra'];		
		?>
		<div class="site-branding">
			<?php if ( in_array( $header_txt_logo_extra, array( 'show-all', 'logo-title', 'logo-tagline' ) )  ) { ?>
				<div class="site-logo">
					<?php the_custom_logo(); ?>
				</div>
			<?php } 
			if ( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title', 'show-all', 'tagline-only', 'logo-tagline' ) ) ) : ?>
				<div id="site-details">
					<?php
					if( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title' ) )  ) {
						if ( archie_is_latest_posts() ) : ?>
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
add_action( 'archie_header_action', 'archie_site_branding', 20 );

if ( ! function_exists( 'archie_site_navigation' ) ) :
	/**
	 * Site navigation codes
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_site_navigation() {
		$options = archie_get_theme_options();
		?>
		<nav id="site-navigation" class="main-navigation clear" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="menu-label"><?php esc_html_e( 'Menu', 'archie' ); ?></span>
				<?php
				echo archie_get_svg( array( 'icon' => 'menu' ) );
				echo archie_get_svg( array( 'icon' => 'close' ) );
				?>					
			</button>

			<?php  
				$search = '';
				if ( $options['nav_search_enable'] ) :
					$search = '<li class="search-menu">';
					$search .= '<div id="search">';
					$search .= archie_get_svg( array( 'icon' => 'search' ) );
					$search .= get_search_form( $echo = false );
	                $search .= '</div><!-- #search --></li>';
                endif;

        		$defaults = array(
        			'theme_location' => 'primary',
        			'container' => 'div',
        			'menu_class' => 'menu nav-menu',
        			'menu_id' => 'primary-menu',
        			'echo' => true,
        			'fallback_cb' => 'archie_menu_fallback_cb',
        			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s' . $search . '</ul>',
        		);
        	
        		wp_nav_menu( $defaults );
        	?>
		</nav><!-- #site-navigation -->
		<?php
	}
endif;
add_action( 'archie_header_action', 'archie_site_navigation', 30 );


if ( ! function_exists( 'archie_header_end' ) ) :
	/**
	 * Header end html codes
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_header_end() {
		?>
		</header><!-- #masthead -->
		<?php
	}
endif;

add_action( 'archie_header_action', 'archie_header_end', 50 );

if ( ! function_exists( 'archie_content_start' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_content_start() {
		?>
		<div id="content" class="site-content">
		<?php
	}
endif;
add_action( 'archie_content_start_action', 'archie_content_start', 10 );

if ( ! function_exists( 'archie_header_image' ) ) :
	/**
	 * Header Image codes
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_header_image() {
		if ( archie_is_frontpage() )
			return;
		?>
		 <div id="page-detail" class="relative">
            <div class="wrapper">
                <header class="page-header">
                	<?php echo archie_custom_header_banner_title(); ?>
                </header><!-- .page-header -->
            </div><!-- .wrapper -->
        </div><!--#page-detail -->
		<?php
	}
endif;
add_action( 'archie_header_image_action', 'archie_header_image', 10 );

if ( ! function_exists( 'archie_add_breadcrumb' ) ) :
	/**
	 * Add breadcrumb.
	 *
	 * @since Archie 1.0.0
	 */
	function archie_add_breadcrumb() {
		$options = archie_get_theme_options();
		// Bail if Breadcrumb disabled.
		$breadcrumb = $options['breadcrumb_enable'];
		if ( false === $breadcrumb ) {
			return;
		}
		
		// Bail if Home Page.
		if ( archie_is_frontpage() ) {
			return;
		}

		echo '<div id="breadcrumb-list" >';
				/**
				 * archie_simple_breadcrumb hook
				 *
				 * @hooked archie_simple_breadcrumb -  10
				 *
				 */
				do_action( 'archie_simple_breadcrumb' );
		echo '</div><!-- #breadcrumb-list -->';
		return;
	}
endif;
add_action( 'archie_header_image_action', 'archie_add_breadcrumb', 20 );

if ( ! function_exists( 'archie_content_end' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_content_end() {
		?>
		</div><!-- #content -->
		<?php
	}
endif;
add_action( 'archie_content_end_action', 'archie_content_end', 10 );

if ( ! function_exists( 'archie_footer_start' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_footer_start() {
		?>
		<footer id="colophon" class="site-footer" role="contentinfo">
		<?php
	}
endif;
add_action( 'archie_footer', 'archie_footer_start', 10 );

if ( ! function_exists( 'archie_footer_site_info' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_footer_site_info() {
		$theme_data = wp_get_theme();
		$options = archie_get_theme_options();
		$search = array( '[the-year]', '[site-link]' );

        $replace = array( date( 'Y' ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );

        $options['copyright_text'] = str_replace( $search, $replace, $options['copyright_text'] );
		$copyright_text = $options['copyright_text'];

		$powered_by_text = esc_html__( 'All Rights Reserved | ', 'archie' ) . esc_html( $theme_data->get( 'Name') ) . '&nbsp;' . esc_html__( 'by', 'archie' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_html( ucwords( $theme_data->get( 'Author' ) ) ) .'</a>';
		?>
		<div class="site-info">
                <div class="wrapper">
                    <span>
                    	<?php 
                    	echo archie_santize_allow_tag( $copyright_text ); 
                    	if ( function_exists( 'the_privacy_policy_link' ) ) {
							the_privacy_policy_link( ' | ' );
						}
                    	?>
                	</span>
                	<span><?php echo archie_santize_allow_tag( $powered_by_text ); ?></span>
                </div><!-- .wrapper -->    
            </div><!-- .site-info -->

		<?php
	}
endif;
add_action( 'archie_footer', 'archie_footer_site_info', 40 );

if ( ! function_exists( 'archie_footer_scroll_to_top' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_footer_scroll_to_top() {
		$options  = archie_get_theme_options();
		if ( true === $options['scroll_top_visible'] ) : ?>
			<div class="backtotop"><?php echo archie_get_svg( array( 'icon' => 'up' ) ); ?></div>
		<?php endif;
	}
endif;
add_action( 'archie_footer', 'archie_footer_scroll_to_top', 40 );

if ( ! function_exists( 'archie_footer_end' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Archie 1.0.0
	 *
	 */
	function archie_footer_end() {
		?>
		</footer>
		<div class="popup-overlay"></div>
		<?php
	}
endif;
add_action( 'archie_footer', 'archie_footer_end', 100 );


if ( ! function_exists( 'archie_get_author_profile' ) ) :
	/**
	 * Function to get author profile
	 *
	 * @since Archie 1.0.0
	 */           
	function archie_get_author_profile(){
		$options = archie_get_theme_options();
		if ( $options['single_post_hide_author'] ) {
			return;
		} ?>

		<div id="author-section" class="align-center">
            <div class="author-image">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 95 );  ?>
            </div><!-- .author-image -->

            <div class="author-content">
                <h3 class="author-name"><?php the_author_posts_link(); ?>, <span><?php echo esc_html_e( 'Author', 'archie' ); ?></span></h3>
            </div><!-- .author-content -->
        </div><!-- #author -->

	<?php
	}	
endif;
add_action( 'archie_author_profile_action', 'archie_get_author_profile' );