<?php

class SQ_Controllers_Audits extends SQ_Classes_FrontController {

    public $blogs;
    public $audits;

    /** @var int Audit history limit */
    public $limit = 10;

    function init() {
        //Clear the Scripts and Styles from other plugins
        SQ_Classes_ObjController::getClass('SQ_Models_Compatibility')->clearStyles();

        //Checkin to API V2
        SQ_Classes_RemoteController::checkin();

        $tab = SQ_Classes_Helpers_Tools::getValue('tab', 'audits');

        if (method_exists($this, $tab)) {
            call_user_func(array($this, $tab));
        }

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap-reboot');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('switchery');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fontawesome');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('global');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('assistant');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('navbar');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('audits');

        //@ob_flush();
        echo $this->getView('Audits/' . ucfirst($tab));

        //get the modal window for the assistant popup
        echo SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->getModal();

    }

    public function audits() {

        $args = array();
        $args['limit'] = $this->limit;

        $this->audits = SQ_Classes_RemoteController::getBlogAudits($args);

        if(is_wp_error($this->audits)) {
            $this->audits = array();
        }
        SQ_Debug::dump($this->audits);

    }

    /**
     * Called when action is triggered
     *
     * @return void
     */
    public function action() {
        parent::action();

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_audits_settings':
                if (!current_user_can('sq_manage_settings')) {
                    return;
                }

                $email = sanitize_email(SQ_Classes_Helpers_Tools::getValue('sq_audit_email'));
                SQ_Classes_Helpers_Tools::saveOptions('sq_audit_email', $email);

                if ($email <> '') {

                    //Save the settings on API too
                    $args = array();
                    $args['audit_email'] = $email;
                    SQ_Classes_RemoteController::saveSettings($args);
                    ///////////////////////////////

                    //show the saved message
                    SQ_Classes_Error::setMessage(__('Saved', _SQ_PLUGIN_NAME_));
                } else {
                    SQ_Classes_Error::setError(__('Not a valid email address', _SQ_PLUGIN_NAME_));

                }

                break;
        }

    }
}
