<?php defined('DIR') OR exit; ?>
    <div id="slideri-bg"></div>
    <!-- Content -->
    <div id="contenti">
        <div id="con-top" class="wrapper fix">
            <div id="search" class="left">
                <div id="sw">
                    <form action="<?php echo href(3) ?>" method="get">
                        <input type="text" name="search" value="<?php echo get('search') ?>" />
                        <input type="submit" value="ძიება" />
                    </form>
                </div>
            </div>
            <div id="social" class="right fix">
                <div id="stext"><?php echo l("join") ?></div>
                <ul>
                    <li><a href="<?php echo s("fblink") ?>" id="fb" target="_blank">facebook</a></li>
                    <li><a href="<?php echo s("twlink") ?>" id="tw" target="_blank">tweeter</a></li>
                </ul>
            </div>
        </div>
        <div id="news" class="wrapper fix">
            <h1><?php echo $title ?></h1>
<?php
    $num = count($lists);
    foreach ($lists as $item):
        $link = href($item["id"]);
?>
            <div class="news fix">
            <?php if ($item["image1"]!=''): ?>
                <div class="img left">
                    <a href="<?php echo $link ?>"><img src="<?php echo 'crop.php?img='.$item["image1"].'&n=4' ?>" width="150" height="150" alt="<?php echo $item["title"] ?>"></a>
                </div>
            <?php endif ?>
                <div class="date left" ><?php echo convert_date($item["postdate"]) ?></div>
                <h2><a href="<?php echo $link ?>"><?php echo $item["title"] ?></a></h2>
                <?php echo $item["description"] ?>
            </div>
<?php endforeach ?>
            <?php if ($page_max > 1): ?>
            <div id="pager" class="fix">
                <ul>
                <?php
                // echo $count_sql;
                // Pager Start
                    if (isset($item_count) AND $item_count > $num):
                        if ($page_cur > 1):
                ?>
                            <li><a href="<?php echo href($section["id"], array()) . '?page=1'; ?>">&lt;&lt;</a></li>
                            <li><a href="<?php echo href($section["id"], array()) . '?page=' . ($page_cur - 1); ?>">&lt;</a></li>
                <?php
                        endif;
                        $per_side = c('lists.page_count');
                        $index_start = ($page_cur - $per_side) <= 0 ? 1 : $page_cur - $per_side;
                        $index_finish = ($page_cur + $per_side) >= $page_max ? $page_max : $page_cur + $per_side;
                        if (($page_cur - $per_side) > 1)
                            echo '<li>...</li>';
                        for ($idx = $index_start; $idx <= $index_finish; $idx++):
                ?>
                                <li><a <?php echo ($page_cur==$idx) ? 'class="active"':'' ;?> href="<?php echo href($section["id"], array()) . '?page=' . $idx; ?>"><?php echo $idx ?></a></li>

                <?php
                        endfor;
                        if (($page_cur + $per_side) < $page_max)
                            echo '<li>...</li>';
                        if ($page_cur < $index_finish):
                ?>

                        <li><a href="<?php echo href($section["id"], array('page' => ($page_cur + 1))); ?>">&gt;</a></li>
                        <li><a href="<?php echo href($section["id"], array('page' => $page_max)); ?>">&gt;&gt;</a></li>
                <?php
                        endif;
                    endif;
                // Pager End
                ?>
                </ul>
            </div>
            <!-- #pager .fix -->
            <?php endif; ?>
            <div id="adb">
        </div>
    </div>
    <!-- Content End -->