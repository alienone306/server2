<?php
/**
 * Latest section
 *
 * This is the template for the content of latest section
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */
if ( ! function_exists( 'archie_add_latest_section' ) ) :
    /**
    * Add latest section
    *
    *@since Archie 1.0.0
    */
    function archie_add_latest_section() {
    	$options = archie_get_theme_options();
        // Check if latest is enabled on frontpage
        $latest_enable = apply_filters( 'archie_section_status', true, 'latest_section_enable' );

        if ( true !== $latest_enable ) {
            return false;
        }
        // Get latest section details
        $section_details = array();
        $section_details = apply_filters( 'archie_filter_latest_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render latest section now.
        archie_render_latest_section( $section_details );
    }
endif;

if ( ! function_exists( 'archie_get_latest_section_details' ) ) :
    /**
    * latest section details.
    *
    * @since Archie 1.0.0
    * @param array $input latest section details.
    */
    function archie_get_latest_section_details( $input ) {
        $options = archie_get_theme_options();
        
        $content = array();
        $cat_id = ! empty( $options['latest_content_category'] ) ? $options['latest_content_category'] : '';
        $args = array(
            'post_type'         => 'post',
            'posts_per_page'    => 4,
            'cat'               => absint( $cat_id ),
            'ignore_sticky_posts'   => true,
            );                    

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'post-thumbnail' ) : get_template_directory_uri() . '/assets/uploads/no-featured-image-590x650.jpg';

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
// latest section content details.
add_filter( 'archie_filter_latest_section_details', 'archie_get_latest_section_details' );


if ( ! function_exists( 'archie_render_latest_section' ) ) :
  /**
   * Start latest section
   *
   * @return string latest content
   * @since Archie 1.0.0
   *
   */
   function archie_render_latest_section( $content_details = array() ) {
        $options = archie_get_theme_options();
        $readmore = ! empty( $options['read_more_text'] ) ? $options['read_more_text'] : esc_html__( 'Read More', 'archie' );

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="latest-projects" class="relative page-section">
            <div class="project-wrapper clear">
                <div class="wrapper">
                    <?php if ( ! empty( $options['latest_title'] ) ) : ?>
                        <div class="section-header">
                            <h2 class="section-title color-black"><?php echo esc_html( $options['latest_title'] ); ?></h2>
                        </div><!-- .section-header -->
                    <?php endif; ?>
                </div><!-- .wrapper -->
            </div>

            <div class="project-slider" data-slick='{"slidesToShow": 3, "slidesToScroll": 1, "infinite": true, "speed": 500, "dots": false, "centerMode": true, "arrows":true, "autoplay": true, "fade": false, "focusOnSelect": true, "draggable": false }'>
                <?php $i = 1;
                foreach ( $content_details as $content ) : ?>
                    <article class="slick-item" style="background-image: url('<?php echo esc_url( $content['image'] ); ?>');">
                        <div class="count"><?php echo 0 . $i; ?></div>
                        <div class="entry-container">
                            <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                            <div class="seperator"></div>
                        </div><!-- .entry-container -->
                    </article><!-- .slick-item -->

                <?php $i++; 
                endforeach; ?>
            </div><!-- .project-slider -->
               
        </div><!-- #latest-projects -->
        
    <?php }
endif;