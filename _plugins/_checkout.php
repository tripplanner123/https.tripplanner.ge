<?php
defined('DIR') OR exit;

$basket = db_fetch_all("SELECT cart.tprice as sum, cart.*, catalogs.* FROM catalogs, cart WHERE catalogs.id=cart.pid and catalogs.language='".l()."' and session='".session_id()."' order by cid asc");

$data["message"] = 'Checkout';
$data["basket"] = $basket;
$data["title"] = $this->storage->section['title'];
$data["id"] = $this->storage->section['id'];
$data["content"] = $this->storage->section['content'];
$this->storage->content = plugin_template('_checkout', $data);
?>
