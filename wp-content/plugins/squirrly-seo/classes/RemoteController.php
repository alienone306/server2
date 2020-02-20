<?php

class SQ_Classes_RemoteController {

    public static $cache = array();
    public static $apiversion = 1;
    public static $apimethod = 'get';

    /**
     * Call the Squirrly Cloud Server
     * @param string $module
     * @param array $params
     * @param array $options
     * @return string
     */
    public static function apiCall($module, $params = array(), $options = array()) {
        $parameters = "";

        if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '' && $module <> 'login' && $module <> 'register') {
            return false;
        }

        //predefined args
        $args = array(
            'user_url' => get_bloginfo('url'),
            'lang' => get_bloginfo('language'),
            'token' => SQ_Classes_Helpers_Tools::getOption('sq_api'),
            'versq' => (int)str_replace('.', '', SQ_VERSION)
        );

        //predefined options
        $options = array_merge(
            array(
                'method' => self::$apimethod,
                'sslverify' => SQ_CHECK_SSL,
                'timeout' => 10,
                'headers' => array(
                    'USER-TOKEN' => SQ_Classes_Helpers_Tools::getOption('sq_api'),
                    'USER-URL' => get_bloginfo('url'),
                    'LANG' => get_bloginfo('language'),
                    'VERSQ' => (int)str_replace('.', '', SQ_VERSION)
                )
            ),
            $options);

