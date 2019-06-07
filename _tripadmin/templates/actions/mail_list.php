<?php defined('DIR') OR exit; ?>

		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/buttons/_table.png" width="16" height="16" alt="" /></div>			
			<div class="name">Mail List</div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
				</div>	
				<div id="info">
					<div class="list-top">
						<div class="name-title"  style="padding-left:45px;"><?php echo a('name');?></div>	
						<div class="act2 fix"><?php echo a('actions');?></div>	
						<div class="pid">ID</div>									
											
					</div>
<?php
	$class='list';
	foreach($data["maillist"] as $mail) :
		if($class == 'list2') $class = 'list'; else $class = 'list2';
?>
					<div class="<?php echo $class;?> fix">
						<div class="name4"><? echo $mail["email"]; ?>&nbsp;</div>									
						<div class="action2 fix">
							<a href="javascript:del('<?php echo $mail['id'];?>','<?php echo $mail['email'];?>');" title="<?php echo a('ql.delete');?>"><img src="_tripadmin/img/buttons/icon_delete.png" /></a>
						</div>
						<div class="id"><? echo $mail['id']; ?></div>									
															
					</div>		
<?php endforeach; ?>
				</div>	
			</div>		
		</div>
        
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/buttons/_table.png" width="16" height="16" alt="" /></div>			
			<div class="name">Mail List For Copy</div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="info">
<?php
	$maillist = array();
	foreach($data["maillist"] as $mail) :
		$maillist[] = $mail["email"];
	endforeach;
	$mailstring = implode(";", $maillist);
	echo $mailstring;
?>                
                </div>
			</div>
        </div>                
        
<script language="javascript">
function del(id,email) {
	if (confirm("<?php echo a("deletequestion"); ?>" + email + "?")) { 
 
		window.location.href="<?php echo ahref(array('mailinglistnews','delete'));?>?id=" + id;
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
