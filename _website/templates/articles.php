<?php defined('DIR') OR exit; ?>
<!-- main-cont -->
<div class="main-cont">
	<div class="body-wrapper">
		<div class="page-head">
			 <div class="wrapper-padding">
			      <div class="page-title"><?php echo $title;?></div>
			      <div class="clear"></div>
		     </div>
		</div>
		<div class="wrapper-padding">
		<div class="two-colls">
		  <div class="two-colls-left">

		    <!-- // side // -->
		    <div class="side-block fly-in">
		      <div class="side-stars">
		        <div class="side-padding">
		          <div class="side-lbl">კატეგორიები</div>
<?php 
	if($level==1) $t=$id; else $t=$masterid;
	$article_cats = db_fetch_all("select * from pages where language='".l()."' and masterid=".$t);
	foreach($article_cats as $a) :	
?>
		          <div class="checkbox">
		            <label>
		              <input type="checkbox" value="" onclick="goPage('<?php echo href($a["id"]);?>');"/>
		              <?php echo $a["title"];?>
		            </label>
		          </div> 
<?php 
	endforeach; 
?>
<script>
	function goPage(link) {
		location.href=link;
	}
</script>
		          <div class="checkbox all">
		            <label>
		              <input type="checkbox" value="" onclick="goPage('<?php echo href($t);?>');" />
		              ყველა
		            </label>
		          </div>
<?php if($t==9) : ?>	
				  <a href="<?php echo href(34); ?>" class="add-recipe-btn">რეცეპტის დამატება</a>
<?php endif; ?>
		        </div>
		      </div>  
		    </div>
		    <!-- \\ side \\ -->
		  </div>
		  <div class="two-colls-right">
		    <div class="two-colls-right-b">
		      <div class="padding">
		        <div class="catalog-row alternative">
<?php foreach($articles as $a) : ?>	
<?php if($t==6) : ?>
					<div class="flat-adv large">
						<div class="offer-slider-i">
							<a class="offer-slider-img" href="<?php echo href($a["id"]);?>" width="330" height="216"> 
								<img alt="" src="<?php echo ($a["image1"]!="") ? $a["image1"]:"_website/img/article1.jpg";?>">
								<span class="offer-slider-overlay" style="display: none;">
									<span class="offer-slider-btn" style="top: -200px;">დეტალურად</span>
								</span>
							</a>
							<div class="offer-slider-txt">
								<div class="offer-slider-link"><a href="<?php echo href($a["id"]);?>"><?php echo $a["title"];?></a></div>
								<div class="offer-slider-cat">
<?php
	$cat = db_fetch("select * from pages where language='".l()."' and menutype=".$a["menuid"]);
	echo $cat["title"];
?>
								</div>
								<div class="offer-slider-auth">
									<?php echo $a["author"];?>
								</div>						
								<div class="clear"></div>
							</div>
						</div>  
					</div>
<?php else : ?>
					<div class="flat-adv large">
						<div class="flat-adv-a">
							<div class="flat-adv-l">
								<a href="<?php echo href($a["id"]);?>"><img alt="" src="<?php echo ($a["image1"]!="") ? $a["image1"]:"_website/img/article1.jpg";?>" width="99" height="99"></a>
							</div>
							<div class="flat-adv-r">
								<div class="flat-adv-rb">
									<div class="flat-adv-b"><a href="<?php echo href($a["id"]);?>"><?php echo $a["title"];?></a></div>
									<div class="flat-adv-c">
										<?php echo $a["description"];?>
									</div>
									<a class="flat-adv-btn" href="<?php echo href($a["id"]);?>">დეტალურად</a>
								</div>
							</div>
						</div>
					</div>
<?php endif; ?>
<?php endforeach; ?>
			    </div>

		        <div class="clear"></div>
		        
<?php if($page_max>1) : ?>
		        <div class="pagination">
<?php for($i=1;$i<=$page_max;$i++) : ?>		          
		          <a href="<?php echo href($id).'?page='.$i;?>" <?php echo ($page_cur==$i) ? 'class="active"':'';?> ><?php echo $i;?></a>
<?php endfor; ?>
		          <div class="clear"></div>
		        </div>            
<?php endif;?>
		      </div>
		    </div>
		    <br class="clear" />
		  </div>
		</div>
		<div class="clear"></div>
		</div>	
	</div>
<?php require("_website/templates/widgets/popular.php");?>
</div>

