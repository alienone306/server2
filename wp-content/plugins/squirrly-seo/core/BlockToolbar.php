<?php

class SQ_Core_BlockToolbar extends SQ_Classes_BlockController {

    function init() {
        echo $this->getView('Blocks/Toolbar');
    }

    function hookGetContent() { }

}
