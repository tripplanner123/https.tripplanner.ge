<?php defined('DIR') OR exit; ?>
<?php
	$menus = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="sitemap" order by id asc, title');
	$categories = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and (type="news" or type="articles" or type="events") order by type, title');
	$lists = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="list" order by type, title');
	$galleries = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type like "%gallery%" order by type, title');
	$polls = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="poll" order by type, title');
	$catalogs = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="catalog" order by type, title');
	$banners = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="banners" order by type, title');
	$faqs = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="faq" order by type, title');

	$categories_cnt = db_fetch('select count(*) as cnt from '.c('table.menus').' where language="'.l().'" and deleted=0 and (type="news" or type="articles" or type="events") order by type, title');
	$lists_cnt = db_fetch('select count(*) as cnt from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="list" order by type, title');
	$galleries_cnt = db_fetch('select count(*) as cnt from '.c('table.menus').' where language="'.l().'" and deleted=0 and type like "%gallery%" order by type, title');
	$polls_cnt = db_fetch('select count(*) as cnt from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="poll" order by type, title');
	$catalogs_cnt = db_fetch('select count(*) as cnt from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="catalog" order by type, title');
	$faqs_cnt = db_fetch('select count(*) as cnt from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="faq" order by type, title');
?>
        <ul id="topnav" class="menu fix">
            <li>
            	<div class="rootmenu" >
					<a href="<?php echo ahref();?>"><?php echo a("home"); ?></a>
                </div>
                <ul></ul>
            </li>
<?php 
	if(getUserRight($_SESSION['auth']["id"], 'sitemap')) {
?>
			<li><div class="rootmenu" ><?php echo a("site"); ?></div>
                <div class="sub">
                    <ul>
<?php
	$cats = $menus;
	foreach($cats as $cat) :
        if ($_SESSION['auth']['class'] > 0 && in_array($cat['id'], array(3,4)))
            continue;
?>                    
						<li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('sitemap', 'show', $cat['id']));?>"><?php echo $cat["title"]; ?></a>
                            </div>
                        </li>
<?php
	endforeach;
?>
                        <li style="background:none;">
                            <div class="submenu1">
								<a href="<?php echo ahref(array('pages'));?>"><?php echo a("menulist"); ?></a>
                            </div>
                        </li>
            		</ul>
                </div>
            </li>
<?php            
	}
	if(getUserRight($_SESSION['auth']["id"], 'files')) {
?>
			<li>
            	<div class="rootmenu" >
					<a href="<?php echo ahref(array('filemanager'));?>"><?php echo a("filemanager"); ?></a>
                </div>
            </li>
<?php 
	}
	if(getUserRight($_SESSION['auth']["id"], 'modules')) {
?>       
			<li><div class="rootmenu" ><?php echo a("modules"); ?></div>
                <div class="sub">
                    <ul>
<?php
		if(getUserRight($_SESSION['auth']["id"], 'categories')) {
			if($categories_cnt["cnt"]>0) {
?>            
                        <li style="background:none;">
                            <div class="submenu">
								<a href="<?php echo ahref(array('categories'));?>"><?php echo a("news.articles"); ?></a>
                            </div>
                        </li>
<?php
			}
		}
		if(getUserRight($_SESSION['auth']["id"], 'lists')) {
			if($lists_cnt["cnt"]>0) {
?>            
                        <li style="background:none;">
                            <div class="submenu">
								<a href="<?php echo ahref(array('lists'));?>"><?php echo a("lists"); ?></a>
                            </div>
                        </li>
<?php
			}
		}
		if(getUserRight($_SESSION['auth']["id"], 'galleries')) {
			if($galleries_cnt["cnt"]>0) {
?>            
                        <li style="background:none;">
                            <div class="submenu">
								<a href="<?php echo ahref(array('gallerylist'));?>"><?php echo a("galleries"); ?></a>
                            </div>
                        </li>
<?php
			}
		}
		if(getUserRight($_SESSION['auth']["id"], 'polls')) {
			if($polls_cnt["cnt"]>0) {
?>            
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('polls'));?>"><?php echo a("polls"); ?></a>
                            </div>
                        </li>
<?php
			}
		}
		if(getUserRight($_SESSION['auth']["id"], 'catalogs')) {
			if($catalogs_cnt["cnt"]>0) {
?>            
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('catalogs'));?>"><?php echo a("catalogs"); ?></a>
                            </div>
                        </li>
<?php
			}
		}
		if(getUserRight($_SESSION['auth']["id"], 'faqs')) {
			if($faqs_cnt["cnt"]>0) {
?>            
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('faqs'));?>"><?php echo a("faqs"); ?></a>
                            </div>
                        </li>
<?php
			}
		}
