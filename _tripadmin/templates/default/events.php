<?php
defined('DIR') OR exit;

if (!empty($events)):
    foreach ($events as $faq):
?>
        <a href="javascript:void(null);" rel="faq"><?php echo $faq['title']; ?></a><br />
        <p style="margin-bottom: 15px; display: none"><?php echo html_entity_decode($faq['description']); ?></p>
<?php
        endforeach;
    endif;
