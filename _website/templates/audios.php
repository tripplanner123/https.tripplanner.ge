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

























<?php /*


<script type="text/javascript" src="<?php echo c("players");?>/swfobject.js"></script>
<script type="text/javascript">
	swfobject.registerObject("player","9.0.98","expressInstall.swf");
</script>

<?php
defined('DIR') OR exit;

$idx = 0;
$num = count($audio);
?>
    <div class="block br fix">
        <ul class="menu">
            <li><a href="<?php echo href(2, array('all' => 'show'), l());?>"><?php echo l('video');?></a></li>					
		</ul>
		<div class="white fix">
            <div class="part">
                <div class="list fix" style="border:none">
                    <div class="item-info">
                        <div class="news-name cufon"><?php echo $title; ?></div>	
                    </div>	
                </div>
			</div>
<?php
$half = ceil((count($audio) - 1 ) / 2) + 1;
$idx = 0;
foreach ($audio AS $item):
	$idx++;
    $link = href($item['id']);
    $is_last = ($idx == ($num - 1));
?>
            <div class="part">
                <div class="list fix">
                    <div class="news-img" id="mp3player<?php echo $item['id'] ?>">
	<script type="text/javascript">
	var s2 = new SWFObject("<?php echo c("players");?>/player.swf", "line", "280", "20", "6");
	s2.addVariable("file","<?php echo $item['file'] ?>");
	s2.addVariable("backcolor","0x45535F");
	s2.addVariable("frontcolor","0xFFFFFF");
	s2.addVariable("lightcolor","0xeeeeee");
	s2.addVariable("displayheight","0");
	s2.addVariable("width","280");
	s2.addVariable("height","20");
	s2.addVariable("autostart","false");
	s2.addVariable("shuffle","false");
	s2.addVariable("repeat","list");
	s2.addVariable("thumbsinplaylist","false");
	s2.addVariable("titlesinplaylist","true");
	s2.addVariable("playlist","top");
	s2.addVariable("playlistsize","0");
	s2.addVariable("item","1");
	s2.write("mp3player<?php echo $item['id'] ?>");
	</script>
					</div>								
                    <div class="news-info">
                        <div class="news-name"><?php echo $item['title'] ?></div>	
                        <div class="news-text"><?php echo $item['description']; ?></div>		
                    </div>								
                </div>
            </div>
<?php
    endforeach;
?>
        </div>
    </div>


<!--
<?php
// Pager Start
    if (isset($item_count) AND $item_count > $num):
        echo '<ul id="page">';
        if ($page_cur > 1):
?>
            <li><a href="<?php echo href($section, array('page' => 1)) ?>">&lt;&lt;</a></li>
            <li><a href="<?php echo href($section, array('page' => $page_cur - 1)) ?>">&lt;</a></li>
<?php
            endif;
            $per_side = 5;
            $index_start = ($page_cur - $per_side) <= 0 ? 1 : $page_cur - $per_side;
            $index_finish = ($page_cur + $per_side) >= $page_max ? $page_max : $page_cur + $per_side;
            if (($page_cur - $per_side) > 1)
                echo '...';
            for ($idx = $index_start; $idx <= $index_finish; $idx++):
?>
                <li><a href="<?php echo href($section, array('page' => $idx)) ?>"<?php echo $idx == $page_cur ? ' class="current"' : NULL ?>><?php echo $idx ?></a></li>
<?php
                endfor;
                if (($page_cur + $per_side) < $page_max)
                    echo '...';
                if ($page_cur < $index_finish):
?>
                    <li><a href="<?php echo href($section, array('page' => $page_cur + 1)) ?>">&gt;</a></li>
                    <li><a href="<?php echo href($section, array('page' => $page_max)) ?>">&gt;&gt;</a></li>
<?php
                    endif;
                    echo '</ul>';
                endif;
// Pager End
?>

                <a href="<?php echo href(c('section.news')) ?>" class="all"><?php echo l('all_news') ?></a>
-->


*/ ?>