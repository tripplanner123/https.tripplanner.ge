<?php defined('DIR') || exit();
foreach ($list as $item): ?>

<div class="news-list">
	<div class="news2-text-block">
		<div class="news2-title-block">
			<div class="news2-title" style="font-size: 12px;"><a href="javascript:faq(<?=$item['id']?>);"><?=$item['title']?></a></div>
		</div>
		<div id="faq_<?=$item['id']?>" class="news2-description" style="display: none; font-size: 12px;"><?=$item['description']?></div>
	</div>
</div>

<?php endforeach; ?>