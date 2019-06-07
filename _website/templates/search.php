<?php defined('DIR') OR exit; ?>
<!-- main-cont -->
<?php
	$mark = 0;
	if(isset($_GET["q"]) &&  mb_strlen($_GET["q"], "UTF8")>3) {
		$mark = 1;
		$q = db_escape($_GET["q"]); 
	    $all_news = " AND (title like '%".$q."%' OR author like '%".$q."%' OR meta_keys like '%".$q."%' OR description like '%".$q."%' OR content like '%".$q."%') AND menuid>2 "; 
	    //Pager: start
	    $page = abs(get('page', 1));
	    $per_page = c('articles.per_page');
	    $limit = " LIMIT " . (($page - 1) * $per_page) . ",{$per_page}";
	    $count = "SELECT COUNT(*) AS cnt FROM `".c("table.pages")."` WHERE language = '" . l() . "' {$all_news}AND visibility = 1 AND deleted = 0 ORDER BY postdate DESC;";
	    $count = db_fetch($count);
	    $count = empty($count) ? 0 : $count['cnt'];
	    $page_max = ceil($count / $per_page);
	    $page_cur = $page;
	    $page_max = $page_max;
	    $item_count = $count;
	    //Pager: end
	    $sql = "SELECT * FROM `".c("table.pages")."` WHERE language = '" . l() . "' {$all_news}AND `deleted` = '0' AND visibility = 1 ORDER BY postdate DESC{$limit};";
	    $res = db_fetch_all($sql);
	    $articles = $res;
	    if(count($articles)==0)
	    	$mark = 0;
	}
?>
<div class="main-cont">
<?php if($mark == 0) : ?>

	<div class="body-wrapper">
		<div class="page-head">
			 <div class="wrapper-padding">
			      <div class="page-title"><?php echo $title;?></div>
			      <div class="clear"></div>
		     </div>
		</div>
    	<div class="wrapper-padding ip-full-width">
           	<div class="padding">
		   		სტატიები არ მოიძებნა
			</div>
		</div>
	</div>
<?php else : ?>	
	<div class="body-wrapper">
		<div class="page-head">
			 <div class="wrapper-padding">
			      <div class="page-title"><?php echo $title;?></div>
			      <div class="clear"></div>
		     </div>
		</div>
    	<div class="wrapper-padding ip-full-width">
          	<div class="padding">
		        <div class="catalog-row alternative">
<?php foreach($articles as $a) : ?>					
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
<?php endforeach; ?>
			    </div>

		        <div class="clear"></div>
		        
<?php if($page_max>1) : ?>
		        <div class="pagination">
<?php for($i=1;$i<=$page_max;$i++) : ?>		          
		          <a href="<?php echo href($id).'?q='.$q.'&page='.$i;?>" <?php echo ($page_cur==$i) ? 'class="active"':'';?> ><?php echo $i;?></a>
<?php endfor; ?>
		          <div class="clear"></div>
		        </div>            
<?php endif;?>
			</div>
		</div>
		<br class="clear" />
	</div>
<?php endif; ?>	
<?php require("_website/templates/widgets/popular.php");?>

</div>
