<?php

/**
 * Function to get post and page layout.
 */
if( ! function_exists( 'perfectwpthemes_toolkit_single_layout' ) ) {

	function perfectwpthemes_toolkit_single_layout() {

		$theme_prefix = perfectwpthemes_toolkit_theme_prefix();

		$single_layout_key = $theme_prefix . '_single_layout';

		$single_layout = get_post_meta( get_the_ID(), $single_layout_key, true );

		if( empty( $single_layout ) ) {

			return 'layout_one';
		} else {

			return $single_layout;
		}
	}
}

/**
 * Function to define widget area.
 */
if( ! function_exists( 'perfectwpthemes_toolkit_instagram_widget_area' ) ) {

	function perfectwpthemes_toolkit_instagram_widget_area() {

		if( is_active_sidebar( 'glaze-blog-instagram-widget-area' ) ) :
			?>
			<div class="primary-widget-area primary-insta-widget-area">
				<?php dynamic_sidebar( 'glaze-blog-instagram-widget-area' ) ?>
			</div><!-- .primary-widget-area.primary-insta-widget-area -->
			<?php
		endif;
	}
}


/**
 * Function to get social share template.
 */
if( ! function_exists( 'perfectwpthemes_toolkit_social_share' ) ) {

	function perfectwpthemes_toolkit_social_share() {

		if( is_attachment() ) {

			return;
		}

        $global_share 			= perfectwpthemes_toolkit_get_option( 'display_social_share_global' );

        $share_on_facebook 		= perfectwpthemes_toolkit_get_option( 'share_on_facebook' );
        $share_on_twitter 		= perfectwpthemes_toolkit_get_option( 'share_on_twitter' );
        $share_on_pinterest 	= perfectwpthemes_toolkit_get_option( 'share_on_pinterest' );
        $share_on_linkedin 		= perfectwpthemes_toolkit_get_option( 'share_on_linkedin' );
        $share_on_reddit 		= perfectwpthemes_toolkit_get_option( 'share_on_reddit' );
        $share_on_tumblr 		= perfectwpthemes_toolkit_get_option( 'share_on_tumblr' );
        $share_on_digg 			= perfectwpthemes_toolkit_get_option( 'share_on_digg' );
        $share_on_vk 			= perfectwpthemes_toolkit_get_option( 'share_on_vk' );

        $share_on_archive 		= perfectwpthemes_toolkit_get_option( 'display_archive_social_share' );
        $share_on_blog 			= perfectwpthemes_toolkit_get_option( 'display_blog_social_share' );
        $share_on_search 		= perfectwpthemes_toolkit_get_option( 'display_search_social_share' );
        $share_on_post 			= perfectwpthemes_toolkit_get_option( 'display_post_single_social_share' );
        $share_on_page 			= perfectwpthemes_toolkit_get_option( 'display_page_single_social_share' );

        if( $global_share == true ) :

        	if( is_page() && $share_on_page == true ) {

        		perfectwpthemes_toolkit_singular_social_share( $share_on_facebook, $share_on_twitter, $share_on_pinterest, $share_on_linkedin, $share_on_reddit, $share_on_tumblr, $share_on_digg, $share_on_vk );
        	}

        	if( is_single() && $share_on_post == true ) {

        		perfectwpthemes_toolkit_singular_social_share( $share_on_facebook, $share_on_twitter, $share_on_pinterest, $share_on_linkedin, $share_on_reddit, $share_on_tumblr, $share_on_digg, $share_on_vk );
        	}

        	if( is_home() && $share_on_blog == true ) {

        		perfectwpthemes_toolkit_non_singular_social_share( $share_on_facebook, $share_on_twitter, $share_on_pinterest, $share_on_linkedin, $share_on_reddit, $share_on_tumblr, $share_on_digg, $share_on_vk );
        	}

        	if( is_archive() && $share_on_archive == true ) {

        		perfectwpthemes_toolkit_non_singular_social_share( $share_on_facebook, $share_on_twitter, $share_on_pinterest, $share_on_linkedin, $share_on_reddit, $share_on_tumblr, $share_on_digg, $share_on_vk );
        	}

        	if( is_search() && $share_on_search == true ) {

			perfectwpthemes_toolkit_non_singular_social_share( $share_on_facebook, $share_on_twitter, $share_on_pinterest, $share_on_linkedin, $share_on_reddit, $share_on_tumblr, $share_on_digg, $share_on_vk );        		
        	}
		endif;
	}
}


