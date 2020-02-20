<?php

class SQ_Models_Snippet {

    public $post;

    public function saveSEO() {
        $json = array();
        if (SQ_Classes_Helpers_Tools::getIsset('sq_hash')) {
            $sq_hash = SQ_Classes_Helpers_Tools::getValue('sq_hash', '');
            $post_id = SQ_Classes_Helpers_Tools::getValue('post_id', 0);

            if (!current_user_can('sq_manage_snippets')) {
                if (!current_user_can('edit_post', $post_id)) {
                    $json['error'] = 1;
                    $json['error_message'] = __("You don't have enough pemission to edit this article", _SQ_PLUGIN_NAME_);
                    exit();
                }
            }

            $url = SQ_Classes_Helpers_Tools::getValue('sq_url', '');

            $sq = SQ_Classes_ObjController::getClass('SQ_Models_Qss')->getSqSeo($sq_hash);

            $sq->doseo = SQ_Classes_Helpers_Tools::getValue('sq_doseo', 0);

            $sq->title = SQ_Classes_Helpers_Tools::getValue('sq_title', '');
            $sq->description = SQ_Classes_Helpers_Tools::getValue('sq_description', '');
            $sq->keywords = SQ_Classes_Helpers_Tools::getValue('sq_keywords', '');
            $sq->canonical = SQ_Classes_Helpers_Tools::getValue('sq_canonical', '');
            if (SQ_Classes_Helpers_Tools::getIsset('sq_noindex')) $sq->noindex = SQ_Classes_Helpers_Tools::getValue('sq_noindex', 0);
            if (SQ_Classes_Helpers_Tools::getIsset('sq_nofollow')) $sq->nofollow = SQ_Classes_Helpers_Tools::getValue('sq_nofollow', 0);
            if (SQ_Classes_Helpers_Tools::getIsset('sq_nositemap')) $sq->nositemap = SQ_Classes_Helpers_Tools::getValue('sq_nositemap', 0);

            $sq->og_title = SQ_Classes_Helpers_Tools::getValue('sq_og_title', '');
            $sq->og_description = SQ_Classes_Helpers_Tools::getValue('sq_og_description', '');
            $sq->og_author = SQ_Classes_Helpers_Tools::getValue('sq_og_author', '');
            $sq->og_type = SQ_Classes_Helpers_Tools::getValue('sq_og_type', '');
            $sq->og_media = SQ_Classes_Helpers_Tools::getValue('sq_og_media', '');

            $sq->tw_title = SQ_Classes_Helpers_Tools::getValue('sq_tw_title', '');
            $sq->tw_description = SQ_Classes_Helpers_Tools::getValue('sq_tw_description', '');
            $sq->tw_media = SQ_Classes_Helpers_Tools::getValue('sq_tw_media', '');
            $sq->tw_type = SQ_Classes_Helpers_Tools::getValue('sq_tw_type', '');

            //Sanitize Emoticons
            $sq->title = wp_encode_emoji($sq->title);
            $sq->description = wp_encode_emoji($sq->description);
            $sq->og_title = wp_encode_emoji($sq->og_title);
            $sq->og_description = wp_encode_emoji($sq->og_description);
            $sq->tw_title = wp_encode_emoji($sq->tw_title);
            $sq->tw_description = wp_encode_emoji($sq->tw_description);

            if (SQ_Classes_Helpers_Tools::getValue('sq_jsonld_code_type', 'auto') == 'custom') {
                if (isset($_POST['sq_jsonld'])) {
                    $allowed_html = array(
                        'script' => array('type' => array()),
                    );
                    $sq->jsonld = strip_tags(wp_unslash(trim(wp_kses($_POST['sq_jsonld'], $allowed_html))));
                }
            } else {
                $sq->jsonld = '';
            }

            if (SQ_Classes_Helpers_Tools::getValue('sq_fpixel_code_type', 'auto') == 'custom') {
                if (isset($_POST['sq_fpixel'])) {
                    $allowed_html = array(
                        'script' => array(),
                        'noscript' => array(),
                    );
                    $sq->fpixel = wp_unslash(trim(wp_kses($_POST['sq_fpixel'], $allowed_html)));
                }
            } else {
                $sq->fpixel = '';
            }

            //Prevent broken url in canonical link
            if (strpos($sq->canonical, '//') === false) {
                $sq->canonical = '';
            }

            if (SQ_Classes_ObjController::getClass('SQ_Models_Qss')->saveSqSEO(
                $url,
                $sq_hash,
                (int)$post_id,
                maybe_serialize($sq->toArray()),
                gmdate('Y-m-d H:i:s')
            )
            ) {
                return true;
            } else {
                SQ_Classes_ObjController::getClass('SQ_Models_Qss')->createTable();
                return false;
            };

        } else {
            return false;
        }

        return $json;
    }

    public function getCurrentSnippet($post_id, $term_id, $taxonomy, $post_type) {

        if ($post_type == 'home') {
            return $this->setHomePage();
        } elseif ($post_type == 'profile') {
            return $this->setAuthorPage($post_id);
        } elseif ($post_id > 0) {
            $post = $this->setPostByID($post_id);
            $this->getMultilangPage($post);
            return $post;
        } elseif ($term_id > 0 && $taxonomy <> '') {
            if ($post = $this->setPostByTaxID($term_id, $taxonomy)) {
                if (get_term_link($term_id, $taxonomy) == $post->url) {
                    $this->getMultilangPage($post);

                    return $post;
                }
            }
        } elseif ($post_type <> '') {
            $post = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Post');
            $post->post_type = $post_type;
            $post->hash = md5($post_type);
            $post->url = get_post_type_archive_link($post_type);

            if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->setPost($post)->getPost()) {
                return $post;
            }
        } else {
            SQ_Classes_Error::setError(__("Couldn't find the page", _SQ_PLUGIN_NAME_));
        }

