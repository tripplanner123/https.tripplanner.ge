<?php

defined('DIR') OR exit;

class Admin_Manager
{

    protected $content,
    $route = array(),
    $navigation = array();

    public function __construct()
    {
        $this->route = Storage::instance()->route;
        (isset($_SESSION['auth']) AND !empty($_SESSION['auth'])) AND v() OR $this->access();
		// $this->write_log();
    }

	public function write_log()
	{
		$ipaddress = get_ip() . ' : ' . $_SERVER['REMOTE_ADDR'];
		switch($this->route[0]) :
			case 'files': 			$pagetitle = 'File Attachements'; break;
			case 'poll': 			$pagetitle = 'Poll Management'; break;
			case 'polls': 			$pagetitle = 'Polls Management'; break;
			case 'catalog': 		$pagetitle = 'Catalog Management'; break;
			case 'catalogs': 		$pagetitle = 'Catalogs Management'; break;
			case 'pages': 			$pagetitle = 'Sitemap Management'; break;
			case 'sitemap': 		$pagetitle = 'Site Map'; break;
			case 'faq': 			$pagetitle = 'FAQ Management'; break;
			case 'faqs':	 		$pagetitle = 'FAQ Pages Management'; break;
			case 'news': 			$pagetitle = 'News List'; break;
			case 'customnews': 		$pagetitle = 'News List'; break;
			case 'articles': 		$pagetitle = 'Article List'; break;
			case 'events': 			$pagetitle = 'Event List'; break;
			case 'lists': 			$pagetitle = 'Lists Management '; break;
			case 'customlist': 		$pagetitle = 'List Management'; break;
			case 'videogallery': 	$pagetitle = 'Video gallery'; break;
			case 'imagegallery': 	$pagetitle = 'Image gallery'; break;
			case 'audiogallery': 	$pagetitle = 'Audio gallery'; break;
			case 'bannergroups': 	$pagetitle = 'Banner Group Management'; break;
			case 'banners': 		$pagetitle = 'Banner Management'; break;
			case 'gallerylist': 	$pagetitle = 'Gallery Management'; break;
			case 'settings': 		$pagetitle = 'Site Settings'; break;
			case 'adminsettings': 	$pagetitle = 'Admin Settings'; break;
			case 'langdata': 		$pagetitle = 'Site Phrases'; break;
			case 'users': 			$pagetitle = 'User Management'; break;
			case 'siteusers': 		$pagetitle = 'Site User Management'; break;
			case 'cart': 			$pagetitle = 'Cart Management'; break;
			case 'userrights': 		$pagetitle = 'User Right Management'; break;
			case 'filemanager': 	$pagetitle = 'File Manager'; break;
			case 'backup': 			$pagetitle = 'Database Backup'; break;
			case 'textconverter': 	$pagetitle = 'Text Converter'; break;
			case 'log': 			$pagetitle = 'Admin Log'; break;
			default: 				$pagetitle = 'Main'; break;
		endswitch;
		$menu = get('menu', '0');
		$lang = l();

		$href = $_SERVER['REQUEST_URI'];
		$sql='insert into ' . c('table.log') . ' (user, action, subaction, menu, language, visitdate, href, ipaddress, pagetitle) values ("' . $_SESSION['auth']['username'] . '", "' . $this->route[0] . '", "' . $this->route[1] . '", "' . $menu . '",  "' . $lang . '", "' . date('Y-m-d H:i:s') . '", "' . $href . '", "' . $ipaddress . '", "' . $pagetitle . '");';
		db_query($sql);
	}

    public function __toString()
    {
    	if(isset($_GET["ajax"])) {
    		$s = $this->content;
    		return (string)$s;
    	} else {
	        return template('layout', array(
	            'header' => template('header', array(
	                'action' => $this->route[0],
	                'subaction' => $this->route[1]
	            )),
	            'left' => template('left', array(
	                'action' => $this->route[0],
	                'navigation' => $this->navigation
	            )),
	            'content' => $this->content,
	            'footer' => template('footer'),
	        ));
	    }
    }

    public function access()
    {
        $tpl['message'] = '';
        switch ($this->route[1]):
            case 'login':
                post('perform') === FALSE AND redirect(ahref());
                $username = $_POST['username'];
                $password = hash('sha512', $_POST['password']);
                $sql = "SELECT * FROM users WHERE username='{$username}' AND password = '{$password}' LIMIT 1;";
                $user = db_fetch($sql);

                if (empty($user))
                {
                    $tpl['message'] = a('admin.incorrect_password');
                    break;
                }
				if((strtoupper(a_s("ipprotection"))=='YES')&&($user["class"]=='1')) {
					$ip_list=explode(',', a_s("iplist"));
					$in_array = 0;
					foreach($ip_list as $key=>$value) :
						$cur_ip = trim(get_ip(), ' ');
						if($cur_ip == trim($value)) $in_array = 1;
					endforeach;
					if($in_array==0)
					// if(!in_array($cur_ip, $ip_list))
					{
						$tpl['message'] = a('admin.access_denied');
						break;
					}
				}
                session_regenerate_id();
                $_SESSION['auth'] = $user;
				if(getUserRight($_SESSION['auth']["id"], get('action',''), get('subaction','')))
	                if($_SESSION['auth']["id"]==4){
	                	redirect(ahref(array('cart')));
	                }else{
	                	redirect(ahref(array('sitemap')));	
	                }
	                
	            else
	                redirect(ahref(array('main')));
                break;
            case 'logout':
                if (isset($_SESSION['auth']) AND !empty($_SESSION['auth']))
                {
                    unset($_SESSION['auth']);
                    redirect(ahref());
                }
                redirect(ahref());
                break;
        endswitch;
        exit(template('access', $tpl));
    }

