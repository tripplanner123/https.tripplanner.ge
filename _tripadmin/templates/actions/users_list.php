<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/buttons/_user.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo a("userlist");?></div>
		</div>	
		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<a href="<?php echo ahref(array($route[0], 'add'));?>" class="button br" style="float: right"><?php echo a("newuser");?></a>
				</div>	
				<div id="user">
					<div class="list-top">
						<div class="check"><?php echo a("active");?></div>
						<div class="name"><?php echo a("username");?></div>
                        <div class="full"><?php echo a("fullname");?></div>
                        <div class="mail"><?php echo a("email");?></div>
						<div class="action fix"><?php echo a('actions');?></div>
                        <div class="group">ID</div>
                        <div class="fullname"><?php echo a("group");?></div>
						
						
					</div>
<?php
	$class = 'list';
	foreach($users as $user) :
		if ($user['class'] == 0) continue;
		if($class == 'list2') $class = 'list'; else $class = 'list2';
		$ch = ($user["active"]=='1') ? '' : 'un';
?>
					<div id="div<?php echo $user['id'] ?>" class="<?php echo $class;?> fix">
						<div class="check">
							<a href="javascript:chclick(<?php echo $user['id'];?>);"><img src="_tripadmin/img/buttons/icon_<?php echo $ch;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="img_<?php echo $user['id'];?>" style="width:9px;height:9px;" /></a>
                            <input type="hidden" name="vis_<?php echo $user['id'];?>" id="vis_<?php echo $user['id'];?>" value="<?php echo $user['active'];?>" />
                        </div>
						<div class="name b"><a href="<?php echo ahref(array($route[0], 'edit', $user['id']));?>"><?php echo $user["username"];?></a></div>
                        <div class="full"><?php echo ($user["firstname"] || $user["lastname"]) ? $user["firstname"].' '.$user["lastname"] : 'N/A' ;?></div>
                        <div class="mail"><?php echo $user["email"];?></div>
						<div class="action fix">
							<a href="<?php echo ahref(array($route[0], 'edit', $user['id']));?>"><img src="_tripadmin/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.editcontent');?>" /></a>
							<a href="javascript:del(<?php echo $user['id'];?>, '<?php echo $user['username'];?>');"><img src="_tripadmin/img/buttons/icon_delete.png" class="star" title="<?php echo a('ql.delete');?>" /></a>
						</div>
						<div class="group"><?php echo $user["id"];?></div>
                        <div class="fullname"><?php echo $user["usercat"];?></div>		

						
					</div>
<?php endforeach; ?>
				</div>	
<?php
	$uc = a_s("users.per.page");
	$curpage = ceil((get("start", 0) + 1) / $uc);
	$firstpage = 1;
	$lastpage = ceil(($count) / $uc);
	$first = get("start", 0) - ($uc * 3);
	$j = ($curpage > 1) ? $curpage - 1 : 0; 
	$k = ($curpage < $lastpage) ? $curpage + 1 : $lastpage; 
?>
				<div id="bottom" class="fix">
					<ul id="page" class="fix left">
						<li><a href="<?php echo ahref(array($route[0], ''), array('start' => 0));?>"><img src="_tripadmin/img/prev2.png" width="5" height="5" alt=""  class="arrow" /></a></li>
						<li><a href="<?php echo ahref(array($route[0], ''), array('start' => $uc * ($j - 1)));?>"><img src="_tripadmin/img/prev.png" width="5" height="5" alt=""  class="arrow" /></a></li>
<?php
	for($i = $firstpage; $i<=$lastpage; $i++) {
?>
						<li><?php echo ($i == $curpage) ? '<span style="color:#2e84d7; font-weight:bold;">' : '<a href="'.ahref(array($route[0], ''), array('start' => $uc * ($i - 1))).'">';?><?php echo $i;?><?php echo ($i == $curpage) ? '</span>' : '</a>';?></li>
<?php
	}
?>
						<li><a href="<?php echo ahref(array($route[0], ''), array('start' => $uc * ($k - 1)));?>"><img src="_tripadmin/img/next.png" width="5" height="5" alt="" class="arrow" /></a></li>
						<li><a href="<?php echo ahref(array($route[0], ''), array('start' => $uc * ($lastpage - 1)));?>"><img src="_tripadmin/img/next2.png" width="5" height="5" alt="" class="arrow" /></a></li>
					</ul>
					<a href="<?php echo ahref(array($route[0], 'add'));?>" class="button br" style="float: right"><?php echo a("newuser");?></a>
				</div>					
			</div>		
		</div>
<script language="javascript">
function chclick(id) {
	var activity = ($('#vis_'+id).val()=='1') ? '0':'1'; 
	$.post("<?php echo ahref(array($route[0], 'activity'));?>?id=" + id + "&active=" + activity, function() {
		if(activity=='1') 
	        $('#img_'+id).attr("src","_tripadmin/img/buttons/icon_visible.png"); 
		else
	        $('#img_'+id).attr("src","_tripadmin/img/buttons/icon_unvisible.png"); 
		$('#vis_'+id).val(activity);
	});
};	

function del(id, title) {
	if (confirm("<?php echo a('deletequestion'); ?>" + title + "?")) {
		$.post("<?php echo ahref(array($route[0], 'delete'));?>?id=" + id, function(){
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