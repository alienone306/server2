<?php
/**
 * About Section options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

// Add About section
$wp_customize->add_section( 'music_freak_about_section', array(
	'title'             => esc_html__( 'About Us','music-freak' ),
	'description'       => esc_html__( 'About Section options.', 'music-freak' ),
	'panel'             => 'music_freak_front_page_panel',
) );

// About content enable control and setting
$wp_customize->add_setting( 'music_freak_theme_options[about_section_enable]', array(
	'default'			=> 	$options['about_section_enable'],
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[about_section_enable]', array(
	'label'             => esc_html__( 'About Section Enable', 'music-freak' ),
	'section'           => 'music_freak_about_section',
	'on_off_label' 		=> music_freak_switch_options(),
) ) );

// about pages drop down chooser control and setting
$wp_customize->add_setting( 'music_freak_theme_options[about_content_page]', array(
	'sanitize_callback' => 'music_freak_sanitize_page',
) );

$wp_customize->add_control( new Music_Freak_Dropdown_Chooser( $wp_customize, 'music_freak_theme_options[about_content_page]', array(
	'label'             => esc_html__( 'Select Page', 'music-freak' ),
	'section'           => 'music_freak_about_section',
	'choices'			=> music_freak_page_choices(),
	'active_callback'	=> 'music_freak_is_about_section_enable',
) ) );

// about btn title setting and control
$wp_customize->add_setting( 'music_freak_theme_options[about_btn_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> 	$options['about_btn_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'music_freak_theme_options[about_btn_title]', array(
	'label'           	=> esc_html__( 'Button Label', 'music-freak' ),
	'section'        	=> 'music_freak_about_section',
	'active_callback' 	=> 'music_freak_is_about_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'music_freak_theme_options[about_btn_title]', array(
		'selector'            => '#about-us .read-more a',
		'settings'            => 'music_freak_theme_options[about_btn_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'music_freak_about_btn_title_partial',
    ) );
}