        return false;
    }

    public function getMultilangPage(&$post) {
        global $polylang, $wp_query;

        if (function_exists('pll_default_language')) {
            $language = pll_default_language();
            if (isset($polylang) && function_exists('pll_get_term')) {
                if (($post->post_type == 'category' || $post->post_type == 'tag') && $post->term_id > 0) {
                    SQ_Debug::dump(pll_get_term($post->term_id, $language));
                    if (!pll_get_term($post->term_id, $language)) {
                        SQ_Classes_Error::setError(__('No Polylang translation for this post.', _SQ_PLUGIN_NAME_));

                        $wp_query->is_404 = true;
                        $post->post_type = '404';
                        $post->hash = md5($post->post_type);
                        $post->sq = $post->sq_adm = null;
                        $post = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->setPost($post)->getPost();
                        SQ_Debug::dump($post);
                    }
                } elseif ($post->ID > 0) {
                    //SQ_Debug::dump(pll_get_post($post->ID, $language));
                    if (!pll_get_post($post->ID, $language)) {
                        SQ_Classes_Error::setError(__('No Polylang translation for this post.', _SQ_PLUGIN_NAME_));
                    }
                }

            }
        }
        return true;
    }

    public function setPostByURL($url) {
        $post_id = url_to_postid($url);

        if ($post_id > 0) {
            $post = get_post($post_id);
            $post = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->setPost($post)->getPost();
            return $post;
        }

        return false;
    }

    /**
     * Set the home page or blog page in Shippet
     * @return array|null|stdClass|WP_Post
     */
    public function setHomePage() {
        global $wp_query;

        //If  post id set in General Readings for Home Page
        if ($post_id = get_option('page_on_front')) {
            //Get the post for this post ID
            $post = get_post((int)$post_id);

        } else {
            //create the home page domain if no post ID set in Settings > Readings
            $post = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Post');

            $wp_query->is_home = true;
            $post->post_type = 'home';
            $post->hash = md5('wp_homepage');
            $post->post_title = get_bloginfo('name');
            $post->post_excerpt = get_bloginfo('description');
            $post->url = home_url();
        }

        $post = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->setPost($post)->getPost();

        return $post;
    }

    public function setPostByID($post = 0) {

        if (!$post instanceof WP_Post && !$post instanceof SQ_Models_Domain_Post) {
            $post_id = (int)$post;
            if ($post_id > 0) {
                $post = get_post($post_id);
            }
        }

        if ($post) {
            if (isset($post->post_type)) {
                set_query_var('post_type', $post->post_type);
            }
            $post = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->setPost($post)->getPost();

            return $post;
        }
        return false;
    }

    public function setPostByTaxID($term_id = 0, $taxonomy = 'category') {
        if ($term_id > 0) {
            global $wp_query;

            if (!method_exists($wp_query, 'query')) {
                return false;
            }

            $term = get_term_by('term_id', $term_id, $taxonomy);

            if (!is_wp_error($term)) {
                $args = array('posts_per_page' => 1, $taxonomy => $taxonomy, 'term_id' => $term_id);

                if (isset($term->slug)) {
                    $tax_query = array(
                        array(
                            'taxonomy' => $taxonomy,
                            'terms' => $term->slug,
                            'field' => 'slug',
                            'include_children' => true,
                            'operator' => 'IN'
                        ),
                        array(
                            'taxonomy' => $taxonomy,
                            'terms' => $term->slug,
                            'field' => 'slug',
                            'include_children' => false,
                        )
                    );
                    $args['tax_query'] = $tax_query;

                }

                $wp_query->query($args);
                set_query_var('post_type', $taxonomy);
                //SQ_Debug::dump($term, $args);

                if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->setPost($term)->getPost()) {
                    return $post;
                }
            }
        }
        return false;
    }

    public function setAuthorPage($user_id) {

        if ($author = get_userdata($user_id)) {
            $post = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Post');

            $post->post_type = 'profile';
            if (isset($author->ID)) {
                $post->debug = 'is_author:' . $post->post_type . $author->ID;
                $post->ID = $author->ID;
                $post->hash = md5($post->post_type . $author->ID);
                $post->post_author = $author->display_name;
                $post->post_title = $author->display_name;
                $post->post_excerpt = get_the_author_meta('description', $author->ID);
                $post->post_attachment = false;

                //If buddypress installed
                if (function_exists('bp_core_get_user_domain')) {
                    $post->url = bp_core_get_user_domain($author->ID);
                } else {
                    $post->url = get_author_posts_url($author->ID);
                }

            }

            if ($post = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->setPost($post)->getPost()) {
                return $post;
            }
        }

        return false;
    }

    /**
     * Is the user on page name? Default name = post edit page
     * name = 'quirrly'
     *
     * @global array $pagenow
     * @param string $name
     * @return boolean
     */
    public function is_page($name = '') {
        global $pagenow;
        $page = array();
        //make sure we are on the backend
        if (is_admin() && $name <> '') {
            if ($name == 'edit') {
                $page = array('post.php', 'post-new.php');
            } else {
                array_push($page, $name . '.php');
            }

            return in_array($pagenow, $page);
        }

        return false;
    }

}