    protected function _lists($order_by = 'position', $pager = 'false', $title='sitemap', $form_template = 'actions/_lists_forms', $list_template = 'actions/_lists')
    {
		$start=0; if(isset($_GET["start"])) $start=$_GET["start"];
        $tpl = $params = array();
        $srch = get('srch', '');
        if ($srch)
	        $srch =  ' AND `title` LIKE "%' . $srch . '%"';
		$cnt = db_fetch('SELECT count(*) AS cnt FROM `'.c("table.pages").'` WHERE language="'.l().'" AND deleted=0 AND menuid={$this->route[2]}'.$srch);
		$tpl["count"] = $cnt["cnt"];
		$tpl["start"] = $start;
        $params['start'] = $start;
        isset($_GET['level']) AND $params['level'] = $_GET['level'];
        $tpl['route'] = $this->route;
        $tpl['params'] = $params;
        $tpl['title'] = a($title) .': '. db_retrieve('title', c("table.menus"), 'id', $this->route[2], ' and language = "'.l().'" LIMIT 1');
        $tpl['edit'] = array();
        $tpl['pager'] = $pager;
		$lng = l();
		
        switch ($this->route[1]):
            case 'show':
                $tpl['order_by'] = $order_by;
                $this->content = template($list_template, $tpl);
                break;
            case 'visibility':
// AJAX CALL
                $update = db_update(c("table.pages"), array('visibility' => $_GET['visibility']), "WHERE `id` = {$_GET['id']} and language='".l()."'");
                db_query($update);
                break;
            case 'delete':
// AJAX CALL
                $update = db_update(c("table.pages"), array('deleted' => 1), "WHERE `id` = {$_GET['id']}");
                db_query($update);
				$category = db_retrieve('category', c("table.pages"), 'id', $_GET['id'], "AND language = '{$lng}' LIMIT 1");
				if(in_array($category, array(8,9,10,11,12,13,14,15,16,17))) {
					$menutype = db_retrieve('menutype', c("table.pages"), 'id', $_GET["id"]);
					$update = db_update(c("table.menus"), array('deleted' => 1), "WHERE `id` = {$menutype}");
					db_query($update);
				}
                break;
            case 'collapse':
                $update = db_update(c("table.pages"), array('collapsed' => 1), "WHERE `menuid` = {$this->route[2]}");
                db_query($update);
                redirect(ahref(array($this->route[0], 'show', $this->route[2])));
                break;
            case 'expand':
                $update = db_update(c("table.pages"), array('collapsed' => 0), "WHERE `menuid` = {$this->route[2]}");
                db_query($update);
                redirect(ahref(array($this->route[0], 'show', $this->route[2])));
                break;
            case 'move':
                $sql = "SELECT id, level, position, masterid FROM `".c("table.pages")."` WHERE `id` = {$_GET['id']};";
                $result = db_fetch($sql);
				$pos1 = $result['position'];
                switch ($_GET['where']):
                    case 'up':
                        $pos_sql = "< {$result['position']} ORDER BY `position` DESC";
                        break;
                    case 'down':
                        $pos_sql = "> {$result['position']} ORDER BY `position`";
                        break;
                endswitch;
                $sql = "SELECT id, level, position, masterid FROM `".c("table.pages")."` WHERE `language` = '" . l() . "' AND `menuid` = '{$_GET['menu']}' AND `masterid` = {$result['masterid']} AND `level` = {$result['level']} AND `deleted` = 0 AND `position` {$pos_sql} LIMIT 1;";
                $result = db_fetch($sql);
				$pos2 = $result['position'];
                $update1 = db_update(c("table.pages"), array('position' => $pos2), "WHERE `id` = {$_GET['id']};");
                db_query($update1);
                $update2 = db_update(c("table.pages"), array('position' => $pos1), "WHERE `id` = {$result['id']};");
                db_query($update2);
                redirect(ahref(array($this->route[0], 'show', $_GET['menu']), array('pos' => $_GET["pos"])));
                break;
			case 'add':
            	$sql = db_fetch("SELECT title from ".c("table.menus")." where id = {$this->route[2]} and type = '{$title}' limit 1");

            	if(isset($_POST["description"]) && isset($_POST["content"])){
	            	$_POST["description"] = str_replace(array('"', "'"), array("&ldquo;", "&lsquo;"), $_POST["description"]);
	            	$_POST["content"] = str_replace(array('"', "'"), array("&ldquo;", "&lsquo;"), $_POST["content"]);
            	}

            	// echo "hi";
//            var_dump($this->route); die();
            	$sql OR redirect(ahref(array('sitemap')));
                $tpl['menuid'] = $this->route[2];
				$tpl["pagetitle"] = $sql['title'];
                if (isset($_POST['perform']) && !empty($_POST['title'])):
// ADD TOPIC
					if(isset($_POST["category"]) && in_array($_POST["category"], array(8,9,10,11,12,13,14,15,16,17))) {
						switch($_POST["category"]) {
							case 8:  $menucat = "news"; break;
							case 9:  $menucat = "articles"; break;
							case 10: $menucat = "events"; break;
							case 11: $menucat = "list"; break;
							case 12: $menucat = "imagegallery"; break;
							case 13: $menucat = "videogallery"; break;
							case 14: $menucat = "audiogallery"; break;
							case 15: $menucat = "poll"; break;
							case 16: $menucat = "catalog"; break;
							case 17: $menucat = "faq"; break;
						}
						$id = db_fetch('select max(id) as maxid from `'.c("table.menus").'`');
						$new_id = $id["maxid"]+1;
						foreach(c('languages.all') as $language):
                            $title = ($language == l()) ?  $_POST['title'] : $_POST['title'] . ' (' . strtoupper($language) . ')';
							$insert = db_insert(c("table.menus"), array(
										'id' => $new_id,
										'title' => $title,
										'items_per_page' => c('news.per_page'),
										'items_on_homepage' => c('news.per_page'),
										'language' => $language,
										'type' => $menucat
									));
							db_query($insert);
						endforeach;
						$_POST['menutype'] = $new_id;
					}
// ADD TOPIC
					$tabstop = $_POST["tabstop"];
                    $new_id_res = db_fetch("SELECT MAX(`id`) AS `num` FROM `".c("table.pages")."`;");
                    $new_id = $new_id_res['num'] + 1;
                    $_POST['id'] = $new_id;
                    $_POST['position'] = $new_id;
                    $languages = c('languages.all');
                    if (!empty($languages))
                    {
						$title = $_POST['title'];
						$_POST['menutitle'] = empty($_POST['menutitle']) ? "0" : $_POST['menutitle'];
						$slug = empty($_POST['slug']) ? $_POST['title'] : $_POST['slug'];
						$posttime = isset($_POST["posttime"]) ? $_POST["posttime"]:date("H:i:s");
						$_POST["postdate"] .= ' ' . $posttime;
						$_POST["visibility"] = (isset($_POST["visibility"])) ? 1 : 0;
						$_POST["homepage"] = (isset($_POST["homepage"])) ? 1 : 0;

						$columns = db_fetch_all("SELECT column_name FROM information_schema.columns WHERE table_schema = '".c('database.name')."' AND table_name = '".c('table.pages')."';","column_name");
						$columns2 = array();
						foreach ($columns as $key2 => $value) {
							$columns2[$value["column_name"]] = $key2;
						}	

                        foreach ($languages as $language)
                        {
                            $_POST['language'] = $language;
                            $_POST['masterid'] = get('id', 0);
                            $_POST['title'] = ($language == l()) ?  $title : $title . ' (' . strtoupper($language) . ')';
                            $_POST['slug'] = new_slug($slug, $_POST['masterid'], FALSE);

							if ($language==l()) {
				                if ($_POST["meta_desc"]=='') {
									$_POST["meta_desc"] = text_match(text_limit(($_POST["description"]=='') ? $_POST["content"] : $_POST["description"]), $_POST["title"]);
				                	if ($_POST["meta_desc"]=='')
				                		$_POST["meta_desc"] = text_match(text_limit((s('description')=='') ? $_POST["title"] : s('description')), $_POST["title"]);
				                }

				                if ($_POST["meta_keys"]=='') {
				                    $_POST["meta_keys"] = keyword_maker(($_POST["content"]!='' || $_POST["description"]!='') ? $_POST["title"]." ".$_POST["title"]." ".$_POST["content"]." ".$_POST["description"] : $_POST["title"]." ".$_POST["title"]." ".s('sitetitle')." ".s('sitetitle')." ".s('keywords')." ".s('keywords'));
				                }
							} else {
								$_POST["meta_desc"]='';
								$_POST["meta_keys"]='';
							}

			                $data = array_diff($_POST, array(''));
							$data = array_intersect_key($data, $columns2);

                            $insert = db_insert(c("table.pages"), $data);
                            db_query($insert);
                        }
                    }
					if($tabstop == 'close')
    	                redirect(ahref(array($this->route[0], 'show', $this->route[2]), $params));
					$params['id'] = $new_id;
                    redirect(ahref(array($this->route[0], 'edit', $params['id']), array('tabstop' => $tabstop)));
	                break;
                endif;
                $this->content = template($form_template, $tpl);
                break;
            case 'edit':
                $edit = "SELECT * FROM `".c("table.pages")."` WHERE `id` = {$this->route[2]} and language='".l()."' LIMIT 1;";

                if(isset($_POST["description"]) && isset($_POST["content"])){
	                $_POST["description"] = str_replace(array('"', "'"), array("&ldquo;", "&lsquo;"), $_POST["description"]);
	            	$_POST["content"] = str_replace(array('"', "'"), array("&ldquo;", "&lsquo;"), $_POST["content"]);
            	}

                $tpl['edit'] = db_fetch($edit);
                // echo "<pre>";
                // print_r($tpl["edit"]);
                // echo "</pre>";
                $tpl['edit'] OR redirect(ahref(array('sitemap')));
				$slugpos = strpos($tpl['edit']['slug'], '/');
				if ($slugpos !== false) {
					$tpl['edit']['slug'] = substr(strrchr($tpl['edit']['slug'], '/'), 1);
				}
                $tpl['menuid'] = $tpl['edit']['menuid'];
                $tpl['edit_mode'] = TRUE;
				$tpl["pagetitle"] = db_retrieve('title', c("table.menus"), 'id', $tpl['edit']['menuid'], ' and language="'.l().'" LIMIT 1');
                if (isset($_POST['perform']) && !empty($_POST['title'])):
// ADD TOPIC
					if(isset($_POST["category"]) && in_array($_POST["category"], array(8,9,10,11,12,13,14,15,16,17))) {
						if($_POST["menutype"]!=$_POST["category"]) {
							switch($_POST["category"]) {
								case 8:  $menucat = "news"; break;
								case 9:  $menucat = "articles"; break;
								case 10: $menucat = "events"; break;
								case 11: $menucat = "list"; break;
								case 12: $menucat = "imagegallery"; break;
								case 13: $menucat = "videogallery"; break;
								case 14: $menucat = "audiogallery"; break;
								case 15: $menucat = "poll"; break;
								case 16: $menucat = "catalog"; break;
								case 17: $menucat = "faq"; break;
							}
							$id = db_fetch('select max(id) as maxid from `'.c("table.menus").'`');
							$new_id = $id["maxid"]+1;
							foreach(c('languages.all') as $language) :
								$insert = db_insert(c("table.menus"), array(
											'id' => $new_id,
											'title' => $_POST["title"],
											'items_per_page' => c('news.per_page'),
											'items_on_homepage' => c('news.per_page'),
											'language' => $language,
											'type' => $menucat
										));
								db_query($insert);
							endforeach;
							$_POST['menutype'] = $new_id;
		                    $update = db_update(c("table.pages"), array('menutype' => $_POST['menutype'], 'category' => $_POST["category"]), "WHERE `id` = {$this->route[2]}");
		                    db_query($update);
						}
					}
					if(!empty($_POST["menutype"])) {
						$update = db_update(c("table.menus"), array('title' => $_POST["title"]), "WHERE `id` = {$_POST["menutype"]} and language='".l()."' limit 1");
						db_query($update);
					}
// ADD TOPIC
					$tabstop = $_POST["tabstop"];
					$_POST['menutitle'] = empty($_POST['menutitle']) ? "0" : $_POST['menutitle'];
					$_POST["postdate"] .= ' ' . $_POST["posttime"];
					$_POST["visibility"] = (isset($_POST["visibility"])) ? 1 : 0;
					$_POST["homepage"] = (isset($_POST["homepage"])) ? 1 : 0;

		                if ($_POST["meta_desc"]=='') {
		                    $_POST["meta_desc"] = text_match(text_limit(($_POST["description"]=='') ? $_POST["content"] : $_POST["description"]), $_POST["title"]);
		                	if ($_POST["meta_desc"]=='')
		                		$_POST["meta_desc"] = text_match(text_limit((s('description')=='') ? $_POST["title"] : s('description')), $_POST["title"]);
		                }

		                if ($_POST["meta_keys"]=='') {
		                    $_POST["meta_keys"] = keyword_maker(($_POST["content"]!='' || $_POST["description"]!='') ? $_POST["title"]." ".$_POST["title"]." ".$_POST["content"]." ".$_POST["description"] : $_POST["title"]." ".$_POST["title"]." ".s('sitetitle')." ".s('sitetitle')." ".s('keywords')." ".s('keywords'));
		                }

// CHANGE CHILDRESN SLUGS
					$new_slug = isset($_POST['slug']) ? $_POST['slug'] : '';
                    $_POST['slug'] = new_slug((empty($_POST['slug']) ? $_POST['title'] : $_POST['slug']), $this->route[2], TRUE);
                    
// CHANGE CHILDRESN SLUGS
					$cur_slug = db_retrieve('slug', c("table.pages"), 'id', $this->route[2], ' LIMIT 1');
					if (strpos($cur_slug, '/') !== false) $cur_slug = substr(strrchr($cur_slug, '/'), 1);
					if($cur_slug!=$new_slug) $this->change_children_slugs($this->route[2]);
// CHANGE CHILDRESN SLUGS

					$columns = db_fetch_all("SELECT column_name FROM information_schema.columns WHERE table_schema = '".c('database.name')."' AND table_name = '".c('table.pages')."';","column_name");
					$columns2 = array();
					foreach ($columns as $key2 => $value) {
						$columns2[$value["column_name"]] = $key2;
					}	

					$data = $_POST;
					$data = array_intersect_key($data, $columns2);

                    $update = db_update(c("table.pages"), $data, "WHERE id = {$this->route[2]} and language='".l()."' LIMIT 1");
                    db_query($update);
                    
//  update identically
                    $data = array(
						'slug' => $_POST['slug'],
						'template' => $_POST['template'],
						'image1' => $_POST['image1'],
						'menutitle' => (isset($_POST['menutitle'])) ? $_POST['menutitle'] : '0',
						'menutitle2' => (isset($_POST['menutitle2'])) ? $_POST['menutitle2'] : '0',
						'menutitle4' => (isset($_POST['menutitle4'])) ? $_POST['menutitle4'] : '0',
						'menutitle3' => (isset($_POST['menutitle3'])) ? $_POST['menutitle3'] : '0',
						'menutitle5' => (isset($_POST['menutitle5'])) ? $_POST['menutitle5'] : '0',
						'menutitle6' => (isset($_POST['menutitle6'])) ? $_POST['menutitle6'] : '0',
						'menutitle7' => (isset($_POST['menutitle7'])) ? $_POST['menutitle7'] : '0',
						'menutitle8' => (isset($_POST['menutitle8'])) ? $_POST['menutitle8'] : '0',
						'menutitle9' => (isset($_POST['menutitle9'])) ? $_POST['menutitle9'] : '0',
						'menutitle10' => (isset($_POST['menutitle10'])) ? $_POST['menutitle10'] : '0',
						'menutitle11' => (isset($_POST['menutitle11'])) ? $_POST['menutitle11'] : '0',
						'p_transfer_0_50' => (isset($_POST['p_transfer_0_50'])) ? $_POST['p_transfer_0_50'] : '0',
						'p_transfer_50_100' => (isset($_POST['p_transfer_50_100'])) ? $_POST['p_transfer_50_100'] : '0',
						'p_transfer_100_150' => (isset($_POST['p_transfer_100_150'])) ? $_POST['p_transfer_100_150'] : '0',
						'p_transfer_150_200' => (isset($_POST['p_transfer_150_200'])) ? $_POST['p_transfer_150_200'] : '0',
						'p_transfer_200_250' => (isset($_POST['p_transfer_200_250'])) ? $_POST['p_transfer_200_250'] : '0',
						'p_transfer_250_300' => (isset($_POST['p_transfer_250_300'])) ? $_POST['p_transfer_250_300'] : '0',
						'p_transfer_300_350' => (isset($_POST['p_transfer_300_350'])) ? $_POST['p_transfer_300_350'] : '0',
						'p_transfer_350_400' => (isset($_POST['p_transfer_350_400'])) ? $_POST['p_transfer_350_400'] : '0',
						'p_transfer_400_plus' => (isset($_POST['p_transfer_400_plus'])) ? $_POST['p_transfer_400_plus'] : '0',
						'p_transfer_max_crowed' => (isset($_POST['p_transfer_max_crowed'])) ? $_POST['p_transfer_max_crowed'] : '0', 
						'p_transfer_income_proc' => (isset($_POST['p_transfer_income_proc'])) ? $_POST['p_transfer_income_proc'] : '0', 
						'p_planner_0_50' => (isset($_POST['p_planner_0_50'])) ? $_POST['p_planner_0_50'] : '0',
						'p_planner_50_100' => (isset($_POST['p_planner_50_100'])) ? $_POST['p_planner_50_100'] : '0',
						'p_planner_100_150' => (isset($_POST['p_planner_100_150'])) ? $_POST['p_planner_100_150'] : '0',
						'p_planner_150_200' => (isset($_POST['p_planner_150_200'])) ? $_POST['p_planner_150_200'] : '0',
						'p_planner_200_250' => (isset($_POST['p_planner_200_250'])) ? $_POST['p_planner_200_250'] : '0',
						'p_planner_250_300' => (isset($_POST['p_planner_250_300'])) ? $_POST['p_planner_250_300'] : '0',
						'p_planner_300_350' => (isset($_POST['p_planner_300_350'])) ? $_POST['p_planner_300_350'] : '0',
						'p_planner_350_400' => (isset($_POST['p_planner_350_400'])) ? $_POST['p_planner_350_400'] : '0',
						'p_planner_400_plus' => (isset($_POST['p_planner_400_plus'])) ? $_POST['p_planner_400_plus'] : '0',
						'p_planner_max_crowd' => (isset($_POST['p_planner_max_crowd'])) ? $_POST['p_planner_max_crowd'] : '0',
						'p_planner_income_proc' => (isset($_POST['p_planner_income_proc'])) ? $_POST['p_planner_income_proc'] : '0',
						'p_ongoing_max_crowd' => (isset($_POST['p_ongoing_max_crowd'])) ? $_POST['p_ongoing_max_crowd'] : '0',
						'samewaydiscount' => (isset($_POST['samewaydiscount'])) ? $_POST['samewaydiscount'] : '0',
						'samewaydiscount2' => (isset($_POST['samewaydiscount2'])) ? $_POST['samewaydiscount2'] : '0',
						'price_50' => (isset($_POST['price_50'])) ? $_POST['price_50'] : '0',
						'price_100' => (isset($_POST['price_100'])) ? $_POST['price_100'] : '0',
						'price_200' => (isset($_POST['price_200'])) ? $_POST['price_200'] : '0',
						'price_200_plus' => (isset($_POST['price_200_plus'])) ? $_POST['price_200_plus'] : '0'
                    );
	                $update = db_update(c("table.pages"), $data, "WHERE id = {$this->route[2]}");
                    db_query($update);

					foreach(c('languages.all') as $language) {
						if ($tabstop == $language) {
	    	            	redirect(ahref($this->route, get(), $tabstop));
		    	        }
					}
					$params["tabstop"] = $tabstop;
					if($tabstop == 'close')
    	                redirect(ahref(array($this->route[0], 'show', $tpl['edit']['menuid'])));
    	            elseif($tabstop == 'files')
   	                	redirect(ahref(array('files', '', $this->route[2], @$this->route[3])));
    	            else
   	                	redirect(ahref($this->route, $params));
                endif;
                $this->content = template($form_template, $tpl);
                break;
        endswitch;
    }

