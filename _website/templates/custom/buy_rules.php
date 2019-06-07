<?php defined('DIR') OR exit; 


?>
<div class="InsidePagesHeader">
	<div class="Item" style="background:url('_website/img/trip_1.jpg');"></div> 
</div>
 
<div class="container">
 	<h3 class="PageTitle InsideTitle"><label><?php echo $title ?></label></h3>
 	<div class="row row0">
 		<div class="col s12">
 			<div class="Breadcrumb"> 
		 		<a href="/<?=l()?>/" class="Nolink"><?=menu_title(1)?></a>
		 			<span>></span>
		 		<a href="#"><?php echo $title ?></a>
			</div>
 		</div>
 	</div>
</div> 

<div class="AboutPageDiv">
	<div class="HomeFullInfoDiv">
		<div class="container-fluid padding_0">
			<div class="LeftDiv">
				<div class="container">
					<h4 class="ShowForMobile"><?php echo $title ?></h4>
					<div class="g-rule-content">
						<?php echo $content; ?>
					</div>
				</div>
			</div>
			<div class="RightDiv">
				<div class="container"> 
					<div class="Background" style="background:url('<?php echo $image1 ?>');"></div>
				</div>
			</div>
		</div>
	</div>
</div>