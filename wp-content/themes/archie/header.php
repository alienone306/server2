<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage Archie
	 * @since Archie 1.0.0
	 */

	/**
	 * archie_doctype hook
	 *
	 * @hooked archie_doctype -  10
	 *
	 */
	do_action( 'archie_doctype' );

?>
<head>
<?php
	/**
	 * archie_before_wp_head hook
	 *
	 * @hooked archie_head -  10
	 *
	 */
	do_action( 'archie_before_wp_head' );

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<?php
	/**
	 * archie_page_start_action hook
	 *
	 * @hooked archie_page_start -  10
	 *
	 */
	do_action( 'archie_page_start_action' ); 

	/**
	 * archie_loader_action hook
	 *
	 * @hooked archie_loader -  10
	 *
	 */
	do_action( 'archie_before_header' );

	/**
	 * archie_header_action hook
	 *
	 * @hooked archie_header_start -  10
	 * @hooked archie_site_branding -  20
	 * @hooked archie_site_navigation -  30
	 * @hooked archie_header_end -  50
	 *
	 */
	do_action( 'archie_header_action' );

	/**
	 * archie_content_start_action hook
	 *
	 * @hooked archie_content_start -  10
	 *
	 */
	do_action( 'archie_content_start_action' );

	/**
	 * archie_header_image_action hook
	 *
	 * @hooked archie_header_image -  10
	 *
	 */
	do_action( 'archie_header_image_action' );

    if ( archie_is_frontpage() ) {

    	$sections = archie_sortable_sections();
		foreach ( $sections as $section => $value ) {
			add_action( 'archie_primary_content', 'archie_add_'. $section .'_section', archie_sort( $section ) );
		}
		do_action( 'archie_primary_content' );
	}