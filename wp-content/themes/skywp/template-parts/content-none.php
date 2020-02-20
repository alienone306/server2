<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Urchenko
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */

?>

<div class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( "Couldn't find what you're looking for!", 'skywp' ); ?></h1>
	</header><!-- .page-header -->

		<div class="content-wrap">

			<div class="column-first">
				<h2 class="oops"><?php esc_html_e( "Oops!", 'skywp' ); ?></h2>
			</div>

			<div class="column-second">
				<h3><?php esc_html_e( "Try again", 'skywp' ); ?></h3>
				<?php
				if ( is_home() && current_user_can( 'publish_posts' ) ) :

					printf(
						'<p>' . wp_kses(
							/* translators: 1: link to WP admin new post page. */
							__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'skywp' ),
							array(
								'a' => array(
									'href' => array(),
								),
							)
						) . '</p>',
						esc_url( admin_url( 'post-new.php' ) )
					);

				elseif ( is_search() ) :
					?>

					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'skywp' ); ?></p>
					<?php

				else :
					?>

					<p><?php esc_html_e( "It seems we can't find what you're looking for. Perhaps searching can help.", 'skywp' ); ?></p>
					<?php

				endif;

				get_search_form();
				?>
			</div>
			
		</div><!-- .content-wrap -->

</div><!-- .no-results -->
