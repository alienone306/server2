<?php

/**
 * Keyword must be the live assistant. The last optimized keyword
 * Class SQ_Models_Focuspages_Keyword
 */
class SQ_Models_Focuspages_Keyword extends SQ_Models_Abstract_Assistant {

    protected $_category = 'keyword';

    protected $_keyword = false;
    protected $_competition = false;
    protected $_trend = false;
    protected $_volume = false;

    const COMPETITION_SCORE = 7;
    const IMPRESSIONS_MINVAL = 5;
    const TREND_SCORE = 5;


    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }

        if (isset($this->_audit->data->sq_seo_keywords->value)) {
            $this->_keyword = $this->_audit->data->sq_seo_keywords->value;
        }

        if (isset($this->_audit->data->sq_seo_keywords->research)) {
            $this->_competition = $this->_audit->data->sq_seo_keywords->research->sc;
            $this->_trend = $this->_audit->data->sq_seo_keywords->research->td;
            $this->_volume = $this->_audit->data->sq_seo_keywords->research->sv;
        }


        //add_filter('sq_assistant_' . $this->_category . '_task_practice', array($this, 'getPractice'), 11, 2);
    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'competition' => array(
                'title' => __("Keyword Competition", _SQ_PLUGIN_NAME_),
                'value' => ($this->_competition ? $this->_competition->text : false),
                'penalty' => 15,
                'description' => sprintf(__('To complete this task you must make sure that the main keyword you\'re optimizing this Focus Page for has low competition. %s The Squirrly SEO software suite uses our proprietary Market Intelligence feature to determine the chance that your site has of outranking the current TOP 10 of Google for the desired keyword you\'re targeting. %s If you really want to have a clear shot at ranking, make sure the competition is low for the keyword you choose.', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
            'impressions' => array(
                'title' => __("Search volume", _SQ_PLUGIN_NAME_),
                'value' => ($this->_volume ? $this->_volume->absolute : false),
                'description' => sprintf(__("To turn this task to green, go and find a keyword that has a good search volume. (meaning that many people search on Google for this keyword every single month). %s The Research features from Squirrly SEO will indicate if the volume is big enough. %s Since these are the most important pages on your website, you need to make sure that you get the maximum number of people possible to find this page. %s If you target keyword searches with low volumes, then you'll end up having just 2 or 3 people every month visiting this page. And then all the effort will have been for nothing.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'trend' => array(
                'title' => __("Google Trend", _SQ_PLUGIN_NAME_),
                'value' => ($this->_trend ? $this->_trend->text : false),
                'description' => sprintf(__("Trend levels required to get the Green Check on this task: %s - Steady %s - Going Up %s - Sky-rocketing %s we take the trend from the previous 3 months. %s If you target a search query with a bad trend you'll end up seeing little traffic to this page in the long run. %s Why ? A declining trend shows that Google Users are losing interest in that topic or keyword and will continue to do so in the future. %s Therefore, even though you could get much traffic right now after you rank this page, in the near future you'll get very little traffic even if you'd end up on Position 1 in Google Search.", _SQ_PLUGIN_NAME_), '<br />', '<br />', '<br />', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
//            'practice' => array(
//                'title' => __("Look at Best Practices", _SQ_PLUGIN_NAME_),
//                'description' => sprintf(__("%sGo to Focus Pages -> Best Practices%s Read the ideas for researching keywords. It will help you come up with winning keyword opportunities.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<br /><br />'),
//            ),
        );
    }

    /*********************************************/
    /**
     * API Keyword Detected
     * @return string
     */
    public function getHeader() {
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-1">' . __('Current URL', _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        $header .= '<li class="completed">';
        if ($this->_keyword) {
            if ($this->_competition && $this->_trend) {
                $header .= '<div class="font-weight-bold text-black-50 mb-2 text-center">' . __('Keyword', _SQ_PLUGIN_NAME_) . ': ' . $this->_keyword . '</div>';
                $header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') . '&keyword=' . htmlspecialchars($this->_keyword) . '" target="_blank" class="btn bg-primary text-white col-sm-8 offset-2 mt-3" >' . __('Find Better Keywords', _SQ_PLUGIN_NAME_) . '</a>';
            } else {
                $header .= '<div class="font-weight-bold text-black-50 mb-2 text-center">' . __('Keyword', _SQ_PLUGIN_NAME_) . ': ' . $this->_keyword . '</div>';
                $header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') . '&keyword=' . htmlspecialchars($this->_keyword) . '" target="_blank" class="btn bg-primary text-white col-sm-8 offset-2 mt-3">' . __('Do a research', _SQ_PLUGIN_NAME_) . '</a>';
            }
        } else {
            if (isset($this->_post->ID)) {
                $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('post.php?post=' . (int)$this->_post->ID . '&action=edit');
                if ($this->_post->post_type <> 'profile') {
                    $edit_link = get_edit_post_link($this->_post->ID, false);
                }


                $header .= '<div class="font-weight-bold text-warning m-0  text-center">' . __('No Keyword Found', _SQ_PLUGIN_NAME_) . '</div>';
                if (isset($this->_post->ID)) {
                    $header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') . '" target="_blank" class="btn bg-primary text-white col-sm-8 offset-2 mt-3">' . __('Do a research', _SQ_PLUGIN_NAME_) . '</a>';
                    $header .= '<a href="' . $edit_link . '" target="_blank" class="btn bg-primary text-white col-sm-10 offset-1 my-2">' . __('Optimize for a keyword', _SQ_PLUGIN_NAME_) . '</a>';
                }
            }
        }
        $header .= '</li>';

        return $header;
    }

    /**
     * Keyword optimization required
     * @param $title
     * @return string
     */
    public function getTitle($title) {
        parent::getTitle($title);

        if ($this->_error && !$this->_keyword) {
            $title = __("Optimize the page for a keyword", _SQ_PLUGIN_NAME_);
        }
        return $title;
    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkCompetition($task) {
        if ($this->_competition !== false) {
            $task['completed'] = ($this->_competition->value >= self::COMPETITION_SCORE);
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkImpressions($task) {
        if ($this->_volume !== false) {
            $task['completed'] = ($this->_volume->value >= self::IMPRESSIONS_MINVAL);
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkTrend($task) {
        if ($this->_trend !== false) {
            $task['completed'] = ($this->_trend->value >= self::TREND_SCORE);
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

}