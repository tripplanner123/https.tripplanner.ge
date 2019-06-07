<?php

defined('DIR') || exit();

if (in_array($section, array(41, 42, 43))):

?>


<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td width="35%" valign="top">

            <table cellpadding="3" cellspacing="3">
                <?php
                    $abbrs = array();
                    foreach ($list as $painter):
                        $abbr = mb_substr(end(explode(' ', $painter['title'])), 0, 3);
                    ?>
                <tr>
                    <td style="vertical-align: top; font-weight: bold; font-size: 125%; color: #305867;"><?php echo in_array($abbr, $abbrs) ? null : $abbr; ?></td>
                    <td style="vertical-align: top; padding-left: 15px"><a href="<?php echo href($painter['id'], l()); ?>&amp;is_painter=1"><?php echo $painter['title']; ?></a></td>
                </tr>
                <?php
                        if (!isset($abbrs[$abbr]))
                        {
                            $abbrs[] = $abbr;
                        }
                    endforeach;
                ?>
            </table>

        </td>
        <td width="65%" valign="top"><?php
            $random_sql = "SELECT * FROM `dd_pictures` WHERE `lang` = '" . l() . "' ORDER BY RAND() LIMIT 4;";
            $random_res = db_fetch_all($random_sql);
            if (!empty($random_res)):
                foreach ($random_res as $picture):
                    echo parse('<div style="display: block; clear both; margin: {rand_1}px {rand_2}px {rand_3}px {rand_4}px"><img src="crop.php?img=' . $picture['picture'] . '&width=180&height=120" alt=""></div>', array(
                        'rand_1' => rand(9, 100),
                        'rand_2' => rand(9, 100),
                        'rand_3' => rand(9, 100),
                        'rand_4' => rand(9, 100)
                    ));
                endforeach;
            endif;
        ?></td>
    </tr>
</table>

<?php else: ?>

        <?php foreach ($list as $item): ?>

            <table cellpadding="3" cellspacing="3">
                <tr>
                <?php if (!empty($item['pic1'])): ?>
                    <td style="vertical-align: top">
                        <a href="<?= href($item['id'], l()) ?>">
                            <img src="crop.php?img=<?php echo str_replace(c('site.url'), null, $item['pic1']); ?>&width=120&height=100" style="padding: 1px; border: 1px solid #999" alt="" />
                        </a>
                    </td>
                <?php endif; ?>
                    <td style="vertical-align: top">
                        <a href="<?= href($item['id'], l()) ?>" style="color: #305867; font-weight: bold"><?= $item['title'] ?></a><br />
                        <i style="padding: 3px 0"><?= convert_date($item['postdate']) ?></i><br />
                    <?= $item['description'] ?>
                </td>
            </tr>
        </table>

        <br><br><br>

        <?php endforeach; ?>

<?php endif;

/*

<div class="auction-part">
    <div class="auction-list-part">
        <?php for ($idx = 0, $num = count($list); $idx < $num; $idx ++): ?>
            <div class="auction-list">
                <?php if (isset($list[$idx]['pic1']) && !empty($list[$idx]['pic1'])): ?>
                    <div class="auction-img"><a href="<?php echo href($list[$idx]['id'], l()); ?>"><img src="crop.php?img=<?php echo $list[$idx]['pic1']; ?>&amp;width=180&amp;height=180" style="border: 0" alt="" /></a></div>
                <?php endif; ?>
                <div class="auction-name"><a href="<?php echo href($list[$idx]['id'], l()); ?>"><?php echo $list[$idx]['title']; ?></a></div>
                <?php if ($idx % 3 == 0): ?>
                    <div class="div-clear"></div>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>

*/


?>