	public function change_children_slugs($id)
	{
		$children = db_fetch_all("SELECT id, slug FROM `".c("table.pages")."` WHERE `masterid` = {$id};");
		foreach($children as $child) :
			$slug = substr(strrchr($child['slug'], '/'), 1);
			$new_slug = new_slug($slug, $child['id'], TRUE);
			$update = db_update(c("table.pages"), array('slug' => $new_slug), "WHERE `id` = {$child['id']};");
			db_query($update);
			$this->change_children_slugs($child['id']);
		endforeach;
	}

//////////////////////////////////////////////////
///////////// DO NOT EDIT ABOVE !!! //////////////
//////////////////////////////////////////////////

    public function main()
    {
        $this->content = template('actions/home');
    }

    public function sitemap()
    {
        $this->_lists('position', 'false', 'sitemap');
    }

    public function news()
    {
        $this->_lists('postdate DESC', 'true', 'news');
    }

    public function customnews()
    {
        $this->_lists('postdate DESC', 'true', 'customnews');
    }

    public function events()
    {
        $this->_lists('postdate DESC', 'true', 'eventlist');
    }

    public function articles()
    {
        $this->_lists('postdate DESC', 'true', 'articles');
    }

    public function customlist()
    {
        $this->_lists('position', 'true', 'list', 'actions/_lists_document_forms', 'actions/_lists_document');
    }

    function banners()
    {
        $this->_lists('position', 'true', 'bannerlist', 'actions/_lists_banner_forms', 'actions/_lists_banner');
    }

    function faq()
    {
        $this->_lists('position', 'true', 'faq', 'actions/_lists_faq_forms', 'actions/_lists_faq');
    }

    function params($form, $list, $table, $key, $order_by = 'id asc', $title = 'settings') {
        switch ($this->route[1]):
            case 'show':
                $sql = db_fetch_all("SELECT * FROM `{$table}` WHERE `deleted` = 0 AND `language` = '".l()."' order by {$order_by};");
                $data['items'] = $sql;
				$data["route"] = $this->route;
				$data["pagetitle"] = a($title);
                $this->content = template($list, $data);
                break;
            case 'delete':
                $sql = "UPDATE `{$table}` SET `deleted` = 1 WHERE `{$key}` = '".$_GET[$key]."';";
                db_query($sql);
                redirect(ahref(array($this->route[0])));
                break;
            case 'add':
                if (isset($_POST['params_form_perform'])):
					$columns = db_fetch_all("SELECT column_name FROM information_schema.columns WHERE table_schema = '".c('database.name')."' AND table_name = '{$table}';","column_name");
					//$columns = array_flip($columns);

					$columns2 = array();
					foreach ($columns as $key2 => $value) {
						$columns2[$value["column_name"]] = $key2;
					}	

					$maxid = db_fetch("SELECT max(id) as id from {$table}");
				    $_POST["id"] = $maxid["id"] + 1;

					foreach(c('languages.all') as $language):
						$_POST["language"] = $language;

	                	$data = array_diff($_POST, array(''));
						$data = array_intersect_key($data, $columns2);

						$insert = db_insert($table, $data);
						db_query($insert);
					endforeach;

                    $tabstop = $_POST["tabstop"];
                    ($tabstop == 'close') ? redirect(ahref(array($this->route[0]))) : redirect(ahref(array($this->route[0], 'edit', $_POST[$key])));
                endif;
				$data["route"] = $this->route;
				$data["pagetitle"] = a($title).': '.a('add');
                $this->content = template($form, $data);
                break;
            case 'edit':
                if (isset($_POST['params_form_perform'])):
					$columns = db_fetch_all("SELECT column_name FROM information_schema.columns WHERE table_schema = '".c('database.name')."' AND table_name = '{$table}';","column_name");
					$columns2 = array();
					
					foreach ($columns as $key2 => $value) {
						$columns2[$value["column_name"]] = $key2;
					}

					$data = $_POST;
					$data = array_intersect_key($data, $columns2);

					if (post('ident',0)==0)
                    	$update = db_update($table, $data, "WHERE `{$key}` = {$this->route[2]} and language='".l()."' LIMIT 1");
                	else
                    	$update = db_update($table, $data, "WHERE `{$key}` = {$this->route[2]}");

                    // die($update);
                    db_query($update);

                    $tabstop = $_POST["tabstop"];
					foreach(c('languages.all') as $language):
						if ($tabstop == $language) {
	    	            	redirect(ahref($this->route, get(), $tabstop));
							break;
		    	        }
					endforeach;
					($tabstop == 'close') ? redirect(ahref(array($this->route[0]))) : redirect(ahref($this->route));
                endif;
                $data = db_fetch("SELECT * FROM `{$table}` WHERE `language` = '".l()."' AND `deleted` = 0 AND `{$key}` = {$this->route[2]};");
                $data OR redirect(ahref(array($this->route[0])));
				$data["route"] = $this->route;
				$data["pagetitle"] = a($title).': '.a('edit');
                $this->content = template($form, $data);
                break;
        endswitch;
    }

    function settings()
    {
        $this->params('actions/settings_forms', 'actions/settings_list', c("table.settings"), 'id', 'id asc', 'settings');
    }

    function langdata()
    {
        $this->params('actions/settings_forms', 'actions/settings_list', c("table.language_data"), 'id', 'id desc', 'text');
    }

    function adminsettings()
    {
        $this->params('actions/settings_forms', 'actions/settings_list', c("table.admin_settings"), 'id', 'id asc', 'settings');
    }

