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
            </div>
          </div>  
        </div>
        <!-- \\ side \\ -->
        
      </div>
      <div class="two-colls-right">
        <div class="two-colls-right-b">
          <div class="padding">
            <div class="catalog-row alternative">
				<div class="fly-in mp-popular-row">
<?php foreach($audios as $a) : ?>					
					<div class="flat-adv large">
						<div class="blog-masonry-audio">
							<audio src="<?php echo $a["link"];?>" controls="controls"></audio>
						</div>
						<div class="offer-slider-txt audio-txt">
							<div class="offer-slider-link"><a style="display:block; float:left;" nohref=""><?php echo $a["title"];?></a><a style="display:block; float:right;" href="<?php echo $a["link"];?>" target="_blank">ჩამოტვირთეთ</a></div>
							<div class="clear"></div>
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
<?php endforeach; ?>
            	</div>
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
    
</div>
<!-- /main-cont -->
<?php require("_website/templates/widgets/popular.php");?>
