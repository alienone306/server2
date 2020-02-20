<?php
/*
  Copyright (c) 2012-2020, SEO Squirrly.
  The copyrights to the software code in this file are licensed under the (revised) BSD open source license.

  Plugin Name: Squirrly SEO 2019 (Strategy)
  Plugin URI: https://www.squirrly.co
  Description: SEO By Squirrly is for the NON-SEO experts. Get Excellent Seo with Better Content, Ranking and Analytics. For Both Humans and Search Bots.<BR> <a href="http://my.squirrly.co/user" target="_blank"><strong>Check your profile</strong></a>
  Author: Squirrly SEO
  Version: 9.2.18
  Author URI: https://www.squirrly.co
 */
if (!defined('SQ_VERSION')) {
    /* SET THE CURRENT VERSION ABOVE AND BELOW */
    define('SQ_VERSION', '9.2.18');
    //The last stable version
    define('SQ_STABLE_VERSION', '9.2.17');
    // Call config files
    try {
        require_once(dirname(__FILE__) . '/config/config.php');
        require_once(dirname(__FILE__) . '/debug/index.php');

        /* important to check the PHP version */
        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
            // inport main classes
            require_once(_SQ_CLASSES_DIR_ . 'ObjController.php');

            // Load helpers
            SQ_Classes_ObjController::getClass('SQ_Classes_Helpers_Tools');
            SQ_Classes_ObjController::getClass('SQ_Classes_Helpers_Sanitize');
            // Load the Front and Block controller
            SQ_Classes_ObjController::getClass('SQ_Classes_FrontController');
            SQ_Classes_ObjController::getClass('SQ_Classes_BlockController');

            if (SQ_Classes_Helpers_Tools::isBackedAdmin()) {
                SQ_Classes_ObjController::getClass('SQ_Classes_FrontController')->runAdmin();
                // Upgrade Squirrly call.
                register_activation_hook(__FILE__, array(SQ_Classes_ObjController::getClass('SQ_Classes_Helpers_Tools'), 'sq_activate'));
                register_deactivation_hook(__FILE__, array(SQ_Classes_ObjController::getClass('SQ_Classes_Helpers_Tools'), 'sq_deactivate'));

                //RUN THE HOURLY CRONS
                if (!SQ_Classes_Helpers_Tools::getOption('sq_force_savepost')) {
                    //Send the posts to API
                    add_action('sq_cron_process', array(SQ_Classes_ObjController::getClass('SQ_Controllers_Cron'), 'processSEOPostCron'));
                }
                //Check the SEO issues in frontend
                add_action('sq_cron_process', array(SQ_Classes_ObjController::getClass('SQ_Controllers_Cron'), 'processSEOCheckCron'));
                ///////////////////////
                ///
            } else {
                SQ_Classes_ObjController::getClass('SQ_Classes_FrontController')->runFrontend();
            }
        }

    } catch (Exception $e) {
    }
}
