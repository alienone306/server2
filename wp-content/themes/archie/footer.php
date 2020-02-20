<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

/**
 * archie_footer_primary_content hook
 *
 * @hooked archie_add_contact_section -  10
 *
 */
do_action( 'archie_footer_primary_content' );

/**
 * archie_content_end_action hook
 *
 * @hooked archie_content_end -  10
 *
 */
do_action( 'archie_content_end_action' );

/**
 * archie_content_end_action hook
 *
 * @hooked archie_footer_start -  10
 * @hooked Archie_Pro_Footer_Widgets->add_footer_widgets -  20
 * @hooked archie_footer_site_info -  40
 * @hooked archie_footer_end -  100
 *
 */
do_action( 'archie_footer' );

/**
 * archie_page_end_action hook
 *
 * @hooked archie_page_end -  10
 *
 */
do_action( 'archie_page_end_action' ); 

?>

<?php wp_footer(); ?>

</body>
</html>
