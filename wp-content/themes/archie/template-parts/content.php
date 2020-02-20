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
$class = has_post_thumbnail() ? '' : 'no-post-thumbnail';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>

    <div class="featured-image">
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
            </a>
        <?php endif; ?>

        <div class="entry-meta">
            <?php archie_posted_on(); ?>    
        </div><!-- .entry-meta -->
    </div><!-- .featured-image -->

    <div class="entry-container">

        <div class="header-meta">
            <?php echo archie_article_header_meta(); ?>
        </div><!-- .header-meta -->

        <header class="entry-header">
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </header>

        <div class="entry-content">
            <?php the_excerpt(); ?>
        </div><!-- .entry-content -->
    </div><!-- .entry-container -->

</article><!-- #post-## -->
