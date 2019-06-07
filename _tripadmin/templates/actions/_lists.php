<?php
$class = 'list';
function _build_lists($parent, $order_by, $start = -1, $per_page)
{
    $route = Storage::instance()->route;
	$limit = ($start == -1) ? "" : "LIMIT ".$start.", ".$per_page;
    $srch = get('srch', '');
    if ($srch)
        $srch =  ' AND `title` LIKE "%' . $srch . '%"';
    $sql = "SELECT * FROM ".c("table.pages")." WHERE menuid = {$route[2]} AND language = '" . l() . "' AND `deleted` = 0 AND masterid = {$parent}{$srch} ORDER BY {$order_by} ".$limit.";";
    $results = db_fetch_all($sql);
    if (empty($results))
        return NULL;
//    $undeletable = c('section.undeletable');
    $total = count($results);
    $count = 1;
    global $class;
    foreach ($results AS $result):
		switch($result["category"]) {
			case 1:  $menucat = a("mt.text"); 			$menulink = ""; 			break;
			case 2:  $menucat = a("mt.home"); 			$menulink = ""; 			break;
			case 3:  $menucat = a("mt.about"); 			$menulink = ""; 			break;
			case 4:  $menucat = a("mt.searchresults");  $menulink = ""; 			break;
			case 5:  $menucat = a("mt.sitemap"); 		$menulink = ""; 			break;
			case 6:  $menucat = a("mt.feedback"); 		$menulink = ""; 			break;
			case 7:  $menucat = a("mt.plugin"); 		$menulink = ""; 			break;
			case 8:  $menucat = a("mt.news"); 			$menulink = "news"; 		break;
			case 9:  $menucat = a("mt.articles"); 		$menulink = "articles"; 	break;
			case 10: $menucat = a("mt.events"); 		$menulink = "events"; 		break;
			case 11: $menucat = a("mt.list"); 			$menulink = "list"; 		break;
			case 12: $menucat = a("mt.imagegallery"); 	$menulink = "imagegallery"; break;
			case 13: $menucat = a("mt.videogallery"); 	$menulink = "videogallery";	break;
			case 14: $menucat = a("mt.audiogallery"); 	$menulink = "audiogallery";	break;
			case 15: $menucat = a("mt.poll"); 			$menulink = "poll"; 		break;
			case 16: $menucat = a("mt.catalog"); 		$menulink = "catalog";		break;
			case 17: $menucat = a("mt.faq"); 			$menulink = "faq";			break;
		}
        $is_first = ($count == 1);
        $is_last = ($count >= $total);
        $arrow_up = $is_first ? '<img src="_tripadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="javascript:pos(\'up\',\''.$result['id'].'\')"><img src="_tripadmin/img/buttons/icon_arrow_up_' . ($result['level'] > 4 ? 1 : $result["level"] - 1) . '.png" class="star" title="' .  a('tt.moveup') . '" width="9" height="9" /></a>';
        $arrow_down = $is_last ? '<img src="_tripadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="javascript:pos(\'down\',\''.$result['id'].'\')"><img src="_tripadmin/img/buttons/icon_arrow_down_' . ($result['level'] > 4 ? 1 : $result["level"] - 1) . '.png" class="star" title="' .  a('tt.movedn') . '" width="9" height="9" /></a>';
		$arrows = $arrow_up . $arrow_down;
        $count++;
        $pad = NULL;
        $spad = NULL;
		$lnks = '';
		$lnke = '';
		if($class == 'list2') $class = 'list'; else $class = 'list2';
	    $sqlchilds = db_fetch("SELECT count(*) as cnt FROM ".c("table.pages")." WHERE masterid = {$result['id']}");
		$bn = ($sqlchilds['cnt'] == 0) ? 'icons_down_bullet' : 'icons_up_bullet';
		$collapse = ($result['collapsed']==1) ? 'plus' : 'minus';
		if($sqlchilds['cnt'] == 0) $collapse = 'none';
		if($collapse == 'plus') { $lnks = '<a href="' . ahref(array($route[0], 'expand', $route[2])) . '">'; $lnke = '</a>'; }
		if($collapse == 'minus') { $lnks = '<a href="' . ahref(array($route[0], 'collapse', $route[2])) . '">'; $lnke = '</a>'; }
		$pad .= $lnks . '<img src="_tripadmin/img/' . $collapse . '.png" width="16" height="16" style="margin:0 0 0 ' . ((($result['level'] - 1) * 25) + 5) . 'px;" >' . $lnke;
		$pad .= '<img src="_tripadmin/img/buttons/' . $bn . '.png" style="margin:0 10px 0 0;" >';
		$spad .= '<img src="_tripadmin/img/none.png" style="margin:0 5px 0 ' . ((($result['level'] - 1) * 25) + 5) . 'px;" >&nbsp;';
		$ch = ($result["visibility"]==1) ? '' : 'un';
?>

                    <div class="<?php echo $class;?> fix" id="div<?php echo $result["id"];?>" >
						<div class="check">
							<a href="javascript:chclick(<?php echo $result['id'];?>);"><img src="_tripadmin/img/buttons/icon_<?php echo $ch;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="img_<?php echo $result['id'];?>" style="width:9px;height:9px;" /></a>
                            <input type="hidden" name="vis_<?php echo $result['id'];?>" id="vis_<?php echo $result['id'];?>" value="<?php echo $result['visibility'];?>" />
                        </div>
<?php if(is_from_list($result["menuid"])&&$result['menuid']!=15 ) {	?>
						<div class="icon">&nbsp;</div>
<?php } else { ?>
						<div class="icon"><?php echo $arrows;?>&nbsp;</div>
<?php } ?>
						<div class="name">
                        	<div class="arrows"><?php echo $pad;?></div>
                            <div class="links">
                                <a href="<?php echo ahref(array($route[0], 'edit', $result["id"]));?>">
                                    <strong><span class="star" title="<?php echo $result["title"];?>">
                                        <?php echo mb_substr($result["title"],0,64,'UTF-8') . ((mb_strlen($result["title"],'UTF-8')>64) ? '...' : '');?>
                                    </span></strong>
                                </a>
                                <br />
						        <?php
					                if ($route[0] != "sitemap") {
					            ?>
								<a href="<?php echo href($result["id"]) ?>" target="_blank">
                                	<span class="star" style="font-size:10px; color:#999" title="<?php echo href($result["id"]) ?>">
<?php echo mb_substr(c('site.url') . l() . '/' . $result["slug"] . '/' . $result["id"], 0,84,'UTF-8') . ((mb_strlen(c('site.url') . l() . '/' . $result["slug"],'UTF-8')>84) ? '...' : '');?>
    	                    		</span>
                                </a>
                                <?php } else { ?>
								<a href="<?php echo href($result["id"]) ?>" target="_blank">
                                	<span class="star" style="font-size:10px; color:#999" title="<?php echo href($result["id"]) ?>">
<?php echo mb_substr(href($result["id"]), 0,84,'UTF-8') . ((mb_strlen(href($result["id"]),'UTF-8')>84) ? '...' : '');?>
    	                    		</span>
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="action fix">
                        	<a href="<?php echo href($result['id']) ?>" target="_blank"><img src="_tripadmin/img/buttons/icon_preview.png" class="star" title="<?php echo a('ql.preview');?>" /></a>
                            <a href="<?php echo ahref(array($route[0], 'edit', $result["id"]));?>"><img src="_tripadmin/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.edit');?>" /></a>
<?php
	if(in_array($result["category"], array(8,9,10,11,12,13,14,15,16,17))) {
		switch($result["category"]) :
			case 12:
			case 13:
			case 14:
				$page_count = db_fetch("SELECT count(*) AS cnt FROM " . c("table.galleries") . " WHERE `menuid` = {$result["menutype"]} AND `deleted` = 0;");
				break;
			case 15:
				$page_count = db_fetch("SELECT count(*) AS cnt FROM " . c("table.pollanswers") . " WHERE `pollid` = {$result["menutype"]} AND `deleted` = 0;");
				break;
			case 16:
				$page_count = db_fetch("SELECT count(*) AS cnt FROM " . c("table.catalogs") . " WHERE `menuid` = {$result["menutype"]} AND `deleted` = 0;");
				break;
			default:
				$page_count = db_fetch("SELECT count(*) AS cnt FROM " . c("table.pages") . " WHERE `menuid` = {$result["menutype"]} AND `deleted` = 0;");
				break;
		endswitch;
		$menulink1 = ($menulink == 'list') ? 'customlist' : $menulink;
		if ($result["category"] == 16 && $result["level"] < 2) {

		} else {
?>
							<a href="<?php echo ahref(array($menulink1, 'show', $result["menutype"])) ?>"><img src="_tripadmin/img/buttons/icon_files<?php echo ($page_count['cnt']==0)	? '' : '_r';?>.png" class="star" title="<?php echo a('ql.editcontent');?>" /></a>
<?php
		}
	}
?>
<?php
	$undeletable = 0;
	if(!in_array($result["category"], array(8,9,10,11,12,13,14,15,16,17))):
		$att_count = db_fetch("SELECT count(*) AS cnt FROM " . c("table.attached") . " WHERE `page` = {$result['id']};");
		if($att_count['cnt']>0) $undeletable = 1;
			if ($_SESSION['auth']['class'] == 0):
?>
                            <a href="<?php echo ahref(array('files', '', $result["id"]));?>"><img src="_tripadmin/img/buttons/icon_attach<?php echo ($att_count['cnt']==0)	? '' : '_r';?>.png" class="star" title="<?php echo a('ql.attachments');?>" /></a>
			<?php endif; ?>
<?php endif; ?>
                            <a href="javascript:addr('Page Address:', '<?php echo href($result['id']) ?>');"><img src="_tripadmin/img/buttons/icon_link.png" class="star" title="<?php echo a('ql.link');?>" /></a>
<?php if($route[0] =='sitemap') : ?>
							<a href="<?php echo ($result["level"]<3 && $result["id"]!=1) ? ahref(array($route[0], 'add', $result['menuid']), array('id' => $result["id"])) : 'javascript:;';?>"><img src="_tripadmin/img/buttons/<?php echo ($result["level"]<3 && $result["id"]!=1) ? 'icon_add' : 'icon_no_add' ?>.png" class="star" title="<?php echo a('ql.addsubpage');?>" /></a>
<?php endif; ?>
<?php
	if((in_array($result["category"], array(8,9,10,11,12,13,14,15,16,17))) && ($page_count['cnt']>0)) $undeletable = 1;
	if($result["category"] == 2) $undeletable = 1;
	$child_count = db_fetch("SELECT count(*) AS cnt FROM " . c("table.pages") . " WHERE `masterid` = {$result['id']} AND `deleted` = 0;");
	if($child_count['cnt']>0) $undeletable = 1;
		if ($result["category"] == 16 && $result["level"] < 2)
			$undeletable = 1;
	if($undeletable == 0) {
?>
                            <a href="javascript:del(<?php echo $result['id'];?>, '<?php echo $result['title'];?>');"><img src="_tripadmin/img/buttons/icon_delete.png" class="star" title="<?php echo a('ql.delete');?>" /></a>
<?php } else { ?>
							<a href="javascript:"><img src="_tripadmin/img/buttons/icon_delete_inactive.png" class="star" title="" style="width:15px;height:15px;" /></a>
<?php } ?>
                        </div>

						<div class="id"><?php echo $result["id"];?></div>
						<?php if(is_from_list($result["menuid"])) {	?>
						<div class="date"><?php echo $result["postdate"];?></div>
<?php } else { ?>
						<div class="date"><?php echo $menucat;?></div>
<?php } ?>



					</div>
<?php
		if($result['collapsed']==0)	echo _build_lists($result['id'], $order_by, 0, $per_page);
	endforeach;
}
?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/table.png" width="16" height="16" alt="" /></div>
			<div class="name"><?php echo $title;?></div>
		</div>

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
<?php if(is_from_list(get('menu'))) {	?>
					<input type="text" class="inp" id="srch" name="srch" style="margin-top:0px;" value="<?php echo get('srch', ''); ?>" />
					<a href="javascript:srch();" class="button br"><?php echo a('search');?></a>
					<a href="<?php echo ahref(array($route[0], 'show', $route[2]));?>" class="button br"><?php echo a('reset');?></a>
<?php } ?>
					<a href="<?php echo ahref(array($route[0], 'add', $route[2]));?>" class="button br" style="float: right"><?php echo a('add');?></a>
		            <?php
		            	if ($_SESSION['auth']["class"]==0):
			            	$file_loc = 'sitemap.xml';
			            	if (!file_exists($file_loc)) {
							    $sitemap = "Create";
								$show = NULL;
							} else {
							    $sitemap = "Update";
								$show = '<div><a href="'.c('site.url').'sitemap.xml" target="_blank">Show Sitemap</a></div>';
							}
			                if (get('menu',1) == 1):
			        ?>
					<div id="sitemap-xml" class="left">
					<form action="" method="post">
					    <input type="submit" name="submit" value="<?php echo $sitemap; ?> sitemap.xml" class="button br" />
					</form>
					<?php
						if (isset($_POST['submit'])) {
							$file = "sitemap.xml";
							$open = fopen($file, 'w') or die("Errow while creating sitemap");
							$write = sitemap_xml();
							fwrite($open, $write);
							fclose($open);
							redirect(ahref(array($route[0], '', $route[2]), array('xml'=>1)));
						}
						if (isset($_GET["xml"])) {
							$show = '<div>Process finished successfully <a href="'.c('site.url').'sitemap.xml" target="_blank">Show Sitemap</a></div>';
						}
						echo $show;
					?>
					</div>
            	<?php
            			endif;
            		endif;
            	?>
				</div>
				<div id="info">
                    <div class="list-top">
						<div class="vis"><?php echo a("vis");?>.</div>
						<div class="pos"><?php echo a("pos");?>.</div>
						<div class="name-title"><span style="padding-left:45px;"><?php echo a("name");?></span></div>
						<div class="act fix"><?php echo a("actions");?></div>
						<div class="pid">ID</div>
						<?php if(is_from_list(get('menu',0))) {	?>
						<div class="ptype"><?php echo a("date");?></div>
						<?php } else { ?>
						<div class="ptype"><?php echo a("pagetype");?></div>
						<?php } ?>
					</div>
<?php
	$st = ($pager == 'true') ? $start : -1;

	$per_page = 20;
	switch($route[0]) :
		case 'news':
		case 'articles':
		case 'events':
			$per_page = 20;
			break;
		case 'customlist':
			$per_page = a_s('list.per.page');
			break;
	endswitch;

	echo _build_lists(0, $order_by, $st, $per_page)
?>
				</div>
				<div id="bottom" class="fix">
<?php
	if($pager == 'true') {
		$curpage = ceil(($start + 1) / $per_page);
		echo $per_page;
		$lastpage = ceil(($count) / $per_page);
		$prevpage = ($curpage == 1) ? 1 : $curpage - 1;
		$nextpage = ($curpage == $lastpage) ? $lastpage : $curpage + 1;
		$last = $per_page * ($lastpage - 1);
		$prev = $per_page * ($prevpage - 1);
		$next = $per_page * ($nextpage - 1);
?>
					<ul id="page" class="fix left" style="width:900px;">
						<li><a href="<?php echo ahref($route, $params) . '&start=0'?>"><img src="_tripadmin/img/prev2.png" width="5" height="5" alt=""  class="arrow" /></a></li>
						<li><a href="<?php echo ahref($route, $params) . '&start=' . $prev;?>"><img src="_tripadmin/img/prev.png" width="5" height="5" alt=""  class="arrow" /></a></li>
<?php
		for($i = 1; $i<=$lastpage; $i++) {
			$nst = $per_page * ($i - 1);
?>
						<li><?php echo ($i == $curpage) ? '<span style="color:#2e84d7; font-weight:bold;">' : '<a href="' . ahref($route, $params) . '&start=' . $nst . '">';?><?php echo $i;?><?php echo ($i == $curpage) ? '</span>' : '</a>';?></li>
<?php } ?>
						<li><a href="<?php echo ahref($route, $params) . '&start=' . $next;?>"><img src="_tripadmin/img/next.png" width="5" height="5" alt="" class="arrow" /></a></li>
						<li><a href="<?php echo ahref($route, $params) . '&start=' . $last;?>"><img src="_tripadmin/img/next2.png" width="5" height="5" alt="" class="arrow" /></a></li>
					</ul>
<?php } ?>
<?php if($route[0]=='sitemap') { ?>
					<a href="<?php echo ahref(array($route[0], 'collapse', $route[2]));?>" class="button br"><?php echo a('collapse');?></a>
					<a href="<?php echo ahref(array($route[0], 'expand', $route[2]));?>" class="button br"><?php echo a('expand');?></a>

<?php } ?>
					<a href="<?php echo ahref(array($route[0], 'add', $route[2]));?>" class="button br" style="float: right"><?php echo a('add');?></a>
				</div>
			</div>
		</div>
<script language="javascript">
function chclick(id) {
	var active = ($('#vis_'+id).val()==0) ? 1 : 0;
	$.post("<?php echo ahref(array($route[0], 'visibility'), array('ajax' => 1));?>&visibility=" + active + "&id=" + id, function(data) {
		if(active==1)
	        $('#img_'+id).attr("src","_tripadmin/img/buttons/icon_visible.png");
		else
	        $('#img_'+id).attr("src","_tripadmin/img/buttons/icon_unvisible.png");
		$('#vis_'+id).val(active);
	});
};
function pos(where,id) {
	var pos = $(document).scrollTop();
	window.location = "<?php echo ahref(array($route[0], 'move'));?>?where="+where+"&menu=<?php echo $route[2] ?>&id="+id+"&pos="+pos;
};
function del(id, title) {
	if (confirm("<?php echo a('deletequestion'); ?>" + title + "?")) {
		$.post("<?php echo ahref(array($route[0], 'delete'));?>?menu=<?php echo $route[2] ?>&id=" + id, function(){
			$("#div" + id).innerHTML = "";
			$("#div" + id).hide();
		});
	}
}
<?php if (isset($_GET["pos"])): ?>
$(function(){
    $("html, body").scrollTop(<?php echo intval($_GET["pos"]) ?>);
});
<?php endif ?>

function addr(title, value) {
	prompt(title, value);
}

function srch() {
	window.location="<?php echo ahref(array($route[0], '', $route[2]));?>&srch=" + $("#srch").val();
}

$(".list").mouseover(function(){
    	$(this).css('background', '#ededed');
    }).mouseout(function(){
    	$(this).css('background', '#f8f8f8');
    });
$(".list2").mouseover(function(){
    	$(this).css('background', '#ededed');
    }).mouseout(function(){
    	$(this).css('background', '#ffffff');
    });
</script>