<?php
/**
 * Testimonial section
 *
 * This is the template for the content of testimonial section
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */
if ( ! function_exists( 'archie_add_testimonial_section' ) ) :
    /**
    * Add testimonial section
    *
    *@since Archie 1.0.0
    */
    function archie_add_testimonial_section() {
    	$options = archie_get_theme_options();
        // Check if testimonial is enabled on frontpage
        $testimonial_enable = apply_filters( 'archie_section_status', true, 'testimonial_section_enable' );

        if ( true !== $testimonial_enable ) {
            return false;
        }
        // Get testimonial section details
        $section_details = array();
        $section_details = apply_filters( 'archie_filter_testimonial_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render testimonial section now.
        archie_render_testimonial_section( $section_details );
    }
endif;

if ( ! function_exists( 'archie_get_testimonial_section_details' ) ) :
    /**
    * testimonial section details.
    *
    * @since Archie 1.0.0
    * @param array $input testimonial section details.
    */
    function archie_get_testimonial_section_details( $input ) {
        $options = archie_get_theme_options();
        
        $content = array();
        $page_ids = array();
        $position = array();

        for ( $i = 1; $i <= 3; $i++ ) {
            if ( ! empty( $options['testimonial_content_page_' . $i] ) ) :
                $page_ids[] = $options['testimonial_content_page_' . $i];
            endif;
        }
        
        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => 3,
            'orderby'           => 'post__in',
            );                    

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = archie_trim_content( 40 );
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'thumbnail' ) : get_template_directory_uri() . '/assets/uploads/no-featured-image-150x150.jpg';

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
// testimonial section content details.
add_filter( 'archie_filter_testimonial_section_details', 'archie_get_testimonial_section_details' );


if ( ! function_exists( 'archie_render_testimonial_section' ) ) :
  /**
   * Start testimonial section
   *
   * @return string testimonial content
   * @since Archie 1.0.0
   *
   */
   function archie_render_testimonial_section( $content_details = array() ) {
        $options = archie_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } 

        $count = 5;
        $class = 'five-slide';
        if ( count( $content_details ) <= 3 ) :
            $count = 1;
            $class = 'one-slide';
        elseif ( count( $content_details ) > 3 && count( $content_details ) <= 5 ) :
            $count = 3;
            $class = 'three-slide';
        endif;
        ?>

        <div id="client-testimonial" class="relative page-section align-center slider <?php echo esc_attr( $class ); ?>">
            <div class="wrapper">
                <?php if ( ! empty( $options['testimonial_title'] ) ) : ?>
                    <div class="section-header">
                        <h2 class="section-title color-black"><?php echo esc_html( $options['testimonial_title'] ); ?></h2>
                    </div><!-- .section-header -->
                <?php endif; ?>

                <div class="testimonial-slider" data-slick='{"slidesToShow": <?php echo absint( $count ); ?>, "slidesToScroll": 1, "infinite": true, "speed": 800, "dots": false, "draggable": false, "arrows":true, "autoplay": false, "fade": false, "centerMode" : true, "focusOnSelect": true}'>
                    <?php $i = 1; 
                    foreach ( $content_details as $content ) : ?>
                        <div class="slick-item" data-current="<?php echo $i ?>">
                            <article class="slick-item">
                                <?php if ( $content['image'] ) : ?>
                                    <div class="featured-image">
                                        <img src="<?php echo esc_url( $content['image'] ); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>">
                                        <div class="overlay"></div>
                                    </div><!-- .featured-image -->
                                <?php endif; ?>
                            </article><!-- .slick-item -->
                        </div><!-- .slick-item -->
                    <?php $i++;
                    endforeach; ?>
                </div><!-- .testimonial-slider -->

                <div class="content-wrapper">
                   <?php $i = 1;
                    foreach ( $content_details as $content ) : ?>
                        <div id="<?php echo $i; ?>" class="slick-content">
                            <div class="entry-container">
                                <header class="entry-header">
                                    <?php if ( ! empty( $content['title'] ) ) : ?>
                                        <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                    <?php endif; ?>
                                </header>

                                <?php if ( ! empty( $content['excerpt'] ) ) : ?>
                                    <div class="entry-content">
                                        <p><?php echo wp_kses_post( $content['excerpt'] ); ?></p> 
                                    </div><!-- .entry-content -->
                                <?php endif; ?>
                            </div><!-- .entry-container -->
                        </div><!-- .slick-content -->
                    <?php $i++;
                    endforeach; ?>
                </div>
            </div><!-- .wrapper -->
        </div><!-- #client-testimonial -->

    <?php }
endif;