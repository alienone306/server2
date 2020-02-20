<?php
/**
 * Call to action section
 *
 * This is the template for the content of cta section
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */
if ( ! function_exists( 'music_freak_add_cta_section' ) ) :
    /**
    * Add cta section
    *
    *@since Music Freak 1.0.0
    */
    function music_freak_add_cta_section() {
    	$options = music_freak_get_theme_options();
        // Check if cta is enabled on frontpage
        $cta_enable = apply_filters( 'music_freak_section_status', true, 'cta_section_enable' );

        if ( true !== $cta_enable ) {
            return false;
        }
        // Get cta section details
        $section_details = array();
        $section_details = apply_filters( 'music_freak_filter_cta_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render cta section now.
        music_freak_render_cta_section( $section_details );
    }
endif;

if ( ! function_exists( 'music_freak_get_cta_section_details' ) ) :
    /**
    * cta section details.
    *
    * @since Music Freak 1.0.0
    * @param array $input cta section details.
    */
    function music_freak_get_cta_section_details( $input ) {
        $options = music_freak_get_theme_options();

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
add_filter( 'music_freak_filter_cta_section_details', 'music_freak_get_cta_section_details' );


if ( ! function_exists( 'music_freak_render_cta_section' ) ) :
  /**
   * Start cta section
   *
   * @return string cta content
   * @since Music Freak 1.0.0
   *
   */
   function music_freak_render_cta_section( $content_details = array() ) {
        $options = music_freak_get_theme_options();
        $readmore = ! empty( $options['cta_btn_title'] ) ? $options['cta_btn_title'] : esc_html__( 'Read More', 'music-freak' );

        if ( empty( $content_details ) ) {
            return;
        } 

        foreach ( $content_details as $content ) : ?>

            <div id="call-to-action" class="relative page-section">
                <div class="wrapper">
                    <div class="section-header">
                        <h2 class="section-title"><?php echo esc_html( $content['title'] ); ?></h2>
                    </div><!-- .section-header -->
                    
                    <div class="read-more">
                        <a href="<?php echo esc_url( $content['url'] ); ?>" class="btn">   <?php echo esc_html( $readmore ); ?>
                        </a>
                    </div><!-- .read-more -->
                </div><!-- .wrapper -->
            </div><!-- #call-to-action -->

        <?php endforeach; 
    }
endif;
