<div class="card-text">
    <div id="sq_assistant_<?php echo SQ_Classes_Helpers_Tools::getValue('page', 'sq_research') ?>" class="sq_assistant">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->getAssistant(SQ_Classes_Helpers_Tools::getValue('page', 'sq_research')); ?>
    </div>
    <div class="border"></div>
    <?php if (SQ_Classes_Helpers_Tools::getValue('page', '') == 'sq_dashboard') { ?>
        <div class="my-4 py-4 border">
            <div class="col-sm-12 row m-0">
                <div class="checker col-sm-12 row m-0 p-0">
                    <div class="col-sm-12 p-0  m-0 sq-switch sq-switch-sm sq_save_ajax">
                        <input type="checkbox" id="sq_seoexpert" name="sq_seoexpert" class="sq-switch" data-action="sq_ajax_seosettings_save" data-input="sq_seoexpert" data-name="sq_seoexpert" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_seoexpert') ? 'checked="checked"' : '') ?> value="1"/>
                        <label for="sq_seoexpert" class="ml-1"><?php _e('Show Advanced SEO', _SQ_PLUGIN_NAME_); ?></label>
                        <div class="offset-1 text-black-50 m-0 mt-2" style="font-size: 13px;"><?php _e('Switch off to have the simplified version of the settings, intended for Non-SEO Experts.', _SQ_PLUGIN_NAME_); ?></div>
                        <div class="offset-1 text-black-50 m-0 mt-2" style="font-size: 13px;"><?php _e('It will offer the same level of SEO performance, but it will be less customizable.', _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-3 py-3">
            <div class="col-sm-12 row m-0">
                <div class="checker col-sm-12 row m-0 p-0 text-center">
                    <div class="col-sm-12 my-2 mx-auto p-0 font-weight-bold" style="font-size: 18px;"><?php echo __('We Need Your Support', _SQ_PLUGIN_NAME_) ?></div>

                    <div class="col-sm-12 my-2 p-0">
                        <a href="https://wordpress.org/support/view/plugin-reviews/squirrly-seo#postform" target="_blank">
                            <img src="<?php echo _SQ_ASSETS_URL_ . 'img/5stars.png' ?>">
                        </a>
                    </div>
                    <div class="col-sm-12 my-2 p-0">
                        <a href="https://wordpress.org/support/view/plugin-reviews/squirrly-seo#postform" target="_blank" class="font-weight-bold" style="font-size: 16px;">
                            <?php echo __('Rate us if you like Squirrly SEO', _SQ_PLUGIN_NAME_) ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockKnowledgeBase')->init(); ?>

</div>