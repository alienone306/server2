<?php
/**
 * Call to action section
 *
 * This is the template for the content of cta section
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */
if ( ! function_exists( 'archie_add_cta_section' ) ) :
    /**
    * Add cta section
    *
    *@since Archie 1.0.0
    */
    function archie_add_cta_section() {
    	$options = archie_get_theme_options();
        // Check if cta is enabled on frontpage
        $cta_enable = apply_filters( 'archie_section_status', true, 'cta_section_enable' );

        if ( true !== $cta_enable ) {
            return false;
        }
        // Get cta section details
        $section_details = array();
        $section_details = apply_filters( 'archie_filter_cta_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render cta section now.
        archie_render_cta_section( $section_details );
    }
endif;

if ( ! function_exists( 'archie_get_cta_section_details' ) ) :
    /**
    * cta section details.
    *
    * @since Archie 1.0.0
    * @param array $input cta section details.
    */
    function archie_get_cta_section_details( $input ) {
        $options = archie_get_theme_options();
        
        $content = array();
        $page_id = ! empty( $options['cta_content_page'] ) ? $options['cta_content_page'] : '';
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
// cta section content details.
add_filter( 'archie_filter_cta_section_details', 'archie_get_cta_section_details' );


if ( ! function_exists( 'archie_render_cta_section' ) ) :
  /**
   * Start cta section
   *
   * @return string cta content
   * @since Archie 1.0.0
   *
   */
   function archie_render_cta_section( $content_details = array() ) {
        $options = archie_get_theme_options();
        $readmore = ! empty( $options['cta_btn_title'] ) ? $options['cta_btn_title'] : esc_html__( 'Know More', 'archie' );

        if ( empty( $content_details ) ) {
            return;
        } 

        foreach ( $content_details as $content ) : ?>
            <div id="call-to-action" class="page-section align-center">
                <div class="wrapper">
                    <?php if ( ! empty( $content['title'] ) ) : ?>
                        <div class="section-content">
                           <?php printf( '"%s"', esc_html( $content['title'] ) ); ?>
                        </div><!-- .section-content -->
                    <?php endif; 

                    if ( ! empty( $content['url'] ) ) : ?>
                        <div class="read-more">
                            <a href="<?php echo esc_url( $content['url'] ) ?>" class="btn btn-deafult" tabindex="-1"><?php echo esc_html( $readmore ); ?></a>
                        </div><!-- .read-more -->
                    <?php endif; ?>
                </div><!-- .wrapper -->
            </div><!-- #call-to-action -->
        <?php endforeach;
    }
endif;