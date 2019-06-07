<?php
defined('DIR') OR exit;

echo '<ul id="video" class="fix">';

foreach ($photos as $photo):
?>
    <li>
        <div class="img"><a href="<?php echo $photo['image'] ?>" rel="photo" title="<?php echo $photo['title'] ?>"><img src="crop.php?img=<?php echo $photo['image'] ?>&width=158&height=120" width="158" height="120" title="<?php echo $photo['title'] ?>" alt="<?php echo $photo['title'] ?>" /></a></div>
        <div class="name"><?php echo $photo['title'] ?></div>
    </li>
<?php
    endforeach;

    echo '</ul>';
