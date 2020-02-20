<?php
/**
 * 728x90 Advertisement
 *
 * @package Urchenko
 * @subpackage Kalina WordPress theme
 * @since Kalina 1.0.0
 */

/**
 * Register widget
 */
add_action( 'widgets_init', 'skywp_load_widget_728_90' );
if ( ! function_exists( 'skywp_load_widget_728_90' ) ) {
	function skywp_load_widget_728_90() {
		register_widget( 'skywp_widget_728x90' );
	}
}

class skywp_widget_728x90 extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'                   => 'widget_728x90',
			'description'                 => __( 'Header banner', 'skywp' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 200, 'height' => 250 );
		parent::__construct( false, $name = __( 'SkyWP - Header Banner', 'skywp' ), $widget_ops );
	}

	function form( $instance ) {
		$instance = wp_parse_args( ( array ) $instance, array(
			'728x90_image_url'  => '',
			'728x90_image_link' => '',
		) );

		$image_link = '728x90_image_link';
		$image_url  = '728x90_image_url';

		$instance[ $image_link ] = $instance[ $image_link ];
		$instance[ $image_url ]  = $instance[ $image_url ];
		?>

		<div class="media-widget-control">
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( $image_link ) ); ?>"> <?php esc_html_e( 'Link to:', 'skywp' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( $image_link ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $image_link ) ); ?>" value="<?php echo esc_url( $instance[ $image_link ] ); ?>" />
		</p>
		<div class="attachment-media-view">
			<div class="custom_media_preview">
				<?php if ( $instance[ $image_url ] != '' ) : ?>
					<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ $image_url ] ); ?>" style="max-width:100%;" />
				<?php endif; ?>
			</div>
			<input type="hidden" class="widefat custom_media_input" name="<?php echo esc_attr( $this->get_field_name( $image_url ) ); ?>" value="<?php echo esc_url( $instance[ $image_url ] ); ?>" style="margin-top:5px;" />
			<button class="custom_media_upload button-add-media" style="margin: 15px 0;"><?php esc_html_e( 'Add Image', 'skywp' ); ?></button>
		</div>
		</div>

		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		
		$image_link = '728x90_image_link';
		$image_url  = '728x90_image_url';

		$instance[ $image_link ] = esc_url_raw( $new_instance[ $image_link ] );
		$instance[ $image_url ]  = esc_url_raw( $new_instance[ $image_url ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );


		$image_link = '728x90_image_link';
		$image_url  = '728x90_image_url';

		$image_link = isset( $instance[ $image_link ] ) ? $instance[ $image_link ] : '';
		$image_url  = isset( $instance[ $image_url ] ) ? $instance[ $image_url ] : '';

		echo $before_widget;
		?>

		<div class="banner-desktop">
			<?php
			$output    = '';
			$image_id  = attachment_url_to_postid( $image_url );
			$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			if ( ! empty( $image_url ) ) {
				$output .= '<div class="visible-desktop">';
				if ( ! empty( $image_link ) ) {
					$image_id  = attachment_url_to_postid( $image_url );
					$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
					$output    .= '<a href="' . esc_url( $image_link ) . '" target="_blank" rel="nofollow">
                                    <img src="' . esc_url( $image_url ) . '" width="728" height="90" alt="' . esc_attr( $image_alt ) . '">
                           </a>';
				} else {
					$output .= '<img src="' . esc_url( $image_url ) . '"width="728" height="90" alt="' . esc_attr( $image_alt ) . '">';
				}
				$output .= '</div>';
				echo $output;
			}
			?>
		</div>
		<?php
		echo $after_widget;
	}

}
