<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/edit.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo $pagetitle ?></div>
		</div>	
		<div id="box">
			<div id="part">
				<div id="top" class="fix">
<?php if($_SESSION['auth']["class"] == '0' || $route[0]!='settings') { ?>
					<a href="<?php echo ahref(array($route[0], 'add'));?>" class="button br" id="addcategory" style="float: right"><?php echo a('addsetting');?></a>
<?php } ?>
				</div>	
				<div id="info">
					<div class="list-top">
						<div class="name-title"><?php echo a('name');?></div>	
						<div class="act2 fix"><?php echo a('actions');?></div>	
                        <div class="url3"><?php echo a('value');?></div>									
											
					</div>
<?php
	$class = 'list';
	foreach($items as $setting) :
		if($class == 'list2') $class = 'list'; else $class = 'list2';
?>
					<div class="<?php echo $class;?> fix">
						<div class="icon"><img src="_tripadmin/img/table.png" width="16" height="16" alt="" /></div>									
						<div class="name4"><a href="<?php echo ahref(array($route[0], 'edit', $setting['id']));?>"><?php echo $setting['title']; ?></a></div>									
						<div class="action2 fix">
							<a href="<?php echo ahref(array($route[0], 'edit', $setting['id']));?>" title="<?php echo a('ql.edit');?>"><img src="_tripadmin/img/buttons/icon_edit.png" /></a>
<?php if($_SESSION['auth']["class"] == '0' || $route[0]!='settings') { ?>
							<a href="javascript:del('<?php echo $setting['id'];?>', '<?php echo $setting['title'];?>');" title="<?php echo a('ql.delete');?>"><img src="_tripadmin/img/buttons/icon_delete.png" /></a>
<?php } ?>
						</div>									
                        <div class="url3"><?php echo $setting['value']; ?></div>		
					</div>		
<?php endforeach; ?>
				</div>	
				<div id="bottom" class="fix">
<?php if($_SESSION['auth']["class"] == '0' || $route[0]!='settings') { ?>
					<a href="<?php echo ahref(array($route[0], 'add'));?>" class="button br" style="float: right"><?php echo a('addsetting');?></a>
<?php } ?>
				</div>					
			</div>		
		</div>
<script language="javascript">
function del(id, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
		window.location="<?php echo ahref(array($route[0],'delete'));?>?id=" + id;
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