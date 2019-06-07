<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/buttons/_table.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo $title;?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
<?php if(in_array($route[0], array('pages', 'bannergroups'))) { ?>
					<a href="<?php echo ahref(array($type, 'add'));?>" class="button br" id="addcategory" style="float: right"><?php echo $add;?></a>
<?php } ?>
				</div>	
				<div id="info">
					<div class="list-top">
						<div class="name-title"  style="padding-left:45px;"><?php echo a('name');?></div>	
						<div class="act2 fix"><?php echo a('actions');?></div>	
                        <div class="ptype"><?php echo a('type');?></div>									
						<div class="pid">ID</div>									
											
					</div>
<?php
	$class = 'list';
	foreach($topics as $topic) :
		$img="table";
		$table_name="pages";
		switch($topic['type']): 
			case 'audiogallery' : 	$table_name = "galleries"; $img = "sound"; break;
			case 'videogallery' : 	$table_name = "galleries"; $img = "film"; break;
			case 'imagegallery' : 	$table_name = "galleries"; $img = "camera"; break;
			case 'poll' : 			$table_name = "pollanswers"; $img = "chart_bar"; break;
			case 'catalog' : 		$table_name = "catalogs"; $img = "cart"; break;
		endswitch;
		$linktype = $topic['type']; if($linktype == 'sitemap') $linktype = 'sitemap'; if($linktype == 'list') $linktype = 'customlist';
		if($class == 'list2') $class = 'list'; else $class = 'list2';
		$count = db_fetch("SELECT count(*) as items from ".$table_name." where menuid={$topic['id']} and language='".l()."'");
		if(($topic['type']!='banners')&&($topic['type']!='sitemap')) {
			$ttl = db_retrieve('title', c("table.pages"), 'menutype', $topic['id'], ' and language = "'.l().'" LIMIT 1');
		} else {
			$ttl = $topic['title'];
		}
?>
					<div id="div<?php echo $topic['id'] ?>" class="<?php echo $class;?> fix">
						<div class="icon4"><img src="_tripadmin/img/buttons/_<?php echo $img;?>.png" width="16" height="16" alt="" /></div>									
						<div class="name4"><a href="<?php echo ahref(array($linktype, 'show', $topic["id"]));?>"><?php echo $ttl; ?>&nbsp;</a></div>									
						<div class="action2 fix">
                            <a href="<?php echo ahref(array($linktype, 'show', $topic["id"])) ?>" title="<?php echo a('ql.editcontent');?>"><img src="_tripadmin/img/buttons/icon_files_edit.png" /></a>
							<a href="<?php echo ahref(array($type, 'edit', $topic['id']));?>" title="<?php echo a('ql.edit');?>"><img src="_tripadmin/img/buttons/icon_edit.png" /></a>
<?php if($count["items"] < 1 && in_array($topic['type'], array('sitemap', 'bannergroups'))): ?>
							<a href="javascript:del('<?php echo $topic['id'];?>', '<?php echo $topic['title'];?>');" title="<?php echo a('ql.delete');?>"><img src="_tripadmin/img/buttons/icon_delete.png" /></a>
<?php else: ?>
							<a href="javascript:;"><img src="_tripadmin/img/buttons/icon_delete_inactive.png" /></a>
<?php endif; ?>
						</div>
                        <div class="date"><?php echo $topic['type']; ?></div>									
						<div class="id"><?php echo $topic['id']; ?></div>									
															
					</div>		
<?php endforeach; ?>
				</div>	
				<div id="bottom" class="fix">
<?php if(in_array($route[0], array('pages', 'bannergroups'))) { ?>                
					<a href="<?php echo ahref(array($type, 'add'));?>" class="button br" id="addcategory" style="float: right"><?php echo $add;?></a>
<?php } ?>
				</div>					
			</div>		
		</div>
<script language="javascript">
function del(id, title) {
	if (confirm("<?php echo a('deletequestion'); ?>" + title + "?")) {
		$.post("<?php echo ahref(array($type, 'delete'));?>?id=" + id, function(){
			$("#div" + id).innerHTML = "";
			$("#div" + id).hide();
		});
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
