<?php
/**
* Main Header layout
*
* @package Urchenko Technologies
* @subpackage SkyWP WordPress theme
* @since SkyWP 1.0.3
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<header id="site-header" class="site-header resize-offset-top-tablet resize-offset-top-mobile <?php echo esc_attr( skywp_border_bottom_class() .' '. skywp_current_menu_item_style() .' '. skywp_change_styles_headers() ); ?>">

	<div id="top-header-inner" class="wrapper">

		<?php if( 'banner' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) : ?>

			<div class="header-wrap-banner">

		<?php endif; ?>

		<?php do_action( 'skywp_header_logo' ); ?>

		<?php do_action( 'skywp_header_banner' ); ?>

		<?php if( 'banner' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) : ?>

			</div><!-- .header-wrap-banner -->

		<?php endif; ?>

		<?php if( 'banner' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) : ?>

			<div class="header-wrap-menu">

		<?php endif; ?>
		
		<?php do_action( 'skywp_header_nav' ); ?>

		<div class="header-inner-right">

			<?php do_action( 'skywp_right_hook_before' ); ?>

			<?php do_action( 'skywp_right_hook' ); ?>

			<?php do_action( 'skywp_right_hook_after' ); ?>

		<?php if( 'banner' == get_theme_mod( 'skywp_header_layout', 'standard' ) ) : ?>

			</div><!-- .header-wrap-menu -->

		<?php endif; ?>

		</div><!-- .header-inner-right -->

	</div><!-- #top-header-inner -->

</header><!-- #site-header -->














