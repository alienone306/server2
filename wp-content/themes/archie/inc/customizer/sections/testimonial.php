<?php
/**
 * Testimonial Section options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add Testimonial section
$wp_customize->add_section( 'archie_testimonial_section', array(
	'title'             => esc_html__( 'Testimonial','archie' ),
	'description'       => esc_html__( 'Testimonial Section options.', 'archie' ),
	'panel'             => 'archie_front_page_panel',
) );

// Testimonial content enable control and setting
$wp_customize->add_setting( 'archie_theme_options[testimonial_section_enable]', array(
	'default'			=> 	$options['testimonial_section_enable'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[testimonial_section_enable]', array(
	'label'             => esc_html__( 'Testimonial Section Enable', 'archie' ),
	'section'           => 'archie_testimonial_section',
	'on_off_label' 		=> archie_switch_options(),
) ) );

// testimonial title setting and control
$wp_customize->add_setting( 'archie_theme_options[testimonial_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['testimonial_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'archie_theme_options[testimonial_title]', array(
	'label'           	=> esc_html__( 'Title', 'archie' ),
	'section'        	=> 'archie_testimonial_section',
	'active_callback' 	=> 'archie_is_testimonial_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'archie_theme_options[testimonial_title]', array(
		'selector'            => '#client-testimonial .section-header h2.section-title',
		'settings'            => 'archie_theme_options[testimonial_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'archie_testimonial_title_partial',
    ) );
}

for ( $i = 1; $i <= 3; $i++ ) :
	// testimonial pages drop down chooser control and setting
	$wp_customize->add_setting( 'archie_theme_options[testimonial_content_page_' . $i . ']', array(
		'sanitize_callback' => 'archie_sanitize_page',
	) );

	$wp_customize->add_control( new Archie_Pro_Dropdown_Chooser( $wp_customize, 'archie_theme_options[testimonial_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'archie' ), $i ),
		'section'           => 'archie_testimonial_section',
		'choices'			=> archie_page_choices(),
		'active_callback'	=> 'archie_is_testimonial_section_enable',
	) ) );

endfor;

