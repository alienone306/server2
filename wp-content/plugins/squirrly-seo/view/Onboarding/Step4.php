<div id="sq_wrap">
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'step4'), 'sq_onboarding'); ?>
        <div class="sq_row d-flex flex-row bg-white px-3">
            <div class="sq_col flex-grow-1 mr-3">

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top  row">
                        <div class="card-body p-2 bg-title rounded-top">
                            <div class="sq_icons sq_squirrly_icon m-1 mx-3"></div>
                            <h3 class="card-title"><?php _e('Start using Squirrly SEO 2019 (Strategy)', _SQ_PLUGIN_NAME_); ?></h3>
                        </div>

                    </div>
                    <div class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0">
                        <div class="card-body p-0">
                            <div class="col-sm-12 m-0 p-0">
                                <div class="card col-sm-12 p-0 border-0 ">

                                    <div class="col-sm-12 pt-0 pb-4 tab-panel">

                                        <div class="col-sm-12 card-title py-3 pt-5 text-success text-center" style="font-size: 28px; line-height: 30px"><?php _e("Choose where you want to start", _SQ_PLUGIN_NAME_); ?>:</div>

                                        <div class="col-sm-12 m-0 p-0 py-2" >


                                            <div class="col-sm-12 my-3 p-0 row justify-content-center">
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings') ?>" class="btn rounded-0 btn-info btn-lg p-4 px-5 m-3 vertical"><?php _e('Customize <br />SEO Settings <br />and Automation', _SQ_PLUGIN_NAME_); ?></a>
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research','research') ?>" class="btn rounded-0 btn-info btn-lg p-4 px-5 m-3"><?php _e('Find the Best <br />Long Tail <br />Keywords', _SQ_PLUGIN_NAME_); ?></a>
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('post-new.php') ?>" class="btn rounded-0 btn-info btn-lg p-4 px-5 m-3"><?php _e('Optimize a <br />New Post <br />Using Keywords', _SQ_PLUGIN_NAME_); ?></a>
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages','pagelist') ?>" class="btn rounded-0 btn-info btn-lg p-4 px-5 m-3"><?php _e('Rank a Page <br /> in TOP 10 <br />with Focus Pages', _SQ_PLUGIN_NAME_); ?></a>
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step2.1') ?>" class="btn rounded-0 btn-info btn-lg p-4 px-5 m-3"><?php _e('Start my 14 <br />Days Journey to <br />Better Rankings', _SQ_PLUGIN_NAME_); ?></a>
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
</div>
</div>
