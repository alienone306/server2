<?php
/*
Template Name: Full Width For Elementor
Template Post Type: page,

* @package Urchenko Technologies
* @subpackage SkyWP WordPress theme
* @since SkyWP 1.0.0
*/
get_header();
?>
<div id="full-width-wrap">
	
	<div id="primary" class="content-area">

		<div id="page-content" class="site-main">

		<?php
		while ( have_posts() ) : the_post();

			the_content();

		endwhile; // End of the loop.
		?>

		</div><!-- #page-content -->

	</div><!-- #primary -->

</div><!-- #full-width-wrap -->

<?php get_footer(); ?>
