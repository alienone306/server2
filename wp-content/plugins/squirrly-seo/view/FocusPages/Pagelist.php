<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row flex-nowrap my-0 bg-nav" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_focuspages')) {
            echo '<div class="col-sm-12 alert alert-success text-center m-0 p-3">'. __("You do not have permission to access this page. You need Squirrly SEO Admin role", _SQ_PLUGIN_NAME_).'</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'pagelist'), 'sq_focuspages'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons sq_focuspages_icon m-2"></div>
                        <h3 class="card-title"><?php _e('Focus Pages', _SQ_PLUGIN_NAME_); ?>:</h3>
                        <div class="card-title-description m-2"><?php _e('Focus Pages bring you clear methods to take your pages from never found to always found on Google. Rank your pages by influencing the right ranking factors. Turn everything that you see here to Green and you will win.', _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_focuspages" class="card col-sm-12 p-0 tab-panel border-0">

                        <?php if (!empty($view->focuspages)) { ?>
                            <?php if (isset($view->labels) && !empty($view->labels)) { ?>
                                <div class="row px-3">
                                    <form method="get" class="form-inline col-sm-12 ignore">
                                        <input type="hidden" name="page" value="<?php echo SQ_Classes_Helpers_Tools::getValue('page') ?>">
                                        <input type="hidden" name="tab" value="<?php echo SQ_Classes_Helpers_Tools::getValue('tab') ?>">
                                        <div class="col-sm-10 p-0">
                                            <h3 class="card-title text-dark p-2" style="line-height: 30px; font-size: 22px;"><?php _e('Current Ranking Drawbacks.', _SQ_PLUGIN_NAME_); ?>:</h3>
                                        </div>
                                        <div class="col-sm-2 p-0 py-2">
                                            <div class="form-group text-right col-sm-12 p-0 m-0">
                                                <?php if (SQ_Classes_Helpers_Tools::getIsset('slabel')) { ?>
                                                    <div class="sq_serp_settings_button mx-1 my-0">
                                                        <button type="button" class="btn btn-info p-v-xs" onclick="location.href = '<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'pagelist') ?>';" style="cursor: pointer"><?php echo __('Show All') ?></button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="sq_filter_label p-2">
                                            <?php $keyword_labels = SQ_Classes_Helpers_Tools::getValue('slabel', array());
                                            foreach ($view->labels as $category => $label) {
                                                if ($label->show) {
                                                    ?>
                                                    <input type="checkbox" name="slabel[]" onclick="form.submit();" id="search_checkbox_<?php echo $category ?>" style="display: none;" value="<?php echo $category ?>" <?php echo(in_array($category, (array)$keyword_labels) ? 'checked' : '') ?> />
                                                    <label for="search_checkbox_<?php echo $category ?>" class="sq_circle_label fa <?php echo(in_array($category, (array)$keyword_labels) ? 'sq_active' : '') ?>" data-id="<?php echo $category ?>" style="background-color: <?php echo $label->color ?>" title="<?php echo $label->name ?>"><?php echo $label->name ?></label>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>

                            <div class="card-body p-0 position-relative">
                                <div class="btn btn-round position-absolute sq_overflow_arrow_left">
                                    <i class="fa fa-arrow-circle-left"></i>
                                </div>
                                <div class="btn btn-round position-absolute sq_overflow_arrow_right">
                                    <i class="fa fa-arrow-circle-right"></i>
                                </div>
                                <div class="sq_overflow col-sm-12 m-0 my-2 px-2 py-0 flexcroll" style="max-height: 480px;">
                                    <div class="card col-sm-12 my-0 p-0 border-0 " style="display: inline-block;">
                                        <table class="table table-light table-striped table-hover table-bordered" >
                                            <thead class="thead-dark">
                                            <tr>
                                                <th><?php echo __('Permalink', _SQ_PLUGIN_NAME_) ?></th>
                                                <th><?php _e('Must FIX', _SQ_PLUGIN_NAME_) ?></th>
                                                <th><?php echo __('Chance to Rank', _SQ_PLUGIN_NAME_) ?></th>
                                                <?php
                                                $categories = SQ_Classes_ObjController::getClass('SQ_Models_FocusPages')->getCategories();
                                                foreach ($categories as $category_title) {
                                                    echo '<th>' . $category_title . '</th>';
                                                }
                                                ?>
                                                <th style="width: 10px"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (!empty($view->focuspages)) {
                                                foreach ($view->focuspages as $index => $focuspage) {
                                                    if (isset($focuspage->id) && $focuspage->id > 0) {
                                                        $view->focuspage = $focuspage;
                                                        $view->post = $view->focuspage->getWppost();

                                                        if (!current_user_can('sq_manage_focuspages')) continue;
                                                        ?>
                                                        <tr id="sq_row_<?php echo $focuspage->id ?>" class="<?php echo($index % 2 ? 'even' : 'odd') ?>">
                                                            <?php
                                                            echo $view->getView('FocusPages/FocusPageRow');
                                                            ?>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card-body">
                                <h4 class="text-center"><?php echo __('Welcome to Focus Pages'); ?></h4>
                                <h5 class="text-center"><?php echo __('To get started with managing the focus pages'); ?>:</h5>
                                <div class="row col-sm-12 my-4">
                                    <div class="col-sm text-right">
                                        <h6 onclick="location.href ='<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'addpage') ?>'" class="text-black-50 text-right">
                                            <div style="float: right; cursor: pointer"><?php echo __('Add new page'); ?></div>
                                            <i class="sq_icons_small sq_addpage_icon" style="float: right; width: 20px; cursor: pointer"></i>
                                        </h6>
                                    </div>
                                    <div class="col-sm text-left">
                                        <h6 class="text-black-50">
                                            <i class="fa fa-ellipsis-v mx-2"></i><?php echo __('Then set a page as focus'); ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="card-body">
                            <div class="col-sm-12 my-2 text-black-50">
                                <em><?php echo sprintf(__('%sNote:%s remember that it takes anywhere between %s1 minute to 5 minutes%s to generate the new audit for a focus page. There is a lot of processing involved.'),'<strong>','</strong>','<strong>','</strong>'); ?></em>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sq_col_side sticky">
                <div class="card col-sm-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <div class="sq_assistant">
                        <ul class="p-0 mx-5">
                            <li class="completed text-black-50 p-0 m-0"><img src="<?php echo _SQ_ASSETS_URL_ . 'img/help/fp_steps.png' ?>" style="max-width: 100%"></li>
                        </ul>
                    </div>
                    <?php
                    if (!empty($view->focuspages)) {
                        foreach ($view->focuspages as $focuspage) { ?>
                            <div id="sq_assistant_<?php echo $focuspage->id ?>" class="sq_assistant">
                                <?php
                                if (isset($focuspage->id)) {
                                    $categories = apply_filters('sq_assistant_categories_page', $focuspage->id);
                                    //SQ_Debug::dump($categories);
                                    if (!empty($categories)) {
                                        foreach ($categories as $index => $category) {
                                            if (isset($category->assistant)) {
                                                echo $category->assistant;
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
