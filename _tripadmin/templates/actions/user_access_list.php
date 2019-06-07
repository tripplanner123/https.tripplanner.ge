<?php defined('DIR') OR exit; ?>
<?php
	$menus = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="pages" order by type, title');
	$categories = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and (type="news" or type="articles" or type="events") order by type, title');
	$galleries = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type like "%gallery%" order by type, title');
	$polls = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="poll" order by type, title');
	$catalogs = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="catalog" order by type, title');
	$faqs = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="faq" order by type, title');
	$banners = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="banners" order by type, title');
?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/buttons/_table.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo a("useraccess");?></div>
		</div>	
		<div id="box">

   			<form id="dataform" name="dataform" method="post" action="<?php echo ahref(array($route[0], 'save'));?>">
			<div id="part">
				<div id="top" class="fix">
                    <div class="right">
                    	<select name="userid" class="userid inp-small" style="margin:0;">
                        	<option value="0" style="color:#cbcbcb" ><?php echo a("selectuser");?></option>
<?php
	$users = db_fetch_all("SELECT * FROM `" . c('table.users') . "` WHERE `deleted` = 0 AND `class` = 1 AND `usercat` = 'User';");
	foreach($users as $user) :
?>                
                        	<option value="<?php echo $user["id"]; ?>" <?php echo (get('userid', 0) == $user["id"]) ? 'selected' : ''; ?>>
								<?php echo $user["username"].': '.$user["firstname"].' '.$user["lastname"]; ?>
                            </option>
<?php
	endforeach;
?>
                        </select>
                    </div>
				</div>	
<?php
	$suser = db_fetch("SELECT * FROM `" . c('table.users') . "` WHERE id=".get('userid', 0));
	$selected_user = (!empty($suser)) ? $suser["username"].': '.$suser["firstname"].' '.$suser["lastname"] : "";
?>                
				
				<div id="user">
					<div class="list-top">
						<div style="margin-left:15px; float:left; font-weight:bold; font-size:11px; white-space:nowrap;"><?php echo a("selecteduser");?>:</div>
						<div style="margin-left:10px; float:left; font-weight:bold; font-size:11px; white-space:nowrap;"><?php echo $selected_user;?></div>
					</div>

					<div class="list2 fix">
						<div style="float:left;font-weight:bold;"><input type="checkbox" name="allprivileges" style="vertical-align:middle;" id="allprivileges" onclick="javascript:allow();" /><?php echo a('allprivileges');?></div>
						<div style="margin-left:10px;float:left;font-weight:bold;"><input type="checkbox" name="noprivileges" style="vertical-align:middle;" id="noprivileges" onclick="javascript:deny();" /><?php echo a('noprivileges');?></div>
					</div>

<?php
	$acc_pages = 0;
	$acc_filemanager = 0;
	$acc_modules = 0;
	$acc_categories = 0;
	$acc_lists = 0;
	$acc_gallerylist = 0;
	$acc_polls = 0;
	$acc_catalogs = 0;
	$acc_faqs = 0;
	$acc_bannergroups = 0;
	$acc_users = 0;
	$acc_siteusers = 0;
	$acc_backup = 0;
	$acc_settings = 0;
	$acc_langdata = 0;
	$acc_adminsettings = 0;
	foreach($user_access as $access) :
		switch($access["action"]) :
			case "pages" : 			$acc_pages = 1; break;
			case "filemanager" : 	$acc_filemanager = 1; break;
			case "modules" : 		$acc_modules = 1; break;
			case "categories" : 	$acc_categories = 1; break;
			case "lists" : 			$acc_lists = 1; break;
			case "galleries" : 		$acc_gallerylist = 1; break;
			case "polls" : 			$acc_polls = 1; break;
			case "catalogs" : 		$acc_catalogs = 1; break;
			case "faqs" : 			$acc_faqs = 1; break;
			case "bannergroups" : 	$acc_bannergroups = 1; break;
			case "users" : 			$acc_users = 1; break;
			case "siteusers" : 		$acc_siteusers = 1; break;
			case "backup" : 		$acc_backup = 1; break;
			case "settings" : 		$acc_settings = 1; break;
			case "langdata" : 		$acc_langdata = 1; break;
			case "adminsettings" : 	$acc_adminsettings = 1; break;
		endswitch;
	endforeach;
