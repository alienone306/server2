<?php
/**
 * Music & Video Playlist Section options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

// Add Music & Video Playlist section
$wp_customize->add_section( 'music_freak_music_video_section', array(
	'title'             => esc_html__( 'Music & Video Playlist','music-freak' ),
	'description'       => esc_html__( 'Music & Video Playlist Section options.', 'music-freak' ),
	'panel'             => 'music_freak_front_page_panel',
) );

// Music & Video Playlist content enable control and setting
$wp_customize->add_setting( 'music_freak_theme_options[music_video_section_enable]', array(
	'default'			=> 	$options['music_video_section_enable'],
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[music_video_section_enable]', array(
	'label'             => esc_html__( 'Music & Video Playlist Section Enable', 'music-freak' ),
	'section'           => 'music_freak_music_video_section',
	'on_off_label' 		=> music_freak_switch_options(),
) ) );

// music_video title setting and control
$wp_customize->add_setting( 'music_freak_theme_options[music_video_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['music_video_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'music_freak_theme_options[music_video_title]', array(
	'label'           	=> esc_html__( 'Music Title', 'music-freak' ),
	'section'        	=> 'music_freak_music_video_section',
	'active_callback' 	=> 'music_freak_is_music_video_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'music_freak_theme_options[music_video_title]', array(
		'selector'            => '#recently-played .music-playlist .section-header h2.section-title',
		'settings'            => 'music_freak_theme_options[music_video_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'music_freak_music_video_title_partial',
    ) );
}

// music_video posts drop down chooser control and setting
$wp_customize->add_setting( 'music_freak_theme_options[music_video_content]', array(
	'sanitize_callback' => 'music_freak_sanitize_array_int',
) );

$wp_customize->add_control( new Music_Freak_Multiple_Dropdown_Chooser( $wp_customize, 'music_freak_theme_options[music_video_content]', array(
	'label'             => esc_html__( 'Select Multiple Audios', 'music-freak' ),
	'section'           => 'music_freak_music_video_section',
	'choices'			=> music_freak_audio_choices(),
	'active_callback'	=> 'music_freak_is_music_video_section_enable',
) ) );

// music_video title setting and control
$wp_customize->add_setting( 'music_freak_theme_options[music_video_list_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['music_video_list_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'music_freak_theme_options[music_video_list_title]', array(
	'label'           	=> esc_html__( 'Video Title', 'music-freak' ),
	'section'        	=> 'music_freak_music_video_section',
	'active_callback' 	=> 'music_freak_is_music_video_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'music_freak_theme_options[music_video_list_title]', array(
		'selector'            => '#recently-played .video-playlist .section-header h2.section-title',
		'settings'            => 'music_freak_theme_options[music_video_list_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'music_freak_music_video_list_title_partial',
    ) );
}

// music_video title setting and control
$wp_customize->add_setting( 'music_freak_theme_options[music_video_list]', array(
	'sanitize_callback' => 'esc_url_raw',
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'music_freak_theme_options[music_video_list]', array(
	'label'           	=> esc_html__( 'Video Url', 'music-freak' ),
	'section'        	=> 'music_freak_music_video_section',
	'active_callback' 	=> 'music_freak_is_music_video_section_enable',
	'type'				=> 'url',
) );
