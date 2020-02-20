<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage Music Freak
	 * @since Music Freak 1.0.0
	 */

	/**
	 * music_freak_doctype hook
	 *
	 * @hooked music_freak_doctype -  10
	 *
	 */
	do_action( 'music_freak_doctype' );

?>
<head>
<?php
	/**
	 * music_freak_before_wp_head hook
	 *
	 * @hooked music_freak_head -  10
	 *
	 */
	do_action( 'music_freak_before_wp_head' );

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' ); ?>

<?php
	/**
	 * music_freak_page_start_action hook
	 *
	 * @hooked music_freak_page_start -  10
	 *
	 */
	do_action( 'music_freak_page_start_action' ); 

	/**
	 * music_freak_header_action hook
	 *
	 * @hooked music_freak_header_start -  10
	 * @hooked music_freak_site_branding -  20
	 * @hooked music_freak_site_navigation -  30
	 * @hooked music_freak_header_end -  50
	 *
	 */
	do_action( 'music_freak_header_action' );

	/**
	 * music_freak_content_start_action hook
	 *
	 * @hooked music_freak_content_start -  10
	 *
	 */
	do_action( 'music_freak_content_start_action' );

	/**
	 * music_freak_header_image_action hook
	 *
	 * @hooked music_freak_header_image -  10
	 *
	 */
	do_action( 'music_freak_header_image_action' );

    if ( music_freak_is_frontpage() ) {
    	$options = music_freak_get_theme_options();
    	$sorted = array();
    	if ( ! empty( $options['sortable'] ) ) {
   			$sorted = explode( ',' , $options['sortable'] );
   		}

		foreach ( $sorted as $section ) {
			add_action( 'music_freak_primary_content', 'music_freak_add_'. $section .'_section' );
		}
		do_action( 'music_freak_primary_content' );
	}