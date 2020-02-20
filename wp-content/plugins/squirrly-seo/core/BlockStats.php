<?php

class SQ_Core_BlockStats extends SQ_Classes_BlockController {
    var $stats = array();

    function init() {
        parent::init();

        if(isset($this->stats) && isset($this->stats)) {
            echo $this->getView('Blocks/Stats');
        }
    }

    function hookGetContent() {
        //get the stats from Dashboard
        $this->stats = SQ_Classes_RemoteController::getStats();

        if(is_wp_error($this->stats)){
            $this->stats = array();
        }
    }


}
