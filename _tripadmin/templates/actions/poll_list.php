<?php
   		$ttl = db_retrieve('title', c("table.pages"), 'attached', $title, ' and language = "'.l().'" LIMIT 1');
?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/edit.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo a("mt.poll");?>: <?php echo $ttl;?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<a href="<?php echo ahref('poll', 'add', array('menu'=>$_GET["menu"]));?>" class="button br" id="addcategory" style="float: right"><?php echo a("addpolls");?></a>
				</div>	
				<div id="info">
					<div class="list-top">
						<div class="check"><?php echo a("vis");?>.</div>									
						<div class="name-title" style="width:630px;"><?php echo a("answer");?></div>									
						<div class="id">ID</div>									
						<div class="date" style="width:100px;"><?php echo a("count");?></div>									
						<div class="action fix"><?php echo a("actions");?></div>						
					</div>
<?php
	$class = 'list';
    $total = count($polls);
    $count = 1;
	if(count($polls) > 0) :
		foreach($polls as $poll) :
			$is_first = ($count == 1);
			$is_last = ($count >= $total);
			$arrow_up = $is_first ? '<img src="_tripadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="' . ahref('poll', 'move', array('where' => 'up', 'menu'=>$poll['pollid'], 'idx'=> $poll['idx'])) . '"><img src="_tripadmin/img/buttons/icon_arrow_up.png" alt="Move Up" title="Move Up" width="9" height="9" /></a>';
			$arrow_down = $is_last ? '<img src="_tripadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="' . ahref('poll', 'move', array('where' => 'down', 'menu'=>$poll['pollid'], 'idx'=> $poll['idx'])) . '"><img src="_tripadmin/img/buttons/icon_arrow_down.png" alt="Move Down" title="Move Down" width="9" height="9" /></a>';
			$arrows = $arrow_up . $arrow_down;
			$count++;
			if($class == 'list2') $class = 'list'; else $class = 'list2';
			$ch = ($poll["visibility"]==1) ? '' : 'un';
?>
					<div id="list" class="<?php echo $class;?> fix">
						<div class="check">
							<a href="javascript:chclick(<?php echo $poll['idx'];?>);"><img src="_tripadmin/img/buttons/icon_<?php echo $ch;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="img_<?php echo $poll['idx'];?>" style="width:9px;height:9px;" /></a>
                            <input type="hidden" name="vis_<?php echo $poll['idx'];?>" id="vis_<?php echo $poll['idx'];?>" value="<?php echo $poll['visibility'];?>" />
                        </div>									
						<div class="icon"><?php echo $arrows;?></div>									
						<div class="name" style="width:600px;"><a href="<?php echo ahref('poll', 'edit', array('idx' => $poll['idx'], 'menu'=>$poll['pollid']));?>"><?php echo $poll["answer"];?></a></div>									
						<div class="id"><?php echo $poll["id"];?></div>
						<div class="date" style="width:100px;"><?php echo $poll["answercounttotal"];?></div>									
						<div class="action fix" style="padding-top:6px; width:120px;">
							<a href="<?php echo ahref('poll', 'edit', array('idx' => $poll['idx'], 'menu'=>$poll['pollid']));?>" title="<?php echo a('ql.edit');?>"><img src="_tripadmin/img/buttons/icon_edit.png" /></a>
							<a href="javascript:del(<?php echo $poll['id'];?>, '<?php echo $poll['answer'];?>');" title="<?php echo a('ql.delete');?>"><img src="_tripadmin/img/buttons/icon_delete.png" /></a>
						</div>									
					</div>		
<?php
		endforeach;
	endif;
?>
				</div>	
				<div id="bottom" class="fix">
					<a href="<?php echo ahref('poll', 'add', array('menu'=>$_GET["menu"]));?>" class="button br" id="addcategory" style="float: right"><?php echo a("addpolls");?></a>
				</div>					
			</div>		
		</div>
<script language="javascript">
function chclick(idx) {
	var active = ($('#vis_'+idx).val()==0) ? 1:0; 
	$.post("<?php echo ahref('poll', 'visibility');?>&idx=" + idx + "&visibility=" + active, function() {
		if(active==1) 
	        $('#img_'+idx).attr("src","_tripadmin/img/buttons/icon_visible.png"); 
		else
	        $('#img_'+idx).attr("src","_tripadmin/img/buttons/icon_unvisible.png"); 
		$('#vis_'+idx).val(active);
	});
};	

function del(id, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
		window.location="<?php echo ahref('poll','delete');?>&id=" + id + "&menu=<?php echo $_GET["menu"];?>";
	}
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