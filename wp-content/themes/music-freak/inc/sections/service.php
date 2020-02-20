<?php
/**
 * Service section
 *
 * This is the template for the content of service section
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */
if ( ! function_exists( 'music_freak_add_service_section' ) ) :
    /**
    * Add service section
    *
    *@since Music Freak 1.0.0
    */
    function music_freak_add_service_section() {
    	$options = music_freak_get_theme_options();
        // Check if service is enabled on frontpage
        $service_enable = apply_filters( 'music_freak_section_status', true, 'service_section_enable' );

        if ( true !== $service_enable ) {
            return false;
        }
        // Get service section details
        $section_details = array();
        $section_details = apply_filters( 'music_freak_filter_service_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render service section now.
        music_freak_render_service_section( $section_details );
    }
endif;

if ( ! function_exists( 'music_freak_get_service_section_details' ) ) :
    /**
    * service section details.
    *
    * @since Music Freak 1.0.0
    * @param array $input service section details.
    */
    function music_freak_get_service_section_details( $input ) {
        $options = music_freak_get_theme_options();

        $content = array();
        $page_ids = array();

        for ( $i = 1; $i <= 4; $i++ ) {
            if ( ! empty( $options['service_content_page_' . $i] ) ) :
                $page_ids[] = $options['service_content_page_' . $i];
                $icons[] = ! empty( $options['service_content_icon_' . $i] ) ? esc_attr( $options['service_content_icon_' . $i] ) : 'fa-cogs';
            endif;
        }
        
        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => 4,
            'orderby'           => 'post__in',
            );                    


        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
        $i = 0;
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = music_freak_trim_content( 15 );
                $page_post['icon']      = ! empty( $icons[$i] ) ? $icons[$i] : 'fa-cogs';

                // Push to the main array.
                array_push( $content, $page_post );
                $i++;
            endwhile;
        endif;
        wp_reset_postdata();

            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// service section content details.
add_filter( 'music_freak_filter_service_section_details', 'music_freak_get_service_section_details' );


if ( ! function_exists( 'music_freak_render_service_section' ) ) :
  /**
   * Start service section
   *
   * @return string service content
   * @since Music Freak 1.0.0
   *
   */
   function music_freak_render_service_section( $content_details = array() ) {
        $options = music_freak_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="featured-services" class="relative page-section">
            <div class="wrapper">
                <div class="section-header clear">
                    <?php if ( ! empty( $options['service_title'] ) ) : ?>
                        <h2 class="section-title"><?php echo esc_html( $options['service_title'] ); ?></h2>
                    <?php endif; ?>
                </div><!-- .section-header -->

                <!-- supports col-1, col-2, col-3 and col-4 -->
                <div class="section-content col-4">
                    <div class="featured-services-wrapper clear">
                        <?php foreach ( $content_details as $content ) : ?>
                            <article>
                                <div class="icon">
                                    <a href="<?php echo esc_url( $content['url'] ); ?>">
                                        <i class="fa <?php echo esc_attr( $content['icon'] ); ?>"></i>
                                    </a>
                                </div><!-- .icon -->

                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                </header>

                                <div class="entry-content">
                                    <p><?php echo esc_html( $content['excerpt'] ); ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div><!-- .featured-services-wrapper -->
                </div><!-- .section-content -->

            </div><!-- .wrapper -->
        </div><!-- #featured-services -->

    <?php }
endif;
