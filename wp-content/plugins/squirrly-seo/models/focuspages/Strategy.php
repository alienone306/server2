<?php

class SQ_Models_Focuspages_Strategy extends SQ_Models_Abstract_Assistant {

    protected $_category = 'strategy';

    protected $_keyword = false;
    protected $_optimization = false;
    protected $_briefcase = false;
    protected $_lsikeywords = false;
    protected $_labels = false;

    const OPTIMIZATION_MINVAL = 30;

    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }
        $this->_labels = 0;
        $this->_briefcase = 0;

        $briefcase = SQ_Classes_RemoteController::getBriefcaseStats();
        if (isset($briefcase->labels)) {
            $this->_labels = $briefcase->labels;
        }
        if (isset($briefcase->keywords)) {
            $this->_briefcase = $briefcase->keywords;
        }

        if (isset($this->_audit->data->sq_seo_keywords->value)) {
            $this->_keyword = $this->_audit->data->sq_seo_keywords->value;
        }

        if (isset($this->_audit->data->sq_seo_briefcase) && !empty($this->_audit->data->sq_seo_briefcase)) {
            foreach ($this->_audit->data->sq_seo_briefcase as $lsikeyword) {
                if ($lsikeyword->keyword <> $this->_keyword) {
                    $this->_lsikeywords[$lsikeyword->keyword] = $lsikeyword->optimized;
                }
            }
        }

        add_filter('sq_assistant_' . $this->_category . '_task_practice', array($this, 'getPractice'), 11, 2);
    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $lsikeywords = array();
        if ($this->_lsikeywords) {
            foreach ($this->_lsikeywords as $keyword => $optimized) {
                $lsikeywords[] = $keyword . ' (' . $optimized . '%)';
            }
        }

        $this->_tasks[$this->_category] = array(
            'briefcase' => array(
                'title' => __("Add keyword to Briefcase", _SQ_PLUGIN_NAME_),
                'value' => ($this->_briefcase ? $this->_briefcase : 0) . ' ' . __('keywords', _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("Go add a keyword to your Briefcase. %s The Briefcase is the command center for your SEO operations. Manage your keywords in briefcase, so that you'll always have quick access to them. You'll always know what your SEO Strategy is all about. %s Plus, adding keywords to Briefcase will make it very easy for you to collaborate with other people from your team, freelancers, agencies or partners. %s Never lose the amazing keywords you find through the Squirrly SEO Keyword Research tool.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'lsioptimization' => array(
                'title' => __("Add SEO Context", _SQ_PLUGIN_NAME_),
                'value' => (!empty($lsikeywords) ? join(', ', $lsikeywords) : ''),
                'penalty' => 5,
                'description' => sprintf(__("Optimize to %s for a secondary keyword. %s Squirrly SEO's Live Assistant allows you to optimize for multiple keywords that you have placed in your Briefcase. %s Use a couple of additional keywords for your Focus Page which help Google understand the exact topic and context of your page.  %s If you added the keywords 'political party' to 'black panther', you'd make a clear hint to Google that your page is about the Black Panther political party, not Black Panther, the Marvel Movie.  %s Or add 'places to eat' to a page about your Local Restaurant in San Diego. That will give clearer context to Google that your page really is about a restaurant where people can dine.", _SQ_PLUGIN_NAME_), self::OPTIMIZATION_MINVAL . '%', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),

            'labels' => array(
                'title' => __("Labels Exist", _SQ_PLUGIN_NAME_),
                'value' => ($this->_labels ? $this->_labels : 0) . ' ' . __('labels', _SQ_PLUGIN_NAME_),
                'description' => sprintf(__("To turn this task to green, go and add a label to the keyword that you've used as main keyword for this Focus Page. %s Make sure that you keep creating new labels as you're finding more keywords to target with your website. %s If you're unsure regarding keyword research, go to the Best Practices section of Focus Pages. %s Organize all the Keywords that you plan to use for your website with Briefcase Labels. %s This task helps you make sure that the main keyword for this Focus Page has been organized clearly inside your SEO Strategy. That's what Briefcase Labels are all about.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
        );
    }

    /*********************************************/
    /**
     * @param $content
     * @param $task
     * @return string
     */
    public function getHeader() {
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-1">' . __('Current URL', _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        $header .= '<li class="completed">';
        if ($this->_keyword) {
            $header .= '<div class="font-weight-bold text-black-50 mb-2 text-center">' . __('Keyword', _SQ_PLUGIN_NAME_) . ': ' . $this->_keyword . '</div>';
            $header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') . '" target="_blank" class="btn bg-primary text-white col-sm-8 offset-2 mt-3">' . __('Manage Strategy', _SQ_PLUGIN_NAME_) . '</a>';
        } else {
            if (isset($this->_post->ID)) {
                $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('post.php?post=' . (int)$this->_post->ID . '&action=edit');
                if ($this->_post->post_type <> 'profile') {
                    $edit_link = get_edit_post_link($this->_post->ID, false);
                }


                $header .= '<div class="font-weight-bold text-warning m-0  text-center">' . __('No Keyword Found', _SQ_PLUGIN_NAME_) . '</div>';
                $header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') . '" target="_blank" class="btn bg-primary text-white col-sm-8 offset-2 mt-3">' . __('Do a research', _SQ_PLUGIN_NAME_) . '</a>';
                if (isset($this->_post->ID)) {
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
     * API Briefcase Keyword Exists
     * @return bool|WP_Error
     */
    public function checkBriefcase($task) {
        if ($this->_briefcase) {
            $task['completed'] = ($this->_briefcase > 0);
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

    /**
     * API Briefcase LSI optimization
     * @return bool|WP_Error
     */
    public function checkLsioptimization($task) {
        if ($this->_lsikeywords) {
            foreach ($this->_lsikeywords as $keyword => $optimized) {
                if (($optimized >= self::OPTIMIZATION_MINVAL)) {
                    $task['completed'] = true;
                    return $task;
                }
            }

            $task['completed'] = false;
            return $task;
        }

        $task['error_message'] = __('Add a secondary keyword in Squirrly Live Assistant', _SQ_PLUGIN_NAME_);
        $task['error'] = true;
        return $task;
    }

    /**
     * API Briefcase Keyword label exists
     * @return bool|WP_Error
     */
    public function checkLabels($task) {
        if ($this->_labels) {
            $task['completed'] = ($this->_labels > 0);
            return $task;
        }

        $task['error'] = true;
        return $task;
    }

}