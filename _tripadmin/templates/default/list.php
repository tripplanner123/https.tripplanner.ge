<?php defined('DIR') OR exit ?>
<div id="news">
    <?php
    for ($idx = 0, $num = count($list); $idx < $num; $idx++):
        $link = href($list[$idx]['id']);
        $has_photo = (!empty($list[$idx]['pic1']));
    ?>
        <div class="list fix"<?php echo ($idx == ($num - 1)) ? ' style="background: none"' : NULL ?>>
        <?php if ($has_photo): ?>
            <a href="<?php echo $link ?>" class="img"><img src="resize.php?img=<?php echo str_replace(c('site.url'), NULL, $list[$idx]['pic1']) ?>&width=150&height=90" width="150" height="90" title="<?php echo $list[$idx]['title'] ?>" alt="<?php echo $list[$idx]['title'] ?>" /></a>
        <?php endif; ?>
            <div class="right fix"<?php !$has_photo AND print ' style="display: block; width: auto"'; ?>>
                <div class="info">
                    <span class="date"><?php echo convert_date($list[$idx]['postdate']) ?></span>
                    <span class="name"><a href="<?php echo $link ?>"><?php echo $list[$idx]['title'] ?></a></span>
                    <div class="text"><?php echo html_entity_decode($list[$idx]['description']); ?></div>
                </div>
                <div class="read"><a href="<?php echo $link ?>"><img src="images/read.png" width="9" height="7" title="<?php echo l('more') ?>" alt="<?php echo l('more'); ?>" /></a></div>
            </div>
        </div>
    <?php endfor; ?>

    <?php if ($item_count > $num): ?>
                <div id="page">

        <?php if ($page_cur > 1): ?>
                    <a href="<?php echo href($section) ?>&page=1">&lt;&lt;</a>
                    <a href="<?php echo href($section) ?>&page=<?php echo $page_cur - 1 ?>">&lt;</a>
        <?php endif; ?>

        <?php
                    $per_side = 5;
                    $index_start = ($page_cur - $per_side) <= 0 ? 1 : $page_cur - $per_side;
                    $index_finish = ($page_cur + $per_side) >= $page_max ? $page_max : $page_cur + $per_side;
                    if (($page_cur - $per_side) > 1)
                        echo '...';

                    for ($idx = $index_start; $idx <= $index_finish; $idx++):
        ?>
                        <a href="<?php echo href($section) ?>&page=<?php echo $idx ?>"<?php echo ($idx == $page_cur ? ' style="font-weight: bold"' : NULL); ?>><?php echo $idx ?></a>
        <?php
                        endfor;
                        if (($page_cur + $per_side) < $page_max)
                            echo '...';
        ?>

        <?php if ($page_cur < $index_finish): ?>
                            <a href="<?php echo href($section) ?>&page=<?php echo $page_cur + 1 ?>">&gt;</a>
                            <a href="<?php echo href($section) ?>&page=<?php echo $page_max ?>">&gt;&gt;</a>
        <?php endif; ?>

                        </div>
    <?php endif; ?>

</div>