        try {
            $args = array_merge($args, $params);

            foreach ($args as $key => $value) {
                if ($value <> '') {
                    $parameters .= ($parameters == "" ? "" : "&") . $key . "=" . urlencode($value);
                }
            }

            //call it with http to prevent curl issues with ssls
            $url = self::cleanUrl(((self::$apiversion == 1) ? _SQ_API_URL_ : _SQ_APIV2_URL_) . $module . "?" . $parameters);

            //echo $url .'<br/>';
            if (!isset(self::$cache[md5($url)])) {
                if ($options['method'] == 'post') {
                    $options['body'] = $args;
                }

                self::$cache[md5($url)] = self::sq_wpcall($url, $options);
            }

            return self::$cache[md5($url)];


        } catch (Exception $e) {
            return '';
        }

    }

    /**
     * Clear the url before the call
     * @param string $url
     * @return string
     */
    private static function cleanUrl($url) {
        return str_replace(array(' '), array('+'), $url);
    }

    public static function generatePassword($length = 12) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $password;
    }

    /**
     * Get My Squirrly Link
     *
     * @param $path
     * @return string
     */
    public static function getMySquirrlyLink($path) {
        if (SQ_Classes_Helpers_Tools::getMenuVisible('show_panel')) {
            return _SQ_DASH_URL_ . 'login/?token=' . SQ_Classes_Helpers_Tools::getOption('sq_api') . '&user_url=' . get_bloginfo('url') . '&redirect_to=' . _SQ_DASH_URL_ . 'user/' . $path;
        } else {
            return _SQ_DASH_URL_;
        }
    }

    /**
     * Get API Link
     *
     * @param string $path
     * @param integer $version
     * @return string
     */
    public static function getApiLink($path) {
        return _SQ_APIV2_URL_ . $path . '?token=' . SQ_Classes_Helpers_Tools::getOption('sq_api') . '&url=' . get_bloginfo('url');
    }

    /**
     * Use the WP remote call
     *
     * @param $url
     * @param $options
     * @return array|bool|string|WP_Error
     */
    public static function sq_wpcall($url, $options) {
        $method = $options['method'];

        switch ($method) {
            case 'get':
                unset($options['method']);
                $response = wp_remote_get($url, $options);
                break;
            case 'post':
                unset($options['method']);
                $response = wp_remote_post($url, $options);
                break;
            default:
                $response = wp_remote_request($url, $options);
                break;
        }

        if (is_wp_error($response)) {
            SQ_Classes_Error::setError($response->get_error_message(), 'sq_error');
            return false;
        }

        $response = self::cleanResponce(wp_remote_retrieve_body($response)); //clear and get the body

        SQ_Debug::dump('wp_remote_get', $method, $url, $options, $response); //output debug
        return $response;
    }

    /**
     * Get the Json from responce if any
     * @param string $response
     * @return string
     */
    private static function cleanResponce($response) {
        return trim($response, '()');
    }

    /**********************  API CALLs ******************************/
    /**
     * @param array $args
     * @return array|mixed|object|WP_Error
     */
    public static function connect($args = array()) {
        self::$apiversion = 1; //api v2
        self::$apimethod = 'get'; //call method
        $json = json_decode(self::apiCall('user/connect', $args));

        if (isset($json->error) && $json->error <> '') {
            if ($json->error == 'invalid_token') {
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', false);
            }
            if ($json->error == 'disconnected') {
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', false);
            }
            if ($json->error == 'banned') {
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', false);
            }
            return (new WP_Error('api_error', $json->error));
        }

        return $json;
    }

    /**
     * Login user to API
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function login($args = array()) {
        self::$apiversion = 1; //api v2
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('login', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        return $json;
    }

    /**
     * Register user to API
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function register($args = array()) {
        self::$apiversion = 1; //api v2
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('register', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        return $json;
    }

    /**
     * Checkin on API v2
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function checkin($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/user/checkin', $args));

        if (isset($json->error) && $json->error <> '') {
            self::connect(); //connect the website

            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            //Save the connections into database
            if (isset($json->data->connection_gsc) && isset($json->data->connection_ga)) {
                $connect = SQ_Classes_Helpers_Tools::getOption('connect');
                $connect['google_analytics'] = $json->data->connection_ga;
                $connect['google_search_console'] = $json->data->connection_gsc;
                SQ_Debug::dump($connect);
                SQ_Classes_Helpers_Tools::saveOptions('connect', $connect);
            }

            return $json->data;
        }

        return false;
    }

    /**
     * Get the API stats for this blog
     * @return array
     */
    public static function getStats() {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //call method

        $args = $stats = array();
        if ($json = json_decode(self::apiCall('api/user/stats', $args))) {

            if (isset($json->error) && $json->error <> '') {
                self::connect(); //connect the website

                return (new WP_Error('api_error', $json->error));
            }

            if (!isset($json->data)) {
                return (new WP_Error('api_error', 'no_data'));
            }

            $data = $json->data;

            if (isset($data->optimized_articles) && isset($data->average_optimization) && isset($data->kr_research) && isset($data->kr_in_briefcase)
                && isset($data->ranked_top) && isset($data->audits_made)) {

                //do not show stats if not optimization is made
                if ($data->optimized_articles == 0 && $data->kr_research == 0) {
                    return false;
                }

                //Get last month articles
                $stats['all_articles'] = array();
                $stats['all_articles']['value'] = ((int)$data->optimized_articles);
                $stats['all_articles']['text'] = __('Articles optimized so far', _SQ_PLUGIN_NAME_);
                $stats['all_articles']['link'] = SQ_Classes_Helpers_Tools::getAdminUrl('post-new.php');
                $stats['all_articles']['linktext'] = __('add post', _SQ_PLUGIN_NAME_);

                //Get last month articles
                $stats['avg_articles'] = array();
                $stats['avg_articles']['value'] = ((int)$data->average_optimization);
                $stats['avg_articles']['text'] = __('Average optimization', _SQ_PLUGIN_NAME_);
                $stats['avg_articles']['link'] = SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant');
                $stats['avg_articles']['linktext'] = __('add post', _SQ_PLUGIN_NAME_);

                //Get all keyword researched
                $stats['all_researches'] = array();
                $stats['all_researches']['value'] = (int)$data->kr_research;
                $stats['all_researches']['text'] = __('All Keyword Researches performed for all websites', _SQ_PLUGIN_NAME_);
                $stats['all_researches']['link'] = SQ_Classes_Helpers_Tools::getAdminUrl('sq_research');
                $stats['all_researches']['linktext'] = __('do research', _SQ_PLUGIN_NAME_);

                //Get all keywords from briefcase
                $stats['all_briefcase'] = array();
                $stats['all_briefcase']['value'] = (int)$data->kr_in_briefcase;
                $stats['all_briefcase']['text'] = __('Keywords stored in Squirrly Briefcase', _SQ_PLUGIN_NAME_);
                $stats['all_briefcase']['link'] = SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase');
                $stats['all_briefcase']['linktext'] = __('add keyword', _SQ_PLUGIN_NAME_);

                //Get the top 100 ranking
                $stats['top_ranking'] = array();
                $stats['top_ranking']['value'] = (int)$data->ranked_top;
                $stats['top_ranking']['text'] = __('Pages ranking in top 100 Google', _SQ_PLUGIN_NAME_);
                $stats['top_ranking']['link'] = SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings');
                $stats['top_ranking']['linktext'] = __('see rankings', _SQ_PLUGIN_NAME_);

                //Get last month audits
                $stats['lm_audit'] = array();
                $stats['lm_audit']['value'] = (int)$data->audits_made;
                $stats['lm_audit']['text'] = __('SEO Audits', _SQ_PLUGIN_NAME_);
                $stats['lm_audit']['link'] = SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits');
                $stats['lm_audit']['linktext'] = __('see audits', _SQ_PLUGIN_NAME_);
            }
        }

        return $stats;
    }


    /**
     * Get audits from API
     * @param array $args
     * @return array|bool
     */
    public static function getBlogAudits($args = array()) {
        self::$apiversion = 1; //api v1
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('audit/get-blog-audits', $args));

        if (isset($json->audits)) {
            return $json->audits;
        }

        return false;
    }

    /******************************** BRIEFCASE *********************/
    public static function getBriefcase($args = array()) {
        self::$apiversion = 2; //api v1
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/briefcase/get', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function addBriefcaseKeyword($args = array()) {
        self::$apiversion = 2; //api v1
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/add', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }


        return false;
    }

    public static function removeBriefcaseKeyword($args = array()) {
        self::$apiversion = 2; //api v1
        self::$apimethod = 'post'; //call method

        if ($json = json_decode(self::apiCall('api/briefcase/hide', $args))) {
            return $json;
        }

        return false;
    }

    public static function getBriefcaseStats($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/briefcase/stats', $args));

        if (isset($json->error) && $json->error <> '') {
            self::connect(); //connect the website

            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function saveBriefcaseKeywordLabel($args = array()) {
        self::$apiversion = 2; //api v1
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/label/keyword', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }

        return false;
    }


    public static function addBriefcaseLabel($args = array()) {
        self::$apiversion = 2; //api v1
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/label/add', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function saveBriefcaseLabel($args = array()) {
        self::$apiversion = 2; //api v1
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/label/save', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }

        return false;
    }

    public static function removeBriefcaseLabel($args = array()) {
        self::$apiversion = 2; //api v1
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/label/delete', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }

        return false;
    }

    /******************************** KEYWORD RESEARCH ****************/

    public static function getKROthers($args = array()) {
        self::$apiversion = 1; //api v1
        self::$apimethod = 'get'; //call method

        if ($json = json_decode(self::apiCall('kr/other', $args))) {

            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            }

            return $json;
        }

        return false;
    }

    /**
     * Get Keyword Research Suggestion
     *
     * @param array $args
     * @return array|bool|mixed|object|WP_Error
     */
    public static function getKRSuggestion($args = array()) {
        self::$apiversion = 1; //api v1
        self::$apimethod = 'get'; //call method

        if ($json = json_decode(self::apiCall('kr/suggestion', $args, array('timeout' => 300)))) {

            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            }

            return $json;
        }

        return false;
    }

    /**
     * Get Keyword Research History
     * @param array $args
     * @return array|bool|mixed|object|WP_Error
     */
    public static function getKRHistory($args = array()) {
        self::$apiversion = 1; //api v1
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('kr/history/json/1', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->json)) {
            return $json->json;
        }

        return false;
    }

    /**
     * Get the Kr Found by API
     * @param array $args
     * @return bool|WP_Error
     */
    public static function getKrFound($args = array()) {
        self::$apiversion = 1; //api v1
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('kr/found', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->json)) {
            return $json->json;
        }

        return false;
    }

    /**
     * Get KR Countries
     * @param array $args
     * @return bool|WP_Error
     */
    public static function getKrCountries($args = array()) {
        self::$apiversion = 1; //api v1
        self::$apimethod = 'get'; //call method

        $args['json'] = true;
        $json = json_decode(self::apiCall('kr/countries', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->json)) {
            return $json->json;
        }

        return false;
    }

    /******************** WP Posts ***************************/
    /**
     * Save the post status on API
     * @param array $args
     * @return bool
     */
    public static function savePost($args = array()) {
        self::$apiversion = 1; //api v1
        self::$apimethod = 'get'; //call method

        return json_decode(self::apiCall('seo/post', $args));

    }

    /**
     * Get the post optimization
     *
     * @param array $args
     * @return array|mixed|object
     */
    public static function getPostOptimization($args = array()) {
        self::$apiversion = 1; //api v1

        return json_decode(self::apiCall('seo/get-optimization', $args));
    }

    /**
     * Update the post status on API
     * @param array $args
     * @return bool
     */
    public static function updatePost($args = array()) {
        self::$apiversion = 1; //api v1
        self::$apimethod = 'get'; //call method

        return json_decode(self::apiCall('seo/update', $args));

    }

    /******************** RANKINGS ***************************/

    /**
     * Add a keyword in Rank Checker
     * @param array $args
     * @return bool|WP_Error
     */
    public static function addSerpKeyword($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/serp', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Delete a keyword from Rank Checker
     * @param array $args
     * @return bool|WP_Error
     */
    public static function deleteSerpKeyword($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'post'; //call method

        $json = json_decode(self::apiCall('api/briefcase/serp-delete', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }

        return false;
    }

    /**
     * Get the Ranks for this blog
     * @param array $args
     * @return bool|WP_Error
     */
    public static function getRanksStats($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/serp/stats', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }
        return false;
    }

    /**
     * Get the Ranks for this blog
     * @param array $args
     * @return bool|WP_Error
     */
    public static function getRanks($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/serp/get-ranks', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }
        return false;
    }

    /**
     * Refresh the rank for a page/post
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function checkPostRank($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/serp/refresh', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }

        return true;
    }

    /******************** FOCUS PAGES ***********************/

    /**
     * Get all focus pages and add them in the SQ_Models_Domain_FocusPage object
     * Add the audit data for each focus page
     * @param array $args
     * @return SQ_Models_Domain_FocusPage|WP_Error|false
     */
    public static function getFocusPages($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/posts/focus', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data)) {
            return $json->data;
        }
        return false;
    }

    /**
     * Get the focus page audit
     *
     * @param array $args
     * @return bool|WP_Error
     */
    public static function getFocusAudits($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //call method

        $json = json_decode(self::apiCall('api/audits/focus', $args));

        if (isset($json->error) && $json->error <> '') {
            return (new WP_Error('api_error', $json->error));
        }

        if (isset($json->data) && !empty($json->data)) {
            return $json->data;
        }
        return false;
    }

    /**
     * Get the audit for a specific page
     * @param array $args
     * @return array|bool|mixed|object|WP_Error
     */
    public static function getSeoAudit($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //call method

        if ($json_audit = json_decode(self::apiCall('api/audits/old', $args))) {

            if (isset($json_audit->error) && $json_audit->error <> '') {
                return (new WP_Error($json_audit->error));
            }

            if (isset($json_audit->data)) {
                return json_decode(json_encode($json_audit->data));
            }
        }

        return false;
    }

    /**
     * Add Focus Page
     * @param array $args
     * @return bool|WP_Error
     */
    public static function addFocusPage($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'post'; //post call

        if ($json = json_decode(self::apiCall('api/posts/set-focus', $args))) {

            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            }

            if (isset($json->data)) {
                return $json->data;
            }
        }
        return false;
    }

    public static function updateFocusPage($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'post'; //post call

        if ($json = json_decode(self::apiCall('api/posts/update-focus', $args))) {
            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            }

            if (isset($json->data)) {
                return $json->data;
            }
        }
        return false;
    }

    /**
     * Delete the Focus Page
     * @param array $args
     * @return bool|WP_Error
     */
    public static function deleteFocusPage($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'post'; //post call

        if (isset($args['user_post_id']) && $args['user_post_id'] > 0) {
            if ($json = json_decode(self::apiCall('api/posts/remove-focus/' . $args['user_post_id']))) {

                if (isset($json->error) && $json->error <> '') {
                    return (new WP_Error('api_error', $json->error));
                }

                if (isset($json->data)) {
                    return $json->data;
                }
            }
        }
        return false;
    }

    /**************************************** CONNECTIONS */
    /**
     * Disconnect Google Analytics account
     * @param array $args
     * @return bool|WP_Error
     */
    public static function revokeGaConnection($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //post call

        if ($json = json_decode(self::apiCall('api/ga/revoke'))) {
            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            }

            if (isset($json->data)) {
                return $json->data;
            }
        }

        return false;
    }


    /**
     * Disconnect Google Search Console account
     * @param array $args
     * @return bool|WP_Error
     */
    public static function revokeGscConnection($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //post call

        if ($json = json_decode(self::apiCall('api/gsc/revoke'))) {
            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            }

            if (isset($json->data)) {
                return $json->data;
            }
        }

        return false;
    }

    public static function syncGSC($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //post call


        if ($json = json_decode(self::apiCall('api/gsc/sync/kr', $args))) {

            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            }

            if (isset($json->data)) {
                return $json->data;
            }
        }

        return false;
    }


    /******************** OTHERS *****************************/
    public static function crawlURL($args = array()) {
        self::$apiversion = 2; //api v2
        self::$apimethod = 'get'; //post call


        if ($json = json_decode(self::apiCall('api/url/crawl', $args, array('timeout' => 60)))) {

            if (isset($json->error) && $json->error <> '') {
                return (new WP_Error('api_error', $json->error));
            }

            if (isset($json->data)) {
                return $json->data;
            }
        }

        return false;
    }

    public static function saveSettings($args) {
        self::$apiversion = 1; //api v1
        self::$apimethod = 'get'; //call method

        self::apiCall('user/settings', array('settings' => json_encode($args)));
    }

    /**
     * Load the JS for API
     */
    public static function loadJsVars() {
        global $post;
        $sq_postID = (isset($post->ID) ? $post->ID : 0);

        echo '<script>
                    var SQ_DEBUG = ' . (int)SQ_DEBUG . ';
                    (function($){
                        $.sq_config = {
                            sq_use: ' . (int)SQ_Classes_Helpers_Tools::getOption('sq_use') . ',
                            sq_version: "' . SQ_VERSION . '",
                            token: "' . SQ_Classes_Helpers_Tools::getOption('sq_api') . '",
                            sq_baseurl: "' . _SQ_STATIC_API_URL_ . '", 
                            sq_uri: "' . SQ_URI . '", 
                            sq_apiurl: "' . str_replace('/sq', '', _SQ_API_URL_) . '",
                            user_url: "' . get_bloginfo('url') . '",
                            language: "' . get_bloginfo('language') . '",
                            sq_keywordtag: ' . (int)SQ_Classes_Helpers_Tools::getOption('sq_keywordtag') . ',
                            sq_seoversion: "' . ((int)SQ_Classes_Helpers_Tools::getOption('sq_sla') + 1) . '",
                            keyword_information: ' . (int)SQ_Classes_Helpers_Tools::getOption('sq_keyword_information') . ',
                            frontend_css: "' . _SQ_ASSETS_URL_ . 'css/frontend' . (SQ_DEBUG ? '' : '.min') . '.css",
                            postID: "' . $sq_postID . '",
                            prevNonce: "' . wp_create_nonce('post_preview_' . $sq_postID) . '",
                            __infotext: ["' . __('Recent discussions:', _SQ_PLUGIN_NAME_) . '", "' . __('SEO Search Volume:', _SQ_PLUGIN_NAME_) . '", "' . __('Competition:', _SQ_PLUGIN_NAME_) . '", "' . __('Trend:', _SQ_PLUGIN_NAME_) . '"],
                            __keyword: "' . __('Keyword:', _SQ_PLUGIN_NAME_) . '",
                            __date: "' . __('date', _SQ_PLUGIN_NAME_) . '",
                            __saved: "' . __('Saved!', _SQ_PLUGIN_NAME_) . '",
                            __readit: "' . __('Read it!', _SQ_PLUGIN_NAME_) . '",
                            __insertit: "' . __('Insert it!', _SQ_PLUGIN_NAME_) . '",
                            __reference: "' . __('Reference', _SQ_PLUGIN_NAME_) . '",
                            __insertasbox: "' . __('Insert as box', _SQ_PLUGIN_NAME_) . '",
                            __addlink: "' . __('Insert Link', _SQ_PLUGIN_NAME_) . '",
                            __notrelevant: "' . __('Not relevant?', _SQ_PLUGIN_NAME_) . '",
                            __insertparagraph: "' . __('Insert in your article', _SQ_PLUGIN_NAME_) . '",
                            __ajaxerror: "' . __(':( An error occurred while processing your request. Please try again', _SQ_PLUGIN_NAME_) . '",
                            __krerror: "' . __('Keyword Research takes too long to get the results. Click to try again', _SQ_PLUGIN_NAME_) . '",
                            __nofound: "' . __('No results found!', _SQ_PLUGIN_NAME_) . '",
                            __morewords: "' . __('Enter one more word to find relevant results', _SQ_PLUGIN_NAME_) . '",
                            __toolong: "' . __("It's taking too long to check this keyword", _SQ_PLUGIN_NAME_) . '",
                            __doresearch: "' . __('Do a research!', _SQ_PLUGIN_NAME_) . '",
                            __morekeywords: "' . __('Do more research!', _SQ_PLUGIN_NAME_) . '",
                            __sq_photo_copyright: "' . __('[ ATTRIBUTE: Please check: %s to find out how to attribute this image ]', _SQ_PLUGIN_NAME_) . '",
                            __has_attributes: "' . __('Has creative commons attributes', _SQ_PLUGIN_NAME_) . '",
                            __no_attributes: "' . __('No known copyright restrictions', _SQ_PLUGIN_NAME_) . '",
                            __noopt: "' . __('You haven`t used Squirrly SEO to optimize your article. Do you want to optimize for a keyword before publishing?', _SQ_PLUGIN_NAME_) . '",
                            __limit_exceeded: "' . __('Keyword Research limit exceeded', _SQ_PLUGIN_NAME_) . '",
                            __subscription_expired: "' . __('Your Subscription has Expired', _SQ_PLUGIN_NAME_) . '",
                            __add_keywords: "' . __('Add 20 Keyword Researches', _SQ_PLUGIN_NAME_) . '",
                            __no_briefcase: "' . __('There are no keywords saved in briefcase yet', _SQ_PLUGIN_NAME_) . '",
                            __fulloptimized: "' . __('Congratulations! Your article is 100% optimized!', _SQ_PLUGIN_NAME_) . '",
                            __toomanytimes: "' . __('appears too many times. Try to remove %s of them', _SQ_PLUGIN_NAME_) . '",
                            __writemorewords: "' . __('write %s more words', _SQ_PLUGIN_NAME_) . '",
                            __keywordinintroduction: "' . __('Add the keyword in the %s of your article', _SQ_PLUGIN_NAME_) . '",
                            __clicktohighlight: "' . __('Click to keep the highlight on', _SQ_PLUGIN_NAME_) . '",
                            __introduction: "' . __('introduction', _SQ_PLUGIN_NAME_) . '",
                            __morewordsafter: "' . __('Write more words after the %s keyword', _SQ_PLUGIN_NAME_) . '",
                            __orusesynonyms: "' . __('or use synonyms', _SQ_PLUGIN_NAME_) . '",
                            __addmorewords: "' . __('add %s more word(s)', _SQ_PLUGIN_NAME_) . '",
                            __removewords: "' . __('or remove %s word(s)', _SQ_PLUGIN_NAME_) . '",
                            __addmorekeywords: "' . __('add %s  more keyword(s)', _SQ_PLUGIN_NAME_) . '",
                            __addminimumwords: "' . __('write %s  more words to start calculating', _SQ_PLUGIN_NAME_) . '",
                            __add_to_briefcase: "' . __('Add to Briefcase', _SQ_PLUGIN_NAME_) . '",
                            __add_keyword_briefcase: "' . __('Add Keyword to Briefcase', _SQ_PLUGIN_NAME_) . '",
                            __usekeyword: "' . __('Use Keyword', _SQ_PLUGIN_NAME_) . '",
                            __new_post_title: "' . __('Auto Draft') . '"
                        };
                  
                        
                        if (typeof sq_script === "undefined"){
                            var sq_script = document.createElement(\'script\');
                            sq_script.src = "' . _SQ_STATIC_API_URL_ . SQ_URI . '/js/squirrly' . (SQ_DEBUG ? '' : '.min') . '.js?ver=' . SQ_VERSION . '";
                            var site_head = document.getElementsByTagName ("head")[0] || document.documentElement;
                            site_head.insertBefore(sq_script, site_head.firstChild);
                        }
                        
                        window.onerror = function(){
                            $.sq_config.sq_windowerror = true;
                        };
                        
                        //for older version return
                        window.params = [];

                        $(document).ready(function() {
                            $("#sq_preloading").html("");
                        });
                    })(jQuery);
                     </script>';

    }

    public static function versionOne() {
        return 1;
    }

    public static function versionTwo() {
        return 2;
    }
}
