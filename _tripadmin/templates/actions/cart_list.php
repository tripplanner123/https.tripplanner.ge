<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/buttons/_user.png" width="16" height="16" alt="" /></div>
			<div class="name">Orders</div>
		</div>
		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<!-- <a href="<?php echo ahref(array($route[0], 'add'));?>" class="button br" style="float: right">Add</a> -->

					<input type="text" class="inp" id="searchuser" name="searchuser" style="margin-top:0px;" value="<?=(isset($_GET["u"])) ? htmlentities($_GET["u"]) : ""?>" placeholder="Search by username" />

					<input type="date" name="orderdate" id="orderdate" placeholder="Order date" style="float: left; width: 150px; background: #fff; border: 1px solid #d8d8d8; height:24px; font-size: 12px; margin: 0 0 0 4px; line-height: 24px" value="<?=(isset($_GET["o"])) ? htmlentities($_GET["o"]) : ""?>" />
					<?php 
					$g_transfer_start_places = g_transfer_start_places();
					?>
					<select class="start-place" style="float: left; width: 150px; background: #fff; border: 1px solid #d8d8d8; height:24px; font-size: 12px; margin: 0 0 0 4px; line-height: 24px">
						<option value="">start place</option>
						<?php foreach($g_transfer_start_places as $v): ?>
						<option value="<?=$v["id"]?>" <?=(isset($_GET["s"]) && $_GET["s"]==$v["id"]) ? "selected='selected'" : ""?>><?=$v["title"]?></option>
						<?php endforeach; ?>
					</select>

					<select class="end-place" style="float: left; width: 150px; background: #fff; border: 1px solid #d8d8d8; height:24px; font-size: 12px; margin: 0 0 0 4px; line-height: 24px">
						<option value="">end place</option>
						<?php foreach($g_transfer_start_places as $v): ?>
						<option value="<?=$v["id"]?>" <?=(isset($_GET["e"]) && $_GET["e"]==$v["id"]) ? "selected='selected'" : ""?>><?=$v["title"]?></option>
						<?php endforeach; ?>
					</select>

					<a href="javascript:searchOrder();" class="button br">Filter</a>

					<?php 
					$admin = $_SESSION['auth']["id"];
					?>
					<div id="sitemap-xml" class="right">
						<form action="https://tripplanner.ge/export.php?from=usersList&type=transport&lang=<?=l()?>&admin=<?=$admin?>" method="post" target="_blank">
							<input type="submit" name="submit" value="Export transfer orders" class="button br">
						</form>
						<?php if($_SESSION['auth']["id"]==1): ?>
						<form action="https://tripplanner.ge/export.php?from=usersList&type=plantrip&lang=<?=l()?>&admin=<?=$admin?>" method="post" target="_blank">
							<input type="submit" name="submit" value="Export Tour Planning orders" class="button br">
						</form>
						<form action="https://tripplanner.ge/export.php?from=usersList&type=ongoing&lang=<?=l()?>&admin=<?=$admin?>" method="post" target="_blank">
							<input type="submit" name="submit" value="Export Ongoing Tours orders" class="button br">
						</form>
						<?php endif; ?>
					</div>
				</div>
				<div id="user">
					<div class="list-top">
						<div class="name" style="width:100px;">Date</div>
						<div class="name" style="width:100px;">Pick up</div>
						<div class="name" style="width:200px;">UserName</div>
						<div class="full" style="width:120px;">Total price</div>
						<div class="full" style="width:130px;">Fro-To Guests</div>
						
						<div class="action fix"><?php echo a("actions");?></div>
						<div class="right" style="width:80px;">ID</div>
						<div class="right" style="width:80px;">Website</div>
						<div class="right" style="width:80px;">Type</div>
						<div class="right" style="width:80px;">status</div>
					</div>
					<?php
						$class = 'list';
						foreach($cart as $cartx) :
							if($class == 'list2') $class = 'list'; else $class = 'list2';
							// $ch = ($cartx["active"]=='1') ? '' : 'un';
					?>
					<div id="div<?php echo $cartx['id'] ?>" class="<?php echo $class;?> fix">
						<div class="name" style="width:100px;">
							<a href=""><?php echo date("Y-m-d H:i:s",$cartx["date"]);?></a>
						</div>
						<div class="name" style="width:100px;">
							<p><?php echo $cartx["wherepickup"];?></p>
							<p>&nbsp;</p>
							<p><?php echo $cartx["startdate"]." ".$cartx["timetrans"];?></p>
							<?php if($cartx['roud2_price']>0): ?>
							<p>--------------</p>
							<p><?php echo $cartx["wherepickup2"];?></p>
							<p>&nbsp;</p>
							<p><?=$cartx['startdate2']?></p>
							<p><?=$cartx['timetrans2']?></p>
							<?php endif; ?>
						</div>
						<div class="name" style="width:200px;">
							<a href="<?php echo ahref(array($route[0], 'edit', $cartx['id']));?>"><?php echo $cartx["userid"];?></a>
						</div>
                        <div class="full" style="width:120px;">
                        	<span><?=$cartx['roud1_price']?> GEL</span>
                            <br />
                            <?php if($cartx['roud2_price']>0): ?>
                            <span><?=$cartx['roud2_price']?> GEL</span>
                            <?php endif; ?>		
                        </div>

                        <div class="name" style="width: 130px">
                        	<?php 
                        	if($cartx["type"]=="transport"){
                                if($cartx['startPlaceName2'] && $cartx['endPlaceName2']){

                                	if($cartx["guests"]<=3){
                                    	$vehical = "Car";
                                    }else if($cartx["guests"]>3){
                                    	$vehical = "Mini Van";
                                    }else if($cartx["guests"]>7){
                                    	$vehical = "Bus";
                                    }

                                    $title = $cartx["startPlaceName"] . " - " . $cartx["endPlaceName"];
                                    $guests = "<br />".$cartx["guests"]." ".l("passenger")."<br /> ".$vehical."<br />";

                                    if($cartx["guests2"]<=3){
                                    	$vehical = "Car";
                                    }else if($cartx["guests2"]>3){
                                    	$vehical = "Mini Van";
                                    }else if($cartx["guests2"]>7){
                                    	$vehical = "Bus";
                                    }
                                    $guests .= $cartx["startPlaceName2"] . " - " . $cartx["endPlaceName2"];
                                    $guests .= "<br />".$cartx["guests2"]." ".l("passenger")."<br />" . $vehical;
                                    
                                    

                                }else{
                                	if($cartx["guests"]<=3){
                                    	$vehical = "Car";
                                    }else if($cartx["guests"]>3){
                                    	$vehical = "Mini Van";
                                    }else if($cartx["guests"]>7){
                                    	$vehical = "Bus";
                                    }

                                    $title = $cartx["startPlaceName"] . " - " . $cartx["endPlaceName"];
                                    $guests = "<br />".$cartx["guests"]." ".l("passenger")."<br />". $vehical;
                                } 
                                ?>
                                <span><?=$title?></span><?=$guests?>
                            <?php
                            }else{
                            	echo "N/A";
                            }
                        	?>
                        </div>
                        
						
						<div class="action fix" style="padding-top:6px;">
							<!-- <a href="<?php echo ahref(array($route[0], 'edit', $cartx['id']));?>"><img src="_tripadmin/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.editcontent');?>" /></a> -->
							<a href="javascript:alert('დამზღვევი: <?=$cartx["damzgvevi"]?>\nდაზღვეული: <?=$cartx["dazgveuli"]?>\nმისამართი: <?=$cartx["misamarti"]?>\nდაბ. თარიღი: <?=$cartx["dabtarigi"]?>\nპასპ. ნომერი: <?=$cartx["pasporti"]?>\nპირადი ნომერი: <?=$cartx["piradinomeri"]?>\nტელეფონის ნომერი: <?=$cartx["telefonis"]?>');" style="margin-right: 5px;"><img src="_tripadmin/img/buttons/_table.png" class="star" title="Insuarance data" /></a>

							<?php if($cartx["status"]=="payed"): ?>
								<!-- <a href="javascript:void(0)" style="margin-right:5px;" title="Paid" onclick="changePayementStatus(<?=$cartx['id']?>)"><img src="_tripadmin/img/buttons/icon_visible.png" class="star" /></a> -->
							<?php endif;?>

							<?php if($cartx["status"]=="invoiced"): ?>
								<a href="javascript:void(0)" style="margin-right:5px;" title="Change payment status" onclick="changePayementStatus(<?=$cartx['id']?>)"><img src="_tripadmin/img/buttons/icon_unvisible.png" class="star" /></a>
							<?php endif;?>

							<?php 
	    					$attachment = "#";
	    					if(isset($cartx["attachment"]) && !empty($cartx["attachment"])){
	    						$attachment = str_replace("/home4/tripplanner/public_html/", "/", $cartx["attachment"]);
	    					}
	    					?>
							<a href="<?=$attachment?>" style="margin-right:5px;" target="_blank"><img src="_tripadmin/img/pdf.png" class="star" title="Invoice" /></a>

							<a href="javascript:del(<?php echo $cartx['id'];?>, '<?php echo $cartx['userid'];?>');"><img src="_tripadmin/img/buttons/icon_delete.png" class="star" title="<?php echo a('ql.delete');?>" /></a>
						</div>
						<div class="right" style="width:80px;"><?php echo $cartx["id"];?></div>
						<div class="right" style="width:80px;"><?php echo $cartx["website"];?></div>
						<div class="right" style="width:80px;"><?php echo ($cartx["type"]) ? $cartx["type"] : 'N/A' ;?></div>
						<div class="right" style="width:80px;"><?php 
						if(isset($cartx["status"]) && $cartx["status"]=="payed"){
							echo "Paid";
						}else if(isset($cartx["status"]) && $cartx["status"]=="invoiced"){
							echo "Invoiced";
						}else if(isset($cartx["status"]) && $cartx["status"]=="unpayed"){
							echo "Unpaid";
						}else{
							echo "N/A";
						}
						?></div>
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

	$u = "";
	$o = "";
	$s = "";
	$e = "";
	if(isset($_GET["u"]) && !empty($_GET["u"])){
		$u = $_GET["u"];
	}
	if(isset($_GET["o"]) && !empty($_GET["o"])){
		$o = $_GET["o"];
	}
	if(isset($_GET["s"]) && !empty($_GET["s"])){
		$s = $_GET["s"];
	}
	if(isset($_GET["e"]) && !empty($_GET["e"])){
		$e = $_GET["e"];
	}
