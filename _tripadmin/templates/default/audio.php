<?php
defined('DIR') OR exit;

echo '<ul id="video" class="fix" style="background: none">';

foreach ($audios as $audio):
?>
    <li class="fix" style="clear: both; height: auto; margin-bottom: 2.5em">
        <div class="name" style="font-weight: bold; margin-bottom: 3px"><?php echo $audio['title'] ?></div>
        <a href="<?php echo $audio['image'] ?>" rel="audio"></a>
    </li>
<?php
    endforeach;

    echo '</ul>';

