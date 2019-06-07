<?php defined('DIR') OR exit;
   	$ttl = (in_array($route[0], array('pages', 'bannergroups'))) ? a("menulist") : $menutitle;
?>
    	<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/edit.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo $ttl;?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
				</div>	

				<div id="news">
					<div class="list fix">
						<div class="icon"><a href="#"><img src="_tripadmin/img/minus.png" width="16" height="16" alt="" /></a></div>								
						<div class="title">Info: <span class="star">*</span></div>								
					</div>	
<?php $ulink = ($route[1]=="add") ? ahref(array($type, 'add')) : ahref(array($type, 'edit', $id)); ?>
	                <form id="catform" name="catform" method="post" action="<?php echo $ulink;?>">
                   		<input type="hidden" name="topics_form_perform" value="1" />
                   		<input type="hidden" name="tabstop" id="tabstop" value="edit" />
                        <div class="list2 fix">
                            <div class="name"><?php echo a('title');?> <span class="star">*</span></div>					
                            <input type="text" id="menutitle" name="title" value="<?php echo ($route[1]=="edit") ? $title : '' ;?>"<?php echo (in_array($route[0], array('pages', 'bannergroups'))) ? '' : ' readonly';?> class="inp"/>
                        </div>	
                        <div class="list fix">
                            <div class="name"><?php echo a('items.per.page');?> <span class="star">*</span></div>					
                            <input type="text" id="items_per_page" name="items_per_page" value="<?php echo ($route[1]=="edit") ? $items_per_page : '0' ;?>" class="inp" style="width:80px;" />
                        </div>	
                        <div class="list2 fix">
                            <div class="name"><?php echo a('items.on.homepage');?> <span class="star">*</span></div>					
                            <input type="text" id="items_on_homepage" name="items_on_homepage" value="<?php echo ($route[1]=="edit") ? $items_on_homepage : '0' ;?>" class="inp" style="width:80px;" />
                        </div>	
                        
<?php
	if(($type=='gallerylist')&&($route[1]=='add')) {
?>
                        <div class="list fix">
                            <div class="name"><?php echo a('gallerytype');?><span class="star">*</span></div>					
                            <select name="menutype" class="inp" style="width:200px;">
                            	<option value="imagegallery"><?php echo a("imagegallery");?></option>
                            	<option value="videogallery"><?php echo a("videogallery");?></option>
                            	<option value="audiogallery"><?php echo a("audiogallery");?></option>
                            </select>
                        </div>	
<?php
	} elseif((($type=='categories'))&&($route[1]=='add')) {
?>
                        <div class="list fix">
                            <div class="name"><?php echo a('gallerytype');?><span class="star">*</span></div>					
                            <select name="menutype" class="inp" style="width:200px;">
                            	<option value="news"><?php echo a("news");?></option>
                            	<option value="articles"><?php echo a("articles");?></option>
                            	<option value="events"><?php echo a("events");?></option>
                            </select>
                        </div>	
<?php
	} else {
?>
                   		<input type="hidden" name="menutype" value="<?php echo $menutype;?>" />
<?php
	} 
?>
					</form>
				</div>	
				<div id="bottom" class="fix">
					<a href="javascript:save('edit');" class="button br" id="save"><?php echo a("save");?></a>
					<a href="javascript:save('close');" class="button br" id="save"><?php echo a("save&close");?></a>
					<a href="<?php echo ahref(array($route[0])) ?>" class="button br" id="cancel"><?php echo a("cancel");?></a>
				</div>					
			</div>	
		</div>
<script language="javascript">
	function save(action) {
        $("#tabstop").val(action);
		var validate = 0;
		var msg = "";
		if($("#menutitle").val()=='') {
			msg = "<?php echo a('error.title');?>";
			validate = 0; 
		} else {
			validate = 1;
		}
		if(validate == 1) {		
			document.catform.submit();
		} else {
			alert(msg);
		}
	};

    function nextlang(lang) {
        save(lang);
    }
</script>                
