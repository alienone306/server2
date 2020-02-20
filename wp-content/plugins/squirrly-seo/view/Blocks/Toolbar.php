<div id="sq_toolbarblog" class="col-sm-12 m-0 p-0">
    <nav class="navbar navbar-expand-sm" color-on-scroll="500">
        <div class=" container-fluid  ">
            <div class="justify-content-start" id="navigation">
                <ul class="nav navbar-nav mr-auto">
                    <?php
                    $mainmenu = SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getMainMenu();

                    if (!empty($mainmenu)) {
                        foreach ($mainmenu as $menuid => $item) {
                            if($menuid == 'sq_audits' && !SQ_Classes_Helpers_Tools::getMenuVisible('show_audit')){
                                continue;
                            }elseif($menuid == 'sq_rankings' && !SQ_Classes_Helpers_Tools::getMenuVisible('show_rankings')){
                                continue;
                            }elseif($menuid == 'sq_focuspages' && !SQ_Classes_Helpers_Tools::getMenuVisible('show_focuspages')){
                                continue;
                            }
                            //make sure the user has the capabilities
                            if (current_user_can($item['capability'])) {
                                if ($menuid <> 'sq_dashboard') {
                                    ?>
                                    <li class="nav-item" style="    padding-top: 8px;">
                                        <svg class="separator" height="40" width="20" xmlns="http://www.w3.org/2000/svg">
                                            <line stroke="lightgray" stroke-width="1" x1="0" x2="19" y1="0" y2="20"></line>
                                            <line stroke="lightgray" stroke-width="1" x1="0" x2="19" y1="40" y2="20"></line>
                                        </svg>
                                    </li>
                                <?php } ?>

                                <li class="nav-item <?php echo((SQ_Classes_Helpers_Tools::getValue('page', false) == $menuid) ? 'active' : '') ?>">
                                    <a class="nav-link" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl($menuid) ?>">
                                        <?php echo($menuid == 'sq_dashboard' ? __('Overview', _SQ_PLUGIN_NAME_) : $item['title']) ?>
                                    </a>
                                </li>
                            <?php }
                        }
                    } ?>
                    <li class="sq_help_toolbar" ><i class="fa fa-question-circle" onclick="jQuery('.header-search').toggle();"></i></li>
                </ul>
            </div>
        </div>
        <div id="sq_btn_toolbar_close" class="m-0 p-0">
            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" class="btn btn-lg bg-white text-black m-0 mx-2 p-2 px-3 font-weight-bold">X</a>
        </div>
    </nav>
</div>
<?php SQ_Classes_ObjController::getClass('SQ_Core_BlockSearch')->init(); ?>
