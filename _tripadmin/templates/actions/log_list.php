<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/buttons/_table.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo a("log");?></div>
		</div>	
		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<a href="javascript:clear('<?php echo a('clearlogquestion');?>');" class="button br" style="float: right"><?php echo a("clearlog");?></a>
				</div>	
				<div id="user">
					<div class="list-top">
						<div class="name"><?php echo a("ipaddress");?></div>
						<div class="fullname"><?php echo a("visitdate");?></div>
						<div class="group"><?php echo a("section");?></div>
						<div class="action fix"><?php echo a("subsection");?></div>
					</div>
<?php
	$class = 'list';
	foreach($data["log"] as $log) :
		if($class == 'list2') $class = 'list'; else $class = 'list2';
?>
					<div id="user" class="<?php echo $class;?> fix">
						<div class="name"><?php echo $log["ipaddress"];?></a></div>
						<div class="fullname"><?php echo $log["visitdate"];?></div>		
						<div class="group"><?php echo $log["action"];?></div>
						<div class="action"><?php echo $log["subaction"];?></div>
					</div>
<?php endforeach; ?>
				</div>	
<?php
	$curpage = ceil((get("start", 0) + 1) / 50);
	$firstpage = 1;
	$lastpage = ceil(($data["count"]) / 50);
	$first = get("start", 0) - (50 * 3);
	$j = ($curpage > 1) ? $curpage - 1 : 0; 
	$k = ($curpage < $lastpage) ? $curpage + 1 : $lastpage; 
?>
				<div id="bottom" class="fix">
					<ul id="page" class="fix left" style="width:720px; float: left;">
						<li><a href="<?php echo ahref('log', '', array('start' => 0));?>"><img src="_tripadmin/img/prev2.png" width="5" height="5" alt=""  class="arrow" /></a></li>
						<li><a href="<?php echo ahref('log', '', array('start' => 50 * ($j - 1)));?>"><img src="_tripadmin/img/prev.png" width="5" height="5" alt=""  class="arrow" /></a></li>
<?php
	for($i = $firstpage; $i<=$lastpage; $i++) {
?>
						<li><?php echo ($i == $curpage) ? '<span style="color:#2e84d7; font-weight:bold;">' : '<a href="'.ahref('log', '', array('start' => 50 * ($i - 1))).'">';?><?php echo $i;?><?php echo ($i == $curpage) ? '</span>' : '</a>';?></li>
<?php
	}
?>
						<li><a href="<?php echo ahref('log', '', array('start' => 50 * ($k - 1)));?>"><img src="_tripadmin/img/next.png" width="5" height="5" alt="" class="arrow" /></a></li>
						<li><a href="<?php echo ahref('log', '', array('start' => 50 * ($lastpage - 1)));?>"><img src="_tripadmin/img/next2.png" width="5" height="5" alt="" class="arrow" /></a></li>
					</ul>
					<a href="javascript:clear('<?php echo a('clearlogquestion');?>');" class="button br" style="float: right"><?php echo a("clearlog");?></a>
				</div>					
			</div>		
		</div>
<script language="javascript">
function clear(title) {
	if (confirm(title + "?")) { 
		window.location="<?php echo ahref('log', 'clear');?>";
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