<?php defined('DIR') OR exit; ?>
<div class="HomeGeorgianMap">
	<div class="container">
		<div id="image_map" style=""></div>
		<div class="MapInfoBottomDiv">
			<div class="col-sm-4">
				<div class="Item">
					<span data-count="80" class="NumberCount">80</span>
					<label>location</label>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="Item">
					<span data-count="1500" class="NumberCount">1500</span>
					<label>Tour</label>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="Item">
					<span data-count="100" class="NumberCount">100</span>
					<label>Sight</label>
				</div>
			</div>
		</div>		
	</div>
</div>





<div class="ToursListDiv">
	<div class="container">
		<div class="ModalsOpenLinks">
			<div data-toggle="modal" data-target="#ErrorModal">Error</div>
			<div data-toggle="modal" data-target="#SuccessModal">Success</div>
			<div data-toggle="modal" data-target="#PromptModal">Need Hotel</div>
			<div data-toggle="modal" data-target="#SearchModal">Search</div>
			<div data-toggle="modal" data-target="#HomeMapModal">MapModal</div>
		</div>
		<h3 class="PageTitle">
			<label>top tours</label> <span>Top Tours</span>
		</h3>
		<div class="ToursList">
			<div class="row">				
				<?php 
				foreach (g_homepage_tours(true, false) as $item):
					$link = href(63,array(), l(), $item['id']);
				?>
				<div class="col-sm-3">
					<div class="Item">
						<div class="TopInfo" onclick="location.href='<?=str_replace(array('"',"'"," "),"",$link)?>'">
							<div class="Background" style="background:url('<?=$item['image1']?>');"></div>
							<!-- <div class="UserCount"><span>7</span></div> -->
						</div>
						<div class="BottomInfo" onclick="location.href='<?=str_replace(array('"',"'"," "),"",$link)?>'">
							<div class="Title"><?=g_cut($item['title'], 40)?></div>
							<div class="Day"><?=$item['day_count']?> day</div>
							<!-- <div class="Price">Package Price: <span>500 <i>A</i></span></div>-->
						</div>
						<div class="Buttons">
							<a href="javascript:void(0)" class="addCart<?=(!empty($item['cartId'])) ? ' active' : ''?>" data-id="<?=$item['id']?>" data-title="<?=l("wrongmessage")?>" data-errortext="<?=l("error")?>"><span class="CartIcon"></span> Add To Cart</a>
							<a href="<?=str_replace(array('"',"'"," "),"",$link)?>"><span class="WishListIcon"></span> More</a>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="col-sm-12 text-center">
			<a href="/<?=l()?>/ongoing-tours" class="GreenCircleButton_2">View All</a>
		</div>
	</div>
</div>	










<div class="HomeFullInfoDiv">
	<div class="container-fluid padding_0">
		
		<div class="RightDiv">
			<h3 class="PageTitle">
				<label>about us</label> <span>About Us</span>
			</h3>
			<div class="Background" style="background:url('_website/img/home_1.png');"></div>
		</div>
		<div class="LeftDiv">
			<div class="container">
				<p>Thousands of architectural and historical cultural monuments are scattered on the territory of Georgia. The vast majority of them is unique in the world and is included in the world treasury. Georgia is considered to be a classical country of monuments, where the monument and the surrounding landscape are indivisible parts.</p>
				<p>Thanks to the special geographical location of Georgia, the country is beautiful because of natural diversity too: alpine zones, the sea, unique mountains, natural reserves, canyons, caves and lakes is an incomplete list when talking about Georgia.</p>
				<p>Tourist zones, where it is possible to do some extreme sports, make the idea of travelling to Georgia more attractive.</p> 
			</div>
		</div>
	</div>
</div>










<div class="ToursListDiv">
	<div class="container">
		<h3 class="PageTitle">
			<label>top offers</label> <span>Top Offers</span>
		</h3>
		<div class="ToursList">
			<div class="row">	
				<?php 
				foreach (g_homepage_tours(false, true) as $item):
					$link = href(63,array(), l(), $item['id']);
				?>
				<div class="col-sm-3">
					<div class="Item">
						<div class="TopInfo" onclick="location.href='<?=str_replace(array('"',"'"," "),"",$link)?>'">
							<!-- <div class="RatingStars">
								<span class="fa fa-star-o" data-rating="1"></span>
								<span class="fa fa-star-o" data-rating="2"></span>
								<span class="fa fa-star-o" data-rating="3"></span>
								<span class="fa fa-star-o" data-rating="4"></span>
								<span class="fa fa-star-o" data-rating="5"></span>
								<input type="hidden" name="whatever1" class="rating-value" value="3">
							</div> -->
							<div class="Background" style="background:url('<?=$item['image1']?>');"></div>
							<!-- <div class="UserCount"><span>7</span></div> -->
						</div>
						<div class="BottomInfo" onclick="location.href='<?=str_replace(array('"',"'"," "),"",$link)?>'">
							<div class="Title"><?=g_cut($item['title'], 40)?></div>
							<div class="Day"><?=$item['day_count']?> day</div>
							<!-- <div class="Price">Package Price: <span>500 <i>A</i></span></div>-->
						</div>
						<div class="Buttons">
							<a href="javascript:void(0)" class="addCart<?=(!empty($item['cartId'])) ? ' active' : ''?>" data-id="<?=$item['id']?>" data-title="<?=l("wrongmessage")?>" data-errortext="<?=l("error")?>"><span class="CartIcon"></span> Add To Cart</a>
							<a href="<?=str_replace(array('"',"'"," "),"",$link)?>"><span class="WishListIcon"></span> More</a>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
				<!-- <div class="col-sm-3">
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
				</div>	 -->			
				
			</div>
		</div>
		<div class="col-sm-12 text-center">
			<a href="#" class="GreenCircleButton_2">View All</a>
		</div>
	</div>
