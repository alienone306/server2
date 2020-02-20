<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

get_header(); 
?>

<div id="inner-content-wrapper">
	<?php  
	$sticky_posts = get_option( 'sticky_posts' );
	if ( ! empty($sticky_posts) ) :
		$sticky_count = count( $sticky_posts );

	?>
		<div class="posts-wrapper blog-post">
	        <div class="sticky-post-wrapper col-<?php echo ( $sticky_count >= 3 ) ? 3 : absint( $sticky_count ); ?>">
		        <div class="wrapper">
		        	<?php $sticky_args = array(
		        		'post_type'	=> 'post',
		        		'post__in'	=> ( array ) $sticky_posts,
		        		'posts_per_page' => absint( $sticky_count ),
		        	); 
		        	$sticky_query = new WP_Query( $sticky_args );
		        	if ( $sticky_query->have_posts() ) : while ( $sticky_query->have_posts() ) : $sticky_query->the_post();
		        	?>
			            <article class="hentry sticky has-post-thumbnail">
			                <div class="entry-meta">
			                    <?php archie_posted_on( get_the_id() ); ?>    
			                </div><!-- .entry-meta -->
			                <div class="sticky-featured-wrapper">
			                	<?php if ( has_post_thumbnail() ) : ?>
				                    <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'medium_large' ); ?>');">
				                    </div><!-- .featured-image -->
				                <?php endif; ?>

			                    <div class="entry-container">
			                        <header class="entry-header">
			                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			                        </header>

			                        <div class="entry-content">
			                            <?php the_excerpt(); ?>
			                        </div><!-- .entry-content -->
			                    </div><!-- .entry-container -->
			                </div><!-- ..sticky-featured-wrapper -->
			            </article><!--.sticky -->
			        <?php endwhile; endif; 
			        wp_reset_postdata(); ?>
		        </div><!--.wrapper -->
		    </div><!--.sticky-post-wrapper -->
		</div><!--.posts-wrapper -->
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="posts-wrapper blog-wrapper">
				<?php
				if ( have_posts() ) : ?>

					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );

					endwhile;

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
			</div>
			<?php  
			/**
			* Hook - archie_action_pagination.
			*
			* @hooked archie_pagination 
			*/
			do_action( 'archie_action_pagination' ); 
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php  
	if ( archie_is_sidebar_enable() ) {
		get_sidebar();
	}
	?>
</div><!-- .wrapper -->

<?php
get_footer();
