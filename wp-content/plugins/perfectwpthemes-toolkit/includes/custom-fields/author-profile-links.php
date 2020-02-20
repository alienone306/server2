<?php

if( ! class_exists( 'Perfectwpthemes_Toolkit_Author_Custom_Field' ) ) {

	class Perfectwpthemes_Toolkit_Author_Custom_Field {

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 */
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

	   		// Register author meta fields and save meta fields values.
	 		add_action( 'show_user_profile', array( $this, 'author_meta' ), 10 );
			add_action( 'edit_user_profile', array( $this, 'author_meta' ), 10 );
	 		add_action( 'personal_options_update', array( $this, 'author_meta_save' ), 10 );
			add_action( 'edit_user_profile_update', array( $this, 'author_meta_save' ), 10 );
	   	}

	   	/**
	     * Create Social Fields For Author.
	     *
	     * @since 1.0.0
	   	 */
	   	function author_meta( $user ) { 

	   		$theme_prefix = perfectwpthemes_toolkit_theme_prefix();

	   		$designation_meta_key = $theme_prefix . '_author_designation';
			$designation = get_the_author_meta( $designation_meta_key, $user->ID );

			$facebook_meta_key = $theme_prefix . '_author_facebook_link';
			$facebook_link = get_the_author_meta( $facebook_meta_key, $user->ID );

			$twitter_meta_key = $theme_prefix . '_author_twitter_link';
			$twitter_link = get_the_author_meta( $twitter_meta_key, $user->ID );

			$instagram_meta_key = $theme_prefix . '_author_instagram_link';
			$instagram_link = get_the_author_meta( $instagram_meta_key, $user->ID );

			$linkedin_meta_key = $theme_prefix . '_author_linkedin_link';
			$linkedin_link = get_the_author_meta( $linkedin_meta_key, $user->ID );

			$pinterest_meta_key = $theme_prefix . '_author_pinterest_link';
			$pinterest_link = get_the_author_meta( $pinterest_meta_key, $user->ID );

			$youtube_meta_key = $theme_prefix . '_author_youtube_link';
			$youtube_link = get_the_author_meta( $youtube_meta_key, $user->ID );

			$vk_meta_key = $theme_prefix . '_author_vk_link';
			$vk_link = get_the_author_meta( $vk_meta_key, $user->ID );
			?>
		   <h3><?php esc_html_e( 'Profile & Links', 'perfectwpthemes-toolkit' ); ?></h3>
		   <table class="form-table">
		       <tr>
		           <th><label for="designation"><?php esc_html_e( 'Designation (Title)','perfectwpthemes-toolkit' ); ?></label></th>
		           <td>
		               <input type="text" name="designation" id="designation" value="<?php echo esc_attr( $designation ); ?>" class="regular-text" />
		           </td>
		       </tr>

		       <tr>
		           <th><label for="facebook_link"><?php esc_html_e( 'Facebook Profile Link','perfectwpthemes-toolkit' ); ?></label></th>
		           <td>
		               <input type="url" name="facebook_link" id="facebook_link" value="<?php echo esc_url( $facebook_link ); ?>" class="regular-text" />
		           </td>
		       </tr>

		       <tr>
		           <th><label for="twitter_link"><?php esc_html_e('Twitter Profile Link','perfectwpthemes-toolkit'); ?></label></th>
		           <td>
		               <input type="url" name="twitter_link" id="twitter_link" value="<?php echo esc_attr( $twitter_link ); ?>" class="regular-text" />
		           </td>
		       </tr>

		       <tr>
		           <th><label for="instagram_link"><?php esc_html_e('Instagram Profile Link','perfectwpthemes-toolkit'); ?></label></th>
		           <td>
		               <input type="url" name="instagram_link" id="instagram_link" value="<?php echo esc_url( $instagram_link ); ?>" class="regular-text" />
		           </td>
		       </tr>

		       <tr>
		           <th><label for="linkedin_link"><?php esc_html_e('Linkedin Profile Link','perfectwpthemes-toolkit'); ?></label></th>
		           <td>
		               <input type="url" name="linkedin_link" id="linkedin_link" value="<?php echo esc_url( $linkedin_link ); ?>" class="regular-text" />
		           </td>
		       </tr>

		       <tr>
		           <th><label for="pinterest_link"><?php esc_html_e('Pinterest Profile Link','perfectwpthemes-toolkit'); ?></label></th>
		           <td>
		               <input type="url" name="pinterest_link" id="pinterest_link" value="<?php echo esc_url( $pinterest_link ); ?>" class="regular-text" />
		           </td>
		       </tr>

		       	<tr>
		           	<th><label for="youtube_link"><?php esc_html_e('Youtube Channel Link','perfectwpthemes-toolkit'); ?></label></th>
		           	<td>
		               	<input type="url" name="youtube_link" id="youtube_link" value="<?php echo esc_url( $youtube_link ); ?>" class="regular-text" />
		           	</td>
		       	</tr>

		       	<tr>
		           	<th><label for="vk_link"><?php esc_html_e('VK Link','perfectwpthemes-toolkit'); ?></label></th>
		           	<td>
		               	<input type="url" name="vk_link" id="vk_link" value="<?php echo esc_url( $vk_link ); ?>" class="regular-text" />
		           	</td>
		       	</tr>
		   </table>
			<?php 
		}

		/**
	     * Save Author Custom Fields.
	     *
	     * @since 1.0.0
	   	 */
	   	function author_meta_save( $user_id ) {

	   		$link_fields = array( 'facebook_link', 'twitter_link', 'instagram_link', 'linkedin_link', 'pinterest_link', 'vk_link', 'youtube_link' );

	   		$text_fields = array( 'designation' );

	       	if ( !current_user_can( 'edit_user', $user_id ) ) {
	       		return false;
	       	}

	       	$theme_prefix = perfectwpthemes_toolkit_theme_prefix();

	        foreach( $link_fields as $field ) {

	        	$meta_key = $theme_prefix . '_author_' . $field;

	        	if( !empty( $_POST[ $field ] ) ) {

	        		update_user_meta( $user_id, $meta_key, esc_url_raw( wp_unslash( $_POST[ $field ] ) ) );
	        	}
	        }

	        foreach( $text_fields as $field ) {

	        	$meta_key = $theme_prefix . '_author_' . $field;

	        	if( !empty( $_POST[ $field ] ) ) {

	        		update_user_meta( $user_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
	        	}
	        }
	   	}
	}
}