</div>








<div class="HomeFullInfoDiv_2">
	<div class="container-fluid padding_0">	 
		<h3 class="PageTitle">
			<label>who us?</label> <span>Who Us?</span>
		</h3> 
		<div class="RightDiv">			
			<div class="Background" style="background:url('_website/img/home_1.png');"></div>
		</div>
		<div class="LeftDiv">
			<div class="container">
				<p>Thousands of architectural and historical cultural monuments are scattered on the territory of Georgia. The vast majority of them is unique in the world and is included in the world treasury. Georgia is considered to be a classical country of monuments, where the monument and the surrounding landscape are indivisible parts.</p>
				<p>Thanks to the special geographical location of Georgia, the country is beautiful because of natural diversity too: alpine zones, the sea, unique mountains, natural reserves, canyons, caves and lakes is an incomplete list when talking about Georgia.</p>
				<p>Tourist zones, where it is possible to do some extreme sports, make the idea of travelling to Georgia more attractive.</p>
				<p>Tripplanner.ge is space for people from around the world who are fond of travelling. Here you can discover virtual Georgia, which will greet you with vaunted Georgian hospitality and offer you guidance to discover real Georgia.</p>
				<p>The most valuable thing that we offer is an individual tour planning tool - the ability for each traveler to decide what they want to see, which route to choose and where to taste the Georgian dishes. As we know, the basic charm of travelling is the tremendous feeling of freedom.</p>
				<p>As it is said: "Not all those who wonder are lost".</p>

				<a href="#" class="GreenCircleButton_3">More</a>
			</div>
		</div>
	</div>
</div>










<div class="SightsListDiv">
	<div class="container">
		<h3 class="PageTitle">
			<label>sights</label> <span>Sights</span>
		</h3>
		<div class="SightsList">
			<div class="row">
				<div class="col-sm-6">
					<div class="Item">
						<div class="Background" style="background:url('_website/img/sights_1.png');"></div>
						<div class="Title">Batumi</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="Item">
						<div class="Background" style="background:url('_website/img/sights_2.png');"></div>
						<div class="Title">tbilisi</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="Item">
						<div class="Background" style="background:url('_website/img/sights_3.png');"></div>
						<div class="Title">yazbegi</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="Item">
						<div class="Background" style="background:url('_website/img/sights_4.png');"></div>
						<div class="Title">svaneti</div>
					</div>
				</div>
			</div>
		</div>		
		<div class="col-sm-12 text-center">
			<a href="#" class="GreenCircleButton_2">View All</a>
		</div>
	</div>
</div>









<div class="BlogListDiv">
	<div class="container">
		<h3 class="PageTitle">
			<label>blog</label> <span>Blog</span>
		</h3>
		<div class="BlogList">
			<div class="row">
				<div class="col-sm-3">
					<div class="Item">
						<div class="TopInfo">
							<div class="Background" style="background:url('_website/img/blog_1.png');"></div> 
							<div class="Date">12.10.2017</div>
						</div>
						<div class="BottomInfo">
							<div class="Title">One Day Tour In Yazbegi</div>  							
							<div class="Text">Tourist zones, where it is possible to do some extreme sports, make the idea</div>
						</div>
						<div class="Buttons">
							<a href="blog_inside.html">More</a> 
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="Item">
						<div class="TopInfo">
							<div class="Background" style="background:url('_website/img/blog_2.png');"></div> 
							<div class="Date">12.10.2017</div>
						</div>
						<div class="BottomInfo">
							<div class="Title">One Day Tour In Yazbegi</div>  							
							<div class="Text">Tourist zones, where it is possible to do some extreme sports, make the idea</div>
						</div>
						<div class="Buttons">
							<a href="blog_inside.html">More</a>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="Item">
						<div class="TopInfo">
							<div class="Background" style="background:url('_website/img/blog_3.png');"></div> 
							<div class="Date">12.10.2017</div>
						</div>
						<div class="BottomInfo">
							<div class="Title">One Day Tour In Yazbegi</div>  							
							<div class="Text">Tourist zones, where it is possible to do some extreme sports, make the idea</div>
						</div>
						<div class="Buttons">
							<a href="blog_inside.html">More</a>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="Item">
						<div class="TopInfo">
							<div class="Background" style="background:url('_website/img/blog_4.png');"></div> 
							<div class="Date">12.10.2017</div>
						</div>
						<div class="BottomInfo">
							<div class="Title">One Day Tour In Yazbegi</div>  							
							<div class="Text">Tourist zones, where it is possible to do some extreme sports, make the idea</div>
						</div>
						<div class="Buttons">
							<a href="blog_inside.html">More</a>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>






<div class="PartnersListDiv">
	<div class="container">
		<h3 class="PageTitle">
			<label>our partners</label> <span>Partners</span>
		</h3>
		<div class="PartnersList"> 
			<a href="#" target="_blank"><img src="_website/img/part_1.png"/></a>
			<a href="#" target="_blank"><img src="_website/img/part_2.png"/></a>
			<a href="#" target="_blank"><img src="_website/img/part_1.png"/></a>
			<a href="#" target="_blank"><img src="_website/img/part_2.png"/></a>
			<a href="#" target="_blank"><img src="_website/img/part_1.png"/></a>
			<a href="#" target="_blank"><img src="_website/img/part_2.png"/></a>
			<a href="#" target="_blank"><img src="_website/img/part_1.png"/></a>
			<a href="#" target="_blank"><img src="_website/img/part_2.png"/></a>
		</div>	
	</div>
</div>
