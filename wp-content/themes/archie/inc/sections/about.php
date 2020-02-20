<?php
/**
 * About section
 *
 * This is the template for the content of about section
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */
if ( ! function_exists( 'archie_add_about_section' ) ) :
    /**
    * Add about section
    *
    *@since Archie 1.0.0
    */
    function archie_add_about_section() {
    	$options = archie_get_theme_options();
        // Check if about is enabled on frontpage
        $about_enable = apply_filters( 'archie_section_status', true, 'about_section_enable' );

        if ( true !== $about_enable ) {
            return false;
        }
        // Get about section details
        $section_details = array();
        $section_details = apply_filters( 'archie_filter_about_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render about section now.
        archie_render_about_section( $section_details );
    }
endif;

if ( ! function_exists( 'archie_get_about_section_details' ) ) :
    /**
    * about section details.
    *
    * @since Archie 1.0.0
    * @param array $input about section details.
    */
    function archie_get_about_section_details( $input ) {
        $options = archie_get_theme_options();
        
        $content = array();
        $page_id = ! empty( $options['about_content_page'] ) ? $options['about_content_page'] : '';
        $args = array(
            'post_type'         => 'page',
            'page_id'           => $page_id,
            'posts_per_page'    => 1,
            );      

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = archie_trim_content( 50 );
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'medium_large' ) : '';

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
// about section content details.
add_filter( 'archie_filter_about_section_details', 'archie_get_about_section_details' );


if ( ! function_exists( 'archie_render_about_section' ) ) :
  /**
   * Start about section
   *
   * @return string about content
   * @since Archie 1.0.0
   *
   */
   function archie_render_about_section( $content_details = array() ) {
        $options = archie_get_theme_options();
        $readmore = ! empty( $options['about_btn_title'] ) ? $options['about_btn_title'] : esc_html__( 'Read More', 'archie' );

        if ( empty( $content_details ) ) {
            return;
        } 

        foreach ( $content_details as $content ) : ?>
             <div id="about-us" class="relative page-section no-padding-bottom">
                <div class="wrapper">
                    <article class="<?php echo ! empty( $content['image'] ) ? 'has-featured-image' : 'no-featured-image'; ?>">
                        <?php if ( ! empty( $content['image'] ) ) : ?>
                            <div class="featured-image" style="background-image: url('<?php echo esc_url( $content['image'] ); ?>');">  
                            </div><!-- .featured-image -->
                        <?php endif; ?>

                        <div class="entry-container">
                            <?php if ( ! empty( $content['title'] ) ) : ?>
                                <div class="section-header">
                                    <h2 class="section-title"><?php echo esc_html( $content['title'] ); ?></h2>
                                </div>
                            <?php endif; 

                            if ( ! empty( $content['excerpt'] ) ) : ?>
                                <div class="entry-content">
                                    <p><?php echo esc_html( $content['excerpt'] ); ?></p>
                                </div><!-- .entry-content -->
                            <?php endif; 

                            if ( ! empty( $content['url'] ) ) : ?>
                                <div class="read-more">
                                    <a href="<?php echo esc_url( $content['url'] ); ?>" class="btn btn-primary white"><?php echo esc_html( $readmore ); ?></a>
                                </div><!-- .read-more -->
                            <?php endif; ?>
                        </div><!-- .entry-container -->
                    </article>
                </div><!-- .wrapper -->
            </div><!-- #about-us -->
        <?php endforeach;
    }
endif;