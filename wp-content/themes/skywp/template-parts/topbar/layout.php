<?php
/**
* Topbar layout
*
* @package Urchenko Technologies
* @subpackage SkyWP WordPress theme
* @since SkyWP 1.0.0
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div id="top-bar-wrap" class="<?php echo esc_attr( skywp_topbar_visibility_classes() ); ?>">

	<div id="top-bar" class="wrapper">

		<div id="top-bar-inner" class="<?php echo esc_attr( skywp_topbar_style_classes() ) ?>">

			<?php
			do_action( 'skywp_topbar_content_before' );

			do_action( 'skywp_topbar_content' );

			do_action( 'skywp_topbar_content_after' );
			?>
			<?php if ( has_nav_menu( 'social_topbar' ) ) : ?>
				<nav class="social-navigation" role="navigation">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'social_topbar',
								'menu_class'     => 'social-links-menu',
								'depth'          => 1,
								'link_before'    => '<span class="screen-reader-text">',
								'link_after'     => '</span>',
							)
						);
					?>
				</nav><!-- .social-navigation -->
			<?php endif; ?>
			
		</div><!-- top-bar-inner -->
		
	</div><!-- top-bar -->
	
</div><!-- #top-bar-wrap -->
