<?php defined('DIR') OR exit; ?>
            <div id="page" class="faq right">
                <div class="block-title faq mark5">
                    <h2><?php echo $title; ?></h2>
                </div>
                <!-- .block-title -->
<?php
foreach ($news AS $item):
?>		
                <div class="block faq fix">
                    <div class="title">
                        <h3><?php echo $item["title"]; ?></h3>
                    </div>
                    <!-- .title -->
                    <div class="text">
                        <?php echo $item["content"]; ?>
                    </div>
                    <!-- .text fix -->
                </div>
                <!-- .block fix -->
<?php
endforeach;
?> 
<?php if((banners(9))!='') { ?>
                <div class="block banner fix">
                    <?php echo banners(9); ?>
                </div>
                <!-- .block fix -->
<?php } ?>
            </div>
            <!-- #page.right -->
<script type="text/javascript">
// Click for toggle neighbor element
$(function(){
  $('.title').click(function(){
     $(this).siblings('.text').toggle('slow');
  });
});
</script>