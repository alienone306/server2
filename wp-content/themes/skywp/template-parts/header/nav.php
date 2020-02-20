<?php
/**
* Header menu
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

<div id="site-navigation-wrap" class="clr">

	<nav id="site-navigation" class="clr">

		<?php
		wp_nav_menu( [
			'theme_location'  => 'main_menu',
			'menu'            => '', 
			'container'       => false, 
			'container_class' => '', 
			'container_id'    => '',
			'menu_class'      => 'menu', 
			'menu_id'         => 'menu-all-pages',
			'echo'            => true,
			'fallback_cb'     => 'main_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => new Sky_Walker_Nav_Menu(),
		] );

		?>

	</nav><!-- #site-navigation -->

</div><!-- #site-navigation-wrap -->