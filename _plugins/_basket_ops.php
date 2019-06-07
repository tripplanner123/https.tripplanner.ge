<?php
	defined('DIR') OR exit;
    $product = $_POST["product"];

    $year = $_POST["year"];
    $month = $_POST["month"];
    $day = $_POST["day"];

    if(isset($_POST["total-price"]) && intval($_POST["total-price"])>0) {
        $total_price = $_POST["total-price"];

        
    	$basket = db_fetch("SELECT count(*) as cnt FROM cart WHERE pid='".$product."' and session='".session_id()."'");

        $dt = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

        $qnt_name = "";
        $qnt_num = "";
        $qnt_upd = "";
        if(isset($_POST["quantity"])) {$qnt_name .= "quantity,"; $qnt_num .= $_POST["quantity"].","; $qnt_upd .= "quantity=".$_POST["quantity"].",";} else {$qnt_name .= ""; $qnt_num .= ""; $qnt_upd .= "";}
        if(isset($_POST["quantity1"])) {$qnt_name .= "quantity1,"; $qnt_num .= $_POST["quantity1"].","; $qnt_upd .= "quantity1=".$_POST["quantity1"].",";} else {$qnt_name .= ""; $qnt_num .= ""; $qnt_upd .= "";}
        if(isset($_POST["quantity2"])) {$qnt_name .= "quantity2,"; $qnt_num .= $_POST["quantity2"].","; $qnt_upd .= "quantity2=".$_POST["quantity2"].",";} else {$qnt_name .= ""; $qnt_num .= ""; $qnt_upd .= "";}
        if(isset($_POST["quantity3"])) {$qnt_name .= "quantity3,"; $qnt_num .= $_POST["quantity3"].","; $qnt_upd .= "quantity3=".$_POST["quantity3"].",";} else {$qnt_name .= ""; $qnt_num .= ""; $qnt_upd .= "";}
        if(isset($_POST["quantity4"])) {$qnt_name .= "quantity4,"; $qnt_num .= $_POST["quantity4"].","; $qnt_upd .= "quantity4=".$_POST["quantity4"].",";} else {$qnt_name .= ""; $qnt_num .= ""; $qnt_upd .= "";}
        if(isset($_POST["quantity5"])) {$qnt_name .= "quantity5,"; $qnt_num .= $_POST["quantity5"].","; $qnt_upd .= "quantity5=".$_POST["quantity5"].",";} else {$qnt_name .= ""; $qnt_num .= ""; $qnt_upd .= "";}
        if(isset($_POST["quantity6"])) {$qnt_name .= "quantity6,"; $qnt_num .= $_POST["quantity6"].","; $qnt_upd .= "quantity6=".$_POST["quantity6"].",";} else {$qnt_name .= ""; $qnt_num .= ""; $qnt_upd .= "";}
        if(isset($_POST["quantity7"])) {$qnt_name .= "quantity7,"; $qnt_num .= $_POST["quantity7"].","; $qnt_upd .= "quantity7=".$_POST["quantity7"].",";} else {$qnt_name .= ""; $qnt_num .= ""; $qnt_upd .= "";}
        if(isset($_POST["quantity8"])) {$qnt_name .= "quantity8,"; $qnt_num .= $_POST["quantity8"].","; $qnt_upd .= "quantity8=".$_POST["quantity8"].",";} else {$qnt_name .= ""; $qnt_num .= ""; $qnt_upd .= "";}

    	if($basket["cnt"]==0) {
    		$qry = db_query("insert into cart (pid,".$qnt_name."tprice,startdate,session) values(".$product.",".$qnt_num.$total_price.",'".$dt."','".session_id()."')");
            redirect(href(58));
    	} else {
    		$qry = db_query("update cart set ".$qnt_upd." tprice=".$total_price.", startdate='".$dt."' where pid=".$product." and session='".session_id()."'");
            redirect(href(58));
    	}
    } else {
        $sql = db_fetch("select menuid from catalogs where id=".$product." limit 0,1");
        $sql1 = db_fetch("select title from menus where id=".$sql["menuid"]." limit 0,1");
        $page = db_fetch("select id from pages where attached='".$sql1["title"]."' limit 0,1");
        redirect(href($page["id"], array(), l(), $product).'/?action=order&year='.$year.'&month='.$month.'&day='.$day.'&err');
    }
?>