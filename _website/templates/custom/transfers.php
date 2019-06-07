<?php defined('DIR') OR exit; ?>

<div class="InsidePagesHeader Big"> 
	<div class="Item" style="background:url('<?php echo $image1 ?>');"></div> 
</div>

<div class="TripListPageDiv">
	<div class="TripListInsidePage">   
		<div class="container"> 
		 	<div class="row row0">
		 		<div class="col s12">
		 			<div class="Breadcrumb">   
                    	<?php echo location(); ?>
					</div>
		 		</div>
		 	</div>

		 	<div class="row">
		 		<div class="col-sm-9 ColSm9">			 		
		 			
		 		<div class="TripTransfersDiv">
		 			<?php 
					$g_getlist = g_transfer_start_places(); 
					$g_transports = g_transports();
					$cur = "<i>A</i>"; 
					$cur_exchange = 1;


					if(!isset($_SESSION["CSRF_token"])){
						$_SESSION["CSRF_token"] = md5(sha1(time()));
					}
					?>
					<form action="" method="post">
						<input type="hidden" name="CSRF_token" value="<?=$_SESSION["CSRF_token"]?>" />
						<input type="hidden" name="km" id="km" value="0" />
						<input type="hidden" name="km" id="double-km" value="0" />
						<input type="hidden" name="cur" id="cur" value="<?=htmlentities($cur)?>" />
						<input type="hidden" name="cur_exchange" id="cur_exchange" value="<?=htmlentities($cur_exchange)?>" />
					</form>
											
					<div class="FiltersDiv ShowForMobile">
						<div class="row"> 
							<div class="col-sm-4">
								<div class="HtmlMultiSelect">
									<div class="TItle"></div>
									<select id="mobile-startingPlace">
										<option value="" selected disabled><?=l("choosestartingplace")?></option>
										<?php foreach ($g_getlist as $item): ?>
										<option value="<?=$item['id']?>" data-map="<?=str_replace(":",", ",$item['map_coordinates'])?>" data-plus="<?=$item['price_plus']?>"><?=g_cut($item['title'], 45)?></option>	
										<?php endforeach; ?>								
									</select>
								</div>
							</div>
							
							<div class="col-sm-4">
								<div class="HtmlMultiSelect">
									<div class="TItle"></div>
									<select id="mobile-endPlace">
										<option value="" selected disabled><?=l("chooseendplace")?></option>
										<?php foreach ($g_getlist as $item): ?>
										<option value="<?=$item['id']?>" data-map="<?=str_replace(":",", ",$item['map_coordinates'])?>" data-plus="<?=$item['price_plus']?>"><?=g_cut($item['title'], 45)?></option>	
										<?php endforeach; ?>									
									</select>
								</div>
							</div>	 
							
							<div class="MobileDateAndGuests">
								<div class="col-sm-666">
									<div class="HtmlMultiSelect HtmlMultiSelect222">
										<div class="Title"><?=l("startdate")?></div>
										<div class="MobileInputs">
											<div class="input-group PositionRelative">
												<span class="DateControl1" style="width: 80% !important;">
													 <input type="text" class="form-control DatePicker2" value="<?=date("Y-m-d", time()+172800)?>" id="mobile-startdate" />
												</span>
												<span class="input-group-addon addon2" onclick="$('#mobile-startdate').focus()"><i class="fa fa-calendar"></i></span>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-666">
									<div class="HtmlMultiSelect HtmlMultiSelect222">
										<div class="Title"><?=l("time")?></div>
										<div class="MobileInputs">
											<div class="input-group PositionRelative">
												<span class="DateControl3">
													 <input type="time" class="form-control" value="<?=date("H:i")?>" id="mobile-time" />
												</span>
												<span class="input-group-addon addon3" onclick="$('#mobile-time').focus()"><i class="fa fa-clock-o"></i></span>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="MobileDateAndGuests">
								<div class="col-sm-4">
									<div class="HtmlMultiSelect FixedHeight">
										<div class="Title"><?=l("adults")?></div>
										<select id="mobile-guests"> 
											<?php for($x=1;$x<=30; $x++): ?>
											<option value="<?=$x?>"><?=$x?></option>			
											<?php endfor; ?>						
										</select>
									</div>
								</div>

								<div class="col-sm-4">
									<div class="HtmlMultiSelect FixedHeight">
										<div class="Title"><?=l("underchildrenages")?></div>
										<select id="mobile-children-under"> 
											<?php for($x=0;$x<=10; $x++): ?>
											<option value="<?=$x?>"><?=$x?></option>			
											<?php endfor; ?>						
										</select>
									</div>
								</div>

								<div class="col-sm-4">
									<div class="HtmlMultiSelect FixedHeight">
										<div class="Title"><?=l("childrenages")?></div>
										<select id="mobile-children"> 
											<?php for($x=0;$x<=10; $x++): ?>
											<option value="<?=$x?>"><?=$x?></option>			
											<?php endfor; ?>						
										</select>
									</div>
								</div>
							</div>	
							
							<div class="col-sm-4">
								<div class="HtmlMultiSelect">
									<div class="TItle"></div>
									<select id="mobile-transpor">
										<option selected disabled><?=l("transport")?></option>
										<?php foreach($g_transports as $tra): ?>
										<?php $selected = ($tra['id']==125) ? 'selected="selected"' : ''; ?>
										<option value="<?=$tra['id']?>" <?=$selected?> data-kiloprice-up="<?=htmlentities($tra['price1'])?>" data-kiloprice-down="<?=htmlentities($tra['price2'])?>" data-kmlimit="<?=$tra["kmlimit"]?>" data-price_50="<?=$tra['price_50']?>" data-price_100="<?=$tra['price_100']?>" data-price_200="<?=$tra['price_200']?>" data-price_200_plus="<?=$tra['price_200_plus']?>"><?=$tra['title']?></option>
										<?php endforeach; ?>					
									</select>
								</div>
							</div>
						</div>	

						<div class="form-group col-sm-12">
						 	<button class="GreenCircleButton_4 TransferButton mobile-doubleway" style="padding:10px 60px 10px 60px !important">&nbsp;&nbsp;<?=l("doubleway")?></button>
						</div>	

						<!-- double way start -->
						<div id="mobile-doublewaybox" style="display: none;">		
						
							<div class="col-sm-4" style="padding: 0">
								<div class="HtmlMultiSelect">
									<div class="TItle"></div>
									<select id="mobile-startingPlace2">
										<option value="" selected disabled><?=l("choosestartingplace")?></option>
										<?php foreach ($g_getlist as $item): ?>
										<option value="<?=$item['id']?>" data-map="<?=str_replace(":",", ",$item['map_coordinates'])?>" data-plus="<?=$item['price_plus']?>"><?=g_cut($item['title'], 45)?></option>	
										<?php endforeach; ?>								
									</select>
								</div>
							</div>
							
							<div class="col-sm-4" style="padding: 0">
								<div class="HtmlMultiSelect">
									<div class="TItle"></div>
									<select id="mobile-endPlace2">
										<option value="" selected disabled><?=l("chooseendplace")?></option>
										<?php foreach ($g_getlist as $item): ?>
										<option value="<?=$item['id']?>" data-map="<?=str_replace(":",", ",$item['map_coordinates'])?>" data-plus="<?=$item['price_plus']?>"><?=g_cut($item['title'], 45)?></option>	
										<?php endforeach; ?>									
									</select>
								</div>
							</div>

							<div class="MobileDateAndGuests" style="margin: 0 -15px;">
								<div class="col-sm-666">
									<div class="HtmlMultiSelect HtmlMultiSelect222">
										<div class="Title"><?=l("startdate")?></div>
										<div class="MobileInputs">
											<div class="input-group PositionRelative">
												<span class="DateControl1" style="width: 80% !important;">
													 <input type="date" class="form-control DatePicker2" value="<?=date("Y-m-d", time()+172800)?>" id="double-mobile-startdate" />
												</span>
												<span class="input-group-addon addon2" onclick="$('#double-mobile-startdate').focus()"><i class="fa fa-calendar"></i></span>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-sm-666">
									<div class="HtmlMultiSelect HtmlMultiSelect222">
										<div class="Title"><?=l("time")?></div>
										<div class="MobileInputs">
											<div class="input-group PositionRelative">
												<span class="DateControl3">
													 <input type="time" class="form-control" value="<?=date("H:i")?>" id="double-mobile-time">
												</span>
												<span class="input-group-addon addon3" onclick="$('#double-mobile-time').focus()"><i class="fa fa-clock-o"></i></span>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="MobileDateAndGuests" style="margin: 0 -15px;">
								<div class="col-sm-4">		 
									<div class="HtmlMultiSelect FixedHeight">
										<div class="Title"><?=l("adults")?></div>
										<select id="double-mobile-guests"> 
											<?php for($x=1;$x<=30; $x++): ?>
											<option value="<?=$x?>"><?=$x?></option>			
											<?php endfor; ?>						
										</select>
									</div>
								</div>

								<div class="col-sm-4">		 
									<div class="HtmlMultiSelect FixedHeight">
										<div class="Title"><?=l("underchildrenages")?></div>
										<select id="double-mobile-child-under"> 
											<?php for($x=0;$x<=10; $x++): ?>
											<option value="<?=$x?>"><?=$x?></option>			
											<?php endfor; ?>						
										</select>
									</div>
								</div>

								<div class="col-sm-4">		 
									<div class="HtmlMultiSelect FixedHeight">
										<div class="Title"><?=l("childrenages")?></div>
										<select id="double-mobile-child"> 
											<?php for($x=0;$x<=10; $x++): ?>
											<option value="<?=$x?>"><?=$x?></option>			
											<?php endfor; ?>						
										</select>
									</div>
								</div>																
							</div>

							<div class="col-sm-4" style="padding: 0">
								<div class="HtmlMultiSelect">
									<div class="TItle"></div>
									<select id="double-mobile-transpor">
										<option selected disabled><?=l("transport")?></option>
										<?php foreach($g_transports as $tra): ?>
										<?php $selected = ($tra['id']==125) ? 'selected="selected"' : ''; ?>
										<option value="<?=$tra['id']?>" <?=$selected?> data-kiloprice-up="<?=htmlentities($tra['price1'])?>" data-kiloprice-down="<?=htmlentities($tra['price2'])?>" data-kmlimit="<?=$tra["kmlimit"]?>" data-price_50="<?=$tra['price_50']?>" data-price_100="<?=$tra['price_100']?>" data-price_200="<?=$tra['price_200']?>" data-price_200_plus="<?=$tra['price_200_plus']?>"><?=$tra['title']?></option>
										<?php endforeach; ?>					
									</select>
								</div>
							</div>
						</div>
						<!-- double way end -->					
					</div>
					
						<div class="FiltersDiv HideForMobile">
					 		<div class="row"> 
				 				<div class="form-group col-sm-6">
						 			<div class="btn-group SearchFilterItem"> 
									    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
									    	<span class="Name1"><?=l("choosestartingplace")?></span>
									    	<label class="Name2 LocationName InpueValue2"></label>
									    </div>
									    <div class="dropdown-menu LocationDropDown LocationDropDown2"> 
								        	<?php 
								        	foreach ($g_getlist as $item):
								        	?>
								        	<div class="Item">
								        		<input class="TripCheckbox" type="checkbox" id="List<?=$item['id']?>" data-id="<?=$item['id']?>" data-map="<?=str_replace(":",", ", $item['map_coordinates'])?>" data-plus="<?=$item['price_plus']?>" value="<?=htmlentities($item['title'])?>">
												<label class="pull-left Text DejaVuSans" for="List<?=$item['id']?>" style="height: 35px; line-height: 100%;" title="<?=htmlentities($item['title'])?>">
													<?=g_cut($item['title'], 35)?>
												</label> 
								        	</div> 
								        	<?php endforeach; ?>
									    </div>
									</div>
						 		</div>

						 		<div class="form-group col-sm-6">
						 			<div class="btn-group SearchFilterItem"> 
									    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
									    	<span class="Name1"><?=l("chooseendplace")?></span>
									    	<label class="Name2 LocationName InpueValue3"></label>
									    </div>
									    <div class="dropdown-menu LocationDropDown LocationDropDown3"> 
								        	<?php 
								        	foreach ($g_getlist as $item):
								        	?>
								        	<div class="Item">
								        		<input class="TripCheckbox" type="checkbox" id="List3<?=$item['id']?>" data-id="<?=$item['id']?>" data-map="<?=str_replace(":",", ", $item['map_coordinates'])?>" data-plus="<?=$item['price_plus']?>" value="<?=htmlentities($item['title'])?>">
												<label class="pull-left Text DejaVuSans" for="List3<?=$item['id']?>" style="height: 35px; line-height: 100%;" title="<?=htmlentities($item['title'])?>">
													<?=g_cut($item['title'], 35)?>
												</label> 
								        	</div> 
								        	<?php endforeach; ?>
									    </div>
									</div>
						 		</div>

						 		<div class="col-sm-12 padding_0">
						 			<div class="form-group col-sm-6">
							 			<div class="btn-group SearchFilterItem"> 
										    <div class="TripTogglebutton">
										    	<span>
										    		<div class="row">
										    			<div class="col-sm-12"><?=l("startdate")?></div> 
										    		</div>
										    	</span>
										    	<div class="input-group PositionRelative"> 
												  <input type="text" class="form-control DatePicker2 startdatetrans" value="<?=date("Y-m-d", time()+172800)?>">
												  <span class="input-group-addon" onclick="$('.startdatetrans').focus()"><i class="fa fa-calendar"></i></span>
												</div>
										    </div>
										</div>
							 		</div>

							 		<div class="form-group col-sm-6">
							 			<div class="btn-group SearchFilterItem"> 
										    <div class="TripTogglebutton">
										    	<span>
										    		<div class="row">
										    			<div class="col-sm-12"><?=l("time")?></div> 
										    		</div>
										    	</span>
										    	<div class="input-group PositionRelative"> 
												  <input type="time" class="form-control timeTrans" value="<?=date("H:i")?>">
												  <span class="input-group-addon" onclick="$('.timeTrans').focus()"><i class="fa fa-clock-o"></i></span>
												</div>
										    </div>
										</div>
							 		</div>
							 		
							 		<div class="form-group col-sm-3">
							 			<div class="btn-group SearchFilterItem"> 
										    <div class="TripTogglebutton">
										    	<span class="Name1"><?=l("adults")?></span>
										    	<div class="input-group PositionRelative"> 
												  <span class="Quantity Quantity2">
												  	<div class="input-group">
												          <span class="input-group-btn">
												              <button type="button" class="btn QuantityButton btn-number"  data-type="minus" data-field="quant[2]">
												                <span class="glyphicon glyphicon-minus"></span>
												              </button>
												          </span>
												          <input type="number" readonly="readonly" name="quant[2]" id="guest-number" class="form-control input-number" value="1" min="1" max="100" pattern="\d*"/>
												          <span class="input-group-btn">
												              <button type="button" class="btn QuantityButton btn-number" data-type="plus" data-field="quant[2]">
												                  <span class="glyphicon glyphicon-plus"></span>
												              </button>
												          </span>

												      </div>
												  </span> 
												</div>
										    </div> 
										</div>
							 		</div>

							 		<div class="form-group col-sm-3">
							 			<div class="btn-group SearchFilterItem"> 
										    <div class="TripTogglebutton">
										    	<span class="Name1"><?=l("underchildrenages")?></span>
										    	<div class="input-group PositionRelative"> 
												  <span class="Quantity Quantity3">
												  	<div class="input-group">
												          <span class="input-group-btn">
												              <button type="button" class="btn QuantityButton btn-number g-no-disabled"  data-type="minus" data-field="nquant[400]">
												                <span class="glyphicon glyphicon-minus"></span>
												              </button>
												          </span>
												          <input type="number" readonly="readonly" name="nquant[400]" id="children-under" class="form-control children-number" value="0" min="0" max="100" pattern="\d*" />
												          <span class="input-group-btn">
												              <button type="button" class="btn QuantityButton btn-number g-no-disabled" data-type="plus" data-field="nquant[400]">
												                  <span class="glyphicon glyphicon-plus"></span>
												              </button>
												          </span>

												      </div>
												  </span> 
												</div>
										    </div> 
										</div>
							 		</div>

							 		<div class="form-group col-sm-3">
							 			<div class="btn-group SearchFilterItem"> 
										    <div class="TripTogglebutton">
										    	<span class="Name1"><?=l("childrenages")?></span>
										    	<div class="input-group PositionRelative"> 
												  <span class="Quantity Quantity3">
												  	<div class="input-group">
												          <span class="input-group-btn">
												              <button type="button" class="btn QuantityButton btn-number g-no-disabled"  data-type="minus" data-field="nquant[3]">
												                <span class="glyphicon glyphicon-minus"></span>
												              </button>
												          </span>
												          <input type="number" readonly="readonly" name="nquant[3]" id="children-number" class="form-control children-number" value="0" min="0" max="100" pattern="\d*" />
												          <span class="input-group-btn">
												              <button type="button" class="btn QuantityButton btn-number g-no-disabled" data-type="plus" data-field="nquant[3]">
												                  <span class="glyphicon glyphicon-plus"></span>
												              </button>
												          </span>

												      </div>
												  </span> 
												</div>
										    </div> 
										</div>
							 		</div>

							 		<div class="form-group col-sm-3">
										<div class="btn-group SearchFilterItem" id="TransporDropDown">  
										    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
										    	<span class="Name1"><?=l("transport")?></span>
										    	<label class="Name2 LocationName TransportValue"><text><?=$g_transports[0]["title"]?></text></label>
										    </div>
										    <div class="dropdown-menu OneListDropDown TransporDropDown"> 
												<?php 
									        	$x=1;
									        	foreach($g_transports as $tra): ?>	
									        	<div class="Item">
													<input class="TripCheckbox" type="checkbox" id="ListTra<?=$tra['id']?>" data-id="<?=$tra['id']?>" data-kiloprice-up="<?=htmlentities($tra['price1'])?>" data-kiloprice-down="<?=htmlentities($tra['price2'])?>" data-kmlimit="<?=$tra["kmlimit"]?>" data-price_50="<?=$tra['price_50']?>" data-price_100="<?=$tra['price_100']?>" data-price_200="<?=$tra['price_200']?>" data-price_200_plus="<?=$tra['price_200_plus']?>" value="<?=htmlentities($tra['title'])?>" <?=($x==1) ? 'checked="checked"' : ''?> />
													<label class="pull-left Text" for="ListTra<?=$tra['id']?>">
														<?=$tra['title']?>
														<div class="IconSmall"><i class="<?=htmlentities($tra['meta_desc'])?>"></i></div>
													</label> 
									        	</div> 	
									        	<?php 
									        	$x=2;
									        	endforeach; ?>						       	
										    </div>
										</div>
							 		</div>
						 		</div>

						 		


						 		<div class="form-group col-sm-12">
						 			<button class="GreenCircleButton_4 TransferButton doubleway">&nbsp;&nbsp;<?=l("doubleway")?></button>
						 		</div>

						 		<!-- Double way start -->
						 		<div id="doubleway" style="display: none;">
						 			<div class="form-group col-sm-6">
							 			<div class="btn-group SearchFilterItem" id="LocationDropDown4"> 
										    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
										    	<span class="Name1"><?=l("choosestartingplace")?></span>
										    	<label class="Name2 LocationName InpueValue4"></label>
										    </div>
										    <div class="dropdown-menu LocationDropDown LocationDropDown4"> 
									        	<?php 
									        	foreach ($g_getlist as $item):
									        	?>
									        	<div class="Item">
									        		<input class="TripCheckbox" type="checkbox" id="List4<?=$item['id']?>" data-id="<?=$item['id']?>" data-map="<?=str_replace(":",", ",$item['map_coordinates'])?>" data-plus="<?=$item['price_plus']?>" value="<?=htmlentities($item['title'])?>">
													<label class="pull-left Text DejaVuSans" for="List4<?=$item['id']?>" style="height: 35px; line-height: 100%;" title="<?=htmlentities($item['title'])?>">
														<?=g_cut($item['title'], 35)?>
													</label> 
									        	</div> 
									        	<?php endforeach; ?>
										    </div>
										</div>
							 		</div>

							 		<div class="form-group col-sm-6">
							 			<div class="btn-group SearchFilterItem" id="LocationDropDown5"> 
										    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
										    	<span class="Name1"><?=l("chooseendplace")?></span>
										    	<label class="Name2 LocationName InpueValue5"></label>
										    </div>
										    <div class="dropdown-menu LocationDropDown LocationDropDown5"> 
									        	<?php 
									        	foreach ($g_getlist as $item):
									        	?>
									        	<div class="Item">
									        		<input class="TripCheckbox" type="checkbox" id="List5<?=$item['id']?>" data-id="<?=$item['id']?>" data-map="<?=str_replace(":",", ",$item['map_coordinates'])?>" data-plus="<?=$item['price_plus']?>" value="<?=htmlentities($item['title'])?>">
													<label class="pull-left Text DejaVuSans" for="List5<?=$item['id']?>" style="height: 35px; line-height: 100%;" title="<?=htmlentities($item['title'])?>">
														<?=g_cut($item['title'], 35)?>
													</label> 
									        	</div> 
									        	<?php endforeach; ?>
										    </div>
										</div>
							 		</div>

						 			<div class="col-sm-12 padding_0">
							 			<div class="form-group col-sm-6">
								 			<div class="btn-group SearchFilterItem"> 
											    <div class="TripTogglebutton">
											    	<span>
											    		<div class="row">
											    			<div class="col-sm-12"><?=l("startdate")?></div> 
											    		</div>
											    	</span>
											    	<div class="input-group PositionRelative"> 
													  <input type="text" class="form-control DatePicker2 double-startdatetrans" value="<?=date("Y-m-d", time()+172800)?>">
													  <span class="input-group-addon" onclick="$('.double-startdatetrans').focus()"><i class="fa fa-calendar"></i></span>
													</div>
											    </div>
											</div>
								 		</div>

								 		<div class="form-group col-sm-6">
								 			<div class="btn-group SearchFilterItem"> 
											    <div class="TripTogglebutton">
											    	<span>
											    		<div class="row">
											    			<div class="col-sm-12"><?=l("time")?></div> 
											    		</div>
											    	</span>
											    	<div class="input-group PositionRelative"> 
													  <input type="time" class="form-control double-timeTrans" value="<?=date("H:i")?>">
													  <span class="input-group-addon" onclick="$('.double-timeTrans').focus()"><i class="fa fa-clock-o"></i></span>
													</div>
											    </div>
											</div>
								 		</div>

								 		<div class="form-group col-sm-3">
								 			<div class="btn-group SearchFilterItem"> 
											    <div class="TripTogglebutton">
											    	<span class="Name1"><?=l("adults")?></span>
											    	<div class="input-group PositionRelative"> 
													  <span class="Quantity Quantity2">
													  	<div class="input-group">
													          <span class="input-group-btn">
													              <button type="button" class="btn QuantityButton double-btn-number"  data-type="minus" data-field="quant[3]">
													                <span class="glyphicon glyphicon-minus"></span>
													              </button>
													          </span>
													          <input type="number" readonly="readonly" name="quant[3]" id="double-guest-number" class="form-control double-input-number" value="1" min="1" max="100" pattern="\d*" />
													          <span class="input-group-btn">
													              <button type="button" class="btn QuantityButton double-btn-number" data-type="plus" data-field="quant[3]">
													                  <span class="glyphicon glyphicon-plus"></span>
													              </button>
													          </span>

													      </div>
													  </span> 
													</div>
											    </div> 
											</div>
								 		</div>

								 		<div class="form-group col-sm-3">
								 			<div class="btn-group SearchFilterItem"> 
											    <div class="TripTogglebutton">
											    	<span class="Name1"><?=l("underchildrenages")?></span>
											    	<div class="input-group PositionRelative"> 
													  <span class="Quantity Quantity2">
													  	<div class="input-group">
													          <span class="input-group-btn">
													              <button type="button" class="btn QuantityButton double-btn-number g-no-disabled"  data-type="minus" data-field="quant[900]">
													                <span class="glyphicon glyphicon-minus"></span>
													              </button>
													          </span>
													          <input type="number" readonly="readonly" name="quant[900]" id="double-children-under-number" class="form-control double-children-under-number" value="0" min="0" max="100" pattern="\d*" />
													          <span class="input-group-btn">
													              <button type="button" class="btn QuantityButton double-btn-number g-no-disabled" data-type="plus" data-field="quant[900]">
													                  <span class="glyphicon glyphicon-plus"></span>
													              </button>
													          </span>

													      </div>
													  </span> 
													</div>
											    </div> 
											</div>
								 		</div>

								 		<div class="form-group col-sm-3">
								 			<div class="btn-group SearchFilterItem"> 
											    <div class="TripTogglebutton">
											    	<span class="Name1"><?=l("childrenages")?></span>
											    	<div class="input-group PositionRelative"> 
													  <span class="Quantity Quantity4">
													  	<div class="input-group">
													          <span class="input-group-btn">
													              <button type="button" class="btn QuantityButton double-btn-number g-no-disabled"  data-type="minus" data-field="nnquant[3]">
													                <span class="glyphicon glyphicon-minus"></span>
													              </button>
													          </span>
													          <input type="number" readonly="readonly" name="nnquant[3]" id="double-children-number" class="form-control double-children-number" value="0" min="0" max="100" pattern="\d*" />
													          
													          <span class="input-group-btn">
													              <button type="button" class="btn QuantityButton double-btn-number g-no-disabled" data-type="plus" data-field="nnquant[3]">
													                  <span class="glyphicon glyphicon-plus"></span>
													              </button>
													          </span>

													      </div>
													  </span> 
													</div>
											    </div> 
											</div>
								 		</div>								 		

								 		<div class="form-group col-sm-3">
								 			<div class="btn-group SearchFilterItem" id="SearchFilterItem"> 
											    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
											    	<span class="Name1"><?=l("transport")?></span>
											    	<label class="Name2 LocationName double-TransportValue"><text><?=$g_transports[0]["title"]?></text></label>
											    </div>
											    <div class="dropdown-menu OneListDropDown double-TransporDropDown"> 
													<?php 
										        	$x=1;
										        	foreach($g_transports as $tra): ?>	
										        	<div class="Item">
														<input class="TripCheckbox" type="checkbox" id="double-ListTra<?=$tra['id']?>" data-id="<?=$tra['id']?>" data-kiloprice-up="<?=htmlentities($tra['price1'])?>" data-kmlimit="<?=$tra["kmlimit"]?>" data-kiloprice-down="<?=htmlentities($tra['price2'])?>" data-price_50="<?=$tra['price_50']?>" data-price_100="<?=$tra['price_100']?>" data-price_200="<?=$tra['price_200']?>" data-price_200_plus="<?=$tra['price_200_plus']?>" value="<?=htmlentities($tra['title'])?>" <?=($x==1) ? 'checked="checked"' : ''?> />
														<label class="pull-left Text" for="double-ListTra<?=$tra['id']?>">
															<?=$tra['title']?>
															<div class="IconSmall"><i class="<?=htmlentities($tra['meta_desc'])?>"></i></div>
														</label> 
										        	</div> 	
										        	<?php 
										        	$x=2;
										        	endforeach; ?>						       	
											    </div>
											</div>
								 		</div>

							 		</div>						 		
							 		
							 		
						 		</div>
						 		<!-- Double way end -->

					 		</div>
					 	</div>
		 			</div>
			 	</div>
			 	
			 	<div class="col-sm-3 ColSm3">
			 		<div class="TripSidebar">
						<div class="GreenSidebarDiv RightBackground">
							<div class="SidebarTitle"><?=l("yourdironmap")?></div>
							<div id="SidebarSmallMap" class="SidebarSmallMap text-center">
								MAP DIV
							</div> 

							

							<div class="col-sm-12 padding_0">
					 			<div class="btn-group PackageInfoDiv"> 
					 				<label><?=l("price")?></label> 
					 				<span id="totalprice">0</span>
					 			</div>
					 		</div>

					 		<div class="doublemapbox" style="display: none;">
						 		<div id="SidebarSmallMap2" class="SidebarSmallMap text-center">
								</div> 
								<div class="col-sm-12 padding_0">
						 			<div class="btn-group PackageInfoDiv"> 
						 				<label><?=l("price")?></label>
						 				<span id="totalprice2">0</span>
						 			</div>
						 		</div>
					 		</div>

					 		<div class="col-sm-12 padding_0">



					 			<div class="btn-group TotalPriceDiv"> 
					 				<label style="width: 100%;display: block; text-align: right;"><?=l("totalpricefinal")?></label>
					 				<div class="row">
						 				<div class="col-sm-12">
							 				
											<div class="SumCount" style="float: right;">
						        				<span id="totalpricefinal" class="gelprice">0</span>
						        				<span class="hoverprice"></span>
						        			</div>
										</div>
					 				</div>

					 			</div>
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

					 		

							<div class="TotalPriceDiv"> 

				        		<div class="col-sm-12 padding_0">				        			
									<div class="IncuranceNewDiv"> 
										<input class="TripNewCheckbox" type="checkbox" id="insurance123" />
										<label for="insurance123">
											<div class="FreeIncurance">+ <?=l("freeinsurance")?></div>
										</label>
									</div>
								</div>
									
			        			<?php 
            					if(isset($_SESSION["trip_user"])){
            					?>
									<div class="col-sm-12 padding_0"><a href="javascript:void(0)" class="GreenCircleButton_4 addTransportToCart" data-redirect="true" data-title="<?=l("message")?>" data-successtext="<?=l("welldone")?>"><?=l("buy")?></a></div>
			        			<?php } ?>

			        			<div class="col-sm-12 padding_0"><a href="javascript:void(0)" class="GreenCircleButton_4 addTransportToCart" data-redirect="false" data-title="<?=l("message")?>" data-successtext="<?=l("welldone")?>"><span class="CartIcon"></span> <?=l("addtocart")?></a> </div>

				        	</div>


				        	</div>
						</div>
			 		</div>
			 	</div>
	 		</div> 
		</div>
	</div>
