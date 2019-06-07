<?php
    defined('DIR') OR exit;
    $num = count($events);
?>
        <header id="location-part">
            <div class="wrapper fix">
                <div id="location" class="left">
                    <div class="title">
                        <h1><?php echo $title; ?></h1>
                    </div>
                    <!-- .title -->
                    <ul>
                        <?php echo location(); ?>
                    </ul>
                </div>
                <!-- #location .left -->
                <div id="share">
                    <div class="left"><?php echo l('share'); ?></div>
                    <ul class="right">
                        <li>
                            <div class="fb-share-button share-btn" data-href="<?php echo href($storage->section["id"]) ?>" data-type="button"></div>
                            <img src="<?php echo WEBSITE;?>/images/share-fb.png" width="32" height="32" alt="Facebook Share" />
                        </li>
                        <li>
                            <a href="https://twitter.com/share" class="twitter-share-button share-btn" data-url="<?php echo href($storage->section["id"]) ?>" data-count="none"></a><img src="<?php echo WEBSITE;?>/images/share-tw.png" width="32" height="32" alt="Twitter Share" />
                        </li>
                        <li>
                            <div class="g-plus share-btn" data-action="share" data-annotation="none"></div>
                            <img src="<?php echo WEBSITE;?>/images/share-gp.png" width="32" height="32" alt="GooglePlus Share" />
                        </li>
                    </ul>
                </div>
                <!-- #share -->
            </div>
            <!-- .wrapper fix -->
        </header>
        <!-- #location-part -->
        <article id="page" class="wrapper">
        <?php if (content($content)!=''): ?>
            <div class="headline">
                <div class="text">
                    <?php echo content($content); ?>
                </div>
                <!-- .text -->
            </div>
            <!-- .headline -->
        <?php endif ?>
            <section id="sort">
                <ul>
                    <li><a href="<?php echo href(5) ?>" class="bdr"><?php echo l('all'); ?></a></li>
                    <?php foreach ($neighbor as $item): ?>
                    <li><a href="<?php echo href($item["id"]); ?>" class="<?php echo ($id==$item["id"]) ? "active " : "" ?>bdr"><?php echo $item["title"]; ?></a></li>
                    <?php endforeach ?>
                </ul>
            </section>
            <!-- #sort -->
            <div class="keeper fix">
<?php
$i = 0;
foreach ($events as $item):
    $link = href($item['id']);
    $i++;
    if ($i==5) {$class=" first"; $i=1;} else {$class=null;}
?>
                <article class="project left<?php echo $class ?> bdr">
                    <header class="title">
                        <h2><?php echo $item['title'] ?></h2>
                    </header>
                    <!-- .title -->
                    <div class="img">
                        <img src="<?php echo ($item['image1']!='') ? 'crop.php?img=' . $item['image1'] . '&width=278&height=170' : '';?>" width="278" height="170" alt="">
                        <div class="mark"></div>
                    </div>
                    <!-- .img -->
                    <div class="text"><?php echo $item['description'] ?></div>
                    <!-- .text -->
                    <div class="view bdr">
                        <div class="link">
                            <div class="detail">
                                <a href="<?php echo $link ?>" class="bdr"><?php echo l('more'); ?></a>
                            </div>
                            <!-- .detail -->
                        <?php if ($item['field1']!=''): ?>
                            <div class="website">
                                <a href="<?php echo $item['field1'] ?>" class="bdr" target="_blank"><?php echo l('website'); ?></a>
                            </div>
                            <!-- .website -->
                        <?php endif ?>
                        </div>
                        <!-- .link -->
                    </div>
                    <!-- .view bdr -->
                </article>
                <!-- .project bdr left -->
<?php
    endforeach;
?>
            </div>
            <!-- .keeper fix -->
        <?php if ($num > 0) : ?>
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
                        $per_side = c('news.page_count');
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

                        <li><a href="<?php echo href($section["id"], array()) . '?page=' . ($page_cur + 1); ?>">&gt;</a></li>
                        <li><a href="<?php echo href($section["id"], array()) . '?page=' . $page_max; ?>">&gt;&gt;</a></li>
                <?php
                        endif;
                    endif;
                // Pager End
                ?>
                </ul>
            </div>
            <!-- #pager .fix -->
            <?php endif; ?>
        </section>
        <!-- #page .wrapper -->