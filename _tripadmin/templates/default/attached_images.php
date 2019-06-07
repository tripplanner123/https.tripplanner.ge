<?php
defined('DIR') OR exit;

if (!empty($images)):

    echo '<div id="about-img">';

    foreach ($images as $image):
        $image['new_path'] = str_replace(c('site.url'), null, $image['path']);
        $image_name = substr(strstr($image['path'], '/'), 1);
?>
        <a href="<?php echo $image['path']; ?>" rel="lightbox"><img src="resize.php?img=<?php echo $image['path']; ?>&width=240&height=160" width="240" height="160" class="img" alt="" /></a>
<?php
        endforeach;

        echo '</div>';

    endif;
