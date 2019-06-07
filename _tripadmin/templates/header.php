<?php defined('DIR') OR exit; ?>
<div id="site_logo">
    <div id="site_logo_line"><img src="_tripadmin/modules/images/spacer.gif" width="1" height="1" alt="" /></div>
    <div id="site_logo_left"><a href="http://www.digitaldesign.ge" target="_blank"><img src="_tripadmin/modules/images/gr_logo.jpg" width="250" height="60" style="margin-left: 10px;" alt="" /></a></div>
    <div id="site_logo_right">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="120" class="tdff"><strong>Switch the language:</strong></td>
                <td class="tdff"><table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <?php
                            $languages = c('languages.all');
                            foreach ($languages as $language)
                            {
                                $params = array();
                                $optionals = array('menu', 'id', 'idx', 'gameid');
                                foreach ($optionals as $name)
                                {
                                    if (($option = get($name)) === FALSE)
                                        continue;
                                    $params[$name] = $option;
                                }
                                echo '<td width="20"><a href="' . ahref($action, $subaction, $params, $language) . '"><img src="_tripadmin/modules/images/' . $language . (l() == $language ? NULL : '_r') . '.png" style="' . (l() == $language ? 'cursor: default' : NULL) . '" width="16" height="16" alt="" /></a></td>';
                            }
                            ?>
                        </tr>
                    </table></td>
                <td width="16" class="tdff"><img src="_tripadmin/modules/images/i_user.gif" width="16" height="16" alt="" /></td>
                <td width="100" class="tdff"><strong>User:</strong> <a href="#"><?php echo (isset($_SESSION['auth']['name'])) ? $_SESSION['auth']['name'] : "N/A"; ?></a></td>
                <td width="12" class="tdff"><img src="_tripadmin/modules/images/i_logout.gif" width="12" height="10" alt="" /></td>
                <td width="35" class="tdff"><a href="<?php echo ahref('access', 'logout') ?>">Logout</a></td>
            </tr>
        </table>
    </div>
    <div class="clearboth"><img src="_tripadmin/modules/images/spacer.gif" width="1" height="1" alt="" /></div>
</div>