/**
 * Function to define template for social share in post and page single.
 */
if( !function_exists( 'perfectwpthemes_toolkit_singular_social_share' ) ) :

	function perfectwpthemes_toolkit_singular_social_share( $share_facebook, $share_twitter, $share_pinterest, $share_linkedin, $share_reddit, $share_tumblr, $share_digg, $share_vk ) {

		$post_url   = urlencode( esc_url( get_permalink() ) );

        $post_title = urlencode( get_the_title( get_the_ID() ) );

        $post_thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

        $facebook_share_link = sprintf( 'http://www.facebook.com/share.php?u=%1$s&title=%2$s', $post_url, $post_title );
        $twitter_share_link = sprintf( 'http://twitter.com/home?status=%1$s+%2$s', $post_title, $post_url );
        $linkedin_share_link = sprintf( 'https://www.linkedin.com/shareArticle?url=%1$s&title=%2$s&mini=true', $post_url, $post_title );
        $pinterest_share_link = sprintf( 'http://pinterest.com/pin/create/button/?url=%s', $post_url );
        $reddit_share_link = sprintf( 'http://www.reddit.com/submit?url=%1$s&title=$2$s', $post_url, $post_title );
        $tumblr_share_link = sprintf( 'http://www.tumblr.com/share?v=3&u=%1$s&t=%2$s', $post_url, $post_title );
        $digg_share_link = sprintf( 'http://www.digg.com/submit?phase=2&url=%1$s&title=%2$s', $post_url, $post_title );
        $vk_share_link = sprintf( 'http://vk.com/share.php?url=%1$s&title=%2$s', $post_url, $post_title );
		?>
		<div id="sticky-social">
            <ul class="social-icons-list colored-social-icons">
            	<?php
	        	if( $share_facebook == true ) :
		        	?>
	                <li class="fb">
	                	<a href="<?php echo esc_url( $facebook_share_link ); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
	                </li>
	                <?php
		        endif;

		        if( $share_twitter == true ) :
		        	?>
	                <li class="tw">
	                	<a href="<?php echo esc_url( $twitter_share_link ); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
	                </li>
	                <?php
		        endif;

		        if( $share_pinterest == true ) :
		        	?>
	                <li class="pin">
	                	<a href="<?php echo esc_url( $pinterest_share_link ) ?>"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
	                </li>
	                <?php
		        endif;

		        if( $share_linkedin == true ) :
		        	?>
		        	<li class="lk">
	                	<a href="<?php echo esc_url( $linkedin_share_link ) ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
	                </li>
		        	<?php
		        endif;

		        if( $share_reddit == true ) :
		        	?>
		        	<li class="rd">
	                	<a href="<?php echo esc_url( $reddit_share_link ) ?>"><i class="fa fa-reddit" aria-hidden="true"></i></a>
	                </li>
		        	<?php
		        endif;

		        if( $share_tumblr == true ) :
		        	?>
		        	<li class="tmb">
	                	<a href="<?php echo esc_url( $tumblr_share_link ) ?>"><i class="fa fa-tumblr" aria-hidden="true"></i></a>
	                </li>
		        	<?php
		        endif;

		        if( $share_digg == true ) :
		        	?>
		        	<li class="dg">
	                	<a href="<?php echo esc_url( $digg_share_link ) ?>"><i class="fa fa-digg" aria-hidden="true"></i></a>
	                </li>
		        	<?php
		        endif;

		        if( $share_vk == true ) :
		        	?>
		        	<li class="vk">
	                	<a href="<?php echo esc_url( $vk_share_link ) ?>"><i class="fa fa-vk" aria-hidden="true"></i></a>
	                </li>
		        	<?php
		        endif;
	            ?>
            </ul><!-- .social-icons-list.colored-socal-icons -->
        </div><!-- #sticky-social -->
	    <?php
	}
