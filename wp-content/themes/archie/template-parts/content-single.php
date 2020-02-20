<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */
$options = archie_get_theme_options();
$class = has_post_thumbnail() ? '' : 'no-post-thumbnail';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clear ' . $class ); ?>>
	
    <?php  
    /**
	 * Hook archie_author_profile_action
	 *  
	 * @hooked archie_get_author_profile 
	 */
    do_action( 'archie_author_profile_action' );
    ?>

    <div class="featured-image">
    	<?php if ( has_post_thumbnail() ) :
	        the_post_thumbnail( 'full', array( 'alt' => the_title_attribute( 'echo=0' ) ) );
	    endif;
        
        if ( ! $options['single_post_hide_date'] ) : ?>
	        <div class="entry-meta">
	            <?php archie_posted_on(); ?>
	        </div><!-- .entry-meta -->
        <?php endif; ?>
    </div>

	<div class="post-wrapper">
		<div class="entry-container">
			<div class="entry-content">
				<?php
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'archie' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'archie' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->

			<?php archie_entry_footer(); ?>
		</div><!-- .entry-container -->
    </div><!-- .post-wrapper -->
</article><!-- #post-## -->
