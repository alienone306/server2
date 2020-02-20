<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_Research extends SQ_Classes_FrontController {

    public $blogs;
    public $kr;
    //--
    public $keywords = array();
    public $suggested = array();
    public $rankkeywords = array();
    public $labels = array();
    public $countries = array();
    //--
    public $index;
    public $error;
    public $user;

    function init() {
        //Clear the Scripts and Styles from other plugins
        SQ_Classes_ObjController::getClass('SQ_Models_Compatibility')->clearStyles();

        $tab = SQ_Classes_Helpers_Tools::getValue('tab', 'research');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap-reboot');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('switchery');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('datatables');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fontawesome');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('global');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('assistant');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('navbar');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('research');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia($tab);
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('chart');

        if (method_exists($this, $tab)) {
            call_user_func(array($this, $tab));
        }

        //@ob_flush();
        echo $this->getView('Research/' . ucfirst($tab));

        //get the modal window for the assistant popup
        echo SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->getModal();
    }

    public function research() {
        $countries = SQ_Classes_RemoteController::getKrCountries();

        if (!is_wp_error($countries)) {
            $this->countries = $countries;
        } else {
            $this->error = $countries->get_error_message();
        }
    }

    public function briefcase() {
        $search = (string)SQ_Classes_Helpers_Tools::getValue('skeyword', '');
        $labels = SQ_Classes_Helpers_Tools::getValue('slabel', false);

        $args = array();
        $args['search'] = $search;
        if ($labels && !empty($labels)) {
            $args['label'] = join(',', $labels);
        }
        SQ_Debug::dump($args);

        $briefcase = SQ_Classes_RemoteController::getBriefcase($args);
        $this->rankkeywords = SQ_Classes_RemoteController::getRanks();

        if (!is_wp_error($briefcase)) {
            if (isset($briefcase->keywords) && !empty($briefcase->keywords)) {
                $this->keywords = $briefcase->keywords;
            } else {
                $this->error = __('No keyword found.', _SQ_PLUGIN_NAME_);
            }

            if (isset($briefcase->labels)) {
                $this->labels = $briefcase->labels;
            }

        }

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('briefcase');

    }

    public function labels() {

        $args = array();
        if (!empty($labels)) {
            $args['label'] = join(',', $labels);
        }

        $briefcase = SQ_Classes_RemoteController::getBriefcase($args);

        if (!is_wp_error($briefcase)) {
            if (isset($briefcase->labels)) {
                $this->labels = $briefcase->labels;
            }
        }

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('briefcase');

    }

    public function suggested() {
        //Get the briefcase keywords
        if ($briefcase = SQ_Classes_RemoteController::getBriefcase()) {
            if (!is_wp_error($briefcase)) {
                if (isset($briefcase->keywords)) {
                    $this->keywords = $briefcase->keywords;
                }
            }
        }

        $this->suggested = SQ_Classes_RemoteController::getKrFound();

    }

    function history() {

        $args = array();
        $args['limit'] = 100;
        $this->kr = SQ_Classes_RemoteController::getKRHistory($args);

    }


    /**
     * Called when action is triggered
     *
     * @return void
     */
    public function action() {
        parent::action();

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {

            case 'sq_briefcase_addkeyword':
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');

                    if (SQ_Classes_Helpers_Tools::isAjax()) {
                        echo json_encode($response);
                        exit();
                    } else {
                        SQ_Classes_Error::setError(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_));
                    }
                }

                SQ_Classes_Helpers_Tools::setHeader('json');
                $keyword = (string)SQ_Classes_Helpers_Tools::getValue('keyword', '');
                $do_serp = (int)SQ_Classes_Helpers_Tools::getValue('doserp', 0);
                $is_hidden = (int)SQ_Classes_Helpers_Tools::getValue('hidden', 0);

                if ($keyword <> '') {
                    //set ignore on API
                    $args = array();
                    $args['keyword'] = stripslashes($keyword);
                    $args['do_serp'] = $do_serp;
                    $args['is_hidden'] = $is_hidden;
                    SQ_Classes_RemoteController::addBriefcaseKeyword($args);

                    if (SQ_Classes_Helpers_Tools::isAjax()) {
                        if ($do_serp) {
                            echo json_encode(array('message' => __('Keyword Saved. The rank check will be ready in a minute.', _SQ_PLUGIN_NAME_)));
                        } else {
                            echo json_encode(array('message' => __('Keyword Saved!', _SQ_PLUGIN_NAME_)));
                        }
                        exit();
                    } else {
                        SQ_Classes_Error::setMessage(__('Keyword Saved!', _SQ_PLUGIN_NAME_));
                    }
                } else {
                    if (SQ_Classes_Helpers_Tools::isAjax()) {
                        echo json_encode(array('error' => __('Invalid params!', _SQ_PLUGIN_NAME_)));
                        exit();
                    } else {
                        SQ_Classes_Error::setError(__('Invalid params!', _SQ_PLUGIN_NAME_));
                    }
                }
                break;
            case 'sq_briefcase_deletekeyword':
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('json');
                $keyword = (string)SQ_Classes_Helpers_Tools::getValue('keyword', '');

                if ($keyword <> '') {
                    //set ignore on API
                    $args = array();
                    $args['keyword'] = stripslashes($keyword);
                    SQ_Classes_RemoteController::removeBriefcaseKeyword($args);

                    echo json_encode(array('message' => __('Deleted!', _SQ_PLUGIN_NAME_)));
                } else {
                    echo json_encode(array('error' => __('Invalid params!', _SQ_PLUGIN_NAME_)));
                }
                exit();
            case 'sq_briefcase_article':
                if (!current_user_can('sq_manage_snippets')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('json');

                $keyword = (string)SQ_Classes_Helpers_Tools::getValue('keyword', '');

                if ($keyword <> '') {
                    $args = array();

                    $args['keyword'] = stripslashes($keyword);
                    $articles = json_decode(SQ_Classes_RemoteController::apiCall('briefcase/articles', $args));

                    $rows = array();
                    if ($articles && !empty($articles)) {
                        foreach ($articles as $article) {
                            if ($post = get_post($article->id)) {
                                $link = SQ_Classes_Helpers_Tools::getAdminUrl('optimization?post=' . $post->ID);
                                $rows[] = '<tr>
                                            <td><span style="font-size: 15px; color: #333">' . $post->post_title . '</span></td>
                                            <td align="right">' . (int)$article->optimized . '%' . '</td>
                                            <td align="center">
                                                <button class="btn btn-default sq_research_selectit" onclick="location.href = \'' . $link . '\'">' . __('Edit', _SQ_PLUGIN_NAME_) . '</button>
                                            </td>
                                        </tr>';
                            } else {
                                $rows[] = '<tr>
                                            <td><span style="font-size: 11px; color: #aaa">' . __('Deleted Post', _SQ_PLUGIN_NAME_) . '</span></td>
                                            <td align="right"></td>
                                            <td align="right">' . (int)$article->optimized . '%' . '</td>
                                            <td></td>
                                        </tr>';
                            }
                        }

                        $table = sprintf('<table class="subtable">
                                            <tr>
                                                <th>' . __('Article title', _SQ_PLUGIN_NAME_) . '</th>
                                                <th style="width: 150px; text-align: right;">' . __('Optimized', _SQ_PLUGIN_NAME_) . '</th>
                                                <th style="width: 150px; text-align: center;">' . __('Option', _SQ_PLUGIN_NAME_) . '</th>
                                            </tr>
                                            %s
                                        </table>', join('', $rows));
                    } else {
                        $table = '<table class="subtable"><tr><td colspan="6" align="center" style="color: red">' . __('No articles found', _SQ_PLUGIN_NAME_) . '</td></tr></table>';
                    }


                    echo json_encode(array('articles' => $table));
                } else {
                    echo json_encode(array('error' => __('Invalid Keyword!', _SQ_PLUGIN_NAME_)));
                }
                exit();

            /**********************************/
            case 'sq_briefcase_addlabel':
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('json');

                $name = (string)SQ_Classes_Helpers_Tools::getValue('name', '');
                $color = (string)SQ_Classes_Helpers_Tools::getValue('color', '#ffffff');

                if ($name <> '' && $color <> '') {
                    $args = array();

                    $args['name'] = $name;
                    $args['color'] = $color;
                    $json = SQ_Classes_RemoteController::addBriefcaseLabel($args);

                    if (!is_wp_error($json)) {
                        echo json_encode(array('saved' => __('Saved!', _SQ_PLUGIN_NAME_)));
                    } else {
                        echo json_encode(array('error' => $json->get_error_message()));
                    }

                } else {
                    echo json_encode(array('error' => __('Invalid Label or Color!', _SQ_PLUGIN_NAME_)));
                }
                exit();
            case 'sq_briefcase_editlabel':
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('json');

                $id = (string)SQ_Classes_Helpers_Tools::getValue('id', 0);
                $name = (string)SQ_Classes_Helpers_Tools::getValue('name', 0);
                $color = (string)SQ_Classes_Helpers_Tools::getValue('color', '#ffffff');

                if ((int)$id > 0 && $name <> '' && $color <> '') {
                    $args = array();

                    $args['id'] = $id;
                    $args['name'] = $name;
                    $args['color'] = $color;
                    SQ_Classes_RemoteController::saveBriefcaseLabel($args);

                    echo json_encode(array('saved' => __('Saved!', _SQ_PLUGIN_NAME_)));
                } else {
                    echo json_encode(array('error' => __('Invalid params!', _SQ_PLUGIN_NAME_)));
                }
                exit();
            case 'sq_briefcase_deletelabel':
                if (!current_user_can('sq_manage_snippets')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('json');

                $id = (int)SQ_Classes_Helpers_Tools::getValue('id', 0);

                if ($id > 0) {
                    //set ignore on API
                    $args = array();

                    $args['id'] = $id;
                    SQ_Classes_RemoteController::removeBriefcaseLabel($args);

                    echo json_encode(array('deleted' => __('Deleted!', _SQ_PLUGIN_NAME_)));
                } else {
                    echo json_encode(array('error' => __('Invalid params!', _SQ_PLUGIN_NAME_)));
                }
                exit();
            case 'sq_briefcase_keywordlabel':
                if (!current_user_can('sq_manage_snippet')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('json');

                $keyword = (string)SQ_Classes_Helpers_Tools::getValue('keyword', '');
                $labels = SQ_Classes_Helpers_Tools::getValue('labels', array());

                if ($keyword <> '') {
                    $args = array();

                    $args['keyword'] = $keyword;
                    $args['labels'] = '';
                    if (is_array($labels) && !empty($labels)) {
                        $args['labels'] = join(',', $labels);
                        SQ_Classes_RemoteController::saveBriefcaseKeywordLabel($args);
                    } else {
                        SQ_Classes_RemoteController::saveBriefcaseKeywordLabel($args);

                    }
                    echo json_encode(array('saved' => __('Saved!', _SQ_PLUGIN_NAME_)));
                } else {
                    echo json_encode(array('error' => __('Invalid Keyword!', _SQ_PLUGIN_NAME_)));
                }
                exit();
            case 'sq_briefcase_backup':
                if (!current_user_can('sq_manage_settings')) {
                    SQ_Classes_Error::setError(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    return;
                }

                $briefcase = SQ_Classes_RemoteController::getBriefcase();

                $fp = fopen(_SQ_CACHE_DIR_ . 'file.csv', 'w');
                foreach ($briefcase->keywords as $row) {
                    fputcsv($fp, array($row->keyword), ',', '"');
                }
                fclose($fp);

                header('Content-type: text/csv');
                header("Content-Disposition: attachment; filename=squirrly-briefcase-" . gmdate('Y-m-d') . ".csv");
                header("Pragma: no-cache");
                header("Expires: 0");
                readfile(_SQ_CACHE_DIR_ . 'file.csv');

                exit();
            case 'sq_briefcase_restore':
                if (!current_user_can('sq_manage_settings')) {
                    SQ_Classes_Error::setError(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    return;
                }

                if (!empty($_FILES['sq_upload_file']) && $_FILES['sq_upload_file']['tmp_name'] <> '') {
                    $fp = fopen($_FILES['sq_upload_file']['tmp_name'], 'rb');

                    try {
                        $data = '';
                        $keywords = array();


                        while (($line = fgets($fp)) !== false) {
                            $data .= $line;
                        }
                        if (function_exists('base64_encode') && base64_decode($data) <> '') {
                            $data = @base64_decode($data);
                        }

                        if ($data = json_decode($data)) {
                            if (is_array($data) and !empty($data)) {
                                foreach ($data as $row) {
                                    if (isset($row->keyword)) {
                                        $keywords[] = $row->keyword;
                                    }
                                }
                            }
                        } else {
                            //Get the data from CSV
                            $fp = fopen($_FILES['sq_upload_file']['tmp_name'], 'rb');

                            while (($data = fgetcsv($fp, 1000, ";")) !== FALSE) {
                                if (!isset($data[0]) || $data[0] == '' || strlen($data[0]) > 255 || is_numeric($data[0])) {
                                    SQ_Classes_Error::setError(__('Error! The backup is not valid.', _SQ_PLUGIN_NAME_) . " <br /> ");
                                    break;
                                }

                                if (is_string($data[0]) && $data[0] <> '') {
                                    $keywords[] = strip_tags($data[0]);
                                }
                            }

                            if (empty($keywords)) {
                                $fp = fopen($_FILES['sq_upload_file']['tmp_name'], 'rb');

                                while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
                                    if (!isset($data[0]) || $data[0] == '' || strlen($data[0]) > 255 || is_numeric($data[0])) {
                                        SQ_Classes_Error::setError(__('Error! The backup is not valid.', _SQ_PLUGIN_NAME_) . " <br /> ");
                                        break;
                                    }

                                    $num = count($data);
                                    for ($c = 0; $c < $num; $c++) {
                                        if (is_string($data[$c]) && $data[$c] <> '') {
                                            $keywords[] = strip_tags($data[0]);
                                        }
                                    }
                                }
                            }


                        }

                        if (!empty($keywords)) {
                            foreach ($keywords as $keyword) {
                                if($keyword <> '') {
                                    SQ_Classes_RemoteController::addBriefcaseKeyword(array('keyword' => $keyword));
                                }
                            }

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
            /************************************************* AJAX */
            case 'sq_ajax_briefcase_doserp':
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('json');

                $json = array();
                $keyword = (string)SQ_Classes_Helpers_Tools::getValue('keyword', '');

                if ($keyword <> '') {
                    $args = array();
                    $args['keyword'] = stripslashes($keyword);
                    if (SQ_Classes_RemoteController::addSerpKeyword($args) === false) {
                        $json['error'] = SQ_Classes_Error::showNotices(__('Could not add the keyword to SERP Check. Please try again.', _SQ_PLUGIN_NAME_), 'sq_error');
                    } else {
                        $json['message'] = SQ_Classes_Error::showNotices(__('The keyword is added to SERP Check.', _SQ_PLUGIN_NAME_), 'sq_success');
                    }
                } else {
                    $json['error'] = SQ_Classes_Error::showNotices(__('Invalid parameters.', _SQ_PLUGIN_NAME_), 'sq_error');
                }

                SQ_Classes_Helpers_Tools::setHeader('json');
                echo json_encode($json);
                exit();
            case 'sq_ajax_research_others':
                SQ_Classes_Helpers_Tools::setHeader('json');
                $keyword = SQ_Classes_Helpers_Tools::getValue('keyword', false);
                $country = SQ_Classes_Helpers_Tools::getValue('country', 'com');
                $lang = SQ_Classes_Helpers_Tools::getValue('lang', 'en');

                if ($keyword) {
                    $args = array();
                    $args['keyword'] = $keyword;
                    $args['country'] = $country;
                    $args['lang'] = $lang;
                    $json = SQ_Classes_RemoteController::getKROthers($args);

                    if (!is_wp_error($json)) {
                        echo json_encode(array('keywords' => $json->keywords));
                    } else {
                        echo json_encode(array('error' => $json->get_error_message()));
                    }
                } else {
                    echo json_encode(array('error' => __('Invalid params!', _SQ_PLUGIN_NAME_)));
                }

                exit();
            case 'sq_ajax_research_process':
                @ini_set("max_execution_time", 300);

                SQ_Classes_Helpers_Tools::setHeader('json');
                $keywords = SQ_Classes_Helpers_Tools::getValue('keywords', false);
                $country = SQ_Classes_Helpers_Tools::getValue('country', 'com');
                $lang = SQ_Classes_Helpers_Tools::getValue('lang', 'en');

                if ($keywords) {
                    $args = array();
                    $args['q'] = $keywords;
                    $args['country'] = $country;
                    $args['lang'] = $lang;
                    $this->kr = SQ_Classes_RemoteController::getKRSuggestion($args);

                    if (!is_wp_error($this->kr)) {
                        //Get the briefcase keywords
                        if ($briefcase = SQ_Classes_RemoteController::getBriefcase()) {
                            if (!is_wp_error($briefcase)) {
                                if (isset($briefcase->keywords)) {
                                    $this->keywords = $briefcase->keywords;
                                }
                            }
                        }

                        $this->country = $country;
                        echo json_encode(array('html' => $this->getView('Research/ResearchDetails')));
                    } else {
                        $this->kr = array();
                        //show the keywords in results to be able to add them to brifcase
                        $keywords = explode(',', $keywords);
                        if (!empty($keywords)) {
                            foreach ($keywords as $keyword) {
                                $this->kr[] = json_decode(json_encode(array(
                                    'keyword' => $keyword,
                                )));
                            }
                            $this->country = $country;
                        }
                        echo json_encode(array('html' => $this->getView('Research/ResearchDetails')));

                    }
                } else {
                    echo json_encode(array('error' => __('Invalid params!', _SQ_PLUGIN_NAME_)));
                }
                exit();
            case 'sq_ajax_research_history':
                SQ_Classes_Helpers_Tools::setHeader('json');
                $id = (int)SQ_Classes_Helpers_Tools::getValue('id', 0);

                if ($id > 0) {
                    $args = array();
                    $args['id'] = $id;
                    $this->kr = SQ_Classes_RemoteController::getKRHistory($args);

                    //Get the briefcase keywords
                    if ($briefcase = SQ_Classes_RemoteController::getBriefcase()) {
                        if (!is_wp_error($briefcase)) {
                            if (isset($briefcase->keywords)) {
                                $this->keywords = $briefcase->keywords;
                            }
                        }
                    }

                    echo json_encode(array('html' => $this->getView('Research/HistoryDetails')));
                } else {
                    echo json_encode(array('error' => __('Invalid params!', _SQ_PLUGIN_NAME_)));
                }
                exit();

            case 'sq_ajax_briefcase_bulk_delete':
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('json');
                $keywords = SQ_Classes_Helpers_Tools::getValue('inputs', array());

                if (!empty($keywords)) {
                    foreach ($keywords as $keyword) {
                        //set ignore on API
                        $args = array();
                        $args['keyword'] = stripslashes($keyword);
                        SQ_Classes_RemoteController::removeBriefcaseKeyword($args);
                    }

                    echo json_encode(array('message' => __('Deleted!', _SQ_PLUGIN_NAME_)));
                } else {
                    echo json_encode(array('error' => __('Invalid params!', _SQ_PLUGIN_NAME_)));
                }
                exit();
            case 'sq_ajax_briefcase_bulk_label':
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('json');

                $keywords = SQ_Classes_Helpers_Tools::getValue('inputs', array());
                $labels = SQ_Classes_Helpers_Tools::getValue('labels', array());

                if (!empty($keywords)) {
                    foreach ($keywords as $keyword) {
                        $args = array();

                        $args['keyword'] = $keyword;
                        $args['labels'] = '';
                        if (is_array($labels) && !empty($labels)) {
                            $args['labels'] = join(',', $labels);
                            SQ_Classes_RemoteController::saveBriefcaseKeywordLabel($args);
                        } else {
                            SQ_Classes_RemoteController::saveBriefcaseKeywordLabel($args);

                        }
                    }

                    echo json_encode(array('message' => __('Saved!', _SQ_PLUGIN_NAME_)));
                } else {
                    echo json_encode(array('error' => __('Invalid Keyword!', _SQ_PLUGIN_NAME_)));
                }

                exit();
            case 'sq_ajax_briefcase_bulk_doserp':
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('json');

                $keywords = SQ_Classes_Helpers_Tools::getValue('inputs', array());

                if (!empty($keywords)) {
                    foreach ($keywords as $keyword) {
                        $args = array();
                        $args['keyword'] = stripslashes($keyword);
                        SQ_Classes_RemoteController::addSerpKeyword($args);

                    }

                    echo json_encode(array('message' => __('The keywords are added to SERP Check!', _SQ_PLUGIN_NAME_)));
                } else {
                    echo json_encode(array('error' => __('Invalid Keyword!', _SQ_PLUGIN_NAME_)));
                }
                exit();

            case 'sq_ajax_labels_bulk_delete':
                if (!current_user_can('sq_manage_settings')) {
                    $response['error'] = SQ_Classes_Error::showNotices(__("You do not have permission to perform this action", _SQ_PLUGIN_NAME_), 'sq_error');
                    SQ_Classes_Helpers_Tools::setHeader('json');
                    echo json_encode($response);
                    exit();
                }

                SQ_Classes_Helpers_Tools::setHeader('json');
                $inputs = SQ_Classes_Helpers_Tools::getValue('inputs', array());

                if (!empty($inputs)) {
                    foreach ($inputs as $id) {
                        if ($id > 0) {
                            $args = array();
                            $args['id'] = $id;
                            SQ_Classes_RemoteController::removeBriefcaseLabel($args);
                        }
                    }

                    echo json_encode(array('message' => __('Deleted!', _SQ_PLUGIN_NAME_)));
                } else {
                    echo json_encode(array('error' => __('Invalid params!', _SQ_PLUGIN_NAME_)));
                }
                exit();
        }


    }
}
