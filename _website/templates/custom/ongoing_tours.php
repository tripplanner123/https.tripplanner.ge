<?php defined('DIR') OR exit; ?>
<div class="InsidePagesHeader">
	<div class="Item" style="background:url('_website/img/trip_1.jpg');"></div>
	<div class="Item" style="background:url('_website/img/trip_2.jpg');"></div>
	<div class="Item" style="background:url('_website/img/trip_3.jpg');"></div>
	<div class="Item" style="background:url('_website/img/trip_4.jpg');"></div>
</div>

<div class="TripListPageDiv">
	<div class="TripListInsidePage"> 
		<div class="container">
		 	<h3 class="PageTitle InsideTitle"><label><?php echo $title ?></label></h3>
		 	<div class="row row0">
		 		<div class="col s12">
		 			<div class="Breadcrumb"> 
				 		<?php echo location();?>
					</div>
		 		</div>
		 	</div>

		 	<div class="FiltersDiv">
		 		<div class="row row0">
			 		<div class="AllToursButton">All Tours <div>150</div></div>
			 		<div class="col-sm-3">
			 			<div class="btn-group SearchFilterItem"> 
						    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
						    	<span class="Name1">Search By Categories</span>
						    	<label class="Name2 CatagoryName"><text>Museums</text></label>
						    </div>
						    <div class="dropdown-menu CategoriesDropDown"> 
					        	<div class="Item">
					        		<input class="TripCheckbox" type="checkbox" value="Museums" name="layout" id="Cat1" checked="">
									<label class="pull-left Text" for="Cat1">
										<div class="Info">
											<div class="Image Museums"></div>
											<div class="Title">Museums</div>
											<div class="Count">15</div>
										</div>
									</label> 
					        	</div>
					        	<div class="Item">
					        		<input class="TripCheckbox" type="checkbox" value="Natural Sights" name="layout" id="Cat2">
									<label class="pull-left Text" for="Cat2">
										<div class="Info">
											<div class="Image Natural"></div>
											<div class="Title">Museums</div>
											<div class="Count">15</div>
										</div>
									</label> 
					        	</div> 
					        	<div class="Item">
					        		<input class="TripCheckbox" type="checkbox" value="Cultural Sights" name="layout" id="Cat3">
									<label class="pull-left Text" for="Cat3">
										<div class="Info">
											<div class="Image Cultural"></div>
											<div class="Title">Museums</div>
											<div class="Count">15</div>
										</div>
									</label> 
					        	</div>
					        	<div class="Item">
					        		<input class="TripCheckbox" type="checkbox" value="Wine Tours" name="layout" id="Cat4">
									<label class="pull-left Text" for="Cat4">
										<div class="Info">
											<div class="Image WineTours"></div>
											<div class="Title">Museums</div>
											<div class="Count">15</div>
										</div>
									</label> 
					        	</div>
						    </div>
						</div>
			 		</div>
			 		<div class="col-sm-3">
			 			<div class="btn-group SearchFilterItem"> 
						    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
						    	<span class="Name1">Search By Location</span>
						    	<label class="Name2 LocationName InpueValue2"><text>Tbilisi</text></label>
						    </div>
						    <div class="dropdown-menu LocationDropDown LocationDropDown2"> 
					        	<div class="Item">
					        		<input class="TripCheckbox" type="checkbox" id="List1" value="Imereti">
									<label class="pull-left Text" for="List1">
										Imereti <span>15</span>
									</label> 
					        	</div> 
					        	<div class="Item">
					        		<input class="TripCheckbox" type="checkbox" id="List2" value="Adjara">
									<label class="pull-left Text" for="List2">
										Adjara
									</label> 
					        	</div>
					        	<div class="Item">
					        		<input class="TripCheckbox" type="checkbox" id="List3" value="Abkhazia">
									<label class="pull-left Text" for="List3">
										Abkhazia <span>15</span>
									</label> 
					        	</div>
					        	<div class="Item">
					        		<input class="TripCheckbox" type="checkbox" id="List4" value="Samegrelo">
									<label class="pull-left Text" for="List4">
										Samegrelo <span>5</span>
									</label> 
					        	</div>
					        	<div class="Item">
					        		<input class="TripCheckbox" type="checkbox" id="List5" value="Svaneti">
									<label class="pull-left Text" for="List5">
										Svaneti
									</label> 
					        	</div>
					        	<div class="Item">
					        		<input class="TripCheckbox" type="checkbox" id="List6" value="Tbilisi" checked="">
									<label class="pull-left Text" for="List6">
										Tbilisi
									</label> 
					        	</div>
					        	<div class="Item">
					        		<input class="TripCheckbox" type="checkbox" id="List7" value="Guria">
									<label class="pull-left Text" for="List7">
										Guria
									</label> 
					        	</div>
					        	<div class="Item">
					        		<input class="TripCheckbox" type="checkbox" id="List8"  value="yazbegi">
									<label class="pull-left Text" for="List8" >
										yazbegi
									</label> 
					        	</div>
						    </div>
						</div>
			 		</div>
			 		<div class="col-sm-3">
			 			<div class="btn-group SearchFilterItem"> 
						    <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
						    	<span>Search By Price</span>
						    	<label class="Name2 LocationName" for="List8" id="AmountLabelID"><label></label><i>A</i></label>
						    </div>
						    <div class="dropdown-menu PriceBox">
						        <div class=""> 
						            <div class="PriceSlider"> 
						            	<span>Price Range</span>
						                <div id="slider"></div>
						                <input type="hidden" id="amount" class="form-control">
				                        <p class="price lead" ></p>
						            </div>  
							    </div>
						    </div>
						</div>
			 		</div>
		 		</div>
		 	</div>



		 	<div class="FiltItemsDiv">
		 		<div class="row">
		 			<div class="col-sm-8">
			 			<div class="Item">Museums <div class="Remove"><i class="fa fa-times"></i></div></div>
				 		<div class="Item">Wine Tours <div class="Remove"><i class="fa fa-times"></i></div></div>
				 		<div class="Item">Tbilisi <div class="Remove"><i class="fa fa-times"></i></div></div>
				 		<div class="Item">2017-09-22 <div class="Remove"><i class="fa fa-times"></i></div></div>
				 		<div class="Item">500 <div class="Remove"><i class="fa fa-times"></i></div></div>
			 		</div>
			 		<div class="col-sm-4 text-right">
			 			<div class="SearchResultText">Search Results: <span>25</span></div>
			 		</div>
		 		</div>	
		 	</div>




		 	<div class="ToursListDiv">
				<div class=""> 
					<div class="ToursList">
						<div class="row">				
							<div class="col-sm-3">
								<div class="Item">
									<div class="TopInfo">
										<div class="Background" style="background:url('_website/img/tour_1.jpg');"></div>
										<div class="UserCount"><span>7</span></div>
									</div>
									<div class="BottomInfo">
										<div class="Title">One Day Tour In Yazbegi</div>
										<div class="Day">1 day</div>
										<div class="Price">Package Price: <span>500 <i>A</i></span></div>							
									</div>
									<div class="Buttons">
										<a href="#"><span class="CartIcon"></span> Add To Cart</a>
										<a href="#"><span class="WishListIcon"></span> Add To WishList</a>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="Item">
									<div class="TopInfo">
										<div class="Background" style="background:url('_website/img/tour_2.jpg');"></div>
										<div class="UserCount"><span>7</span></div>
									</div>
									<div class="BottomInfo">
										<div class="Title">One Day Tour In Yazbegi</div>
										<div class="Day">1 day</div>
										<div class="Price">Package Price: <span>500 <i>A</i></span></div>							
									</div>
									<div class="Buttons">
										<a href="#"><span class="CartIcon"></span> Add To Cart</a>
										<a href="#"><span class="WishListIcon"></span> Add To WishList</a>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="Item">
									<div class="TopInfo">
										<div class="Background" style="background:url('_website/img/tour_3.jpg');"></div>
										<div class="UserCount"><span>7</span></div>
									</div>
									<div class="BottomInfo">
										<div class="Title">One Day Tour In Yazbegi</div>
										<div class="Day">1 day</div>
										<div class="Price">Package Price: <span>500 <i>A</i></span></div>							
									</div>
									<div class="Buttons">
										<a href="#"><span class="CartIcon"></span> Add To Cart</a>
										<a href="#"><span class="WishListIcon"></span> Add To WishList</a>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="Item">
									<div class="TopInfo">
										<div class="Background" style="background:url('_website/img/tour_4.jpg');"></div>
										<div class="UserCount"><span>7</span></div>
									</div>
									<div class="BottomInfo">
										<div class="Title">One Day Tour In Yazbegi</div>
										<div class="Day">1 day</div>
										<div class="Price">Package Price: <span>500 <i>A</i></span></div>							
									</div>
									<div class="Buttons">
										<a href="#"><span class="CartIcon"></span> Add To Cart</a>
										<a href="#"><span class="WishListIcon"></span> Add To WishList</a>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="Item">
									<div class="TopInfo">
										<div class="Background" style="background:url('_website/img/tour_1.jpg');"></div>
										<div class="UserCount"><span>7</span></div>
									</div>
									<div class="BottomInfo">
										<div class="Title">One Day Tour In Yazbegi</div>
										<div class="Day">1 day</div>
										<div class="Price">Package Price: <span>500 <i>A</i></span></div>							
									</div>
									<div class="Buttons">
										<a href="#"><span class="CartIcon"></span> Add To Cart</a>
										<a href="#"><span class="WishListIcon"></span> Add To WishList</a>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="Item">
									<div class="TopInfo">
										<div class="Background" style="background:url('_website/img/tour_2.jpg');"></div>
										<div class="UserCount"><span>7</span></div>
									</div>
									<div class="BottomInfo">
										<div class="Title">One Day Tour In Yazbegi</div>
										<div class="Day">1 day</div>
										<div class="Price">Package Price: <span>500 <i>A</i></span></div>							
									</div>
									<div class="Buttons">
										<a href="#"><span class="CartIcon"></span> Add To Cart</a>
										<a href="#"><span class="WishListIcon"></span> Add To WishList</a>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="Item">
									<div class="TopInfo">
										<div class="Background" style="background:url('_website/img/tour_3.jpg');"></div>
										<div class="UserCount"><span>7</span></div>
									</div>
									<div class="BottomInfo">
										<div class="Title">One Day Tour In Yazbegi</div>
										<div class="Day">1 day</div>
										<div class="Price">Package Price: <span>500 <i>A</i></span></div>							
									</div>
									<div class="Buttons">
										<a href="#"><span class="CartIcon"></span> Add To Cart</a>
										<a href="#"><span class="WishListIcon"></span> Add To WishList</a>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="Item">
									<div class="TopInfo">
										<div class="Background" style="background:url('_website/img/tour_4.jpg');"></div>
										<div class="UserCount"><span>7</span></div>
									</div>
									<div class="BottomInfo">
										<div class="Title">One Day Tour In Yazbegi</div>
										<div class="Day">1 day</div>
										<div class="Price">Package Price: <span>500 <i>A</i></span></div>							
									</div>
									<div class="Buttons">
										<a href="#"><span class="CartIcon"></span> Add To Cart</a>
										<a href="#"><span class="WishListIcon"></span> Add To WishList</a>
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