?>
    	            </ul>
        	    </div>
            </li>
<?php 
	}

	if(getUserRight($_SESSION['auth']["id"], 'users')) {
?>
            <li><div id="users" class="rootmenu" ><?php echo a("users"); ?></div>
                <div class="sub">
                    <ul>

<?php
		if(getUserRight($_SESSION['auth']["id"], 'users')) {
?>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('users'));?>"><?php echo a("userlist"); ?></a>
                            </div>
                        </li>
<?php 
		}
//		if(getUserRight($_SESSION['auth']["id"], 'userrights')) {
?>
                        <!-- <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('userrights'));?>"><?php echo a("userrights"); ?></a>
                            </div>
                        </li> -->
<?php
//		}
//		if(getUserRight($_SESSION['auth']["id"], 'siteusers')) {
?>
                        <!-- <li style="background:none">
                            <div class="submenu1">
								<a href="<?php echo ahref(array('siteusers'));?>"><?php echo a("siteuserlist"); ?></a>
                            </div>
                        </li> -->
<?php
//		}
?>
                    </ul>
                </div>
            </li>
<?php 
	}
?>
            <!-- <li><div id="tools" class="rootmenu" ><?php echo a("tools"); ?></div>
                <div class="sub">
                    <ul>
<?php 
	//if(getUserRight($_SESSION['auth']["id"], 'backup')) {
?>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('backup'));?>"><?php echo a("backup"); ?></a>
                            </div>
                        </li>
<?php 
//	}
?>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('textconverter'));?>"><?php echo a("textconverter"); ?></a>
                            </div>
                        </li>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('log'));?>"><?php echo a("log"); ?></a>
                            </div>
                        </li> 
                        <li style="background:none">
                            <div class="submenu">
                                <a href="<?php echo ahref(array('mailinglistnews'));?>"><?php echo 'News Mailing List'; ?></a>
                                <a href="<?php echo ahref('mailinglistnews','show');?>"><?php echo 'News Mailing List'; ?></a> 
                            </div>
                        </li>
                    </ul>
                </div>
            </li> -->
            
<?php
	if((getUserRight($_SESSION['auth']["id"], 'settings'))||(getUserRight($_SESSION['auth']["id"], 'langdata'))||(getUserRight($_SESSION['auth']["id"], 'adminsettings'))) {
?>
            <li><div id="settings" class="rootmenu" ><?php echo a("settings"); ?></div>
                <div class="sub">
                    <ul>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('textconverter'));?>"><?php echo a("textconverter"); ?></a>
                            </div>
                        </li>
<?php 
		if(getUserRight($_SESSION['auth']["id"], 'settings')) {
?>
                        <li style="background:none">
                            <div class="submenu">
                                <a href="<?php echo ahref(array('settings'));?>"><?php echo a("sitesettings"); ?></a>
                            </div>
                        </li>
<?php 
		}
        if($_SESSION['auth']["class"]==0) {
?>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('langdata'));?>"><?php echo a("sitelanguagedata"); ?></a>
                            </div>
                        </li>
<?php 
?>
                        <li style="background:none;">
                            <div class="submenu1">
								<a href="<?php echo ahref(array('adminsettings'));?>"><?php echo a("adminsettings"); ?></a>
                            </div>
                        </li>
<?php 
		}
?>
    	            </ul>
        	    </div>
            </li>
<?php 
	}
?>
            <!-- <li><div id="help" class="rootmenu" ><?php echo a("help"); ?></div>
                <div class="sub">
                    <ul>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('help'));?>"><?php echo a("help"); ?></a>
                            </div>
                        </li>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref(array('about'));?>"><?php echo a("about"); ?></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </li> -->
        	<!--<li class="last"><div id="tools" class="rootmenu" ><a href="<?php echo ahref(array('help'));?>">Check</a></div></li>-->
        </ul>
<script language="javascript">
$(".rootmenu").mouseover(function(){
    	$(this).css('color', '#999999');
    }).mouseout(function(){
    	$(this).css('color', '#fff');
    });
$(".submenu").mouseover(function(){
    	$(this).css('background', '#575757');
    }).mouseout(function(){
    	$(this).css('background', '#494949');
    });
$(".submenu1").mouseover(function(){
    	$(this).css('background', '#575757');
    }).mouseout(function(){
    	$(this).css('background', '#494949');
    });
</script>
