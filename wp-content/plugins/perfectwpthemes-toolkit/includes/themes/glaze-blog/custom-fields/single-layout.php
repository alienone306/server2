<?php

if( ! class_exists( 'Perfectwpthemes_Toolkit_Single_Layout_Field' ) ) :

	class Perfectwpthemes_Toolkit_Single_Layout_Field {

		public function __construct() {

			$this->init();
		}

		/**
		 * Sets up initial actions.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function init() {
			// Register post meta fields and save meta fields values.
			add_action( 'admin_init', array( $this, 'register_post_meta' ) );
			add_action( 'save_post', array( $this, 'save_single_layout_meta' ) );
		}

		/**
		 * Register post custom meta fields.
		 *
		 * @since    1.0.0
		 */
		public function register_post_meta() {   

		    add_meta_box( 'single_layout_metabox', esc_html__( 'Single Layout', 'perfectwpthemes-toolkit' ), array( $this, 'single_layout_meta' ), array( 'post', 'page' ), 'side', 'default' );
		}

		/**
		 * Custom Single Layout Post Meta.
		 *
		 * @since    1.0.0
		 */
		public function single_layout_meta() {

			global $post;

			$theme_prefix = perfectwpthemes_toolkit_theme_prefix();

			$single_layout_key = $theme_prefix . '_single_layout';

			$single_layout = get_post_meta( $post->ID, $single_layout_key, true );

			if( empty( $single_layout ) ) {
				$single_layout = 'right';
			}

		    wp_nonce_field( 'single_layout_meta_nonce', 'single_layout_meta_nonce_id' );

		    $choices = array(
		        'layout_one' => esc_html__( 'Layout One', 'perfectwpthemes-toolkit' ),
		        'layout_two' => esc_html__( 'Layout Two', 'perfectwpthemes-toolkit' ),
		    );

		    ?>

		    <table width="100%" border="0" class="options" cellspacing="5" cellpadding="5">
		        <tr>
		        	<td>
			        	<select class="widefat" name="single_layout" id="single_layout">
			        		<?php
			        		foreach( $choices as $key => $choice ) {
			        			?>
			        			<option value="<?php echo esc_attr( $key ); ?>" <?php if( $key == $single_layout ) { esc_attr_e( 'selected', 'perfectwpthemes-toolkit' ); } ?>><?php echo esc_html( $choice ); ?></option>
			        			<?php
			        		}
			        		?>
			        	</select>
		        	</td>
		        </tr> 
		    </table>   
		    <?php   
		}

		/**
		 * Save Custom Single Layout Post Meta.
		 *
		 * @since    1.0.0
		 */
		public function save_single_layout_meta() {

		    global $post;  

		    // Bail if we're doing an auto save
		    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		        return;
		    }
		    
		    // if our nonce isn't there, or we can't verify it, bail
		    if( !isset( $_POST['single_layout_meta_nonce_id'] ) || !wp_verify_nonce( sanitize_key( $_POST['single_layout_meta_nonce_id'] ), 'single_layout_meta_nonce' ) ) {
		        return;
		    }
		    
		    // if our current user can't edit this post, bail
		    if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		        return;
		    } 

		    $theme_prefix = perfectwpthemes_toolkit_theme_prefix();

			$single_layout_key = $theme_prefix . '_single_layout';

		    if( isset( $_POST['single_layout'] ) ) {

				update_post_meta( $post->ID, $single_layout_key, sanitize_text_field( wp_unslash( $_POST['single_layout'] ) ) ); 
			}
		}
	}
endif;