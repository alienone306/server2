<?php
/**
 * Music Video section
 *
 * This is the template for the content of music_video section
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */
if ( ! function_exists( 'music_freak_add_music_video_section' ) ) :
    /**
    * Add music_video section
    *
    *@since Music Freak 1.0.0
    */
    function music_freak_add_music_video_section() {
    	$options = music_freak_get_theme_options();
        // Check if music_video is enabled on frontpage
        $music_video_enable = apply_filters( 'music_freak_section_status', true, 'music_video_section_enable' );

        if ( true !== $music_video_enable ) {
            return false;
        }

        // Render music_video section now.
        music_freak_render_music_video_section();
    }
endif;

if ( ! function_exists( 'music_freak_render_music_video_section' ) ) :
    /**
    * Start music_video section
    *
    * @return string music_video content
    * @since Music Freak 1.0.0
    *
    */
    function music_freak_render_music_video_section() {
        $options = music_freak_get_theme_options();
        $playlist = ! empty( $options['music_video_content'] ) ? $options['music_video_content'] : array();
        $video = ! empty( $options['music_video_list'] ) ? $options['music_video_list'] : '';

        $playlist = implode(',', $playlist);
        ?>

        <div id="recently-played" class="relative page-section">
            <div class="wrapper">
                <div class="col-2 clear">
                    <?php if ( ! empty( $playlist ) ) : ?>
                        <div class="hentry music-playlist">
                            <div class="section-header">
                                <?php if ( ! empty( $options['music_video_title'] ) ) : ?>
                                    <h2 class="section-title"><?php echo esc_html( $options['music_video_title'] ); ?></h2>
                                <?php endif; 

                                if ( ! empty( $options['music_video_btn_title'] ) && ! empty( $options['music_video_btn_url'] ) ) : ?>
                                    <a href="<?php echo esc_url( $options['music_video_btn_url'] ) ?>" class="more-link"><?php echo esc_html( $options['music_video_btn_title'] ); ?></a>
                                <?php endif; ?>
                            </div><!-- .section-header -->

                            <div class="playlist-wrapper">
                                <?php 
                                    $playlist_shortcode = '[playlist type="audio" ids="' . $playlist . '" style="light"]';
                                    echo do_shortcode( wp_kses_post( $playlist_shortcode ) );  
                                ?>
                            </div><!-- .playlist-wrapper -->

                            <?php if ( ! empty( $options['music_video_btn_title'] ) && ! empty( $options['music_video_btn_url'] ) ) : ?>
                                <div class="read-more">
                                    <a href="<?php echo esc_url( $options['music_video_btn_url'] ) ?>" class="more-link"><?php echo esc_html( $options['music_video_btn_title'] ); ?></a>
                                </div><!-- .read-more -->
                            <?php endif; ?>

                        </div><!-- .hentry -->
                    <?php endif; 

                    if ( ! empty( $video ) ) : ?>
                        <div class="hentry video-playlist">
                            <div class="section-header">
                                <?php if ( ! empty( $options['music_video_list_title'] ) ) : ?>
                                    <h2 class="section-title"><?php echo esc_html( $options['music_video_list_title'] ); ?></h2>
                                <?php endif; 

                                if ( ! empty( $options['music_video_list_btn_title'] ) && ! empty( $options['music_video_list_btn_url'] ) ) : ?>
                                    <a href="<?php echo esc_url( $options['music_video_list_btn_url'] ) ?>" class="more-link"><?php echo esc_html( $options['music_video_list_btn_title'] ); ?></a>
                                <?php endif; ?>
                            </div><!-- .section-header -->

                            <div class="video-slider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": false, "speed": 1000, "dots": false, "arrows":true, "autoplay": true, "draggable": true, "fade": false }'>
                                <article>
                                    <div class="video-wrapper">
                                        <?php echo do_shortcode( '[video src="' . esc_url( $video ) . '"]' ); ?>
                                    </div><!-- .video-wrapper -->
                                </article>
                            </div><!-- .video-slider -->

                            <?php if ( ! empty( $options['music_video_list_btn_title'] ) && ! empty( $options['music_video_list_btn_url'] ) ) : ?>
                                    <div class="read-more">
                                        <a href="<?php echo esc_url( $options['music_video_list_btn_url'] ) ?>" class="more-link"><?php echo esc_html( $options['music_video_list_btn_title'] ); ?></a>
                                    </div><!-- .read-more -->
                                <?php endif; ?>
                        </div><!-- .hentry -->
                    <?php endif; ?>
                </div><!-- .col-2 -->
            </div><!-- .wrapper -->
        </div><!-- #recently-played -->

    <?php }
endif;