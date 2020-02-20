<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_focuspages')) {
            echo '<div class="col-sm-12 alert alert-success text-center m-0 p-3">'. __("You do not have permission to access this page. You need Squirrly SEO Admin role", _SQ_PLUGIN_NAME_).'</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'boost'), 'sq_focuspages'); ?>
        <div class="sq_row d-flex flex-row bg-white px-3">
            <div class="sq_col flex-grow-1 mr-3">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons sq_addpage_icon m-2"></div>
                        <h3 class="card-title"><?php _e('Add a page in Focus Pages', _SQ_PLUGIN_NAME_); ?>:</h3>
                        <div class="card-title-description m-2"><?php _e('Focus Pages bring you clear methods to take your pages from never found to always found on Google. Rank your pages by influencing the right ranking factors. Turn everything that you see here to Green and you will win.', _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_focuspages" class="card col-sm-12 p-0 tab-panel border-0">
                        <div class="card-body p-0">
                            <div class="col-sm-12 m-0 p-0">
                                <div class="card col-sm-12 my-4 p-0 border-0 ">
                                    <div class="row px-3">
                                        <form method="get" class="form-inline col-sm-12">
                                            <input type="hidden" name="page" value="<?php echo SQ_Classes_Helpers_Tools::getValue('page') ?>">
                                            <input type="hidden" name="tab" value="<?php echo SQ_Classes_Helpers_Tools::getValue('tab') ?>">
                                            <div class="row justify-content-center col-sm-12 p-0 py-2 text-center">
                                                <input type="search" class="align-middle col-sm-7 p-1 mr-2" id="post-search-input" autofocus name="skeyword" value="<?php echo htmlspecialchars(SQ_Classes_Helpers_Tools::getValue('skeyword')) ?>"/>
                                                <input type="submit" class="btn btn-primary btn-lg px-4" value="<?php echo __('Search', _SQ_PLUGIN_NAME_) ?>"/>
                                            </div>

                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <?php if (!empty($view->pages)) { ?>
                            <div class="card-body p-0 position-relative">
                                <div class="col-sm-12 m-0 p-2">
                                    <div class="card col-sm-12 my-1 p-0 border-0 " style="display: inline-block;">

                                        <table class="table table-light table-striped table-hover table-bordered">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th><?php echo __('Title', _SQ_PLUGIN_NAME_) ?></th>
                                                <th><?php echo __('Option', _SQ_PLUGIN_NAME_) ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($view->pages as $index => $post) {
                                                if (!isset($post->ID)) continue;

                                                $active = false;
                                                if (!empty($view->focuspages)) {
                                                    foreach ($view->focuspages as $focuspage) {
                                                        if ($focuspage->post_id == $post->ID || rtrim($focuspage->permalink,'/') == rtrim($post->url,'/')) {
                                                            $active = true;
                                                        }
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="col-sm-12 px-0 mx-0 font-weight-bold" style="font-size: 15px"><?php echo $post->post_title ?></div>
                                                        <div class="small " style="font-size: 11px"><?php echo '<a href="' . get_permalink($post->ID) . '" class="text-link" rel="permalink" target="_blank">' . urldecode(get_permalink($post->ID)) . '</a>' ?></div>

                                                    </td>
                                                    <td style="width: 140px">
                                                        <?php if (!$active) { ?>
                                                            <form method="post" class="p-0 m-0">
                                                                <?php wp_nonce_field('sq_focuspages_addnew', 'sq_nonce'); ?>
                                                                <input type="hidden" name="action" value="sq_focuspages_addnew"/>
                                                                <input type="hidden" name="id" value="<?php echo $post->ID ?>"/>
                                                                <button type="submit" class="btn btn-sm text-white bg-primary">
                                                                    <?php echo __('Set Focus Page', _SQ_PLUGIN_NAME_) ?>
                                                                </button>
                                                            </form>
                                                        <?php }else{ ?>
                                                            <span class="text-success font-weight-bold text-center"><?php echo __('Is focus page', _SQ_PLUGIN_NAME_) ?></span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                            </tbody>
                                        </table>
                                        <div class="nav-previous alignleft"><?php the_posts_pagination(array(
                                                'mid_size' => 3,
                                                'format' => '?paged=%#%',
                                                'prev_text' => __('Prev Page', _SQ_PLUGIN_NAME_),
                                                'next_text' => __('Next Page', _SQ_PLUGIN_NAME_),
                                            ));; ?></div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="sq_col sq_col_side ">
                <div class="card col-sm-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
