<?php
/**
 * About Section options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add About section
$wp_customize->add_section( 'archie_about_section', array(
	'title'             => esc_html__( 'About Us','archie' ),
	'description'       => esc_html__( 'About Section options.', 'archie' ),
	'panel'             => 'archie_front_page_panel',
) );

// About content enable control and setting
$wp_customize->add_setting( 'archie_theme_options[about_section_enable]', array(
	'default'			=> 	$options['about_section_enable'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[about_section_enable]', array(
	'label'             => esc_html__( 'About Section Enable', 'archie' ),
	'section'           => 'archie_about_section',
	'on_off_label' 		=> archie_switch_options(),
) ) );

// about pages drop down chooser control and setting
$wp_customize->add_setting( 'archie_theme_options[about_content_page]', array(
	'sanitize_callback' => 'archie_sanitize_page',
) );

$wp_customize->add_control( new Archie_Pro_Dropdown_Chooser( $wp_customize, 'archie_theme_options[about_content_page]', array(
	'label'             => esc_html__( 'Select Page', 'archie' ),
	'section'           => 'archie_about_section',
	'choices'			=> archie_page_choices(),
	'active_callback'	=> 'archie_is_about_section_enable',
) ) );

// about btn title setting and control
$wp_customize->add_setting( 'archie_theme_options[about_btn_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['about_btn_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'archie_theme_options[about_btn_title]', array(
	'label'           	=> esc_html__( 'Button Label', 'archie' ),
	'section'        	=> 'archie_about_section',
	'active_callback' 	=> 'archie_is_about_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'archie_theme_options[about_btn_title]', array(
		'selector'            => '#about-us .read-more a',
		'settings'            => 'archie_theme_options[about_btn_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'archie_about_btn_title_partial',
    ) );
}
