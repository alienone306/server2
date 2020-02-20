<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'archie_excerpt_section', array(
	'title'             => esc_html__( 'Excerpt','archie' ),
	'description'       => esc_html__( 'Excerpt section options.', 'archie' ),
	'panel'             => 'archie_theme_options_panel',
) );


// long Excerpt length setting and control.
$wp_customize->add_setting( 'archie_theme_options[long_excerpt_length]', array(
	'sanitize_callback' => 'archie_sanitize_number_range',
	'validate_callback' => 'archie_validate_long_excerpt',
	'default'			=> $options['long_excerpt_length'],
) );

$wp_customize->add_control( 'archie_theme_options[long_excerpt_length]', array(
	'label'       		=> esc_html__( 'Blog Page Excerpt Length', 'archie' ),
	'description' 		=> esc_html__( 'Total words to be displayed in archive page/search page.', 'archie' ),
	'section'     		=> 'archie_excerpt_section',
	'type'        		=> 'number',
	'input_attrs' 		=> array(
		'style'       => 'width: 80px;',
		'max'         => 100,
		'min'         => 5,
	),
) );
