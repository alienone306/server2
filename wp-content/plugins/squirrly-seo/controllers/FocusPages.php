<?php

class SQ_Controllers_FocusPages extends SQ_Classes_FrontController {

    /** @var array list of tasks labels */
    public $labels = array();
    /** @var array found pages in DB */
    public $pages = array();
    /** @var array of focus pages from API */
    public $focuspages = array();
    /** @var object with the connection status from API */
    public $checkin;

    /**
     * Initiate the class if called from menu
     * @return mixed|void
     */
    function init() {
        //Clear the Scripts and Styles from other plugins
        SQ_Classes_ObjController::getClass('SQ_Models_Compatibility')->clearStyles();

        //Checkin to API V2
        $this->checkin = SQ_Classes_RemoteController::checkin();

        $tab = SQ_Classes_Helpers_Tools::getValue('tab', 'pagelist');


        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap-reboot');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('switchery');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fontawesome');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('global');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('assistant');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('navbar');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('seosettings');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('chart');

        if (method_exists($this, $tab)) {
            call_user_func(array($this, $tab));
        }

        //@ob_flush();

        if (is_wp_error($this->checkin)) {
            SQ_Classes_Error::setError('Could not connect to Squirrly Cloud. Please refresh.');
            SQ_Classes_Error::hookNotices();
            return;
        }

        echo $this->getView('FocusPages/' . ucfirst($tab));

