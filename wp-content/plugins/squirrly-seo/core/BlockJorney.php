<?php

class SQ_Core_BlockJorney extends SQ_Classes_BlockController {

    public $days = 0;

    public function hookGetContent() {
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('jorney');

        if (!$seojorney = SQ_Classes_Helpers_Tools::getOption('sq_seojourney')) {
            ?>
            <div class="col-sm-12 m-0 p-3 text-center">
                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step2.1') ?>" class="btn btn-success m-2 py-2 px-4" style="font-size: 20px;"><?php echo __("I'm ready to start the 14 Days Journey To Better Ranking", _SQ_PLUGIN_NAME_); ?></a>
            </div>
            <?php
            return false;
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_seojourney_congrats')) {
            return false;
        }

        $days = 1;
        $seconds = strtotime(date('Y-m-d')) - strtotime($seojorney);

        if ($seconds > 0) {
            $days = $seconds / (3600 * 24);
            $days = (int)$days + 1;
        }

        $this->days = $days;
        echo $this->getView('Blocks/Jorney');
    }

    public function getJourneyDays() {
        return $this->days;
    }

    /**
     * 14 days journey action
     */
    public function action() {
        parent::action();
        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            //login action
            case 'sq_journey_close':
                SQ_Classes_Helpers_Tools::saveOptions('sq_seojourney_congrats', 0);
                break;

        }
    }
}
