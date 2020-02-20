<?php
/**
 * Service Section options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add Service section
$wp_customize->add_section( 'archie_service_section', array(
	'title'             => esc_html__( 'Services','archie' ),
	'description'       => esc_html__( 'Services Section options.', 'archie' ),
	'panel'             => 'archie_front_page_panel',
) );

// Service content enable control and setting
$wp_customize->add_setting( 'archie_theme_options[service_section_enable]', array(
	'default'			=> 	$options['service_section_enable'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[service_section_enable]', array(
	'label'             => esc_html__( 'Service Section Enable', 'archie' ),
	'section'           => 'archie_service_section',
	'on_off_label' 		=> archie_switch_options(),
) ) );

// service btn label setting and control
$wp_customize->add_setting( 'archie_theme_options[service_btn_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['service_btn_label'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'archie_theme_options[service_btn_label]', array(
	'label'           	=> esc_html__( 'Button Label', 'archie' ),
	'section'        	=> 'archie_service_section',
	'active_callback' 	=> 'archie_is_service_section_enable',
	'type'				=> 'text',
) );

for ( $i = 1; $i <= 3; $i++ ) :

	// service note control and setting
	$wp_customize->add_setting( 'archie_theme_options[service_content_icon_' . $i . ']', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new Archie_Pro_Icon_Picker( $wp_customize, 'archie_theme_options[service_content_icon_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Icon %d', 'archie' ), $i ),
		'section'           => 'archie_service_section',
		'active_callback'	=> 'archie_is_service_section_enable',
	) ) );

	// service pages drop down chooser control and setting
	$wp_customize->add_setting( 'archie_theme_options[service_content_page_' . $i . ']', array(
		'sanitize_callback' => 'archie_sanitize_page',
	) );

	$wp_customize->add_control( new Archie_Pro_Dropdown_Chooser( $wp_customize, 'archie_theme_options[service_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'archie' ), $i ),
		'section'           => 'archie_service_section',
		'choices'			=> archie_page_choices(),
		'active_callback'	=> 'archie_is_service_section_enable',
	) ) );

	// service hr setting and control
	$wp_customize->add_setting( 'archie_theme_options[service_hr_'. $i .']', array(
		'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_control( new Archie_Pro_Customize_Horizontal_Line( $wp_customize, 'archie_theme_options[service_hr_'. $i .']',
		array(
			'section'         => 'archie_service_section',
			'active_callback' => 'archie_is_service_section_enable',
			'type'			  => 'hr'
	) ) );
endfor;
