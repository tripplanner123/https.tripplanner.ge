<?php

defined('DIR') OR exit;

echo '<br/><br/>';
echo '<img src="images/news-line.png" width="680" height="1" alt="" />';
echo '<ul class="menu">';
foreach ($all_files as $file):
    $path = str_replace(c('site.url'), NULL, $file['path']);
    $ext = array_pop(explode('.', $path));
    echo '<li><a href="' . $path . '" target="_blank"><img src="images/icons/' . $ext . '.gif" width="17" height="19" style="vertical-align: middle;" alt="" /> ' . $file['title'] . '</a></li>';
endforeach;
echo '</ul>';

