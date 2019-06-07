<?php defined('DIR') OR exit; ?>
<div class="HomeGeorgianMap">
	<div class="container">
		<div id="image_map" style=""></div>
		<div class="MapInfoBottomDiv">
			<div class="col-sm-4">
				<div class="Item">
					<span id="locCount1" class="NumberCount">0</span>
					<label>
						<?php
					//l("location")
					echo menu_title(110);
					?>
					</label>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="Item">
					<span id="locCount2" class="NumberCount">0</span>
					<label><?php
					//l("tours")
					echo menu_title(63);
					?></label>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="Item">
					<span id="locCount3" class="NumberCount">0</span>
					<label><?php
					//l("sight")
					echo menu_title(83);
					?></label>
				</div>
			</div>
		</div>		
	</div>
</div>

<script type="text/javascript">
function animateValue(id, start, end, duration) {
    var range = end - start;
    var current = start;
    var increment = end > start? 1 : -1;
    var stepTime = Math.abs(Math.floor(duration / range));
    var obj = document.getElementById(id);
    var timer = setInterval(function() {
        current += increment;
        obj.innerHTML = current;
        if (current == end) {
            clearInterval(timer);
        }
    }, stepTime);
}
<?php $g_homepage_counts = g_homepage_counts(); ?>
animateValue("locCount1", 0, <?=(isset($g_homepage_counts["locations"])) ? $g_homepage_counts["locations"] : 0?>, 1000);
animateValue("locCount2", 0, <?=(isset($g_homepage_counts["tours"])) ? $g_homepage_counts["tours"] : 0?>, 1000);
animateValue("locCount3", 0, <?=(isset($g_homepage_counts["regions"])) ? $g_homepage_counts["regions"] : 0?>, 1000);
</script>





<div class="ToursListDiv">
	<div class="container">
		<h3 class="PageTitle">
			<label><?=l("toptours")?></label> <span><?=l("toptours")?></span>
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
							<div class="Background" style="background:url('https://tripplanner.ge/image.php?f=<?=$item['image1']?>&w=350&h=280');"></div>
							<!-- <div class="UserCount"><span>7</span></div> -->
						</div>
						<div class="BottomInfo" onclick="location.href='<?=str_replace(array('"',"'"," "),"",$link)?>'">
							<div class="Title"><?=g_cut($item['title'], 40)?></div>
							<?php if(isset($item['day_count'])){ ?>
							<div class="Day"><?=$item['day_count']?> <?=($item['day_count']<=1) ? l("days") : l("daysm")?></div>
							<?php }else{ ?>
								<div class="Day">0 <?=l("daysm")?></div>
							<?php } ?>
							<!-- <div class="Price">Package Price: <span>500 <i>A</i></span></div>-->
						</div>
						<div class="Buttons">
							<a href="<?=str_replace(array('"',"'"," "),"",$link)?>" style="width:100%"> <?=l("more")?></a>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="col-sm-12 text-center">
			<a href="/<?=l()?>/ongoing-tours" class="GreenCircleButton_2"><?=l("viewall")?></a>
		</div>
	</div>
</div>	










<div class="HomeFullInfoDiv">
	<div class="container-fluid padding_0">
		
		<div class="RightDiv">
			<h3 class="PageTitle">
				<label><?php echo menu_title('64');?></label> <span><?php echo menu_title('64');?></span>
			</h3>
			<div class="Background" style="background:url('https://tripplanner.ge/image.php?f=<?=imagen('64')?>&w=700&h=370');"></div>
		</div>
		<div class="LeftDiv">
			<div class="container">
				<?php echo text('64');?>
			</div>
		</div>
	</div>
</div>










<div class="ToursListDiv">
	<div class="container">
		<h3 class="PageTitle">
			<label><?=l("topoffers")?></label> <span><?=l("topoffers")?></span>
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
							<div class="Background" style="background:url('https://tripplanner.ge/image.php?f=<?=$item['image1']?>&w=350&h=280');"></div>
							<!-- <div class="UserCount"><span>7</span></div> -->
						</div>
						<div class="BottomInfo" onclick="location.href='<?=str_replace(array('"',"'"," "),"",$link)?>'">
							<div class="Title"><?=g_cut($item['title'], 40)?></div>
							<div class="Day"><?=$item['day_count']?> <?=($item['day_count']<=1) ? l("days") : l("daysm")?></div>
							<!-- <div class="Price">Package Price: <span>500 <i>A</i></span></div>-->
						</div>
						<div class="Buttons">
							<a href="<?=str_replace(array('"',"'"," "),"",$link)?>" style="width:100%"><?=l("more")?></a>
						</div>
					</div>
				</div>
				<?php endforeach; ?>				
			</div>
		</div>
		
	</div>
</div>








<div class="HomeFullInfoDiv_2">
	<div class="container-fluid padding_0">	 
		<h3 class="PageTitle">
			<label><?php echo menu_title('124');?></label> <span><?php echo menu_title('124');?></span>
		</h3> 
		<div class="RightDiv">			
			<div class="Background" style="background:url('https://tripplanner.ge/image.php?f=<?=imagen('124')?>&w=700&h=450');"></div>
		</div>
		<div class="LeftDiv">
			<div class="container">
				<?php echo desc('124');?>

				<a href="<?php echo href('124');?>" class="GreenCircleButton_3"><?php echo l('more');?></a>
			</div>
		</div>
	</div>
</div>










<div class="SightsListDiv">
	<div class="container">
		<h3 class="PageTitle">
			<label><?=menu_title(141)?></label> <span><?=menu_title(141)?></span>
		</h3>
		<div class="SightsList" data-loadedLimit="4">
			<div class="row">
				<?php foreach(g_places(false, false, "`position` ASC", "LIMIT 0, 4", 47) as $sight): 

					$link = href(141, array(), l(), $sight['id']);?>
				<div class="col-sm-6">
					<a href="<?=$link?>" class="Item">
						<div class="Background" style="background:url('https://tripplanner.ge/image.php?f=<?=$sight['image1']?>&w=600&h=400');"></div>
						<div class="Title"><?=$sight['title']?></div>
					</a>
				</div>
				<?php endforeach; ?>
			</div>
		</div>		
		<div class="col-sm-12 text-center">
			<a href="javascript:void(0)" class="GreenCircleButton_2 loadmoreSights"><?php echo l('loadmore');?></a>
		</div>
	</div>
</div>









<div class="BlogListDiv">
	<div class="container">
		<h3 class="PageTitle">
			<label><?=l("blog")?></label> <span><?=l("blog")?></span>
		</h3>
		<div class="BlogList">
			<div class="row">
				<?=news()?>
			</div>

			<div class="col-sm-12 text-center">
			<a href="/<?=l()?>/blog" class="GreenCircleButton_2"><?=l("more")?></a>
		</div>
		</div>	
	</div>
</div>






<div class="PartnersListDiv">
	<div class="container">
		<h3 class="PageTitle">
			<label><?=menu_title(138)?></label> <span><?=menu_title(138)?></span>
		</h3>
		<div class="PartnersList"> 
			<?=g_image_gallery_home()?>
		</div>	
	</div>
</div>
