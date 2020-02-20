<?php
/**
 * Blog Section options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

// Add Blog section
$wp_customize->add_section( 'music_freak_blog_section', array(
	'title'             => esc_html__( 'Blog','music-freak' ),
	'description'       => esc_html__( 'Blog Section options.', 'music-freak' ),
	'panel'             => 'music_freak_front_page_panel',
) );

// Blog content enable control and setting
$wp_customize->add_setting( 'music_freak_theme_options[blog_section_enable]', array(
	'default'			=> 	$options['blog_section_enable'],
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[blog_section_enable]', array(
	'label'             => esc_html__( 'Blog Section Enable', 'music-freak' ),
	'section'           => 'music_freak_blog_section',
	'on_off_label' 		=> music_freak_switch_options(),
) ) );

// blog title setting and control
$wp_customize->add_setting( 'music_freak_theme_options[blog_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['blog_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'music_freak_theme_options[blog_title]', array(
	'label'           	=> esc_html__( 'Title', 'music-freak' ),
	'section'        	=> 'music_freak_blog_section',
	'active_callback' 	=> 'music_freak_is_blog_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'music_freak_theme_options[blog_title]', array(
		'selector'            => '#latest-posts .section-header h2.section-title',
		'settings'            => 'music_freak_theme_options[blog_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'music_freak_blog_title_partial',
    ) );
}

// Blog content type control and setting
$wp_customize->add_setting( 'music_freak_theme_options[blog_content_type]', array(
	'default'          	=> $options['blog_content_type'],
	'sanitize_callback' => 'music_freak_sanitize_select',
) );

$wp_customize->add_control( 'music_freak_theme_options[blog_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'music-freak' ),
	'section'           => 'music_freak_blog_section',
	'type'				=> 'select',
	'active_callback' 	=> 'music_freak_is_blog_section_enable',
	'choices'			=> array( 
		'category' 	=> esc_html__( 'Category', 'music-freak' ),
		'recent' 	=> esc_html__( 'Recent', 'music-freak' ),
	),
) );

// Add dropdown category setting and control.
$wp_customize->add_setting(  'music_freak_theme_options[blog_content_category]', array(
	'sanitize_callback' => 'music_freak_sanitize_single_category',
) ) ;

$wp_customize->add_control( new Music_Freak_Dropdown_Taxonomies_Control( $wp_customize,'music_freak_theme_options[blog_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'music-freak' ),
	'description'      	=> esc_html__( 'Note: Latest seven posts will be shown from selected category', 'music-freak' ),
	'section'           => 'music_freak_blog_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'music_freak_is_blog_section_content_category_enable'
) ) );

// Add dropdown categories setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[blog_category_exclude]', array(
	'sanitize_callback' => 'music_freak_sanitize_category_list',
) ) ;

$wp_customize->add_control( new Music_Freak_Dropdown_Category_Control( $wp_customize,'music_freak_theme_options[blog_category_exclude]', array(
	'label'             => esc_html__( 'Select Excluding Categories', 'music-freak' ),
	'description'      	=> esc_html__( 'Note: Select categories to exclude. Press Shift key select multilple categories.', 'music-freak' ),
	'section'           => 'music_freak_blog_section',
	'type'              => 'dropdown-categories',
	'active_callback'	=> 'music_freak_is_blog_section_content_recent_enable'
) ) );
