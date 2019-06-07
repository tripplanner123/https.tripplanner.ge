<?php defined('DIR') OR exit; ?>

  <div id="slide-1">
    <div class="fullscreen background parallax" style="background-image:url('files/gallery/sl-image.jpg');" data-img-width="1920" data-img-height="844" data-diff="200">
        <div class="content-a">
            <div class="content-b">
              <div id="slide-down">
                <div class="container">
                  <div id="scroll-down">
                    <a href="#exp-content" id="sba" class="center-block"><?php echo l('scroll.down');?></a>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
  </div>
  <div id="exp-content" class="fix">
   <?php
    $count = 0;
    foreach ($children as $item):
    	$count++;
   ?>
    <div class="title col-sm-6 <?php echo (($count % 2 == 0) ? 'tr' : 'right');?>">
      <?php echo $item['title'];?>
    </div>
    <div class="clear"></div>
    <div class="res-content fix">
      <div class="col-sm-6 content-img <?php echo (($count % 2 == 0) ? 'right' : '');?>">
        <img src="<?php echo 'crop.php?img='.$item['image1'].'&n=5' ?>" width="960" height="395" class="img-responsive">
      </div>
      <div class="gallery clear fix col-sm-7">
<?php
        $count = "SELECT count(*) as cnt from `".c("table.galleries")."` WHERE `menuid` = '".$item['menutype']."' AND `deleted` = '0' AND `language` = '" . l() . "' AND visibility=1 ORDER BY `position` DESC";
        $count = db_fetch($count);

        // pager
        $page = abs(get('page', 1));
        $per_page = c('photos.per_page');
        $count = $count['cnt'];
        $page_max = ceil($count / $per_page);
        $page = ($page > $page_max && $page_max != 0) ? $page_max : $page;
        $limit = " LIMIT " . (($page - 1) * $per_page) . ", {$per_page}";
        // pager end

        $sql = "SELECT * FROM `".c("table.galleries")."` WHERE `menuid` = '".$item['menutype']."' AND `deleted` = '0' AND `language` = '" . l() . "' AND visibility=1 ORDER BY `position` DESC{$limit}";
        $photos = db_fetch_all($sql);
        $page_cur = $page;

		foreach ($photos as $photo):
		    if ($photo['image1']):
?>
        <div class="photos left">
          <a href="<?php echo $photo['image1'] ?>" class="fancybox" rel="group">
            <img src="<?php echo 'crop.php?img='.$photo["image1"].'&n=6' ?>" width="220" height="220" class="img-responsive">
          </a>
        </div>
<?php
	        endif;
	    endforeach;
?>
		</div>
	<?php echo pager($id, $page_cur, $page_max, c('photos.page_count'), get()) ?>
  </div>
    <div class="clear"></div>
<?php
  endforeach;
?>

<?php
	$video = db_fetch("SELECT * FROM pages WHERE id=14 and language = '" . l() . "' AND visibility = 1 and deleted=0 ");
?>
    <div id="tab14"></div>
    <div class="title col-sm-6 right">
      <?php echo $video['title'];?>
    </div>
    <div class="clear"></div>
    <div class="res-content fix">
      <div class="col-sm-6 content-img">
        <img src="<?php echo 'crop.php?img='.$video['image1'].'&n=5' ?>" width="960" height="395" class="img-responsive">
      </div>
      <div class="col-sm-6 exp-text">
    	<?php echo $video['description'];?>
      </div>
    </div>
    <div class="clear gallery col-sm-8">
      <div class="videos">
    	<?php echo video_home();?>
        <!--<img src="files/gallery/video.png">-->
      </div>
    </div>
  </div>

