<?php

class SQ_Models_Compatibility {

    /**
     * Prevent other plugins javascript
     */
    public function fixEnqueueErrors() {
        global $wp_styles, $wp_scripts;
        $corelib = array('admin-bar', 'colors', 'ie', 'common', 'utils', 'wp-auth-check','dismissible-notices',
            'media-editor', 'media-audiovideo', 'media-views', 'imgareaselect', 'mce-view', 'image-edit',
            'wp-color-picker','migrate_style','jquery-ui-draggable','jquery-ui-core',
            'wordfence-global-style','ip2location_country_blocker_admin_menu_styles','wf-adminbar','autoptimize-toolbar',
            'yoast-seo-adminbar','bbp-admin-css','bp-admin-common-css','bp-admin-bar','elementor-common','ithemes-icon-font',
            'wordfence-ls-admin-global','woocommerce_admin_menu_styles','besclwp_cpt_admin_style','uabb-notice-settings',
            'besclwp_cpt_admin_script','itsec-core-admin-notices','sandbox-website'
        );

        foreach ($wp_styles->queue as $key => $queue) {
            if (!in_array($queue, $corelib)) {
                unset($wp_styles->queue[$key]);
            }
        }

        foreach ($wp_scripts->queue as $key => $queue) {
            if (!in_array($queue, $corelib)) {
                unset($wp_scripts->queue[$key]);
            }
        }
    }

    /**
     * Clear the styles from other plugins
     */
    public function clearStyles() {
        //clear the other plugins styles
        global $wp_styles;
        $wp_styles->queue = array();
    }
}
