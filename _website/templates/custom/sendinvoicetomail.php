<?php 
if(isset($_GET["o_website"]) && isset($_GET['user_trip'])){
	g_sent_order_mail("unpayed", "payed", "green", '', $_GET['user_trip']);

	$sql = "UPDATE `cart` SET `status`='payed' WHERE `userid`='".$_GET['user_trip']."' AND `status`='unpayed' AND `readytopay`='ready' AND  `website`='".$_GET['o_website']."'";
	db_query($sql);	
}
?>