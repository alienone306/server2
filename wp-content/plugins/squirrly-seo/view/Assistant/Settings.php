<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_assistant'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3">
                <?php do_action('sq_form_notices'); ?>
                <form method="POST">
                    <?php wp_nonce_field('sq_settings_assistant', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_settings_assistant"/>

                    <div class="card col-sm-12 p-0">
                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="card-body p-2 bg-title rounded-top">
                                <div class="sq_icons sq_settings_icon m-2"></div>
                                <h3 class="card-title"><?php _e('Live Assistant Settings', _SQ_PLUGIN_NAME_); ?>:</h3>
                                <div class="card-title-description m-2"></div>
                            </div>
                            <div class="col-sm-12 text-left m-0 p-0">
                                <div class="card-title-description m-2"></div>
                            </div>

                        </div>
                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) { ?>
                            <div class="col-sm-12 py-0 text-right">
                                <button type="button" class="show_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0"><?php _e('Show Advanced Options', _SQ_PLUGIN_NAME_); ?></button>
                                <button type="button" class="hide_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0" style="display: none"><?php _e('Hide Advanced Options', _SQ_PLUGIN_NAME_); ?></button>
                            </div>
                        <?php } ?>
                        <div id="sq_seosettings" class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0">
                            <div class="card-body p-0">
                                <div class="col-sm-12 m-0 p-0">
                                    <div class="card col-sm-12 p-0 border-0 ">

                                        <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">
                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_keyword_help" value="0"/>
                                                        <input type="checkbox" id="sq_keyword_help" name="sq_keyword_help" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_keyword_help') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_keyword_help" class="ml-2"><?php _e('Squirrly Tooltips', _SQ_PLUGIN_NAME_); ?></label>
                                                        <div class="offset-1 small text-black-50"><?php echo sprintf(__('Show %sSquirrly Tooltips%s when posting a new article (e.g. "Enter a keyword").', _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1 sq_advanced">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_local_images" value="0"/>
                                                        <input type="checkbox" id="sq_local_images" name="sq_local_images" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_local_images') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_local_images" class="ml-2"><?php _e('Download Remote Images', _SQ_PLUGIN_NAME_); ?></label>
                                                        <div class="offset-1 small text-black-50"><?php echo sprintf(__('Download %sremote images%s in your %sMedia Library%s for the new posts.', _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<strong>', '</strong>'); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php _e("Prevent from losing the images you use in your articles in case the remote images are deleted.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1 sq_advanced">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_force_savepost" value="0"/>
                                                        <input type="checkbox" id="sq_force_savepost" name="sq_force_savepost" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_force_savepost') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_force_savepost" class="ml-2"><?php _e('Send Optimization On Save', _SQ_PLUGIN_NAME_); ?></label>
                                                        <div class="offset-1 small text-black-50"><?php _e("Send optimization data to Squirrly Cloud when the post is saved (don't use cron)", _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php _e("Use this option if your WordPress cron is not working properly.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_img_licence" value="0"/>
                                                        <input type="checkbox" id="sq_img_licence" name="sq_img_licence" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_img_licence') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_img_licence" class="ml-2"><?php _e('Copyright Free Images', _SQ_PLUGIN_NAME_); ?></label>
                                                        <div class="offset-1 small text-black-50"><?php echo sprintf(__('Search %sCopyright Free Images%s in Squirrly Live Assistant.', _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_sla" value="0"/>
                                                        <input type="checkbox" id="sq_sla" name="sq_sla" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_sla') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_sla" class="ml-2"><?php _e('Optimized Version Of Live Assistant', _SQ_PLUGIN_NAME_); ?></label>
                                                        <div class="offset-1 small text-black-50"><?php echo sprintf(__('Use %sthe NEW version of the SEO Live Assistant%s with Google and Human Friendly Analysis.', _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="bg-title p-2 sq_advanced">
                                            <h3 class="card-title"><?php _e('Places where you do NOT want Squirrly Live Assistant to load', _SQ_PLUGIN_NAME_); ?>:</h3>
                                            <div class="col-sm-12 text-left m-0 p-0">
                                                <div class="card-title-description mb-0 text-danger"><?php _e("Don't select anything if you wish Squirrly Live Assistant to load for all post types.", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 py-4 border-bottom tab-panel sq_advanced">
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Exclusions', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php _e('Select places where you do NOT want Squirrly Live Assistant to load.', _SQ_PLUGIN_NAME_); ?></div>
                                                    <div class="small text-black-50 my-1"><?php _e('Hold Control key to select multiple places', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group">
                                                    <input type="hidden" name="sq_sla_exclude_post_types[]" value="0"/>
                                                    <select multiple name="sq_sla_exclude_post_types[]" class="form-control bg-input mb-1" style="height: auto;">
                                                        <?php
                                                        $types = get_post_types(array('public' => true));
                                                        foreach ($types as $type) {
                                                            $type_data = get_post_type_object($type);
                                                            echo '<option value="' . $type . '" ' . (in_array($type, (array)SQ_Classes_Helpers_Tools::getOption('sq_sla_exclude_post_types')) ? 'selected="selected"' : '') . '>' . $type_data->labels->name . '</option>';
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-sm-12 my-3 p-0">
                        <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php _e('Save Settings', _SQ_PLUGIN_NAME_); ?></button>
                    </div>
                </form>
            </div>
            <div class="sq_col_side sticky">
                <div class="card col-sm-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
