<?php defined('DIR') OR exit;?>
<!-- main-cont -->
<div class="main-cont">
  <div class="body-wrapper">
    <div class="page-head">
    	 <div class="wrapper-padding">
		      <div class="page-title"><?php echo $title;?></div>
		      <div class="clear"></div>
	     </div>
    </div>
    <div class="columns">
   	 <div class="content-wrapper columns">
        <div class="columns-block">
            <div class="columns-row shop">
				<!-- // -->
<?php
  	foreach ($items as $item):
      	$link = href($id,array(), l(), $item['id']);
		$link = $item['image1'];
?>
				<div class="column mm-3">
					<a class="offer-slider-img popup-img" href="<?php echo $item["file"]; ?>" target="_blank">
						<img alt="" src="<?php echo $item['image1'];?>">
						<span class="offer-slider-overlay" style="display: none;">
							<span class="offer-slider-btn" style="top: -200px;">დეტალურად</span>
						</span>
					</a>
					<div class="offer-slider-txt">
						<div class="offer-slider-link"><a class="popup-img" href="<?php echo $item["file"]; ?>" target="_blank"><?php echo $item['title'];?></a></div>
						<div class="flat-adv-c">
							<?php echo $item['description'];?>
						</div>	
<!--
						<div class="shop-price">
							<span class="lab">
								ფასი:
							</span>
							<span class="val">
								<?php echo $item['price'];?> ლ
							</span>
						</div>				
-->
						<div class="clear"></div>
					</div>
				</div>
<?php endforeach; ?>
            </div>
            <div class="clear"></div>
    	</div>
<?php
// pager
	if (isset($item_count) AND $item_count > count($items)):
?>
    	<div class="wrapper-padding ip-full-width">
          	<div class="padding">
	            <div class="pagination">
<?php
        if ($page_num > 1):
?>
                                <a href="<?php echo $link . '?page=1'; ?>">&laquo;&laquo;</a>
                                <a href="<?php echo $link . '?page=' . ($page_num - 1); ?>">&laquo;</a>
<?php
        endif;
        $per_side = 5;
        $index_start = ($page_num - $per_side) <= 0 ? 1 : $page_num - $per_side;
        $index_finish = ($page_num + $per_side) >= $page_max ? $page_max : $page_num + $per_side;
        if (($page_num - $per_side) > 1)
            echo '<a href="javascript:">...</a>';
        for ($idx = $index_start; $idx <= $index_finish; $idx++):
?>
                                <a href="<?php echo $link . '?page=' . $idx; ?>"><?php echo $idx ?></a>
<?php
        endfor;
        if (($page_num + $per_side) < $page_max)
            echo '<li class="pages"><a href="javascript:">...</a></li>';
        if ($page_num < $index_finish):
?>
                                <a href="<?php echo $link . '?page=' . ($page_num + 1); ?>">&raquo;</a>
                                <a href="<?php echo $link . '?page=' . $page_max; ?>">&raquo;&raquo;</a>
<?php
        endif;
?>
                         </div>
	              <div class="clear"></div>           
         	 	</div>
	        	<br class="clear" />
	    		<div class="clear"></div>
	    	</div>
<?php
    endif;
// Pager End
?>
    	</div>
  	</div>
  </div>
<?php require("_website/templates/widgets/popular.php");?>
    
</div>
<!-- /main-cont -->