?>
				<div id="bottom" class="fix">
					<ul id="page" class="fix left">
						<li><a href="<?php echo ahref(array($route[0], 'show'), array('start' => 0, 'u' => $u, 'o'=>$o, 's' => $s, 'e'=>$e));?>"><img src="_tripadmin/img/prev2.png" width="5" height="5" alt=""  class="arrow" /></a></li>
						<li><a href="<?php echo ahref(array($route[0], 'show'), array(
							'start' => $uc * ($j - 1),'u' => $u, 'o'=>$o, 's' => $s, 'e'=>$e));?>"><img src="_tripadmin/img/prev.png" width="5" height="5" alt=""  class="arrow" /></a></li>
<?php
	for($i = $firstpage; $i<=$lastpage; $i++) {
?>
						<li><?php echo ($i == $curpage) ? '<span style="color:#2e84d7; font-weight:bold;">' : '<a href="'.ahref(array($route[0], 'show'), array('start' => $uc * ($i - 1), 'u' => $u, 'o'=>$o, 's' => $s, 'e'=>$e)).'">';?><?php echo $i;?><?php echo ($i == $curpage) ? '</span>' : '</a>';?></li>
<?php
	}
?>
						<li><a href="<?php echo ahref(array($route[0], 'show'), array('start' => $uc * ($k - 1), 'u' => $u, 'o'=>$o, 's' => $s, 'e'=>$e));?>"><img src="_tripadmin/img/next.png" width="5" height="5" alt="" class="arrow" /></a></li>
						<li><a href="<?php echo ahref(array($route[0], 'show'), array('start' => $uc * ($lastpage - 1), 'u' => $u, 'o'=>$o, 's' => $s, 'e'=>$e));?>"><img src="_tripadmin/img/next2.png" width="5" height="5" alt="" class="arrow" /></a></li>
					</ul>
					<!-- <a href="<?php echo ahref(array($route[0], 'add'));?>" class="button br" style="float: right"><?php echo a("newuser");?></a> -->
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

