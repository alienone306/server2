<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

/**
 * music_freak_content_end_action hook
 *
 * @hooked music_freak_add_subscription_section -  5
 * @hooked music_freak_content_end -  10
 *
 */
do_action( 'music_freak_content_end_action' );

/**
 * music_freak_content_end_action hook
 *
 * @hooked music_freak_footer_start -  10
 * @hooked Music_Freak_Footer_Widgets->add_footer_widgets -  20
 * @hooked music_freak_footer_site_info -  40
 * @hooked music_freak_footer_end -  100
 *
 */
do_action( 'music_freak_footer' );

/**
 * music_freak_page_end_action hook
 *
 * @hooked music_freak_page_end -  10
 *
 */
do_action( 'music_freak_page_end_action' ); 

?>

<?php wp_footer(); ?>

</body>
</html>
