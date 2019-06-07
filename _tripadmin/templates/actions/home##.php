<?php defined('DIR') OR exit; ?>
        <div id="home-t" class="fix">
			<div class="title"><?php echo a("welcome"). ' ' . a("website") . ': "' . s('sitetitle') . '" ' . a("CMS"); ?></div>
            <div id="line"></div>
            <div class="clear"></div>
<?php
	if ($handle = opendir(c('folders.backup'))) {
		$files = array(); 
	    while (false !== ($file = readdir($handle))) {
		 	if ($file != "." && $file != "..") {
				$files[] = $file; 
			}
		}
		if(empty($files)) {
			$filedate = strtotime('2010-01-01');
		} else {
			rsort($files); 
			closedir($handle); 
			$ext = strtolower(substr(strrchr($files[0], '.'), 1));
			$filedate = ($ext == 'sql') ? substr($files[0], 10, 19) : substr($files[0], 12, 19);
			$filedate = str_replace('_', ' ', str_replace('.', ':', $filedate));
			$filedate = strtotime($filedate);
		}
	} else {
		$filedate = strtotime(date('Y-m-d'));
	}
	$date1 = time(); 
	$dateDiff = $date1 - $filedate;
	$fulldays = floor($dateDiff/(60*60*24));
	$fullmonths = floor($dateDiff/(60*60*24*30));
	if($fullmonths>0) {
?>
			<!-- <div id="boxred">
                <div id="partred">
                    <?php echo str_replace('%s', $fullmonths, a("backup.alert")) ?> <a href="<?php echo ahref(array('backup')) ?>" style="color:#ff2222; text-decoration:underline;"><?php echo a("backup.create") ?></a>
                </div>
             </div> -->
<?php
	} elseif($fulldays>30) {
?>
			<!-- <div id="boxyellow">
				<div id="partyellow">
                	<?php echo str_replace('%s', $fulldays, a("backup.warning")) ?> <a href="<?php echo ahref(array('backup')) ?>" style="color:#ffaa22; text-decoration:underline;"><?php echo a("backup.create") ?></a>
                </div>
            </div> -->
<?php
	}
