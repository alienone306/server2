<?php
/**
* Partial functions
*
* @package Theme Palace
* @subpackage Music Freak
* @since Music Freak 1.0.0
*/

if ( ! function_exists( 'music_freak_about_btn_title_partial' ) ) :
    // about btn title
    function music_freak_about_btn_title_partial() {
        $options = music_freak_get_theme_options();
        return esc_html( $options['about_btn_title'] );
    }
endif;

if ( ! function_exists( 'music_freak_music_video_title_partial' ) ) :
    // music_video title
    function music_freak_music_video_title_partial() {
        $options = music_freak_get_theme_options();
        return esc_html( $options['music_video_title'] );
    }
endif;


if ( ! function_exists( 'music_freak_music_video_list_title_partial' ) ) :
    // music_video_list title
    function music_freak_music_video_list_title_partial() {
        $options = music_freak_get_theme_options();
        return esc_html( $options['music_video_list_title'] );
    }
endif;

if ( ! function_exists( 'music_freak_service_title_partial' ) ) :
    // service title
    function music_freak_service_title_partial() {
        $options = music_freak_get_theme_options();
        return esc_html( $options['service_title'] );
    }
endif;

if ( ! function_exists( 'music_freak_blog_title_partial' ) ) :
    // blog title
    function music_freak_blog_title_partial() {
        $options = music_freak_get_theme_options();
        return esc_html( $options['blog_title'] );
    }
endif;

if ( ! function_exists( 'music_freak_cta_btn_title_partial' ) ) :
    // cta btn title
    function music_freak_cta_btn_title_partial() {
        $options = music_freak_get_theme_options();
        return esc_html( $options['cta_btn_title'] );
    }
endif;
