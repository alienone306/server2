<?php
/**
 * Client section
 *
 * This is the template for the content of client section
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */
if ( ! function_exists( 'archie_add_client_section' ) ) :
    /**
    * Add client section
    *
    *@since Archie 1.0.0
    */
    function archie_add_client_section() {
    	$options = archie_get_theme_options();
        // Check if client is enabled on frontpage
        $client_enable = apply_filters( 'archie_section_status', true, 'client_section_enable' );

        if ( true !== $client_enable ) {
            return false;
        }
        // Get client section details
        $section_details = array();
        $section_details = apply_filters( 'archie_filter_client_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render client section now.
        archie_render_client_section( $section_details );
    }
endif;

if ( ! function_exists( 'archie_get_client_section_details' ) ) :
    /**
    * client section details.
    *
    * @since Archie 1.0.0
    * @param array $input client section details.
    */
    function archie_get_client_section_details( $input ) {
        $options = archie_get_theme_options();
        $content = array();
        $page_ids = array();

        for ( $i = 1; $i <= 4; $i++ ) {
            if ( ! empty( $options['client_content_page_' . $i] ) )
                $page_ids[] = $options['client_content_page_' . $i];
        }
        
        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => absint( 4 ),
            'orderby'           => 'post__in',
            );                    

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'medium' ) : '';

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
// client section content details.
add_filter( 'archie_filter_client_section_details', 'archie_get_client_section_details' );


if ( ! function_exists( 'archie_render_client_section' ) ) :
  /**
   * Start client section
   *
   * @return string client content
   * @since Archie 1.0.0
   *
   */
   function archie_render_client_section( $content_details = array() ) {
        $options = archie_get_theme_options();
        $column = 4;
        $column = ( count( $content_details ) <= 4 ) ? count( $content_details ) : $column;
        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="our-partners" class="relative page-section">
            <div class="wrapper">
                <div class="logo-slider" data-slick='{"slidesToShow": <?php echo absint( $column ); ?>, "slidesToScroll": 1, "infinite": true, "speed": 800, "dots": false, "arrows":false, "autoplay": true, "fade": false }'>
                    <?php foreach ( $content_details as $content ) : 
                        if ( ! empty( $content['image'] ) ) : ?>
                            <article class="slick-item">
                                <div class="featured-image">
                                    <a href="<?php echo esc_url( $content['url'] ); ?>"><img src="<?php echo esc_url( $content['image'] ); ?>" title="<?php echo esc_attr( $content['title'] ); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>"></a>
                                </div><!-- .featured-image -->
                            </article>
                        <?php endif; 
                    endforeach; ?>
                </div><!-- .testimonial-slider -->
            </div><!-- .wrapper -->
        </div><!-- #our-partners -->

    <?php }
endif;