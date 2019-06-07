<?php defined('DIR') || exit;
function treeview ($parid=0, $lang, $link = null, $pl = null) {	// Tree View for Sitemap
	$qry = "SELECT " . c("table.pages") . ".id as dd," . c("table.pages") . ".* FROM " . c("table.pages") . "," . c("table.menus") . " WHERE " . c("table.pages") . ".menuid=" . c("table.menus") . ".id AND " . c("table.pages") . ".language='".$lang."' AND " . c("table.menus") . ".language='".$lang."' AND " . c("table.menus") . ".type='pages' AND " . c("table.pages") . ".visibility=1 AND " . c("table.pages") . ".menuid>0 AND " . c("table.pages") . ".deleted='0' AND " . c("table.pages") . ".masterid='".$parid."' order by position";
	$result = mysql_query($qry) or die (mysql_error());
	if (mysql_num_rows($result)>0) {
		while($row = mysql_fetch_array($result)) {
			$pad = ($row["level"] - 1) * 30;
?>
        <li style="margin-left:<?php echo $pad;?>px;">
            <a href="<?php echo href($row["dd"]);?>"><?php echo $row["title"];?></a>
        </li>
<?php
			treeview ($row["idx"], $lang);
		}
	}
}
?>
    <div id="title-color">
        <div id="page-title">
            <div class="wrapper">
                <h1><?php echo $title ?></h1>
                <ul class="fix">
                    <?php echo location() ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <div id="news" class="fix">
            <div id="sitemap">
                <ul>
                    <?php treeview (0, l()); ?>
                </ul>
            </div>
            <!-- #sitemap -->
        </div>
    </div>