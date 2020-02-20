<?php
/**
 * Menu options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'music_freak_menu', array(
	'title'             => esc_html__('Header Menu','music-freak'),
	'description'       => esc_html__( 'Header Menu options.', 'music-freak' ),
	'panel'             => 'nav_menus',
) );

// Menu search setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[nav_search_enable]', array(
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
	'default'           => $options['nav_search_enable'],
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[nav_search_enable]', array(
	'label'             => esc_html__( 'Enable Menu Search', 'music-freak' ),
	'section'           => 'music_freak_menu',
	'on_off_label' 		=> music_freak_switch_options(),
) ) );

// top bar menu visible
$wp_customize->add_setting( 'music_freak_theme_options[nav_social_enable]',
	array(
		'default'       	=> $options['nav_social_enable'],
		'sanitize_callback' => 'music_freak_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[nav_social_enable]',
    array(
		'label'      		=> esc_html__( 'Display Social Menu', 'music-freak' ),
		'description'       => sprintf( '%1$s <a class="topbar-menu-trigger" href="#"> %2$s </a> %3$s', esc_html__( 'Note: To show topbar menu.', 'music-freak' ), esc_html__( 'Click Here', 'music-freak' ), esc_html__( 'to create menu', 'music-freak' ) ),
		'section'    		=> 'music_freak_topbar_section',
		'on_off_label' 		=> music_freak_switch_options(),
    )
) );