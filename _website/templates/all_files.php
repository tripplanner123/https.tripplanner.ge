<?php defined('DIR') OR exit ?>
        <div class="atachment"><?php echo (l()=='ge') ? 'მიმაგრებული დოკუმენტები' : 'Attachments'; ?></div>
<?php 
if(isset($files)){
foreach($files as $file) : ?>        
        <div class="pdf"><a href="<?php echo $file['path'];?>"><?php echo $file['title'];?></a></div>
<?php endforeach;
} ?>        
