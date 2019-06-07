<?php defined('DIR') OR exit; ?>
<div class="section-title title">
    <h2><?php echo $title ?></h2>
</div>
<div id="photos" class="row content-lists">
<?php
    foreach ($photos as $item):
        if ($item['image1']):
?>
    <div class="photoe col-md-3">
        <div class="photos-img">
            <a href="<?php echo $item['image1'] ?>" class="img-pop" rel="gallery1"><img src="<?php echo 'crop.php?img='.$item["image1"].'&n=6' ?>" alt="<?php echo $item['title'] ?>"></a>
        </div>
    </div>
<?php
        endif;
    endforeach;
?>
</div>
<?php echo pager($id, $page_cur, $page_max, c('photos.page_count'), get()) ?>