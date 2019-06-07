<?php
	if(isset($_SESSION["user"])) {
		
/*	$status = $_POST["status"];
	if ($status == MERCHANT_TRANSTATUS_COMPLETED) {
			db_query("UPDATE `sold` SET `sold` = 1 WHERE `product_id` = {$product_id};");
	}
*/
?>   

    <div class="page-title"><span class="left">1</span><h2>ნაყიდი პროდუქტი</h2></div>
    <div id="page" class="fix">

<?php
                            	$user_id = $_SESSION["user"]["id"];	
								$select = mysql_query("SELECT * FROM sold WHERE uid='".$user_id."' AND sold=1");
								while($rows = mysql_fetch_array($select))
								{	//catalogs
									$uid = $rows['uid'];
									$quantity = $rows['quantity'];	
									$price = $rows['price'];
									$product_id=$rows['product_id'];
									$size = $rows['size'];
									$color = $rows['color'];
									$select2 = mysql_query("SELECT * FROM catalogs WHERE id='".$product_id."' AND language = '" . l() . "'");
									
									$rows2 = mysql_fetch_array($select2);
									
		$result1 = mysql_query("SELECT * FROM ".c("table.menus")." WHERE language = '" . l() . "' AND id='".$rows2['menuid']."'");
		$item1 = mysql_fetch_array($result1);

		$result2 = mysql_query("SELECT * FROM ".c("table.pages")." WHERE language = '" . l() . "' AND attached='".$item1['title']."'");
		$item2 = mysql_fetch_array($result2);
										
									$id = $rows2['id'];
									$photo = $rows2['photo1'];
									$title = $rows2['title'];
									$pid = $rows2['pid'];
									$price = $rows2['price'];
?>
        <div class="basket-main fix" style="border-bottom:1px solid #eee">
            <div class="basket-img left">
                <img src="<?php echo $photo;?>" width="100" height="100" alt="" title="" />
            </div>
            <div class="title"><h3><?php echo $title;?></h3></div>
            <div class="detail">
<?php if($color!="undefined"){ ?>
                <div class="det-color left"><?php echo l('color') ?>: <span><?php echo $color;?></span></div>
<?php } ?>
<?php if($size!="undefined"){ ?>
                <div><?php echo l('sizinginfo') ?>: <span><?php echo $size;?></span></div>
<?php } ?>
            </div>
            <div class="added-price right"><?php echo l('price') ?>: <span><?php echo $price;?> <?php echo l('val') ?></span></div>
            <div class="quantity"><span class="left"><?php echo l('quantity') ?>:</span> <input name="quantity" readonly type="text" value="<?php echo $quantity;?>"></div>
        </div>
        <!-- main end -->
<?php 
	}
?>

<?php } else { 
		$href = "#sign-in";
		$rel = 'rel="prettyFrame"';

?>

<div class="signin">გთხოვთ გაიაროთ <a href="<?php echo $href;?>" <?php echo $rel; ?>>ავტორიზაცია</a> ან <a href="<?php echo href(62);?>">რეგისტრაცია</a></div>

<?php } ?>