<?php defined('DIR') OR exit; ?>
<?php
$startingplace = g_places(false, true, '`id` ASC');
$regions = g_regions();
$g_places = g_places(); 
$g_places_musiams = g_places(108); 
$g_places_naturalSights = g_places(107); 
$g_places_culturalSights = g_places(105); 
$g_places_wine_tours = g_places(106); 
?>
<div class="InsidePagesHeader Big">
	<div class="Title"><span class="BigSpan"><?php echo $title ?></span></div>
	<div class="Item" style="background:url('_website/img/trip_1.jpg');"></div>
	<div class="Item" style="background:url('_website/img/trip_2.jpg');"></div>
	<div cernlass="Item" style="background:url('_website/img/trip_3.jpg');"></div>
	<div class="Item" style="background:url('_website/img/trip_4.jpg');"></div>
</div>



<div class="TripListPageDiv TripListPageDiv22">
	<div class="TripListInsidePage"> 
		<div class="container"> 
		 	<div class="row row0">
		 		<div class="col s12">
		 			<div class="Breadcrumb"> 
				 		<?php echo location();?> 
					</div>
		 		</div>
		 	</div>

		 	<div class="FiltersDiv">
		 		<div class="row row8"> 
		 			<div class="col-sm-8 padding_0 ">
		 				<form action="?" method="position">
		 					<input type="hidden" name="totalkm" class="totalkm" id="totalkm" value="0" />
		 					<input type="hidden" name="input_regions" class="input_regions" value="[]" />
		 					<input type="hidden" name="input_start_place" class="input_start_place" value="[]" />
		 					<input type="hidden" name="input_date_start" class="input_date_start" value="[]" />
		 					<input type="hidden" name="input_date_end" class="input_date_end" value="[]" />
		 					<input type="hidden" name="input_guest" class="input_guest" value="[]" />
		 					<input type="hidden" name="daily" id="daily" value="( <?=l("daily")?> )" />
		 				</form>						
						
						<div class="col-sm-4 ShowForMobile">
							<div class="HtmlMultiSelect">
								<div class="TItle"></div>
								<select id="mobile-place">
									<option selected disabled><?=l("choosestartingplace")?></option>
									<?php 
							    	foreach ($startingplace as $item):
							    		$selected = ($item["id"]==856) ? 'selected="selected"' : '';
							    	?>
							    	<option value="<?=$item["id"]?>" <?=$selected?>><?=$item["title"]?></option>
							    	<?php endforeach; ?>									
								</select>
							</div>

							<input type="hidden" name="mobile-regions" id="mobile-regions" value="" />
							<div class="g-selector-mainbox">
								<div class="g-selector-title" data-defaulttext="<?=htmlentities(l("searchbyregions"))?>"><?=l("searchbyregions")?></div>
								<div class="g-mselector-box">
									<?php 
									foreach ($regions as $item):
									?>
									<label><?=$item["title"]?> (<?=$item["placeCouned"]?>) <input type="checkbox" name="mselector[]" value="<?=$item["id"]?>" class="mselector" data-attached="#mobile-regions" data-val="<?=htmlentities($item["title"])?>" /></label>
									<?php 
									endforeach;
									?>
								</div>
							</div>


							<div class="col-sm-12 padding_0" style="position: relative;">
								<div class="HtmlMultiSelect HtmlMultiSelect222">
									<div class="Title"><?=l("startdate")?> &amp; <?=l("enddate")?> </div>
									<div class="MobileInputs" style="height: 37px;">
										<div class="input-group PositionRelative">
											<span class="DateControl1">
												 <input type="text" id="mobile-startdate" class="form-control theAllDatepicker" value="<?=date("Y-m-d", time()+172800)?>" readonly="readonly" style="background-color: white">
											</span>
											<span class="input-group-addon TimeAddons" style="top: 18px;">-</span>
											<span class="DateControl2">
												 <input type="text" id="mobile-enddate" class="form-control theAllDatepicker" value="<?=date("Y-m-d", time()+172800)?>" disabled="disabled" style="background-color: white">
											</span>
											<span class="input-group-addon addon2" style="top: 12px; right: 8px; position: absolute;"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>

								<script type="text/javascript">
								$(document).on("change", "#mobile-startdate", function(){
								var needday = parseInt($("#needday").val());

								let startDate = new Date($(this).val());                  
								let tour_dayes_times = parseInt(needday) * 86400000;
								let tour_finish = startDate.getTime() + tour_dayes_times;

								var setTodate = new Date(new Date().setTime(tour_finish));
								$("#mobile-enddate").val(setTodate.yyyymmdd());
								return false;
								});
								</script>
							</div>
							
							<div class="MobileDateAndGuests">
								<div class="row">									
									<div class="col-sm-12">
										<div class="HtmlMultiSelect FixedHeight">
											<div class="Title"><?=l("adults")?></div>
											<select id="mobile-guest"> 
												<?php for($x=1; $x<=30; $x++):?>
												<option value="<?=$x?>"><?=$x?></option>			
												<?php endfor; ?>						
											</select>
										</div>
									</div>

									<div class="col-sm-666">
										<div class="HtmlMultiSelect FixedHeight">
											<div class="Title"><?=l("underchildrenages")?></div>
											<select id="mobile-underchild"> 
												<?php for($x=0; $x<=10; $x++):?>
												<option value="<?=$x?>"><?=$x?></option>			
												<?php endfor; ?>						
											</select>
										</div>
									</div>

									<div class="col-sm-666">
										<div class="HtmlMultiSelect FixedHeight">
											<div class="Title"><?=l("childrenages")?></div>
											<select id="mobile-child"> 
												<?php for($x=0; $x<=10; $x++):?>
												<option value="<?=$x?>"><?=$x?></option>			
												<?php endfor; ?>						
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-sm-4 HideForMobile">
				 			<div class="btn-group SearchFilterItem"> 
							    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
							    	<span class="Name1"><?=l("searchbyregions")?></span>
							    	<label class="Name2 LocationName InpueValue1"></label>
							    </div>
							    <div class="dropdown-menu LocationDropDown LocationDropDown1"> 
						        	<?php 
							    	foreach ($regions as $item):
							    	?>
						        	<div class="Item">
						        		<input class="TripCheckbox" type="checkbox" data-id="<?=$item["id"]?>" id="List<?=$item["id"]?>" value="<?=htmlentities($item["title"])?>" data-id="<?=$item["id"]?>">
										<label class="pull-left Text" for="List<?=$item["id"]?>">
											<?=$item["title"]?> <span><?=$item["placeCouned"]?></span>
										</label> 
						        	</div> 
						        	<?php endforeach; ?>
						        	<script> $("label[for='List145']").click(); </script>
							    </div>
							</div>
				 		</div>
				 		
				 		<div class="col-sm-4 HideForMobile">
				 			<div class="btn-group SearchFilterItem"> 
				 				<div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
							    	<span class="Name1"><?=l("choosestartingplace")?></span>
							    	<label class="Name2 LocationName InpueValue2">
							    		<?php if(isset($startingplace[2]['title'])) :?>
							    			<text><?=$startingplace[2]['title']?></text>
							    		<?php endif; ?>
							    	</label>
							    </div>
							    <div class="dropdown-menu LocationDropDown LocationDropDown2"> 
							    	<?php 
							    	foreach ($startingplace as $item):
							    		$checked = ($item["id"]==856) ? 'checked' : '';
							    	?>
						        	<div class="Item">
						        		<input class="TripCheckbox" type="checkbox" data-id="<?=$item["id"]?>" <?=$checked?> id="List<?=$item["id"]?>" data-map_coordinates="<?=$item["map_coordinates"]?>" value="<?=htmlentities($item["title"])?>">
										<label class="pull-left Text" for="List<?=$item["id"]?>">
											<?=$item["title"]?>
										</label> 
						        	</div> 
						        	<?php endforeach; ?>
							    </div>
							</div>
				 		</div>

				 		<div class="col-sm-4 PaddingRight0 HideForMobile">
				 			<div class="btn-group SearchFilterItem"> 
							    <div class="TripTogglebutton">
							    	<span>
							    		<div class="row">
							    			<div class="col-sm-6"><?=l("startdate")?></div>
							    			<div class="col-sm-6" style="position:relative;left:-19px;"><?=l("enddate")?></div>
							    		</div>
							    	</span>
							    	<div class="input-group PositionRelative">
							    	  <input type="hidden" id="needday" value="0" /><!-- needday -->
									  <input type="text" class="form-control startDatePicker theAllDatepicker" id="startDatePicker" value="<?=date("Y-m-d", time()+172800)?>" readonly="readonly" />
									  <span class="input-group-addon TimeAddons">-</span>
									  <input type="text" class="form-control endDatePicker theAllDatepicker2" disabled="disabled" style="background-color: #fff" value="<?=date("Y-m-d", time()+172800)?>" />
									  <span class="input-group-addon" onclick="$('#startDatePicker').focus()"><i class="fa fa-calendar"></i></span>
									</div>

									<script type="text/javascript">
										var todayDate = new Date().getDate(); 
										$('.theAllDatepicker').datepicker({
											format: 'yyyy-mm-dd',
											ignoreReadonly: true,
											autoclose:true, 
											startDate: new Date(new Date().setDate(todayDate + 2)),
											language:'<?=l()?>'
										});

										$(document).on("change", ".theAllDatepicker", function(){
										  var needday = parseInt($("#needday").val());
										  console.log(needday);
										  let startDate = new Date($(this).val());                  
										  let tour_dayes_times = parseInt(needday) * 86400000;
										  let tour_finish = startDate.getTime() + tour_dayes_times;
										  
										  var setTodate = new Date(new Date().setTime(tour_finish));
										  $(".theAllDatepicker2").val(setTodate.yyyymmdd());
										  return false;
										});

									</script>
							    </div> 
							</div>
				 		</div>
		 			</div>
			 		
			 		<div class="col-sm-4 HideForMobile">			 			
		 				<div class="col-sm-4">
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
									          <input type="number" name="quant[2]" id="quant2" readonly="readonly" class="form-control input-number" value="1" min="1" max="100" pattern="\d+" inputmode="numeric" />
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

						<div class="col-sm-4">
				 			<div class="btn-group SearchFilterItem g-tooltip" data-tooltip="<?=htmlentities(l("chindrenrangedescunder"))?>"> 
							    <div class="TripTogglebutton">
							    	<span class="Name1"><?=l("underchildrenages")?></span>
							    	<div class="input-group PositionRelative"> 
									  <span class="Quantity Quantity2">
									  	<div class="input-group">
									          <span class="input-group-btn">
									              <button type="button" class="btn QuantityButton btn-number"  data-type="minus" data-field="quantn[400]">
									                <span class="glyphicon glyphicon-minus"></span>
									              </button>
									          </span>
									          <input type="number" name="quantn[400]" id="quantn4" readonly="readonly" class="form-control planner-childrenunder" value="0" min="0" max="100" pattern="\d+" inputmode="numeric" />
									          <span class="input-group-btn">
									              <button type="button" class="btn QuantityButton btn-number" data-type="plus" data-field="quantn[400]">
									                  <span class="glyphicon glyphicon-plus"></span>
									              </button>
									          </span>
									      </div>
									  </span> 
									</div>
							    </div> 
							</div>
						</div>

						<div class="col-sm-4">
				 			<div class="btn-group SearchFilterItem g-tooltip" data-tooltip="<?=htmlentities(l("chindrenrangedesc"))?>"> 
							    <div class="TripTogglebutton">
							    	<span class="Name1"><?=l("childrenages")?></span>
							    	<div class="input-group PositionRelative"> 
									  <span class="Quantity Quantity2">
									  	<div class="input-group">
									          <span class="input-group-btn">
									              <button type="button" class="btn QuantityButton btn-number"  data-type="minus" data-field="quantn[4]">
									                <span class="glyphicon glyphicon-minus"></span>
									              </button>
									          </span>
									          <input type="number" name="quantn[4]" id="quantn44" readonly="readonly" class="form-control planner-children" value="0" min="0" max="100" pattern="\d+" inputmode="numeric" />
									          <span class="input-group-btn">
									              <button type="button" class="btn QuantityButton btn-number" data-type="plus" data-field="quantn[4]">
									                  <span class="glyphicon glyphicon-plus"></span>
									              </button>
									          </span>
									      </div>
									  </span> 
									</div>
							    </div> 
							</div>
						</div>


						

			 		</div>
		 		</div>
		 	</div>



		 	<div class="row">
		 		<div class="col-sm-9 ColSm9">
					
					<div class="PlannerCategories">
		        		<div class="row">
		        			<div class="col-sm-3">
			        			<div class="Item catbox active g-tooltip" data-id="108" data-cattodelete="gg_musiams" data-tooltip="<?=menu_title(108, 'meta_desc')?>">
			        				<div class="MuseumIcon"></div>
			        				<div class="Title"><?=menu_title(108)?></div> 
			        				<div class="CheckedItem"></div>
				        		</div>
			        		</div>
			        		<div class="col-sm-3">
			        			<div class="Item catbox active g-tooltip" data-id="107" data-cattodelete="gg_natural" data-tooltip="<?=menu_title(107, 'meta_desc')?>">
			        				<div class="NaturalIcon"></div>
			        				<div class="Title"><?=menu_title(107)?></div> 
			        				<div class="CheckedItem"></div>
				        		</div>
			        		</div>
			        		<div class="col-sm-3">
			        			<div class="Item catbox active g-tooltip" data-id="105" data-cattodelete="gg_calture" data-tooltip="<?=menu_title(105, 'meta_desc')?>">
			        				<div class="CulturalIcon"></div>
			        				<div class="Title"><?=menu_title(105)?></div> 
			        				<div class="CheckedItem"></div>
				        		</div>
			        		</div>
			        		<div class="col-sm-3">
			        			<div class="Item catbox active g-tooltip" data-id="106" data-cattodelete="gg_wine" data-tooltip="<?=menu_title(106, 'meta_desc')?>">
			        				<div class="WineToursIcon"></div>
			        				<div class="Title"><?=menu_title(106)?></div> 
			        				<div class="CheckedItem"></div>
				        		</div>
			        		</div>
		        		</div>
				    </div>


			 		<div class="ToursPlannerDiv">
						<div  class="DivScroll"> 
							<div class="CheckboxListsForMobile ShowForMobile mobile-placesbox">
								<?php foreach ($g_places as $item): ?>
								<div class="Item" data-region="<?=$item["regions"]?>"> 
									<input class="TripCheckbox" type="checkbox" data-map="<?=$item['map_coordinates']?>" data-addprice="<?=htmlentities($item['menutitle'])?>" data-categories="<?=$item['categories']?>" data-title="<?=htmlentities(str_replace('"','',$item['title']))?>" value="<?=$item['id']?>" id="Chek<?=$item['id']?>" />
									<label class="pull-left Text FontNormal" for="Chek<?=$item['id']?>">
										<div class="Info" onclick="$('#Chek<?=$item['id']?>').click();" style="cursor: pointer">
											<div class="Title"><?=str_replace('"','',$item['title'])?></div>
											<div class="Text" id="text<?=$item['id']?>" data-fulltext="<?=htmlentities(strip_tags($item['description']))?>">
												<?=g_cut($item['description'],120)?>
											</div>
										</div>
										<a href="javascript:void(0)" class="text<?=$item['id']?>" onclick="gShowAllText('text<?=$item['id']?>')"><?=l("more")?></a>
									</label> 
									
								</div>
								<?php endforeach; ?>							
							</div>
							

							
					  		<div class="CheckboxLists">
				  				<div class="col-sm-3 gg_musiams">	
				  					<?php 					  			
									foreach($g_places_musiams as $item):
									?>					  			
									<div class="CheckBoxItem" data-region="<?=$item["regions"]?>"> 
									<input class="TripCheckbox" type="checkbox" name="layout" id="<?=$item["id"]?>" value="<?=$item["id"]?>" data-map="<?=$item["map_coordinates"]?>" data-title="<?=htmlentities(str_replace('"','',$item["title"]))?>" data-addprice="<?=htmlentities($item['menutitle'])?>" data-categories="<?=$item["categories"]?>" onclick="ColorDistance()" />
									<label class="pull-left Text FontNormal" for="<?=$item["id"]?>">
										<?=str_replace('"','',$item["title"])?>

										<div class="PositionRelative"> 
											<div class="ShowWindow1">
												<div class="Title"><?=str_replace('"','',$item["title"])?></div>
												<?php 
												$imagePath = explode("https://tripplanner.ge", $item["image1"]);
												if(!empty($item["image1"]) && $item["image1"]!="" && file_exists("/home4/tripplanner/public_html".$imagePath[1])): ?>
													<div class="Image LoadImage" data-image="https://tripplanner.ge/image.php?f=<?=$item["image1"]?>&w=280&h=180" data-loaded="false" style="height: 180px;"></div>
												<?php endif; ?>
												<div class="Text">
													<?=strip_tags($item["description"], "<p><a><strong>")?>
												</div>
											</div>
										</div>
									</label> 		
									</div>
									<?php endforeach; ?>
				  				</div>
				  				<div class="col-sm-3 gg_natural">	
				  					<?php 					  			
									foreach($g_places_naturalSights as $item):
									?>					  			
									<div class="CheckBoxItem" data-region="<?=$item["regions"]?>"> 
									<input class="TripCheckbox" type="checkbox" name="layout" id="<?=$item["id"]?>" value="<?=$item["id"]?>" data-map="<?=$item["map_coordinates"]?>" data-title="<?=htmlentities(str_replace('"','',$item["title"]))?>" data-addprice="<?=htmlentities($item['menutitle'])?>" data-categories="<?=$item["categories"]?>" onclick="ColorDistance()" />
									<label class="pull-left Text FontNormal" for="<?=$item["id"]?>">
										<?=str_replace('"','',$item["title"])?>
										<div class="PositionRelative"> 
											<div class="ShowWindow1">
												<div class="Title"><?=str_replace('"','',$item["title"])?></div>
												<?php 
												$imagePath = explode("https://tripplanner.ge", $item["image1"]);
												if(!empty($item["image1"]) && $item["image1"]!="" && file_exists("/home4/tripplanner/public_html".$imagePath[1])): ?>
													<div class="Image LoadImage" data-image="<?=$item["image1"]?>" data-loaded="false" style="height: 180px;"></div>
												<?php endif; ?>
												<div class="Text">
													<?=strip_tags($item["description"], "<p><a><strong>")?>
												</div>
											</div>
										</div>
									</label> 		
									</div>
									<?php endforeach; ?>
				  				</div>
				  				<div class="col-sm-3 gg_calture">	
				  					<?php 					  			
									foreach($g_places_culturalSights as $item):
									?>					  			
									<div class="CheckBoxItem" data-region="<?=$item["regions"]?>"> 
										<input class="TripCheckbox" type="checkbox" name="layout" id="<?=$item["id"]?>" value="<?=$item["id"]?>" data-map="<?=$item["map_coordinates"]?>" data-title="<?=htmlentities(str_replace('"','',$item["title"]))?>" data-addprice="<?=htmlentities($item['menutitle'])?>" data-categories="<?=$item["categories"]?>" onclick="ColorDistance()" />
										<label class="pull-left Text FontNormal" for="<?=$item["id"]?>">
											<?=str_replace('"','',$item["title"])?>
											<div class="PositionRelative"> 
												<div class="ShowWindow1">
													<div class="Title"><?=str_replace('"','',$item["title"])?></div>
													<?php 
													$imagePath = explode("https://tripplanner.ge", $item["image1"]);
													if(!empty($item["image1"]) && $item["image1"]!="" && file_exists("/home4/tripplanner/public_html".$imagePath[1])): ?>
														<div class="Image LoadImage" data-image="<?=$item["image1"]?>" data-loaded="false" style="height: 180px;"></div>
													<?php endif; ?>
													<div class="Text">
														<?=strip_tags($item["description"], "<p><a><strong>")?>
													</div>
												</div>
											</div>
										</label> 		
										</div>
									<?php endforeach; ?>
				  				</div>
				  				<div class="col-sm-3 gg_wine">	
				  					<?php 					  			
									foreach($g_places_wine_tours as $item):
									?>					  			
									<div class="CheckBoxItem" data-region="<?=$item["regions"]?>"> 
										<input class="TripCheckbox" type="checkbox" name="layout" id="<?=$item["id"]?>" value="<?=$item["id"]?>" data-map="<?=$item["map_coordinates"]?>" data-title="<?=htmlentities(str_replace('"','',$item["title"]))?>" data-categories="<?=$item["categories"]?>" data-addprice="<?=htmlentities($item['menutitle'])?>" onclick="ColorDistance()" />
										<label class="pull-left Text FontNormal" for="<?=$item["id"]?>">
											<?=str_replace('"','',$item["title"])?>
											<div class="PositionRelative"> 
												<div class="ShowWindow1">
													<div class="Title"><?=str_replace('"','',$item["title"])?></div>
													<?php 
													$imagePath = explode("https://tripplanner.ge", $item["image1"]);
													if(!empty($item["image1"]) && $item["image1"]!="" && file_exists("/home4/tripplanner/public_html".$imagePath[1])): ?>
														<div class="Image LoadImage" data-image="<?=$item["image1"]?>" data-loaded="false" style="height: 180px;"></div>
													<?php endif; ?>
													<div class="Text">
														<?=strip_tags($item["description"], "<p><a><strong>")?>
													</div>
												</div>
											</div>
										</label> 		
										</div>
									<?php endforeach; ?>
				  				</div>						
					  		</div>
						</div>
						
						<div style="clear:both"></div>
					</div>	

					<div class="PlannerBottom FiltersDiv">
							<div class="col-sm-6 ColSm6">
								<div class="PlanItem">
					        		<div class="FirstCheckDiv g-plan-hotels">
					        			<div class="CheckBox">
					        				<input class="TripCheckbox Hotels_Main_Checkbox" type="checkbox" id="Hotels" value="Hotels" onclick="return false;" onkeydown="return false;" />
											<label class="pull-left Text" for="Hotels">
												<div class="Icon"><img src="_website/img/hotel_icon.png"/></div>
												<div class="Title"><?=menu_title(111)?></div>
											</label> 
					        			</div>
					        		</div>
									
									
					        		<div class="SecondCheckDiv">
					        			<?php 
					        			$Hotels = g_listselect(37, array(
					        				"`id`",
					        				"`title`",
					        				"`image1`",
					        				"`menutitle`",
					        				"`meta_desc`"
					        			));
					        			?>
										
										<div class="col-sm-4 ShowForMobile">
											<div class="HtmlMultiSelect">
												<div class="TItle"></div>
												<select class="mobile-HotelsDropDown" data-parent="Hotels">
													<option value="" selected disabled><?=menu_title(111)?></option>
													<?php 
										        	foreach ($Hotels as $value):
										        	?>
														<option value="<?=$value['id']?>"><?=htmlentities($value['title'])?></option>
													<?php 
										        	endforeach; 
										        	?>									
												</select>
											</div>
										</div>
										
					        			<div class="btn-group SearchFilterItem g-plan-dropdown-toggle HideForMobile"> 
										    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
										    	<span class="Name1"><?=menu_title(111)?></span>
										    	<label class="Name2 LocationName hostelValue"></label>
										    </div>
										    <div class="dropdown-menu HotelsDropDown"> 		        	
									        	<?php 
									        	foreach ($Hotels as $value):
									        	?>
									        	<div class="Item">
									        		<input class="TripCheckbox planner-hotels" type="checkbox" id="Hotels<?=$value['id']?>" data-parent="Hotels" data-hotelid="<?=(int)$value['id']?>" data-price="<?=$value['menutitle']?>" value="<?=htmlentities($value['title'])?>"  />
													<label class="pull-left Text" for="Hotels<?=$value['id']?>" style="width:100%">
														<div class="Title2"><?=$value['title']?></div>
														<div class="TextDiv"><?=$value['meta_desc']?></div> 
														<div class="Image" style="float:right"><img src="<?=$value['image1']?>" alt="" /></div>
													</label> 
									        	</div> 	
									        	<?php 
									        	endforeach; 
									        	?>
										    </div>
										</div>
					        		</div>	
					        	</div>
							</div>


							<div class="col-sm-6 ColSm6">
								<div class="PlanItem">
					        		<div class="FirstCheckDiv g-plan-cuisune">
					        			<div class="CheckBox">
					        				<input class="TripCheckbox" type="checkbox" id="Cuisine" value="Cuisine" onclick="return false;" onkeydown="return false;" />
											<label class="pull-left Text" for="Cuisine">
												<div class="Icon"><img src="_website/img/cuisine_1.png"/></div>
												<div class="Title"><?=menu_title(112)?></div>
											</label> 
					        			</div>
					        		</div>
					        		<?php 
				        			$Cuisune = g_listselect(38, array(
				        				"`id`",
				        				"`title`",
				        				"`menutitle`",
				        				"`meta_desc`",
				        				"`image1`"
				        			));
				        			?>
					        		<div class="SecondCheckDiv">
										<div class="col-sm-4 ShowForMobile">
											<div class="HtmlMultiSelect" style="cursor: pointer;" onclick="$('.gg-cuisune-dropdown').slideToggle();">
												<div class="TItle"><?=menu_title(112)?></div>			
											</div>
											<div class="HtmlMultiSelect gg-cuisune-dropdown" style="display: none; background: none; border:none; ">
												<div class="cuisune-mobile-box">
													<?php 
								        			foreach ($Cuisune as $value):
								        			?>
								        				<div class="CheckBox">
								        					
								        					<input class="TripCheckbox cuisune-mobile-checkbox" type="checkbox" id="Cuisine-mobile<?=$value['id']?>" value="<?=htmlentities($value['title'])?>" data-price="<?=$value['menutitle']?>" data-cuisuneid="<?=$value['id']?>" />

								        					<label class="pull-left Text" for="Cuisine-mobile<?=$value['id']?>">
								        						<span><?=htmlentities($value['title'])?></span>
																<input type="number" name="guestsN-mobile[]" class="guestsN-mobile" data-id="<?=$value['id']?>" width="30"  value="1" min="1" max="100" pattern="\d+" inputmode="numeric" />
															</label>
														</div>
													<?php endforeach; ?>
												</div>
											</div>
										</div>	
					        			<div class="btn-group SearchFilterItem g-plan-dropdown-toggle2 HideForMobile"> 
										    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
										    	<span class="Name1"><?=menu_title(112)?></span>
										    	<label class="Name2 LocationName CuisineValue"></label>
										    </div>
										    <div class="dropdown-menu CuisineDropDown"> 
							        			<?php 
							        			foreach ($Cuisune as $value):
							        			?>
									        	<div class="Item">
									        		<input class="TripCheckbox planner-cuisune" type="checkbox" id="Cuisine<?=$value['id']?>" value="<?=htmlentities($value['title'])?>" data-price="<?=$value['menutitle']?>" data-cuisuneid="<?=$value['id']?>" data-parent="Cuisine" />
													<label class="pull-left Text" for="Cuisine<?=$value['id']?>" style="width: 100%" />
														<div class="Title2"><?=$value['title']?></div>
														<div class="TextDiv"><?=$value['meta_desc']?></div> 
														 <div class="TextDiv">
														 	<input type="number" name="guestsN[]" class="guestsN" data-id="<?=$value['id']?>" width="30" value="1" min="1" max="100" pattern="\d+" inputmode="numeric" />
														 </div> <!---->
														<div class="Image" style="float:right"><img src="<?=$value['image1']?>" alt="" /></div>
													</label> 
									        	</div>
									        	<?php endforeach; ?>									        	
										    </div>
										</div>
					        		</div>	
					        	</div>
							</div>

							<div style="clear:both"></div>

							<div class="col-sm-6 ColSm6">
								<div class="PlanItem">
					        		<div class="FirstCheckDiv g-plan-guide">
					        			<div class="CheckBox">
					        				<input class="TripCheckbox" type="checkbox" id="Guide" value="Guide" onclick="return false;" onkeydown="return false;" />
											<label class="pull-left Text" for="Lang11">
												<div class="Icon"><img src="_website/img/lang_icon.png"/></div>
												<div class="Title"><?=menu_title(113)?></div>
											</label> 
					        			</div>
					        		</div>
					        		<?php 
					        		$Language = g_listselect(39, array(
				        				"`id`",
				        				"`title`",
				        				"`meta_desc`",
				        				"`menutitle`",
				        				"`image1`"
				        			));
					        		?>
					        		<div class="SecondCheckDiv">
										<div class="col-sm-4 ShowForMobile">
											<div class="HtmlMultiSelect">
												<div class="TItle"></div>
												<select class="mobile-LanguageDropDown" data-parent="Guide">
													<option value="" selected disabled><?=menu_title(113)?></option>
													<?php 
								        			foreach ($Language as $value):
								        			?>
													<option value="<?=$value['id']?>"><?=$value['title']?></option>	
													<?php endforeach; ?>						
												</select>
											</div>
										</div>	
					        			<div class="btn-group SearchFilterItem g-plan-dropdown-toggle3 HideForMobile"> 
										    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
										    	<span class="Name1"><?=menu_title(113)?></span>
										    	<label class="Name2 LangValue"></label>
										    </div>

										    <div class="dropdown-menu LanguageDropDown"> 
									        	<?php 
							        			foreach ($Language as $value):
							        			?>
									        	<div class="Item">
									        		<input class="TripCheckbox planner-guide" type="checkbox" data-guideid="<?=$value['id']?>" id="Language<?=$value['id']?>" value="<?=htmlentities($value['title'])?>" data-price="<?=$value['menutitle']?>" data-parent="Guide">
													<label class="pull-left Text" for="Language<?=$value['id']?>" style="width: 100%">
														<div class="Title2"><?=$value['title']?></div>
														<!-- <div class="TextDiv"><?=$value['meta_desc']?></div> -->
														<!-- <div class="Image" style="float:right"><img src="<?=$value['image1']?>" alt="" /></div> -->
													</label> 
									        	</div>	
									        	<?php endforeach; ?>							        	
										    </div>
										</div>
					        		</div>	
					        	</div>
							</div>

							<div class="col-sm-6 ColSm6">
								<div class="PlanItem">
					        		<div class="FirstCheckDiv g-plan-transport">
					        			<div class="CheckBox">
					        				<input class="TripCheckbox" type="checkbox" id="Transports" value="Transports" onclick="return false;" onkeydown="return false;" checked="checked" />
											<label class="pull-left Text" for="Transport11">
												<div class="Icon"><img src="_website/img/transport_1.png"/></div>
												<div class="Title"><?=menu_title(114)?></div>
											</label> 
					        			</div>
					        		</div>
					        		<?php 
					        		$Transport = g_listselect(40, false);
					        		?>
					        		<div class="SecondCheckDiv">
										<div class="col-sm-4 ShowForMobile">
											<div class="HtmlMultiSelect">
												<div class="TItle"></div>
												<select class="mobile-TransporDropDown" data-parent="Transports">
													<option selected disabled><?=l("transport")?></option>
													<?php 
													$x=1;
													foreach ($Transport as $value):
														$checked = ($x==1) ? 'selected="selected"' : ''; 
													?>
													<option value="<?=$value['id']?>" <?=$checked?>><?=$value['title']?></option>
													<?php 
													$x=2;
													endforeach; ?>								
												</select>
											</div>
										</div>
					        			<div class="btn-group SearchFilterItem g-plan-dropdown-toggle4 HideForMobile"> 
										    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
										    	<span class="Name1"><?=menu_title(114)?></span>
										    	<label class="Name2 LocationName TransportValue"><text><?=$Transport[0]["title"]?></text></label>
										    </div>
										    <div class="dropdown-menu TransporDropDown"> 
									        	<?php 
									        	$x=1;
							        			foreach ($Transport as $value):
							        				$checked = ($x==1) ? 'checked="checked"' : ''; 
							        			?>
							        			<div class="Item">
									        		<input class="TripCheckbox planner-transport" type="checkbox" 
									        			data-id="<?=$value['id']?>" 
									        			id="tra<?=$value['id']?>" 
									        			value="<?=htmlentities($value['title'])?>" 
									        			data-kmlimit="<?=$value["kmlimit"]?>" 
									        			data-price="<?=$value['price1']?>" 
									        			data-kiloprice-up="<?=$value["price1"]?>" 
									        			data-kiloprice-down="<?=$value["price2"]?>" 
									        			data-parent="Transports" 
									        			data-price_50="<?=$value["price_50"]?>" 
									        			data-price_100="<?=$value["price_100"]?>" 
									        			data-price_200="<?=$value["price_200"]?>" 
									        			data-price_200_plus="<?=$value["price_200_plus"]?>" 
									        			<?=$checked?> />
													<label class="pull-left Text" for="tra<?=$value['id']?>" style="width:100%">
														<div class="Title2"><?=$value['title']?></div>
														<div class="TextDiv"><?=$value['description']?></div>
														<div class="IconSmall" style="margin-top: -15px; float: right; font-size: 30px;"><i class="<?=$value['meta_desc']?>"></i></div>
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

							<script type="text/javascript">

							</script>

							<div style="clear:both"></div>
						</div>
					
			 	</div>
			 	<div class="col-sm-3 ColSm3">
			 		<div class="TripSidebar">
			 			<form action="javascript:void(0)" method="post" id="plantripform">
			 				<input type="hidden" name="CSRF_token" value="<?=@$_SESSION["CSRF_token"]?>" />			 				
			 			</form>
						<div class="GreenSidebarDiv RightBackground">
							<div class="SidebarTitle geolowercase"><?=l("yourdironmap")?></div>
							<div class="SidebarSmallMap text-center" id="SidebarSmallMap">
								MAP DIV
							</div>
							<div class="response"></div>
							<div class="SidebarDaysList">							
							</div>
							
							<div class="addd"></div>

							<div class="col-sm-12 padding_0">				        			
								<div class="IncuranceNewDiv"> 
									<input class="TripNewCheckbox" type="checkbox" id="insurance123" />
									<label for="insurance123">
										<div class="FreeIncurance">+ <?=l("freeinsurance")?></div>
									</label>
								</div>
							</div>
								
								
							
							<div class="TotalPriceDiv">
				        		<div class="col-sm-6">
				        			<div class="Title">
				        				<?=l("totalprice")?>:
				        			</div>
				        		</div>
				        		<div class="col-sm-6 text-right ">
				        			<div class="SumCount">
				        				<span class="gelprice">0</span>
				        				<span class="hoverprice"></span>
				        			</div>
																		
									
									<script>
										// $(document).ready(function() {
										// 	$ExchangeDropDown = $('.ExchangeDropDown');
										// 	$ExchangeDropDown.find("li").click(function() {
										// 		$caret = '<span class="caret"></span>';
										// 		$val = $(this).html();
										// 		$(".ExcButton").html($val + $caret)
										// 	});
										// });
									</script>
				        		</div>
 
								
				        		<div class="col-sm-12 pull-right text-center ">
				        			<?php 
                					if(isset($_SESSION["trip_user"])){
                					?>
					        			<div class="col-sm-12 padding_0">
					        				<a href="javascript:void(0)" class="GreenCircleButton_4 addPlanTripToCart btn-block" data-redirect="true" data-title="<?=l("message")?>"  data-successText="<?=l("welldone")?>"><?=l("buy")?></a>
					        			</div>
				        			<?php } ?>
				        			<div class="col-sm-12 padding_0">
				        				<a href="javascript:void(0)" class="GreenCircleButton_4 addPlanTripToCart btn-block" data-redirect="false" data-title="<?=l("message")?>"  data-successText="<?=l("welldone")?>"><?=l("addtocart")?>
				        				</a>
				        			</div>
				        		</div>
				        	</div>

				        	
						</div>
			 		</div>
			 	</div>
	 		</div> 
		</div>
	</div>
