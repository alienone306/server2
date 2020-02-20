<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_focuspages')) {
            echo '<div class="col-sm-12 alert alert-success text-center m-0 p-3">' . __("You do not have permission to access this page. You need Squirrly SEO Admin role", _SQ_PLUGIN_NAME_) . '</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'audits'), 'sq_audits'); ?>

        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons sq_audit_icon m-2"></div>
                        <h3 class="card-title"><?php _e('Audits', _SQ_PLUGIN_NAME_); ?>:</h3>
                        <div class="card-title-description m-2"><?php _e('Verifies the online presence of your website by knowing how your website is performing in terms of Blogging, SEO, Social, Authority, Links, and Traffic', _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_audits" class="card col-sm-12 p-0 tab-panel border-0">
                        <?php
                        $connect = json_decode(json_encode(SQ_Classes_Helpers_Tools::getOption('connect')));
                        if (!$connect->google_analytics) { ?>
                            <div class="form-group mb-4 col-sm-8 offset-2">
                                <?php echo $view->getView('Connect/GoogleAnalytics'); ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($view->audits) && is_array($view->audits) && !empty($view->audits)) {
                            $lastaudit = current($view->audits);

                            //make sure is the write value
                            if (date('Y', strtotime($lastaudit->datetime)) == 1970) {
                                $lastaudit->datetime = false;
                            } else {
                                $lastaudit->datetime = date('Y-m-d H:i:s', strtotime($lastaudit->datetime));
                            }
                            $lastaudit->error = isset($lastaudit->error) ? (bool)$lastaudit->error : false;
                            $lastaudit->security = isset($lastaudit->security) ? (bool)$lastaudit->security : false;
                            $overdue = false;
                            ?>
                            <div class="card-group mb-2">
                                <div class="col-sm card m-2 bg-light">
                                    <div class="card-body mt-2">
                                        <h4>
                                            <?php
                                            if ((int)$lastaudit->score > 0) {
                                                echo __('Score:') . ' ' . $lastaudit->score;

                                                $diff = null;

                                                if (!empty($view->audits)) {
                                                    foreach ($view->audits as $row) {
                                                        if (strtotime($lastaudit->datetime) - strtotime($row->datetime) > (3600 * 24) && $row->score > 0) {
                                                            $diff = ($lastaudit->score - $row->score);
                                                            break;
                                                        }
                                                    }
                                                }
                                                if (isset($diff)) {
                                                    if ($diff > 0) {
                                                        echo '<i class="fa fa-sort-up text-success ml-2" title="' . sprintf(__('The audit score increased by %s since %s', _SQ_PLUGIN_NAME_), $diff, date(get_option('date_format'), strtotime($row->datetime))) . '">' . $diff . '</i>';
                                                    } elseif ($diff < 0) {
                                                        echo '<i class="fa fa-sort-down ml-2" style="color:rgb(241, 97, 18)" title="' . sprintf(__('The audit score went down by %s since %s', _SQ_PLUGIN_NAME_), abs($diff), date(get_option('date_format'), strtotime($row->datetime))) . '">' . abs($diff) . '</i>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </h4>

                                        <?php
                                        if ($lastaudit->security == 'incapsula') {
                                            echo '<h4><a href="https://en.wikipedia.org/wiki/Incapsula" target="_blank">' . __('Incapsula Protection Error', _SQ_PLUGIN_NAME_) . '</a></h4>';
                                        } elseif ($lastaudit->error) {
                                            ?>
                                            <input type="button" value="<?php echo __('Your blog returns an error', _SQ_PLUGIN_NAME_) ?>" data-domain="<?php echo get_bloginfo('url') ?>" class="btn btn-default btn-lg sq-errorbutton">
                                            <?php
                                        } else {
                                            echo '<p class="card-subtitle text-warning">Date: ' . date(get_option('date_format') . ' ' . get_option('time_format'), strtotime($lastaudit->datetime)) . '</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm card m-2 bg-light border-left">
                                    <div class="card-body row">
                                        <div class="card bg-light border-0 shadow-none mx-1 my-3 p-0 col-sm-12" style="box-shadow: none !important;">
                                            <div class="card-body m-0 p-0 text-center">
                                                <?php
                                                if (!empty($view->audits)) {
                                                    $last_audit = array_reverse($view->audits);
                                                    $last_audit = end($last_audit);

                                                    echo '<a class="btn btn-primary btn-lg ml-2" href="' . SQ_Classes_RemoteController::getMySquirrlyLink('audits') . '" target="_blank">' . __('Go to all audit panel', _SQ_PLUGIN_NAME_) . '</a>';

                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card col-sm-12 border-0 m-0 px-0">
                                <div class="card-body">
                                    <h4 class="card-title"><?php _e('Audits Score', _SQ_PLUGIN_NAME_) ?></h4>
                                    <p class="card-subtitle my-1 text-warning"><?php echo sprintf(__('last %s audits', _SQ_PLUGIN_NAME_), count((array)$view->audits)) ?></p>
                                    <div class="card-text mt-2 border">
                                        <?php
                                        if (!empty($view->audits)) {
                                            $view->audits = array_reverse($view->audits);
                                            echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAudits')->getScripts();
                                            $chart[0][0] = __('Date', _SQ_PLUGIN_NAME_);
                                            $chart[0][1] = __('On-Page', _SQ_PLUGIN_NAME_);
                                            $chart[0][2] = __('Off-Page', _SQ_PLUGIN_NAME_);
                                            $moz = 0;
                                            foreach ($view->audits as $key => $audit) {
                                                if ((int)$audit->moz > 0) {
                                                    $moz = (int)$audit->moz;
                                                } else {
                                                    $view->audits[$key]->moz = $moz;
                                                }
                                            }
                                            foreach ($view->audits as $key => $audit) {
                                                $chart[$key + 1][0] = date('d/m/Y', strtotime($audit->datetime));
                                                $chart[$key + 1][1] = (int)$audit->score;
                                                $chart[$key + 1][2] = (int)$audit->moz;
                                            }
                                            echo '
                                <div class="col-sm-12 p-0 m-0 border-0">
                                    <div id="sq_chart_audit" class="sq_chart no-p" style="width: 100%; height: 300px;"></div><script>jQuery(document).ready(function(){var sq_chart_val = drawChart("sq_chart_audit", ' . json_encode($chart) . ' ,true);}); </script>
                                </div>';
                                        } else {
                                            _e('No data yet', _SQ_PLUGIN_NAME_);
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="col-sm-8"></div>
                                    <div class="col-sm-3 text-right pl-4 pr-0"></div>
                                </div>
                            </div>

                            <div class="card col-sm-12 my-4 py-2 px-3 border-0 m-0">
                                <table class="sq_blog_list table table-light table-striped table-hover">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col"><?php _e('No.', _SQ_PLUGIN_NAME_) ?></th>
                                        <th scope="col"><?php _e('On-Page Score', _SQ_PLUGIN_NAME_) ?></th>
                                        <th scope="col"><?php _e('Off-Page Score', _SQ_PLUGIN_NAME_) ?></th>
                                        <th scope="col"><?php _e('Date', _SQ_PLUGIN_NAME_) ?></th>
                                        <th scope="col"><?php _e('Tasks', _SQ_PLUGIN_NAME_) ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cnt = 0;
                                    foreach ($view->audits as $key => $audit) {
                                        $cnt++;
                                        $tasks = array();
                                        foreach ($audit->tasks as $task) {
                                            $tasks[] = $task;
                                        }
                                        ?>
                                        <tr id="sq_tr<?php echo $audit->id ?>">
                                            <th scope="row" style="width: 30px;"><?php echo $cnt ?></th>
                                            <td style="width: 145px;">
                                                <span style="color:rgb(23, 198, 234); font-weight: bold"><?php echo $audit->score ?></span>
                                            </td>
                                            <td style="width: 145px;">
                                                <span style="color:rgb(251, 59, 71); font-weight: bold"><?php echo $audit->moz ?></span>
                                            </td>
                                            <td><?php echo $audit->datetime ?></td>
                                            <td style="cursor: pointer" title="<?php echo join("\n", $tasks) ?>">
                                                <strong><?php echo count((array)$audit->tasks) ?></strong> <?php _e('tasks found', _SQ_PLUGIN_NAME_) ?>
                                            </td>

                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card col-sm-12 px-0 py-2 border-0 m-0">
                                <?php $last_audit = end($view->audits); ?>
                                <div class="card-body">
                                    <h4 class="card-title"><?php _e('Tasks', _SQ_PLUGIN_NAME_) ?></h4>
                                    <p class="card-subtitle my-1 text-warning"><?php echo __('last issues found', _SQ_PLUGIN_NAME_) ?></p>
                                    <div class="card-text border">
                                        <table class="table">
                                            <tbody> <?php
                                            foreach ($last_audit->tasks as $task) {
                                                if ($task == '') continue;
                                                ?>
                                                <tr>
                                                    <td><?php echo $task ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <small><?php echo __('Update on', _SQ_PLUGIN_NAME_) . ': ' . date(get_option('date_format'), strtotime($last_audit->datetime)) ?></small>
                                </div>
                            </div>

                            <div class="card col-sm-12 bg-cta text-white rounded-0 py-0">
                                <div class="card-body">
                                    <h4 class="text-center">
                                        <?php echo sprintf(__('Learn how to improve your SEO Audit score over time %sClick Here%s'), '<a href="https://plugin.squirrly.co/wordpress-seo/what-is-the-site-visibility-score/" target="_blank" style="color: #ffea2a" >', '</a>') ?>
                                    </h4>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card-body">
                                <h4 class="text-center"><?php echo __('Welcome to Squirrly SEO Audits'); ?></h4>
                                <h5 class="text-center"><?php echo __('The SEO Audit is generated once every week'); ?></h5>
                                <h6 class="text-center text-black-50 mt-3"><?php echo __('Until the audit is ready, try the Focus Pages section'); ?>:</h6>
                                <div class="row col-sm-12 my-4 text-center">
                                    <div class="my-0 mx-auto justify-content-center text-center">
                                        <h6 onclick="location.href ='<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'pagelist') ?>'" class="text-black-50 text-right">
                                            <div style="float: right; cursor: pointer"><?php echo __('Go to Focus Pages'); ?></div>
                                            <i class="sq_icons_small sq_focuspages_icon" style="float: right; width: 20px; cursor: pointer"></i>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>


            </div>
            <div class="sq_col_side sticky">
                <div class="card col-sm-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                    <?php
                    if (!empty($view->pages)) {
                        foreach ($view->pages as $page) { ?>
                            <?php
                            if (!empty($page->categories)) {
                                foreach ($page->categories as $index => $category) {
                                    if (isset($category->assistant)) {
                                        echo $category->assistant;
                                    }
                                }
                            }
                            ?>
                        <?php }
                    } ?></div>
            </div>
        </div>
    </div>
</div>
