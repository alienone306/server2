<?php
/**
 * Template part for displaying results in search pages
 *
 * @package Urchenko Technologies
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */

?>

<?php get_template_part( 'template-parts/content', get_post_type() ); ?>

<?php if ( false ) { ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'item' ); ?>>
	<div class="blog-wrap">

		<div class="post-image">
			<?php sky_post_thumbnail(); ?>
		</div><!-- .post-image -->

		<div class="post-content-wrap">

			<header class="entry-header">
				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;

				if ( 'post' === get_post_type() ) :
					?>
					<div class="entry-meta">
						<ul>
							<li class="meta-date">
								<i class="far fa-calendar-alt"></i><span><?php the_time( get_option( 'date_format' ) ); ?></span>
							</li>
							<li class="meta-author">
								<i class="far fa-user"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
							</li>
							<li class="meta-comments">
								<i class="far fa-comments"></i><?php comments_popup_link( '0', '1', '%', '', esc_html__( 'Comments Off', 'skywp' ) ); ?>
								
									
							</li>
						</ul>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php 

				if ( is_singular() ) {
					the_content();
				}
				else {
					the_excerpt();
				}

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'skywp' ),
					'after'  => '</div>',
				) );
				?>
				
			</div><!-- .entry-content -->

		</div><!-- .post-content-wrap -->

</article><!-- #post-<?php the_ID(); ?> -->
<?php } ?>