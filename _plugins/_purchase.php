<?php
defined('DIR') OR exit;
$data["message"] = 'Basket';

    $data["title"] = $this->storage->section['title'];
    $data["id"] = $this->storage->section['id'];
    $data["content"] = $this->storage->section['content'];
	$this->storage->content = plugin_template('_purchase', $data);
?>
