<?php
/**
 * Slider Section options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

// Add Slider section
$wp_customize->add_section( 'music_freak_slider_section', array(
	'title'             => esc_html__( 'Main Slider','music-freak' ),
	'description'       => esc_html__( 'Slider Section options.', 'music-freak' ),
	'panel'             => 'music_freak_front_page_panel',
) );

// Slider content enable control and setting
$wp_customize->add_setting( 'music_freak_theme_options[slider_section_enable]', array(
	'default'			=> 	$options['slider_section_enable'],
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[slider_section_enable]', array(
	'label'             => esc_html__( 'Slider Section Enable', 'music-freak' ),
	'section'           => 'music_freak_slider_section',
	'on_off_label' 		=> music_freak_switch_options(),
) ) );

for ( $i = 1; $i <= 5; $i++ ) :
	// slider pages drop down chooser control and setting
	$wp_customize->add_setting( 'music_freak_theme_options[slider_content_page_' . $i . ']', array(
		'sanitize_callback' => 'music_freak_sanitize_page',
	) );

	$wp_customize->add_control( new Music_Freak_Dropdown_Chooser( $wp_customize, 'music_freak_theme_options[slider_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'music-freak' ), $i ),
		'section'           => 'music_freak_slider_section',
		'choices'			=> music_freak_page_choices(),
		'active_callback'	=> 'music_freak_is_slider_section_enable',
	) ) );

endfor;

// slider btn title setting and control
$wp_customize->add_setting( 'music_freak_theme_options[slider_btn_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'          	=> $options['slider_btn_title'],
) );

$wp_customize->add_control( 'music_freak_theme_options[slider_btn_title]', array(
	'label'           	=> esc_html__( 'Button Label', 'music-freak' ),
	'section'        	=> 'music_freak_slider_section',
	'active_callback' 	=> 'music_freak_is_slider_section_enable',
	'type'				=> 'text',
) );