</div>

<script type="text/javascript">
var VAR_DAY = "<?=l("days")?>";
$(document).ready(function(){// check price
	<?php 
	$triger = (isset($_GET['triger'])) ? $_GET['triger'] : '';
	$triger = explode(",", $triger);
	if(count($triger)){
		foreach ($triger as $v) {
			if($v!=""){
				echo '$("#'.$v.'").trigger("click");';
			}
		}
	}
	?>

	$(".guestsN").keyup(function(e){
		if(parseInt($(this).val()) <= 0){
			$(this).val("1");
			return false;
		}

		if(parseInt($(this).val()) >= 101){
			$(this).val("100");
			return false;
		}
	});

	$(".guestsN-mobile").keyup(function(e){
		if(parseInt($(this).val()) <= 0){
			$(this).val("1");
			return false;
		}

		if(parseInt($(this).val()) >= 101){
			$(this).val("100");
			return false;
		}
	});
});
</script>


<?php 
$plannerPrices = [];
foreach($Transport as $tra){
	if($tra["id"]==125){ //sedani
		$plannerPrices["sedan"]["p_planner_0_50"] = $tra["p_planner_0_50"];
		$plannerPrices["sedan"]["p_planner_50_100"] = $tra["p_planner_50_100"];
		$plannerPrices["sedan"]["p_planner_100_150"] = $tra["p_planner_100_150"];
		$plannerPrices["sedan"]["p_planner_150_200"] = $tra["p_planner_150_200"];
		$plannerPrices["sedan"]["p_planner_200_250"] = $tra["p_planner_200_250"];
		$plannerPrices["sedan"]["p_planner_250_300"] = $tra["p_planner_250_300"];
		$plannerPrices["sedan"]["p_planner_300_350"] = $tra["p_planner_300_350"];
		$plannerPrices["sedan"]["p_planner_350_400"] = $tra["p_planner_350_400"];
		$plannerPrices["sedan"]["p_planner_400_plus"] = $tra["p_planner_400_plus"];
		$plannerPrices["sedan"]["p_planner_max_crowd"] = $tra["p_planner_max_crowd"];
		$plannerPrices["sedan"]["income_proc"] = $tra["p_planner_income_proc"];
	}else if($tra["id"]==126){ //minivan
		$plannerPrices["minivan"]["p_planner_0_50"] = $tra["p_planner_0_50"];
		$plannerPrices["minivan"]["p_planner_50_100"] = $tra["p_planner_50_100"];
		$plannerPrices["minivan"]["p_planner_100_150"] = $tra["p_planner_100_150"];
		$plannerPrices["minivan"]["p_planner_150_200"] = $tra["p_planner_150_200"];
		$plannerPrices["minivan"]["p_planner_200_250"] = $tra["p_planner_200_250"];
		$plannerPrices["minivan"]["p_planner_250_300"] = $tra["p_planner_250_300"];
		$plannerPrices["minivan"]["p_planner_300_350"] = $tra["p_planner_300_350"];
		$plannerPrices["minivan"]["p_planner_350_400"] = $tra["p_planner_350_400"];
		$plannerPrices["minivan"]["p_planner_400_plus"] = $tra["p_planner_400_plus"];
		$plannerPrices["minivan"]["p_planner_max_crowd"] = $tra["p_planner_max_crowd"];
		$plannerPrices["minivan"]["income_proc"] = $tra["p_planner_income_proc"];
	}else if($tra["id"]==127){ //minibus
		$plannerPrices["minibus"]["p_planner_0_50"] = $tra["p_planner_0_50"];
		$plannerPrices["minibus"]["p_planner_50_100"] = $tra["p_planner_50_100"];
		$plannerPrices["minibus"]["p_planner_100_150"] = $tra["p_planner_100_150"];
		$plannerPrices["minibus"]["p_planner_150_200"] = $tra["p_planner_150_200"];
		$plannerPrices["minibus"]["p_planner_200_250"] = $tra["p_planner_200_250"];
		$plannerPrices["minibus"]["p_planner_250_300"] = $tra["p_planner_250_300"];
		$plannerPrices["minibus"]["p_planner_300_350"] = $tra["p_planner_300_350"];
		$plannerPrices["minibus"]["p_planner_350_400"] = $tra["p_planner_350_400"];
		$plannerPrices["minibus"]["p_planner_400_plus"] = $tra["p_planner_400_plus"];
		$plannerPrices["minibus"]["p_planner_max_crowd"] = $tra["p_planner_max_crowd"];
		$plannerPrices["minibus"]["income_proc"] = $tra["p_planner_income_proc"];
	}else if($tra["id"]==220){ //bus
		$plannerPrices["bus"]["p_planner_0_50"] = $tra["p_planner_0_50"];
		$plannerPrices["bus"]["p_planner_50_100"] = $tra["p_planner_50_100"];
		$plannerPrices["bus"]["p_planner_100_150"] = $tra["p_planner_100_150"];
		$plannerPrices["bus"]["p_planner_150_200"] = $tra["p_planner_150_200"];
		$plannerPrices["bus"]["p_planner_200_250"] = $tra["p_planner_200_250"];
		$plannerPrices["bus"]["p_planner_250_300"] = $tra["p_planner_250_300"];
		$plannerPrices["bus"]["p_planner_300_350"] = $tra["p_planner_300_350"];
		$plannerPrices["bus"]["p_planner_350_400"] = $tra["p_planner_350_400"];
		$plannerPrices["bus"]["p_planner_400_plus"] = $tra["p_planner_400_plus"];
		$plannerPrices["bus"]["p_planner_max_crowd"] = $tra["p_planner_max_crowd"];
		$plannerPrices["bus"]["income_proc"] = $tra["p_planner_income_proc"];
	}
}
?>
<script type="text/javascript">
	var plannerPrices = {
		sedan:{
			p_planner_0_50:parseFloat("<?=(float)$plannerPrices['sedan']['p_planner_0_50']?>"),
			p_planner_50_100:parseFloat("<?=(float)$plannerPrices['sedan']['p_planner_50_100']?>"),
			p_planner_100_150:parseFloat("<?=(float)$plannerPrices['sedan']['p_planner_100_150']?>"),
			p_planner_150_200:parseFloat("<?=(float)$plannerPrices['sedan']['p_planner_150_200']?>"),
			p_planner_200_250:parseFloat("<?=(float)$plannerPrices['sedan']['p_planner_200_250']?>"),
			p_planner_250_300:parseFloat("<?=(float)$plannerPrices['sedan']['p_planner_250_300']?>"),
			p_planner_300_350:parseFloat("<?=(float)$plannerPrices['sedan']['p_planner_300_350']?>"),
			p_planner_350_400:parseFloat("<?=(float)$plannerPrices['sedan']['p_planner_350_400']?>"),
			p_planner_400_plus:parseFloat("<?=(float)$plannerPrices['sedan']['p_planner_400_plus']?>"),
			p_planner_max_crowd:parseFloat("<?=(float)$plannerPrices['sedan']['p_planner_max_crowd']?>"),
			income_proc:parseFloat("<?=(float)$plannerPrices['sedan']['income_proc']?>")
		},
		minivan:{
			p_planner_0_50:parseFloat("<?=(float)$plannerPrices['minivan']['p_planner_0_50']?>"),
			p_planner_50_100:parseFloat("<?=(float)$plannerPrices['minivan']['p_planner_50_100']?>"),
			p_planner_100_150:parseFloat("<?=(float)$plannerPrices['minivan']['p_planner_100_150']?>"),
			p_planner_150_200:parseFloat("<?=(float)$plannerPrices['minivan']['p_planner_150_200']?>"),
			p_planner_200_250:parseFloat("<?=(float)$plannerPrices['minivan']['p_planner_200_250']?>"),
			p_planner_250_300:parseFloat("<?=(float)$plannerPrices['minivan']['p_planner_250_300']?>"),
			p_planner_300_350:parseFloat("<?=(float)$plannerPrices['minivan']['p_planner_300_350']?>"),
			p_planner_350_400:parseFloat("<?=(float)$plannerPrices['minivan']['p_planner_350_400']?>"),
			p_planner_400_plus:parseFloat("<?=(float)$plannerPrices['minivan']['p_planner_400_plus']?>"),
			p_planner_max_crowd:parseFloat("<?=(float)$plannerPrices['minivan']['p_planner_max_crowd']?>"),
			income_proc:parseFloat("<?=(float)$plannerPrices['minivan']['income_proc']?>")
		},
		minibus:{
			p_planner_0_50:parseFloat("<?=(float)$plannerPrices['minibus']['p_planner_0_50']?>"),
			p_planner_50_100:parseFloat("<?=(float)$plannerPrices['minibus']['p_planner_50_100']?>"),
			p_planner_100_150:parseFloat("<?=(float)$plannerPrices['minibus']['p_planner_100_150']?>"),
			p_planner_150_200:parseFloat("<?=(float)$plannerPrices['minibus']['p_planner_150_200']?>"),
			p_planner_200_250:parseFloat("<?=(float)$plannerPrices['minibus']['p_planner_200_250']?>"),
			p_planner_250_300:parseFloat("<?=(float)$plannerPrices['minibus']['p_planner_250_300']?>"),
			p_planner_300_350:parseFloat("<?=(float)$plannerPrices['minibus']['p_planner_300_350']?>"),
			p_planner_350_400:parseFloat("<?=(float)$plannerPrices['minibus']['p_planner_350_400']?>"),
			p_planner_400_plus:parseFloat("<?=(float)$plannerPrices['minibus']['p_planner_400_plus']?>"),
			p_planner_max_crowd:parseFloat("<?=(float)$plannerPrices['minibus']['p_planner_max_crowd']?>"),
			income_proc:parseFloat("<?=(float)$plannerPrices['minibus']['income_proc']?>")
		},
		bus:{
			p_planner_0_50:parseFloat("<?=(float)$plannerPrices['bus']['p_planner_0_50']?>"),
			p_planner_50_100:parseFloat("<?=(float)$plannerPrices['bus']['p_planner_50_100']?>"),
			p_planner_100_150:parseFloat("<?=(float)$plannerPrices['bus']['p_planner_100_150']?>"),
			p_planner_150_200:parseFloat("<?=(float)$plannerPrices['bus']['p_planner_150_200']?>"),
			p_planner_200_250:parseFloat("<?=(float)$plannerPrices['bus']['p_planner_200_250']?>"),
			p_planner_250_300:parseFloat("<?=(float)$plannerPrices['bus']['p_planner_250_300']?>"),
			p_planner_300_350:parseFloat("<?=(float)$plannerPrices['bus']['p_planner_300_350']?>"),
			p_planner_350_400:parseFloat("<?=(float)$plannerPrices['bus']['p_planner_350_400']?>"),
			p_planner_400_plus:parseFloat("<?=(float)$plannerPrices['bus']['p_planner_400_plus']?>"),
			p_planner_max_crowd:parseFloat("<?=(float)$plannerPrices['bus']['p_planner_max_crowd']?>"),
			income_proc:parseFloat("<?=(float)$plannerPrices['bus']['income_proc']?>")
		}
	};
</script>

<!-- <script type="text/javascript" src="_website/js/planner.js?v=<?=WEBSITE_VERSION?>"></script> -->
<script type="text/javascript" src="_website/js/plan.compressed.js?v=<?=WEBSITE_VERSION?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeSTjMJTVIuJaIiFgxLQgvCRl8HJqo0qo&amp;callback=initMap"></script>

<script type="text/javascript">
	$(document).ready(function(){
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		 	//$("select").replaceWith("<div>select multiple repleced!</div>");
		}
	});
</script>