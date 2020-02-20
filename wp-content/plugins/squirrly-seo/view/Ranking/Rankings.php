<?php
$date_format = get_option('date_format');
$time_format = get_option('time_format');
$timezone = (int)get_option('gmt_offset');
$connect = json_decode(json_encode(SQ_Classes_Helpers_Tools::getOption('connect')));
$view->checkin->subscription_serpcheck = (isset($view->checkin->subscription_serpcheck) ? $view->checkin->subscription_serpcheck : 0);
?>
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
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'rankings'), 'sq_rankings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-sm-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons sq_rankings_icon m-2"></div>
                        <h3 class="card-title"><?php _e('Google Rankings', _SQ_PLUGIN_NAME_); ?>:</h3>
                        <?php if ($view->checkin->subscription_serpcheck) { ?>
                            <div class="card-title-description m-2"><?php _e("It's a fully functional SEO Ranking Tool that helps you find the true position of your website in Google for any keyword and any country you want", _SQ_PLUGIN_NAME_); ?></div>
                        <?php } else { ?>
                            <div class="card-title-description m-2"><?php _e("See the Google Search Console average possition, click and impressions for organic keywords", _SQ_PLUGIN_NAME_); ?></div>

                        <?php } ?>
                    </div>


                    <div id="sq_ranks" class="card col-sm-12 p-0 tab-panel border-0">
                        <?php
                        if (SQ_Classes_Helpers_Tools::getMenuVisible('show_ads')) {
                            if ($view->checkin->subscription_serpcheck) {
                                echo '<div class="alert alert-success text-center">';
                                echo sprintf(__("%sSERP Checker Business:%s We update the best ranks for each keyword, daily. 100%% accurate and objective.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>');
                                echo '</div>';

                                if (!$view->checkin->subscription_serps) {
                                    echo '<div class="alert alert-success text-center">';
                                    echo sprintf(__("%sNo SERP queries remained.%s Please check your %saccount status and limits%s", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('account') . '" target="_blank"><strong>', '</strong></a>');
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="alert alert-warning text-center">';
                                echo sprintf(__("%sSERP Checker Lite:%s We show ranks according to what Google shows you in Google Search Console. Positions shown by GSC are averages, not exact positions in SERPs. To have your rankings checked daily please upgrade your plan to %sBusiness Plan%s", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('plans') . '" target="_blank"><strong>', '</strong></a>');
                                echo '</div>';
                            }


                        }

                        if (!$connect->google_search_console) { ?>
                            <div class="form-group my-5 col-sm-8 offset-2">
                                <?php echo $view->getView('Connect/GoogleSearchConsole'); ?>
                            </div>
                        <?php } ?>

                        <?php if (SQ_Classes_Helpers_Tools::getIsset('schanges') ||
                            SQ_Classes_Helpers_Tools::getIsset('ranked') ||
                            SQ_Classes_Helpers_Tools::getIsset('rank') ||
                            SQ_Classes_Helpers_Tools::getIsset('skeyword') ||
                            SQ_Classes_Helpers_Tools::getIsset('type') ||
                            SQ_Classes_Helpers_Tools::getValue('skeyword', '')
                        ) { ?>
                            <div class="text-right col-sm-12 p-0 px-2 my-2">
                                <div class="sq_serp_settings_button mx-1 my-0">
                                    <button type="button" class="btn btn-info p-v-xs" onclick="location.href = '<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings') ?>';" style="cursor: pointer"><?php echo __('Show All') ?></button>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($view->ranks) && !empty($view->ranks)) { ?>
                            <?php if ($view->checkin->subscription_serpcheck) { ?>
                                <?php if (isset($view->info) && !empty($view->info)) { ?>
                                    <?php if (!SQ_Classes_Helpers_Tools::getValue('skeyword', false)) { ?>
                                        <div class="card-group mb-5 mx-0">
                                            <div class="card  bg-light mx-2 col-sm-6">
                                                <div class="row card-body py-2 px-2">
                                                    <div class="card-text col-sm-5 px-2">
                                                        <h2>
                                                            <?php
                                                            if (isset($view->info->average) && !empty($view->info->average)) {
                                                                $today_average = end($view->info->average);
                                                                $today_average = number_format((int)$today_average[1], 2);
                                                                reset($view->info->average);
                                                            } else {
                                                                $today_average = '0';
                                                            }

                                                            ?>
                                                            <a href="<?php echo esc_url(add_query_arg(array('ranked' => 1), SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings'))) ?>" data-toggle="tooltip" title="<?php echo __('Only show ranked articles', _SQ_PLUGIN_NAME_) ?>">
                                                                <i class="fa fa-line-chart pull-left mt-1" aria-hidden="true"></i>
                                                                <?php echo($today_average == 0 ? 100 : $today_average) ?>
                                                            </a>
                                                        </h2>
                                                        <span class="info-box-title my-2" style="display: block; clear: both; padding: 5px 0 0 0;"><?php _e('Today Avg. Ranking', _SQ_PLUGIN_NAME_); ?></span>
                                                    </div>
                                                    <?php
                                                    if (isset($view->info->average) && count((array)$view->info->average) > 1) {
                                                        echo $view->getScripts();
                                                        foreach ($view->info->average as $key => $average) {
                                                            if ($key > 0 && !empty($view->info->average[$key])) {
                                                                $view->info->average[$key][0] = date('d/m/Y', strtotime($view->info->average[$key][0]));
                                                                $view->info->average[$key][1] = (float)$view->info->average[$key][1];
                                                                if ($view->info->average[$key][1] == 0) {
                                                                    $view->info->average[$key][1] = 100;
                                                                }
                                                            }
                                                            $average[1] = (int)$average[1];
                                                        }

                                                        echo '
                                                            <div class="col-sm-7 px-0">
                                                                <div id="sq_chart" class="sq_chart no-p" style="width:100%; height: 70px;"></div><script>jQuery(document).ready(function(){var sq_chart_val = drawChart("sq_chart", ' . json_encode($view->info->average) . ' ,true);}); </script>
                                                            </div>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="card  bg-light mx-2 col-sm-6 border">
                                                <div class="card-body p-0">
                                                    <div class="card-text mt-2">
                                                        <h2 class="mb-3">
                                                            <a href="<?php echo esc_url(add_query_arg(array('schanges' => 1), SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings'))) ?>" data-toggle="tooltip" title="<?php echo __('Only show SERP changes', _SQ_PLUGIN_NAME_) ?>">
                                                                <i class="fa fa-arrows-v pull-left mt-1" aria-hidden="true"></i>
                                                                <?php
                                                                $changes = 0;
                                                                if (!empty($view->ranks))
                                                                    foreach ($view->ranks as $key => $row) {
                                                                        if ($row->change) {
                                                                            $changes++;
                                                                        }
                                                                    }
                                                                echo $changes;
                                                                ?>
                                                            </a>
                                                        </h2>
                                                        <span class="info-box-title" style="padding: 5px 0 0 0;"><?php _e('Today SERP Changes', _SQ_PLUGIN_NAME_); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <div class="card col-sm-12 py-3 px-0 m-0 border-0">

                                <div class="col-3">
                                    <select name="sq_bulk_action" class="sq_bulk_action">
                                        <option value=""><?php echo __('Bulk Actions') ?></option>
                                        <option value="sq_ajax_rank_bulk_delete" data-confirm="<?php echo __('Ar you sure you want to delete the keyword?', _SQ_PLUGIN_NAME_) ?>"><?php echo __('Delete', _SQ_PLUGIN_NAME_) ?></option>
                                        <?php if ($view->checkin->subscription_serpcheck) { ?>
                                            <option value="sq_ajax_rank_bulk_refresh"><?php echo __('Refresh Serp', _SQ_PLUGIN_NAME_) ?></option>
                                        <?php } ?>
                                    </select>
                                    <button class="sq_bulk_submit btn btn-sm btn-default"><?php _e('Apply'); ?></button>
                                </div>

                                <table class="table table-light table-striped table-hover table-ranks">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th style="width: 10px;"></th>
                                        <th><?php echo __('Keyword', _SQ_PLUGIN_NAME_) ?></th>
                                        <th><?php echo __('Path', _SQ_PLUGIN_NAME_) ?></th>
                                        <?php if ($view->checkin->subscription_serpcheck) { ?>
                                            <th><?php echo __('Rank', _SQ_PLUGIN_NAME_) ?></th>
                                            <th><?php echo __('Best', _SQ_PLUGIN_NAME_) ?></th>
                                        <?php } else { ?>
                                            <th><?php echo __('Avg Rank', _SQ_PLUGIN_NAME_) ?></th>
                                        <?php } ?>
                                        <th><?php echo __('Details', _SQ_PLUGIN_NAME_) ?></th>

                                        <th class="no-sort" style="width: 2%;"></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($view->ranks as $key => $row) {
                                        if (SQ_Classes_Helpers_Tools::getIsset('schanges') && isset($row->change) && !$row->change) {
                                            continue;
                                        }
                                        if (SQ_Classes_Helpers_Tools::getIsset('ranked') && isset($row->rank) && !$row->rank) {
                                            continue;
                                        }
                                        ?>

                                        <tr>
                                            <td style="width: 10px;">
                                                <input type="checkbox" name="sq_edit[]" class="sq_bulk_input" value="<?php echo $row->keyword ?>"/>
                                            </td>
                                            <td><span><?php echo $row->keyword ?></span></td>
                                            <?php if (!$row->permalink && !$view->checkin->subscription_serpcheck) { ?>
                                                <td style="color: #919aa2; font-style: italic">
                                                    <?php echo __('Google Search Console has no data for this keyword', _SQ_PLUGIN_NAME_) ?>
                                                    <br/>
                                                </td>
                                                <td></td>
                                                <?php if ($view->checkin->subscription_serpcheck) { ?>
                                                    <td></td>
                                                <?php } ?>
                                                <td>
                                                    <?php if ($connect->google_search_console) { ?>
                                                        <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'gscsync') ?>" class="btn btn-sm btn-info"><?php echo __('Sync Keywords'); ?></a>
                                                    <?php } ?>
                                                </td>
                                            <?php } else { ?>
                                                <td>
                                                    <?php
                                                    $path = parse_url($row->permalink, PHP_URL_PATH);
                                                    $path = ($path <> '') ? $path : '/';
                                                    ?>
                                                    <a href="<?php echo $row->permalink ?>" target="_blank"><?php echo $path ?></a>
                                                </td>
                                                <?php if ($view->checkin->subscription_serpcheck) { ?>
                                                    <td>
                                                        <?php
                                                        echo(!$row->rank ? '<span style="font-size: 13px">' . __('Not indexed', _SQ_PLUGIN_NAME_) . '</span>' : (int)$row->rank);
                                                        if (isset($row->change)) {
                                                            echo(($row->change) ? sprintf('<span class="badge badge-' . ($row->change < 0 ? 'success' : 'danger') . ' mx-2"><i class="fa fa-sort-%s"></i><span> </span><span>%s</span></span>', ($row->change < 0 ? 'up' : 'down'), $row->change) : '');
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php echo (int)$row->best; ?>
                                                    </td>
                                                <?php } else { ?>
                                                    <td title="<?php echo __('Google Search Console has no data for this keyword', _SQ_PLUGIN_NAME_) ?>">
                                                        <?php echo($row->average_position <= 0 ? __('GSC', _SQ_PLUGIN_NAME_) : $row->average_position); ?>
                                                    </td>
                                                <?php } ?>
                                                <td>
                                                    <button onclick="jQuery('#sq_ranking_modal<?php echo $key ?>').modal('show');" class="small btn btn-success btn-sm" style="cursor: pointer; width: 120px"><?php echo __('rank details', _SQ_PLUGIN_NAME_) ?></button>
                                                </td>
                                            <?php } ?>

                                            <td>
                                                <div class="sq_sm_menu">
                                                    <div class="sm_icon_button sm_icon_options">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </div>
                                                    <div class="sq_sm_dropdown">
                                                        <ul class="p-2 m-0 text-left">
                                                            <?php if ($view->checkin->subscription_serpcheck) { ?>
                                                                <li class="border-bottom m-0 p-1 py-2" data-id="<?php echo $row->id ?>">
                                                                    <form method="post" class="p-0 m-0">
                                                                        <?php wp_nonce_field('sq_serp_refresh_post', 'sq_nonce'); ?>
                                                                        <input type="hidden" name="action" value="sq_serp_refresh_post"/>
                                                                        <input type="hidden" name="id" value="<?php echo $row->id ?>"/>
                                                                        <input type="hidden" name="keyword" value="<?php echo htmlspecialchars($row->keyword) ?>"/>
                                                                        <i class="sq_icons_small fa fa-refresh" style="padding: 2px"></i>
                                                                        <button type="submit" class="btn btn-sm bg-transparent p-0 m-0">
                                                                            <?php echo __('Check Ranking again', _SQ_PLUGIN_NAME_) ?>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            <?php } ?>

                                                            <li class="m-0 p-1 py-2">
                                                                <form method="post" class="p-0 m-0">
                                                                    <?php wp_nonce_field('sq_serp_delete_keyword', 'sq_nonce'); ?>
                                                                    <input type="hidden" name="action" value="sq_serp_delete_keyword"/>
                                                                    <input type="hidden" name="keyword" value="<?php echo htmlspecialchars($row->keyword) ?>"/>
                                                                    <i class="sq_icons_small fa fa-trash-o" style="padding: 2px"></i>
                                                                    <button type="submit" class="btn btn-sm bg-transparent p-0 m-0">
                                                                        <?php echo __('Remove Keyword', _SQ_PLUGIN_NAME_) ?>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>


                                            </td>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>

                                <?php foreach ($view->ranks as $key => $row) {
                                    if (SQ_Classes_Helpers_Tools::getIsset('schanges') && isset($row->change) && !$row->change) {
                                        continue;
                                    }
                                    if (SQ_Classes_Helpers_Tools::getIsset('ranked') && isset($row->rank) && !$row->rank) {
                                        continue;
                                    }
                                    ?>
                                    <div id="sq_ranking_modal<?php echo $key; ?>" class="sq_ranking_modal modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-light">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><?php echo __('Keyword', _SQ_PLUGIN_NAME_); ?>: <?php echo $row->keyword ?>
                                                        <span style="font-weight: bold; font-size: 110%"></span>
                                                    </h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body pt-0" style="min-height: 90px;">
                                                    <ul class="col-sm-12">
                                                        <li class="row py-2 border-bottom">
                                                            <div class="col-sm-12">
                                                                <strong><a href="<?php echo $row->permalink ?>" target="_blank"><?php echo $row->permalink ?></a></strong>
                                                            </div>
                                                        </li>

                                                        <li class="row py-2 border-bottom">
                                                            <div class="col-sm-6"><?php echo __('Impressions', _SQ_PLUGIN_NAME_) ?>:</div>
                                                            <div class="col-sm-6">
                                                                <strong><?php echo $row->impressions ?></strong>
                                                            </div>
                                                        </li>
                                                        <li class="row py-2 border-bottom">
                                                            <div class="col-sm-6"><?php echo __('Clicks', _SQ_PLUGIN_NAME_) ?>:</div>
                                                            <div class="col-sm-6">
                                                                <strong><?php echo $row->clicks ?></strong>
                                                            </div>
                                                        </li>

                                                        <li class="row py-2 border-bottom">
                                                            <div class="col-sm-6"><?php echo __('Optimized with SLA', _SQ_PLUGIN_NAME_) ?>:</div>
                                                            <div class="col-sm-6">
                                                                <strong><?php echo($row->optimized > 0 ? $row->optimized . '%' : 'N/A') ?></strong>
                                                            </div>
                                                        </li>

                                                        <?php if ($view->checkin->subscription_serpcheck) { ?>
                                                            <li class="row py-3 border-bottom">
                                                                <div class="col-sm-6"><?php echo __('Social Shares', _SQ_PLUGIN_NAME_) ?>:</div>
                                                                <div class="col-sm-6">
                                                                    <?php
                                                                    echo __("Facebook", _SQ_PLUGIN_NAME_) . ": <strong>" . $row->facebook . "</strong><br />";
                                                                    echo __("Reddit", _SQ_PLUGIN_NAME_) . ": <strong>" . $row->reddit . "</strong><br />";
                                                                    echo __("Pinterest", _SQ_PLUGIN_NAME_) . ": <strong>" . $row->pinterest . "</strong><br />";
                                                                    ?>
                                                                </div>
                                                            </li>
                                                        <?php } ?>

                                                        <li class="row py-2 border-bottom">
                                                            <div class="col-sm-6"><?php echo __('Country', _SQ_PLUGIN_NAME_) ?>:</div>
                                                            <div class="col-sm-6">
                                                                <strong><?php echo $row->country ?></strong>
                                                            </div>
                                                        </li>

                                                        <?php if (isset($row->datetime)) { ?>
                                                            <li class="row py-2 border-bottom-0">
                                                                <div class="col-sm-6"><?php echo __('Date', _SQ_PLUGIN_NAME_) ?>:</div>
                                                                <div class="col-sm-6">
                                                                    <strong><?php echo date(get_option('date_format'), strtotime($row->datetime)) ?></strong>
                                                                </div>
                                                            </li>
                                                        <?php } ?>

                                                        <li class="small text-center"><?php echo __('Note! The clicks and impressions data is taken from Google Search Console for the last 90 days for the current URL', _SQ_PLUGIN_NAME_) ?></li>

                                                    </ul>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                            </div>
                        <?php } elseif (SQ_Classes_Helpers_Tools::getIsset('skeyword') || SQ_Classes_Helpers_Tools::getIsset('slabel')) { ?>
                            <div class="card-body">
                                <h3 class="text-center"><?php echo __('No ranking found.', _SQ_PLUGIN_NAME_); ?></h3>
                            </div>
                        <?php } else { ?>
                            <div class="card-body">
                                <h4 class="text-center"><?php echo __('Welcome to Squirrly Rankings'); ?></h4>
                                <h5 class="text-center"><?php echo __('To see how your website is ranking on Google'); ?>:</h5>
                                <div class="row col-sm-12 my-4">
                                    <div class="col-sm text-right">
                                        <h6 onclick="location.href ='<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') ?>'" class="text-black-50 text-right">
                                            <div style="float: right; cursor: pointer"><?php echo __('Add keywords in Briefcase'); ?></div>
                                            <i class="sq_icons_small sq_briefcase_icon" style="float: right; width: 20px; cursor: pointer"></i>
                                        </h6>
                                    </div>
                                    <div class="col-sm text-left">
                                        <h6 class="text-black-50">
                                            <i class="fa fa-ellipsis-v mx-2"></i><?php echo __('Then send keywords to Rank Checker'); ?>
                                        </h6>
                                    </div>
                                </div>

                            </div>
                        <?php } ?>
                    </div>

                    <?php if ($connect->google_search_console) { ?>
                        <div class="row col-sm-12 my-4 text-center">
                            <div class="my-0 mx-auto justify-content-center text-center">
                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'gscsync') ?>" class="btn btn-info"><?php echo __('Synchronize Keywords with Google Search Console'); ?></a>
                            </div>
                        </div>
                    <?php } ?>
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
