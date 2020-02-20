<?php
/**
* Homepage (Static ) options
*
* @package Theme Palace
* @subpackage Archie
* @since Archie 1.0.0
*/

// Homepage (Static ) setting and control.
$wp_customize->add_setting( 'archie_theme_options[enable_frontpage_content]', array(
	'sanitize_callback'   => 'archie_sanitize_checkbox',
	'default'             => $options['enable_frontpage_content'],
) );

$wp_customize->add_control( 'archie_theme_options[enable_frontpage_content]', array(
	'label'       	=> esc_html__( 'Enable Content', 'archie' ),
	'description' 	=> esc_html__( 'Check to enable content on static front page only.', 'archie' ),
	'section'     	=> 'static_front_page',
	'type'        	=> 'checkbox',
	'active_callback' => 'archie_is_static_homepage_enable',
) );