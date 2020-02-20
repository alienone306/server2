<?php
$edit_link = false;

if (isset($view->post->ID)) {
    if ($view->post->post_type <> 'profile') {
        $edit_link = get_edit_post_link($view->post->ID, false);
    }
}

if (strtotime($view->focuspage->audit_datetime)) {
    $audit_timestamp = strtotime($view->focuspage->audit_datetime) + ((int)get_option('gmt_offset') * 3600);
    $audit_timestamp = date(get_option('date_format') . ' ' . get_option('time_format'), $audit_timestamp);
} else {
    $audit_timestamp = $view->focuspage->audit_datetime;
}
$call_timestamp = 0;
if (get_transient('sq_focuspage_' . $view->post->ID)) {
    $call_timestamp = (int)get_transient('sq_focuspage_' . $view->post->ID);
}
$categories = apply_filters('sq_assistant_categories_page', $view->focuspage->id);

if (isset($view->post->ID) && $view->post->ID > 0) {
    ?>
    <td style="min-width: 380px;">
        <?php if ($view->post) { ?>
            <div class="col-sm-12 px-0 mx-0 font-weight-bold">
                <?php echo $view->post->sq->title ?> <?php echo(($view->post->post_status <> 'publish' && $view->post->post_status <> 'inherit' && $view->post->post_status <> '') ? ' <spam style="font-weight: normal">(' . $view->post->post_status . ')</spam>' : '') ?>
                <?php if ($edit_link) { ?>
                    <a href="<?php echo $edit_link ?>" target="_blank">
                        <i class="fa fa-edit" style="font-size: 11px"></i>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="small" style="font-size: 11px"><?php echo '<a href="' . $view->post->url . '"  class="text-link" rel="permalink" target="_blank">' . urldecode($view->post->url) . '</a>' ?></div>
        <div class="small my-1"><?php echo __('Last audited', _SQ_PLUGIN_NAME_) ?>:
            <span class="text-danger"><?php echo $audit_timestamp ?></span>
        </div>
        <form method="post" class="p-0 m-0">
            <?php wp_nonce_field('sq_focuspages_update', 'sq_nonce'); ?>
            <input type="hidden" name="action" value="sq_focuspages_update"/>
            <input type="hidden" name="id" value="<?php echo $view->post->ID ?>"/>
            <input type="hidden" name="user_post_id" value="<?php echo $view->focuspage->user_post_id ?>"/>
            <button type="submit" class="btn btn-sm bg-warning text-white inline p-0 px-2 m-0" <?php if ($call_timestamp > time() - 300) {
                echo 'disabled="disabled"' . ' title="' . __('You can refresh the audit once every 5 minutes', _SQ_PLUGIN_NAME_) . '"';
            } ?>>
                <?php echo __('Request new audit', _SQ_PLUGIN_NAME_) ?>
            </button>
        </form>
    </td>
    <?php if ($view->focuspage->audit_error) { ?>
        <td colspan="<?php echo (count((array)$categories) + 2) ?>">
            <div class="text-danger my-2"><?php echo __('Could not create the audit for this URL', _SQ_PLUGIN_NAME_) ?></div>
            <div class="text-black-50" style="font-size: 11px"><em><?php echo sprintf(__('The current way your WordPress site is hosted can cause experience issues to the way Squirrly SEO works. %s In order to serve you with the best data, and make sure that the Focus Pages audits can be processed, you will need to talk to your hosting provider and tell them to make the following settings. %s Please add the IP addresses 176.9.59.55 and 176.9.112.210 in the white-list for remote access and it should work.', _SQ_PLUGIN_NAME_),'<br />','<br />') ?></em></div>
        </td>
    <?php } else { ?>
        <td style="min-width: 100px; "><?php echo $view->focuspage->incomplete ?></td>
        <td style="min-width: 150px;"><?php echo $view->focuspage->visibility . ((int)$view->focuspage->visibility > 0 ? '%' : '') ?></td>

        <?php if (!empty($categories)) {
            foreach ($categories as $name => $category) { ?>
                <td style="min-width: 100px; ">
                    <div class="sq_show_assistant <?php echo(($category->value === false) ? 'sq_circle_label' : '') ?>" data-id="<?php echo $view->focuspage->id ?>" data-category="<?php echo $name ?>" style="cursor: pointer; <?php echo(($category->value === false) ? 'background-color' : 'color') ?>: <?php echo $category->color ?>;" title="<?php echo $category->title ?>" <?php echo(($category->value === false) ? 'class="sq_circle_label"' : '') ?>><?php echo(($category->value !== false) ? $category->value : '') ?></div>
                </td>
                <?php
            }
        }
    } ?>

    <td class="px-0" style="width: 20px">
        <div class="sq_sm_menu">
            <div class="sm_icon_button sm_icon_options">
                <i class="fa fa-ellipsis-v"></i>
            </div>
            <div class="sq_sm_dropdown">
                <ul class="p-2 m-0 text-left">
                    <li class="m-0 p-1 py-2">
                        <form method="post" class="p-0 m-0">
                            <?php wp_nonce_field('sq_focuspages_delete', 'sq_nonce'); ?>
                            <input type="hidden" name="action" value="sq_focuspages_delete"/>
                            <input type="hidden" name="id" value="<?php echo $view->focuspage->user_post_id ?>"/>
                            <i class="sq_icons_small fa fa-trash-o" style="padding: 2px"></i>
                            <button type="submit" class="btn btn-sm bg-transparent p-0 m-0">
                                <?php echo __('Delete Focus Page', _SQ_PLUGIN_NAME_) ?>
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