<?php defined('DIR') OR exit; ?>
<!-- main-cont -->
<?php if(count($videos)==0) : ?>
<div class="main-cont">
  <div class="body-wrapper">
    <div class="page-head">
    	 <div class="wrapper-padding">
		      <div class="page-title"><?php echo $title;?></div>
		      <div class="clear"></div>
	     </div>
    </div>
    <div class="wrapper-padding">
<?php else : ?>
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
            </div>
          </div>  
        </div>
        <!-- \\ side \\ -->
        
      </div>
      <div class="two-colls-right">
        <div class="two-colls-right-b">
          <div class="padding">
            <div class="catalog-row alternative">
<?php foreach($videos as $a) : ?>					
            	<div class="flat-adv large">
					<div class="offer-slider-i">
						<a class="offer-slider-img" href="<?php echo href(22)."?v=".$a["id"];?>" style="height:220px;">
							<img alt="" src="<?php echo $a["image1"];?>" />
							<span class="offer-slider-overlay">
								<span class="offer-slider-btn">დეტალურად</span>
							</span>
						</a>
						<div class="offer-slider-txt">
							<div class="offer-slider-link"><a href="<?php echo href(22)."?v=".$a["id"];?>"><?php echo $a["title"];?></a></div>
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
<?php endforeach; ?>
            </div>
            
            <div class="clear"></div>
<!--            
            <div class="pagination">
              <a class="active" href="#">1</a>
              <a href="#">2</a>
              <a href="#">3</a>
              <div class="clear"></div>
            </div>            
-->
          </div>
        </div>
        <br class="clear" />
      </div>
    </div>
    <div class="clear"></div>
    </div>	
  </div>
<?php endif; ?>    
</div>
<!-- /main-cont -->
<?php require("_website/templates/widgets/popular.php");?>
