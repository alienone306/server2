<?php
if (!defined('ABSPATH')) {
    exit;
}


class PWPT_Admin_Demo_Config {

    private $theme = '';
    private $import_class = '';

    public function __construct() {

        $this->theme = wp_get_theme();
        add_filter('et-demo-content-import', array($this, 'import_files'));
        add_action('et-after-demo-content-import', array($this, 'after_import'));
    }

    private function get_import_class() {

        $supported_themes = $this->supported_themes();
        $demo_class = '';
        foreach ($supported_themes as $theme) {

            $theme_name = isset($theme['theme_name']) ? $theme['theme_name'] : '';
            
            if (trim($theme_name) === trim($this->theme)) {

                $demo_class = isset($theme['demo_class']) ? $theme['demo_class'] : '';
                break;
            }
        }

        return $demo_class;
    }

    private function supported_themes() {

        return array(

            'glaze_blog' => array(
                'theme_name' => 'Glaze Blog',
                'demo_class' => 'PWPT_Theme_Demo_Glaze_Blog',
            ),
            'glaze_blog_lite' => array(
                'theme_name' => 'Glaze Blog Lite',
                'demo_class' => 'PWPT_Theme_Demo_Glaze_Blog_Lite',
            ),
            'masonry_blog' => array(
                'theme_name' => 'Masonry Blog',
                'demo_class' => 'PWPT_Theme_Demo_Masonry_Blog',
            ),
        );
    }


    public function import_files() {

        $import_class = $this->get_import_class();

        if (empty($import_class)) {

            return array();
        }

        return $import_class::import_files();
    }

    public function after_import( $selected_import ) {

        $import_class = $this->get_import_class();

        if (empty($import_class)) {

            return '';
        }

        $import_class::after_import($selected_import);
    }
}

new PWPT_Admin_Demo_Config();
