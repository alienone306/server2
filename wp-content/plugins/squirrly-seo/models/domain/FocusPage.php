<?php

class SQ_Models_Domain_FocusPage extends SQ_Models_Abstract_Domain {

    protected $_id;
    protected $_user_post_id;
    protected $_post_id;
    protected $_permalink;
    protected $_audit;

    protected $_incomplete = 0;
    protected $_visibility = 100;
    //--
    protected $_audit_datetime;
    protected $_audit_error;
    protected $_datetime;

    protected $_wppost;

    /**
     * Get the Local Post ID
     * @return bool
     */
    public function getId() {
        if (!isset($this->_id)) {
            if ($post = $this->getWppost()) {
                $this->_id = $post->ID;
            }
        }

        return $this->_id;
    }

    public function getAudit() {
        if (!isset($this->_audit)) {
            $this->_audit = (object)array();
        }

        $this->_audit->permalink = $this->_permalink;
        return $this->_audit;
    }

    public function getVisibility() {
        //if the post is not public
        if (isset($this->_wppost->ID)) {
            if($this->_wppost->post_status <> 'publish'){
                $this->_visibility = 0;
            }
        }

        //if visibility is
        if (isset($this->_visibility)) {
            if ((int)$this->_visibility < 0) {
                $this->_visibility = 0;
            }
        }

        return $this->_visibility;
    }

    /**
     * Get the local post
     * @param $url
     * @return SQ_Models_Domain_Post|false
     */
    public function getWppost() {
        if (!isset($this->_wppost->ID)) {
            if (isset($this->_post_id) && $this->_post_id > 0) {
                if ($this->_wppost = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByID($this->_post_id)) {
                    $this->_wppost->sq_adm; //call the sq to populate
                }
            }
        }

        if (!isset($this->_wppost->ID)) {
            if (isset($this->_permalink) && $this->_permalink <> '') {
                if ($this->_wppost = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setPostByURL($this->_permalink)) {
                    $this->_wppost->sq_adm; //call the sq to populate
                }
            }
        }

        return $this->_wppost;
    }
}
