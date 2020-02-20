<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'suggested'), 'sq_research'); ?>
        <?php SQ_Classes_RemoteController::loadJsVars(); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_help_question float-right"><a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#history" target="_blank"><i class="fa fa-question-circle"></i></a></div>
                        <div class="sq_icons sq_history_icon m-2"></div>
                        <h3 class="card-title"><?php _e('History', _SQ_PLUGIN_NAME_); ?>:</h3>
                        <div class="card-title-description m-2"><?php _e("See the last Keyword Researches you made.", _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_history" class="card col-sm-12 p-0 tab-panel border-0">
                        <div class="card-body p-0">
                            <div class="col-sm-12 m-0 p-0">
                                <div class="card col-sm-12 my-4 p-0 px-3 border-0 ">
                                    <?php if (is_array($view->kr) && !empty($view->kr)) { ?>
                                        <table class="sq_krhistory_list table table-light table-striped table-hover" cellpadding="0" cellspacing="0" border="0">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col"><?php _e('Keyword', _SQ_PLUGIN_NAME_) ?></th>
                                                <th scope="col" title="<?php _e('Country', _SQ_PLUGIN_NAME_) ?>"><?php _e('Co', _SQ_PLUGIN_NAME_) ?></th>
                                                <th style="width: 160px;"><?php _e('Date', _SQ_PLUGIN_NAME_) ?></th>
                                                <th style="width: 160px;"><?php _e('Details', _SQ_PLUGIN_NAME_) ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($view->kr as $key => $kr) {
                                                ?>
                                                <tr>
                                                    <td class="sq_kr_keyword" title="<?php echo $kr->keyword ?>"><?php echo $kr->keyword ?></td>
                                                    <td><?php echo $kr->country ?></td>
                                                    <td>
                                                        <div data-datetime="<?php echo strtotime($kr->datetime) ?>"><?php echo date(get_option('date_format'), strtotime($kr->datetime)) ?></div>
                                                    </td>
                                                    <td>
                                                        <button type="button" data-id="<?php echo $kr->id ?>" data-destination="#history<?php echo $kr->id ?>" class="sq_history_details btn btn-success btn-sm px-5"><?php echo __('Show Details', _SQ_PLUGIN_NAME_) ?></button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="card-body">
                                            <h4 class="text-center"><?php echo __('Welcome to Keyword Research History'); ?></h4>
                                            <h5 class="text-center"><?php echo __('See your research results and compare them over time'); ?>:</h5>
                                            <div class="row col-sm-12 my-4">
                                                <div class="col-sm text-right">
                                                    <h6 onclick="location.href ='<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research','research') ?>'" class="text-black-50 text-right">
                                                        <div style="float: right; cursor: pointer"><?php echo __('Do Keyword Research'); ?></div>
                                                        <i class="sq_icons_small sq_kr_icon" style="float: right; width: 20px; cursor: pointer"></i>
                                                    </h6>
                                                </div>
                                                <div class="col-sm text-left">
                                                    <h6 class="text-black-50">
                                                        <i class="fa fa-ellipsis-v mx-2"></i><?php echo __('Then Add them to Briefcase'); ?>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sq_col_side sticky">
                <div class="card col-sm-12 p-0">
                    <div class="card-body f-gray-dark p-0">
                        <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                        <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>