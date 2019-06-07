<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/buttons/_camera.png" width="16" height="16" alt="" /></div>
			<div class="name"><?php echo a("imagegallery");?>: <?php echo $title;?></div>
		</div>

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<a href="<?php echo ahref(array($route[0], 'add', $route[2]));?>" class="button br" id="addcategory" style="float: right"><?php echo a("addimage");?></a>
				</div>
				<div id="info">
					<div class="list-top">
						<div class="vis"><?php echo a("vis");?>.</div>
						<div class="name-title"><span style="padding-left:45px;"><?php echo a("name");?></span></div>
						<div class="act fix"><?php echo a("actions");?></div>
						<div class="pid">ID</div>
						<div class="ptype"><?php echo a("date");?></div>
					</div>
<?php
	$class = 'list';
    $total = count($gallery);
    $count = 1;
	if(count($gallery) > 0) :
		foreach($gallery as $item) :
			$is_first = ($count == 1);
			$is_last = ($count >= $total);
			$arrow_up = $is_first ? '<img src="_tripadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="javascript:pos(\'up\',\''.$item['id'].'\')"><img src="_tripadmin/img/buttons/icon_arrow_up.png" alt="Move Up" title="Move Up" width="9" height="9" /></a>';
			$arrow_down = $is_last ? '<img src="_tripadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="javascript:pos(\'down\',\''.$item['id'].'\')"><img src="_tripadmin/img/buttons/icon_arrow_down.png" alt="Move Down" title="Move Down" width="9" height="9" /></a>';
			$arrows = $arrow_up . $arrow_down;
			$count++;
			if($class == 'list2') $class = 'list'; else $class = 'list2';
			$ch = ($item["visibility"]==1) ? '' : 'un';
?>
					<div id="div<?php echo $item['id'] ?>" class="<?php echo $class;?> fix">
						<div class="check">
							<a href="javascript:chclick(<?php echo $item['id'];?>);"><img src="_tripadmin/img/buttons/icon_<?php echo $ch;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="img_<?php echo $item['id'];?>" style="width:9px;height:9px;" /></a>
                            <input type="hidden" name="vis_<?php echo $item['id'];?>" id="vis_<?php echo $item['id'];?>" value="<?php echo $item['visibility'];?>" />
                        </div>
						<div class="icon"><?php echo $arrows;?></div>
						<div class="name" style="padding: 6px 0 0 15px;"><a href="<?php echo ahref(array($route[0], 'edit', $item['id']));?>"><?php echo $item["title"];?></a></div>
						<div class="action fix" style="padding-top:6px; width:120px;">
							<a class="preview" rel="lightbox[<?php echo $item['id'];?>]" href="<?php echo $item["image1"];?>" title="<?php echo a('ql.preview');?>"><img src="_tripadmin/img/buttons/icon_preview.png" style="padding-right:1px;" /></a>
							<a href="<?php echo ahref(array($route[0], 'edit', $item['id']));?>" title="<?php echo a('ql.edit');?>"><img src="_tripadmin/img/buttons/icon_edit.png" /></a>
							<a href="javascript:del(<?php echo $item['id'];?>, '<?php echo $item['title'];?>');" title="<?php echo a('ql.delete');?>"><img src="_tripadmin/img/buttons/icon_delete.png" /></a>
						</div>
						<div class="id"><?php echo $item["id"];?></div>
						<div class="date"><?php echo $item["postdate"];?></div>
					</div>
<?php
		endforeach;
	endif;
?>
				</div>
				<div id="bottom" class="fix">
					<a href="<?php echo ahref(array($route[0], 'add', $route[2]));?>" class="button br" id="addcategory" style="float: right"><?php echo a("addimage");?></a>
				</div>
			</div>
		</div>
<script type="text/javascript">
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