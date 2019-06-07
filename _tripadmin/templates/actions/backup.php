<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/edit.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo a("backup");?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<a href="<?php echo ahref('backup', 'create');?>" class="button br" style="float: right"><?php echo a('createbackup');?></a>
				</div>	
				<div id="info">
					<div class="list-top">
						<div class="name-title" style="padding-left:45px;"><?php echo a('name');?></div>	
						<div class="act2 fix"><?php echo a('actions');?></div>	
                        <div class="url2"><?php echo a('date');?></div>						
					</div>
<?php
	$class = 'list';

	if ($handle = opendir(c('folders.backup'))) {
		
		$files = array(); 
	    while (false !== ($file = readdir($handle))) {
		 	if ($file != "." && $file != "..") {
				$files[] = $file; 
			}
		}
		rsort($files); 
		closedir($handle); 
		foreach ($files as $file) {
			if($class == 'list2') $class = 'list'; else $class = 'list2';
		 	if ($file != "." && $file != "..") {
				$ext = strtolower(substr(strrchr($file, '.'), 1));
				$fileicon = ($ext == 'zip') ? '_compress_link' : '_backup_link';
				$filedate = ($ext == 'zip') ? substr($file, 10, 19) : substr($file, 10, 19);
				$filetitle = ($ext == 'zip') ? a('backup.files') : a('backup.database');
?>
					<div class="<?php echo $class;?> fix">
						<div class="icon4"><img src="_tripadmin/img/buttons/<?php echo $fileicon;?>.png" width="16" height="16" alt="" /></div>									
						<div class="name4"><a href="<?php echo c('folders.backup') . $file;?>"><?php echo $filetitle; ?></a></div>									
															
						<div class="act2 fix">
							<a href="<?php echo c('folders.backup') . $file;?>"><img src="_tripadmin/img/buttons/icon_link.png" /></a>
<?php if($_SESSION['auth']["class"] == '0') { ?>
							<a href="javascript:del('<?php echo $file;?>', '<?php echo $file;?>');"><img src="_tripadmin/img/buttons/icon_delete.png" /></a>
<?php } ?>
						</div>
                        <div class="url2"><? echo str_replace('_', ' ', str_replace('.', ':', $filedate)); ?></div>									
					</div>		
<?php 
			}
		}
	}
?>
				</div>	
				<div id="bottom" class="fix">
					<a href="<?php echo ahref('backup', 'create');?>" class="button br" style="float: right"><?php echo a('createbackup');?></a>
				</div>					
			</div>		
		</div>
<script language="javascript">
function del(id, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
		window.location("<?php echo ahref('backup','delete');?>&file=" + id);
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
