<?php

class SQ_Core_Blocklogin extends SQ_Classes_BlockController {

    public $message;

    public function init() {
        /* If logged in, then return */
        if (SQ_Classes_Helpers_Tools::getOption('sq_api') <> '') {
            return;
        }

        echo $this->getView('Blocks/Login');
    }

    /**
     * Called for sq_login on Post action
     * Login or register a user
     */
    public function action() {
        parent::action();
        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            //login action
            case 'sq_login':
                $this->squirrlyLogin();
                break;

            //sign-up action
            case 'sq_register':
                $this->squirrlyRegister();
                break;
        }
    }

    /**
     * Register a new user to Squirrly and get the token
     * @global string $current_user
     */
    public function squirrlyRegister() {
        //post arguments
        $args = array();

        //if email is set
        if (SQ_Classes_Helpers_Tools::getIsset('email')) {
            $args['name'] = '';
            $args['user'] = SQ_Classes_Helpers_Tools::getValue('email', '');
            $args['email'] = SQ_Classes_Helpers_Tools::getValue('email', '');

            //create an object from json responce
            $responce = SQ_Classes_RemoteController::register($args);

            if (is_wp_error($responce)) {
                switch ($responce->get_error_message()) {
                    case 'alreadyregistered':
                        $message = SQ_Classes_Error::showNotices(sprintf(__('We found your email, so it means you already have a Squirrly.co account. Please login with your Squirrly Email. If you forgot your password, click %shere%s', _SQ_PLUGIN_NAME_), '<a href="' . _SQ_DASH_URL_ . '/login?action=lostpassword" target="_blank">', '</a>'), 'sq_error');
                        break;
                    case 'invalidemail':
                        $message = SQ_Classes_Error::showNotices(__('Your email is not valid. Please enter a valid email', _SQ_PLUGIN_NAME_), 'sq_error');
                        break;
                    default:
                        $message = SQ_Classes_Error::showNotices(__('We could not create your account. Please enter a valid email', _SQ_PLUGIN_NAME_), 'sq_error');
                        break;
                }

            } else if (isset($responce->token)) { //check if token is set and save it
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', $responce->token);

                //redirect users to onboarding if necessary
                $onboarding = SQ_Classes_Helpers_Tools::getOption('sq_onboarding');
                if (!$onboarding = SQ_Classes_Helpers_Tools::getOption('sq_onboarding')) {
                    wp_safe_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding'));
                    die();
                }

            } else {
                if (SQ_Classes_Error::isError()) {
                    $message = SQ_Classes_Error::showError(SQ_Classes_Error::getError(), 'sq_error');
                } else {
                    //if unknown error
                    $message = SQ_Classes_Error::showNotices(sprintf(__("Error: Couldn't connect to host :( . Please contact your site's webhost (or webmaster) and request them to add %s to their  IP whitelist.", _SQ_PLUGIN_NAME_), _SQ_API_URL_), 'sq_error');
                }
            }
        } else {
            $message = SQ_Classes_Error::showNotices(__('Could not send your information to Squirrly. Please try again.', _SQ_PLUGIN_NAME_), 'sq_error');
        }

        $this->message = $message;

    }

    /**
     * Login a user to Squirrly and get the token
     */
    public function squirrlyLogin() {
        $message = '';
        if (SQ_Classes_Helpers_Tools::getIsset('email') && SQ_Classes_Helpers_Tools::getIsset('password') && isset($_POST['password'])) {
            //get the user and password
            $args['user'] = SQ_Classes_Helpers_Tools::getValue('email');
            $args['password'] = $_POST['password'];

            //get the responce from server on login call
            /** @var bool|WP_Error $responce */
            $responce = SQ_Classes_RemoteController::login($args);

            /**  */
            if (is_wp_error($responce)) {
                switch ($responce->get_error_message()) {
                    case 'badlogin':
                        $message = SQ_Classes_Error::showNotices(__('Wrong email or password!', _SQ_PLUGIN_NAME_), 'sq_error');
                        break;
                    case 'multisite':
                        $message = SQ_Classes_Error::showNotices(__('You can only use this account for the URL you registered first!', _SQ_PLUGIN_NAME_), 'sq_error');
                        break;
                    default:
                        $message = SQ_Classes_Error::showNotices(__('An error occured', _SQ_PLUGIN_NAME_) . ':' . $responce->get_error_message(), 'sq_error');
                        break;
                }

            } elseif (isset($responce->token)) { //check if token is set and save it
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', $responce->token);

                //redirect users to onboarding if necessary
                $onboarding = SQ_Classes_Helpers_Tools::getOption('sq_onboarding');
                if (!$onboarding = SQ_Classes_Helpers_Tools::getOption('sq_onboarding')) {
                    wp_safe_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding'));
                    die();
                }

            } else {
                //if unknown error
                if (SQ_Classes_Error::isError()) {
                    $message = SQ_Classes_Error::showError(SQ_Classes_Error::getError(), 'sq_error');
                } else {
                    //if unknown error
                    $message = SQ_Classes_Error::showNotices(sprintf(__("Error: Couldn't connect to host :( . Please contact your site's webhost (or webmaster) and request them to add %s to their  IP whitelist.", _SQ_PLUGIN_NAME_), _SQ_API_URL_), 'sq_error');
                }
            }

        } else {
            $message = SQ_Classes_Error::showNotices(__('Both fields are required.', _SQ_PLUGIN_NAME_), 'sq_error');
        }

        $this->message = $message;
    }

}
