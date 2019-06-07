<?php
defined('DIR') OR exit;

header('Content-Type: application/rss+xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';

?>
<rss version="2.0">
    <channel>
        <title><?php echo title(); ?></title>
        <description><?php echo l('site_title'); ?> RSS Feed</description>
        <link><?php echo str_replace('&', '&amp;', href($section)); ?></link>
        <lastBuildDate><?php echo date('D, d M Y H:i:s T'); ?></lastBuildDate>
        <pubDate><?php echo date('D, d M Y H:i:s T'); ?></pubDate>
        <?php foreach ($news as $item): ?>
        <item>
            <title><?php echo $item['title']; ?></title>
            <description><![CDATA[
                <?php echo html_entity_decode($item['content']); ?>
            ]]></description>
            <link><?php echo str_replace('&', '&amp;', href($item['id'])); ?></link>
            <pubDate><?php echo date('D, d M Y H:i:s T', strtotime($item['postdate'])); ?></pubDate>
        </item>
        <?php endforeach; ?>
    </channel>
</rss>
