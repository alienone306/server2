<?php

class SQ_Controllers_Cron extends SQ_Classes_FrontController {

    public function processSEOPostCron() {
        //make sure the classes are loaded
        SQ_Classes_ObjController::getClass('SQ_Classes_Helpers_Tools');
        SQ_Classes_ObjController::getClass('SQ_Classes_ActionController');
        SQ_Classes_ObjController::getClass('SQ_Classes_RemoteController');

        if (get_option('sq_seopost')) {
            $process = json_decode(get_option('sq_seopost'), true);

            if (!empty($process)) {
                foreach ($process as $key => $args) {

                    if (!$response = SQ_Classes_RemoteController::savePost($args)) {
                        break;
                    }

                    if (isset($response->saved) && $response->saved == true) {
                        unset($process[$key]);
                    }
                }

                update_option('sq_seopost', json_encode($process));
            }
        }
    }

    public function processSEOCheckCron() {
        //make sure the classes are loaded
        SQ_Classes_ObjController::getClass('SQ_Classes_Helpers_Tools');

        //Check the SEO and save the Report
        $report_time = get_option('sq_seoreport_time');
        if (isset($report_time['timestamp'])) {
            if ((time() - $report_time['timestamp']) < (3600 * 12)) {
                return false;
            }
        }

        SQ_Classes_ObjController::getClass('SQ_Models_CheckSeo')->checkSEO();
    }


}
