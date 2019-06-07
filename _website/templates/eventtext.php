<?php defined('DIR') OR exit; global $storage; ?>
        <header id="location-part">
            <div class="wrapper fix">
                <div id="location" class="left">
                    <div class="title">
                        <h2><?php echo $headline; ?></h2>
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
        <article id="page" class="wrapper fix">
            <section id="sort">
                <ul>
                    <li><a href="<?php echo href(5) ?>" class="bdr"><?php echo l('all') ?></a></li>
                    <?php foreach ($allmenu as $item): ?>
                    <li><a href="<?php echo href($item["id"]) ?>" class="<?php echo ($headline==$item["title"]) ? "active " : "" ?>bdr"><?php echo $item["title"]; ?></a></li>
                    <?php endforeach ?>
                </ul>
            </section>
            <!-- #sort -->
            <div id="read" class="portfolio fix">
            <?php if (content($image1)!=""): ?>
                <div class="image left">
                    <a href="<?php echo content($image1); ?>" rel="prettyPhoto[3]"><img src="<?php echo (content($image1)!='') ? 'crop.php?img=' . content($image1) . '&width=580&height=350' : '';?>"  width="580" height="350" alt="<?php echo $title; ?>"></a>
                </div>
                <!-- .image left -->
            <?php endif ?>
                <header class="title">
                    <h1><?php echo $title; ?></h1>
                </header>
                <!-- .title -->
                <div class="data">
                <?php
                    (strpos($storage->section['field1'],'www.') !== false) ? $www = "" : $www = "www.";
                    if ($storage->section['field1']!=""):
                ?>
                    <div><?php echo l('adress') ?>: <a href="<?php echo $storage->section['field1'] ?>" target="_blank"><?php echo rtrim(str_replace("http://", "".$www."", $storage->section['field1']), "/") ?></a></div>
                <?php endif ?>
                <?php if ($storage->section['field2']!=""): ?>
                    <div><?php echo l('tech') ?>: <span><?php echo $storage->section['field2'] ?></span></div>
                <?php endif ?>
                    <div><?php echo l('work.period') ?>: <span><?php echo convert_date($postdate)." - ".convert_date($storage->section['expiredate']) ?></span></div>
                <?php
                    if ($storage->section['field3']!=""):
                    if($storage->section['field4']=="") {
                        $second = null;
                        $order = null;
                    } else {
                        $second = ",".$storage->section['field4'];
                        $order = " ORDER BY FIELD(id, ".$storage->section['field3']."".$second.")";
                    }
                    $programmer = db_fetch_all("SELECT id, title FROM pages WHERE id in (".$storage->section['field3']."".$second.") AND language='".l()."'".$order."");
                ?>
                <div><?php echo l('programmers') ?>: 
                <?php
                    $i = 0;
                    $cnt = count($programmer);
                    $comma = ",";
                    foreach ($programmer as $item):
                        $i++;
                        if ($i == $cnt)
                            $comma = ""; 
                ?>
                    <a href="<?php echo href($item['id']) ?>"><?php echo $item['title'] ?></a><?php echo $comma ?>
                <?php
                    endforeach;
                ?>
                </div>
                <?php
                    endif;
                    if ($storage->section['field5']!=""):
                    if($storage->section['field6']=="") {
                        $second = null;
                        $order = null;
                    } else {
                        $second = ",".$storage->section['field6'];
                        $order = " ORDER BY FIELD(id, ".$storage->section['field5']."".$second.")";
                    }
                    $designer = db_fetch_all("SELECT id, title FROM pages WHERE id in (".$storage->section['field5']."".$second.") AND language='".l()."'".$order."");
                ?>
                <div><?php echo l('designers') ?>: 
                <?php
                    $i = 0;
                    $cnt = count($designer);
                    $comma = ",";
                    foreach ($designer as $item):
                        $i++;
                        if ($i == $cnt)
                            $comma = ""; 
                ?>
                    <a href="<?php echo href($item['id']) ?>"><?php echo $item['title'] ?></a><?php echo $comma ?>
                <?php
                    endforeach;
                ?>
                </div>
                <?php
                    endif;
                    if ($storage->section['field7']!=""):
                    if($storage->section['field8']=="") {
                        $second = null;
                        $order = null;
                    } else {
                        $second = ",".$storage->section['field8'];
                        $order = " ORDER BY FIELD(id, ".$storage->section['field7']."".$second.")";
                    }
                    $developer = db_fetch_all("SELECT id, title FROM pages WHERE id in (".$storage->section['field7']."".$second.") AND language='".l()."'".$order."");
                ?>
                <div><?php echo l('developers') ?>: 
                <?php
                    $i = 0;
                    $cnt = count($developer);
                    $comma = ",";
                    foreach ($developer as $item):
                        $i++;
                        if ($i == $cnt)
                            $comma = ""; 
                ?>
                    <a href="<?php echo href($item['id']) ?>"><?php echo $item['title'] ?></a><?php echo $comma ?>
                <?php
                    endforeach;
                ?>
                </div>
                <?php
                    endif;
                ?>
                </div>
                <!-- .data -->
                <div class="text">
                    <?php echo content($content); ?>
                </div>
                <!-- .text fix -->
                <div id="attachment" class="clear">
        <?php
        if(count($images)>0) : ?>
                    <div id="attached" class="images fix">
        <?php
        $i=0;
        foreach($images as $image) :
        $i++;
        if ($i == 7) {$class = " first"; $i=1;} else {$class=NULL;}
        ?>
                        <div class="img left<?php echo $class ?>">
                            <a href="<?php echo $image["path"];?>" rel="prettyPhoto[2]"><img src="<?php echo ($image['path']!='') ? 'crop.php?img=' . $image['path'] . '&width=180&height=110' : '';?>" width="180" height="110" alt="<?php echo $image['title'];?>" /></a>
                        </div>
                        <!-- .img left -->
        <?php endforeach; ?>
                    </div>
                    <!-- #attached .images fix -->
        <?php endif; ?>
        <?php if(count($files)>0) : ?>
                    <div id="attached" class="files fix">
        <?php foreach($files as $file) : ?>
        <?php if($file['path']!='') : ?>
        <?php $ext = strtolower(substr(strrchr($file['path'], '.'), 1)); ?>
        <?php $img = '_tripadmin/img/icons/' . $ext . '.gif'; ?>
                        <div class="file left">
                            <img src="<?php echo $img;?>" width="16" height="16" alt="icon" /><a href="<?php echo $file['path'];?>"><?php echo $file['title'];?></a>
                        </div>
                        <!-- .file left -->
        <?php endif; ?>        
        <?php endforeach; ?>    
                    </div>
                    <!-- #attached .files fix -->
        <?php endif; ?>
                </div>
                <!-- #attachment -->
            </div>
            <!-- #read -->
        </article>
        <!-- #page .wrapper -->
<script type="text/javascript">
$(document).ready(function() {
    $("#tab li").click(function() {
        $("#tab li").removeClass("active");
        $(this).addClass("active");
        $(".tab-content .sheet").hide();
        var activeTab = $(this).find("a").attr("href");
        $(activeTab).fadeIn(300);
        return false;
    });
});
</script>