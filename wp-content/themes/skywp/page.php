<?php
/**
 * The template for displaying all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Urchenko Technologies
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */

get_header();
?>
<div id="content-wrap" class="wrapper">
	
	<div id="primary" class="content-area">

		<div id="page-content" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</div><!-- #page-content -->

	</div><!-- #primary -->

	<?php get_sidebar(); ?>

</div><!-- #content-wrap -->

<?php get_footer(); ?>