function changePayementStatus(id){
	var conf = confirm("გსურთ გადახდის სტატუსის ცვლილება ?");
	if(conf){
		$.ajax({
	        type: "POST",
	        url: "/<?=l()?>/?ajax=true",
	        data: { 
	            type:"changePaymentStatusFromAdmin",
	            id:id          
	        } 
	    }).done(function( msg ) {
	        var obj = $.parseJSON(msg);
	        var errorFields = obj.Error.errorFields;
	        if(obj.Error.Code==1){            
	            console.log(obj.Error.Text);
	        }else{
	            location.reload();
	        }
	    });
	}
}

function searchOrder(){
	var searchuser = document.getElementById("searchuser").value;
	var orderdate = document.getElementById("orderdate").value;
	var startPlace = document.getElementsByClassName("start-place")[0].value;
	var endPlace = document.getElementsByClassName("end-place")[0].value;

	if(typeof searchuser === "undefined" || searchuser==""){
		searchuser="";
	}

	if(typeof orderdate === "undefined" || orderdate==""){
		orderdate="";
	}

	if(typeof startPlace === "undefined" || startPlace==""){
		startPlace="";
	}

	if(typeof endPlace === "undefined" || endPlace==""){
		endPlace="";
	}
	
	location.href = "/<?=l()?>/badmin/cart?u="+searchuser+"&o="+orderdate+"&s="+startPlace+"&e="+endPlace;
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