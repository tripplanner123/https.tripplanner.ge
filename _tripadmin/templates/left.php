<?php defined('DIR') OR exit; ?>
<div id="site_left" style="margin-bottom: 5px;">

    <div id="site_left_line"></div>
    <div id="left">

        <?php
        foreach ($navigation AS $nav):
            if (empty($nav['children']))
                continue;
        ?>
            <div class="title1<?php
            foreach ($nav['children'] AS $child)
                $child['link']['action'] == $action AND print ' selected';
        ?>">
            <table width="190" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="tdf4_1"><img src="_tripadmin/modules/images/<?php echo $nav['icon'] ?>" width="16" height="16" alt="" /></td>
                    <td class="tdf4_2" style="cursor: pointer"><?php echo html_entity_decode($nav['name']) ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="tddot"></td>
                </tr>
            </table>
        </div>
        <div>
            <table width="190" border="0" cellspacing="0" cellpadding="0">
                <?php foreach ($nav['children'] AS $child): ?>
                    <tr>
                        <td class="tdff_1"><img src="_tripadmin/modules/images/<?php echo $child['icon'] ?>" width="16" height="16" alt="" /></td>
                        <td class="tdff" align="left"><a href="<?php echo ahref($child['link']['action'], isset($child['link']['subaction']) ? $child['link']['subaction'] : NULL, isset($child['link']['parameters']) ? $child['link']['parameters'] : NULL) ?>"><?php echo html_entity_decode($child['name']) ?></a></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="tddot"></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
        <?php endforeach; ?>

    </div>
</div>
