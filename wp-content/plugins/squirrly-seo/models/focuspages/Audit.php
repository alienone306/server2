<?php

class SQ_Models_Focuspages_Audit extends SQ_Models_Abstract_Assistant {

    protected $_category = 'audit';
    protected $_siteaudit = false;
    protected $_loading_time = false;

    const SCORE_MINVAL = 70;
    const SPEED_MAXVAL = 2;

    public function init() {
        if (isset($this->_audit->data)) {

            $this->_siteaudit = SQ_Classes_RemoteController::getSeoAudit();

            if (isset($this->_audit->data->sq_seo_meta->loading_time)) {
                $this->_loading_time = $this->_audit->data->sq_seo_meta->loading_time;
            }

        } else {
            $this->_error = true;
        }

        parent::init();

    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'score' => array(
                'title' => sprintf(__("Audit score is over %s", _SQ_PLUGIN_NAME_), self::SCORE_MINVAL . '%'),
                'value' => (isset($this->_siteaudit->score) ? $this->_siteaudit->score : 0) . '%',
                'penalty' => 5,
                'description' => sprintf(__("Even though we recommend getting an Audit score of 84 or above, a score of 70 will do. %s The Audit made by Squirrly takes a lot of things into account: blogging, SEO, social media, links, authority, traffic. All these aspects contribute directly or indirectly to the overall SEO of your site. %s Therefore, without a good score on your Audit it's quite probable for Google not to position your pages high enough, because overall your website is not doing good enough for it to be considered a priority. %s A page will not rank high if most of the website has low quality SEO and low marketing metrics.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'duplicatetitle' => array(
                'title' => __("No duplicate titles", _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("Make sure that you don't have duplicate titles across pages from your site. %s If you do, then use canonical links to point the duplicate pages towards the original. %s Otherwise, if it's too hard to customize too many titles at once, simply use the Patterns feature from Squirrly. You'll be able to define patterns, so that your titles will seem to be unique. %s WordPress -> Squirrly -> SEO Settings. There you will find the Patterns tab.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'duplicatedescription' => array(
                'title' => __("No duplicate description", _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("Make sure that your pages do not have duplicate descriptions. %s This is super easy to fix if you're using the Patterns feature from Squirrly SEO, because it will generate your META description automatically from the content of your page (in case you didn't already place a custom description). %s If you want to fix this problem by giving the problematic pages their own custom descriptions: go to the Squirrly SEO Audit and see which pages have this problem. %s Or use a tool like ContentLook to identify the pages and then place tasks for your self to fix those issues at a later time.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'title' => array(
                'title' => __("No empty titles", _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("Make sure that you do not have pages with empty titles. %s This means: pages where you haven't placed a meta title in your Snippet. %s Features like Patterns or Snippet from Squirrly SEO will help you easily fix this problem by either automating or customizing descriptions for your pages.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
            'description' => array(
                'title' => __("No empty descriptions", _SQ_PLUGIN_NAME_),

                'description' => sprintf(__("Make sure that you do not have pages with empty descriptions. %s This means: pages where you haven't placed a meta description. %s Features like Patterns or Snippet from Squirrly SEO will help you easily fix this problem by either automating or customizing descriptions for your pages.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
            'speed' => array(
                'title' => __("SEO speed", _SQ_PLUGIN_NAME_),
                'value' => ($this->_loading_time ? $this->_loading_time . ' ' . __('sec', _SQ_PLUGIN_NAME_) : ''),
                'description' => sprintf(__("You need to get good loading times for your pages. %s Good loading times will help you rank higher in Google, while pages that load very slowly will drag you down in search results.", _SQ_PLUGIN_NAME_), '<br /><br />'),
            ),
            'mobile' => array(
                'title' => __("Mobile-friendly", _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("Your website must be mobile friendly. %s It used to be an optional thing for Google until now, but it made it quite mandatory. %s Google prefers to display sites which are mobile friendly higher in search results, because most people search using mobile devices these days.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
        );


    }

    /*********************************************/
    /**
     * Show button in header to go to audit page
     * @return string
     */
    public function getHeader() {
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-1">' . __('Current URL', _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        if ($this->_siteaudit && isset($this->_siteaudit->score)) {
            $header .= '<li class="completed">
                    <a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('audits') . '" target="_blank" class="btn bg-primary text-white col-sm-8 offset-2 mt-3">' . __('Go to Audit', _SQ_PLUGIN_NAME_) . '</a>
                </li>';
        } else {
            $header .= '<li class="completed">
                    <div class="font-weight-bold text-warning text-center">' . __('Note! The audit is not ready yet', _SQ_PLUGIN_NAME_) . '</div>
                     <a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits') . '" target="_blank" class="btn bg-primary text-white col-sm-10 offset-1 mt-3">' . __('Request a new audit', _SQ_PLUGIN_NAME_) . '</a>
                    </li>';
        }

        return $header;
    }

    /**
     * API Audit sq_audit_queue
     * Check Audit Score
     * The score must be over SCORE_MINVAL value
     * @return bool|WP_Error
     */
    public function checkScore($task) {
        if ($this->_siteaudit && isset($this->_siteaudit->score)) {
            $task['completed'] = ((int)$this->_siteaudit->score >= self::SCORE_MINVAL);
            return $task;
        }

        $task['error'] = true;
        return $task;

    }

    /**
     * API Audit sq_audit_queue
     * Check duplicate titles in the audit for the verified pages
     * @return bool|WP_Error
     */
    public function checkDuplicatetitle($task) {
        if ($this->_siteaudit && isset($this->_siteaudit->duplicate_titles)) {
            if(isset($this->_siteaudit->duplicate_titles->value) && !empty($this->_siteaudit->duplicate_titles->value)) {
                $task['value'] = '<br />';
                foreach ($this->_siteaudit->duplicate_titles->value as $value){
                    if(isset($value->url)) {
                        $task['value'] .= __('URL', _SQ_PLUGIN_NAME_) . ': ' . $value->url . '<br />';
                    }
                }
            }
            $task['completed'] = (bool)$this->_siteaudit->duplicate_titles->complete;
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

    /**
     * API Audit sq_audit_queue
     * Check duplicate descriptions in the audit for the verified pages
     * @return bool|WP_Error
     */
    public function checkDuplicatedescription($task) {
        if ($this->_siteaudit && isset($this->_siteaudit->duplicate_descriptions)) {
            if(isset($this->_siteaudit->duplicate_descriptions->value) && !empty($this->_siteaudit->duplicate_descriptions->value)) {
                $task['value'] = '<br />';
                foreach ($this->_siteaudit->duplicate_descriptions->value as $value){
                    if(isset($value->url)) {
                        $task['value'] .= __('URL', _SQ_PLUGIN_NAME_) . ': ' . $value->url . '<br />';
                    }
                }
            }
            $task['completed'] = (bool)$this->_siteaudit->duplicate_descriptions->complete;
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

    /**
     * API Audit sq_audit_queue
     * Check empty titles in the audit for the verified pages
     * @return bool|WP_Error
     */
    public function checkTitle($task) {
        if ($this->_siteaudit && isset($this->_siteaudit->empty_titles)) {
            if(isset($this->_siteaudit->empty_titles->value) && !empty($this->_siteaudit->empty_titles->value)) {
                $task['value'] = '<br />';
                foreach ($this->_siteaudit->empty_titles->value as $value){
                    if(isset($value->url)) {
                        $task['value'] .= __('URL', _SQ_PLUGIN_NAME_) . ': ' . $value->url . '<br />';
                    }
                }
            }
            $task['completed'] = (bool)$this->_siteaudit->empty_titles->complete;
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

    /**
     * API Audit sq_audit_queue
     * Check empty descriptions in the audit for the verified pages
     * @return bool|WP_Error
     */
    public function checkDescription($task) {
        if ($this->_siteaudit && isset($this->_siteaudit->empty_descriptions)) {
            if(isset($this->_siteaudit->empty_descriptions->value) && !empty($this->_siteaudit->empty_descriptions->value)) {
                $task['value'] = '<br />';
                foreach ($this->_siteaudit->empty_descriptions->value as $value){
                    if(isset($value->url)) {
                        $task['value'] .= __('URL', _SQ_PLUGIN_NAME_) . ': ' . $value->url . '<br />';
                    }
                }
            }
            $task['completed'] = (bool)$this->_siteaudit->empty_descriptions->complete;
            return $task;
        }

        $task['error'] = true;
        return $task;

    }

    /**
     * API Audit sq_seo_meta
     * Check current page loading speed
     * @return bool|WP_Error
     */
    public function checkSpeed($task) {
        if (isset($this->_audit->data->sq_seo_meta->loading_time)) {
            $task['completed'] = ($this->_audit->data->sq_seo_meta->loading_time <= self::SPEED_MAXVAL);
            return $task;
        }

        $task['error'] = true;
        return $task;

    }

    /**
     * API Audit sq_seo_meta
     * Check if the page viewport exists
     * @return bool|WP_Error
     */
    public function checkMobile($task) {
        if (isset($this->_audit->data->sq_seo_meta->viewport)) {
            $task['completed'] = ($this->_audit->data->sq_seo_meta->viewport <> '');
            return $task;
        }

        $task['error'] = true;
        return $task;

    }
}