        //get the modal window for the assistant popup
        echo SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->getModal();
    }

    /**
     * Load for Add Focus Page menu tab
     */
    public function addpage() {
        global $wp_query;
        wp_reset_query();

        $search = (string)SQ_Classes_Helpers_Tools::getValue('skeyword', '');
        $paged = SQ_Classes_Helpers_Tools::getValue('paged', 1);
        $post_per_page = SQ_Classes_Helpers_Tools::getValue('cnt', 10);

        //get all the public post types
        $types = get_post_types(array('public' => true));
        $statuses = array('publish');
        $post_ids = array();
        if ($search <> '') {
            $post_per_page = -1;
        }

        if (!empty($types)) {

            //get all the posts types from database
            $query = array(
                'post_type' => array_keys($types),
                's' => (strpos($search, '/') === false ? $search : ''),
                'post_status' => $statuses,
                'posts_per_page' => $post_per_page,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
            );

            $wp_query = new WP_Query($query);
            $posts = $wp_query->get_posts();

            if (!empty($posts)) {
                foreach ($posts as $post) {
                    if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByID($post)) {
                        //Search the Squirrly Title, Description and URL if search is set
                        if ($search <> '') {
                            if (SQ_Classes_Helpers_Tools::findStr($post->post_title, $search) === false && SQ_Classes_Helpers_Tools::findStr($post->sq->title, $search) === false && SQ_Classes_Helpers_Tools::findStr($post->sq->description, $search) === false && SQ_Classes_Helpers_Tools::findStr($post->url, $search) === false) {
                                continue;
                            }
                        }
                        $post_ids[] = $post->ID;
                        $this->pages[] = $post;
                        unset($page);
                    }
                }
            }

            //get also the focus pages
            $this->focuspages = SQ_Classes_RemoteController::getFocusPages();

        }


    }

    /**
     * Called for List of the Focus Pages
     */
    public function pagelist() {
        $labels = SQ_Classes_Helpers_Tools::getValue('slabel', array());

        //Set the Labels and Categories
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('focuspages');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('labels');
        SQ_Classes_ObjController::getClass('SQ_Models_FocusPages')->init();

        if ($this->checkin) {
            if ($focuspages = SQ_Classes_RemoteController::getFocusPages()) {

                if (is_wp_error($focuspages)) {
                    SQ_Classes_Error::setError('Could not load the Focus Pages.');
                    SQ_Classes_Error::hookNotices();
                    return;
                }

                //Get the audits for the focus pages
                $audits = SQ_Classes_RemoteController::getFocusAudits();

                if (!empty($focuspages)) {
                    foreach ($focuspages as $focuspage) {
                        //Add the audit data if exists
                        if (isset($focuspage->user_post_id) && !empty($audits)) {
                            foreach ($audits as $audit) {
                                if ($focuspage->user_post_id == $audit->user_post_id) {
                                    $focuspage->audit = json_decode($audit->audit);
                                }
                            }
                        }

                        /** @var SQ_Models_Domain_FocusPage $focuspage */
                        $focuspage = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_FocusPage', $focuspage);
                        //set the connection info with GSC and GA
                        $focuspage->audit->sq_analytics_gsc_connected = (isset($this->checkin->connection_gsc) ? $this->checkin->connection_gsc : 0);
                        $focuspage->audit->sq_analytics_google_connected = (isset($this->checkin->connection_ga) ? $this->checkin->connection_ga : 0);
                        $focuspage->audit->sq_subscription_serpcheck = (isset($this->checkin->subscription_serpcheck) ? $this->checkin->subscription_serpcheck : 0);

                        SQ_Debug::dump($focuspage, $focuspage->audit);

                        //If there is a local page, then show focus
                        if ($focuspage->getWppost()) {
                            $this->focuspages[] = SQ_Classes_ObjController::getClass('SQ_Models_FocusPages')->parseFocusPage($focuspage, $labels)->getFocusPage();
                        } elseif ($focuspage->user_post_id) {
                            SQ_Classes_Error::setError(__('Focus Page does not exist or was deleted from your website.', _SQ_PLUGIN_NAME_));
                            SQ_Classes_RemoteController::deleteFocusPage(array('user_post_id' => $focuspage->user_post_id));
                        }
                    }
                }
            }
        }
        //Get the labels for view use
        if (!empty($labels) || count((array)$this->focuspages) > 1) {
            $this->labels = SQ_Classes_ObjController::getClass('SQ_Models_FocusPages')->getLabels();
        }
    }


    /**
     * Called when action is triggered
     *
     * @return void
     */
    public function action() {

        parent::action();

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_focuspages_addnew':
                if (!current_user_can('sq_manage_focuspages')) {
                    return;
                }

                $post_id = SQ_Classes_Helpers_Tools::getValue('id', false);
                if ($post_id) {
                    if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByID($post_id)) {
                        if ($post->post_status == 'publish' && $post->ID == $post_id) {
                            $args = array();
                            $args['post_id'] = $post->ID;
                            $args['permalink'] = $post->url;
                            if ($focuspage = SQ_Classes_RemoteController::addFocusPage($args)) {
                                if (!is_wp_error($focuspage)) {
                                    SQ_Classes_Error::setError(__('Focus page is added. The audit may take a while so please be patient.', _SQ_PLUGIN_NAME_) . " <br /> ", 'success');
                                    set_transient('sq_focuspage_' . $post_id, strtotime(date('Y-m-d H:i:s')));
                                } elseif ($focuspage->get_error_message() == 'limit_exceed') {
                                    SQ_Classes_Error::setError(__('You reached the maximum number of focus pages for your account.', _SQ_PLUGIN_NAME_) . " <br /> ");
                                }
                            } else {
                                SQ_Classes_Error::setError(__('Error! Could not add the focus page.', _SQ_PLUGIN_NAME_) . " <br /> ");
                            }
                        } else {
                            SQ_Classes_Error::setError(__('Error! This focus page is not public.', _SQ_PLUGIN_NAME_) . " <br /> ");
                        }
                    } else {
                        SQ_Classes_Error::setError(__('Error! Could not find the focus page in your website.', _SQ_PLUGIN_NAME_) . " <br /> ");
                    }
                }
                break;

            case 'sq_focuspages_update':
                if (!current_user_can('sq_manage_focuspages')) {
                    return;
                }

                $post_id = SQ_Classes_Helpers_Tools::getValue('id', false);
                $user_post_id = SQ_Classes_Helpers_Tools::getValue('user_post_id', false);
                if ($user_post_id) {
                    if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByID($post_id)) {
                        if ($post->post_status == 'publish') {
                            $args = array();
                            $args['post_id'] = $user_post_id;
                            $args['permalink'] = $post->url;
                            if ($focuspage = SQ_Classes_RemoteController::updateFocusPage($args)) {
                                if (!is_wp_error($focuspage)) {
                                    SQ_Classes_Error::setError(__('Focus page sent for recheck. It may take a while so please be patient.', _SQ_PLUGIN_NAME_) . " <br /> ", 'success');
                                    set_transient('sq_focuspage_' . $post_id, strtotime(date('Y-m-d H:i:s')));
                                } elseif ($focuspage->get_error_message() == 'too_many_attempts') {
                                    SQ_Classes_Error::setError(__("You've made too many requests, please wait a few minutes.", _SQ_PLUGIN_NAME_) . " <br /> ");
                                }
                            } else {
                                SQ_Classes_Error::setError(__('Error! Could not refresh the focus page.', _SQ_PLUGIN_NAME_) . " <br /> ");
                            }
                        } else {
                            SQ_Classes_Error::setError(__('Error! This focus page is not public.', _SQ_PLUGIN_NAME_) . " <br /> ");
                        }
                    } else {
                        SQ_Classes_Error::setError(__('Error! Could not find the focus page in your website.', _SQ_PLUGIN_NAME_) . " <br /> ");
                    }
                }
                break;
            case 'sq_focuspages_delete':
                if (!current_user_can('sq_manage_focuspages')) {
                    return;
                }

                if ($user_post_id = SQ_Classes_Helpers_Tools::getValue('id', false)) {
                    SQ_Classes_RemoteController::deleteFocusPage(array('user_post_id' => $user_post_id));
                    SQ_Classes_Error::setError(__('The focus page is deleted', _SQ_PLUGIN_NAME_) . " <br /> ", 'success');
                } else {
                    SQ_Classes_Error::setError(__('Invalid params!', _SQ_PLUGIN_NAME_) . " <br /> ");
                }

                break;
        }

    }
}
