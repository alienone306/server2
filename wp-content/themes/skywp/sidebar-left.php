<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Urchenko
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */
if ( ! is_active_sidebar( 'sidebar-left' ) ) {
	return;
}
?>

<aside id="left-sidebar" class="widget-area">

	<?php dynamic_sidebar( 'sidebar-left' ); ?>
	
</aside><!-- #left-sidebar -->
