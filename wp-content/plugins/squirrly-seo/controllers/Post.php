<?php

class SQ_Controllers_Post extends SQ_Classes_FrontController {

    public $saved;

    public function init() {
        parent::init();

        //Load post style in post edit
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('post');

        //load the draggable script in post edit for the floating SLA
        wp_enqueue_script("jquery-ui-core");
        wp_enqueue_script("jquery-ui-draggable");
    }

    /**
     * Hook the post save
     */
    public function hookPost() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '')
            return;

        //Hook and save the Snippet and Keywords
        add_action('wp_insert_attachment_data', array($this, 'checkSeo'), 11, 2);
        add_filter('wp_insert_post_data', array($this, 'checkSeo'), 11, 2);
        add_filter('wp_insert_post_data', array($this, 'removeHighlight'), 12, 2);
        add_filter('wp_insert_post_data', array($this, 'checkImage'), 13, 2);
        add_filter('save_post', array($this, 'sendSeo'), 11, 2);

        //Hook the Move To Trash action
        add_action('wp_trash_post', array(SQ_Classes_ObjController::getClass('SQ_Models_PostsList'), 'hookUpdateStatus'));

        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap')) {
            add_action('transition_post_status', array(SQ_Classes_ObjController::getClass('SQ_Controllers_Sitemaps'), 'refreshSitemap'), 9999, 3);
        }

    }

    /**
     * Initialize the TinyMCE editor for the current use
     *
     * @return void
     */
    public function hookEditor() {
        $this->saved = array();
    }

    /**
     * Remove the Squirrly Highlights in case there are some left
     * @param array $post_data
     * @param array $postarr
     * @return array
     */
    public function removeHighlight($post_data, $postarr) {
        if (!isset($post_data['post_content']) || !isset($postarr['ID'])) {
            return $post_data;
        }

        if (strpos($post_data['post_content'], '<mark') !== false) {
            $post_data['post_content'] = preg_replace('/<mark[^>]*(data-markjs|mark_counter)[^>]*>([^<]*)<\/mark>/i', '$2', $post_data['post_content']);
        }
        return $post_data;
    }

    /**
     * Check if the image is a remote image and save it locally
     *
     * @param array $post_data
     * @param array $postarr
     * @return array
     */
    public function checkImage($post_data, $postarr) {
        if (!isset($post_data['post_content']) || !isset($postarr['ID'])) {
            return $post_data;
        }

        require_once(ABSPATH . 'wp-admin/includes/image.php');

        //if the option to save the images locally is set on
        if (SQ_Classes_Helpers_Tools::getOption('sq_local_images')) {
            @set_time_limit(90);

            $urls = array();
            if (function_exists('preg_match_all')) {
                @preg_match_all('/<img[^>]*src=[\'"]([^\'"]+)[\'"][^>]*>/i', stripslashes($post_data['post_content']), $out);

                if (!empty($out)) {
                    if (!is_array($out[1]) || count((array)$out[1]) == 0)
                        return $post_data;

                    if (get_bloginfo('wpurl') <> '') {
                        $domain = parse_url(home_url(), PHP_URL_HOST);

                        foreach ($out[1] as $row) {
                            if (strpos($row, '//') !== false && strpos($row, $domain) === false) {
                                if (!in_array($row, $urls)) {
                                    $urls[] = $row;
                                }
                            }
                        }
                    }
                }
            }

            if (!is_array($urls) || (is_array($urls) && count((array)$urls) == 0)) {
                return $post_data;
            }

            $urls = @array_unique($urls);

            $time = microtime(true);
            foreach ($urls as $url) {
                if ($file = $this->model->upload_image($url)) {
                    if (!file_is_valid_image($file['file']))
                        continue;

                    $local_file = $file['url'];
                    if ($local_file !== false) {
                        $post_data['post_content'] = str_replace($url, $local_file, $post_data['post_content']);

                        if (!$this->model->findAttachmentByUrl(basename($url))) {
                            $attach_id = wp_insert_attachment(array(
                                'post_mime_type' => $file['type'],
                                'post_title' => SQ_Classes_Helpers_Tools::getValue('sq_keyword', preg_replace('/\.[^.]+$/', '', $file['filename'])),
                                'post_content' => '',
                                'post_status' => 'inherit',
                                'guid' => $local_file
                            ), $file['file'], $postarr['ID']);

                            $attach_data = wp_generate_attachment_metadata($attach_id, $file['file']);
                            wp_update_attachment_metadata($attach_id, $attach_data);
                        }
                    }
                }

                if (microtime(true) - $time >= 20) {
                    break;
                }

            }


        }

        return $post_data;
    }

    public function sendSeo($postID, $post) {
        if (!isset($post->ID)) {
            return;
        }

        //If the post is a new or edited post
        if (wp_is_post_autosave($post->ID) == '' &&
            get_post_status($post->ID) != 'auto-draft' &&
            get_post_status($post->ID) != 'inherit'
        ) {

            $args = array();

            $seo = SQ_Classes_Helpers_Tools::getValue('sq_seo', '');

            if (is_array($seo) && count((array)$seo) > 0)
                $args['seo'] = implode(',', $seo);

            $args['keyword'] = SQ_Classes_Helpers_Tools::getValue('sq_keyword', '');

            $args['status'] = $post->post_status;
            $args['permalink'] = get_permalink($post->ID);
            $args['author'] = $post->post_author;
            $args['post_id'] = $post->ID;

            if ($args['permalink']) {
                if (SQ_Classes_Helpers_Tools::getOption('sq_force_savepost')) {
                    SQ_Classes_RemoteController::savePost($args);
                } else {
                    $process = array();
                    if (get_option('sq_seopost') !== false) {
                        $process = json_decode(get_option('sq_seopost'), true);
                    }

                    $process[] = $args;

                    //save for later send to api
                    update_option('sq_seopost', json_encode($process));
                    wp_schedule_single_event(time(), 'sq_cron_process_single');

                    //If the queue is too big ... means that the cron is not working
                    if (count((array)$process) > 5) SQ_Classes_Helpers_Tools::saveOptions('sq_force_savepost', 1);
                }
            }
        }
    }

    /**
     * Check the SEO from Squirrly Live Assistant
     *
     * @param array $post_data
     * @param array $postarr
     * @return array
     */
    public function checkSeo($post_data, $postarr) {
        if (!isset($post_data['post_content']) || !isset($postarr['ID'])) {
            return $post_data;
        }

        //If the post is a new or edited post
        if (wp_is_post_autosave($postarr['ID']) == '' &&
            get_post_status($postarr['ID']) != 'auto-draft' &&
            get_post_status($postarr['ID']) != 'inherit'
        ) {
            //Save the snippet in case is edited in backend and not saved
            SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->saveSEO();

            //check for custom SEO
            $this->_checkBriefcaseKeywords($postarr['ID']);
        }

        return $post_data;
    }

    /**
     * Called when Post action is triggered
     *
     * @return void
     */
    public function action() {
        parent::action();
        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_save_ogimage':
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                if (!empty($_FILES['ogimage'])) {
                    $return = $this->model->addImage($_FILES['ogimage']);
                }
                if (isset($return['file'])) {
                    $return['filename'] = basename($return['file']);
                    $local_file = str_replace($return['filename'], urlencode($return['filename']), $return['url']);
                    $attach_id = wp_insert_attachment(array(
                        'post_mime_type' => $return['type'],
                        'post_title' => preg_replace('/\.[^.]+$/', '', $return['filename']),
                        'post_content' => '',
                        'post_status' => 'inherit',
                        'guid' => $local_file
                    ), $return['file'], SQ_Classes_Helpers_Tools::getValue('post_id'));

                    $attach_data = wp_generate_attachment_metadata($attach_id, $return['file']);
                    wp_update_attachment_metadata($attach_id, $attach_data);
                }
                SQ_Classes_Helpers_Tools::setHeader('json');
                SQ_Classes_Helpers_Tools::emptyCache();

                echo json_encode($return);
                exit();

            case 'sq_create_demo':
                $post_type = 'post';
                if (post_type_exists($post_type)) {
                    if (file_exists(_SQ_ROOT_DIR_ . 'demo.json')) {
                        $json = json_decode(file_get_contents(_SQ_ROOT_DIR_ . 'demo.json'));

                        if (isset($json->demo->title) && isset($json->demo->content)) {
                            @setrawcookie('sq_keyword', rawurlencode($json->demo->keyword), strtotime('+1 hour'), COOKIEPATH, COOKIE_DOMAIN, is_ssl());

                            $args = array();
                            $args['s'] = '"' . addslashes($json->demo->title) . '"';
                            $args['post_type'] = $post_type;
                            //if the post doesn't exists already or is changed
                            if (!$posts = SQ_Classes_ObjController::getClass('SQ_Models_Post')->searchPost($args)) {

                                // Create post object
                                $post = array(
                                    'post_title' => $json->demo->title,
                                    'post_content' => $json->demo->content,
                                    'post_status' => 'draft',
                                    'comment_status' => 'closed',
                                    'ping_status' => 'closed',
                                    'post_type' => $post_type,
                                    'post_author' => get_current_user_id(),
                                    'post_category' => array()
                                );

                                if ($post_id = wp_insert_post($post)) {
                                    if (!is_wp_error($post_id)) {
                                        wp_redirect(admin_url("post.php?post=" . $post_id . "&action=edit&post_type=" . $post_type));
                                        exit();

                                    }
                                }
                            } else {
                                foreach ($posts as $post) {
                                    wp_redirect(admin_url("post.php?post=" . $post->ID . "&action=edit&post_type=" . $post_type));
                                    exit();
                                }
                            }

                        }
                    }
                }
                SQ_Classes_Error::setError(__('Could not add the demo post.', _SQ_PLUGIN_NAME_));
                break;

            /**************************** AJAX CALLS *************************/
            case 'sq_ajax_type_click':
                SQ_Classes_Helpers_Tools::saveOptions('sq_img_licence', SQ_Classes_Helpers_Tools::getValue('licence'));
                exit();

            case 'sq_ajax_search_blog':
                $args = array();
                $args['post_type'] = 'post';
                $args['post_status'] = 'publish';

                if (SQ_Classes_Helpers_Tools::getValue('exclude') && SQ_Classes_Helpers_Tools::getValue('exclude') <> 'undefined') {
                    $args['post__not_in'] = array((int)SQ_Classes_Helpers_Tools::getValue('exclude'));
                }
                if (SQ_Classes_Helpers_Tools::getValue('start'))
                    $args['start'] = array((int)SQ_Classes_Helpers_Tools::getValue('start'));

                if (SQ_Classes_Helpers_Tools::getValue('nrb'))
                    $args['posts_per_page'] = (int)SQ_Classes_Helpers_Tools::getValue('nrb');

                if (SQ_Classes_Helpers_Tools::getValue('q') <> '')
                    $args['s'] = SQ_Classes_Helpers_Tools::getValue('q');

                $responce = array();
                if ($posts = SQ_Classes_ObjController::getClass('SQ_Models_Post')->searchPost($args)) {
                    foreach ($posts as $post) {
                        $responce['results'][] = array('id' => $post->ID,
                            'url' => get_permalink($post->ID),
                            'title' => $post->post_title,
                            'content' => SQ_Classes_Helpers_Sanitize::truncate($post->post_content, 50),
                            'date' => $post->post_date_gmt);
                    }
                }

                echo json_encode($responce);
                exit();
        }
    }

    /**
     * Save the keywords from briefcase into the meta keywords if there are no keywords saved
     * @param $post_id
     */
    private function _checkBriefcaseKeywords($post_id) {
        if (SQ_Classes_Helpers_Tools::getIsset('sq_hash')) {
            $keywords = SQ_Classes_Helpers_Tools::getValue('sq_briefcase_keyword', array());

            if (empty($keywords)) { //if not from brifcase, check the keyword
                $keywords[] = SQ_Classes_Helpers_Tools::getValue('sq_keyword');
            }

            if (!empty($keywords)) {
                $sq_hash = SQ_Classes_Helpers_Tools::getValue('sq_hash', md5($post_id));
                $url = SQ_Classes_Helpers_Tools::getValue('sq_url', get_permalink($post_id));
                $sq = SQ_Classes_ObjController::getClass('SQ_Models_Qss')->getSqSeo($sq_hash);

                if ($sq->doseo && $sq->keywords == '') {
                    $sq->keywords = join(',', $keywords);

                    SQ_Classes_ObjController::getClass('SQ_Models_Qss')->saveSqSEO(
                        $url,
                        $sq_hash,
                        (int)$post_id,
                        maybe_serialize($sq->toArray()),
                        gmdate('Y-m-d H:i:s')
                    );
                }
            }
        }
    }

    public function hookFooter() {
        if (!defined('DISABLE_WP_CRON') || DISABLE_WP_CRON) {
            global $pagenow;
            if (in_array($pagenow, array('post.php', 'post-new.php'))) {
                SQ_Classes_ObjController::getClass('SQ_Controllers_Cron')->processSEOPostCron();
            }
        }
    }

}
