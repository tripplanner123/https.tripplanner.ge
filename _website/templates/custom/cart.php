<?php defined('DIR') OR exit; ?>
<!-- pickup Modal start -->
<div id="g-pickplace-modal" class="modal fade MessagesPopup" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="CloseButton" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
                <div class="Title" style="font-size: 21px; color: #27774d; font-weight: bold; margin-bottom: 10px;"><?=l("pickupmodaltitle")?></div>
                <div class="Text">
                    <form action="?" method="post" id="pickupplaceform">
                        <input type="hidden" name="CSRF_token" value="<?=@$_SESSION["CSRF_token"]?>" />
                        <div class="resultPickupsave"></div>
                        <div class="MaterialForm" style="margin-bottom: 20px;">
                            <input type="text" class="form-control" id="pick1" name="placeform" value="" placeholder="<?=l("address")?>" />
                        </div>
                        <div class="MaterialForm">
                            <input type="text" class="form-control" id="pick2" name="placeform" value="" placeholder="<?=l("address")?>" />
                        </div>
                        

                        <button type="button" class="button button--small button--yellow w-100 text-uppercase savePickUp" style="margin: 15px 0px;"><?=l("save")?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- pickup Modal end -->



<div class="CartPageDiv">
	<div class="CardInsidePage"> 
		<div class="container">
			<h3 class="PageTitle">
				<label><?php echo $title ?></label> <span class="BigSpan"><?php echo $title ?></span>
			</h3> 
			
			<div class="CartPageItems">
				<div class="ItemTop">
					<div class="col-sm-2"></div>
					<div class="col-sm-2 text-center">
						<div class="Title22"><?=l("tours")?></div>
					</div>
                    <div class="col-sm-2">
                        <div class="Title22"><?=l("date")?></div>
                    </div>
					<div class="col-sm-2 text-center">
						<div class="Title22"><?=l("price")?></div>
					</div>
                    <div class="col-sm-2 text-center"></div>
					<div class="col-sm-2 text-center"></div>
				</div>
				<div class="Itemssss">
					<?php 
					$order_id='';
                    $cur = "<i>A</i>"; 
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

					$totalPriceOut = 0;
	        		foreach(g_cart() as $item):
				
	        		$doubleWay = "";
    				$guests = "";
    				$totalPriceOut += $item['totalprice'];
    				if(!empty($item['tourplaces'])){
                       $sql = "SELECT `title` FROM `catalogs` WHERE `id` IN(".$item['startplacex'].",".$item['tourplaces'].") AND `menuid`=36 AND `deleted`=0 AND `language`='".l()."' ORDER BY FIELD(`id`, ".$item['startplacex'].",".$item['tourplaces'].")"; 
    					$fetch = db_fetch_all($sql);
    					$places = array();
    					foreach ($fetch as $v) {
    						$places[] = $v['title'];
    					}

    					$item['title'] = implode("-><br />", $places);
    					$item['image1'] = "/_website/img/plan.png";
    				}

    				$image1 = $item['image1'];
    				$title = $item['title'];
    				if($item["type"]=="transport"){
    					$image1 = "/_website/img/transport.png";    					
    					
    					if($item['startPlaceName2'] && $item['endPlaceName2']){
    						$title = $item["startPlaceName"] . " - " . $item["endPlaceName"];
    						
    						$guests = "<br />".l("price").": ".$item["roud1_price"];
                            $guests .= "<br />".l("adults").": ".$item["guests"];
    						if($item["children"]!=0){
    							$guests .= "<br />".l("childrenages").": ".$item["children"];
    						}

                            if($item["childrenunder"]!=0){
                                $guests .= "<br />".l("underchildrenages").": ".$item["childrenunder"];
                            }
    						$guests .= "<br />".$item["transport_name1"]."<br />";
    						$guests .= $item["startPlaceName2"] . " - " . $item["endPlaceName2"];
    						$guests .= "<br />".l("price").": ".$item["roud2_price"];
                            $guests .= "<br />".l("adults").": ".$item["guests2"];
    						if($item["children2"]!=0){
    							$guests .= "<br />".l("childrenages").": ".$item["children2"];
    						}
    						if($item["childrenunder2"]!=0){
                                $guests .= "<br />".l("underchildrenages").": ".$item["childrenunder2"];
                            }
    						$guests .= "<br />".$item["transport_name2"]."<br />";
    						
    					}else{
    						$title = $item["startPlaceName"] . " - " . $item["endPlaceName"];
    						$guests = "<br />".l("adults").": ".$item["guests"];
    						if($item["children"]!=0){
    							$guests .= "<br />".l("childrenages").": ".$item["children"];
    						}
                            if($item["childrenunder"]!=0){
                                $guests .= "<br />".l("underchildrenages").": ".$item["childrenunder"];
                            }
    					}    					
    				}
    				if($item["type"]=="ongoing"){
    					$guests = "<br />".l("adults").": ".$item["guests"];
    					if($item["children"]!=0){
    						$guests .= "<br />".l("childrenages").": ".$item["children"];
    					}

                        if($item["childrenunder"]!=0){
                            $guests .= "<br />".l("underchildrenages").": ".$item["childrenunder"];
                        }
    				}

    				if($item["type"]=="plantrip"){
    					$guests = "<br />".l("adults").": ".$item["guests"];
    					if($item["children"]!=0){
    						$guests .= "<br />".l("childrenages").": ".$item["children"];
    					}

                        if($item["childrenunder"]!=0){
                            $guests .= "<br />".l("underchildrenages").": ".$item["childrenunder"];
                        }
    				} 
					?>
					<div class="Item HideForMobile" id="r<?=$item['id']?>" data-price="<?=round($item['totalprice']/$cur_exchange)?>"> <!--  -->
						
                        <div class="col-sm-2">
							<div class="Image" style="background:url('<?=$image1?>');"></div>
						</div>
						<div class="col-sm-2 text-center">
                            <div class="Title" data-title="tour">
                                <?=$title.$doubleWay.$guests?>
                                <?php 
                                if(
                                    !empty($item["hotels"]) || 
                                    !empty($item["cuisune"]) || 
                                    !empty($item["guide"]) || 
                                    (isset($item["insurance"]) && $item["insurance"]==1)
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

                                    <?php if(!empty($item["insurance"])): ?>
                                    <div class="g-add-service-insurance"></div>
                                    <?php endif; ?>
                                </div>
                                <?php 
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-2 text-center">
							<div class="Title">
                                <?=$item['startdate']?>
                                <?php 
                                if(!empty($item['startdate2']) && $item["type"]=="transport"){
                                    echo "<br />".$item['startdate2'];
                                }
                                ?>
                            </div>
						</div>
						<div class="col-sm-2 text-center">
							<div class="Price" data-title="price">
                                <span class="cartitemprice" data-gelprice="<?=round($item['totalprice'])?>">
                                    <?=round($item['totalprice']/$cur_exchange)?><?=$cur?>
                                </span>
                            </div>
						</div>
                        <div class="col-sm-2 text-center">
                            <button class="pickupButton g-pickup-button" 
                                data-modaltitle="<?=l("pickupmodaltitle")?>" 
                                data-pick1="<?=l("pickupaddress1")?>" 
                                data-pick2="<?=l("pickupaddress2")?>" 
                                data-cartid="<?=$item['id']?>" 
                                data-doubleway="<?=($item['startPlaceName2'] && $item['endPlaceName2']) ? "true" : "false"?>" 
                                data-pickplacevalue1="<?=$item["wherepickup"]?>" 
                                data-pickplacevalue2="<?=$item["wherepickup2"]?>" 
                            style="width:220px;"><i class="fa fa-map-marker"></i> <span><?=l("pickupmodaltitle")?></span></button>
                        </div>

						<div class="col-sm-2 text-center">
                            <button class="DeleteButton askAgaindelete" data-id="<?=$item['id']?>"><i class="fa fa-trash"></i> <span><?=l("delete")?></span></button>
						</div>



					</div>
                    <div class="g-mob-item ShowForMobile">
                        <table>
                            <tr>
                                <td>
                                    <div class="g-mob-image" style="background:url('<?=$image1?>');"></div>
                                </td>
                                <td>
                                    <div class="Title">
                                        <?=$item['startdate']?>
                                        <?php 
                                        if(!empty($item['startdate2'])){
                                            echo "<br />".$item['startdate2'];
                                        }
                                        ?>
                                    </div>
                                    <div class="Title" data-title="tour">
                                        <?=$title.$doubleWay.$guests?>
                                        <div class="g-add-services">
                                            <!-- <div class="g-add-service-hotel"></div>
                                            <div class="g-add-service-cuisune"></div>
                                            <div class="g-add-service-guide"></div> -->

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
                                    </div>

                                    <button class="DeleteButton askAgaindelete" data-id="<?=$item['id']?>"><i class="fa fa-trash"></i> <span><?=l("delete")?></span></button>
                                </td>
                            </tr>
                        </table>
                    </div>
					<?php 
					// $order_id=$item['uniq'];
					endforeach; ?>
				</div>
			</div>
			

		

        	<div class="TotalPriceDiv pull-right">
        		<div class="col-sm-8">
                    <div class="Title">
                        <?=l("totalprice")?>
                        <!-- <div class="g-change-currency-v2">
                          <span class="active" data-cur="gel"><i>A</i></span>
                          <span data-cur="usd">$</span>
                          <span data-cur="eur">&euro;</span>
                        </div> -->
                    </div>
                </div>
        		<div class="col-sm-4 text-right">
                    <div class="SumCount">
                        
                        <span class="gelprice" data-gelprice="<?=(int)$totalPriceOut?>" style="width: auto;"><?=round($totalPriceOut / $cur_exchange)?><?=$cur?></span> 
                        <span class="hoverprice" style="width: auto;"></span>
                    </div>

                   
                  
                  
                  <script>
                    $(document).ready(function() {
                      $ExchangeDropDown = $('.ExchangeDropDown');
                      $ExchangeDropDown.find("li").click(function() {
                        $caret = '<span class="caret"></span>';
                        $val = $(this).html();
                        $(".ExcButton").html($val + $caret)
                      });
                    });
                  </script>
                </div>
                <!-- <div class="col-sm-8"><div class="FreeIncurance">+ Free Insurance</div></div> -->
                <?php 
                if((int)$totalPriceOut > 0){
                    $order_id = md5("jhjnjTRpo9JJ".time()); 
                    if(isset($_SESSION["trip_user"])){
                    ?>	


                    <div class="col-sm-12 text-center">
                        <div class="form-group col-sm-12 TermsAndConditions" style="margin: 20px 0; margin-left: -15px;"> 
                            <input class="TripCheckbox terms-conditions-buy" id="1" name="terms-conditions" type="checkbox" value="1">
                            <label class="pull-left Text" for="1"><a href="/en/buy_rules" target="_blank"><?=menu_title(215)?></a></label>
                        </div>
            		</div>
                    <div class="col-sm-4 pull-right text-center">
                        <a href="javascript:void(0)" class="GreenCircleButton_4 g-buyButtonx" style="opacity: 0.8;"><?=l("buy")?></a>
                    </div>
                    <div class="CartBuyDiv" style="display: none">
                        <div class="Title"><?=ucfirst(strtolower(l("selectpaymentmethod")))?></div>
                        <div class="PaymentMethod">
                            <div class="Item" onclick="location.href='https://3dacq.georgiancard.ge/payment/start.wsm?lang=KA&merch_id=C0FD41491D5576D077F57BD605B04858&back_url_s=<?=urlencode('https://tripplanner.ge/'.l().'/profile/?order_id='.$order_id.'#myorders')?>&back_url_f=<?=urlencode('https://tripplanner.ge/'.l().'/cart')?>&preauth=N&&o.website=tripplanner&o.order_id=<?=$order_id?>&o.userid=<?=(isset($_SESSION["trip_user"])) ? $_SESSION["trip_user"] : ''?>&o.lang=<?=l()?>'">
                                <div class="check"><div><i class="fa fa-check"></i></div></div>
                                <div class="Icon Icon_1"></div>
                                <div class="Name"><?=ucfirst(strtolower(l("paywithcard")))?></div>
                            </div>
                            <div class="Item invoicePay">
                                <div class="check"><div><i class="fa fa-check"></i></div></div>
                                <div class="Icon Icon_2"></div>
                                <div class="Name"><?=ucfirst(strtolower(l("invoicepayment")))?></div>
                            </div>
                        </div>    
                    </div>
                     <?php 
    				}else{
                        ?>
                        <div class="col-sm-4 pull-right text-center"><a href="/<?=l()?>/registration" class="GreenCircleButton_4"><?=l("buy")?></a></div>
                        <?php
                    }
                }else{
                    echo "<div class=\"col-sm-4 pull-right text-center\"><a href=\"javascript:void(0)\" class=\"GreenCircleButton_4\" style=\"opacity: 0.5\">".l("buy")."</a></div>";
                }
                ?>


                
		</div>
	</div>
</div>

<?php if(isset($_GET['buy']) && $_GET["buy"]=="true"): ?>
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){
            $(".GreenCircleButton_4").click();
            $("html, body").animate({ scrollTop: $(".CartBuyDiv").offset().top }, "slow");
        }, 1500);            
    });
</script>
<?php endif; ?>