endif;


/**
 * Function to define template for social share in archive, search and blog single.
 */
if( !function_exists( 'perfectwpthemes_toolkit_non_singular_social_share' ) ) :

	function perfectwpthemes_toolkit_non_singular_social_share( $share_facebook, $share_twitter, $share_pinterest, $share_linkedin, $share_reddit, $share_tumblr, $share_digg, $share_vk ) {

		$post_url   = urlencode( esc_url( get_permalink() ) );

        $post_title = urlencode( get_the_title( get_the_ID() ) );

        $post_thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

        $facebook_share_link = sprintf( 'http://www.facebook.com/share.php?u=%1$s&title=%2$s', $post_url, $post_title );
        $twitter_share_link = sprintf( 'http://twitter.com/home?status=%1$s+%2$s', $post_title, $post_url );
        $linkedin_share_link = sprintf( 'https://www.linkedin.com/shareArticle?url=%1$s&title=%2$s&mini=true', $post_url, $post_title );
        $pinterest_share_link = sprintf( 'http://pinterest.com/pin/create/button/?url=%s', $post_url );
        $reddit_share_link = sprintf( 'http://www.reddit.com/submit?url=%1$s&title=$2$s', $post_url, $post_title );
        $tumblr_share_link = sprintf( 'http://www.tumblr.com/share?v=3&u=%1$s&t=%2$s', $post_url, $post_title );
        $digg_share_link = sprintf( 'http://www.digg.com/submit?phase=2&url=%1$s&title=%2$s', $post_url, $post_title );
        $vk_share_link = sprintf( 'http://vk.com/share.php?url=%1$s&title=%2$s', $post_url, $post_title );
		?>
		<div class="col">
			<div class="social-icons">
		        <ul class="social-icons-list">
		        	<?php
		        	if( $share_facebook == true ) :
			        	?>
			            <li>
			            	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Share on Facebook', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $facebook_share_link ); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
			            </li>
			            <?php
			        endif;

			        if( $share_twitter == true ) :
			        	?>
			            <li>
			            	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Twitt on Twitter', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $twitter_share_link ); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			            </li>
			            <?php
			        endif;

			        if( $share_pinterest == true ) :
			        	?>
			            <li>
			            	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Pin on Pinterest', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $pinterest_share_link ) ?>"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
			            </li>
			            <?php
			        endif;

			        if( $share_linkedin == true ) :
			        	?>
			        	<li>
			            	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Share on Linkedin', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $linkedin_share_link ) ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
			            </li>
			        	<?php
			        endif;

			        if( $share_reddit == true ) :
			        	?>
			        	<li>
			            	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Share on Reddit', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $reddit_share_link ) ?>"><i class="fa fa-reddit" aria-hidden="true"></i></a>
			            </li>
			        	<?php
			        endif;

			        if( $share_tumblr == true ) :
			        	?>
			        	<li>
			            	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Share on Tumblr', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $tumblr_share_link ) ?>"><i class="fa fa-tumblr" aria-hidden="true"></i></a>
			            </li>
			        	<?php
			        endif;

			        if( $share_digg == true ) :
			        	?>
			        	<li>
			            	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Share on Digg', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $digg_share_link ) ?>"><i class="fa fa-digg" aria-hidden="true"></i></a>
			            </li>
			        	<?php
			        endif;

			        if( $share_vk == true ) :
			        	?>
			        	<li>
			            	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Share on VK', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $vk_share_link ) ?>"><i class="fa fa-vk" aria-hidden="true"></i></a>
			            </li>
			        	<?php
			        endif;
			        ?>
		        </ul>
		    </div><!-- .social-icons -->
		</div><!-- .col -->
	    <?php
	}
endif;


/**
 * Function to define template for author title or designation.
 */
