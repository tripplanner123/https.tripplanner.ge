<?php defined('DIR') OR exit; ?>
<div class="fix" id="gallery">
    <div class="list-part fix">
        <?php
        foreach ($photos as $photo):
            $img = str_replace(c('site.url'), NULL, $photo['path']);
        ?>
            <div class="list">
                <a href="<?php echo $img; ?>" rel="lightbox" title="<?php echo $photo['title']; ?>"><img width="150" height="100" class="img" alt="" src="resize.php?img=<?php echo $img; ?>&width=150&height=100"></a>
                <div class="name"><?php echo $photo['title']; ?></div>
                <!--
                <div class="date">December 26, 2010</div>
                -->
            </div>
        <?php endforeach; ?>
    </div>
</div>