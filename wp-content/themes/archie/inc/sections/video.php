<?php
/**
 * Video section
 *
 * This is the template for the content of video section
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */
if ( ! function_exists( 'archie_add_video_section' ) ) :
    /**
    * Add video section
    *
    *@since Archie 1.0.0
    */
    function archie_add_video_section() {
    	$options = archie_get_theme_options();
        // Check if video is enabled on frontpage
        $video_enable = apply_filters( 'archie_section_status', true, 'video_section_enable' );

        if ( true !== $video_enable ) {
            return false;
        }

        // Render video section now.
        archie_render_video_section();
    }
endif;

if ( ! function_exists( 'archie_render_video_section' ) ) :
  /**
   * Start video section
   *
   * @return string video content
   * @since Archie 1.0.0
   *
   */
   function archie_render_video_section() {
        $options = archie_get_theme_options();
        $image = ! empty( $options['video_image'] ) ? $options['video_image'] : '';
        $featured_video = ! empty( $options['video_section_url'] ) ? $options['video_section_url'] : '';
        ?>

            <div id="latest-video" class="relative page-section video-enabled" style="background-image: url('<?php echo esc_url( $image ); ?>');">
                <!-- use video-disabled class when video is not uploaded -->
                <div class="overlay"></div>

                <div class="wrapper">                
                    <div class="video-content-wrapper">
                        <?php if ( ! empty( $options['video_title'] ) ) : ?>
                            <div class="section-header">
                                <?php if ( ! empty( $options['video_title'] ) ) : ?>
                                    <h2 class="section-title"><?php echo esc_html( $options['video_title'] ); ?></h2>
                                <?php endif; ?>
                            </div><!-- .section-header -->
                        <?php endif; 

                        if ( ! empty( $featured_video ) ) : ?>
                            <div class="icon-play">
                                <a class="popup-video" href="#"><i class="fa fa-play"></i></a>
                            </div><!-- .icon-play -->
                        <?php endif; ?>
                    </div><!-- .video-content-wrapper -->

                    <?php if ( ! empty( $featured_video ) ) : ?>
                        <div id="video-popup">
                            <?php the_widget( 'WP_Widget_Media_Video', $instance = array( 'url' => esc_url( $featured_video ) ) ); ?>
                        </div>
                    <?php endif; ?>
                </div><!-- .wrapper -->
            </div><!-- #latest-video -->

    <?php
    }
endif;