if( !function_exists( 'perfectwpthemes_toolkit_author_title' ) ) :

	function perfectwpthemes_toolkit_author_title() {

		$author_id = get_the_author_meta( 'ID' );

		$theme_prefix = perfectwpthemes_toolkit_theme_prefix();

		$designation_meta_key = $theme_prefix . '_author_designation';

		$author_title = get_the_author_meta( $designation_meta_key, $author_id );

		if( !empty( $author_title ) ) :
			?>
			<p class="author-professsional"><?php echo esc_html( $author_title ); ?></p>
		    <?php
		endif;
	}
endif;


/**
 * Function to define template for author social links.
 */
if( !function_exists( 'perfectwpthemes_toolkit_author_links' ) ) :

	function perfectwpthemes_toolkit_author_links() {

		$author_id = get_the_author_meta( 'ID' );

		$theme_prefix = perfectwpthemes_toolkit_theme_prefix();

		$facebook_meta_key = $theme_prefix . '_author_facebook_link';
		$facebook_link = get_the_author_meta( $facebook_meta_key, $author_id );

		$twitter_meta_key = $theme_prefix . '_author_twitter_link';
		$twitter_link = get_the_author_meta( $twitter_meta_key, $author_id );

		$instagram_meta_key = $theme_prefix . '_author_instagram_link';
		$instagram_link = get_the_author_meta( $instagram_meta_key, $author_id );

		$googleplus_meta_key = $theme_prefix . '_author_googleplus_link';
		$googleplus_link = get_the_author_meta( $googleplus_meta_key, $author_id );

		$linkedin_meta_key = $theme_prefix . '_author_linkedin_link';
		$linkedin_link = get_the_author_meta( $linkedin_meta_key, $author_id );

		$pinterest_meta_key = $theme_prefix . '_author_pinterest_link';
		$pinterest_link = get_the_author_meta( $pinterest_meta_key, $author_id );

		$youtube_meta_key = $theme_prefix . '_author_youtube_link';
		$youtube_link = get_the_author_meta( $youtube_meta_key, $author_id );

		$vk_meta_key = $theme_prefix . '_author_vk_link';
		$vk_link = get_the_author_meta( $vk_meta_key, $author_id );

		?>
		<div class="social-icons">
            <ul class="social-icons-list">
            	<?php
            	if( !empty( $facebook_link ) ) :
	            	?>
	                <li>
	                	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Follow on facebook', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $facebook_link ); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
	                </li>
	                <?php
	            endif;

	            if( !empty( $twitter_link ) ) :
	            	?>
	                <li>
	                	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Follow on twitter', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $twitter_link ); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
	                </li>
	                <?php
	            endif;

	            if( !empty( $instagram_link ) ) :
	            	?>
	                <li>
	                	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Follow on instagram', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $instagram_link ); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
	                </li>
	                <?php
	            endif;

	            if( !empty( $pinterest_link ) ) :
	            	?>
	                <li>
	                	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Follow on pinterest', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $pinterest_link ); ?>"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
	                </li>
	                <?php
	            endif;

	            if( !empty( $youtube_link ) ) :
	            	?>
	                <li>
	                	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Subscribe at youtube', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $youtube_link ); ?>"><i class="fa fa-youtube" aria-hidden="true"></i></a>
	                </li>
	                <?php
	            endif;

	            if( !empty( $linkedin_link ) ) :
	            	?>
	                <li>
	                	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Connect on linkedin', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $linkedin_link ); ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
	                </li>
	                <?php
	            endif;

	            if( !empty( $vk_link ) ) :
	            	?>
	                <li>
	                	<a class="tool-tip" data-tippy-content="<?php esc_attr_e( 'Follow on vk', 'perfectwpthemes-toolkit' ); ?>" href="<?php echo esc_url( $vk_link ); ?>"><i class="fa fa-vk" aria-hidden="true"></i></a>
	                </li>
	                <?php
	            endif;
	            ?>
            </ul><!-- .social-icons-list -->
        </div><!-- .social-icons -->
		<?php
	}
endif;