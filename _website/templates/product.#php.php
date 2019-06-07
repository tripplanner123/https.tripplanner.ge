<?php defined('DIR') OR exit; 
	$sql = db_fetch_all("SELECT * FROM catalogs WHERE id<>{$id} AND menuid = {$menuid} AND language = '" . l() . "' AND visibility = 1 and deleted=0 order by rand() limit 10");
?>
      <div id="page-header">
        <div class="container">
          <ol class="breadcrumb">
            <?php echo location();?>
          </ol>
        </div>
      </div>
      <div id="product-details" class="section">
        <div class="container">
          <div class="selected-item row">
            <div class="col-md-6 pt-off-md">
              <div class="img">
                <img src="<?php echo $image1 ?>" width="570" height="380" class="img-responsive" alt="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="title">
                <h1><?php echo $title;?></h1>
              </div>
              <div class="tblock">
                <?php echo $description;?>
              </div>
              <div class="el-list row">
                <div class="col-md-2 pt-off-md">
                  <input type="number" class="amount" id="qnt" min="1" value="1">
                </div>
                <div class="col-md-5">
                  <select name="size" class="selectpicker" id="size">
                      <option value=""><?php echo l('size')?></option>
                    <?php
                      $option = explode(",", $size);
                      for($i=0; $i<count($option); $i++){
                    ?>
                      <option value="<?php echo $option[$i];?>"><?php echo $option[$i];?></option>
                    <?php } ?>
                  </select>
                </div>
                
                <?php if($file!='') : ?>
                <?php $ext = strtolower(substr(strrchr($file, '.'), 1)); ?>
                  <div class="col-md-5">
                    <a href="<?php echo $file;?>" class="btn data-sheet"><?php echo l('datenblatt');?></a>
                  </div>
                <?php endif; ?>        

                <div class="col-md-7 col-offset-md-5 pt-off-md">
                  <a nohref="" onclick="javascript:add_to_basket();" class="btn btn-primary add-to-cart"><span class="text"><?php echo l('add.cart');?></span><span class="icon"></span></a>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <table class="features table table-bordered">
                <tr>    
                  <th><?php echo l('gewindeart');?></th>
                  <th><?php echo l('schneidstoff');?></th>
                  <th><?php echo l('bescichtung');?></th>
                  <th><?php echo l('typ');?></th>
                  <th><?php echo l('norm');?></th>
                  <th><?php echo l('form');?></th>
                  <th><?php echo l('lochart');?></th>
                  <th><?php echo l('toleranzfeld');?></th>
                  <th><?php echo l('schaft');?></th>
                </tr>
                <tr>
                  <td><?php echo $gewindeart;?></td>
                  <td><?php echo $schneidstoff;?></td>
                  <td><?php echo $beschichtung;?></td>
                  <td><?php echo $typ;?></td>
                  <td><?php echo $norm;?></td>
                  <td><?php echo $form;?></td>
                  <td><?php echo $lochart;?></td>
                  <td><?php echo $toleranzfeld;?></td>
                  <td><?php echo $schneidrichtung;?></td>
                </tr>
              </table>
            </div>
          </div>

<?php 
      $children = db_fetch("SELECT * from ".c("table.pages")." where menutype = {$menuid} and visibility=1 and deleted=0 and language='".l()."'");
     $parent = db_fetch("SELECT * from ".c("table.pages")." where id = {$children['masterid']} and visibility=1 and deleted=0 and language='".l()."'");
     if($children['level']==3):
          $pid = $parent['menutype'];
      else:
          $pid = $menuid;
      endif;

?>
<?php echo similar_products($menuid, $id); ?>

        </div>
      </div>

<script type="text/javascript">
  function add_to_basket(){ 
  	if(parseInt($("#qnt").val())>0)
  		if($("#size").val()!="")
		    $.post("<?php echo href(16);?>?ajax=1&pid="+<?php echo $id ?>+"&quantity="+$("#qnt").val()+"&size="+$("#size").val(),function(data) {
		      location.reload();
		    });
		else {
			$("[data-id*=size]").css("border", "solid 1px #f00");
		}
    else
    	$("#qnt").css("border", "solid 1px #f00");
  	  
  }

</script>
