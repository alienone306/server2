<?php
/**
 * @package     SkyWP WordPress theme
 * @subpackage  Controls
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Range control
 */
class SkyWP_Customizer_Heading_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'customize-heading';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		
	}

	/**
	 * Render the control.
	 */
	protected function render_content() { ?>

		<div class="heading-wrap">
		<?php
		if ( isset( $this->label ) && '' !== $this->label ) {
			echo '<span class="customizer-heading">' . sanitize_text_field( $this->label ) . '</span>';
		}
		if ( isset( $this->description ) && '' !== $this->description ) {
			echo '<span class="description">' . sanitize_text_field( $this->description ) . '</span>';
		} ?>
		</div>
		<?php
	}
}
