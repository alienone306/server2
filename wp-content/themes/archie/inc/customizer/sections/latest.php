<?php
/**
 * Latest Section options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add Latest section
$wp_customize->add_section( 'archie_latest_section', array(
	'title'             => esc_html__( 'Latest','archie' ),
	'description'       => esc_html__( 'Latest Section options.', 'archie' ),
	'panel'             => 'archie_front_page_panel',
) );

// Latest content enable control and setting
$wp_customize->add_setting( 'archie_theme_options[latest_section_enable]', array(
	'default'			=> 	$options['latest_section_enable'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[latest_section_enable]', array(
	'label'             => esc_html__( 'Latest Section Enable', 'archie' ),
	'section'           => 'archie_latest_section',
	'on_off_label' 		=> archie_switch_options(),
) ) );

// latest title setting and control
$wp_customize->add_setting( 'archie_theme_options[latest_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['latest_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'archie_theme_options[latest_title]', array(
	'label'           	=> esc_html__( 'Title', 'archie' ),
	'section'        	=> 'archie_latest_section',
	'active_callback' 	=> 'archie_is_latest_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'archie_theme_options[latest_title]', array(
		'selector'            => '#latest-projects .section-header h2.section-title',
		'settings'            => 'archie_theme_options[latest_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'archie_latest_title_partial',
    ) );
}

// Add dropdown category setting and control.
$wp_customize->add_setting(  'archie_theme_options[latest_content_category]', array(
	'sanitize_callback' => 'archie_sanitize_single_category',
) ) ;

$wp_customize->add_control( new Archie_Pro_Dropdown_Taxonomies_Control( $wp_customize,'archie_theme_options[latest_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'archie' ),
	'description'      	=> esc_html__( 'Note: Latest four posts will be shown from selected category', 'archie' ),
	'section'           => 'archie_latest_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'archie_is_latest_section_enable'
) ) );