?>
					<div class="list fix">
						<input type="checkbox" style="float:left; padding-right:80px" name="pages" <?php echo (($selected_user!='')&&($acc_pages==1)) ? 'checked="checked"' : '';?> />
						<div class="users-name" style="margin-left:15px;"><?php echo a("site");?> </div>					
						
						<input type="checkbox" style="float:left; padding-right:80px" name="filemanager" <?php echo (($selected_user!='')&&($acc_filemanager==1)) ? 'checked="checked"' : '';?> />
						<div class="users-name" style="margin-left:15px;"><?php echo a("filemanager");?> </div>					
						
					</div>

					<div class="list2 fix">
						<input type="checkbox" style="float:left; padding-right:80px" name="modules" <?php echo (($selected_user!='')&&($acc_modules==1)) ? 'checked="checked"' : '';?> />
						<div class="users-name" style="margin-left:15px;"><?php echo a("modules");?> </div>					
						
						<input type="checkbox" style="float:left; padding-right:80px" name="categories" <?php echo (($selected_user!='')&&($acc_categories==1)) ? 'checked="checked"' : '';?> />
						<div class="users-name" style="margin-left:15px;"><?php echo a("news.articles"); ?> </div>					
						
					</div>

					<div class="list fix">
						<input type="checkbox" style="float:left; padding-right:80px" name="lists" <?php echo (($selected_user!='')&&($acc_lists==1)) ? 'checked="checked"' : '';?> />
						<div class="users-name" style="margin-left:15px;"><?php echo a("lists"); ?> </div>					
						
						<input type="checkbox" style="float:left; padding-right:80px" name="galleries" <?php echo (($selected_user!='')&&($acc_gallerylist==1)) ? 'checked="checked"' : '';?> />
						<div class="users-name" style="margin-left:15px;"><?php echo a("galleries"); ?> </div>					
						
					</div>

					<div class="list2 fix">
						<input type="checkbox" style="float:left; padding-right:80px" name="users" <?php echo (($selected_user!='')&&($acc_users==1)) ? 'checked="checked"' : '';?> />
						<div class="users-name" style="margin-left:15px;"><?php echo a("users");?> </div>					
						
						<input type="checkbox" style="float:left; padding-right:80px" name="siteusers" <?php echo (($selected_user!='')&&($acc_siteusers==1)) ? 'checked="checked"' : '';?> />
						<div class="users-name" style="margin-left:15px;"><?php echo a("siteuserlist");?> </div>					
						
					</div>

					<div class="list fix">
						<input type="checkbox" style="float:left; padding-right:80px" name="backup" <?php echo (($selected_user!='')&&($acc_backup==1)) ? 'checked="checked"' : '';?> />
						<div class="users-name" style="margin-left:15px;"><?php echo a("backup");?> </div>					
						<input type="checkbox" style="float:left; padding-right:80px" name="settings" <?php echo (($selected_user!='')&&($acc_settings==1)) ? 'checked="checked"' : '';?> />
						<div class="users-name" style="margin-left:15px;"><?php echo a("sitesettings");?> </div>					
						
					</div>

					<div class="list2 fix">
						<input type="checkbox" style="float:left; padding-right:80px" name="langdata" <?php echo (($selected_user!='')&&($acc_langdata==1)) ? 'checked="checked"' : '';?> />
						<div class="users-name" style="margin-left:15px;"><?php echo a("sitelanguagedata");?> </div>					
						<input type="checkbox" style="float:left; padding-right:80px" name="adminsettings" <?php echo (($selected_user!='')&&($acc_adminsettings==1)) ? 'checked="checked"' : '';?> />
						<div class="users-name" style="margin-left:15px;"><?php echo a("adminsettings");?> </div>					
						
					</div>
        	    </div>

				</div>	
				<div id="bottom" class="fix">
                    <a href="javascript:save();" class="button br" style="float: left;"><?php echo a("save");?></a>
                    <div class="right">
                    	<select class="userid inp-small right" style="margin:0;">
                        	<option value="0" style="color:#cbcbcb" ><?php echo a("selectuser");?></option>
<?php
	$users = db_fetch_all("SELECT * FROM `" . c('table.users') . "` WHERE `deleted` = 0 AND `class` = 1 AND `usercat` = 'User';");
	foreach($users as $user) :
?>                
                        	<option value="<?php echo $user["id"]; ?>" <?php echo (get('userid', 0) == $user["id"]) ? 'selected' : ''; ?>>
								<?php echo $user["username"].': '.$user["firstname"].' '.$user["lastname"]; ?>
                            </option>
<?php
	endforeach;
?>
                        </select>
                    </div>
				</div>					
			</div>		
            </form>
		</div>
<script language="javascript">
$('.userid').on('change', function(){
	window.location="<?php echo ahref(array($route[0])) ?>?userid=" + $(this).val();
});

$(".list").mouseover(function(){
    	$(this).css('background', '#ededed');
    }).mouseout(function(){
    	$(this).css('background', '#f8f8f8');
    });
$(".list2").mouseover(function(){
    	$(this).css('background', '#ededed');
    }).mouseout(function(){
    	$(this).css('background', '#ffffff');
    });

function allow() {
	$(":input[type='checkbox']").attr('checked',true); 	
	$("#allprivileges").attr('checked',false); 	
	$("#noprivileges").attr('checked',false); 	
}	

function deny() {
	$(":input[type='checkbox']").attr('checked',false); 	
	$("#allprivileges").attr('checked',false); 	
	$("#noprivileges").attr('checked',false); 	
}	
function save() {
	document.dataform.submit();
}
</script>