?>
			<div class="homelist fix">
				<div class="micon br">
                    <div class="info">
                        <!--<div class="blockname dgrey">General</div>-->
                        <div class="blocktext"><span class="grey b"><?php echo a("websitename"); ?>:</span> <?php echo s('sitetitle') ;?></div>
                        <div class="blocktext"><span class="grey b"><?php echo a("websiteaddress"); ?>:</span> <a href="<?php echo href(); ?>"><?php echo href(); ?></a></div>			
                        <div class="blocktext"><span class="grey b"><?php echo a("user"); ?>:</span> <a href="<?php echo ahref(array('users')) ?>"><?php echo $_SESSION['auth']['username']; ?></a> (<?php echo $_SESSION['auth']['usercat'] ?>)</div>						
					</div>	
                </div>
			</div>					
            
			<div class="homelist fix" style="width:34%">
				<div class="micon br">
                    <div class="info">
                        <!--<div class="blockname dgrey">General</div>-->
                        <div class="blocktext"><span class="grey b"><?php echo a("cmsversion"); ?>:</span> <?php echo c("cmsversion");?></div>
                        <div class="blocktext"><span class="grey b"><?php echo a("ipaddress"); ?>:</span> <?php echo get_ip() . ' : ' . $_SERVER['REMOTE_ADDR'];?></div>						
					</div>	
                </div>
			</div>					
            
			<div class="homelist fix">
				<div class="micon br">
                    <div class="info">
                        <!--<div class="blockname dgrey">General</div>-->
							<?php
                                $sql = 'SELECT * FROM ' . c('table.log') .' WHERE (`action` <> "main" or `pagetitle` <> "main") and `subaction` = "show" ORDER BY id DESC LIMIT 1';
                                $page = db_fetch($sql);
                                $sectitle = '';
                                $menu = $page["menu"];
                                if($menu!='0') {
                                    $sqlm = 'SELECT ' . c('table.menus') .'.* FROM ' . c('table.menus') .' WHERE  
                                            ' . c('table.menus') . '.language = "' . $page['language'] . '" and 
                                            ' . c('table.menus') . '.id = "' . $menu . '" LIMIT 1';
                                    $resm = db_fetch($sqlm);
                                    if(in_array($resm['type'], array('pages', 'bannergroups'))) {
                                        $sectitle = ' - ' . $resm['title'];
                                    } else {
                                        $sqlp = 'SELECT ' . c('table.pages') .'.* FROM ' . c('table.pages') .', ' . c('table.menus') .' WHERE  
                                                ' . c('table.pages') . '.attached = ' . c('table.menus') . '.title and 
                                                ' . c('table.pages') . '.language = "' . $page['language'] . '" and 
                                                ' . c('table.menus') . '.language = "' . $page['language'] . '" and 
                                                ' . c('table.menus') . '.id = "' . $menu . '" LIMIT 1';
                                        $resp = db_fetch($sqlp);
                                        $sectitle = ' - ' . $resp['title'];
                                    }
                                }
                            ?>
                        <div class="blocktext"><span class="grey b"><?php echo a("lastvisitdate"); ?>:&nbsp;&nbsp;</span><?php echo $page['visitdate'];?></div>
                        <div class="blocktext"><span class="grey b"><?php echo a("lastvisitedpages"); ?>:&nbsp;&nbsp;<a href="<?php echo $page['href'];?>" style="color:#4e9be6;"><?php echo $page['pagetitle'] . $sectitle;?></a></div>
					</div>	
                </div>
			</div>					
            
			<div class="clear"></div>
				<?php
                    if(getUserRight($_SESSION['auth']["id"], 'pages')) {
                ?>                    
			<div class="smartblock fix">
				<div class="content br">
						<a href="<?php echo ahref(array('pages'));?>"><div class="title"><?php echo a("site"); ?></div></a>
                        <div class="line"></div>
						<?php 
                            $cats = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="sitemap" order by type, title limit 5');
                            $index = '3';
                            foreach($cats as $cat) :
                                $index = ($index=='3') ? '4' : '3';
                        ?>                    
                        <div class="list<?php echo $index;?> fix" style=" <?php echo ($index=='4') ? 'border:1px solid #e1e1e1;' : '';?>">
                            <div class="name left"><a href="<?php echo ahref(array('sitemap', 'show', $cat['id']));?>"><span class="grey b"><?php echo $cat["title"]; ?></span></a></div>	
                            <div class="smicon"><a href="<?php echo ahref(array('sitemap', 'show', $cat['id']));?>"><img src="_manager/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.edit');?>" /></a></div> 	
                        </div>					
						<?php
                            endforeach;
                        ?>
                </div>
			</div>					
			<?php 
                }
                if(getUserRight($_SESSION['auth']["id"], 'modules')) {
            ?>       
			<div class="smartblock fix" style="width:34%">
				<div class="content br">
						<a href="<?php echo ahref(array('categories'));?>"><div class="title"><?php echo a("news"); ?></div></a>
                        <div class="line"></div>
						<?php
                            $cats = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and (type="news" or type="articles" or type="events" or type="list") order by type, title limit 5');
                            $index = '3';
                            foreach($cats as $cat) :
                                $index = ($index=='3') ? '4' : '3';
                                if(getUserRight($_SESSION['auth']["id"], 'categories')) {
                        ?>                    
                        <?php $act=$cat["type"]; if($cat["type"]=='list') $act='customlist'; ?>
                        <div class="list<?php echo $index;?> fix" style=" <?php echo ($index=='4') ? 'border:1px solid #e1e1e1;' : '';?>;">
                            <div class="name left"><a href="<?php echo ahref(array($act ,'show', $cat['id']));?>"><span class="grey b"><?php echo $cat['title']; ?></span></a></div>
                            <div class="smicon"><a href="<?php echo ahref(array($act ,'show', $cat['id']));?>"><img src="_manager/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.edit');?>" /></a></div> 	
                        </div>
                        <?php
                                }
                            endforeach;
                        ?>
                </div>	
			</div>	

			<div class="smartblock fix">
				<div class="content br">
						<a href="<?php echo ahref(array('gallerylist'));?>"><div class="title"><?php echo a("galleries"); ?></div></a>
                        <div class="line"></div>
						<?php
                            $cats = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type like "%gallery%" order by type, title limit 5');
                            $index = '3';
                            foreach($cats as $cat) :
                                $index = ($index=='3') ? '4' : '3';
                                if(getUserRight($_SESSION['auth']["id"], 'galleries')) {
                        ?>                    
                        <div class="list<?php echo $index;?> fix" style=" <?php echo ($index=='4') ? 'border:1px solid #e1e1e1;' : '';?>">
							<div class="name left"><a href="<?php echo ahref(array($cat["type"] ,'show', $cat['id']));?>"><span class="grey b"><?php echo $cat['title']; ?></span></a></div>
                            <div class="smicon"><a href="<?php echo ahref(array($cat["type"] ,'show', $cat['id']));?>"><img src="_manager/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.edit');?>" /></a></div> 	
                        </div>
						<?php
                                }
                            endforeach;
                        ?>
                </div>
			</div>	

			<div class="clear"></div>

			<div class="smartblock fix">
				<div class="content br">
						<a href="<?php echo ahref(array('bannergroups'));?>"><div class="title"><?php echo a("banners"); ?></div></a>
                        <div class="line"></div>
						<?php
                            $cats = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="banners" order by type, title limit 5');
                            $index = '3';
                            foreach($cats as $cat) :
                                $index = ($index=='3') ? '4' : '3';
                        ?>                    
                        <div class="list<?php echo $index;?> fix" style=" <?php echo ($index=='4') ? 'border:1px solid #e1e1e1;' : '';?>">
							<div class="name left"><a href="<?php echo ahref(array('banners' ,'show', $cat['id']));?>"><span class="grey b"><?php echo $cat["title"]; ?></span></a></div>						
                            <div class="smicon"><a href="<?php echo ahref(array('banners' ,'show', $cat['id']));?>"><img src="_manager/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.edit');?>" /></a></div> 	
                        </div>
						<?php
                            endforeach;
                        ?>
                </div>
			</div>	
			<?php 
                }
                if(getUserRight($_SESSION['auth']["id"], 'users')) {
            ?>
			<div class="smartblock fix" style="width:34%">
				<div class="content br">
						<a href="<?php echo ahref(array('users')) ?>"><div class="title"><?php echo a("userlist"); ?></div></a>
                        <div class="line"></div>
                        <div class="list4 fix" style="border:1px solid #e1e1e1;">
							<div class="name left"><a href="<?php echo ahref(array('users')) ?>"><span class="grey b"><?php echo a("userlist"); ?></span></a></div>
                            <div class="smicon"><a href="<?php echo ahref(array('users')) ?>"><img src="_manager/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.edit');?>" /></a></div> 	
                        </div>						
                        <div class="list3 fix">
							<div class="name left"><a href="<?php echo ahref(array('users', 'add')) ?>"><span class="grey b"><?php echo a("newuser"); ?></span></a></div>							
                            <div class="smicon"><a href="<?php echo ahref(array('users', 'add')) ?>"><img src="_manager/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.edit');?>" /></a></div> 	
                        </div>
						<?php
                                if(getUserRight($_SESSION['auth']["id"], 'userrights')) {
                        ?>
                        <div class="list4 fix" style="border:1px solid #e1e1e1;">
							<div class="name"><a href="<?php echo ahref(array('userrights')) ?>"><span class="grey b"><?php echo a("userrights"); ?></span></a></div>	
                            <div class="smicon"><a href="<?php echo ahref(array('userrights')) ?>"><img src="_manager/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.edit');?>" /></a></div> 	
                        </div>					
					<?php
                            }
                    ?>                        
				</div>	
			</div>	
			<?php
                }
                if((getUserRight($_SESSION['auth']["id"], 'settings'))||(getUserRight($_SESSION['auth']["id"], 'langdata'))||(getUserRight($_SESSION['auth']["id"], 'backup'))) {
            ?>

			<div class="smartblock fix">
				<div class="content br">
                    <div class="title"><?php echo a("settings").'/'.a("tools");?></div>
                    <div class="line"></div>
                    <?php
                        if(getUserRight($_SESSION['auth']["id"], 'settings')) {
                    ?>
                    <div class="list4 fix" style="border:1px solid #e1e1e1;">
                        <div class="name"><a href="<?php echo ahref(array('settings')) ?>"><span class="grey b"><?php echo a("sitesettings");?></span></a></div>						
                        <div class="smicon"><a href="<?php echo ahref(array('settings')) ?>"><img src="_manager/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.edit');?>" /></a></div> 	
                    </div>
                    <?php
                        }
                        if(getUserRight($_SESSION['auth']["id"], 'langdata')) {
                    ?>
                    <div class="list3 fix">
                        <div class="name"><a href="<?php echo ahref(array('langdata')) ?>"><span class="grey b"><?php echo a("sitelanguagedata");?></span></a></div>						
                        <div class="smicon"><a href="<?php echo ahref(array('langdata')) ?>"><img src="_manager/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.edit');?>" /></a></div> 	
                    </div>
                    <?php
                        }
                    ?>
                </div>
			</div>	
			<?php
                }
            ?>
		</div>
