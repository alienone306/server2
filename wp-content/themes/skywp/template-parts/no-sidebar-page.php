<?php
/*
Template Name: No Sidebar
Template Post Type: page

* @package Urchenko
* @subpackage SkyWP WordPress theme
* @since SkyWP 1.0.0
*/
get_header();
?>
<div id="no-sidebar-page">
	
	<div id="primary" class="content-area">

		<div id="page-content" class="post-content wrapper">

		<?php
		while ( have_posts() ) :
			the_post();
			
			if ( is_singular() ) {
				the_content();
			}

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</div><!-- #page-content -->

	</div><!-- #primary -->

</div><!-- #content-wrap -->

<?php get_footer(); ?>
