<?php

defined('DIR') OR exit;

if (!empty($files)):
    foreach ($files as $file)
    {
        $path = str_replace(c('site.url'), NULL, $file['path']);
        $ext = end(explode('.', $path));
        $name = end(explode('/', $path));
        echo '<a href="' . $path . '" target="_blank"><img src="img/icons/' . $ext . '.gif" width="17" height="19" style="vertical-align: middle;" alt="" /> ' . $name . '</a><br />';
    }
endif;
