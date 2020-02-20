<?php

if ( ! function_exists( 'perfectwpthemes_toolkit_get_default_theme_options' ) ) {

    /**
     * Get default theme options.
     *
     * @since 1.0.0
     *
     * @return array Default theme options.
     */
    function perfectwpthemes_toolkit_get_default_theme_options() {

        $defaults = array(
            
            'display_social_share_global' => true,
            'display_blog_social_share' => true,
            'display_archive_social_share' => true,
            'display_search_social_share' => true,
            'display_post_single_social_share' => true,
            'display_page_single_social_share' => true,
            'share_on_facebook' => true,
            'share_on_twitter' => true,
            'share_on_pinterest' => true,
            'share_on_linkedin' => true,
            'share_on_reddit' => true,
            'share_on_tumblr' => true,
            'share_on_digg' => true,
            'share_on_vk' => true,
        );

        return $defaults;
    }
}