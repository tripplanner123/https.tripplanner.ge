<?php 
defined('DIR') OR exit; 
if(!isset($_SESSION["trip_user"]) || empty($_SESSION["trip_user"])){
	$relpath = sprintf("/%s/registration", l());
	echo '<meta http-equiv="refresh" content="0; url='.$relpath.'">';
	exit();
}

if(isset($_GET["uploadphoto"]) && isset($_FILES["profile-photo"]["name"])){
	g_changeprofilephoto();
}

if(isset($_GET['order_id']) && !empty($_GET["order_id"])){
	g_sent_order_mail("payed", "payed", "green", $_GET["order_id"]);
}
$cur = "<i style=\"font-family: BPGGEL !important;\">A</i>"; //TripCheckbox
$cur_exchange = 1;
if(isset($_SESSION["currency"])){
	if($_SESSION["currency"]=="usd"){
		$cur = "$";
		$cur_exchange = (float)s("currencyusd");
	}

	if($_SESSION["currency"]=="eur"){
		$cur = "&euro;";
		$cur_exchange = (float)s("courseeur");
	}
}
?>
<!-- pickup Modal start -->
<div id="g-pickplace-modal" class="modal fade MessagesPopup" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="CloseButton" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
                <div class="Title" style="font-size: 21px; color: #27774d; font-weight: bold; margin-bottom: 10px;"><?=l("pickupmodaltitle")?></div>
                <div class="Text">
                    <form action="?" method="post" id="pickupplaceform">
                        <div class="resultPickupsave"></div>
                        <div class="MaterialForm" style="margin-bottom: 20px;">
                            <input type="text" class="form-control" id="pick1" name="placeform" value="" />
                        </div>
                        <div class="MaterialForm">
                            <input type="text" class="form-control" id="pick2" name="placeform" value="" />
                        </div>
                        

                        <button type="button" class="button button--small button--yellow w-100 text-uppercase savePickUp" style="margin: 15px 0px;"><?=l("save")?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- pickup Modal end -->


