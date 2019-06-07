<?php
	defined('DIR') OR exit;
?>
    <div id="title" class="fix">
        <div class="icon"><img src="_tripadmin/img/table.png" width="16" height="16" alt="" /></div>			
        <div class="name"><?php echo a("filemanager");?></div>
    </div>	
    <div id="box">
        <div id="part">
            <iframe  width="100%" height="600" frameborder="0"
                src="<?php echo JAVASCRIPT ?>/tinymce/filemanager/dialog.php">
            </iframe>
        </div>
    </div>