<?php
/**
 * Footer options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

// Footer Section
$wp_customize->add_section( 'music_freak_section_footer',
	array(
		'title'      			=> esc_html__( 'Footer Options', 'music-freak' ),
		'priority'   			=> 900,
		'panel'      			=> 'music_freak_theme_options_panel',
	)
);

// footer text
$wp_customize->add_setting( 'music_freak_theme_options[copyright_text]',
	array(
		'default'       		=> $options['copyright_text'],
		'sanitize_callback'		=> 'music_freak_santize_allow_tag',
		'transport'				=> 'postMessage',
	)
);
$wp_customize->add_control( 'music_freak_theme_options[copyright_text]',
    array(
		'label'      			=> esc_html__( 'Copyright Text', 'music-freak' ),
		'section'    			=> 'music_freak_section_footer',
		'type'		 			=> 'textarea',
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'music_freak_theme_options[copyright_text]', array(
		'selector'            => '.site-info .copyright p',
		'settings'            => 'music_freak_theme_options[copyright_text]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'corporate_press_pro_copyright_text_partial',
    ) );
}

// scroll top visible
$wp_customize->add_setting( 'music_freak_theme_options[scroll_top_visible]',
	array(
		'default'       		=> $options['scroll_top_visible'],
		'sanitize_callback' => 'music_freak_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[scroll_top_visible]',
    array(
		'label'      			=> esc_html__( 'Display Scroll Top Button', 'music-freak' ),
		'section'    			=> 'music_freak_section_footer',
		'on_off_label' 		=> music_freak_switch_options(),
    )
) );