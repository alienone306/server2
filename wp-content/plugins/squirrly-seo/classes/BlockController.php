<?php

/**
 * The main class for core blocks
 *
 */
class SQ_Classes_BlockController {

    /** @var object of the model class */
    protected $model;

    /** @var boolean */
    public $flush = true;

    /** @var object of the view class */
    protected $view;

    /** @var string name of the  class */
    private $name;

    public function __construct() {
        /* get the name of the current class */
        $this->name = get_class($this);

        /* create the model and view instances */
        $model_classname = str_replace('Core', 'Models', $this->name);
        if(SQ_Classes_ObjController::getClassPath($model_classname)) {
            $this->model = SQ_Classes_ObjController::getClass($model_classname);
        }
    }

    /**
     * load sequence of classes
     * Function called usualy when the controller is loaded in WP
     *
     * @return mixed
     */
    public function init() {
        /* check if there is a hook defined in the block class */
        SQ_Classes_ObjController::getClass('SQ_Classes_HookController')->setBlockHooks($this);
        //get the class path
        $class = SQ_Classes_ObjController::getClassPath($this->name);

        if ($this->flush) {
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia($class['name']);

            echo $this->getView($class['name']);
        } else {
            return $this->getView($class['name']);
        }

        return '';
    }

    /**
     * Get the block view
     *
     * @param  string $view Class name
     * @return mixed
     */
    public function getView($view) {
        return SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->getView($view, $this);
    }

    /**
     * Called as menu callback to show the block
     *
     */
    public function show() {
        $this->flush = true;

        echo $this->init();
    }

    public function preloadSettings() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_api') <> '') {
            echo '<script>
                   var __blog_url = "' . get_bloginfo('url') . '";
                   var __token = "' . SQ_Classes_Helpers_Tools::getOption('sq_api') . '";
                   var __language = "' . get_bloginfo('language') . '";
                   var __api_url = "' . _SQ_API_URL_ . '";
                   var __apiv2_url = "' . _SQ_APIV2_URL_ . '";
             </script>';
        }
    }

    /**
     * This function is called from Ajax class as a wp_ajax_action
     *
     */
    protected function action() { }

    /**
     * This function will load the media in the header for each class
     *
     * @return void
     */
    protected function hookHead() { }

}
