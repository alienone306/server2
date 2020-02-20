<script type="text/javascript" src="//www.google.com/jsapi"></script>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>

    <div class="d-flex flex-row my-0 bg-white col-sm-12 p-0 m-0">
        <?php if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') { ?>
            <div class="sq_col flex-grow-1 mx-0 px-3">
                <div class="bg-title col-sm-8 mx-auto card-body my-3 p-2 offset-2 rounded-top" style="min-width: 600px;">
                    <div class="col-sm-12 text-left m-0 p-0">
                        <div class="sq_icons sq_squirrly_icon m-2"></div>
                        <h3 class="card-title"><?php _e('Connect to Squirrly Data Cloud', _SQ_PLUGIN_NAME_); ?>:</h3>
                    </div>

                    <?php SQ_Classes_ObjController::getClass('SQ_Core_Blocklogin')->init(); ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="sq_col flex-grow-1 mx-0 px-3">
                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons sq_squirrly_icon m-2"></div>
                        <h3 class="card-title"><?php _e('Squirrly dashboard', _SQ_PLUGIN_NAME_); ?></h3>
                    </div>
                    <?php SQ_Classes_ObjController::getClass('SQ_Core_Blocklogin')->init(); ?>
                </div>

                <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockJorney')->init(); ?>
                <?php
                if (SQ_Classes_Helpers_Tools::getMenuVisible('show_account_info')) {
                    if (!SQ_Classes_ObjController::getClass('SQ_Core_BlockJorney')->getJourneyDays()) {
                        SQ_Classes_ObjController::getClass('SQ_Core_BlockStats')->init();
                    }
                }
                ?>
                <?php SQ_Classes_ObjController::getClass('SQ_Controllers_CheckSeo')->init(); ?>
                <?php if (current_user_can('sq_manage_focuspages')) {
                    SQ_Classes_ObjController::getClass('SQ_Core_BlockFocusPages')->init();
                    SQ_Classes_ObjController::getClass('SQ_Core_BlockAudits')->init();
                } ?>
                <?php if (current_user_can('sq_manage_focuspages')) {
                    SQ_Classes_ObjController::getClass('SQ_Core_BlockKRFound')->init();
                } ?>
                <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockKRHistory')->init(); ?>

                <?php
                if (current_user_can('sq_manage_focuspages')) {
                    SQ_Classes_ObjController::getClass('SQ_Core_BlockRanks')->init();
                }
                ?>

            </div>

        <?php } ?>
        <div class="sq_col sq_col_side ">
            <div class="card col-sm-12 p-0">
                <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
            </div>
        </div>

    </div>
</div>