<div class="ProfilePageDiv"> 
	<div class="container">
		<h3 class="PageTitle">
			<label><?=l('profile')?></label>
		</h3>

		<div id="MyProfileMenuSelect">
			<select>
				<option value="0" data-hr="#cartitems"><?=l("cart")?></option>
				<option value="1" data-hr="#myorders"><?=l("orders")?></option>
				<option value="2" data-hr="#EditProFileLink"><?=l("editprofile")?></option>
				<option value="3" data-hr="#EditSecurity"><?=l("security")?></option>
				<option value="4"><?=l("logout")?></option>
			</select>
		</div>		
                		 
		<ul class="ProfileSidebar HideForMobile" id="ProfileSidebar">
			<div class="Title"><?=l('profile')?></div>
			<li class="active"><a href="#cartitems" class="tabLink" data-toggle="tab"><?=l("cart")?></a></li>
			<li><a href="#myorders" class="tabLink" data-toggle="tab"><?=l("orders")?></a></li>
			<li><a href="#EditProFileLink" class="tabLink" data-toggle="tab"><?=l("editprofile")?></a></li>
			<li><a href="#EditSecurity" class="tabLink" data-toggle="tab"><?=l("security")?></a></li>
			<li><a href="/<?=l()?>/registration"><?=l("logout")?></a></li>
		</ul>

		<div class="ProfileRightDiv">
			<div class="tab-content">
			    <div id="cartitems" class="tab-pane fade in active">
			    	<!-- START TOURS DIV -->
			    		<div class="ProfileToursDiv">
							<?php 
							$tprice = 0;
							foreach(g_cart("unpayed") as $item): 
								$doubleWay = "";
	        					$guests = "";
	        					$fromdate = "";
	        					$todate = "";
	        					if(!empty($item['tourplaces'])){
		        					$sql = "SELECT `title` FROM `catalogs` WHERE `id` IN(".$item['startplacex'].",".$item['tourplaces'].") AND `menuid`=36 AND `deleted`=0 AND `language`='".l()."' ORDER BY FIELD(`id`, ".$item['startplacex'].",".$item['tourplaces'].")"; 
		        					$fetch = db_fetch_all($sql);
		        					$places = array();
		        					foreach ($fetch as $v) {
		        						$places[] = $v['title'];
		        					}

		        					$item['title'] = implode("-><br />", $places);
		        					$item['image1'] = "/_website/img/plan.png";
		        					$price = $item['totalprice'];

		        					$fromdate = $item["startdate"];
	        						$todate = $item["startdate2"];
		        				}
		        				$image1 = $item['image1'];
		        				$title = $item['title'];

		        				if($item["type"]=="plantrip"){
		        					$title .= "<br />".l("adults").": ".$item["guests"];

		        					if($item["children"]!=0){
			    						$title .= "<br />".l("childrenages").": ".$item["children"];
			    					}

			                        if($item["childrenunder"]!=0){
			                            $title .= "<br />".l("underchildrenages").": ".$item["childrenunder"];
			                        }

		        				}

		        				$doubleway = false;
		        				if($item["type"]=="transport"){
		        					$image1 = "_website/img/transport.png";		        					
		        					
		        					if($item['startPlaceName2'] && $item['endPlaceName2']){
		        						$doubleway = true;
		        						$title = $item["startPlaceName"] . " - " . $item["endPlaceName"];
		        						$title .= "<br />".l("price").": ".$item["roud1_price"];		        						
		        						$title .= "<br />".l("adults").": ".$item["guests"];

		        						if($item["children"]!=0){
			    							$title .= "<br />".l("childrenages").": ".$item["children"];
			    						}

			                            if($item["childrenunder"]!=0){
			                                $title .= "<br />".l("underchildrenages").": ".$item["childrenunder"]."<br />";
			                            }


		        						$title .= $item["startPlaceName2"] . " - " . $item["endPlaceName2"];
		        						$title .= "<br />".l("price").": ".$item["roud2_price"];
		        						$title .= "<br />".l("adults").": ".$item["guests2"];

		        						if($item["children2"]!=0){
			    							$title .= "<br />".l("childrenages").": ".$item["children2"];
			    						}
			    						if($item["childrenunder2"]!=0){
			                                $title .= "<br />".l("underchildrenages").": ".$item["childrenunder2"];
			                            }
		        						
		        					}else{
		        						$title = $item["startPlaceName"] . " - " . $item["endPlaceName"];

		        						$title .= "<br />".l("adults")." ".$item["guests"];

		        						if($item["children"]!=0){
			    							$title .= "<br />".l("childrenages").": ".$item["children"];
			    						}

			                            if($item["childrenunder"]!=0){
			                                $title .= "<br />".l("underchildrenages").": ".$item["childrenunder"]."<br />";
			                            }
		        					}
		        					$price = $item['totalprice'];

		        					$fromdate = $item["startdate"];
	        						$todate = $item["timetrans"];
		        					
		        				}


		        				if($item["type"]=="ongoing"){
		        					$fromdate = $item["startdate"];
	        						$title .= "<br />".l("adults").": ".$item["guests"];
	        						if($item["children"]!=0){
		    							$title .= "<br />".l("childrenages").": ".$item["children"];
		    						}

		                            if($item["childrenunder"]!=0){
		                                $title .= "<br />".l("underchildrenages").": ".$item["childrenunder"]."<br />";
		                            }
	        						$price = $item['totalprice'];
	        					}
							?>
				    			<div class="Item HideForMobile" id="r<?=$item['id']?>" data-price="<?=(float)$price?>">
				    				<div class="Image DisplayInline"><img src="<?=$image1?>"/></div>
				    				<div class="Title DisplayInline">
				    					<?=$title?>
				    					<?php 
		                                if(
		                                    !empty($item["hotels"]) || 
		                                    !empty($item["cuisune"]) || 
		                                    !empty($item["guide"]) 
		                                ){
		                                ?>
		                                <div class="g-add-services">
		                                    <?php if(!empty($item["hotels"])): ?>
		                                    <div class="g-add-service-hotel"></div>
		                                    <?php endif; ?>
		                                    
		                                    <?php if(!empty($item["cuisune"])): ?>
		                                    <div class="g-add-service-cuisune"></div>
		                                    <?php endif; ?>
		                                    
		                                    <?php if(!empty($item["guide"])): ?>
		                                    <div class="g-add-service-guide"></div>
		                                    <?php endif; ?>
		                                </div>
		                                <?php 
		                                }
		                                ?>		
				    				</div>
				    				<div class="Price DisplayInline">
				    					<span><?=$fromdate?></span><br>
				    					<?php if($todate) : ?><span><?=$todate?></span><br><?php endif; ?><br>
				    					<span data-gelprice="<?=round($price)?>"><?=round($price / $cur_exchange)?><?=$cur?></span><br>
				    				</div>
				    				<div class="Date DisplayInline">
				    					

				    					<button class="pickupButton g-pickup-button" 
		                                data-modaltitle="<?=l("pickupmodaltitle")?>" 
		                                data-pick1="<?=l("pickupaddress1")?>" 
		                                data-pick2="<?=l("pickupaddress2")?>" 
		                                data-cartid="<?=$item['id']?>" 
		                                data-doubleway="<?=($item['startPlaceName2'] && $item['endPlaceName2']) ? "true" : "false"?>" 
		                                data-pickplacevalue1="<?=$item["wherepickup"]?>" 
		                                data-pickplacevalue2="<?=$item["wherepickup2"]?>" 
		                            style="width:200px;"><i class="fa fa-map-marker"></i> <span><?=l("pickupmodaltitle")?></span></button>

				    				</div>
				    				<div class="Button DisplayInline">
				    					<button class="DeleteButton deleteCartItem" data-id="<?=$item['id']?>"><i class="fa fa-trash"></i><?=l("delete")?></button>
				    				</div>			    				
				    			</div>

				    			<div class="g-mob-my-cart ShowForMobile">
				    				<table>
				    					<tr>
				    						<td>
				    							<div class="Image DisplayInline" style="margin: 0 20px;"><img src="<?=$image1?>" width="100" /></div>
				    						</td>
				    						<td>
				    							<div class="Title DisplayInline"><?=$title?></div>
				    							<div style="clear:both; width: 100%;"></div>
				    							<div class="Price DisplayInline">
				    								<span data-gelprice="<?=round($price)?>"><?=round($price / $cur_exchange)?><?=$cur?></span></div>
				    							<div style="clear:both; width: 100%;"></div>
				    							<div class="Date DisplayInline"><?=$fromdate?><div></div><?=$todate?></div>
				    							<div style="clear:both; width: 100%;"></div>
				    							<div class="Button DisplayInline">
							    					<button class="DeleteButton deleteCartItem" data-id="<?=$item['id']?>"><i class="fa fa-trash"></i><?=l("delete")?></button>
							    				</div>	
				    						</td>

				    					</tr>
				    				</table>
				    			</div>
			    			<?php 
			    			$tprice += round($price / $cur_exchange);
			    			endforeach; ?>

			    			<?php if($tprice>0){ ?>
			    				<button class="GreenCircleButton_4" style="margin: 20px;" onclick="location.href='/<?=l()?>/cart?buy=true'"><?=l("buy")?></button>
			    			<?php }else{ ?>
			    				<button class="GreenCircleButton_4" style="margin: 20px; opacity: 0.5"><?=l("buy")?></button>
			    			<?php } ?>

			    		</div>
			    	<!-- END TOURS DIV -->
			    </div>
			    
			    <div id="myorders" class="tab-pane fade">
			    	<!-- START TOURS DIV -->
			    		<div class="ProfileToursDiv" id="g-my-orders">
							<?php 
							foreach(g_cart("payed", "LIMIT 0,5") as $item): 
								$doubleWay = "";
	        					$guests = "";
	        					$fromdate = "";
	        					$todate = "";
	        					if(!empty($item['tourplaces'])){
		        					$sql = "SELECT `title` FROM `catalogs` WHERE `id` IN(".$item['startplacex'].",".$item['tourplaces'].") AND `menuid`=36 AND `deleted`=0 AND `language`='".l()."' ORDER BY FIELD(`id`, ".$item['startplacex'].",".$item['tourplaces'].")"; 
		        					$fetch = db_fetch_all($sql);
		        					$places = array();
		        					foreach ($fetch as $v) {
		        						$places[] = $v['title'];
		        					}

		        					$item['title'] = implode("-><br />", $places);
		        					$item['image1'] = "/_website/img/plan.png";
		        					$price = $item['totalprice'];

		        					$fromdate = $item["startdate"];
	        						$todate = $item["startdate2"];
		        				}
		        				$image1 = $item['image1'];
		        				$title = $item['title'];

		        				if($item["type"]=="plantrip"){
		        					$title .= "<br />".l("adults").": ".$item["guests"];

		        					if($item["children"]!=0){
			    						$title .= "<br />".l("childrenages").": ".$item["children"];
			    					}

			                        if($item["childrenunder"]!=0){
			                            $title .= "<br />".l("underchildrenages").": ".$item["childrenunder"];
			                        }

		        				}


		        				if($item["type"]=="transport"){
		        					$image1 = "_website/img/transport.png";		        					
		        					if($item['startPlaceName2'] && $item['endPlaceName2']){
		        						$title = $item["startPlaceName"] . " - " . $item["endPlaceName"];
		        						$title .= "<br />".l("price").": ".$item["roud1_price"];		        						
		        						$title .= "<br />".l("adults").": ".$item["guests"];

		        						if($item["children"]!=0){
			    							$title .= "<br />".l("childrenages").": ".$item["children"];
			    						}

			                            if($item["childrenunder"]!=0){
			                                $title .= "<br />".l("underchildrenages").": ".$item["childrenunder"];
			                            }


		        						$title .= "<br />".$item["startPlaceName2"] . " -> " . $item["endPlaceName2"];
		        						$title .= "<br />".l("price").": ".$item["roud2_price"];
		        						$title .= "<br />".l("adults").": ".$item["guests2"];

		        						if($item["children2"]!=0){
			    							$title .= "<br />".l("childrenages").": ".$item["children2"];
			    						}
			    						if($item["childrenunder2"]!=0){
			                                $title .= "<br />".l("underchildrenages").": ".$item["childrenunder2"];
			                            }
		        						
		        					}else{
		        						$title = $item["startPlaceName"] . " -> " . $item["endPlaceName"];

		        						$title .= "<br />".l("adults")." ".$item["guests"];

		        						if($item["children"]!=0){
			    							$title .= "<br />".l("childrenages").": ".$item["children"];
			    						}

			                            if($item["childrenunder"]!=0){
			                                $title .= "<br />".l("underchildrenages").": ".$item["childrenunder"]."<br />";
			                            }
		        					}
		        					$price = $item['totalprice'];

		        					$fromdate = $item["startdate"];
	        						$todate = $item["timetrans"];
		        					
		        				}


		        				if($item["type"]=="ongoing"){
	        						$title .= "<br />".l("adults").": ".$item["guests"];
	        						if($item["children"]!=0){
		    							$title .= "<br />".l("childrenages").": ".$item["children"];
		    						}

		                            if($item["childrenunder"]!=0){
		                                $title .= "<br />".l("underchildrenages").": ".$item["childrenunder"]."<br />";
		                            }
	        						$price = $item['totalprice'];
	        						$fromdate = $item["startdate"];
	        					}
							?>
				    			<div class="Item HideForMobile" id="r<?=$item['id']?>" data-price="<?=(float)$price?>">
				    				<div class="Image DisplayInline"><img src="<?=$image1?>"/></div>
				    				<div class="Title DisplayInline">
				    					<?=$title?>
				    					<?php 
		                                if(
		                                    !empty($item["hotels"]) || 
		                                    !empty($item["cuisune"]) || 
		                                    !empty($item["guide"]) 
		                                ){
		                                ?>
		                                <div class="g-add-services">
		                                    <?php if(!empty($item["hotels"])): ?>
		                                    <div class="g-add-service-hotel"></div>
		                                    <?php endif; ?>
		                                    
		                                    <?php if(!empty($item["cuisune"])): ?>
		                                    <div class="g-add-service-cuisune"></div>
		                                    <?php endif; ?>
		                                    
		                                    <?php if(!empty($item["guide"])): ?>
		                                    <div class="g-add-service-guide"></div>
		                                    <?php endif; ?>
		                                </div>
		                                <?php 
		                                }
		                                ?>		
				    				</div>
				    				<div class="Price DisplayInline">
				    					<span data-gelprice="<?=round($price)?>"><?=round($price / $cur_exchange)?><?=$cur?></span>
				    				</div>
				    				<div class="Date DisplayInline"><?=$fromdate?><div></div><?=$todate?></div>
				    				<div class="Button DisplayInline">
				    					<?php 
				    					$attachment = "#";
				    					if(isset($item["attachment"]) && !empty($item["attachment"])){
				    						$attachment = str_replace("/home4/tripplanner/public_html/", "/", $item["attachment"]);
				    					}
				    					?>
				    					<a href="<?=$attachment?>" target="_blank" style="color: #12693b;" class="DejaVuSans"><?=($item["cStatus"]=="payed") ? l("payed") : l("invoiceunpayed")?></a>
				    				</div>			    				
				    			</div>

				    			<div class="ShowForMobile" style="width: 100%;">
				    				<table>
				    					<tr>
				    						<td>
				    							<div class="Image DisplayInline" style="margin:0 20px;"><img src="<?=$image1?>" width="100"/></div>
				    						</td>
				    						<td>
				    							<div class="Title DisplayInline"><?=$title?></div>
				    							<div style="clear: both; width: 100%;"></div>
				    							<div class="Price DisplayInline">
				    								<span data-gelprice="<?=round($price)?>"><?=round($price / $cur_exchange)?><?=$cur?></span></div>
				    							<div style="clear: both; width: 100%;"></div>
				    							<div class="Date DisplayInline"><?=$fromdate?><div></div><?=$todate?></div>
				    							<div style="clear: both; width: 100%;"></div>
				    							<div class="Button DisplayInline">
							    					<?php 
							    					$attachment = "#";
							    					if(isset($item["attachment"]) && !empty($item["attachment"])){
							    						$attachment = str_replace("/home4/tripplanner/public_html/", "/", $item["attachment"]);
							    					}
							    					?>
							    					<a href="<?=$attachment?>" target="_blank" style="color: #12693b;" class="DejaVuSans"><?=($item["cStatus"]=="payed") ? l("payed") : l("invoiceunpayed")?></a>
							    				</div>
				    						</td>
				    					</tr>
				    				</table>
				    				<hr style="width: 100%; margin-bottom: 0px;">
				    			</div>
			    			<?php endforeach; ?>
			    			<div style="clear: both"></div>
			    			<div id="loadedcontent"></div>
			    		</div>
			    	<!-- END TOURS DIV -->
			    	<a href="javascript:void(0)" class="GreenCircleButton_4 g-orders-load-more" data-loaded="5"><?=l("loadmore")?></a>
			    </div>

			    <div id="EditProFileLink" class="tab-pane fade">
			    	<!-- START PROFILE DIV -->		    		
					<div class="ProfileForm">
						<div class="form-group col-sm-12 text-center">
							<div class="ProfileImageEdit">

								<div class="image" style="background: url('<?=(isset($_SESSION["trip_user_info"]["picture"]) && !empty($_SESSION["trip_user_info"]["picture"])) ? $_SESSION["trip_user_info"]["picture"] : '_website/img/user_bg.png'?>') no-repeat; background-position: center; width: 100%; height: 100%; background-size: cover; background-color:#12693b;"></div>
								
									<?php 
									if(empty($_SESSION["trip_user_info"]["picture"])){
									?>
										<div class="UploadButton">
										<?=l('upload')?>
										<form action="/<?=l()?>/profile/?uploadphoto=true#EditProFileLink" method="post" id="profile-photo-form" enctype="multipart/form-data">
										<input type="file" class="profile-photo" name="profile-photo" value="" accept="image/*" data-errorImage="<?=l("imageformaterror")?>" /> 
										</form>
										</div>
									<?php 
									}else{
									?>
										<div class="UploadButton" style="background: transparent; height: 100%;">
											<a href="javascript:void(0)" class="removeProfilePhoto">x</a>
										</div>
									<?php
									}
									?>
									

								
								
							</div>				
						</div>
						<div class="form-group col-sm-6">
							<div class="MaterialForm profile-username-box">
								<input type="text" class="profile-username" name="profile-username" value="<?=$_SESSION["trip_user_info"]["username"]?>" readonly="readonly" />
								<span class="highlight"></span>
								<span class="bar"></span>
								<label><?=l("username")?></label> 
								<div class="ErrorText gErrorText"></div>
							</div>					
						</div>
						<div class="form-group col-sm-6">
							<div class="MaterialForm profile-first-name-box">
								<input type="text" class="profile-first-name" name="profile-first-name" value="<?=$_SESSION["trip_user_info"]["firstname"]?>">
								<span class="highlight"></span>
								<span class="bar"></span>
								<label><?=l("firstname")?></label>
								<div class="ErrorText gErrorText"></div>
							</div>					
						</div>
						<div class="form-group col-sm-6">
							<div class="MaterialForm profile-last-name-box">
								<input type="text" class="profile-last-name" name="profile-last-name" value="<?=$_SESSION["trip_user_info"]["lastname"]?>">
								<span class="highlight"></span>
								<span class="bar"></span>
								<label><?=l("lastname")?></label>
								<div class="ErrorText gErrorText"></div>
							</div>					
						</div>
						<div class="form-group col-sm-6">
							<div class="MaterialForm profile-id-number-box">
								<input type="text" class="profile-id-number" name="profile-id-number"  value="<?=$_SESSION["trip_user_info"]["pn"]?>">
								<span class="highlight"></span>
								<span class="bar"></span>
								<label><?=l("idnumber")?></label>
								<div class="ErrorText gErrorText"></div>
							</div>					
						</div>
						<div class="form-group col-sm-6">
							<div class="MaterialForm profile-birthday-box">
								<input type="text" value="<?=$_SESSION["trip_user_info"]["birthdate"]?>" class="DatePicker profile-birthday" name="profile-birthday" readonly="readonly" /> 
								<span class="highlight"></span>
								<span class="bar"></span>
								<label><?=l("birthdaydate")?></label>
								<i class="fa fa-calendar"></i>
								<div class="ErrorText gErrorText"></div>
							</div>					
						</div>
						<div class="form-group col-sm-6">
							<div class="MaterialForm profile-mobile-box">
								<input type="text" class="profile-mobile" style="width:100%; padding: 15px 10px 11px 0px" name="profile-mobile" value="<?=$_SESSION["trip_user_info"]["mobile"]?>">
								<span class="highlight"></span>
								<span class="bar"></span>
								<label><?=l("mobile")?></label>
								<div class="ErrorText gErrorText"></div>
							</div>					
						</div>
						<div class="form-group col-sm-6">
							<div class="MaterialForm profile-email-box">
								<input type="text" class="profile-email" name="profile-email" value="<?=$_SESSION["trip_user_info"]["email"]?>">
								<span class="highlight"></span>
								<span class="bar"></span>
								<label><?=l("email")?></label>
								<div class="ErrorText gErrorText"></div>
							</div>					
						</div>

						
						<div class="form-group col-sm-12">
							<div class="MaterialForm">
								 <button class="GreenCircleButton_4 profile-edit-button"><?=l("update")?></button>
							</div>					
						</div>
					</div>
			    	<!-- END PROFILE DIV -->
			    </div>


			    <div id="EditSecurity" class="tab-pane fade">
			    	<div class="ProfileForm">
			    		<div class="form-group col-sm-12 text-center" style="margin-top: 40px;">
			    			<div class="MaterialForm profile-currentpassword-box">
								<input type="password" class="profile-currentpassword" name="profile-currentpassword" value="" />
								<span class="highlight"></span>
								<span class="bar"></span>
								<label><?=l("currentpasswordprofile")?></label>
								<div class="ErrorText gErrorText"></div>
							</div>
						</div>

						<div class="form-group col-sm-12 text-center">
							<div class="MaterialForm profile-newpassword-box">
								<input type="password" class="profile-newpassword" name="profile-newpassword" value="" />
								<span class="highlight"></span>
								<span class="bar"></span>
								<label><?=l("newpassword")?></label>
								<div class="ErrorText gErrorText"></div>
							</div>
						</div>

						<div class="form-group col-sm-12 text-center">
							<div class="MaterialForm profile-comfirmpassword-box">
								<input type="password" class="profile-comfirmpassword" name="profile-comfirmpassword" value="" />
								<span class="highlight"></span>
								<span class="bar"></span>
								<label><?=l("passwordconfirm")?></label>
								<div class="ErrorText gErrorText"></div>
							</div>
			    		</div>

			    		<div class="form-group col-sm-12" style="margin-bottom: 0px;">
							<div class="MaterialForm">
								 <button class="GreenCircleButton_4 profile-edit-password-button"><?=l("update")?></button>
							</div>					
						</div>

			    	</div>
			    </div>


			</div>
		</div>

		
	</div>
</div>

<script type="text/javascript">
	$(function(){
  		var hash = window.location.hash;
  		hash && $('ul.ProfileSidebar .tabLink[href="' + hash + '"]').tab('show');

  		$("#MyProfileMenuSelect select").val( $("#MyProfileMenuSelect select option[data-hr='"+hash+"']").val() );
  		
  		$('.ProfileSidebar .tabLink').click(function (e) {
    		$(this).tab('show');
    		window.location.hash = this.hash;
  		});
	});
</script>