<?php
/**
 * Theme Palace options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

/**
 * List of pages for page choices.
 * @return Array Array of page ids and name.
 */
function archie_page_choices() {
    $pages = get_pages();
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'archie' );
    foreach ( $pages as $page ) {
        $choices[ $page->ID ] = $page->post_title;
    }
    return  $choices;
}

/**
 * List of posts for post choices.
 * @return Array Array of post ids and name.
 */
function archie_post_choices() {
    $posts = get_posts( array( 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'archie' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    return  $choices;
}

if ( ! function_exists( 'archie_selected_sidebar' ) ) :
    /**
     * Sidebars options
     * @return array Sidbar positions
     */
    function archie_selected_sidebar() {
        $archie_selected_sidebar = array(
            'sidebar-1'             => esc_html__( 'Default Sidebar', 'archie' ),
            'optional-sidebar'      => esc_html__( 'Optional Sidebar', 'archie' ),
        );

        $output = apply_filters( 'archie_selected_sidebar', $archie_selected_sidebar );

        return $output;
    }
endif;


if ( ! function_exists( 'archie_global_sidebar_position' ) ) :
    /**
     * Global Sidebar position
     * @return array Global Sidebar positions
     */
    function archie_global_sidebar_position() {
        $archie_global_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'archie_global_sidebar_position', $archie_global_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'archie_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidbar positions
     */
    function archie_sidebar_position() {
        $archie_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
            'no-sidebar-content'   => get_template_directory_uri() . '/assets/images/boxed.png',
        );

        $output = apply_filters( 'archie_sidebar_position', $archie_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'archie_pagination_options' ) ) :
    /**
     * Pagination
     * @return array site pagination options
     */
    function archie_pagination_options() {
        $archie_pagination_options = array(
            'numeric'   => esc_html__( 'Numeric', 'archie' ),
            'default'   => esc_html__( 'Default(Older/Newer)', 'archie' ),
        );

        $output = apply_filters( 'archie_pagination_options', $archie_pagination_options );

        return $output;
    }
endif;

if ( ! function_exists( 'archie_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function archie_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'Enable', 'archie' ),
            'off'       => esc_html__( 'Disable', 'archie' )
        );
        return apply_filters( 'archie_switch_options', $arr );
    }
endif;

if ( ! function_exists( 'archie_hide_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function archie_hide_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'archie' ),
            'off'       => esc_html__( 'No', 'archie' )
        );
        return apply_filters( 'archie_hide_options', $arr );
    }
endif;

if ( ! function_exists( 'archie_sortable_sections' ) ) :
    /**
     * List of sections Control options
     * @return array List of Sections control options.
     */
    function archie_sortable_sections() {
        $sections = array(
            'slider'    => esc_html__( 'Main Slider', 'archie' ),
            'service'   => esc_html__( 'Services', 'archie' ),
            'about'     => esc_html__( 'About Us', 'archie' ),
            'video'     => esc_html__( 'Video', 'archie' ),
            'latest'    => esc_html__( 'Latest', 'archie' ),
            'blog'      => esc_html__( 'Blog', 'archie' ),
            'testimonial' => esc_html__( 'Testimonial', 'archie' ),
            'client'    => esc_html__( 'Client', 'archie' ),
            'cta'       => esc_html__( 'Call to Action', 'archie' ),
        );
        return apply_filters( 'archie_sortable_sections', $sections );
    }
endif;