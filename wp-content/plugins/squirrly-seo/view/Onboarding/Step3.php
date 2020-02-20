<div id="sq_wrap">
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'step3'), 'sq_onboarding'); ?>
        <div class="sq_row d-flex flex-row bg-white px-3">
            <div class="sq_col flex-grow-1 mr-3">

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top row">
                        <div class="col-sm-8 m-0 p-0 py-2 bg-title rounded-top">
                            <div class="sq_icons sq_squirrly_icon m-1 mx-3"></div>
                            <h3 class="card-title"><?php _e('Other SEO Plugins', _SQ_PLUGIN_NAME_); ?></h3>
                        </div>
                        <div class="col-sm-4 m-0 p-0 py-2 text-right">
                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step4') ?>" class="btn rounded-0 btn-success btn-lg px-3 mx-4 float-sm-right"><?php _e('Continue >', _SQ_PLUGIN_NAME_); ?></a>
                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0">
                        <div class="card-body p-0">
                            <div class="col-sm-12 m-0 p-0">
                                <div class="card col-sm-12 p-0 border-0 ">

                                    <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">
                                        <?php
                                        add_filter('sq_themes', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'getAvailableThemes'));
                                        add_filter('sq_plugins', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'getAvailablePlugins'));
                                        $platforms = apply_filters('sq_importList', false);
                                        if ($platforms && count((array)$platforms) > 0) {
                                            ?>
                                            <div class="col-sm-12 card-title pt-4 text-center" style="font-size: 23px; line-height: 35px"><?php _e("We've detected another SEO Plugin on your site.", _SQ_PLUGIN_NAME_); ?></div>
                                            <div class="col-sm-12 m-0 p-3 px-5"><?php echo sprintf(__("Just as you'd never place two different sets of tires on the wheels of your car, you shouldn't use two different plugins for your WordPress SEO. %sSquirrly SEO loads the fastest in all tests done by 3rd parties%s, and keeps you best connected on the SEO road.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></div>

                                            <div id="sq_onboarding">

                                                <div class="col-sm-12 card-title m-2 mt-5 text-center" style="font-size: 20px; line-height: 35px"><?php echo sprintf(__("%sLet's import your settings and SEO%s from the following plugin into your new Squirrly SEO", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?>:</div>

                                                <div class="col-sm-12 pt-0 pb-4 ml-3 tab-panel">
                                                    <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                                        <div class="col-sm-12 row py-2 mx-0 my-3">
                                                            <div class="col-sm-10 offset-1 p-0 input-group">
                                                                <?php
                                                                if ($platforms && count((array)$platforms) > 0) {
                                                                    ?>
                                                                    <select name="sq_import_platform" class="form-control bg-input mb-1">
                                                                        <?php
                                                                        foreach ($platforms as $path => $settings) {
                                                                            ?>
                                                                            <option value="<?php echo $path ?>"><?php echo ucfirst(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($path)); ?></option>
                                                                        <?php } ?>
                                                                    </select>

                                                                    <?php wp_nonce_field('sq_seosettings_importall', 'sq_nonce'); ?>
                                                                    <input type="hidden" name="action" value="sq_seosettings_importall"/>
                                                                    <button type="submit" class="btn rounded-0 btn-success px-3 mx-2" style="min-width: 140px; max-height: 50px;"><?php _e('Import', _SQ_PLUGIN_NAME_); ?></button>
                                                                <?php } else { ?>
                                                                    <div class="col-sm-12 my-2"><?php _e("We couldn't find any SEO plugin or theme to import from."); ?></div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <div class="col-sm-12 card-title m-2 mt-5 text-center text-success" style="font-size: 16px;"><?php _e("You are 100% covered by the new Squirrly SEO. You have all you need in it.", _SQ_PLUGIN_NAME_); ?></div>

                                                </div>

                                                <div class="col-sm-12 my-3 p-0 py-3 border-top">
                                                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step4') ?>" class="btn rounded-0 btn-success btn-lg px-3 mx-4 float-sm-right"><?php _e('Continue >', _SQ_PLUGIN_NAME_); ?></a>
                                                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step4') ?>" class="btn rounded-0 btn-default btn-lg px-3 mx-4 float-sm-right"><?php _e('Skip this step', _SQ_PLUGIN_NAME_); ?></a>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-sm-12 card-title pt-4 text-center" style="font-size: 23px; line-height: 35px"><?php _e("We didn't detect other SEO Plugins on your site.", _SQ_PLUGIN_NAME_); ?></div>
                                            <div id="sq_onboarding">
                                                <div class="col-sm-12 my-3 p-0 py-3 border-top">
                                                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step4') ?>" class="btn rounded-0 btn-success btn-lg px-3 mx-4 float-sm-right"><?php _e('Continue >', _SQ_PLUGIN_NAME_); ?></a>
                                                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step4') ?>" class="btn btn-default btn-lg px-3 mx-1 text-secondary float-sm-left rounded-0"><?php _e('Close Tutorial', _SQ_PLUGIN_NAME_); ?></a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
</div>
