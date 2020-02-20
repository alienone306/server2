<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'music_freak_excerpt_section', array(
	'title'             => esc_html__( 'Excerpt','music-freak' ),
	'description'       => esc_html__( 'Excerpt section options.', 'music-freak' ),
	'panel'             => 'music_freak_theme_options_panel',
) );


// long Excerpt length setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[long_excerpt_length]', array(
	'sanitize_callback' => 'music_freak_sanitize_number_range',
	'validate_callback' => 'music_freak_validate_long_excerpt',
	'default'			=> $options['long_excerpt_length'],
) );

$wp_customize->add_control( 'music_freak_theme_options[long_excerpt_length]', array(
	'label'       		=> esc_html__( 'Blog Page Excerpt Length', 'music-freak' ),
	'description' 		=> esc_html__( 'Note: Min 5 & max is 100.Total words to be displayed in archive page/search page.', 'music-freak' ),
	'section'     		=> 'music_freak_excerpt_section',
	'type'        		=> 'number',
	'input_attrs' 		=> array(
		'style'       => 'width: 80px;',
		'max'         => 100,
		'min'         => 5,
	),
) );

