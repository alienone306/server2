<?php
/**
 * Footer options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Footer Section
$wp_customize->add_section( 'archie_section_footer',
	array(
		'title'      			=> esc_html__( 'Footer Options', 'archie' ),
		'priority'   			=> 900,
		'panel'      			=> 'archie_theme_options_panel',
	)
);

// footer text
$wp_customize->add_setting( 'archie_theme_options[copyright_text]',
	array(
		'default'       		=> $options['copyright_text'],
		'sanitize_callback'		=> 'archie_santize_allow_tag',
		'transport'				=> 'postMessage',
	)
);
$wp_customize->add_control( 'archie_theme_options[copyright_text]',
    array(
		'label'      			=> esc_html__( 'Copyright Text', 'archie' ),
		'section'    			=> 'archie_section_footer',
		'type'		 			=> 'textarea',
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'archie_theme_options[copyright_text]', array(
		'selector'            => '.site-info .copyright p',
		'settings'            => 'archie_theme_options[copyright_text]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'archie_copyright_text_partial',
    ) );
}


// scroll top visible
$wp_customize->add_setting( 'archie_theme_options[scroll_top_visible]',
	array(
		'default'       		=> $options['scroll_top_visible'],
		'sanitize_callback' => 'archie_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[scroll_top_visible]',
    array(
		'label'      			=> esc_html__( 'Display Scroll Top Button', 'archie' ),
		'section'    			=> 'archie_section_footer',
		'on_off_label' 		=> archie_switch_options(),
    )
) );