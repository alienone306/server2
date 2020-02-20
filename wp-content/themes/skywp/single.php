<?php
/**
 * The template for displaying all single posts
 *
 * @package Urchenko
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */

get_header();
?>
<div id="content-wrap" class="wrapper single">

	<div id="primary" class="content-area">

		<div id="single-content" class="article-page">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

				the_post_navigation();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</div><!-- #single-content -->

	</div><!-- #primary -->

	<?php get_sidebar(); ?>

</div><!-- #content-wrap -->

<?php get_footer(); ?>


