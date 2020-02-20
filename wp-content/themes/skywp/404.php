<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Urchenko Technologies
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */

get_header();
?>
<div id="content-wrap" class="wrapper">

	<div id="primary-404" class="content-area">

		<main id="main-style" class="site-404">

			<section class="error-404 not-found">

				<div class="content-page widget-area">
					<div class="site_widget">
						<h3 class="error"><?php esc_html_e( '404', 'skywp' ); ?></h3>
					</div>
					<?php dynamic_sidebar('page-404'); ?>
				</div><!-- .content-page -->

			</section><!-- .error-404 -->

		</main><!-- #main -->

	</div><!-- #primary -->

</div><!-- #content-wrap -->

<?php get_footer(); ?>