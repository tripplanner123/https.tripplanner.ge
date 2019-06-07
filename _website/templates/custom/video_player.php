<?php defined('DIR') OR exit; ?>
<!-- main-cont -->
<div class="main-cont">
  <div class="body-wrapper">
    <div class="page-head">
    	 <div class="wrapper-padding">
		      <div class="page-title">ვიდეოთეკა</div>
		      <div class="clear"></div>
	     </div>
    </div>
<?php
	$v = db_fetch("select * from galleries where id=".intval($_GET["v"])." and language='".l()."'"); 
	if(!$v) redirect(href(1));
?>
    <div class="blog-page">
          <div class="content-wrapper">
			   <div class="blog-sidebar">
			   		<div class="blog-sidebar-l">
			   			<div class="blog-sidebar-lb">
			   				<div class="blog-sidebar-p">
			   					<div class="blog-row">
			   						<div class="blog-post-cb">
										<div class="blog-post-title"><?php echo $v["title"];?></div>
										<div class="blog-post-infos">
											<div class="blog-post-date"><?php echo convert_date($v["postdate"]);?></div>
											<div class="blog-post-auth">
												<a href="<?php echo href(3).'?q='.$v["author"];?>" style="color:#f3b01a; text-decoration:none;" ><?php echo $v["author"];?></a>
											</div>
										</div>
										<div class="blog-post-preview">
											<iframe width="825" height="453" src="<?php echo str_replace("watch?v=", "embed/", $v["link"]);?>" frameborder="0" allowfullscreen></iframe>
<!--											<img alt="" src="_website/img/paul-wilbur.jpg">-->
										</div>
										<div class="blog-post-txt">
											<?php echo $v["description"];?>
										</div>
										<div class="blog-post-footer fix">
											<a href="javascript:backPage();" class="back-btn">უკან</a>
<script>
	function backPage() {
		 window.history.back();
	}
</script>
<?php require("_website/templates/widgets/social.php");?>
										</div>
									</div>
									<div class="clear"></div>
			   					</div>
			   				</div>
			   			</div>
			   		</div>
			   </div>
			   <div class="blog-sidebar-r">
<?php require("_website/templates/widgets/search.php");?>
<?php require("_website/templates/widgets/new_videos.php");?>
		  			<div class="blog-widget tags-widget">
	  					<h2>თეგები</h2>
	  					<div class="tags-row">
<?php 
	$tags = explode(",", $v["meta_keys"]);
	foreach($tags as $tag) :
		if($tag!='') :
?>	
							<a href="<?php echo href(3).'?q='.$tag;?>"><?php echo $tag;?></a>
<?php
		endif;
	endforeach;
?>
	  					</div>
	  					<div class="clear"></div>
	  				</div>
				</div>
				<div class="clear"></div>    
          </div>
       	  <div class="clear"></div>
    </div>	
  </div>
</div>
<?php require("_website/templates/widgets/popular.php");?>
<!-- /main-cont -->
