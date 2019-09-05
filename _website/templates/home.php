<?php defined('DIR') OR exit; ?>
<?php 
$g_gift = g_gift();
if($g_gift["menutitle"]==1):
?>
 <div class="modal fade TripModalStyle giftpopup" id="giftpopup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-body" style="background-color: transparent !important;">
        		<div class="popupStyle" style="background-image: url('<?=$g_gift["image1"]?>');"></div>
            </div> 
        </div>
    </div>
</div>
<!--<div class="gift" onclick="$('#giftpopup').modal('show')"></div> -->

<div class="gift2 transition">
	<div class="badgeImage" style="background-image: url('<?=$g_gift["image1"]?>');"></div>
	<div class="badgex"></div>
	<div class="badgeText"><?=l("offer")?></div>
</div>

<script type="text/javascript">
	window.mobileAndTabletcheck = function() {
  		var check = false;
		(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
	  return check;
	};
	(function(){
		var gift_opened = false;
		var gift = document.getElementsByClassName("gift2")[0];
		gift.addEventListener("click", (e) => {
			if(mobileAndTabletcheck() != true){
				if(gift_opened){
					gift.style.left = "0px";
					gift_opened = false;
				}else{
					gift.style.left = "460px";
					gift_opened = true;
				}
			}else{
				$(".giftpopup").modal("show");
			}
		});
	})();	
</script>
<?php endif; ?>

<div class="newScroller">
	<span></span>
	<!-- <span></span>
	<span></span> -->
</div>
<script>
	document.getElementsByClassName("newScroller")[0].addEventListener("click", () => {
	var elmnt = document.getElementsByClassName("ToursListDiv")[0];
	elmnt.scrollIntoView();
});
</script>

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
							<div class="Background g-load-after" data-imgurl="https://tripplanner.ge/image.php?f=<?=$item['image1']?>&w=350&h=280"></div>
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
							<div class="Background g-load-after" data-imgurl="https://tripplanner.ge/image.php?f=<?=$item['image1']?>&w=350&h=280"></div>
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
						<div class="Background g-load-after" data-imgurl="https://tripplanner.ge/image.php?f=<?=$sight['image1']?>&w=600&h=400"></div>
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

<script>
(function(){
	if(typeof document.getElementsByClassName("g-load-after")[0] !== "undefined"){
        var loadafter = document.getElementsByClassName("g-load-after");
        
        setTimeout(function(){
        	for(var x = 0; x < loadafter.length; x++){
            	if(typeof document.getElementsByClassName("g-load-after")[x] !== "undefined"){
			    	var img = document.getElementsByClassName("g-load-after")[x].getAttribute("data-imgurl");
			    	document.getElementsByClassName("g-load-after")[x].style.background = "url('"+img+"')";
			    	document.getElementsByClassName("g-load-after")[x].classList.add("g-all-done");
				}

            };
        },13000);
    };
})();
</script>