<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/buttons/_user.png" width="16" height="16" alt="" /></div>
			<div class="name"><?php echo a("userlist");?></div>
		</div>
		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<input type="text" class="inp" id="searchuser" name="searchuser" style="margin-top:0px;" value="<?=(isset($_GET["search"])) ? htmlentities($_GET["search"]) : ""?>" placeholder="Search E-Mail" />
					<a href="javascript:searchuser();" class="button br">Search</a>
					<a href="javascript:clearsearch();" class="button br">Clear</a>

					<a href="<?php echo ahref(array($route[0], 'add'));?>" class="button br" style="float: right"><?php echo a("newuser");?></a>
				</div>
				<div id="user">
					<div class="list-top">
						<div class="check"><?php echo a("active");?></div>
						<div class="name" style="width:300px;padding-left:50px;">Reg. date</div>
						<div class="full" style="width:320px;"><?php echo a("email");?></div>
						<div class="action fix"><?php echo a("actions");?></div>
						<div class="right" style="width:70px;">ID</div>
						<div class="right" style="width:160px;">Website</div>
					</div>
<?php
	$class = 'list';
	foreach($users as $user) :
		if($class == 'list2') $class = 'list'; else $class = 'list2';
		$ch = ($user["active"]=='1') ? '' : 'un';
?>
					<div id="div<?php echo $user['id'] ?>" class="<?php echo $class;?> fix">
						<div class="check">
							<a href="javascript:chclick(<?php echo $user['id'];?>);"><img src="_tripadmin/img/buttons/icon_<?php echo $ch;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="img_<?php echo $user['id'];?>" style="width:9px;height:9px;" /></a>
                            <input type="hidden" name="vis_<?php echo $user['id'];?>" id="vis_<?php echo $user['id'];?>" value="<?php echo $user['active'];?>" />
                        </div>
						<div class="name" style="width:300px;padding-left:50px;">
							<a href=""><?php echo date("Y-m-d H:i:s", $user["date"]);?></a>
						</div>
                        <div class="full" style="width:320px;"><?php echo ($user["username"]) ? $user["username"] : 'N/A' ;?></div>
						
						<div class="action fix" style="padding-top:6px;">
							<a href="<?php echo ahref(array($route[0], 'edit', $user['id']));?>" style="padding-right:6px;">
								<img src="_tripadmin/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.editcontent');?>" />
							</a>

							<a href="export.php?from=usersList&type=transport&id=<?=$user["username"]?>&lang=<?=l()?>" style="padding-right:6px;" target="_blank">
								<img src="_tripadmin/img/buttons/icon_arrow_down_1.png" class="star" title="Export Transport Orders" />
							</a>

							<a href="export.php?from=usersList&type=plantrip&id=<?=$user["username"]?>&lang=<?=l()?>" style="padding-right:6px;" target="_blank">
								<img src="_tripadmin/img/buttons/icon_arrow_down_1.png" class="star" title="Export Planing Tour" />
							</a>
							
							<a href="export.php?from=usersList&type=ongoing&id=<?=$user["username"]?>&lang=<?=l()?>" style="padding-right:6px;" target="_blank">
								<img src="_tripadmin/img/buttons/icon_arrow_down_1.png" class="star" title="Export Ongoing Tour" />
							</a>

							<a href="javascript:del(<?php echo $user['id'];?>, '<?php echo $user['email'];?>');"><img src="_tripadmin/img/buttons/icon_delete.png" class="star" title="<?php echo a('ql.delete');?>" /></a>
						</div>
						<div class="right" style="width:70px;"><?php echo $user["id"];?></div>
						<div class="right" style="width:160px;"><?php echo $user["website"];?></div>
					</div>
<?php endforeach; ?>
				</div>
<?php
	$uc = a_s("siteusers.per.page");
	$curpage = ceil((get("start", 0) + 1) / $uc);
	$firstpage = 1;
	$lastpage = ceil(($count) / $uc);
	$first = get("start", 0) - ($uc * 3);
	$j = ($curpage > 1) ? $curpage - 1 : 0;
	$k = ($curpage < $lastpage) ? $curpage + 1 : $lastpage;
?>
				<div id="bottom" class="fix">
					<ul id="page" class="fix left">
						<li><a href="<?php echo ahref(array($route[0], 'show'), array('start' => 0));?>"><img src="_tripadmin/img/prev2.png" width="5" height="5" alt=""  class="arrow" /></a></li>
						<li><a href="<?php echo ahref(array($route[0], 'show'), array('start' => $uc * ($j - 1)));?>"><img src="_tripadmin/img/prev.png" width="5" height="5" alt=""  class="arrow" /></a></li>
<?php
	for($i = $firstpage; $i<=$lastpage; $i++) {
?>
						<li><?php echo ($i == $curpage) ? '<span style="color:#2e84d7; font-weight:bold;">' : '<a href="'.ahref(array($route[0], 'show'), array('start' => $uc * ($i - 1))).'">';?><?php echo $i;?><?php echo ($i == $curpage) ? '</span>' : '</a>';?></li>
<?php
	}
?>
						<li><a href="<?php echo ahref(array($route[0], 'show'), array('start' => $uc * ($k - 1)));?>"><img src="_tripadmin/img/next.png" width="5" height="5" alt="" class="arrow" /></a></li>
						<li><a href="<?php echo ahref(array($route[0], 'show'), array('start' => $uc * ($lastpage - 1)));?>"><img src="_tripadmin/img/next2.png" width="5" height="5" alt="" class="arrow" /></a></li>
					</ul>
					<a href="<?php echo ahref(array($route[0], 'add'));?>" class="button br" style="float: right"><?php echo a("newuser");?></a>
				</div>
			</div>
		</div>
<script language="javascript">
function chclick(id) {
	var activity = ($('#vis_'+id).val()=='1') ? '0':'1';
	$.post("<?php echo ahref(array($route[0], 'activity'));?>>id=" + id + "&active=" + activity, function() {
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

function insertParam(key, value)
{
    key = encodeURI(key); value = encodeURI(value);
    var kvp = document.location.search.substr(1).split('&');
    var i=kvp.length; var x; while(i--) 
    {
        x = kvp[i].split('=');
        if (x[0]==key)
        {
            x[1] = value;
            kvp[i] = x.join('=');
            break;
        }
    }
    if(i<0) {kvp[kvp.length] = [key,value].join('=');}
    //this will reload the page, it's likely better to store this until finished
	document.location.search = kvp.join('&'); 
}

function searchuser(){
	var searchuser = document.getElementById("searchuser").value;
	if(typeof searchuser !== "undefined" && searchuser!=""){
		insertParam("search", searchuser);
	}
}

function clearsearch(){
	insertParam("search", "");
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