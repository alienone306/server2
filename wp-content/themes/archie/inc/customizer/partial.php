<?php
/**
* Partial functions
*
* @package Theme Palace
* @subpackage Archie
* @since Archie 1.0.0
*/

if ( ! function_exists( 'archie_about_btn_title_partial' ) ) :
    // about btn title
    function archie_about_btn_title_partial() {
        $options = archie_get_theme_options();
        return esc_html( $options['about_btn_title'] );
    }
endif;

if ( ! function_exists( 'archie_latest_title_partial' ) ) :
    // latest title
    function archie_latest_title_partial() {
        $options = archie_get_theme_options();
        return esc_html( $options['latest_title'] );
    }
endif;

if ( ! function_exists( 'archie_blog_title_partial' ) ) :
    // blog title
    function archie_blog_title_partial() {
        $options = archie_get_theme_options();
        return esc_html( $options['blog_title'] );
    }
endif;

if ( ! function_exists( 'archie_cta_btn_title_partial' ) ) :
    // cta btn title
    function archie_cta_btn_title_partial() {
        $options = archie_get_theme_options();
        return esc_html( $options['cta_btn_title'] );
    }
endif;

if ( ! function_exists( 'archie_testimonial_title_partial' ) ) :
    // testimonial title
    function archie_testimonial_title_partial() {
        $options = archie_get_theme_options();
        return esc_html( $options['testimonial_title'] );
    }
endif;

if ( ! function_exists( 'archie_video_title_partial' ) ) :
    // video title
    function archie_video_title_partial() {
        $options = archie_get_theme_options();
        return esc_html( $options['video_title'] );
    }
endif;

if ( ! function_exists( 'archie_copyright_text_partial' ) ) :
    // copyright text
    function archie_copyright_text_partial() {
        $options = archie_get_theme_options();
        return esc_html( $options['copyright_text'] );
    }
endif;
