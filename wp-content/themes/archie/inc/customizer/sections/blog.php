<?php
/**
 * Blog Section options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add Blog section
$wp_customize->add_section( 'archie_blog_section', array(
	'title'             => esc_html__( 'Blog','archie' ),
	'description'       => esc_html__( 'Blog Section options.', 'archie' ),
	'panel'             => 'archie_front_page_panel',
) );

// Blog content enable control and setting
$wp_customize->add_setting( 'archie_theme_options[blog_section_enable]', array(
	'default'			=> 	$options['blog_section_enable'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[blog_section_enable]', array(
	'label'             => esc_html__( 'Blog Section Enable', 'archie' ),
	'section'           => 'archie_blog_section',
	'on_off_label' 		=> archie_switch_options(),
) ) );

// blog title setting and control
$wp_customize->add_setting( 'archie_theme_options[blog_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['blog_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'archie_theme_options[blog_title]', array(
	'label'           	=> esc_html__( 'Title', 'archie' ),
	'section'        	=> 'archie_blog_section',
	'active_callback' 	=> 'archie_is_blog_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'archie_theme_options[blog_title]', array(
		'selector'            => '#latest-posts .section-header h2.section-title',
		'settings'            => 'archie_theme_options[blog_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'archie_blog_title_partial',
    ) );
}

// Blog content type control and setting
$wp_customize->add_setting( 'archie_theme_options[blog_content_type]', array(
	'default'          	=> $options['blog_content_type'],
	'sanitize_callback' => 'archie_sanitize_select',
) );

$wp_customize->add_control( 'archie_theme_options[blog_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'archie' ),
	'section'           => 'archie_blog_section',
	'type'				=> 'select',
	'active_callback' 	=> 'archie_is_blog_section_enable',
	'choices'			=> array( 
		'category' 	=> esc_html__( 'Category', 'archie' ),
		'recent' 	=> esc_html__( 'Recent', 'archie' ),
	),
) );

// Add dropdown category setting and control.
$wp_customize->add_setting(  'archie_theme_options[blog_content_category]', array(
	'sanitize_callback' => 'archie_sanitize_single_category',
) ) ;

$wp_customize->add_control( new Archie_Pro_Dropdown_Taxonomies_Control( $wp_customize,'archie_theme_options[blog_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'archie' ),
	'description'      	=> esc_html__( 'Note: Latest three posts will be shown from selected category', 'archie' ),
	'section'           => 'archie_blog_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'archie_is_blog_section_content_category_enable'
) ) );

// Add dropdown categories setting and control.
$wp_customize->add_setting( 'archie_theme_options[blog_category_exclude]', array(
	'sanitize_callback' => 'archie_sanitize_category_list',
) ) ;

$wp_customize->add_control( new Archie_Pro_Dropdown_Category_Control( $wp_customize,'archie_theme_options[blog_category_exclude]', array(
	'label'             => esc_html__( 'Select Excluding Categories', 'archie' ),
	'description'      	=> esc_html__( 'Note: Select categories to exclude. Press Shift key select multilple categories.', 'archie' ),
	'section'           => 'archie_blog_section',
	'type'              => 'dropdown-categories',
	'active_callback'	=> 'archie_is_blog_section_content_recent_enable'
) ) );
