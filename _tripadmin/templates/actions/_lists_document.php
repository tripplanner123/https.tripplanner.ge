<?php
function _build_lists($parent, $order_by, $start = -1,$per_page)
{
    $route = Storage::instance()->route;
	$limit = ($start == -1) ? "" : "LIMIT ".$start.", ".$per_page;
    $sql = "SELECT * FROM ".c("table.pages")." WHERE language = '" . l() . "' AND `deleted` = 0 AND masterid = {$parent} AND menuid = {$route[2]} AND `title` LIKE '%" . get('srch', '') . "%' ORDER BY {$order_by} ".$limit.";";
    $results = db_fetch_all($sql);
    if (empty($results))
        return NULL;
    $undeletable = c('section.undeletable');
    $total = count($results);
    $count = 1;
	$class = 'list';
    foreach ($results AS $result):
        $is_first = ($count == 1);
        $is_last = ($count >= $total);
        $arrow_up = $is_first ? '<img src="_tripadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="javascript:pos(\'up\',\''.$result['id'].'\')"><img src="_tripadmin/img/buttons/icon_arrow_up_' . ($result['level'] > 4 ? 1 : $result["level"] - 1) . '.png" class="star" title="' .  a('tt.moveup') . '" width="9" height="9" /></a>';
        $arrow_down = $is_last ? '<img src="_tripadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="javascript:pos(\'down\',\''.$result['id'].'\')"><img src="_tripadmin/img/buttons/icon_arrow_down_' . ($result['level'] > 4 ? 1 : $result["level"] - 1) . '.png" class="star" title="' .  a('tt.movedn') . '" width="9" height="9" /></a>';
		$arrows = $arrow_up . $arrow_down;
        $count++;
        $pad = NULL;
		if($class == 'list2') $class = 'list'; else $class = 'list2';
		$ch = ($result["visibility"]==1) ? '' : 'un';
?>
					<div class="<?php echo $class;?> fix" id="div<?php echo $result["id"];?>" >
						<div class="check" style="float:left;">
							<a href="javascript:chclick(<?php echo $result['id'];?>);"><img src="_tripadmin/img/buttons/icon_<?php echo $ch;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="img_<?php echo $result['id'];?>" style="width:9px;height:9px;" /></a>
                            <input type="hidden" name="vis_<?php echo $result['id'];?>" id="vis_<?php echo $result['id'];?>" value="<?php echo $result['visibility'];?>" />
                        </div>
						<div class="icon" style="float:left;"><?php echo $arrows;?></div>
                        <div class="links left" style="padding-left:40px;">
                                <a href="<?php echo ahref(array($route[0], 'edit', $result["id"]));?>">
                                <strong><span class="star" title="<?php echo $result["title"];?>">
                                    <?php echo mb_substr($result["title"],0,64,'UTF-8') . ((mb_strlen($result["title"],'UTF-8')>64) ? '...' : '');?>
                                </span></strong>
                            </a>
                            <br />
							<a href="<?php echo href($result["id"]) ?>" target="_blank">
                            	<span class="star" style="font-size:10px; color:#999" title="<?php echo href($result["id"]) ?>">
<?php echo mb_substr(c('site.url') . l() . '/' . $result["slug"] . '/' . $result["id"], 0,84,'UTF-8') . ((mb_strlen(c('site.url') . l() . '/' . $result["slug"],'UTF-8')>84) ? '...' : '');?>
	                    		</span>
                            </a>
                        </div>
                        <div class="action fix" style="width:120px;">
                            <a href="<?php echo ahref(array($route[0], 'edit', $result["id"]));?>"><img src="_tripadmin/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.edit');?>" /></a>
                            <a href="javascript:del(<?php echo $result['id'];?>, '<?php echo $result['title'];?>');"><img src="_tripadmin/img/buttons/icon_delete.png" class="star" title="<?php echo a('ql.delete');?>" /></a>
                        </div>
						<div class="id"><?php echo $result["id"];?>&nbsp;</div>
						<div class="date"><?php echo $result["postdate"];?>&nbsp;</div>
					</div>
<?php
		_build_lists($result['idx'], $order_by, -1, $per_page);
	endforeach;
}
?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/buttons/_question.png" width="16" height="16" alt="" /></div>
			<div class="name"><?php echo $title;?></div>
		</div>

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<input type="text" class="inp" id="srch" name="srch" style="margin-top:0px;" value="<?php echo get('srch', ''); ?>" />
					<a href="javascript:srch();" class="button br"><?php echo a('search');?></a>
					<a href="<?php echo ahref(array($route[0], 'show', $route[2]));?>" class="button br"><?php echo a('reset');?></a>
					<a href="<?php echo ahref(array($route[0], 'add', $route[2]));?>" class="button br" style="float: right"><?php echo a('add');?></a>
				</div>
				<div id="info">
                    <div class="list-top">
						<div class="pos"><?php echo a("vis");?>.</div>
						<div class="pos"><?php echo a("pos");?>.</div>
						<div class="name-title"><span style="padding-left:45px;"><?php echo a("name");?></span></div>
						<div class="action fix"><?php echo a("actions");?></div>
						<div class="id">ID</div>
						<div class="date"><?php echo a("date");?></div>
					</div>
<?php
	$st = ($pager == 'true') ? $start : -1;
	$per_page = a_s('faq.per.page');
	_build_lists(0, $order_by, $st, $per_page)
?>
				</div>
				<div id="bottom" class="fix">
<?php
	$curpage = ceil((get("start", 0) + 1) / 50);
	$lastpage = ceil(($count) / 50);
	$j = ($curpage > 1) ? $curpage - 1 : 0; 
	$k = ($curpage < $lastpage) ? $curpage + 1 : $lastpage;
?>
					<ul id="page" class="fix left" style="width:720px; float: left;">
						<li><a href="<?php echo ahref(array($route[0], $route[1], $route[2]), array('start' => 0, 'srch' => get('srch',''), 'rec' => get('rec','')))?>"><img src="_tripadmin/img/prev2.png" width="5" height="5" alt=""  class="arrow" /></a></li>
						<li><a href="<?php echo ahref(array($route[0], $route[1], $route[2]), array('start' => 50 * ($j - 1), 'srch' => get('srch',''), 'rec' => get('rec','')))?>"><img src="_tripadmin/img/prev.png" width="5" height="5" alt=""  class="arrow" /></a></li>
<?php
	for($i = 1; $i<=$lastpage; $i++) {
?>
						<li><?php echo ($i == $curpage) ? '<span style="color:#2e84d7; font-weight:bold;">' : '<a href="'.ahref(array($route[0], $route[1], $route[2]), array('start' => 50 * ($i - 1), 'srch' => get('srch',''), 'rec' => get('rec',''))).'">';?><?php echo $i;?><?php echo ($i == $curpage) ? '</span>' : '</a>';?></li>
<?php
	}
?>
						<li><a href="<?php echo ahref(array($route[0], $route[1], $route[2]), array('start' => 50 * ($k - 1), 'srch' => get('srch',''), 'rec' => get('rec','')))?>"><img src="_tripadmin/img/next.png" width="5" height="5" alt="" class="arrow" /></a></li>
						<li><a href="<?php echo ahref(array($route[0], $route[1], $route[2]), array('start' => 50 * ($lastpage - 1), 'srch' => get('srch',''), 'rec' => get('rec','')))?>"><img src="_tripadmin/img/next2.png" width="5" height="5" alt="" class="arrow" /></a></li>
					</ul>
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