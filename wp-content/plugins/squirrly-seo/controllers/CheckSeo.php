<?php
class SQ_Controllers_CheckSeo extends SQ_Classes_FrontController {
    public $report;
    public $report_time;

    /**
     * Call the init on Dashboard
     * @return mixed|void
     */
    public function init() {
        $this->report = get_option('sq_seoreport');
        $this->report_time = get_option('sq_seoreport_time');

        if (!empty($this->report)) {
            if (!$tasks_ignored = get_option('sq_seoreport_ignore')) {
                $tasks_ignored = array();
            }

            $tasks = $this->model->getTasks();
            foreach ($this->report as $function => &$row) {
                if (!in_array($function, $tasks_ignored)) {
                    if (isset($tasks[$function])) {
                        $row = array_merge($tasks[$function], $row);
                    }
                } else {
                    unset($this->report[$function]);
                }
            }
        }


        echo $this->getView('Blocks/SEOIssues');
    }

    /**
     * Return the number of SEO errors if exists
     * @return bool|int
     */
    public function getErrorsCount(){
        $this->report = get_option('sq_seoreport');
        if (!empty($this->report)) {
            return count((array)$this->report);
        }

        return false;
    }

    /**
     * Check SEO Actions
     */
    public function action() {
        parent::action();

        if (!current_user_can('manage_options')) {
            return;
        }

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_checkseo':
                SQ_Classes_Error::setMessage(__('Done!', _SQ_PLUGIN_NAME_));
                //Check all the SEO
                //Process all the tasks and save the report
                $this->model->checkSEO();

                break;

            case 'sq_fixsettings':
                $name = SQ_Classes_Helpers_Tools::getValue('name', false);
                $value = SQ_Classes_Helpers_Tools::getValue('value', false);

                if ($name && $value) {
                    if (in_array($name, array_keys(SQ_Classes_Helpers_Tools::$options))) {
                        SQ_Classes_Helpers_Tools::saveOptions($name, $value);

                        //Process all the tasks and save the report
                        $this->model->checkSEO();

                        SQ_Classes_Error::setMessage(__('Fixed!', _SQ_PLUGIN_NAME_));
                        return;
                    }
                }

                SQ_Classes_Error::setError(__('Could not fix it. You need to change it manually.', _SQ_PLUGIN_NAME_));
                break;

            case 'sq_ignoretask':

                $name = SQ_Classes_Helpers_Tools::getValue('name', false);

                if ($name) {
                    if (!$tasks_ignored = get_option('sq_seoreport_ignore')) {
                        $tasks_ignored = array();
                    }

                    array_push($tasks_ignored, $name);
                    $tasks_ignored = array_unique($tasks_ignored);
                    update_option('sq_seoreport_ignore', $tasks_ignored);
                }

                SQ_Classes_Error::setMessage(__('Saved! This task will be ignored in the future.', _SQ_PLUGIN_NAME_));
                break;

            case 'sq_resetignored':
                update_option('sq_seoreport_ignore', array());
                SQ_Classes_Error::setMessage(__('Saved!', _SQ_PLUGIN_NAME_));

                break;

        }


    }

}