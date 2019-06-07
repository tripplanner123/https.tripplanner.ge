<?php defined('DIR') OR exit; 
//if($menuid == 6){$bg_color = '#3a1212'; $text_bg = '#5b3a3a';}
//if($menuid == 4){$bg_color = '#3a1212'; $text_bg = '#5b3a3a';}

$sql = db_fetch_all("SELECT * FROM catalogs WHERE id<>{$id} AND menuid = {$menuid} AND language = '" . l() . "' AND visibility = 1 and deleted=0 order by rand() limit 10");
//die(print_r($sql));

$sld = array(
    array(
        'id' => $id,
        'image1' => $image1,
        'title' => $title,
        'description' => $description,
        'text_bg' => $text_bg,
        'bg_color' => $bg_color
    )
);

foreach ($sql as $key => $value) {
    $sld[] = $value;
}

//die(print_r($sld));
?>
  <div id="mob-slide">
    <div class="col-sm-6 fix">
      <div class="mob-img left"><img src="<?php echo $image1 ?>" class="img-responsive"></div>
      <h2><?php echo $title;?></h2>
      <div class="mob-txt">
        <?php echo $description;?>
      </div>
    </div>
  </div>

  <div id="prod-slide">
    <script type="text/javascript" src="_javascript/jssor/jssor.core.js"></script>
    <script type="text/javascript" src="_javascript/jssor/jssor.utils.js"></script>
    <script type="text/javascript" src="_javascript/jssor/jssor.slider.js"></script>
    <script type="text/javascript" src="_javascript/jssor/jssor.ctrl3.js"></script>
    <div class="container" style="position:relative;height:607px;">
    <div id="slider2" style="width:1920px;height:607px;position:absolute;left:-375px;">
        <div u="slides" class="slides" style="width:1920px;height:607px;overflow:hidden;">
        <?php foreach ($sld as $item): ?>
            <div class="sld-bg" style="background-color: <?php echo (($item['bg_color']=='') ? '#3a1212' : $item['bg_color']); ?>; height:553px !important;">
                <div class="img">
                    <div u="image" style="background:url('<?php echo $item['image1'] ?>') no-repeat center 15px; width:1920px;height:553px;" usemap="#slide"></div>
                    <div u="caption" t="*" class="caption" style="width:1920px;height:300px;position:absolute;top:100px;left:0;">
                      <div id="slide-title" class="container fix">
                        <div id="sm-title" class="left">
                          <h2><?php echo $item['title'] ?></h2>
                          <!-- <div class="cat">Méthode Charmat</div> -->
                        </div>
                        <div id="sl-text" class="right" style="background-color: <?php echo (($item['text_bg']=='') ? '#5b3a3a' : $item['text_bg']);?>;">
                          <div id="sfrom">
                            <?php echo $item['description'] ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- .caption -->
                </div>
                <!-- .img -->
            </div>
        <?php endforeach ?>
        </div>
        <!-- .slides -->
      <?php if ($sql): ?>
        <span u="arrowleft" class="arrow-left arrow " style="width:40px;height:113px;position:absolute;left:20%;">
          <!-- <a href="<?php echo href($pageid, array(), '', $sql[0]['id']) ?>" style="width:40px;height:113px;display:block;"></a> -->
        </span>
        <span u="arrowright" class="arrow-right arrow " style="width:40px;height:113px;position:absolute;right:20%;">
         <!--  <a href="<?php echo href($pageid, array(), '', $sql[0]['id']) ?>" style="width:40px;height:113px;display:block;"></a> -->
        </span>
      <?php endif ?>
    </div>
    </div>
  </div>
  <!-- #prod-slide -->
<?php 
      $children = db_fetch("SELECT * from ".c("table.pages")." where menutype = {$menuid} and visibility=1 and deleted=0 and language='".l()."'");
//  echo "SELECT * from ".c("table.pages")." where menutype = {$menuid} and visibility=1 and deleted=0 and language='".l()."'";
      $parent = db_fetch("SELECT * from ".c("table.pages")." where id = {$children['masterid']} and visibility=1 and deleted=0 and language='".l()."'");
      echo $parent['level'];
      if($level==3):
      	  $pid = $parent['menutype'];
  	  else:
  	  	  $pid = $menuid;
  	  endif;

?>
<?php echo similar_products($menuid); ?>

<?php echo products($pid); ?>