    function _gallery()
	{
        switch ($this->route[1]):
            case 'show':
				$gallery = db_fetch("SELECT title FROM `".c("table.menus")."` WHERE `language` = '".l()."' and `id` = {$this->route[2]} and `type`='{$this->route[0]}'");
				if (!$gallery)
					redirect(ahref(array('sitemap')));
				$sql = db_fetch_all("SELECT * FROM `".c("table.galleries")."` WHERE `deleted` = 0 and `language` = '".l()."' and `menuid` = {$this->route[2]} ORDER BY `position`;");
                $tpl["gallery"] = $sql;
                $tpl['route'] = $this->route;
                $tpl['title'] = $gallery['title'];
                $this->content = template('actions/' . $this->route[0] . '_list', $tpl);
                break;
            case 'add':
            	$sql = db_fetch("SELECT title from ".c("table.menus")." where id = {$this->route[2]} and type = '{$this->route[0]}' limit 1");
            	$sql OR redirect(ahref(array('sitemap')));
                $tpl['route'] = $this->route;
				$tpl["menuid"] = $this->route[2];
				$tpl["pagetitle"] = $sql['title'];
                if (!empty($_POST['title'])):
                	$tabstop = $_POST["tabstop"];

					$id = db_fetch('select max(id) as maxid from `'.c("table.galleries").'`');
					$_POST["id"] = $id["maxid"]+1;
					$_POST["position"] = $id["maxid"]+1;
					$_POST["visibility"] = (isset($_POST["visibility"])) ? 1 : 0;
					$_POST["show_title"] = (isset($_POST["show_title"])) ? 1 : 0;
					$_POST["postdate"] .= ' ' . $_POST['posttime'];
					
					$columns = db_fetch_all("SELECT column_name FROM information_schema.columns WHERE table_schema = '".c('database.name')."' AND table_name = '".c('table.galleries')."';","column_name");
					$columns2 = array();
					foreach ($columns as $key2 => $value) {
						$columns2[$value["column_name"]] = $key2;
					}

					foreach(c('languages.all') as $language) :

						$_POST["language"] = $language;

	                	$data = array_diff($_POST, array(''));
						$data = array_intersect_key($data, $columns2);

						$insert = db_insert(c("table.galleries"), $data);
						db_query($insert);

					endforeach;
					if($tabstop == 'edit')
	                    redirect(ahref(array($this->route[0], 'edit', $_POST["id"])));
					else
	                    redirect(ahref(array($this->route[0], 'show', $this->route[2])));
                endif;
                $this->content = template('actions/' . $this->route[0] . '_forms', $tpl);
                break;
            case 'edit':
                $tpl = db_fetch("SELECT * FROM `".c("table.galleries")."` WHERE `id` = {$this->route[2]} and language='".l()."';");
                $tpl OR redirect(ahref(array('sitemap')));
                $tpl['route'] = $this->route;
				$tpl["pagetitle"] = db_retrieve('title', c("table.menus"), 'id', $tpl["menuid"], ' and language="'.l().'" LIMIT 1');
                if (!empty($_POST['title'])):
                	$tabstop = $_POST["tabstop"];
		            
					$_POST["visibility"] = (isset($_POST['visibility'])) ? 1 : 0;
					$_POST["show_title"] = (isset($_POST["show_title"])) ? 1 : 0;
					$_POST["postdate"] .= ' ' . $_POST['posttime'];

					$columns = db_fetch_all("SELECT column_name FROM information_schema.columns WHERE table_schema = '".c('database.name')."' AND table_name = '".c('table.galleries')."';","column_name");
					$columns2 = array();
					foreach ($columns as $key2 => $value) {
						$columns2[$value["column_name"]] = $key2;
					}

					$data = $_POST;
					$data = array_intersect_key($data, $columns2);

                    $update = db_update(c("table.galleries"), $data, "WHERE `id` = {$this->route[2]} and language='".l()."' LIMIT 1");
                    db_query($update);

					// update identically
                    $data = array(
//						'link' => $_POST['link'],
						'image1' => $_POST['image1']
                    );
                    $update = db_update(c("table.galleries"), $data, "WHERE `id` = {$this->route[2]}");
                    db_query($update);

					foreach(c('languages.all') as $language) {
						if ($tabstop == $language) {
	    	            	redirect(ahref(array($this->route[0], 'edit', $this->route[2]), get(), $tabstop));
		    	        }
					}
					if ($tabstop == 'edit')
						redirect(ahref(array($this->route[0], 'edit', $this->route[2])));
					else
						redirect(ahref(array($this->route[0], 'show', $tpl["menuid"])));
                endif;
                $this->content = template('actions/' . $this->route[0] . '_forms', $tpl);
                break;
            case 'visibility':
// AJAX CALL
                $update = db_update(c("table.galleries"), array('visibility' => $_GET['visibility']), "WHERE `id` = {$_GET["id"]} and language='".l()."'");
                db_query($update);
                break;
            case 'delete':
                $update = db_update(c("table.galleries"), array('deleted' => 1), "WHERE `id` = {$_GET['id']}");
                db_query($update);
                redirect(ahref(array($this->route[0], 'show', $_GET["menu"])));
                break;
            case 'move':
                $pos1 = db_retrieve('position', c("table.galleries"), 'id', $_GET["id"]);
                $id1 = $_GET['id'];
                switch ($_GET['where']):
                    case 'up': $pos_sql = "< {$pos1} ORDER BY `position` DESC";
                        break;
                    case 'down': $pos_sql = "> {$pos1} ORDER BY `position` ASC";
                        break;
                endswitch;
                $sql = "SELECT id, position FROM `".c("table.galleries")."` WHERE `language` = '" . l() . "' AND `menuid` = '{$_GET['menu']}' AND `position` {$pos_sql};";
                $res = db_fetch($sql);
                $pos2 = $res['position'];
                $id2 = $res['id'];
                $update1 = db_update(c("table.galleries"), array('position' => $pos2), "WHERE `id` = {$id1}");
                db_query($update1);
                $update2 = db_update(c("table.galleries"), array('position' => $pos1), "WHERE `id` = {$id2}");
                db_query($update2);
                redirect(ahref(array($this->route[0], 'show', $_GET["menu"]), array('pos' => $_GET["pos"])));
                break;
        endswitch;
	}

	function imagegallery()
	{
		$this->_gallery();
	}

	function videogallery()
	{
		$this->_gallery();
	}

	function audiogallery()
	{
		$this->_gallery();
	}

    function _topics($type = "pages")
    {
		switch($type) {
			case 'categories':
				$titleshow = a("categories");
				$titleedit = a("editcategory");
				$titleadd = a("addcategory");
				$mtype = 'news';
				break;
			case 'lists':
				$titleshow = a("listtypes");
				$titleedit = a("editlisttype");
				$titleadd = a("addlisttype");
				$mtype = 'list';
				break;
			case 'gallerylist':
				$titleshow = a("gallerylist");
				$titleedit = a("editgallery");
				$titleadd = a("addgallery");
				$mtype = 'gallery';
				break;
			case 'bannergroups':
				$titleshow = a("banners");
				$titleedit = a("editbannergroups");
				$titleadd = a("addbannergroups");
				$mtype = 'banners';
				break;
			case 'polls':
				$titleshow = a("polls");
				$titleedit = a("editpolls");
				$titleadd = a("addpolls");
				$mtype = 'poll';
				break;
			case 'catalogs':
				$titleshow = a("catalogs");
				$titleedit = a("editcatalogs");
				$titleadd = a("addcatalogs");
				$mtype = 'catalog';
				break;
			case 'faqs':
				$titleshow = a("faqs");
				$titleedit = a("editfaqs");
				$titleadd = a("addfaqs");
				$mtype = 'faq';
				break;
			default:
				$titleshow = a("menulist");
				$titleedit = a("editmenu");
				$titleadd = a("addmenu");
				$mtype = 'sitemap';
				break;
		}
        switch ($this->route[1]):
            case 'show':
				if($mtype == 'news') 		$filter = '`type` in ("news", "articles", "events")';
				elseif($mtype == 'list') 	$filter = '`type` = "list"';
				else 						$filter = '`type` like "%'.$mtype.'%"';
                $sql = db_fetch_all('SELECT * from `'.c("table.menus").'` where '.$filter.' and deleted=0 and language="'.l().'" order by `id`;');
                $data["topics"] = $sql;
                $data["type"] = $type;
				$data["title"] = $titleshow;
				$data["add"] = $titleadd;
				$data["menutype"] = $mtype;
				$data["route"] = $this->route;
                $this->content = template('actions/topics_list', $data);
                break;
            case 'add':
				$data["type"] = $type;
				$data["menutitle"] = $titleadd;
				$data["menutype"] = $mtype;
				$data["route"] = $this->route;
                if (isset($_POST['topics_form_perform']) && !empty($_POST['title'])):
					$id=db_fetch('SELECT max(id) as maxid from `'.c("table.menus").'`');
					$newid=$id["maxid"]+1;
					foreach(c('languages.all') as $language) :
						$insert = db_insert(c("table.menus"), array(
									'title' => $_POST['title'],
									'items_per_page' => $_POST['items_per_page'],
									'items_on_homepage' => $_POST['items_on_homepage'],
									'id' => $newid,
									'language' => $language,
									'type' => $_POST['menutype']
								));
						db_query($insert);
					endforeach;
					if ($_POST["tabstop"]=='close')
                    	redirect(ahref(array($this->route[0], 'show', $this->route[2])));
                    else
	    	            redirect(ahref(array($this->route[0], 'edit', $newid)));
                endif;
                $this->content = template('actions/topics_forms', $data);
                break;
            case 'edit':
                $data = db_fetch("SELECT * FROM `".c("table.menus")."` WHERE `id` = {$this->route[2]} and language='".l()."'");
				$data["type"] = $type;
				$data["menutitle"] = $titleedit;
				$data["menutype"] = $mtype;
				$data["route"] = $this->route;
                if (isset($_POST['topics_form_perform']) && !empty($_POST['title'])):
                    $data = array(
                        'title' => $_POST['title'],
						'items_per_page' => $_POST['items_per_page'],
						'items_on_homepage' => $_POST['items_on_homepage']
                    );
                    $update = db_update(c("table.menus"), $data, "WHERE `id` = {$this->route[2]} and language='".l()."'");
                    db_query($update);
					foreach(c('languages.all') as $language) {
						if ($_POST["tabstop"] == $language) {
	    	            	redirect(ahref($this->route, get(), $_POST["tabstop"]));
		    	        }
					}
					if ($_POST["tabstop"]=='close')
                    	redirect(ahref(array($this->route[0])));
                    else
	    	            redirect(ahref($this->route));
                endif;
                $this->content = template('actions/topics_forms', $data);
                break;
            case 'delete':
                $update = db_update(c("table.menus"), array('deleted' => 1), "WHERE `id` = {$_GET["id"]}");
                db_query($update);
                redirect(ahref(array($type)));
                break;
        endswitch;
    }

    function pages()
    {
		$this->_topics('pages');
	}

    function bannergroups()
    {
		$this->_topics('bannergroups');
	}

    function polls()
    {
		$this->_topics('polls');
	}

    function catalogs()
    {
		$this->_topics('catalogs');
	}

    function categories()
    {
		$this->_topics('categories');
	}

    function lists()
    {
		$this->_topics('lists');
	}

    function faqs()
    {
		$this->_topics('faqs');
	}

    function gallerylist()
    {
		$this->_topics('gallerylist');
	}

    function filemanager()
    {
       	$this->content = template('actions/filemanager', array('title' => ''));
	}

    function textconverter()
    {
       	$this->content = template('actions/textconverter', array('title' => ''));
	}

