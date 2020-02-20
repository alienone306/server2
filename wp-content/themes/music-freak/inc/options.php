<?php
/**
 * Theme Palace options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

/**
 * List of pages for page choices.
 * @return Array Array of page ids and name.
 */
function music_freak_page_choices() {
    $pages = get_pages();
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'music-freak' );
    foreach ( $pages as $page ) {
        $choices[ $page->ID ] = $page->post_title;
    }
    return  $choices;
}

/**
 * List of posts for post choices.
 * @return Array Array of post ids and name.
 */
function music_freak_post_choices() {
    $posts = get_posts( array( 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'music-freak' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    return  $choices;
}

/**
 * List of products for post choices.
 * @return Array Array of post ids and name.
 */
function music_freak_product_choices() {
    $posts = get_posts( array( 'numberposts' => -1, 'post_type' => 'product' ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'music-freak' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    return  $choices;
}

/**
 * List of events for post choices.
 * @return Array Array of post ids and name.
 */
function music_freak_event_choices() {
    $posts = get_posts( array( 'numberposts' => -1, 'post_type' => 'tp-event' ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'music-freak' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    return  $choices;
}

/**
 * List of audio for post choices.
 * @return Array Array of post ids and name.
 */
function music_freak_audio_choices() {
    $posts = get_posts( array( 'numberposts' => -1, 'post_type' => 'attachment', 'post_mime_type' => 'audio' ) );
    $choices = array();
    $choices[0] = esc_html__( '--None--', 'music-freak' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    return  $choices;
}


if ( ! function_exists( 'music_freak_site_layout' ) ) :
    /**
     * Site Layout
     * @return array site layout options
     */
    function music_freak_site_layout() {
        $music_freak_site_layout = array(
            'wide'  => get_template_directory_uri() . '/assets/images/full.png',
            'boxed-layout' => get_template_directory_uri() . '/assets/images/boxed.png',
            'frame-layout' => get_template_directory_uri() . '/assets/images/framed.png',
        );

        $output = apply_filters( 'music_freak_site_layout', $music_freak_site_layout );
        return $output;
    }
endif;

if ( ! function_exists( 'music_freak_selected_sidebar' ) ) :
    /**
     * Sidebars options
     * @return array Sidbar positions
     */
    function music_freak_selected_sidebar() {
        $music_freak_selected_sidebar = array(
            'sidebar-1'             => esc_html__( 'Default Sidebar', 'music-freak' ),
            'optional-sidebar'      => esc_html__( 'Optional Sidebar 1', 'music-freak' ),
        );

        $output = apply_filters( 'music_freak_selected_sidebar', $music_freak_selected_sidebar );

        return $output;
    }
endif;


if ( ! function_exists( 'music_freak_global_sidebar_position' ) ) :
    /**
     * Global Sidebar position
     * @return array Global Sidebar positions
     */
    function music_freak_global_sidebar_position() {
        $music_freak_global_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'music_freak_global_sidebar_position', $music_freak_global_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'music_freak_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidbar positions
     */
    function music_freak_sidebar_position() {
        $music_freak_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
            'no-sidebar-content'   => get_template_directory_uri() . '/assets/images/boxed.png',
        );

        $output = apply_filters( 'music_freak_sidebar_position', $music_freak_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'music_freak_pagination_options' ) ) :
    /**
     * Pagination
     * @return array site pagination options
     */
    function music_freak_pagination_options() {
        $music_freak_pagination_options = array(
            'numeric'   => esc_html__( 'Numeric', 'music-freak' ),
            'default'   => esc_html__( 'Default(Older/Newer)', 'music-freak' ),
        );

        $output = apply_filters( 'music_freak_pagination_options', $music_freak_pagination_options );

        return $output;
    }
endif;

if ( ! function_exists( 'music_freak_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function music_freak_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'Enable', 'music-freak' ),
            'off'       => esc_html__( 'Disable', 'music-freak' )
        );
        return apply_filters( 'music_freak_switch_options', $arr );
    }
endif;

if ( ! function_exists( 'music_freak_hide_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function music_freak_hide_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'music-freak' ),
            'off'       => esc_html__( 'No', 'music-freak' )
        );
        return apply_filters( 'music_freak_hide_options', $arr );
    }
endif;

if ( ! function_exists( 'music_freak_sortable_sections' ) ) :
    /**
     * List of sections Control options
     * @return array List of Sections control options.
     */
    function music_freak_sortable_sections() {
        $sections = array(
            'slider'    => esc_html__( 'Main Slider', 'music-freak' ),
            'about'     => esc_html__( 'About Us', 'music-freak' ),
            'music_video'  => esc_html__( 'Music and Video Playlist', 'music-freak' ),
            'service'   => esc_html__( 'Services', 'music-freak' ),
            'blog'      => esc_html__( 'Blog', 'music-freak' ),
            'cta'       => esc_html__( 'Call to Action', 'music-freak' ),
        );
        return apply_filters( 'music_freak_sortable_sections', $sections );
    }
endif;