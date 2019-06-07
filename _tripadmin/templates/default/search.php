<?php
defined('DIR') || exit;

if (!empty($results)):
    echo '<div id="news">';
    for ($idx = 0, $num = count($results); $idx < $num; $idx++):
        $link = href($results[$idx]['id']);
?>
        <div class="list fix"<?php echo ($idx == ($num - 1)) ? ' style="background: none"' : NULL ?>>
            <div class="right fix" style="display: block; width: auto">
                <div class="info">
                    <span class="date"><?php echo convert_date($results[$idx]['postdate']) ?></span>
                    <span class="name"><a href="<?php echo $link ?>"><?php echo $results[$idx]['title'] ?></a></span>
                    <div class="text"><?php echo html_entity_decode($results[$idx]['description']); ?></div>
                </div>
                <div class="read"><a href="<?php echo $link ?>"><img src="images/read.png" width="9" height="7" title="<?php echo l('more') ?>" alt="<?php echo l('more'); ?>" /></a></div>
            </div>
        </div>
<?php
        endfor;
        echo '</div>';
    endif;
?>