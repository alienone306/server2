<?php

class SQ_Models_CheckSeo {

    public $html = false;

    public function getTasks() {
        $local_ip = @gethostbyname(gethostname());

        return array(
            'getSourceCode' => array(
                'valid' => false,
                'warning' => __("Could not verify the frontend", _SQ_PLUGIN_NAME_),
                'message' => __("To be able to check your website, you need to allow local crawling in your .htaccess file", _SQ_PLUGIN_NAME_),
                'solution' => sprintf(__("Run the test again. If you get the same error, check if you have added 'Deny %s' into your config file (e.g. htaccess)", _SQ_PLUGIN_NAME_), $local_ip),
            ),
            'getSeoSquirrlyTitle' => array(
                'valid' => false,
                'warning' => __("Squirrly SEO Title is not active for your website", _SQ_PLUGIN_NAME_),
                'message' => __("It's important to activate Squirrly SEO Title for your website if you don't use other SEO plugins", _SQ_PLUGIN_NAME_),
                'solution' => sprintf(__("Go to %sSquirrly > SEO Settings > Metas%s and switch on Meta Title", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>'),
            ),
            'getDuplicateOG' => array(
                'valid' => false,
                'warning' => __("You have duplicate Open Graph Meta tags", _SQ_PLUGIN_NAME_),
                'message' => sprintf(__('If you have duplicate OG tags, it means that some crawlers like %sFacebook Open Graph Object Debugger%s will raise an error and may not proceed with your request until you fix it.', _SQ_PLUGIN_NAME_), '<a href="https://developers.facebook.com/tools/debug/" target="_blank">', '</a>'),
                'solution' => __("If you are using multiple SEO plugins, then try to remove some of them and check again.", _SQ_PLUGIN_NAME_),
            ),
            'getDuplicateTC' => array(
                'valid' => false,
                'warning' => __("You have duplicate Twitter Card tags", _SQ_PLUGIN_NAME_),
                'message' => sprintf(__('If you have duplicate Twitter Card tags, it means that some crawlers like %sTwitter Validator%s will raise an error and may not proceed with your request until you fix it.', _SQ_PLUGIN_NAME_), '<a href="https://cards-dev.twitter.com/validator" target="_blank">', '</a>'),
                'solution' => __("If you are using multiple SEO plugins, then try to remove some of them and check again.", _SQ_PLUGIN_NAME_),
            ),
            'getNoTitle' => array(
                'valid' => false,
                'warning' => __("The Title meta tag is missing in frontend", _SQ_PLUGIN_NAME_),
                'message' => __("If you don't have Title meta tag in your website, it means that your website is not going to perform well on search engines.", _SQ_PLUGIN_NAME_),
                'solution' => sprintf(__("Go to %sSquirrly > SEO Settings > Metas%s and switch on Meta Title. If it's already switched on, check if another plugin is stopping Squirrly from showing the Title meta.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>'),
            ),
            'getDuplicateTitle' => array(
                'valid' => false,
                'warning' => __("You have duplicate Title meta tags", _SQ_PLUGIN_NAME_),
                'message' => __('If you have duplicate meta tags, it means that some crawlers may raise an error or process wrong data from your website until you fix it.', _SQ_PLUGIN_NAME_),
                'solution' => __("If you are using multiple SEO plugins, then try to remove some of them and check again.", _SQ_PLUGIN_NAME_),
            ),
            'getDuplicateDescription' => array(
                'valid' => false,
                'warning' => __("You have duplicate Description meta tags", _SQ_PLUGIN_NAME_),
                'message' => __('If you have duplicate meta tags, it means that some crawlers may raise an error or process wrong data from your website until you fix it.', _SQ_PLUGIN_NAME_),
                'solution' => __("If you are using multiple SEO plugins, then try to remove some of them and check again.", _SQ_PLUGIN_NAME_),
            ),
            'getPrivateBlog' => array(
                'valid' => false,
                'warning' => __("Your website is not public", _SQ_PLUGIN_NAME_),
                'message' => sprintf(__("You selected '%s' in Settings > Reading. It's important to uncheck that option.", _SQ_PLUGIN_NAME_), __('Discourage search engines from indexing this site')),
                'solution' => sprintf(__("Go to %sGeneral > Reading%s and uncheck %s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('options-reading.php') . '" >', '</a>', '<strong>' . __('Discourage search engines from indexing this site') . '</strong>'),
            ),
            'getBadLinkStructure' => array(
                'valid' => false,
                'warning' => __("Permalink structure is not good", _SQ_PLUGIN_NAME_),
                'message' => __("Your URLs (the links from your site) should be super easy to read. This makes your site Human-friendly as well.", _SQ_PLUGIN_NAME_),
                'solution' => sprintf(__("Make your LINKS SEO-Friendly. %s Settings > Permalinks %s That is where WordPress allows you to change the permalink structure.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('options-permalink.php') . '" >', '</a>'),
            ),
            'getDefaultTagline' => array(
                'valid' => false,
                'warning' => __("The default Tagline is still on", _SQ_PLUGIN_NAME_),
                'message' => __("Most of the pages will use the WordPress Tagline in Title and Description. Squirrly SEO uses the Tagline on {{sitedesc}} pattern for automation.", _SQ_PLUGIN_NAME_),
                'solution' => sprintf(__("Change the Tagline with your Brand or the Store name from %s", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('options-general.php') . '" >' . __('Settings') . ' > ' . __('General') . '</a>'),
            ),
            'getAMPWebsite' => array(
                'valid' => false,
                'warning' => __("AMP site detected and Squirrly AMP is off", _SQ_PLUGIN_NAME_),
                'message' => __("If this website is an AMP website you need to make sure that you activate Squirrly AMP Tracking for it. Squirrly will load Google Analytics and Facebook Pixel for AMP and avoid AMP script errors.", _SQ_PLUGIN_NAME_),
                'solution' => sprintf(__("Activate AMP tracking in %s Squirrly > SEO Settings > Tracking Tools%s ", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'tracking') . '" >', '</a>'),
            ),

        );
    }

    /**
     * Get the crawled HTML
     * @return bool
     */
    public function getHtml() {
        return $this->html;
    }

    /**
     * Process all the tasks and save the report
     * return void
     */
    public function checkSEO() {
        $report = array();

        if (!function_exists('preg_match_all')) {
            return false;
        }

        if (!$tasks_ignored = get_option('sq_seoreport_ignore')) {
            $tasks_ignored = array();
        }

        $tasks = $this->getTasks();
        foreach ($tasks as $function => $task) {
            if (!in_array($function, $tasks_ignored)) {
                if (method_exists($this, $function)) {
                    if ($result = @call_user_func(array($this, $function))) {
                        if (!$result['valid']) {
                            $report[$function] = $result;
                        }
                    }
                }
            }
        }


        update_option('sq_seoreport', $report);
        update_option('sq_seoreport_time', array('timestamp' => current_time('timestamp', 1)));
    }

    /**
     * Get the homepage source code
     * @return array
     */
    public function getSourceCode() {
        $url = home_url('?rnd=' . rand());

        $json = SQ_Classes_ObjController::getClass('SQ_Classes_RemoteController')->crawlURL(array('url' => $url));

        if (!is_wp_error($json)) {
            if (isset($json->content) && $json->content <> '') {
                $this->html = $json->content;
            } else {
                $this->html = false;
            }
        }

        return array(
            'warning' => __("Could not verify the frontend.", _SQ_PLUGIN_NAME_),
            'valid' => true
        );
    }


    /**
     * Check the common metas
     * @return array|bool
     */
    public function checkMetas() {
        $metas = array(
            'title' => false,
            'description' => false,
            'og' => false,
            'tc' => false,
            'viewport' => false,
            'canonical' => false
        );
        //check if the crawl was made with success
        if (!$this->html) return false;

        //check open graph
        preg_match_all("/<meta[\s+]property=[\"|\']og:url[\"|\'][\s+](content|value)=[\"|\']([^>]*)[\"|\'][^>]*>/i", $this->html, $out);
        if (!empty($out) && isset($out[0]) && is_array($out[0])) {
            if ((sizeof($out[0]) >= 1)) {
                $metas['og'] = true;
            }
        }

        //check twitter card
        preg_match_all("/<meta[\s+]property=[\"|\']twitter:url[\"|\'][\s+](content|value)=[\"|\']([^>]*)[\"|\'][^>]*>/i", $this->html, $out);
        if (!empty($out) && isset($out[0]) && is_array($out[0])) {
            if ((sizeof($out[0]) >= 1)) {
                $metas['tc'] = true;
            }
        }

        //check title
        preg_match_all("/<title[^>]*>(.*)?<\/title>/i", $this->html, $out);
        if (!empty($out) && isset($out[0]) && is_array($out[0])) {
            if ((sizeof($out[0]) >= 1)) {
                $metas['title'] = true;
            }
        }

        preg_match_all("/<meta[^>]*name=[\"|\']title[\"|\'][^>]*content=[\"|\']([^>\"]*)[\"|\'][^>]*>/i", $this->html, $out);
        if (!empty($out) && isset($out[0]) && is_array($out[0])) {
            if ((sizeof($out[0]) >= 1)) {
                $metas['title'] = true;
            }
        }

        //check description
        preg_match_all("/<meta[^>]*name=[\"|\']description[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i", $this->html, $out);
        if (!empty($out) && isset($out[0]) && is_array($out[0])) {
            if ((sizeof($out[0]) >= 1)) {
                $metas['description'] = true;
            }
        }

        preg_match_all("/<meta[^>]*content=[\"]([^\"]*)[\"][^>]*name=[\"|\']description[\"|\'][^>]*>/i", $this->html, $out);
        if (!empty($out) && isset($out[0]) && is_array($out[0])) {
            if ((sizeof($out[0]) >= 1)) {
                $metas['description'] = true;
            }
        }

        //check viewport
        preg_match_all("/<meta[^>]*name=[\"|\']viewport[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i", $this->html, $out);
        if (!empty($out) && isset($out[0]) && is_array($out[0])) {
            if ((sizeof($out[0]) >= 1)) {
                $metas['viewport'] = true;
            }
        }

        preg_match_all("/<meta[^>]*content=[\"]([^\"]*)[\"][^>]*name=[\"|\']viewport[\"|\'][^>]*>/i", $this->html, $out);
        if (!empty($out) && isset($out[0]) && is_array($out[0])) {
            if ((sizeof($out[0]) >= 1)) {
                $metas['viewport'] = true;
            }
        }

        //check canonical
        preg_match_all("/<link[^>]*rel=[\"|\']canonical[\"|\'][^>]*href=[\"]([^\"]*)[\"][^>]*>/i", $this->html, $out);
        if (!empty($out) && isset($out[0]) && is_array($out[0])) {
            if ((sizeof($out[0]) >= 1)) {
                $metas['canonical'] = true;
            }
        }

        preg_match_all("/<link[^>]*href=[\"]([^\"]*)[\"][^>]*rel=[\"|\']canonical[\"|\'][^>]*>/i", $this->html, $out);
        if (!empty($out) && isset($out[0]) && is_array($out[0])) {
            if ((sizeof($out[0]) >= 1)) {
                $metas['canonical'] = true;
            }
        }

        return $metas;

    }

    /**
     * Check if the automatically seo si active
     * @return array
     */
    public function getSeoSquirrlyTitle() {
        return array(
            'name' => 'sq_auto_title',
            'value' => 1,
            'valid' => SQ_Classes_Helpers_Tools::getOption('sq_auto_title'),
        );
    }

    /**
     * Check for META duplicates
     * @return array|false
     */
    public function getDuplicateOG() {
        $valid = true;

        //check if the crawl was made with success
        if (!$this->html) {
            return array(
                'valid' => true
            );
        }

        if ($this->html <> '') {
            preg_match_all("/<meta[\s+]property=[\"|\']og:url[\"|\'][\s+](content|value)=[\"|\']([^>]*)[\"|\'][^>]*>/i", $this->html, $out);
            if (!empty($out) && isset($out[0]) && is_array($out[0])) {
                if ((sizeof($out[0]) > 1)) {
                    $valid = false;
                }

            }
        }

        return array(
            'valid' => $valid
        );
    }

    /**
     * Check for META duplicates
     * @return array|false
     */
    public function getDuplicateTC() {
        $valid = true;

        //check if the crawl was made with success
        if (!$this->html) {
            return array(
                'valid' => true
            );
        }

        if ($this->html <> '') {
            preg_match_all("/<meta[\s+]name=[\"|\']twitter:card[\"|\'][\s+](content|value)=[\"|\']([^>]*)[\"|\'][^>]*>/i", $this->html, $out);
            if (!empty($out) && isset($out[0]) && is_array($out[0])) {
                if ((sizeof($out[0]) > 1)) {
                    $valid = false;
                }
            }
        }

        return array(
            'valid' => $valid
        );
    }

    /**
     * Check for META duplicates
     * @return array|false
     */
    public function getDuplicateTitle() {
        $valid = true;
        $total = 0;

        //check if the crawl was made with success
        if (!$this->html) {
            return array(
                'valid' => true
            );
        }

        if ($this->html <> '') {
            preg_match_all("/<title[^>]*>(.*)?<\/title>/i", $this->html, $out);

            if (!empty($out) && isset($out[0]) && is_array($out[0])) {
                $total += sizeof($out[0]);
            }

            preg_match_all("/<meta[^>]*name=[\"|\']title[\"|\'][^>]*content=[\"|\']([^>\"]*)[\"|\'][^>]*>/i", $this->html, $out);
            if (!empty($out) && isset($out[0]) && is_array($out[0])) {
                $total += sizeof($out[0]);
            }
        }

        if ($total > 1) {
            $valid = false;
        }

        return array(
            'valid' => $valid
        );
    }

    /**
     * Check if not Title META
     * @return array|bool
     */
    public function getNoTitle() {
        $valid = true;
        $total = 0;

        //check if the crawl was made with success
        if (!$this->html) {
            return array(
                'valid' => true
            );
        }

        if ($this->html <> '') {
            preg_match_all("/<title[^>]*>(.*)?<\/title>/i", $this->html, $out);

            if (!empty($out) && isset($out[0]) && is_array($out[0])) {
                $total += sizeof($out[0]);
            }

            preg_match_all("/<meta[^>]*name=[\"|\']title[\"|\'][^>]*content=[\"|\']([^>\"]*)[\"|\'][^>]*>/i", $this->html, $out);
            if (!empty($out) && isset($out[0]) && is_array($out[0])) {
                $total += sizeof($out[0]);
            }
        }

        if ($total == 0) {
            $valid = false;
        }

        return array(
            'valid' => $valid
        );
    }

    /**
     * Check for META duplicates
     * @return array|false
     */
    public function getDuplicateDescription() {
        $valid = true;
        $total = 0;

        //check if the crawl was made with success
        if (!$this->html) {
            return array(
                'valid' => true
            );
        }

        if ($this->html <> '') {
            preg_match_all("/<meta[^>]*name=[\"|\']description[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i", $this->html, $out);
            if (!empty($out) && isset($out[0]) && is_array($out[0])) {
                $total += sizeof($out[0]);
            }

            preg_match_all("/<meta[^>]*content=[\"]([^\"]*)[\"][^>]*name=[\"|\']description[\"|\'][^>]*>/i", $this->html, $out);
            if (!empty($out) && isset($out[0]) && is_array($out[0])) {
                $total += sizeof($out[0]);
            }
        }

        if ($total > 1) {
            $valid = false;
        }

        return array(
            'valid' => $valid
        );
    }

    /**
     * Check if the blog is in private mode
     * @return array
     */
    public static function getPrivateBlog() {
        return array(
            'valid' => ((int)get_option('blog_public') == 1)
        );
    }

    /**
     * Check if the blog has a bad link structure
     * @return array
     */
    public function getBadLinkStructure() {
        return array(
            'valid' => (get_option('permalink_structure'))
        );
    }

    public function getDefaultTagline() {
        $blog_description = get_bloginfo('description');
        $default_blog_description = 'Just another WordPress site';
        $translated_blog_description = __('Just another WordPress site');
        return array(
            'valid' => !($translated_blog_description === $blog_description && $default_blog_description === $blog_description)
        );
    }

    public function getAMPWebsite() {
        $valid = true;
        if (function_exists('is_amp_endpoint') && is_amp_endpoint()) {
            if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_amp')) {
                $valid = false;
            }
        }

        if (function_exists('is_amp') && is_amp()) {
            if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_amp')) {
                $valid = false;
            }
        }

        return array(
            'name' => 'sq_auto_amp',
            'value' => 1,
            'valid' => $valid
        );
    }

    public function getMobileFriendly() {
        //check if mobile friends meta
    }
}