	function _zip_directory($directory, $zip) {
		if ($handle = opendir($directory)) {
		    while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if(is_dir($directory . $file)) {
						$this->_zip_directory($directory . $file . '/', $zip);
					} else {
						$zip->addFile($directory . $file);
					}
				}
			}
			closedir($handle);
		}
	}

    function backup()
    {
        switch ($this->route[1]):
			case 'show':
		       	$this->content = template('actions/backup', array('title' => ''));
				break;
			case 'delete':
				unlink("backup/" . $_GET["file"]);
                redirect(ahref(array('backup')));
				break;
			case 'create':
				$backup = '';
				$tablelist = db_fetch_all("show tables");
				foreach($tablelist as $table) :
					$t = $table["Tables_in_".c("database.name")];
					$createtable = db_fetch("show create table ".$t);
					$backup .= $createtable["Create Table"].';'."\n";
					$tablecontent = db_fetch_all("select * from ".$t);
					foreach($tablecontent as $records) :
						$fieldnames = "";
						$fieldvalues = "";
						foreach($records as $key=>$value) :
							$fieldnames .= $key.',';
							$fieldvalues .= '"'.$value.'",';
						endforeach;
						$fieldnames = str_lreplace(',','',$fieldnames);
						$fieldvalues = str_lreplace(',','',$fieldvalues);
						$backup .= 'insert into '.$t.'('.$fieldnames.') values ('.$fieldvalues.');'."\n";
					endforeach;
				endforeach;
				file_put_contents(c('folders.backup') . 'db_backup_'.date("Y-m-d_H.i.s").'.sql', $backup);
				$zip = new ZipArchive();
				if ($zip->open(c('folders.backup') . 'file_backup_'.date("Y-m-d_H.i.s").'.zip', ZIPARCHIVE::CREATE) === TRUE) {
					$this->_zip_directory(c('folders.upload'), $zip);
				}
				$zip->close();
                redirect(ahref(array($this->route[0])));
				break;
			default:
		       	$this->content = template('actions/backup', array('title' => ''));
				break;
		endswitch;
	}

    function files()
    {
        switch ($this->route[1]):
            case 'add':
                if (isset($_POST['file_form_perform']))
                {
                    $pos = db_fetch("SELECT MAX(`position`) AS `pos` FROM " . c("table.attached") . " WHERE `page` = {$this->route[2]};");
                    $pos = $pos['pos'] + 1;
                    $insert = db_insert(c("table.attached"), array(
                                'page' => $this->route[2],
                                'title' => $_POST['title'],
                                'file' => $_POST['file'],
                                'position' => $pos,
                                'language' => l()
                            ));
                    db_query($insert);
                	redirect(ahref(array($this->route[0], '', $this->route[2])));
                }
                break;
            case 'move':
                $pos1 = db_retrieve('position', c("table.attached"), 'id', $_GET['file']);
                $id1 = $_GET['file'];
                switch ($_GET['where']):
                    case 'up': $pos_sql = "< {$pos1} ORDER BY `position` DESC";
                        break;
                    case 'down': $pos_sql = "> {$pos1} ORDER BY `position` ASC";
                        break;
                endswitch;
                $sql = "SELECT id, position FROM `".c("table.attached")."` WHERE `position` {$pos_sql};";
                $res = db_fetch($sql);
                $pos2 = $res['position'];
                $id2 = $res['id'];
                $update1 = db_update(c("table.attached"), array('position' => $pos2), "WHERE `id` = {$id1}");
                db_query($update1);
                $update2 = db_update(c("table.attached"), array('position' => $pos1), "WHERE `id` = {$id2}");
                db_query($update2);
                redirect(ahref(array($this->route[0], '', $_GET["id"], 'pos' => $_GET["pos"])));
                break;
            case 'delete':
                $delete = db_delete(c("table.attached"), array('id' => $_GET['file']));
                db_query($delete);
                redirect(ahref(array($this->route[0], '', $_GET['file'])));
                break;
        endswitch;
		$data['files'] = db_fetch_all("SELECT * FROM " . c("table.attached") . " WHERE `page` = {$this->route[1]} ORDER BY `position` ASC;");
		$data['pagetitle'] = db_retrieve('title', c("table.pages"), 'id', $this->route[1], ' and language="'.l().'"');
		$data['title'] = a('files.attached');
		$data['route'] = $this->route;
        $this->content = template('actions/files', $data);
    }

    function poll()
	{
        $par = array();
        if (isset($_GET['menu']))
        {
            $par['menu'] = $_GET['menu'];
        }
        if (isset($_GET['id']))
        {
            $par['id'] = $_GET['id'];
        }
        switch ($this->route[1]):
            case 'show':
				$poll = db_fetch("SELECT * FROM `".c("table.menus")."` WHERE `language` = '".l()."' and `id` = ". $_GET["menu"]);
                $sql = db_fetch_all("SELECT * FROM `".c("table.pollanswers")."` WHERE `deleted` = 0 and `language` = '".l()."' and `pollid` = ". get("menu", 0) ." ORDER BY `position`;");
				$data["title"] = $poll["title"];
                $data["polls"] = $sql;
                $this->content = template('actions/' . $this->route[0] . '_list', $data);
                break;
            case 'add':
                if (isset($_POST[$this->route[0] . '_form_perform']) && !empty($_POST['answer'])):
					$id=db_fetch('select max(id) as maxid from `'.c("table.pollanswers").'`');
					$newid=$id["maxid"]+1;
					$_POST["visibility"] = (isset($_POST["visibility"])) ? 1 : 0;
					foreach(c('languages.all') as $language) :
						$insert = db_insert(c("table.pollanswers"), array(
									'pollid' => $_GET['menu'],
									'answer' => $_POST['answer'],
									'id' => $newid,
									'position' => $newid,
									'answercount' => $_POST['answercount'],
									'answercounttotal' => $_POST['answercounttotal'],
									'visibility' => $_POST["visibility"],
									'language' => $language
								));
						db_query($insert);
					endforeach;
                    redirect(ahref($this->route[0], '', array('menu'=>$_GET["menu"])));
                endif;
                $this->content = template('actions/' . $this->route[0] . '_forms', array('menu' => $_GET["menu"], 'action' => $this->route[0], 'subaction' => $this->route[1]));
                break;
            case 'edit':
                if (isset($_POST[$this->route[0] . '_form_perform']) && !empty($_POST['answer'])):
					$_POST["visibility"] = (isset($_POST["visibility"])) ? 1 : 0;
                    $data = array(
                        'pollid' => $_GET['menu'],
						'answer' => $_POST['answer'],
						'answercount' => $_POST['answercount'],
						'answercounttotal' => $_POST['answercounttotal'],
						'visibility' => $_POST["visibility"],
                        'language' => l()
                    );
                    $insert = db_update(c("table.pollanswers"), $data, "WHERE `idx` = {$_GET['idx']}");
                    db_query($insert);
                    redirect(ahref($this->route[0], '', array('menu'=>$_GET["menu"])));
                endif;
                $edit_data = db_fetch("SELECT * FROM `".c("table.pollanswers")."` WHERE `idx` = {$_GET['idx']};");
                $temp_keys = array();
                $edit = array(
                    'title' => a("editimage"),
                    'action' => $this->route[0],
                    'subaction' => $this->route[1],
                    'answer' => $edit_data['answer'],
                    'answercount' => $edit_data['answercount'],
                    'idx' => $edit_data['idx'],
                    'answercounttotal' => $edit_data['answercounttotal'],
                    'visibility' => $edit_data['visibility'],
					'menu' => $edit_data['pollid']
                );
                $this->content = template('actions/' . $this->route[0] . '_forms', $edit);
                break;
            case 'visibility':
// AJAX CALL
                $update = db_update(c("table.pollanswers"), array('visibility' => $_GET['visibility']), "WHERE `id` = {$_GET['id']} and language='".l()."'");
                db_query($update);
                break;
            case 'delete':
                $delete_sql = "UPDATE `".c("table.pollanswers")."` SET `deleted` = 1 WHERE `id` = {$_GET['id']};";
                db_query($delete_sql);
                redirect(ahref($this->route[0], '', array('menu'=>$_GET["menu"])));
                break;
            case 'move':
                $res = db_fetch("SELECT * FROM `".c("table.pollanswers")."` WHERE `idx` = {$_GET['idx']};");
                $pos1 = $res['position'];
                $idx1 = $_GET['idx'];
                switch ($_GET['where']):
                    case 'up': $pos_sql = "< {$pos1} ORDER BY `".c("table.pollanswers")."`.`position` DESC";
                        break;
                    case 'down': $pos_sql = "> {$pos1} ORDER BY `".c("table.pollanswers")."`.`position` ASC";
                        break;
                endswitch;
                $sql = "SELECT * FROM `".c("table.pollanswers")."` WHERE `".c("table.pollanswers")."`.`language` = '" . l() . "' AND `pollid` = '{$_GET['menu']}' AND `".c("table.pollanswers")."`.`position` {$pos_sql} LIMIT 1;";
                $res = db_fetch($sql);
                $pos2 = $res['position'];
                $idx2 = $res['idx'];
                $update1 = db_update(c("table.pollanswers"), array('position' => $pos2), "WHERE `idx` = {$idx1}");
                $update2 = db_update(c("table.pollanswers"), array('position' => $pos1), "WHERE `idx` = {$idx2}");
                db_query($update1);
                db_query($update2);
                redirect(ahref($this->route[0], '', $par));
                break;
        endswitch;
	}

    function catalog()
	{
        switch ($this->route[1]):
            case 'show':
				$catalog = db_fetch("SELECT title FROM `".c("table.menus")."` WHERE `language` = '".l()."' and `id` = {$this->route[2]} and `type`='{$this->route[0]}'");
				$catalog OR redirect(ahref(array('sitemap')));
				$homepage = (get('rec',0)!=1) ? '' : ' and `homepage`=1';
				$cnt = db_fetch("SELECT count(id) as cnt FROM `".c("table.catalogs")."` WHERE `deleted` = 0 and `language` = '".l()."'{$homepage} and `menuid` = {$this->route[2]} AND `title` LIKE '%" . get('srch', '') . "%'");

				if(isset($_GET["cat"]) && !empty($_GET["cat"]) && $_GET["cat"]>0){
					$category = ' and FIND_IN_SET('.(int)$_GET["cat"].', `categories`)';
				}else{
					$category = '';
				}

				if(isset($_GET["reg"]) && !empty($_GET["reg"]) && $_GET["reg"]>0){
					$regions = ' and FIND_IN_SET('.(int)$_GET["reg"].', `regions`)';
				}else{
					$regions = '';
				}
               
                $sql = db_fetch_all("
                	SELECT * 
                	FROM 
                	`".c("table.catalogs")."` 
                	WHERE 
                	`deleted` = 0 and 
                	`language` = '".l()."'{$homepage} and 
                	`menuid` = {$this->route[2]} and 
                	`title` LIKE '%" . get('srch', '') . "%'{$category}{$regions} 
                	ORDER BY `position` 
                	limit " . get('start', 0) . ", 50;
                ");
				
				$data["pageid"] = db_retrieve('id', c("table.pages"), 'menutype', $this->route[2]);
				$data["count"] = $cnt["cnt"];
                $data["catalogs"] = $sql;
				$data["title"] = $catalog["title"];
                $data['route'] = $this->route;
                $this->content = template('actions/' . $this->route[0] . '_list', $data);
                break;
            case 'add':
				if (!empty($_POST['title'])):
					if(isset($_POST["overview"]) && isset($_POST["description"])){
		            	$_POST["overview"] = str_replace(array('"', "'"), array("&ldquo;", "&lsquo;"), $_POST["overview"]);
		            	$_POST["description"] = str_replace(array('"', "'"), array("&ldquo;", "&lsquo;"), $_POST["description"]);
	            	}

					$id=db_fetch('select max(id) as maxid from `'.c("table.catalogs").'`');
					$vis = ((isset($_POST["visibility"])) && ($_POST["visibility"] == 'on')) ? 1 : 0;
					$price = (!empty($_POST["price"])) ? $_POST["price"] : ' ';
					$map_coordinates = (!empty($_POST["map_coordinates"])) ? $_POST["map_coordinates"] : ' ';
					$postdate = $_POST["postdate"] .= ' ' . $_POST['posttime'];
					$reiting = (!empty($_POST["reiting"])) ? $_POST["reiting"] : 1;
					
					$regions = (!empty($_POST["regions"]) && is_array($_POST["regions"])) ? implode(",",$_POST["regions"]) : " ";
					$categories = (!empty($_POST["categories"]) && is_array($_POST["categories"])) ? implode(",",$_POST["categories"]) : " ";
					$description = (!empty($_POST["description"])) ? $_POST["description"] : ' ';
					$includes = (!empty($_POST["includes2"])) ? $_POST["includes2"] : ' ';
					$meta_keys = (!empty($_POST["meta_keys"])) ? $_POST["meta_keys"] : ' ';
					$meta_desc = (!empty($_POST["meta_desc"])) ? $_POST["meta_desc"] : ' ';
					$overview = (!empty($_POST["overview"])) ? $_POST["overview"] : ' ';

					$price_sedan = (!empty($_POST["price_sedan"])) ? $_POST["price_sedan"] : ' ';
					$guest_sedan = (!empty($_POST["guest_sedan"])) ? $_POST["guest_sedan"] : ' ';
					$price_minivan = (!empty($_POST["price_minivan"])) ? $_POST["price_minivan"] : ' ';
					$guest_minivan = (!empty($_POST["guest_minivan"])) ? $_POST["guest_minivan"] : ' ';
					$price_minibus = (!empty($_POST["price_minibus"])) ? $_POST["price_minibus"] : ' ';
					$price_bus = (!empty($_POST["price_bus"])) ? $_POST["price_bus"] : ' ';
					$guest_bus = (!empty($_POST["guest_bus"])) ? $_POST["guest_bus"] : ' ';
					$total_dayes = (!empty($_POST["total_dayes"])) ? $_POST["total_dayes"] : ' ';
					$tour_margin = (!empty($_POST["tour_margin"])) ? $_POST["tour_margin"] : ' ';
					$tour_income_margin = (!empty($_POST["tour_income_margin"])) ? $_POST["tour_income_margin"] : ' ';
					$cuisune_price1person = (!empty($_POST["cuisune_price1person"])) ? $_POST["cuisune_price1person"] : ' ';
					$ticketsandother_price1person = (!empty($_POST["ticketsandother_price1person"])) ? $_POST["ticketsandother_price1person"] : ' ';

					
					$hotelpricefortour = (!empty($_POST["hotelpricefortour"])) ? $_POST["hotelpricefortour"] : ' ';
					$guidepricefortour = (!empty($_POST["guidepricefortour"])) ? $_POST["guidepricefortour"] : ' ';
					
					$startedplace = ((isset($_POST["startedplace"])) && ($_POST["startedplace"] == 'on')) ? 1 : 0;
					$planner_show = ((isset($_POST["planner_show"])) && ($_POST["planner_show"] == 'on')) ? 1 : 0;
					$sight_show = ((isset($_POST["sight_show"])) && ($_POST["sight_show"] == 'on')) ? 1 : 0;
					$top_tour = ((isset($_POST["top_tour"])) && ($_POST["top_tour"] == 'on')) ? 1 : 0;
					$top_offers = ((isset($_POST["top_offers"])) && ($_POST["top_offers"] == 'on')) ? 1 : 0;
					$price_plus = ((isset($_POST["price_plus"])) && ($_POST["price_plus"] == 'on')) ? 1 : 0;

					$places=(isset($_POST['places']) && is_array($_POST['places'])) ? implode(",", $_POST['places']) : ' ';
					$newid=$id["maxid"]+1;
					$slug = (!empty($_POST["slug"])) ? utf82lat($_POST["slug"]) : "";
//					$producttime = $_POST["producttime"];
//					$_POST["productdate"] .= ' ' . $producttime;

					$idx=0;
					foreach(c('languages.all') as $language) :
						$insert = db_insert(c("table.catalogs"), array(
							'id' => $newid,
							'postdate' => $postdate,
							'visibility' => $vis,
							'position' => $newid,
							'menuid' => $this->route[2],
							'language' => $language,
							'title' => $_POST['title'],	
							'price' => $price,							
							'reiting' => $reiting,							
							'slug' => $slug,							
							'map_coordinates' => $map_coordinates,							
							'overview' => $overview,							
							'regions' => $regions,	
							'price_sedan' => $price_sedan,
							'guest_sedan' => $guest_sedan,
							'price_minivan' => $price_minivan,
							'guest_minivan' => $guest_minivan,
							'price_bus' => $price_bus,
							'price_minibus' => $price_minibus,
							'guest_bus' => $guest_bus,
							'tour_margin' => $tour_margin,			
							'tour_income_margin' => $tour_income_margin,			
							'cuisune_price1person' => $cuisune_price1person,			
							'ticketsandother_price1person' => $ticketsandother_price1person,			
							'hotelpricefortour' => $hotelpricefortour,			
							'guidepricefortour' => $guidepricefortour,			
							'total_dayes' => $total_dayes,							
							'categories' => $categories,							
							'description' => $description,							
							'includes' => $includes,							
							'image1' => $_POST['image1'],
							'image2' => $_POST['image2'],
							'image3' => $_POST['image3'],
							'image4' => $_POST['image4'],
							'image5' => $_POST['image5'],
							'image6' => $_POST['image6'],
							'image7' => $_POST['image7'],
							'image8' => $_POST['image8'],
							'image9' => $_POST['image9'],
							'image10' => $_POST['image10'],
							'places' => $places,
							'meta_keys' => $meta_keys,					
							'meta_desc' => $meta_desc, 					
							'startedplace' => $startedplace,					
							'planner_show' => $planner_show, 				
							'sight_show' => $sight_show, 				
							'top_tour' => $top_tour, 				
							'top_offers' => $top_offers,				
							'price_plus' => $price_plus				
						));
						// die($insert);

						db_query($insert);

					endforeach;
					if ($_POST["tabstop"] == 'edit')
						redirect(ahref(array($this->route[0], 'edit', $newid)));
					else
						redirect(ahref(array($this->route[0], 'show', $this->route[2])));
                endif;
            	$sql = db_fetch("SELECT title from ".c("table.menus")." where id = {$this->route[2]} and type = '{$this->route[0]}' limit 1");
            	$sql OR redirect(ahref(array('sitemap')));

            	$regions_list = db_fetch_all("SELECT `id`, `menutitle` FROM `pages` WHERE `menuid` = 27 AND `visibility` = 1 AND `deleted` = 0 AND `language`='".l()."'");
            	$categories_list = db_fetch_all("SELECT `id`, `title`, `menutitle` FROM `pages` WHERE `menuid` = 34 AND `visibility` = 1 AND `deleted` = 0 AND `language`='".l()."'");
				$tpl["pagetitle"] = $sql['title'];
                $tpl['menuid'] = $this->route[2];
                $tpl['route'] = $this->route;
                $tpl['regions_list'] = $regions_list;
                $tpl['categories_list'] = $categories_list;
                $tpl['subaction'] = $this->route[1];
                $this->content = template('actions/' . $this->route[0] . '_forms', $tpl);
                break;
            case 'edit':
            	$edit = db_fetch("SELECT * FROM `".c("table.catalogs")."` WHERE `id` = {$this->route[2]} and language='".l()."'");

            	if(isset($_POST["overview"]) && isset($_POST["description"])){
	            	$_POST["overview"] = str_replace(array('"', "'"), array("&ldquo;", "&lsquo;"), $_POST["overview"]);
	            	$_POST["description"] = str_replace(array('"', "'"), array("&ldquo;", "&lsquo;"), $_POST["description"]);
            	}

            	if (!empty($_POST['title'])):
					$vis = ((isset($_POST["visibility"])) && ($_POST["visibility"] == 'on')) ? 1 : 0;
					$startedplace = ((isset($_POST["startedplace"])) && ($_POST["startedplace"] == 'on')) ? 1 : 0;
					$planner_show = ((isset($_POST["planner_show"])) && ($_POST["planner_show"] == 'on')) ? 1 : 0;
					$sight_show = ((isset($_POST["sight_show"])) && ($_POST["sight_show"] == 'on')) ? 1 : 0;
					$top_tour = ((isset($_POST["top_tour"])) && ($_POST["top_tour"] == 'on')) ? 1 : 0;
					$top_offers = ((isset($_POST["top_offers"])) && ($_POST["top_offers"] == 'on')) ? 1 : 0;
					$price_plus = ((isset($_POST["price_plus"])) && ($_POST["price_plus"] == 'on')) ? 1 : 0;
					$postdate = $_POST["postdate"] .= ' ' . $_POST['posttime'];
					$overview = (isset($_POST['overview']) ? $_POST['overview'] : ' ');
					$includes = (isset($_POST['includes2']) ? $_POST['includes2'] : ' ');


					$price_sedan = (!empty($_POST["price_sedan"])) ? $_POST["price_sedan"] : ' '; 
					$guest_sedan = (!empty($_POST["guest_sedan"])) ? $_POST["guest_sedan"] : ' ';
					$price_minivan = (!empty($_POST["price_minivan"])) ? $_POST["price_minivan"] : ' ';
					$guest_minivan = (!empty($_POST["guest_minivan"])) ? $_POST["guest_minivan"] : ' ';
					$price_minibus = (!empty($_POST["price_minibus"])) ? $_POST["price_minibus"] : ' ';
					$price_bus = (!empty($_POST["price_bus"])) ? $_POST["price_bus"] : ' ';
					$guest_bus = (!empty($_POST["guest_bus"])) ? $_POST["guest_bus"] : ' ';
					$tour_margin = (!empty($_POST["tour_margin"])) ? $_POST["tour_margin"] : ' ';
					$tour_income_margin = (!empty($_POST["tour_income_margin"])) ? $_POST["tour_income_margin"] : ' ';
					$cuisune_price1person = (!empty($_POST["cuisune_price1person"])) ? $_POST["cuisune_price1person"] : ' ';
					$ticketsandother_price1person = (!empty($_POST["ticketsandother_price1person"])) ? $_POST["ticketsandother_price1person"] : ' ';

					$hotelpricefortour = (!empty($_POST["hotelpricefortour"])) ? $_POST["hotelpricefortour"] : ' ';
					$guidepricefortour = (!empty($_POST["guidepricefortour"])) ? $_POST["guidepricefortour"] : ' ';

					$total_dayes = (!empty($_POST["total_dayes"])) ? $_POST["total_dayes"] : ' ';
					$slug = (!empty($_POST["slug"])) ? utf82lat($_POST["slug"]) : "";

					$data = array(
                        'language' => l(), 
						'title' => $_POST['title'],
						'description' => (!empty($_POST['description']) ? $_POST['description'] : ' '),	
						'meta_keys' => (!empty($_POST['meta_keys']) ? $_POST['meta_keys'] : ' '),		
						'meta_desc' => (!empty($_POST['meta_desc']) ? $_POST['meta_desc'] : ' '),		
                    );
                    $insert = db_update(c("table.catalogs"), $data, "WHERE `idx` = {$edit["idx"]}");
                    db_query($insert);

                    $regions = (!empty($_POST["regions"]) && is_array($_POST["regions"])) ? implode(",",$_POST["regions"]) : "";
                    $categories = (!empty($_POST["categories"]) && is_array($_POST["categories"])) ? implode(",",$_POST["categories"]) : "";
                    $places=(isset($_POST['places']) && is_array($_POST['places'])) ? implode(",", $_POST['places']) : '';

                    // echo print_r($_POST['places'], true)."a";
                    // exit();
                    // echo $_POST["postdate"];

                    //update all language
                    db_query("UPDATE 
                    	`catalogs` 
                    	SET 
                    	`price_sedan`='{$price_sedan}', 
                    	`guest_sedan`='{$guest_sedan}', 
                    	`price_minivan`='{$price_minivan}', 
                    	`guest_minivan`='{$guest_minivan}', 
                    	`price_bus`='{$price_bus}', 
                    	`price_minibus`='{$price_minibus}', 
                    	`guest_bus`='{$guest_bus}', 
                    	`tour_margin`='{$tour_margin}', 
                    	`tour_income_margin`='{$tour_income_margin}', 
                    	`cuisune_price1person`='{$cuisune_price1person}', 
                    	`ticketsandother_price1person`='{$ticketsandother_price1person}', 
                    	`hotelpricefortour`='{$hotelpricefortour}', 
                    	`guidepricefortour`='{$guidepricefortour}', 
                    	`places`='{$places}', 
                    	`sight_show`='{$sight_show}', 
                    	`planner_show`='{$planner_show}', 
                    	`top_tour`='{$top_tour}', 
                    	`top_offers`='{$top_offers}', 
                    	`startedplace`='{$startedplace}', 
                    	`price_plus`='{$price_plus}', 
                    	`image1`='{$_POST['image1']}', 
                    	`image2`='{$_POST['image2']}', 
                    	`image3`='{$_POST['image3']}', 
                    	`image4`='{$_POST['image4']}', 
                    	`image5`='{$_POST['image5']}', 
                    	`image6`='{$_POST['image6']}', 
                    	`image7`='{$_POST['image7']}', 
                    	`image8`='{$_POST['image8']}', 
                    	`image9`='{$_POST['image9']}', 
                    	`image10`='{$_POST['image10']}', 
                    	`price`='".(!empty($_POST['price']) ? (float)$_POST['price'] : ' ')."', 
                    	`map_coordinates`='".(!empty($_POST['map_coordinates']) ? $_POST['map_coordinates'] : ' ')."', 
                    	`slug`='".str_replace(array('"',"'", "'", "'"), "", $slug)."', 
                    	`total_dayes`='{$total_dayes}' 
                    	WHERE `id`={$edit["id"]}
                    ");

					//  update catalog identically
                    $data = array(
                    	'postdate' => $postdate,
                    	'visibility' => $vis,
						'reiting' => (!empty($_POST['reiting']) ? $_POST['reiting'] : 1),
						'overview' => $overview,
						'includes' => $includes,
						'regions' => $regions,		
						'categories' => $categories
                    );
                    $update = db_update(c("table.catalogs"), $data, "WHERE `idx` = {$edit["idx"]}");
                    
                    db_query($update);

	                if ($_POST["tabstop"] == 'close')
						redirect(ahref(array($this->route[0], 'show', $edit['menuid'])));
					else
						redirect(ahref(array($this->route[0], 'edit', $this->route[2])));
                endif;
                $edit_data = db_fetch("SELECT * FROM `".c("table.catalogs")."` WHERE `idx` = {$edit["idx"]};");
                $regions_list = db_fetch_all("SELECT `id`, `menutitle` FROM `pages` WHERE `menuid` = 27 AND `visibility` = 1 AND `deleted` = 0 AND `language`='".l()."'");
            	$categories_list = db_fetch_all("SELECT `id`, `title`, `menutitle` FROM `pages` WHERE `menuid` = 34 AND `visibility` = 1 AND `deleted` = 0 AND `language`='".l()."'");
                //$postdate = $_POST["postdate"] .= ' ' . $_POST['posttime'];

                $edit = array(
                    'action' => $this->route[0],
                    'subaction' => $this->route[1],
                    'route' => $this->route,
                    'id' => $this->route[2],
					'postdate' => $edit_data['postdate'],
					'title' => $edit_data['title'],
					'pagetitle' => $edit_data['title'],
					'overview' => $edit_data['overview'],
					'includes' => $edit_data['includes'],
					'price' => $edit_data['price'],		
					'map_coordinates' => $edit_data['map_coordinates'],
					'description' => $edit_data['description'],
					'visibility' => $edit_data["visibility"],
					'slug' => $edit_data["slug"],
					'regions_list' => $regions_list,
					'categories_list' => $categories_list,
					'reiting' => $edit_data["reiting"],
					'regions' => $edit_data["regions"],
					'places' => $edit_data["places"],
					'price_sedan' => $edit_data["price_sedan"],
					'guest_sedan' => $edit_data["guest_sedan"],
					'price_minivan' => $edit_data["price_minivan"],
					'guest_minivan' => $edit_data["guest_minivan"],
					'price_minibus' => $edit_data["price_minibus"],
					'price_bus' => $edit_data["price_bus"],
					'guest_bus' => $edit_data["guest_bus"],
					'tour_margin' => $edit_data["tour_margin"],	
					'tour_income_margin' => $edit_data["tour_income_margin"],	
					'cuisune_price1person' => $edit_data["cuisune_price1person"],	
					'ticketsandother_price1person' => $edit_data["ticketsandother_price1person"],	
					'hotelpricefortour' => $edit_data["hotelpricefortour"],	
					'guidepricefortour' => $edit_data["guidepricefortour"],	
					'total_dayes' => $edit_data["total_dayes"],
					'categories' => $edit_data["categories"],
					'meta_desc' => $edit_data["meta_desc"],
					'image1' => $edit_data['image1'],
					'image2' => $edit_data['image2'],
					'image3' => $edit_data['image3'],
					'image4' => $edit_data['image4'],
					'image5' => $edit_data['image5'],
					'image6' => $edit_data['image6'],
					'image7' => $edit_data['image7'],
					'image8' => $edit_data['image8'],
					'image9' => $edit_data['image9'],
					'image10' => $edit_data['image10'],
					'menuid' => $edit_data['menuid'],
					'idx' => $edit_data['idx'],
					'meta_keys' => $edit_data['meta_keys'], 				
					'startedplace' => $edit_data['startedplace'],				
					'planner_show' => $edit_data['planner_show'], 
					'sight_show' => $edit_data['sight_show'], 
					'top_tour' => $edit_data['top_tour'], 				
					'top_offers' => $edit_data['top_offers'],			
					'price_plus' => $edit_data['price_plus'] 			
                );
                $this->content = template('actions/' . $this->route[0] . '_forms', $edit);
                break;
            case 'visibility':
// AJAX CALL
                $update = db_update(c("table.catalogs"), array('visibility' => $_GET['visibility']), "WHERE `id` = {$_GET['id']} and language='".l()."'");
                db_query($update);
                break;
// AJAX CALL
            case 'delete':
                $update = db_update(c("table.catalogs"), array('deleted' => 1), "WHERE `id` = {$_GET["id"]}");
                db_query($update);
                redirect(ahref(array($this->route[0], 'show', $this->route[2])));
                break;
            case 'move':
                $pos1 = db_retrieve('position', c("table.catalogs"), 'id', $_GET["id"]);
                $id1 = $_GET['id'];
                switch ($_GET['where']):
                    case 'up': $pos_sql = "< {$pos1} ORDER BY `position` DESC";
                        break;
                    case 'down': $pos_sql = "> {$pos1} ORDER BY `position` ASC";
                        break;
                endswitch;
                $sql = "SELECT id, position FROM `".c("table.catalogs")."` WHERE `language` = '" . l() . "' AND `menuid` = '{$_GET['menu']}' AND `position` {$pos_sql};";
                $res = db_fetch($sql);
                $pos2 = $res['position'];
                $id2 = $res['id'];
                $update1 = db_update(c("table.catalogs"), array('position' => $pos2), "WHERE `id` = {$id1}");
                db_query($update1);
                $update2 = db_update(c("table.catalogs"), array('position' => $pos1), "WHERE `id` = {$id2}");
                db_query($update2);
                redirect(ahref(array($this->route[0], 'show', $_GET["menu"]), array('pos' => $_GET["pos"])));
                break;
        endswitch;
	}

	function _cart($list, $form, $table)
	{
		switch ($this->route[1]) {
			case 'show':
				$website = ($_SESSION["auth"]["id"]==4) ? " AND `cart`.`website`='beetrip'" : "";
				$type = ($_SESSION["auth"]["id"]==4) ? " AND `cart`.`type`='transport'" : "";
				$userid = (isset($_GET["u"]) && is_string($_GET["u"]) && !empty($_GET["u"])) ? " AND `cart`.`userid` LIKE '%".$_GET["u"]."%'" : "";

				$startPlace = (isset($_GET["s"]) && is_numeric($_GET["s"])) ? " AND (`cart`.`startplace`= '".$_GET["s"]."' || `cart`.`startplace2`= '".$_GET["s"]."') " : "";

				$endPlace = (isset($_GET["e"]) && is_numeric($_GET["e"])) ? " AND (`cart`.`endplace`= '".$_GET["e"]."' || `cart`.`endplace2`= '".$_GET["e"]."') " : "";

				$startdate = "";
				if(isset($_GET["o"]) && !empty($_GET["o"])){
					$exD = explode("-", $_GET["o"]);
					if(isset($exD[0]) && isset($exD[1]) && isset($exD[2])){
						$year = $exD[0];
						$month = $exD[1];
						$day = $exD[2];

						$fulldate = (int)$year."-".$month."-".$day;
						$startdate = " AND DATE_FORMAT(FROM_UNIXTIME(`cart`.`date`), '%Y-%m-%d')='".$fulldate."' ";
					}
				}

				// $startdate = (isset($_GET["o"]) && !empty($_GET["o"])) ? " AND ='".$_GET["o"]."'" : "";
				// echo $_SESSION["auth"]["id"];
				$quer="SELECT 
				`cart`.`id`,
				`cart`.`date`,
				`cart`.`uniq`,
				`cart`.`tourplaces`, 
				`cart`.`startdate`,  
				`cart`.`startdate2`,  
				`cart`.`type`,  
				`cart`.`timetrans`,   
				`cart`.`timetrans2`,   
				`cart`.`totalprice`,  
				`cart`.`roud1_price`,  
				`cart`.`roud2_price`, 
				`cart`.`double`,  
				`cart`.`guests`,  
				`cart`.`guests2`,  
				`cart`.`damzgvevi`,  
				`cart`.`dazgveuli`,  
				`cart`.`misamarti`,  
				`cart`.`dabtarigi`,  
				`cart`.`pasporti`,  
				`cart`.`piradinomeri`,  
				`cart`.`wherepickup`,  
				`cart`.`wherepickup2`,  
				`cart`.`telefonis`,  
				`cart`.`userid`,  
				`cart`.`website`,  
				`cart`.`status`,  
				`cart`.`attachment`,  
				`cart`.`startplace` AS startplacex,  
				`cart`.`endplace` AS endplacex,  
				`cart`.`startplace2` AS startplacex2,  
				`cart`.`endplace2` AS endplacex2,  
				(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=startplacex AND `language`='".l()."' AND `deleted`=0) AS startPlaceName, 
				(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=endplacex AND `language`='".l()."' AND `deleted`=0) AS endPlaceName,  
				(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=startplacex2 AND `language`='".l()."' AND `deleted`=0) AS startPlaceName2, 
				(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=endplacex2 AND `language`='".l()."' AND `deleted`=0) AS endPlaceName2,  
				`catalogs`.`image1`, 
				`catalogs`.`title`, 
				`catalogs`.`price` 
				FROM 
				`cart` 
				LEFT JOIN `catalogs` ON `catalogs`.`id`=`cart`.`pid` AND `catalogs`.`language`='".l()."'
				WHERE 
				(`cart`.`status`='invoiced' OR `cart`.`status`='payed') AND 
				`cart`.`userid` REGEXP '^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$' 
				{$website}{$type}{$userid}{$startdate}{$startPlace}{$endPlace}
				ORDER BY `cart`.`id` 
				desc LIMIT 
				" . get("start", 0) . ", 
				" . a_s("users.per.page") . ";";
				$sql = db_fetch_all($quer);

				// echo $sql;
                $cnt = db_fetch("
                	SELECT 
                	COUNT(*) AS cnt 
                	FROM `{$table}` 
                	WHERE 
					`userid` REGEXP '^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$'
					{$website}{$type}{$userid}{$startdate}{$startPlace}{$endPlace}
                ");
                
                $tpl["cart"] = $sql;
				$tpl["count"] = $cnt["cnt"];
				$tpl["route"] = $this->route;
                $this->content = template('actions/'.$list, $tpl);
				break;
			case 'edit':
				$tpl["cart"] = "";
				$this->content = template('actions/cart_edit', $tpl);
				break;
			case 'delete':
                //$update = db_update("cart", array('deleted' => 1), "WHERE `id` = {$_GET["id"]}");
                db_query("DELETE FROM `cart` WHERE `id`='{$_GET["id"]}'");
                redirect(ahref(array($this->route[0])));
                break;
			default:
				# code...
				break;
		}
	}

    function _users($list, $form, $table)
    {
        switch ($this->route[1]):
            case 'show':
            	$beetrip = ($_SESSION['auth']["id"]==4) ? " AND `website`='beetrip'" : "";
            	// ".$beetrip."
            	$search = (isset($_GET["search"]) && is_string($_GET["search"])) ? ' AND `email` LIKE "%'.$_GET["search"].'%" ' : ''; 
               	
                $sql = db_fetch_all("SELECT * FROM `{$table}` WHERE `deleted` = 0".$search." ORDER BY `username` asc LIMIT " . get("start", 0) . ", " . a_s("users.per.page") . ";");
               
                $cnt = db_fetch("SELECT COUNT(*) AS cnt FROM `{$table}` WHERE `class` = 1 AND `deleted` = 0;");
                $tpl["users"] = $sql;
				$tpl["count"] = $cnt["cnt"];
				$tpl["route"] = $this->route;
                $this->content = template('actions/'.$list, $tpl);
                break;
            case 'delete':
                $update = db_update($table, array('deleted' => 1), "WHERE `id` = {$_GET["id"]}");
                db_query($update);
                redirect(ahref(array($this->route[0])));
                break;
            case 'add':
                if (isset($_POST['users_form_submit'])):
                	$tabstop = $_POST["tabstop"];
                	if (!db_row_exists("email='{$_POST['email']}'", c('table.site_users'))) {

						$_POST["active"] = (isset($_POST["active"])) ? 1 : 0;
						$_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
						
						$columns = db_fetch_all("SELECT column_name FROM information_schema.columns WHERE table_schema = '".c('database.name')."' AND table_name = '{$table}';","column_name");

						$columns2 = array();
						foreach ($columns as $key2 => $value) {
							$columns2[$value["column_name"]] = $key2;
						}	

						$data = $_POST;
						$data = array_intersect_key($data, $columns2);

						$insert = db_insert($table, $data);
						db_query($insert);

	                    $id = db_fetch("SELECT max(id) as maxid from ".$table);
	                    if ($tabstop == 'edit')
	                    	redirect(ahref(array($this->route[0], 'edit', $id["maxid"])));
	                    else
		                    redirect(ahref(array($this->route[0])));
		            } else {
	                    redirect(ahref(array($this->route[0], $this->route[1]), array('err' => 'email')));
		            }
                endif;
				$tpl["title"] = a('adduser');
				$tpl["route"] = $this->route;
                $this->content = template('actions/'.$form, $tpl);
                break;
            case 'edit':
                $tpl = db_fetch("SELECT * FROM `{$table}` WHERE `id` = {$this->route[2]};");
                $tpl OR redirect(ahref(array($this->route[0])));
				$tpl["title"] = a('edituser');
				$tpl["route"] = $this->route;
                if (isset($_POST['users_form_submit'])):
                	$tabstop = $_POST["tabstop"];

					$_POST["active"] = (isset($_POST["active"])) ? 1 : 0;
                    if (!empty($_POST['userpass']))
	                    $_POST['userpass'] = md5($_POST['userpass']);
	                else
	                    unset($_POST['userpass']);

					$columns = db_fetch_all("SELECT column_name FROM information_schema.columns WHERE table_schema = '".c('database.name')."' AND table_name = '{$table}';","column_name");
					$columns2 = array();
					foreach ($columns as $key2 => $value) {
						$columns2[$value["column_name"]] = $key2;
					}	

					$data = $_POST;
					$data = array_intersect_key($data, $columns2);

                    $update = db_update($table, $data, "WHERE `id` = {$this->route[2]}");
                    db_query($update);

                    // if ($tabstop == 'edit')
                    // 	redirect(ahref(array($this->route[0], 'edit', $this->route[2])));
                    // else
	                   //  redirect(ahref(array($this->route[0])));
                endif;
                $this->content = template('actions/'.$form, $tpl);
                break;
            case 'activity':
                $update = db_update($table, array('active' => $_GET['active']), "WHERE `id` = {$_GET['id']}");
                db_query($update);
                break;
        endswitch;
    }

    function users()
    {
    	$this->_users('users_list', 'users_forms', c('table.users'));
    }

    function siteusers()
    {
    	$this->_users('siteusers_list', 'siteusers_forms', c('table.site_users'));
    }

    function cart()
    {
    	$this->_cart('cart_list', 'cart_forms', c('table.cart'));
    }

    function log()
    {
        switch ($this->route[1]):
            case 'show':
				$sql=db_fetch_all('SELECT * FROM ' . c('table.log') . ' ORDER BY visitdate DESC LIMIT ' . get('start', 0) . ', 50;');
				$cnt=db_fetch('SELECT COUNT(*) AS cnt FROM ' . c('table.log') . ' ORDER BY visitdate DESC;');
                $data["log"] = $sql;
				$data["count"] = $cnt["cnt"];
                $this->content = template('actions/log_list', array('data' => $data));
                break;
			case 'clear':
				$sql=db_query('DELETE FROM `' . c('table.log') . '`;');
                redirect(ahref(array('log')));
			break;
        endswitch;
	}

    function userrights()
    {
        switch ($this->route[1]):
            case 'show':
				$sql=db_fetch_all('SELECT * FROM ' . c('table.user_access') . ' WHERE userid = "' . get('userid', 0) . '";');
                $data["user_access"] = $sql;
				$data["route"] = $this->route;
                $this->content = template('actions/user_access_list', $data);
                break;
			case 'save':
				$userid=post("userid",0);
				if($userid != 0) :
					$sql = db_delete(c("table.user_access"), array('userid' => $userid));
					db_query($sql);
					unset($_POST["userid"]);
					foreach($_POST as $key=>$value) :
						$sql = db_insert(c("table.user_access"), array(
						            'userid' => $userid,
						            'action' => $key
						        ));
						db_query($sql);
					endforeach;
				endif;
                redirect(ahref(array($this->route[0]), array('userid' => $userid)));
			break;
        endswitch;
	}

    function mailinglistnews()
    {
        switch ($this->route[1]):
            case 'show':
				$sql=db_fetch_all('SELECT * FROM subscribe ORDER BY id desc');
                $data["maillist"] = $sql;
                $this->content = template('actions/mail_list', array('data' => $data));
                break;
			case 'delete':
				$sql=db_query('DELETE FROM subscribe where id='.$_GET["id"].';');
                redirect(ahref(array('mailinglistnews','show')));
			break;
        endswitch;
	}

    function help()
    {
       	$this->content = template('actions/help', array('title' => ''));
	}

    function about()
    {
       	$this->content = template('actions/about', array('title' => ''));
	}

    function terms()
    {
       	$this->content = template('actions/terms', array('title' => ''));
	}

    function privacy()
    {
       	$this->content = template('actions/privacy', array('title' => ''));
	}
}
