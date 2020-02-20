<?php

if( ! function_exists( 'perfectwpthemes_toolkit_dynamic_style' ) ) {

	function perfectwpthemes_toolkit_dynamic_style() {

		$primary_color = perfectwpthemes_toolkit_get_option( 'primary_color' );
		?>
		<style>
			<?php
			if( !empty( $primary_color ) ) {
				?>


				a:hover,
				footer.dark a:hover,
				.editor-entry a,
				.gb-breadcrumb ul li a span:hover,
				footer.dark .footer-bottom a:hover,
				.gb-post-widget .entry-metas ul li.comment a:hover, 
				.gb-post-widget .entry-metas ul li.posted-date a:hover,
				.single-page-style-2 .entry-cats ul li a:hover,
				.single-page-style-2 .entry-metas ul li.posted-by a:hover,
				.single-page-style-2 .related-posts .entry-metas li a:hover,
				footer.dark .gb-post-widget :hover.entry-metas ul li.posted-date a:hover, 
				footer.dark .gb-post-widget .entry-metas ul li.comment a:hover,
				.widget_archive a:hover,
				.widget_categories a:hover,
				.widget_recent_entries a:hover,
				.widget_meta a:hover,
				.widget_product_categories a:hover,
				.widget_rss li a:hover,
				.widget_pages li a:hover,
				.widget_nav_menu li a:hover,
				.woocommerce-widget-layered-nav ul li a:hover,
				.widget_rss .widget-title h3 a:hover,
				.widget_rss ul li a:hover,
				.comments-area .comment-body .reply a:hover,
				.comments-area .comment-body .reply a:focus,
				.comments-area .comment-body .fn a:hover,
				.comments-area .comment-body .fn a:focus,
				footer.dark .widget_rss ul li a:hover,
				.comments-area .comment-body .fn:hover,
				.comments-area .comment-body .fn a:hover,
				.comments-area .comment-body .reply a:hover, 
				.comments-area .comment-body .comment-metadata a:hover,
				.comments-area .comment-body .comment-metadata .edit-link:hover	 {

					color: <?php echo esc_attr( $primary_color ); ?>;
				}

				.entry-tags .post-tags a:hover,
				.author-box .social-icons-list li a:hover {

					border-color: <?php echo esc_attr( $primary_color ); ?>;
				}

				button:hover,
				input[type="button"]:hover,
				input[type="reset"]:hover,
				input[type="submit"]:hover,
				button#load-comments:hover,
				.entry-tags .post-tags a:hover,
				.widget_tag_cloud .tagcloud a:hover,
				.gb-patigation a.page-numbers:hover,
				body .wpcf7 input[type="submit"]:hover,
				body .wpcf7 input[type="button"]:hover,
				.entry-metas ul li.posted-date a:hover,
				footer.dark .widget_tag_cloud .tagcloud a:hover,
				.single-page-style-2 .entry-metas ul li.posted-date a:hover,
				.secondary-widget-area .gb-instagram-widget .follow-permalink a:hover,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-handle, 
				.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
				.jetpack_subscription_widget input[type="submit"]:hover,
				body .wpforms-container .wpforms-form input[type=submit]:hover, 
				body .wpforms-container .wpforms-form button[type=submit]:hover,
				body .wpforms-container .wpforms-form .wpforms-page-button:hover,
				footer.dark button:hover, 
				footer.dark input[type="button"]:hover, 
				footer.dark input[type="reset"]:hover, 
				footer.dark input[type="submit"]:hover,
				body footer.dark .wpcf7 input[type="submit"]:hover, 
				body footer.dark .wpcf7 input[type="button"]:hover,
				body footer.dark .wpforms-container .wpforms-form input[type=submit]:hover, 
				body footer.dark .wpforms-container .wpforms-form button[type=submit]:hover,
				body footer.dark .wpforms-container .wpforms-form .wpforms-page-button:hover {

					background: <?php echo esc_attr( $primary_color ); ?>;
				}
				
				<?php
			}

			?>
		</style>
		<?php
	}
}
add_action( 'wp_head', 'perfectwpthemes_toolkit_dynamic_style' );