<?php defined('DIR') OR exit; ?>
<!-- main-cont -->
<?php
	$cat = db_fetch("select * from pages where menutype=".$menuid);	
?>	
<div class="main-cont">
  <div class="body-wrapper">
    <div class="page-head">
    	 <div class="wrapper-padding">
		      <div class="page-title"><?php echo ($cat["masterid"]!=6) ? 'სტატია':'წიგნის კითხვა';?></div>
		      <div class="clear"></div>
	     </div>
    </div>
    <div class="blog-page">
          <div class="content-wrapper">
			   <div class="blog-sidebar">
			   		<div class="blog-sidebar-l">
			   			<div class="blog-sidebar-lb">
			   				<div class="blog-sidebar-p">
			   					<div class="blog-row">
			   						<div class="blog-post-cb">
										<div class="blog-post-title"><h1><?php echo $title ?></h1></div>
										<div class="blog-post-infos">
											<div class="blog-post-date"><?php echo convert_date($postdate);?></div>
											<div class="blog-post-auth">
												<a href="<?php echo href(31).'?q='.$author;?>" style="color:#f3b01a; text-decoration:none;"><?php echo $author;?></a>
											</div>
										</div>
										<?php if($image1!="") :?>
<?php 
//	if($cat["masterid"]!=6) :
	if($cat["masterid"]==-1) :
?>
										<div class="blog-post-preview">
											<div class="blog-post-img">
												<a href="javascript:;"><img alt="" src="<?php echo $image1;?>"></a>
											</div>
										</div>
<?php
	endif;
?>
										<?php endif;?>
										<div class="blog-post-txt" style="text-align:justify; color:black;">
											<?php 
												if($cat["masterid"]!=6) {
													echo $content;
												} else {
													$charcount = 3000;
													$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
													if($page<1) $page=1;
													
													$content = preg_replace("/&#?[a-z0-9]+;/i","",$content);
													$content = html_entity_decode($content);
													// $content = filter_var($content, FILTER_SANITIZE_STRING);
													$txt = mb_substr(str_replace("[", "", str_replace("]", "", $content)), ($page - 1) * $charcount, $charcount, "UTF8");
													$cnt = mb_strlen(str_replace("[", "", str_replace("]", "", $content)), "UTF8");
													$pcnt = intval($cnt / $charcount) + 1;
													echo $txt."<br /><br />"; 
												}
											?>
										</div>
										<div class="pagination">
<?php
	if($cat["masterid"]==6) {
		for($i = 1; $i <= $pcnt; $i++) :
?>
  							              <a href="<?php echo href($id).'?page='.$i;?>" <?php echo ($page==$i) ? 'class="active"':'';?> ><?php echo $i;?></a>
<?php
		endfor;
	}
?>
  							              <div class="clear"></div>
							            </div> 
<?php
	if(count($files) > 0) :
?>	
										<div class="attached-files">
											<ul class="list">
<?php foreach($files as $file) : ?>   
<?php $ext = strtolower(substr(strrchr($file['file'], '.'), 1)); ?>
<?php if (!in_array($ext, c('thumbnail.exts'))) : ?>
												<li class="fix">
													<div class="img">
														<img src="_website/img/<?php echo $ext;?>.png" width="16" height="18" alt="">
													</div>
													<div class="txt">
														<a href="<?php echo $file['file'];?>" target="_blank"><?php echo $file['title'];?></a>
													</div>
												</li>
<?php endif; ?>
<?php endforeach; ?>
											</ul>
										</div>
										<div class="attached-photoes">
											<ul class="list">
<?php foreach($files as $file) : ?>   
<?php $ext = strtolower(substr(strrchr($file['file'], '.'), 1)); ?>
<?php if (in_array($ext, c('thumbnail.exts'))) : ?>
												<li>
													<a href="<?php echo $file['file'];?>" class="popup-img">
														<img src="<?php echo $file['file'];?>" width="150" height="100" alt="">
													</a>
												</li>
<?php endif; ?>
<?php endforeach; ?>
											</ul>
										</div>
<?php
	endif;
?>	
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
		  			<!-- \\ widget \\ -->
			   </div>
			   <div class="blog-sidebar-r">
<?php require("_website/templates/widgets/search.php");?>
<?php if($cat["masterid"]!=6) : ?>
	<?php require("_website/templates/widgets/new_articles.php");?>
<?php else : ?>	
		  			<div class="blog-widget tags-widget">
	  					<h2>სარჩევი</h2>
						<ul style="list-style:none;">
<?php
	preg_match_all('/\[([A-Za-z0-9ა-ჰ ]+?)\]/', $content, $out);
	foreach($out[1] as $a) :
		$p = ceil(mb_strpos($content, $a, 0, "UTF8") / $charcount);
?>
		<li style="height:30px; line-height:30px;"><a href="<?php echo href($id).'?page='.$p;?>" style="color:black; text-decoration:none;"><?php echo $a; ?></a>
<?php
	endforeach;
?>	
						</ul>
					</div>
	
    
<?php endif; ?>
		  			<div class="blog-widget tags-widget">
	  					<h2>თეგები</h2>
	  					<div class="tags-row">
<?php 
	$tags = explode(",", $meta_keys);
	foreach($tags as $tag) :
?>	
							<a href="<?php echo href(31).'?q='.$tag;?>"><?php echo $tag;?></a>
<?php
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

<?php require("_website/templates/widgets/popular.php");?>
