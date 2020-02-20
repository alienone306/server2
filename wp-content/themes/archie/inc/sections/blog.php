<?php
/**
 * Blog section
 *
 * This is the template for the content of blog section
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */
if ( ! function_exists( 'archie_add_blog_section' ) ) :
    /**
    * Add blog section
    *
    *@since Archie 1.0.0
    */
    function archie_add_blog_section() {
    	$options = archie_get_theme_options();
        // Check if blog is enabled on frontpage
        $blog_enable = apply_filters( 'archie_section_status', true, 'blog_section_enable' );

        if ( true !== $blog_enable ) {
            return false;
        }
        // Get blog section details
        $section_details = array();
        $section_details = apply_filters( 'archie_filter_blog_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render blog section now.
        archie_render_blog_section( $section_details );
    }
endif;

if ( ! function_exists( 'archie_get_blog_section_details' ) ) :
    /**
    * blog section details.
    *
    * @since Archie 1.0.0
    * @param array $input blog section details.
    */
    function archie_get_blog_section_details( $input ) {
        $options = archie_get_theme_options();

        // Content type.
        $blog_content_type  = $options['blog_content_type'];        
        $content = array();
        switch ( $blog_content_type ) {
        	
            case 'category':
                $cat_id = ! empty( $options['blog_content_category'] ) ? $options['blog_content_category'] : '';
                $args = array(
                    'post_type'         => 'post',
                    'posts_per_page'    => 3,
                    'cat'               => absint( $cat_id ),
                    'ignore_sticky_posts'   => true,
                    );                    
            break;

            case 'recent':
                $cat_ids = ! empty( $options['blog_category_exclude'] ) ? $options['blog_category_exclude'] : array();
                $args = array(
                    'post_type'         => 'post',
                    'posts_per_page'    => 3,
                    'category__not_in'  => ( array ) $cat_ids,
                    'ignore_sticky_posts'   => true,
                    );                    
            break;

            default:
            break;
        }


        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = archie_trim_content( 20 );

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
        endif;
        wp_reset_postdata();

            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// blog section content details.
add_filter( 'archie_filter_blog_section_details', 'archie_get_blog_section_details' );


if ( ! function_exists( 'archie_render_blog_section' ) ) :
  /**
   * Start blog section
   *
   * @return string blog content
   * @since Archie 1.0.0
   *
   */
   function archie_render_blog_section( $content_details = array() ) {
        $options = archie_get_theme_options();
        $readmore = ! empty( $content['read_more_text'] ) ? $content['read_more_text'] : esc_html__( 'Read More', 'archie' );
        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="latest-posts" class="relative page-section no-padding-top">
            <div class="wrapper">
                <div class="blog-wrapper">
                    <?php if ( ! empty( $options['blog_title'] ) ) : ?>
                        <div class="section-header">
                            <h2 class="section-title color-black"><?php echo esc_html( $options['blog_title'] ); ?></h2>
                        </div><!-- .section-header -->
                    <?php endif; ?>
                </div>

                <!-- supports col-2,col-3,col-4 -->
                <div class="section-content">
                    <div class="posts-wrapper col-3">
                        <?php foreach ( $content_details as $content ) : ?>
                            <article class="hentry">
                                <div class="entry-meta">
                                    <?php archie_posted_on( $content['id'] ); ?>   
                                </div><!-- .entry-meta -->

                                <div class="entry-container">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                    </header>

                                    <div class="entry-content">
                                        <p><?php echo esc_html( $content['excerpt'] ); ?></p>
                                    </div><!-- .entry-content -->

                                    <div class="read-more">
                                        <a href="<?php echo esc_url( $content['url'] ); ?>" class="more-link"><?php echo esc_html( $readmore ); ?></a>
                                    </div><!-- .read-more -->
                                </div><!-- .entry-container -->
                            </article>
                        <?php endforeach; ?>
                    </div><!-- .posts-wrapper -->
                </div><!-- .section-content -->
            </div><!-- .wrapper -->
        </div><!-- #latest-posts -->

    <?php }
endif;