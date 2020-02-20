<?php
/**
 * Instagram Widget Class
 *
 * @package Perfectwpthemes_Toolkit
 */

if( ! class_exists( 'Perfectwpthemes_toolkit_Instagram_Widget' ) ) :

    class Perfectwpthemes_toolkit_Instagram_Widget extends WP_Widget {
     
        function __construct() {   

            $theme_text_domain = perfectwpthemes_toolkit_theme_text_domain();
            $widget_id = $theme_text_domain . '-instagram-widget';

            parent::__construct(
                $widget_id,  // Widget ID
                esc_html__( 'GBL: Instagram Widget', 'perfectwpthemes-toolkit' ),   // Widget Name
                array(
                    'description' => esc_html__( 'Displays Instagram Images.', 'perfectwpthemes-toolkit' ), 
                )
            );
     
        }
     
        public function widget( $args, $instance ) {

            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
     
            $access_token = ! empty( $instance['access_token'] ) ? $instance['access_token'] : false;

            $image_no = ! empty( $instance['image_no'] ) ? absint( $instance['image_no'] ) : 8;

            $link_title = ! empty( $instance['link_title'] ) ? $instance['link_title'] : '';

            $link_url = ! empty( $instance['link_url'] ) ? $instance['link_url'] : '';

            $insta_feeds = $this->instagram_feeds( $access_token, $image_no );

            $image_count        = 0;

            if( !empty( $insta_feeds ) ) {
                $image_count = count( $insta_feeds['images'] );
            }

            if( !empty( $insta_feeds ) ) :

                if( $args['id'] == 'glaze-blog-footer' ) :
                    ?>
                    <div class="col-lg-4 col-md-12">
                    <?php
                endif;
                ?>
                <div class="widget gb-instagram-widget">
                    <?php
                    if( !empty( $title ) ) :
                        ?>
                        <div class="widget_title">
                            <h3><?php echo esc_html( $title ); ?></h3>
                        </div><!-- .widget_title -->
                        <?php
                    endif;
                    ?>
                    <div class="widget-container">
                        <div class="feeds-inner">
                            <ul>
                                <?php
                                for( $i = 0; $i < $image_count; $i++ ) {
                                    if( $insta_feeds[ 'images' ][ $i ] ) {
                                        ?>
                                        <li>
                                            <a class="imghover" href="<?php echo esc_url( $insta_feeds['images'][ $i ][1] ); ?>">
                                                <img src="<?php echo esc_url( $insta_feeds['images'][ $i ][0] ); ?>">
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                        if( !empty( $link_title ) && !empty( $link_url ) ) :
                            ?>
                            <div class="follow-permalink">
                                <a href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $link_title ); ?></a>
                            </div><!-- .follow-permalink -->
                            <?php
                        endif;
                        ?>
                    </div><!-- .widget-container -->
                </div><!-- .widget.gb-instagram-widget -->
                <?php
                if( $args['id'] == 'glaze-blog-footer' ) :
                    ?>
                    </div><!-- .col -->
                    <?php
                endif;
            endif; 
        }
     
        public function form( $instance ) {
     
            // Defaults.
            $defaults = array(
                'title' => '',
                'access_token' => '',
                'image_no' => 6,
                'link_title' => '',
                'link_url' => '',
            );

            $instance = wp_parse_args( (array) $instance, $defaults );
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_name('title') ); ?>">
                    <?php esc_html_e('Title', 'perfectwpthemes-toolkit'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            </p>
                
            <p>
                <label for="<?php echo esc_attr( $this->get_field_name('access_token') ); ?>">
                    <?php esc_html_e('Access Token', 'perfectwpthemes-toolkit'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('access_token') ); ?>" name="<?php echo esc_attr( $this->get_field_name('access_token') ); ?>" type="text" value="<?php echo esc_attr( $instance['access_token'] ); ?>" />
                <small>
                    <?php esc_html_e('If you do not have a token. Follow the link, ', 'perfectwpthemes-toolkit'); ?>  
                     <a href="<?php echo esc_url('http://instagram.pixelunion.net/'); ?>" target="_blank"><?php esc_html_e('Generate Token', 'perfectwpthemes-toolkit'); ?></a>  
                </small>
            </p>        

            <p>
                <label for="<?php echo esc_attr( $this->get_field_name('image_no') ); ?>">
                    <?php esc_html_e('Number of Image', 'perfectwpthemes-toolkit'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('image_no') ); ?>" name="<?php echo esc_attr( $this->get_field_name('image_no') ); ?>" type="number" value="<?php echo absint( $instance['image_no'] ); ?>" />   
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_name('link_title') ); ?>">
                    <?php esc_html_e('Instagram Profile Link Title', 'perfectwpthemes-toolkit'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('link_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('link_title') ); ?>" type="text" value="<?php echo esc_attr( $instance['link_title'] ); ?>" />   
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_name('link_url') ); ?>">
                    <?php esc_html_e('Instagram Profile Link URL', 'perfectwpthemes-toolkit'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('link_url') ); ?>" name="<?php echo esc_attr( $this->get_field_name('link_url') ); ?>" type="url" value="<?php echo esc_url( $instance['link_url'] ); ?>" />   
            </p>
            <?php
     
        }
     
        public function update( $new_instance, $old_instance ) {
     
            $instance = $old_instance;

            $instance['title']   = sanitize_text_field( $new_instance['title'] );

            $instance['access_token']   = sanitize_text_field( $new_instance['access_token'] );

            $instance['image_no']       = absint( $new_instance['image_no'] );

            $instance['link_title']     = sanitize_text_field( $new_instance['link_title'] );

            $instance['link_url']       = esc_url_raw( $new_instance['link_url'] );

            return $instance;
        }

        public function instagram_feeds( $token, $image_no ) {    

            $count = $image_no;

            $url              = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=' . trim( $token ). '&count=' . trim( $count );

            $feeds_json         = wp_remote_fopen( $url );

            $feeds_obj          = json_decode( $feeds_json, true ); 

            if( !empty( $feeds_obj['error_type'] ) ) {
                return;
            }

            $feeds_images = array();


            if ( 200 == $feeds_obj['meta']['code'] ) {

                if ( ! empty( $feeds_obj['data'] ) ) {

                    foreach ( $feeds_obj['data'] as $data ) {
                        array_push( $feeds_images, array( $data['images']['standard_resolution']['url'], $data['link'] ) );
                    }

                    $ending_array = array(
                        'link'   => $feeds_obj['data'][0]['user']['username'],
                        'images' => $feeds_images,
                    );

                    return $ending_array;
                }
            }
        }
     
    }
endif;