<?php
/**
 * Slider Section options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add Slider section
$wp_customize->add_section( 'archie_slider_section', array(
	'title'             => esc_html__( 'Main Slider','archie' ),
	'description'       => esc_html__( 'Slider Section options.', 'archie' ),
	'panel'             => 'archie_front_page_panel',
) );

// Slider content enable control and setting
$wp_customize->add_setting( 'archie_theme_options[slider_section_enable]', array(
	'default'			=> 	$options['slider_section_enable'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[slider_section_enable]', array(
	'label'             => esc_html__( 'Slider Section Enable', 'archie' ),
	'section'           => 'archie_slider_section',
	'on_off_label' 		=> archie_switch_options(),
) ) );

// Slider btn label setting and control
$wp_customize->add_setting( 'archie_theme_options[slider_btn_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['slider_btn_label'],
) );

$wp_customize->add_control( 'archie_theme_options[slider_btn_label]', array(
	'label'           	=> esc_html__( 'Slider Button Label', 'archie' ),
	'section'        	=> 'archie_slider_section',
	'active_callback' 	=> 'archie_is_slider_section_enable',
	'type'				=> 'text',
) );

for ( $i = 1; $i <= 3; $i++ ) :
	// slider pages drop down chooser control and setting
	$wp_customize->add_setting( 'archie_theme_options[slider_content_page_' . $i . ']', array(
		'sanitize_callback' => 'archie_sanitize_page',
	) );

	$wp_customize->add_control( new Archie_Pro_Dropdown_Chooser( $wp_customize, 'archie_theme_options[slider_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'archie' ), $i ),
		'section'           => 'archie_slider_section',
		'choices'			=> archie_page_choices(),
		'active_callback'	=> 'archie_is_slider_section_enable',
	) ) );
endfor;
