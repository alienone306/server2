<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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

		<main id="main-style" class="page-index blog-page">

			<div id="skywp-content" class="content-wrapper <?php echo esc_attr( skywp_select_post_style() ); ?> <?php echo esc_attr( skywp_number_columns_posts() ); ?>">

				<?php
				if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					 * Include the Post-Type-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_type() );

				endwhile;

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
				
			</div><!-- .content-wrapper -->

			<?php the_posts_pagination(
				array(
					'show_all'     => true, // shows all pages in pagination involved
					'end_size'     => 1,     // number of pages at ends
					'mid_size'     => 1,     // number of pages around the current page
					'prev_next'    => true,  // whether to display side links "previous/next page".
					'prev_text'    => '<i class="fas fa-chevron-left"></i>',
					'next_text'    => '<i class="fas fa-chevron-right"></i>',
				)
			); ?>

		</main><!-- #main -->

	</div><!-- #primary -->

	<?php get_sidebar(); ?>

</div><!-- #content-wrap -->

<?php get_footer(); ?>
