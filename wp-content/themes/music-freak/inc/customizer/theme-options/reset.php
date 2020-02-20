<?php
/**
 * Reset options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

/**
* Reset section
*/
// Add reset enable section
$wp_customize->add_section( 'music_freak_reset_section', array(
	'title'             => esc_html__('Reset all settings','music-freak'),
	'description'       => esc_html__( 'Caution: All settings will be reset to default. Refresh the page after clicking Save & Publish.', 'music-freak' ),
) );

// Add reset enable setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[reset_options]', array(
	'default'           => $options['reset_options'],
	'sanitize_callback' => 'music_freak_sanitize_checkbox',
	'transport'			  => 'postMessage',
) );

$wp_customize->add_control( 'music_freak_theme_options[reset_options]', array(
	'label'             => esc_html__( 'Check to reset all settings', 'music-freak' ),
	'section'           => 'music_freak_reset_section',
	'type'              => 'checkbox',
) );
