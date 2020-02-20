<?php
/**
 * Service Section options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

// Add Service section
$wp_customize->add_section( 'music_freak_service_section', array(
	'title'             => esc_html__( 'Services','music-freak' ),
	'description'       => esc_html__( 'Services Section options.', 'music-freak' ),
	'panel'             => 'music_freak_front_page_panel',
) );

// Service content enable control and setting
$wp_customize->add_setting( 'music_freak_theme_options[service_section_enable]', array(
	'default'			=> 	$options['service_section_enable'],
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[service_section_enable]', array(
	'label'             => esc_html__( 'Service Section Enable', 'music-freak' ),
	'section'           => 'music_freak_service_section',
	'on_off_label' 		=> music_freak_switch_options(),
) ) );

// service title setting and control
$wp_customize->add_setting( 'music_freak_theme_options[service_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['service_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'music_freak_theme_options[service_title]', array(
	'label'           	=> esc_html__( 'Title', 'music-freak' ),
	'section'        	=> 'music_freak_service_section',
	'active_callback' 	=> 'music_freak_is_service_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'music_freak_theme_options[service_title]', array(
		'selector'            => '#featured-services .section-header h2.section-title',
		'settings'            => 'music_freak_theme_options[service_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'music_freak_service_title_partial',
    ) );
}

for ( $i = 1; $i <= 4; $i++ ) :

	// service note control and setting
	$wp_customize->add_setting( 'music_freak_theme_options[service_content_icon_' . $i . ']', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new Music_Freak_Icon_Picker( $wp_customize, 'music_freak_theme_options[service_content_icon_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Icon %d', 'music-freak' ), $i ),
		'section'           => 'music_freak_service_section',
		'active_callback'	=> 'music_freak_is_service_section_enable',
	) ) );

	// service pages drop down chooser control and setting
	$wp_customize->add_setting( 'music_freak_theme_options[service_content_page_' . $i . ']', array(
		'sanitize_callback' => 'music_freak_sanitize_page',
	) );

	$wp_customize->add_control( new Music_Freak_Dropdown_Chooser( $wp_customize, 'music_freak_theme_options[service_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'music-freak' ), $i ),
		'section'           => 'music_freak_service_section',
		'choices'			=> music_freak_page_choices(),
		'active_callback'	=> 'music_freak_is_service_section_enable',
	) ) );

	// service hr setting and control
	$wp_customize->add_setting( 'music_freak_theme_options[service_hr_'. $i .']', array(
		'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_control( new Music_Freak_Customize_Horizontal_Line( $wp_customize, 'music_freak_theme_options[service_hr_'. $i .']',
		array(
			'section'         => 'music_freak_service_section',
			'active_callback' => 'music_freak_is_service_section_enable',
			'type'			  => 'hr'
	) ) );
endfor;
