<?php
if(isset($view->stats)) {
    if (count((array)$view->stats) == 6) { ?>
        <?php
        $col = 0;
        foreach ($view->stats as $name => $stat) {
            if ($col % 3 == 0) {
                echo '<div id="sq_stats" class="row my-1 py-2">';
            }
            $col++;
            ?>
            <div class="col-sm bg-light border rounded m-1 p-4">
                <div class="sq_stats_text"><?php echo $stat['text'] ?></div>
                <i class="sq_stats_icon sq_stats_<?php echo $name ?>"></i>
                <div class="sq_stats_value"><?php echo $stat['value'] ?></div>
                <div class="col-sm-12 text-right" style="margin-top: -17px;"><?php echo(isset($stat['link']) ? '<a href="' . $stat['link'] . '" >' . $stat['linktext'] . '</a>' : '') ?></div>
            </div>
            <?php
            if ($col % 3 == 0) {
                echo '</div>';
            }


        } ?>

        <?php
    }
}