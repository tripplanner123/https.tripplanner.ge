<?php defined('DIR') OR exit; ?>
    <div id="location-part">
        <div id="location">
            <div id="page-title">
                <h1><?php echo $title; ?></h1>
            </div>
            <!-- #page-title -->
            <div id="loc-bar">
                <ul>
                    <?php echo location();?>
                </ul>
            </div>
            <!-- #loc-bar -->
        </div>
        <!-- #location .fix -->
    </div>
    <!-- #location-part -->
    <div id="content">
        <div id="page" class="fix">
        <?php if (!empty($basket)): ?>
            <div id="stage">
                <div class="stage1">Booking details</div>
                <div class="stage2 active">Payment</div>
            </div>
            <!-- #stage -->
            <div id="basket-part">
            <?php
                $sum=0;
                foreach ($basket as $item):

                $price = Array();
                if($item["name"]!='' && $item["price"]>0) $price[] = $item["price"]*$item["quantity"];
                if($item["name1"]!='' && $item["price1"]>0) $price[] = $item["price1"]*$item["quantity1"];
                if($item["name2"]!='' && $item["price2"]>0) $price[] = $item["price2"]*$item["quantity2"];
                if($item["name3"]!='' && $item["price3"]>0) $price[] = $item["price3"]*$item["quantity3"];
                if($item["name4"]!='' && $item["price4"]>0) $price[] = $item["price4"]*$item["quantity4"];
                if($item["name5"]!='' && $item["price5"]>0) $price[] = $item["price5"]*$item["quantity5"];
                if($item["name6"]!='' && $item["price6"]>0) $price[] = $item["price6"]*$item["quantity6"];
                if($item["name7"]!='' && $item["price7"]>0) $price[] = $item["price7"]*$item["quantity7"];
                if($item["name8"]!='' && $item["price8"]>0) $price[] = $item["price8"]*$item["quantity8"];

                $sum = $sum + $item["sum"];
                $sql = db_fetch("select title from menus where id=".$item["menuid"]." limit 0,1");
                $change = db_fetch("select id from pages where attached='".$sql["title"]."' limit 0,1");
            ?>
                <div class="basket fix">
                <?php if ($item["photo1"]!=''): ?>
                    <div class="img left">
                        <img src="<?php echo 'crop.php?img='.$item["photo1"].'&width=120&height=150' ?>" height="120" width="150" alt="<?php echo $item["title"] ?>">
                    </div>
                    <!-- .img left -->
                <?php endif ?>
                    <div class="param right">
                        <div class="item-price right">
                            Price: <span>&euro;<?php echo array_sum($price) ?></span>
                        </div>
                        <!-- .item-price -->
                    </div>
                    <!-- .param right -->
                    <div class="inward">
                        <div class="title">
                            <?php echo $item["title"] ?>
                        </div>
                        <!-- .title -->
                        <div class="date">
                            Date: <?php echo convert_date($item["startdate"]) ?>
                        </div>
                        <!-- .date -->
                        <?php echo ($item["name"]!='' && $item["quantity"]>0) ? '<div>'.$item["name"].': '.$item["quantity"].' x &euro;'.$item["price"].'</div>' : null ?>
                        <?php echo ($item["name1"]!='' && $item["quantity1"]>0) ? '<div>'.$item["name1"].': '.$item["quantity1"].' x &euro;'.$item["price1"].'</div>' : null ?>
                        <?php echo ($item["name2"]!='' && $item["quantity2"]>0) ? '<div>'.$item["name2"].': '.$item["quantity2"].' x &euro;'.$item["price2"].'</div>' : null ?>
                        <?php echo ($item["name3"]!='' && $item["quantity3"]>0) ? '<div>'.$item["name3"].': '.$item["quantity3"].' x &euro;'.$item["price3"].'</div>' : null ?>
                        <?php echo ($item["name4"]!='' && $item["quantity4"]>0) ? '<div>'.$item["name4"].': '.$item["quantity4"].' x &euro;'.$item["price4"].'</div>' : null ?>
                        <?php echo ($item["name5"]!='' && $item["quantity5"]>0) ? '<div>'.$item["name5"].': '.$item["quantity5"].' x &euro;'.$item["price5"].'</div>' : null ?>
                        <?php echo ($item["name6"]!='' && $item["quantity6"]>0) ? '<div>'.$item["name6"].': '.$item["quantity6"].' x &euro;'.$item["price6"].'</div>' : null ?>
                        <?php echo ($item["name7"]!='' && $item["quantity7"]>0) ? '<div>'.$item["name7"].': '.$item["quantity7"].' x &euro;'.$item["price7"].'</div>' : null ?>
                        <?php echo ($item["name8"]!='' && $item["quantity8"]>0) ? '<div>'.$item["name8"].': '.$item["quantity8"].' x &euro;'.$item["price8"].'</div>' : null ?>
                    </div>
                    <!-- .inward -->
                </div>
                <!-- .basket -->
            <?php endforeach; ?>
            </div>
            <!-- #basket-part -->
            <div id="total-price" class="sum">
                Total to pay now: <span>€<?php echo $sum ?></span>
            </div>
            <!-- #total-price -->
            <div id="action" class="fix">
                <div class="back left">
                    <a href="<?php echo href(58) ?>">Back to Basket</a>
                </div>
                <!-- .back -->
                <div class="checkout right">
                    <a href="<?php echo href(60) ?>">Complete Checkout</a>
                </div>
                <!-- .continue -->
            </div>
            <!-- #action .fix -->
        <?php endif ?>
        </div>
        <!-- #page .fix -->
    </div>
    <!-- #content .fix -->
