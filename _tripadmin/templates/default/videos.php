<?php
defined('DIR') OR exit;

echo '<ul id="video" class="fix">';

foreach ($videos as $video):
?>
    <li>
        <div class="img"><a href="flash.php?flash=<?php echo $video['video'] ?>" rel="video" title="<?php echo $video['title'] ?>"><img src="crop.php?img=<?php echo $video['image'] ?>&width=158&height=120" width="158" height="120" title="<?php echo $video['title'] ?>" alt="<?php echo $video['title'] ?>" /></a></div>
        <div class="name"><?php echo $video['title'] ?></div>
    </li>
<?php
    endforeach;

    echo '</ul>';
