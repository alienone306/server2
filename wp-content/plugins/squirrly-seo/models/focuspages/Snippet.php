<?php

class SQ_Models_Focuspages_Snippet extends SQ_Models_Abstract_Assistant {

    protected $_category = 'snippet';

    protected $_keyword = false;
    protected $_title = false;
    protected $_description = false;
    protected $_keyword_in_title = false;
    protected $_keyword_in_description = false;
    protected $_open_graph = false;
    protected $_twitter_card = false;
    protected $_json = false;
    protected $_customized = false;

    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }

        if (isset($this->_audit->data->sq_seo_keywords->value)) {
            $this->_keyword = $this->_audit->data->sq_seo_keywords->value;
        }

        if (isset($this->_audit->data->sq_seo_open_graph->value) && $this->_audit->data->sq_seo_open_graph->value <> '') {
            $this->_open_graph = json_decode($this->_audit->data->sq_seo_open_graph->value);
        }

        if (isset($this->_audit->data->sq_seo_twittercard->value) && $this->_audit->data->sq_seo_twittercard->value <> '') {
            $this->_twitter_card = json_decode($this->_audit->data->sq_seo_twittercard->value);
        }

        if (isset($this->_audit->data->sq_seo_jsonld->value) && $this->_audit->data->sq_seo_jsonld->value <> '') {
            $this->_json = json_decode($this->_audit->data->sq_seo_jsonld->value, true);
        }

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            if (isset($this->_post->sq->title) && $this->_post->sq->title <> '') {
                $this->_title = $this->_post->sq->title;
            }
            if (isset($this->_post->sq->description) && $this->_post->sq->description <> '') {
                $this->_description = $this->_post->sq->description;
            }

            if ($this->_title && $this->_keyword) {
                $this->_keyword_in_title = (stripos($this->_post->sq->title, $this->_keyword) !== false);
            }

            if ($this->_description && $this->_keyword) {
                $this->_keyword_in_description = (stripos($this->_post->sq->description, $this->_keyword) !== false);
            }

            if (isset($this->_post->sq_adm->title) && $this->_post->sq_adm->title <> '') {
                $this->_customized = true;
            }
        }

    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'title' => array(
                'title' => __("Title", _SQ_PLUGIN_NAME_),
                'value' => $this->_title,
                'penalty' => 5,
                'description' => sprintf(__('To turn this task to green, go and define a title for this page. You can easily do this by using the Snippet from Squirrly SEO. %s Make sure that you have a Title defined for your Focus Page. %s Not having a title defined is bad for both search engines and Humans. %s Why? %s It\'s weird for someone to try to figure out if they landed on your Pricing page, and not get a clear answer. If you have multiple pricing pages (in case your site displays multiple products) then your title should only contain the brand name of that product.', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'description' => array(
                'title' => __("Description", _SQ_PLUGIN_NAME_),
                'value' => $this->_description,
                'description' => sprintf(__('To turn this task to green, go and define a Meta description for this page. You can easily do this by using the Snippet from Squirrly SEO. %s Make sure that you have a META description set up for this Focus Page. %s The meta description is very important for showing others the value they can find by clicking to go to your page. %s Think of it as an awesome ad that gets people excited enough that they visit your page after reading it. %s Sometimes, Google displays the exact META description that you create inside the search result pages. Use great descriptions for pages on your site to boost CTR (click-through rates).', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'keywordtitle' => array(
                'title' => __("Keyword in title", _SQ_PLUGIN_NAME_),
                'penalty' => 5,
                'description' => sprintf(__('Your keyword must be present in the title of the page. %s It\'s a very important element through which you make sure that you connect the searcher\'s intent to the content on your page. %s If I\'m looking for "buy cheap smartwatch" and you give me a page called "Luna Presentation", I will never click your page. Why? Because I might not know that Luna is a smartwatch designed by VectorWatch. %s "Buy Cheap Smartwatch - Luna by VectorWatch" would be a much better choice for a title.', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'keyworddescription' => array(
                'title' => __("Keyword in description", _SQ_PLUGIN_NAME_),
                'description' => sprintf(__('Same as with the title task. %s If a user reads the description of your page on Google, but cannot find the keyword they searched for in that text, then they\'d have very low chances of actually clicking and visiting your page. %s They\'d go to the next page ranked on Google for that keyword. %s Think about this: Google itself is trying more and more to display keywords in the description of the pages it bring to TOP 10. It\'s pretty clear they care a lot about this, because that\'s what people want to find on the search engine.', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'ogdetails' => array(
                'title' => __("Open Graph - full definition", _SQ_PLUGIN_NAME_),
                'penalty' => 1,
                'description' => sprintf(__('To turn this task to green, you can easily use the Snippet from Squirrly SEO to get all the definitions in place. %s With this task, we make sure that you have the full Open Graph definitions created for this Focus Page. %s There are many things which could interfere with the code, there are times when you could forget setting some of the elements up, so Squirrly SEO helps you make sure that ALL the og tags are present. %s And yes, this is relevant for your search engine position placements.', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'tcdetails' => array(
                'title' => __("Twitter Cards - full definition", _SQ_PLUGIN_NAME_),
                'penalty' => 1,
                'description' => sprintf(__('To turn this task to green, you can easily use the Snippet from Squirrly SEO to get all the definitions in place. %s Checking to make sure that your Twitter Cards definitions are made properly. %s Same as with the Open Graph task, Squirrly SEO makes sure to check for all the required definitions, so that you won\'t miss a beat.', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
            'jsondetails' => array(
                'title' => __("JSON-LD definition", _SQ_PLUGIN_NAME_),
                'description' => sprintf(__('To turn this task to green, you can easily use the JSON-LD section inside Squirrly -> SEO Settings. %s Make sure that you complete all fields with the proper information. %s This gives important Semantic context to Google and it plays a role in determining how high your page should be placed in search rankings. %s You can validate your existing JSON-LD with: %shttps://search.google.com/structured-data/testing-tool%s', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />', '<a href="https://search.google.com/structured-data/testing-tool" target="_blank">', '</a>'),
            ),
            'customization' => array(
                'title' => __("Customized", _SQ_PLUGIN_NAME_),
                'description' => sprintf(__('The Snippets of your most important pages should be customized. %s Use the Snippet from Squirrly SEO to customize the meta settings, the open graph, etc. for this page. %s Since Focus Pages are the most important pages on your site, you\'ll want people to love the search engine listings that you build for this page. %s Therefore, you should define a custom SEO listing to improve the number of clicks you get when people DO find your page on search engines. %s NOTE: sometimes Google tries to create automated snippets and display those, but it\'s just an experiment they run. Most of the times, your own custom snippet will be the one that gets displayed.', _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
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
        $edit_link = '';
        if (isset($this->_post->ID)) {
            $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'bulkseo') . '&sid=' . $this->_post->ID . '&stype=' . $this->_post->post_type;
        }

        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-1">' . __('Current URL', _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        $header .= '<li class="completed">';
        if ($this->_keyword) {
            $header .= '<div class="font-weight-bold text-black-50 mb-2 text-center">' . __('Keyword', _SQ_PLUGIN_NAME_) . ': ' . $this->_keyword . '</div>';
        } else {
            $header .= '<div class="font-weight-bold text-warning m-0 text-center">' . __('No Keyword Found', _SQ_PLUGIN_NAME_) . '</div>';
        }
        if (isset($this->_post->ID)) {
            $header .= '<a href="' . $edit_link . '" target="_blank" class="btn bg-primary text-white col-sm-8 offset-2 mt-3">' . __('Edit your snippet', _SQ_PLUGIN_NAME_) . '</a>';
        }
        $header .= '</li>';

        return $header;
    }


    /**
     * Check if Title Meta is set | API Title
     * @return bool
     */
    public function checkTitle($task) {
        $task['completed'] = ($this->_title <> '');
        return $task;
    }

    /**
     * Check if Description Meta is set | API Description
     * @return bool
     */
    public function checkDescription($task) {
        $task['completed'] = ($this->_description <> '');
        return $task;
    }

    /**
     * Check if Keyword in Title is set | API Keyword in Title
     * @return bool
     */
    public function checkKeywordtitle($task) {
        $task['completed'] = $this->_keyword_in_title;
        return $task;
    }

    /**
     * Check if Keyword in Description is set | API Keyword in Title
     * @return bool
     */
    public function checkKeyworddescription($task) {
        $task['completed'] = $this->_keyword_in_description;
        return $task;
    }

    /**
     * Check if Open Graph integrity | API Open Graph integrity
     * @return bool
     */
    public function checkOgdetails($task) {
        if ($this->_open_graph) {
            $task['value'] = '<br />' .
                '<span style="font-weight: normal">' . __("Title", _SQ_PLUGIN_NAME_) . '</span>: <br />' . ($this->_open_graph->title <> '' ? $this->_open_graph->title . '<br /><br />' : '') .
                '<span style="font-weight: normal">' . __("Description", _SQ_PLUGIN_NAME_) . '</span>: <br />' . ($this->_open_graph->description <> '' ? $this->_open_graph->description . '<br /><br />' : '') .
                '<span style="font-weight: normal">' . __("Image", _SQ_PLUGIN_NAME_) . '</span>: <br />' . ($this->_open_graph->image <> '' ? $this->_open_graph->image . '<br /><br />' : '');

            $task['completed'] = (isset($this->_open_graph->title) && $this->_open_graph->title <> '' &&
                isset($this->_open_graph->description) && $this->_open_graph->description <> '' &&
                isset($this->_open_graph->image) && $this->_open_graph->image <> ''
            );

            return $task;
        }
        $task['completed'] = false;
        return $task;
    }

    /**
     * Check if Twitter Card integrity | API Twitter Card integrity
     * @return bool
     */
    public function checkTcdetails($task) {
        if ($this->_twitter_card) {
            $task['value'] = '<br />' .
                '<span style="font-weight: normal">' . __("Title", _SQ_PLUGIN_NAME_) . '</span>: <br />' . ($this->_twitter_card->title <> '' ? $this->_twitter_card->title . '<br /><br />' : '') .
                '<span style="font-weight: normal">' . __("Description", _SQ_PLUGIN_NAME_) . '</span>: <br />' . ($this->_twitter_card->description <> '' ? $this->_twitter_card->description . '<br /><br />' : '') .
                '<span style="font-weight: normal">' . __("Image", _SQ_PLUGIN_NAME_) . '</span>: <br />' . ($this->_twitter_card->image <> '' ? $this->_twitter_card->image . '<br /><br />' : '');

            $task['completed'] = (isset($this->_twitter_card->title) && $this->_twitter_card->title <> '' &&
                isset($this->_twitter_card->description) && $this->_twitter_card->description <> '' &&
                isset($this->_twitter_card->image) && $this->_twitter_card->image <> ''
            );
            return $task;
        }

        $task['completed'] = false;
        return $task;
    }

    /**
     * Check if JsonLD is set | API JsonLD
     * @return bool
     */
    public function checkJsondetails($task) {
        if ($this->_json && !empty($this->_json)) {
            foreach ($this->_json as $json) {
                if (isset($json["@graph"]) && !empty($json["@graph"])) {
                    foreach ($json["@graph"] as $graph) {
                        if (isset($graph["@type"]) && $graph["@type"] <> '' && isset($graph["@context"]) && $graph["@context"] <> '') {
                            $task['completed'] = true;
                            return $task;
                        }
                    }
                }
            }

        }

        $task['completed'] = false;
        return $task;
    }

    /**
     * Check if Squirrly snippet is manually customized
     * @return bool
     */
    public function checkCustomization($task) {
        $task['completed'] = $this->_customized;
        return $task;
    }
}