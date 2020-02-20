<?php
/**
 * Archive options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

// Add archive section
$wp_customize->add_section( 'music_freak_archive_section', array(
	'title'             => esc_html__( 'Blog/Archive','music-freak' ),
	'description'       => esc_html__( 'Archive section options.', 'music-freak' ),
	'panel'             => 'music_freak_theme_options_panel',
) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[your_latest_posts_title]', array(
	'default'           => $options['your_latest_posts_title'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'music_freak_theme_options[your_latest_posts_title]', array(
	'label'             => esc_html__( 'Your Latest Posts Title', 'music-freak' ),
	'description'       => esc_html__( 'This option only works if Static Front Page is set to "Your latest posts."', 'music-freak' ),
	'section'           => 'music_freak_archive_section',
	'type'				=> 'text',
	'active_callback'   => 'music_freak_is_latest_posts'
) );

// Archive date meta setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[hide_date]', array(
	'default'           => $options['hide_date'],
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'music-freak' ),
	'section'           => 'music_freak_archive_section',
	'on_off_label' 		=> music_freak_hide_options(),
) ) );

// Archive author category setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[hide_category]', array(
	'default'           => $options['hide_category'],
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'music-freak' ),
	'section'           => 'music_freak_archive_section',
	'on_off_label' 		=> music_freak_hide_options(),
) ) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[read_more_text]', array(
	'default'           => $options['read_more_text'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'music_freak_theme_options[read_more_text]', array(
	'label'             => esc_html__( 'Read More Text', 'music-freak' ),
	'section'           => 'music_freak_archive_section',
	'type'				=> 'text',
) );