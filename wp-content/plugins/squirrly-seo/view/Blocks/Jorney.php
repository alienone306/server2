<div class="card col-sm-12 p-0 border-0">
    <div class="card-body m-0 p-0">
        <div class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0">
            <div class="card-body p-0">
                <div class="col-sm-12 m-0 p-0">
                    <div class="card col-sm-12 m-0 p-0 border-0 ">

                        <div class="col-sm-12 m-0 p-3 text-center">
                            <?php if ($view->days > 14) { ?>
                                <h5 class="col-sm-12 card-title py-3 "><?php _e("Congratulations! You've completed the 14 Days Journey To Better Ranking", _SQ_PLUGIN_NAME_); ?></h5>
                            <?php } else { ?>
                                <h2 class="col-sm-12 card-title py-3 "><?php _e("Your 14 Days Journey To Better Ranking", _SQ_PLUGIN_NAME_); ?></h2>
                            <?php } ?>

                            <ul class="stepper horizontal horizontal-fix focused" id="horizontal-stepper-fix">
                                <?php for ($i = 1; $i <= 14; $i++) { ?>
                                    <li class="step <?php echo(($view->days >= $i) ? 'completed' : '') ?>">
                                        <div class="step-title waves-effect waves-dark">
                                            <?php echo(($view->days >= $i) ? '<a href="https://howto.squirrly.co/wordpress-seo/journey-to-better-ranking-day-' . $i . '/" target="_blank"><i class="fa fa-check-circle" style="color: darkcyan;"></i></a>' : '<i class="fa fa-circle-o"  style="color: darkgrey;"></i>') ?>
                                            <div><?php echo(($view->days >= $i) ? '<a href="https://howto.squirrly.co/wordpress-seo/journey-to-better-ranking-day-' . $i . '/" target="_blank">' . __('Day', _SQ_PLUGIN_NAME_) . ' ' . $i . '</a>' : __('Day', _SQ_PLUGIN_NAME_) . ' ' . $i) ?></div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>

                            <?php if ($view->days > 14) { ?>
                                <em class="text-black-50"><?php echo __("If you missed a day, click on it and read the SEO recipe for it.", _SQ_PLUGIN_NAME_); ?></em>
                                <div class="small text-center my-2">
                                    <form method="post" class="p-0 m-0">
                                        <?php wp_nonce_field('sq_journey_close', 'sq_nonce'); ?>
                                        <input type="hidden" name="action" value="sq_journey_close"/>
                                        <button type="submit" class="btn btn-sm text-info btn-link bg-transparent p-0 m-0">
                                            <?php echo __("I'm all done. Hide this block.", _SQ_PLUGIN_NAME_)  ?>
                                        </button>
                                    </form>
                                </div>
                            <?php } else { ?>
                                <a href="https://howto.squirrly.co/wordpress-seo/journey-to-better-ranking-day-<?php echo $view->days ?>/" target="_blank" class="btn btn-primary m-2 py-2 px-4" style="font-size: 20px;"><?php echo __('Day', _SQ_PLUGIN_NAME_) . ' ' . $view->days . ': ' . __("Open the SEO recipe for today", _SQ_PLUGIN_NAME_); ?></a>
                                <?php
                                switch ($view->days) {
                                    case 1:
                                        ?>
                                        <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'addpage') ?>" target="_blank" class="btn btn-success m-2 py-2 px-4" style="font-size: 20px;"><?php echo __("Add a page in Focus Pages", _SQ_PLUGIN_NAME_); ?></a><?php
                                        break;
                                    case 2:
                                        ?>
                                        <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') ?>" target="_blank" class="btn btn-success m-2 py-2 px-4" style="font-size: 20px;"><?php echo __("Do Keyword Research", _SQ_PLUGIN_NAME_); ?></a><?php
                                        break;
                                }
                                ?>
                            <?php } ?>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>

</div>