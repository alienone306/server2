<?php

class SQ_Controllers_SeoSettings extends SQ_Classes_FrontController {

    public $pages = array();

    function init() {
        //Clear the Scripts and Styles from other plugins
        SQ_Classes_ObjController::getClass('SQ_Models_Compatibility')->clearStyles();

        $tab = SQ_Classes_Helpers_Tools::getValue('tab', 'bulkseo');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap-reboot');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('switchery');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fontawesome');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('global');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('assistant');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('navbar');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('seosettings');

        if (method_exists($this, $tab)) {
            call_user_func(array($this, $tab));
        }

        if (function_exists('wp_enqueue_media')) {
            wp_enqueue_media();
        }

        //@ob_flush();
        echo $this->getView('SeoSettings/' . ucfirst($tab));

        //get the modal window for the assistant popup
        echo SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->getModal();
    }

    public function gotoImport() {
        $_GET['tab'] = 'backup';
        return $this->init();
    }

    public function bulkseo() {
        global $wp_query;
        wp_reset_query();

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bulkseo');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('labels');

        $search = (string)SQ_Classes_Helpers_Tools::getValue('skeyword', '');
        $labels = SQ_Classes_Helpers_Tools::getValue('slabel', array());
        $paged = SQ_Classes_Helpers_Tools::getValue('spage', 1);
        $post_id = SQ_Classes_Helpers_Tools::getValue('sid', false);
        $post_type = SQ_Classes_Helpers_Tools::getValue('stype', 'post');
        $post_per_page = SQ_Classes_Helpers_Tools::getValue('cnt', 10);
        $post_status = SQ_Classes_Helpers_Tools::getValue('sstatus', '');

        if ($search <> '') {
            $post_per_page = 50;
        } else {
            $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');
            if (!isset($patterns[$post_type])) {
                $patterns[$post_type] = $patterns['custom'];
            }
        }

        //Set the Labels and Categories
        SQ_Classes_ObjController::getClass('SQ_Models_BulkSeo')->init();

        //Remove the page from URL for bulkSEO
        remove_filter('sq_post', array(SQ_Classes_ObjController::getClass('SQ_Models_Frontend'), 'addPaged'), 14);


        //If home then show the home url
        if (($post_type == 'home' || $search == '#all') && ($post_status == '' || $post_status == 'publish')) {
            if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setHomePage()) {
                $this->pages[] = SQ_Classes_ObjController::getClass('SQ_Models_BulkSeo')->parsePage($post, $labels)->getPage();
            }
        }

        //get all the public post types
        $types = get_post_types(array('public' => true));
        $statuses = array('draft', 'publish', 'pending', 'future', 'private');
        //push the shop page into post types to pass the filter
        if ($post_type == 'shop') array_push($types, 'shop');

        if (!empty($types) && in_array($post_type, $types) || $search == '#all') {

            //get all the posts types from database
            //filter by all in case of #all search
            //filter by page in case of shop post type
            $query = array(
                'post_type' => ($search == '#all' || $post_id ? array_keys($types) : ($post_type <> 'shop' ? $post_type : 'page')),
                's' => ($search <> '#all' ? (strpos($search, '/') === false ? $search : '') : ''),
                'posts_per_page' => $post_per_page,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
            );

            //If post id is set in URL
            if ($post_id) {
                $query['post__in'] = explode(',', $post_id);
            }

            //show the draft and publish posts
            if ($search == '#all' || $post_type <> 'attachment') {
                $query['post_status'] = ($post_status <> '' ? $post_status : $statuses);
            }

            $wp_query = new WP_Query($query);
            $posts = $wp_query->get_posts();
            $wp_query->is_paged = false; //remove pagination

            if (!empty($posts)) {
                foreach ($posts as $post) {

                    if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByID($post)) {
                        if ($page = SQ_Classes_ObjController::getClass('SQ_Models_BulkSeo')->parsePage($post, $labels)->getPage()) {
                            if ($page->url <> '') {
                                //Search the Squirrly Title, Description and URL if search is set
                                if ($search <> '' && $search <> '#all') {
                                    if (SQ_Classes_Helpers_Tools::findStr($page->sq->title, $search) === false && SQ_Classes_Helpers_Tools::findStr($page->sq->description, $search) === false && SQ_Classes_Helpers_Tools::findStr($page->url, $search) === false) {
                                        continue;
                                    }
                                }

                                //Don't let other post types to pass
                                if ($search <> '#all' && !$post_id && isset($page->post_type) && $page->post_type <> $post_type) {
                                    continue;
                                }

                                $this->pages[] = $page;
                            }

                            unset($page);
                        }
                    }
                }
            }
        }

        //Get all taxonomies like category, tag, custom post types
        $taxonomies = get_taxonomies(array('public' => true));
        if ($post_type == 'tag') $post_type = 'post_tag';
        if (strpos($post_type, 'tax-') !== false) $post_type = str_replace('tax-', '', $post_type);
        if (in_array($post_type, $taxonomies) || $search == '#all') {

            $query = array(
                'public' => true,
                'taxonomy' => ($search == '#all' ? $taxonomies : $post_type),
                'hide_empty' => false,
            );

            //If post id is set in URL
            //Same filter for taxonomy id
            if ($post_id) {
                $query['include'] = explode(',', $post_id);
            }

            $categories = get_terms($query);
            if (!is_wp_error($categories) && !empty($categories)) {
                foreach ($categories as $category) {

                    if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByTaxID($category->term_id, $category->taxonomy)) {
                        if ($page = SQ_Classes_ObjController::getClass('SQ_Models_BulkSeo')->parsePage($post, $labels)->getPage()) {
                            if ($page->url <> '') {
                                if ($search <> '') {
                                    if (SQ_Classes_Helpers_Tools::findStr($category->name, $search) === false && SQ_Classes_Helpers_Tools::findStr($category->slug, $search) === false && SQ_Classes_Helpers_Tools::findStr($page->sq->title, $search) === false) {
                                        continue;
                                    }
                                }

                                $this->pages[] = $page;
                            }
                            unset($page);

                        }
                    }

                }
            }
        }

        //Get the user profile from database
        //search in user profile
        if ($post_type == "profile" || $search == '#all') {
            $blog_id = get_current_blog_id();
            $args = array(
                'blog_id' => $blog_id,
                'role__not_in' => array('subscriber', 'contributor', 'customer'),
                'orderby' => 'login',
                'order' => 'ASC',
                'search' => ($search == '#all' ? '' : $search),
                'count_total' => false,
                'fields' => array('ID'),
            );

            $users = get_users($args);

            foreach ($users as $user) {
                if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setAuthorPage($user->ID)) {
                    if ($page = SQ_Classes_ObjController::getClass('SQ_Models_BulkSeo')->parsePage($post, $labels)->getPage()) {
                        if ($page->url <> '') {
                            $this->pages[] = $page;
                            unset($page);
                        }
                    }
                }
            }

        }


        if (!empty($labels) || count((array)$this->pages) > 1) {
            //Get the labels for view use
            $this->labels = SQ_Classes_ObjController::getClass('SQ_Models_BulkSeo')->getLabels();
        }
    }

    public function automation() {
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('highlight');
        SQ_Classes_ObjController::getClass('SQ_Controllers_Patterns')->init();
    }

    public function metas() {
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('highlight');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('snippet');

    }

    public function jsonld() {
    }

    public function backup() {
        add_filter('sq_themes', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'getAvailableThemes'), 10, 1);
        add_filter('sq_importList', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'importList'));

    }

    public function hookFooter() {
        if (!SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) {
            echo "<script>jQuery('.sq_advanced').hide();</script>";
        } else {
            echo "<script>jQuery('.sq_advanced').show();</script>";
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

            ///////////////////////////////////////////SEO SETTINGS METAS
            case 'sq_seosettings_metas':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                ///////////////////////////////////////////
                /////////////////////////////FIRST PAGE OPTIMIZATION
                $url = home_url();
                SQ_Classes_ObjController::getClass('SQ_Models_Qss')->createTable();
                $post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setHomePage();

                $post->sq->doseo = 1;
                $post->sq->title = urldecode(SQ_Classes_Helpers_Tools::getValue('sq_fp_title', false));
                $post->sq->description = urldecode(SQ_Classes_Helpers_Tools::getValue('sq_fp_description', false));
                $post->sq->keywords = SQ_Classes_Helpers_Tools::getValue('sq_fp_keywords', false);

                if (SQ_Classes_Helpers_Tools::getIsset('sq_fp_ogimage')) {
                    $post->sq->og_media = SQ_Classes_Helpers_Tools::getValue('sq_fp_ogimage', '');
                }

                SQ_Classes_ObjController::getClass('SQ_Models_Qss')->saveSqSEO(
                    $url,
                    md5('wp_homepage'),
                    0,
                    maybe_serialize($post->sq->toArray()),
                    gmdate('Y-m-d H:i:s')
                );

                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(__('Saved', _SQ_PLUGIN_NAME_));

                break;

            ///////////////////////////////////////////SEO SETTINGS AUTOMATION
            case 'sq_seosettings_automation':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }


                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(__('Saved', _SQ_PLUGIN_NAME_));

                break;
            ///////////////////////////////////////////SEO SETTINGS METAS
            case 'sq_seosettings_social':
            case 'sq_seosettings_tracking':
            case 'sq_seosettings_webmaster':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                //save the options in database
                SQ_Classes_Helpers_Tools::saveOptions();

                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(__('Saved', _SQ_PLUGIN_NAME_));


                break;

            ///////////////////////////////////////////SEO SETTINGS METAS
            case 'sq_seosettings_sitemap':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                //Make sure we get the Sitemap data from the form
                if ($sitemap = SQ_Classes_Helpers_Tools::getValue('sitemap', false)) {
                    foreach (SQ_Classes_Helpers_Tools::$options['sq_sitemap'] as $key => $value) {
                        if (isset($sitemap[$key])) {
                            SQ_Classes_Helpers_Tools::$options['sq_sitemap'][$key][1] = (int)$sitemap[$key];
                        } elseif ($key <> 'sitemap') {
                            SQ_Classes_Helpers_Tools::$options['sq_sitemap'][$key][1] = 0;
                        }
                    }
                }

                //save the options in database
                SQ_Classes_Helpers_Tools::saveOptions();

                //delete other sitemap xml files from root
                if (SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap') && file_exists(ABSPATH . "/" . 'sitemap.xml')) {
                    @rename(ABSPATH . "/" . 'sitemap.xml', ABSPATH . "/" . 'sitemap_ren' . time() . '.xml');

                }

                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(__('Saved', _SQ_PLUGIN_NAME_));

                break;

            //Save the JSON-LD page from SEO Settings
            case 'sq_seosettings_jsonld':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                if (SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Person']['telephone'] <> '') {
                    SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Person']['telephone'] = '+' . ltrim(SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Person']['telephone'], '+');
                }
                if (SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Organization']['telephone'] <> '') {
                    SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Organization']['telephone'] = '+' . ltrim(SQ_Classes_Helpers_Tools::$options['sq_jsonld']['Organization']['telephone'], '+');
                }

                //save the options in database
                SQ_Classes_Helpers_Tools::saveOptions();

                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(__('Saved', _SQ_PLUGIN_NAME_));

                break;

            //Save the Robots permissions
            case 'sq_seosettings_robots':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                //Save custom robots
                $robots = SQ_Classes_Helpers_Tools::getValue('robots_permission', '', true);
                $robots = explode(PHP_EOL, $robots);
                $robots = str_replace("\r", "", $robots);

                if (!empty($robots)) {
                    SQ_Classes_Helpers_Tools::$options['sq_robots_permission'] = array_unique($robots);
                }

                //save the options in database
                SQ_Classes_Helpers_Tools::saveOptions();

                //show the saved message
                if (!SQ_Classes_Error::isError()) SQ_Classes_Error::setMessage(__('Saved', _SQ_PLUGIN_NAME_));


                break;

            //Save the Favicon image
            case 'sq_seosettings_favicon':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //If the favicon is turned off delete the favicon image created
                if (!SQ_Classes_Helpers_Tools::getValue('sq_auto_favicon') &&
                    SQ_Classes_Helpers_Tools::getOption('sq_auto_favicon') &&
                    SQ_Classes_Helpers_Tools::getOption('favicon') <> '' &&
                    file_exists(ABSPATH . "/" . 'favicon.ico')) {
                    @rename(ABSPATH . "/" . 'favicon.ico', ABSPATH . "/" . 'favicon_ren' . time() . '.ico');
                }

                //Save the settings
                if (!empty($_POST)) {
                    SQ_Classes_ObjController::getClass('SQ_Models_Settings')->saveValues($_POST);
                }

                /* if there is an icon to upload */
                if (!empty($_FILES['favicon'])) {
                    if ($return = SQ_Classes_ObjController::getClass('SQ_Models_Ico')->addFavicon($_FILES['favicon'])) {
                        if ($return['favicon'] <> '') {
                            SQ_Classes_Helpers_Tools::saveOptions('favicon', strtolower(basename($return['favicon'])));
                        }
                    }
                }


                break;

            case "sq_seosettings_ga_revoke":
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //remove connection with Google Analytics
                $response = SQ_Classes_RemoteController::revokeGaConnection();
                if (!is_wp_error($response)) {
                    SQ_Classes_Error::setError(__('Google Analytics account is disconnected.', _SQ_PLUGIN_NAME_) . " <br /> ", 'success');
                } else {
                    SQ_Classes_Error::setError(__('Error! Could not disconnect the account.', _SQ_PLUGIN_NAME_) . " <br /> ");
                }
                break;

            case "sq_seosettings_gsc_revoke":
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                //remove connection with Google Search Console
                $response = SQ_Classes_RemoteController::revokeGscConnection();
                if (!is_wp_error($response)) {
                    SQ_Classes_Error::setError(__('Google Search Console account is disconnected.', _SQ_PLUGIN_NAME_) . " <br /> ", 'success');
                } else {
                    SQ_Classes_Error::setError(__('Error! Could not disconnect the account.', _SQ_PLUGIN_NAME_) . " <br /> ");
                }
                break;

            case 'sq_seosettings_backupsettings':
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('text');
                header("Content-Disposition: attachment; filename=squirrly-settings-" . gmdate('Y-m-d') . ".txt");

                if (function_exists('base64_encode')) {
                    echo base64_encode(json_encode(SQ_Classes_Helpers_Tools::$options));
                } else {
                    echo json_encode(SQ_Classes_Helpers_Tools::$options);
                }
                exit();
            case 'sq_seosettings_restoresettings':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                if (!empty($_FILES['sq_options']) && $_FILES['sq_options']['tmp_name'] <> '') {
                    $fp = fopen($_FILES['sq_options']['tmp_name'], 'rb');
                    $options = '';
                    while (($line = fgets($fp)) !== false) {
                        $options .= $line;
                    }
                    try {
                        if (function_exists('base64_encode') && base64_decode($options) <> '') {
                            $options = @base64_decode($options);
                        }
                        $options = json_decode($options, true);
                        if (is_array($options) && isset($options['sq_api'])) {
                            if (SQ_Classes_Helpers_Tools::getOption('sq_api') <> '') {
                                $options['sq_api'] = SQ_Classes_Helpers_Tools::getOption('sq_api');
                            }
                            if (SQ_Classes_Helpers_Tools::getOption('sq_seojourney') <> '') {
                                $options['sq_seojourney'] = SQ_Classes_Helpers_Tools::getOption('sq_seojourney');
                            }
                            SQ_Classes_Helpers_Tools::$options = $options;
                            SQ_Classes_Helpers_Tools::saveOptions();

                            //Check if there is an old backup from Squirrly
                            SQ_Classes_Helpers_Tools::getOptions();
                            SQ_Classes_Helpers_Tools::checkUpgrade();

                            SQ_Classes_Error::setError(__('Great! The backup is restored.', _SQ_PLUGIN_NAME_) . " <br /> ", 'success');
                        } else {
                            SQ_Classes_Error::setError(__('Error! The backup is not valid.', _SQ_PLUGIN_NAME_) . " <br /> ");
                        }
                    } catch (Exception $e) {
                        SQ_Classes_Error::setError(__('Error! The backup is not valid.', _SQ_PLUGIN_NAME_) . " <br /> ");
                    }
                } else {
                    SQ_Classes_Error::setError(__('Error! You have to enter a previously saved backup file.', _SQ_PLUGIN_NAME_) . " <br /> ");
                }
                break;
            case 'sq_seosettings_backupseo':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary");
                header("Content-Disposition: attachment; filename=squirrly-seo-" . gmdate('Y-m-d') . ".sql");

                if (function_exists('base64_encode')) {
                    echo base64_encode(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->createTableBackup());
                } else {
                    echo SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->createTableBackup();
                }
                exit();
            case 'sq_seosettings_restoreseo':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                if (!empty($_FILES['sq_sql']) && $_FILES['sq_sql']['tmp_name'] <> '') {
                    $fp = fopen($_FILES['sq_sql']['tmp_name'], 'rb');
                    $sql_file = '';
                    while (($line = fgets($fp)) !== false) {
                        $sql_file .= $line;
                    }

                    if (function_exists('base64_encode')) {
                        $sql_file = @base64_decode($sql_file);
                    }

                    if ($sql_file <> '' && strpos($sql_file, 'CREATE TABLE IF NOT EXISTS') !== false) {
                        try {
                            $queries = explode(";\n", $sql_file);
                            SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->executeSql($queries);
                            SQ_Classes_Error::setError(__('Great! The SEO backup is restored.', _SQ_PLUGIN_NAME_) . " <br /> ", 'success');

                        } catch (Exception $e) {
                            SQ_Classes_Error::setError(__('Error! The backup is not valid.', _SQ_PLUGIN_NAME_) . " <br /> ");
                        }
                    } else {
                        SQ_Classes_Error::setError(__('Error! The backup is not valid.', _SQ_PLUGIN_NAME_) . " <br /> ");
                    }
                } else {
                    SQ_Classes_Error::setError(__('Error! You have to enter a previously saved backup file.', _SQ_PLUGIN_NAME_) . " <br /> ");
                }
                break;

            case 'sq_seosettings_importall':
                $platform = SQ_Classes_Helpers_Tools::getValue('sq_import_platform', '');
                if ($platform <> '') {
                    if (SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->importDBSettings($platform)) {
                        SQ_Classes_Error::setMessage(__('Settings imported successfuly!', _SQ_PLUGIN_NAME_));
                    }

                    $seo = SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->importDBSeo($platform);
                    if (!empty($seo)) {
                        foreach ($seo as $sq_hash => $metas) {
                            SQ_Classes_ObjController::getClass('SQ_Models_Qss')->saveSqSEO(
                                (isset($metas['url']) ? $metas['url'] : ''),
                                $sq_hash,
                                (isset($metas['post_id']) && is_numeric($metas['post_id']) ? (int)$metas['post_id'] : 0),
                                maybe_serialize($metas),
                                gmdate('Y-m-d H:i:s'));
                        }
                        SQ_Classes_Error::setMessage(sprintf(__('%s SEO records were imported successfuly! You can now deactivate the %s plugin', _SQ_PLUGIN_NAME_), count((array)$seo), SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($platform)));
                    }
                }
                break;

            case 'sq_seosettings_importsettings':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                $platform = SQ_Classes_Helpers_Tools::getValue('sq_import_platform', '');
                if ($platform <> '') {
                    if (SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->importDBSettings($platform)) {
                        SQ_Classes_Error::setMessage(__('All the Plugin settings were imported successfuly!', _SQ_PLUGIN_NAME_));
                    } else {
                        SQ_Classes_Error::setMessage(__('No settings found for this plugin/theme.', _SQ_PLUGIN_NAME_));

                    }
                }
                break;

            case 'sq_seosettings_importseo':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                $platform = SQ_Classes_Helpers_Tools::getValue('sq_import_platform', '');
                if ($platform <> '') {
                    $seo = SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->importDBSeo($platform);
                    if (!empty($seo)) {
                        foreach ($seo as $sq_hash => $metas) {
                            SQ_Classes_ObjController::getClass('SQ_Models_Qss')->saveSqSEO(
                                (isset($metas['url']) ? $metas['url'] : ''),
                                $sq_hash,
                                (isset($metas['post_id']) && is_numeric($metas['post_id']) ? (int)$metas['post_id'] : 0),
                                maybe_serialize($metas),
                                gmdate('Y-m-d H:i:s'));
                        }
                        SQ_Classes_Error::setMessage(sprintf(__('%s SEO records were imported successfuly! You can now deactivate the %s plugin', _SQ_PLUGIN_NAME_), count((array)$seo), SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($platform)));
                    } else {
                        SQ_Classes_Error::setMessage(sprintf(__('There are no SEO records with this plugin. You can now deactivate the %s plugin', _SQ_PLUGIN_NAME_), SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($platform)));

                    }
                }
                break;

            case 'sq_rollback':
                SQ_Classes_Helpers_Tools::setHeader('html');
                $plugin_slug = basename(_SQ_PLUGIN_NAME_, '.php');


                $rollback = SQ_Classes_ObjController::getClass('SQ_Models_Rollback');

                $rollback->set_plugin(array(
                    'version' => SQ_STABLE_VERSION,
                    'plugin_name' => _SQ_ROOT_DIR_ ,
                    'plugin_slug' => $plugin_slug,
                    'package_url' => sprintf('https://downloads.wordpress.org/plugin/%s.%s.zip', $plugin_slug, SQ_STABLE_VERSION),
                ));

                $rollback->run();

                wp_die(
                    '', __('Rollback to Previous Version', _SQ_PLUGIN_NAME_), [
                        'response' => 200,
                    ]
                );
                exit();
            /**************************** Ajax *******************************************************/
            case "sq_ajax_seosettings_save":
                SQ_Classes_Helpers_Tools::setHeader('json');
                $response = array();
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo json_encode($response);
                    exit();
                }


                $name = SQ_Classes_Helpers_Tools::getValue('input', false);
                $value = SQ_Classes_Helpers_Tools::getValue('value', false);

                if (isset(SQ_Classes_Helpers_Tools::$options[$name])) {
                    SQ_Classes_Helpers_Tools::saveOptions($name, $value);
                    $response['data'] = SQ_Classes_Error::showNotices(__('Saved', _SQ_PLUGIN_NAME_), 'sq_success');
                } else {
                    $response['data'] = SQ_Classes_Error::showNotices(__('Could not save the changes', _SQ_PLUGIN_NAME_), 'sq_error');

                }

                echo json_encode($response);
                exit();

            /************************ Automation ********************************************************/
            case 'sq_ajax_automation_addpostype':
                SQ_Classes_Helpers_Tools::setHeader('json');
                $response = array();
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo json_encode($response);
                    exit();
                }


                //Get the new post type
                $posttype = SQ_Classes_Helpers_Tools::getValue('value', false);
                $types = get_post_types();

                //If the post type is in the list of types
                if ($posttype && in_array($posttype, $types)) {
                    $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');
                    //if the post type does not already exists
                    if (!isset($patterns[$posttype])) {
                        //add the custom rights to the new post type
                        $patterns[$posttype] = $patterns['custom'];
                        $patterns[$posttype]['protected'] = 0;
                        //save the options in database
                        SQ_Classes_Helpers_Tools::saveOptions('patterns', $patterns);

                        $response['data'] = SQ_Classes_Error::showNotices(__('Saved', _SQ_PLUGIN_NAME_), 'sq_success');
                        echo json_encode($response);
                        exit();
                    }
                }


                //Return error in case the post is not saved
                $response['data'] = SQ_Classes_Error::showNotices(__('Could not add the post type', _SQ_PLUGIN_NAME_), 'sq_error');
                echo json_encode($response);
                exit();

            case 'sq_ajax_automation_deletepostype':
                SQ_Classes_Helpers_Tools::setHeader('json');
                $response = array();
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo json_encode($response);
                    exit();
                }


                //Get the new post type
                $posttype = SQ_Classes_Helpers_Tools::getValue('value', false);

                //If the post type is in the list of types
                if ($posttype && $posttype <> '') {
                    $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');
                    //if the post type exists in the patterns
                    if (isset($patterns[$posttype])) {
                        //add the custom rights to the new post type
                        unset($patterns[$posttype]);

                        //save the options in database
                        SQ_Classes_Helpers_Tools::saveOptions('patterns', $patterns);

                        $response['data'] = SQ_Classes_Error::showNotices(__('Saved', _SQ_PLUGIN_NAME_), 'sq_success');
                        echo json_encode($response);
                        exit();
                    }
                }


                //Return error in case the post is not saved
                $response['data'] = SQ_Classes_Error::showNotices(__('Could not add the post type', _SQ_PLUGIN_NAME_), 'sq_error');
                echo json_encode($response);
                exit();

            case 'sq_ajax_assistant_bulkseo':
                SQ_Classes_Helpers_Tools::setHeader('json');
                $response = array();
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo json_encode($response);
                    exit();
                }

                $post_id = (int)SQ_Classes_Helpers_Tools::getValue('post_id', 0);
                $term_id = (int)SQ_Classes_Helpers_Tools::getValue('term_id', 0);
                $taxonomy = SQ_Classes_Helpers_Tools::getValue('taxonomy', 'category');
                $post_type = SQ_Classes_Helpers_Tools::getValue('post_type', 'post');

                //Set the Labels and Categories
                SQ_Classes_ObjController::getClass('SQ_Models_BulkSeo')->init();
                if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->getCurrentSnippet($post_id, $term_id, $taxonomy, $post_type)) {
                    $this->post = SQ_Classes_ObjController::getClass('SQ_Models_BulkSeo')->parsePage($post)->getPage();
                }

                $json = array();
                $json['html'] = $this->getView('SeoSettings/BulkseoRow');
                $json['html_dest'] = "#sq_row_" . $this->post->hash;

                $json['assistant'] = '';
                $categories = apply_filters('sq_assistant_categories_page', $this->post->hash);
                if (!empty($categories)) {
                    foreach ($categories as $index => $category) {
                        if (isset($category->assistant)) {
                            $json['assistant'] .= $category->assistant;
                        }
                    }
                }
                $json['assistant_dest'] = "#sq_assistant_" . $this->post->hash;

                echo json_encode($json);
                exit();

            case 'sq_ajax_sla_sticky':
                SQ_Classes_Helpers_Tools::setHeader('json');
                $response = array();
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::saveUserMeta('sq_auto_sticky', (int)SQ_Classes_Helpers_Tools::getValue('sq_auto_sticky'));
                echo json_encode(array());
                exit();
        }

    }

}
