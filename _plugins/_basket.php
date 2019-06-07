<?php
defined('DIR') OR exit;
if(isset($_GET["action"])) :
	if($_GET["action"]=='add') {
		$qry = db_query("update cart set pid='".$_GET["product"]."' where  session='".session_id()."'");
	}
	if($_GET["action"]=='sub') {
		$qry = db_query("update cart set pid='".$_GET["product"]."' where  session='".session_id()."'");
	}
	if($_GET["action"]=='del') {
		$qry = db_query("delete from cart where pid=".$_GET["product"]." and session='".session_id()."'");
		redirect(href($this->storage->section['id']));
	}
endif;

$basket = db_fetch_all("SELECT cart.tprice as sum, cart.*, catalogs.* FROM catalogs, cart WHERE catalogs.id=cart.pid and catalogs.language='".l()."' and session='".session_id()."' order by cid asc");

$data["message"] = 'Basket';
$data["basket"] = $basket;
$data["title"] = $this->storage->section['title'];
$data["id"] = $this->storage->section['id'];
$data["content"] = $this->storage->section['content'];
$this->storage->content = plugin_template('_basket', $data);
?>
