<?php
/**
 * Theme Palace widgets inclusion
 *
 * This is the template that includes all custom widgets of Archie
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

/*
 * Add social link widget
 */
require get_template_directory() . '/inc/widgets/social-link-widget.php';

/*
 * Add Latest Posts widget
 */
require get_template_directory() . '/inc/widgets/latest-posts-widget.php';




/**
 * Register widgets
 */
function archie_register_widgets() {

	register_widget( 'Archie_Pro_Latest_Post' );

	register_widget( 'Archie_Pro_Social_Link' );

}
add_action( 'widgets_init', 'archie_register_widgets' );