</div>
<?php 
$transfersPrices = [];
foreach($g_transports as $tra){
	if($tra["id"]==125){ //sedani
		$transfersPrices["sedan"]["p_transfer_0_50"] = $tra["p_transfer_0_50"];
		$transfersPrices["sedan"]["p_transfer_50_100"] = $tra["p_transfer_50_100"];
		$transfersPrices["sedan"]["p_transfer_100_150"] = $tra["p_transfer_100_150"];
		$transfersPrices["sedan"]["p_transfer_150_200"] = $tra["p_transfer_150_200"];
		$transfersPrices["sedan"]["p_transfer_200_250"] = $tra["p_transfer_200_250"];
		$transfersPrices["sedan"]["p_transfer_250_300"] = $tra["p_transfer_250_300"];
		$transfersPrices["sedan"]["p_transfer_300_350"] = $tra["p_transfer_300_350"];
		$transfersPrices["sedan"]["p_transfer_350_400"] = $tra["p_transfer_350_400"];
		$transfersPrices["sedan"]["p_transfer_400_plus"] = $tra["p_transfer_400_plus"];
		$transfersPrices["sedan"]["p_transfer_max_crowed"] = $tra["p_transfer_max_crowed"];
		$transfersPrices["sedan"]["samewaydiscount"] = $tra["samewaydiscount"];
		$transfersPrices["sedan"]["income_proc"] = $tra["p_transfer_income_proc"];
	}else if($tra["id"]==126){ //minivan
		$transfersPrices["minivan"]["p_transfer_0_50"] = $tra["p_transfer_0_50"];
		$transfersPrices["minivan"]["p_transfer_50_100"] = $tra["p_transfer_50_100"];
		$transfersPrices["minivan"]["p_transfer_100_150"] = $tra["p_transfer_100_150"];
		$transfersPrices["minivan"]["p_transfer_150_200"] = $tra["p_transfer_150_200"];
		$transfersPrices["minivan"]["p_transfer_200_250"] = $tra["p_transfer_200_250"];
		$transfersPrices["minivan"]["p_transfer_250_300"] = $tra["p_transfer_250_300"];
		$transfersPrices["minivan"]["p_transfer_300_350"] = $tra["p_transfer_300_350"];
		$transfersPrices["minivan"]["p_transfer_350_400"] = $tra["p_transfer_350_400"];
		$transfersPrices["minivan"]["p_transfer_400_plus"] = $tra["p_transfer_400_plus"];
		$transfersPrices["minivan"]["p_transfer_max_crowed"] = $tra["p_transfer_max_crowed"];
		$transfersPrices["minivan"]["samewaydiscount"] = $tra["samewaydiscount"];
		$transfersPrices["minivan"]["income_proc"] = $tra["p_transfer_income_proc"];
	}else if($tra["id"]==127){ //minibus
		$transfersPrices["minibus"]["p_transfer_0_50"] = $tra["p_transfer_0_50"];
		$transfersPrices["minibus"]["p_transfer_50_100"] = $tra["p_transfer_50_100"];
		$transfersPrices["minibus"]["p_transfer_100_150"] = $tra["p_transfer_100_150"];
		$transfersPrices["minibus"]["p_transfer_150_200"] = $tra["p_transfer_150_200"];
		$transfersPrices["minibus"]["p_transfer_200_250"] = $tra["p_transfer_200_250"];
		$transfersPrices["minibus"]["p_transfer_250_300"] = $tra["p_transfer_250_300"];
		$transfersPrices["minibus"]["p_transfer_300_350"] = $tra["p_transfer_300_350"];
		$transfersPrices["minibus"]["p_transfer_350_400"] = $tra["p_transfer_350_400"];
		$transfersPrices["minibus"]["p_transfer_400_plus"] = $tra["p_transfer_400_plus"];
		$transfersPrices["minibus"]["p_transfer_max_crowed"] = $tra["p_transfer_max_crowed"];
		$transfersPrices["minibus"]["samewaydiscount"] = $tra["samewaydiscount"];
		$transfersPrices["minibus"]["income_proc"] = $tra["p_transfer_income_proc"];
	}else if($tra["id"]==220){ //minibus
		$transfersPrices["bus"]["p_transfer_0_50"] = $tra["p_transfer_0_50"];
		$transfersPrices["bus"]["p_transfer_50_100"] = $tra["p_transfer_50_100"];
		$transfersPrices["bus"]["p_transfer_100_150"] = $tra["p_transfer_100_150"];
		$transfersPrices["bus"]["p_transfer_150_200"] = $tra["p_transfer_150_200"];
		$transfersPrices["bus"]["p_transfer_200_250"] = $tra["p_transfer_200_250"];
		$transfersPrices["bus"]["p_transfer_250_300"] = $tra["p_transfer_250_300"];
		$transfersPrices["bus"]["p_transfer_300_350"] = $tra["p_transfer_300_350"];
		$transfersPrices["bus"]["p_transfer_350_400"] = $tra["p_transfer_350_400"];
		$transfersPrices["bus"]["p_transfer_400_plus"] = $tra["p_transfer_400_plus"];
		$transfersPrices["bus"]["p_transfer_max_crowed"] = $tra["p_transfer_max_crowed"];
		$transfersPrices["bus"]["samewaydiscount"] = $tra["samewaydiscount"];
		$transfersPrices["bus"]["income_proc"] = $tra["p_transfer_income_proc"];
	}
}
?>
<script type="text/javascript">
	var transfersPrices = {
		sedan:{
			p_transfer_0_50:parseFloat("<?=(float)$transfersPrices['sedan']['p_transfer_0_50']?>"),
			p_transfer_50_100:parseFloat("<?=(float)$transfersPrices['sedan']['p_transfer_50_100']?>"),
			p_transfer_100_150:parseFloat("<?=(float)$transfersPrices['sedan']['p_transfer_100_150']?>"),
			p_transfer_150_200:parseFloat("<?=(float)$transfersPrices['sedan']['p_transfer_150_200']?>"),
			p_transfer_200_250:parseFloat("<?=(float)$transfersPrices['sedan']['p_transfer_200_250']?>"),
			p_transfer_250_300:parseFloat("<?=(float)$transfersPrices['sedan']['p_transfer_250_300']?>"),
			p_transfer_300_350:parseFloat("<?=(float)$transfersPrices['sedan']['p_transfer_300_350']?>"),
			p_transfer_350_400:parseFloat("<?=(float)$transfersPrices['sedan']['p_transfer_350_400']?>"),
			p_transfer_400_plus:parseFloat("<?=(float)$transfersPrices['sedan']['p_transfer_400_plus']?>"),
			p_transfer_max_crowed:parseFloat("<?=(float)$transfersPrices['sedan']['p_transfer_max_crowed']?>"),
			samewaydiscount:parseFloat("<?=(float)$transfersPrices['sedan']['samewaydiscount']?>"),
			income_proc:parseFloat("<?=(float)$transfersPrices['sedan']['income_proc']?>")
		},
		minivan:{
			p_transfer_0_50:parseFloat("<?=(float)$transfersPrices['minivan']['p_transfer_0_50']?>"),
			p_transfer_50_100:parseFloat("<?=(float)$transfersPrices['minivan']['p_transfer_50_100']?>"),
			p_transfer_100_150:parseFloat("<?=(float)$transfersPrices['minivan']['p_transfer_100_150']?>"),
			p_transfer_150_200:parseFloat("<?=(float)$transfersPrices['minivan']['p_transfer_150_200']?>"),
			p_transfer_200_250:parseFloat("<?=(float)$transfersPrices['minivan']['p_transfer_200_250']?>"),
			p_transfer_250_300:parseFloat("<?=(float)$transfersPrices['minivan']['p_transfer_250_300']?>"),
			p_transfer_300_350:parseFloat("<?=(float)$transfersPrices['minivan']['p_transfer_300_350']?>"),
			p_transfer_350_400:parseFloat("<?=(float)$transfersPrices['minivan']['p_transfer_350_400']?>"),
			p_transfer_400_plus:parseFloat("<?=(float)$transfersPrices['minivan']['p_transfer_400_plus']?>"),
			p_transfer_max_crowed:parseFloat("<?=(float)$transfersPrices['minivan']['p_transfer_max_crowed']?>"),
			samewaydiscount:parseInt("<?=(float)$transfersPrices['minivan']['samewaydiscount']?>"),
			income_proc:parseFloat("<?=(float)$transfersPrices['minivan']['income_proc']?>")
		},
		minibus:{
			p_transfer_0_50:parseFloat("<?=(float)$transfersPrices['minibus']['p_transfer_0_50']?>"),
			p_transfer_50_100:parseFloat("<?=(float)$transfersPrices['minibus']['p_transfer_50_100']?>"),
			p_transfer_100_150:parseFloat("<?=(float)$transfersPrices['minibus']['p_transfer_100_150']?>"),
			p_transfer_150_200:parseFloat("<?=(float)$transfersPrices['minibus']['p_transfer_150_200']?>"),
			p_transfer_200_250:parseFloat("<?=(float)$transfersPrices['minibus']['p_transfer_200_250']?>"),
			p_transfer_250_300:parseFloat("<?=(float)$transfersPrices['minibus']['p_transfer_250_300']?>"),
			p_transfer_300_350:parseFloat("<?=(float)$transfersPrices['minibus']['p_transfer_300_350']?>"),
			p_transfer_350_400:parseFloat("<?=(float)$transfersPrices['minibus']['p_transfer_350_400']?>"),
			p_transfer_400_plus:parseFloat("<?=(float)$transfersPrices['minibus']['p_transfer_400_plus']?>"),
			p_transfer_max_crowed:parseInt("<?=(float)$transfersPrices['minibus']['p_transfer_max_crowed']?>"),
			samewaydiscount:parseInt("<?=(float)$transfersPrices['minibus']['samewaydiscount']?>"),
			income_proc:parseFloat("<?=(float)$transfersPrices['minibus']['income_proc']?>")
		},
		bus:{
			p_transfer_0_50:parseFloat("<?=(float)$transfersPrices['bus']['p_transfer_0_50']?>"),
			p_transfer_50_100:parseFloat("<?=(float)$transfersPrices['bus']['p_transfer_50_100']?>"),
			p_transfer_100_150:parseFloat("<?=(float)$transfersPrices['bus']['p_transfer_100_150']?>"),
			p_transfer_150_200:parseFloat("<?=(float)$transfersPrices['bus']['p_transfer_150_200']?>"),
			p_transfer_200_250:parseFloat("<?=(float)$transfersPrices['bus']['p_transfer_200_250']?>"),
			p_transfer_250_300:parseFloat("<?=(float)$transfersPrices['bus']['p_transfer_250_300']?>"),
			p_transfer_300_350:parseFloat("<?=(float)$transfersPrices['bus']['p_transfer_300_350']?>"),
			p_transfer_350_400:parseFloat("<?=(float)$transfersPrices['bus']['p_transfer_350_400']?>"),
			p_transfer_400_plus:parseFloat("<?=(float)$transfersPrices['bus']['p_transfer_400_plus']?>"),
			p_transfer_max_crowed:parseInt("<?=(float)$transfersPrices['bus']['p_transfer_max_crowed']?>"),
			samewaydiscount:parseInt("<?=(float)$transfersPrices['bus']['samewaydiscount']?>"),
			income_proc:parseFloat("<?=(float)$transfersPrices['bus']['income_proc']?>")
		}
	};
</script>
<script type="text/javascript" src="/_website/js/transfers.js?v=<?=WEBSITE_VERSION?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeSTjMJTVIuJaIiFgxLQgvCRl8HJqo0qo&amp;callback=initMap"></script>
<script type="text/javascript">
var todayDate = new Date().getDate();

$('.DatePicker2').datepicker({
	format: 'yyyy-mm-dd',
	ignoreReadonly: true,
	autoclose:true, 
	startDate: new Date(new Date().setDate(todayDate + 2)),
	language:'<?=l()?>'
});
</script>