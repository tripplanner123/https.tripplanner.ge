<?php
function text($id){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 1 and deleted=0 AND id =".$id;
	$newshome = db_fetch($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	$link = href($newshome['id']);
    $out .= $newshome["content"];
    return $out;
}

function desc($id){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 1 and deleted=0 AND id =".$id;
	$newshome = db_fetch($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	$link = href($newshome['id']);
    $out .= $newshome["description"];
    return $out;
}

function imagen($id){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 1 and deleted=0 AND id =".$id;
	$newshome = db_fetch($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	$link = href($newshome['id']);
    $out .= $newshome["image1"];
    return $out;
}


function getq($column = array(), $id, $table='pages', $lang=true, $vis=true) {

	if ($lang)

		$lang = l();

	$vis = $vis ? ' and visibility=1' : '';

	$column = implode(', ', $column);

	$sql = "SELECT {$column} from {$table} where id = {$id} and language='{$lang}' and deleted=0{$vis}";

	$sql = db_fetch($sql);

	if (count($sql) > 1)

		return $sql;

	else

		return $sql[$column];

	return null;

}



function pager($id, $page_cur, $page_max, $page_show, $query) {

	$out = '';

	if ($page_max > 1) {

		unset($query['page'],$query['pos']);

		$page = (empty($query)) ? '?page=' : '&page=';

		$out .= '<div class="pager" class="col-sm-7"><ul class="pagination">';

	    if ($page_cur > 1) {

	        // $out .= '<li><a href="'.href($id, $query).$page.'1">&laquo;</a></li>';

	        $out .= '<li><a href="'.href($id, $query).$page.($page_cur - 1).'" class="previous">'.l("prev").'</a></li>';

		}

        $index_start = ($page_cur - $page_show) <= 0 ? 1 : $page_cur - $page_show;

        $index_finish = ($page_cur + $page_show) >= $page_max ? $page_max : $page_cur + $page_show;

        if (($page_cur - $page_show) > 1)

            $out .= '<li>...</li>';

        for ($i = $index_start; $i <= $index_finish; $i++) {

            $out .= '<li><a '.(($page_cur==$i) ? 'class="active"':'').' href="'.href($id, $query).$page.$i.'">'.$i.'</a></li>';

        }

        if (($page_cur + $page_show) < $page_max)

            $out .= '<li><a nohref="">...<a/></li>';

	    if ($page_cur < $index_finish) {

	        $out .= '<li><a href="'.href($id, $query).$page.($page_cur + 1).'" class="next">'.l("next").'</a></li>';

	        // $out .= '<li><a href="'.href($id, $query).$page.$page_max.'">&raquo;</a></li>';

	    }

	    $out .= '</ul>';

/*	    if ($page_cur < $index_finish) {

		        $out .= '<div class="next right">

		          <a href="'.href($id, $query).$page.($page_cur + 1).'">

		            '.l("next").'

		          </a>

		        </div>';

	    }

*/

    		$out .= '</div>';

	}

	return $out;

}



function main_menu()

{

	$storage = Storage::instance();

	$out = '';

    $sql = "SELECT id, title, idx, redirectlink, menutitle, level, menuid, category FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 1 AND id>1 AND deleted = 0 AND masterid = 0 AND visibility = 1 ORDER BY position asc;";

    $sections = db_fetch_all($sql);

    if (empty($sections))

        return NULL;

    for ($idx = 0, $out = NULL, $num = count($sections); $idx < $num; $idx++)

    {

        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];



//		menu-selected

		$active = 0;

		if ($storage->page_type !== 'error') {

			if ($storage->section["level"]==2) {

				$menu = db_fetch("SELECT id FROM ".c("table.pages")." WHERE idx=".$storage->section["masterid"]." AND language = '".l()."'");

				$active = $menu["id"];

			} elseif ($storage->section["menuid"]>1) {

			    $menu = db_fetch("SELECT title FROM ".c("table.menus")." WHERE id=".$storage->section["menuid"]."");

			    $menu_in = db_fetch("SELECT id, masterid, level FROM ".c("table.pages")." WHERE attached ='".$menu["title"]."' AND language = '".l()."'");

			    if ($menu_in["level"]==1) {

			    	$active = $menu_in["id"];

			    } else {

			    	$master = db_fetch("SELECT id FROM ".c("table.pages")." WHERE idx='".$menu_in["masterid"]."'");

					$active = $master["id"];

			    }

			} elseif ($storage->section["level"]==3) {

				$menu = db_fetch("SELECT masterid FROM ".c("table.pages")." WHERE idx=".$storage->section["masterid"]." AND language = '".l()."'");

				$child = db_fetch("SELECT id FROM ".c("table.pages")." WHERE idx=".$menu["masterid"]." AND language = '".l()."'");

				$active = $child["id"];

			} else {

				$active = $storage->section["id"];

			}

		}



		$out .= '<li'.(($sections[$idx]["id"] == $active && $sections[$idx]["id"] != 1) ? ' class="active"':'').'>'."\n";

		    $sql_in = "SELECT id, title, idx, redirectlink, menutitle, category, masterid FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 1 AND deleted = 0 AND masterid = " . $sections[$idx]['id'] . " AND visibility = 1 ORDER BY position;";

	    	$sections_in = db_fetch_all($sql_in);

	    	$cnt_sections_in = count($sections_in);

	    	if($cnt_sections_in <=0) 

	        	$out .= '<a href="' . $link . '">' . ((l()=='ge') ? $sections[$idx]['menutitle'] : $sections[$idx]['menutitle']) . '</a>'."\n";

			else

	        	$out .= '<a nohref="">' . ((l()=='ge') ? $sections[$idx]['menutitle'] : $sections[$idx]['menutitle']) . '</a>'."\n";

			if($cnt_sections_in > 0) {

				$out .= '<ul style="left:-40px;">'."\n";

				for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)

	    		{

//			        $out .= '<div  class="fixed-menu" '.(($sections[$idx]['id']==$sections_in[$idx_in]['masterid']) ? 'style="display:block;"' : '' ).'>';

			        $link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];

	            	$out .= '<li>'."\n";

					$out .= '<a href="' .$link_in.'">' . $sections_in[$idx_in]['menutitle'] . '</a>'."\n";

					$sql_in2 = "SELECT id, title, idx, redirectlink, menutitle, category FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 1 AND deleted = 0 AND masterid = " . $sections_in[$idx_in]['id'] . " AND visibility = 1 ORDER BY position;";

					$sections_in2 = db_fetch_all($sql_in2);

					 if(count($sections_in2) > 0) {

					 	$out .= '<div class="sub s2">'."\n";

					 	$out .= '<ul>'."\n";

					 	for ($idx_in2 = 0, $num_in2 = count($sections_in2); $idx_in2 < $num_in2; $idx_in2++)

					 	{

					 		$link_in2 = (($sections_in2[$idx_in2]['redirectlink'] == '') || ($sections_in2[$idx_in2]['redirectlink'] == 'NULL')) ? href($sections_in2[$idx_in2]['id']) : $sections_in2[$idx_in2]['redirectlink'];

					 		$out .= '<li>'."\n";

					 		$out .= '<a href="' . $link_in2 . '">' . $sections_in2[$idx_in2]['menutitle'] . '</a>'."\n";

					 		$sql_in3 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 1 AND deleted = 0 AND masterid = " . $sections_in2[$idx_in2]['idx'] . " AND visibility = 1 ORDER BY position;";

					 	$sections_in3 = db_fetch_all($sql_in3);

					 		if(count($sections_in3) > 0) {

					 			$out .= '<div class="sub s2">'."\n";

					 			$out .= '<ul>'."\n";

					 			for ($idx_in3 = 0, $num_in3 = count($sections_in3); $idx_in3 < $num_in3; $idx_in3++)

					 			{

					 				$link_in3 = (($sections_in3[$idx_in3]['redirectlink'] == '') || ($sections_in3[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in3[$idx_in3]['id']) : $sections_in3[$idx_in3]['redirectlink'];

					 				$out .= '<li>'."\n";

					 				$out .= '<a href="' . $link_in3 . '">' . $sections_in3[$idx_in3]['menutitle'] . '</a>'."\n";

					 				$out .= '</li>'."\n";

					 			}

					 			$out .= '</ul>'."\n";

					 			$out .= '</div>'."\n";

					 		} else {

					 			$out .= ''."\n";

					 		}

					 		$out .= '</li>'."\n";

					 	}

					 	$out .= '</ul>'."\n";

					 	$out .= '</div>'."\n";

					 } else {

					 	$out .= ''."\n";

					 }

					$out .= '</li>'."\n";

				}

	            $out .= '</ul>'."\n";

			} else {

		        $out .= ''."\n";

			}

		$out .= '</li>'."\n";

    }

    return $out;

}



function user_menu() {

		$storage = Storage::instance();

		$user = $storage->user;

		$id = $storage->section['id'];

		$out = '';

	    if ($user->data('type')==2):

	        $obj = db_fetch("SELECT * from ".c("table.catalogs")." where manager = {$user->data('id')} and deleted=0 and language='".l()."'");

	    	$out .= '<div class="pi-area-menu">';

	    	$out .= '<div class="title">'.l('object.info').'</div>';

	    	$out .= '<ul>';

            $userarea = db_fetch("SELECT idx, id, menutitle from ".c("table.pages")." where id=26 and visibility=1 and deleted=0 and language='".l()."'");

            $menu = db_fetch_all("SELECT idx, id, menutitle, slug, table_cnt from ".c("table.pages")." where masterid={$userarea['idx']} and visibility=1 and deleted=0 order by position asc");

	    	$out .= '<li'.(($userarea['id'] != $id) ? '' : ' class="active"').'><a href="'.href($userarea['id']).'">'.$userarea['menutitle'].'</a></li>';

	        foreach ($menu as $item):

	            $out .= '<li class="fix'.(($item['id'] != $id) ? '' : ' active').'"><a href="'.href($item['slug']).'">'.$item["menutitle"].'</a>';

	            if ($item['table_cnt'] != ''):

	                $select = 'count(1)';

	                $qry = '';

	                if ($item['table_cnt'] == 'cart') {

	                    $select = 'count(DISTINCT orderid)';

	                    if ($item['id'] == 27)

			                $qry = ' and resdate > now() and sold=1';

			            else

			                $qry = ' and resdate < now() and sold=1';

	                } elseif ($item['table_cnt'] == 'obj_menus') {

	                    $qry = ' and language="'.l().'"';

	                } elseif ($item['table_cnt'] == 'obj_places') {

	                    $select = 'sum(person + place)';

	                    $qry = ' and language="'.l().'"';

	                }

	                	$cnt = db_fetch("SELECT {$select} as qnt from {$item['table_cnt']} where objid={$obj['id']}{$qry}");

	                	$out .= '<span class="vb">'.(int)$cnt['qnt'].'</span>';

                endif;

                $submenu = db_fetch_all("SELECT id, menutitle, slug from ".c("table.pages")." where masterid={$item['idx']} and visibility=1 and deleted=0 order by position asc");

                if ($submenu):

	                $out .= '<ul class="active">';

	                foreach ($submenu as $item):

	                    $out .= '<li'.(($item['id'] != $id) ? '' : ' class="active"').'><a href="'.href($item['slug']).'">'.$item['menutitle'].'</a></li>';

	                endforeach;

	                $out .= '</ul>';

	            endif;

	            $out .= '</li>';

	        endforeach;

	        $out .= '</ul>';

	    $out .= '</div>';

	endif;

	    $out .= '<div class="pi-area-menu">';

	        $out .= '<div class="title">'.l('personal.info').'</div>';

	        $out .= '<ul>';

	            $userarea = db_fetch("SELECT idx, id, menutitle from ".c("table.pages")." where id=17 and visibility=1 and deleted=0 and language='".l()."'");

	            $menu = db_fetch_all("SELECT idx, id, menutitle, slug, table_cnt from ".c("table.pages")." where masterid={$userarea['idx']} and visibility=1 and deleted=0 order by position asc");

	            $out .= '<li'.(($userarea['id'] != $id) ? '' : ' class="active"').'><a href="'.href($userarea['id']).'">'.$userarea['menutitle'].'</a></li>';

		        foreach ($menu as $item):

	                if ($item['id'] == 22)

	                	continue;

		            $out .= '<li class="fix'.(($item['id'] != $id) ? '' : ' active').'"><a href="'.href($item['slug']).'">'.$item["menutitle"].'</a>';

		            if ($item['table_cnt'] != ''):

		                $select = 'count(1)';

		                $qry = '';

		                if ($item['id'] == 18) {

		                    $select = 'count(DISTINCT orderid)';

			                $qry = ' and resdate > now() and sold=1';

		                } elseif ($item['id'] == 19) {

		                    $select = 'count(DISTINCT orderid)';

			                $qry = ' and resdate < now() and sold=1';

		                }

		                $cnt = db_fetch("SELECT {$select} as qnt from {$item['table_cnt']} where userid={$user->data('id')}{$qry}");

		                $out .= '<span class="vb">'.$cnt['qnt'].'</span>';

	                endif;

	                $submenu = db_fetch_all("SELECT id, menutitle, slug from ".c("table.pages")." where masterid={$item['idx']} and visibility=1 and deleted=0 order by position asc");

	                if ($submenu && $item['id'] != 21):

		                $out .= '<ul class="active">';

		                foreach ($submenu as $item):

		                    $out .= '<li'.(($item['id'] != $id) ? '' : ' class="active"').'><a href="'.href($item['slug']).'">'.$item['menutitle'].'</a></li>';

		                endforeach;

		                $out .= '</ul>';

		            endif;

		            $out .= '</li>';

		        endforeach;

		        $token = md5(date('ihs', strtotime($user->data('logindate'))));

	            $out .= '<li><a id="logout" href="'.href($id, array('logout' => 1, 'token' => $token)).'">'.l("logout").'</a></li>';

	        $out .= '</ul>';

	    $out .= '</div>';

	    return $out;

}

function location()
{
    $storage = Storage::instance();
	$out = '';
    $page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND id= '".c("section.home")."' LIMIT 1;");
	if($storage->section["id"]!=1)
		$out .= '<a href="' . href(c("section.home")) . '">' . $page["title"] . '</a>'."\n";
	$segment = '';
    if (is_numeric($storage->segments[count($storage->segments) - 1])) {
		if($storage->section["category"]==16) {
			for($i=0; $i<count($storage->segments)-2; $i++) :
				$segment .= (($segment!='') ? '/' : '').$storage->segments[$i];
				$page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND slug = '{$segment}' LIMIT 1;");
				$link = (($page['redirectlink'] == '') || ($page['redirectlink'] == 'NULL')) ? href($page['id']) : $page['redirectlink'];
				$title = $page['title'];
				$out .= '<a href="' . $link . '">' . $title . '</a>'."\n";
			endfor;
			$product = db_fetch("SELECT * from catalogs where language='".l()."' and id=".db_escape($storage->product['id']));
			$cat = db_fetch("SELECT * from menus where language='".l()."' and id=".$product["menuid"]);
			$catpage = db_fetch("SELECT * from pages where language='".l()."' and attached='".$cat["title"]."'");
			// $out .= '<li class="active"><a href="'.href($catpage["id"], array(), l(), $product['id']).'">' . $product["title"] . '</a></li>'."\n";
		} else {
			$group = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menutype = '".$storage->section['menuid']."' LIMIT 1;");
			$segments = explode("/", $group["slug"]);
			for($i=0; $i<count($segments); $i++) :
				$segment .= (($segment!='') ? '/' : '').$segments[$i];
				$page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND slug = '{$segment}' LIMIT 1;");
				$link = (($page['redirectlink'] == '') || ($page['redirectlink'] == 'NULL')) ? href($page['id']) : $page['redirectlink'];
				$title = $page['title'];
				$out .= '<a href="' . $link . '" class="active">' . $title . '</a>'."\n";
			endfor;
			$link = (($storage->section['redirectlink'] == '') || ($storage->section['redirectlink'] == 'NULL')) ? href($storage->section['id']) : $storage->section['redirectlink'];
			$title = $storage->section['title'];
			// $out .= '<li class="active"><a href="' . $link . '">' . $title . '</a></li>'."\n";
		}
	} else {
		for($i=0; $i<count($storage->segments); $i++) :
			$segment .= (($segment!='') ? '/' : '').$storage->segments[$i];
			$page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE deleted=0 AND language = '" . l() . "' AND slug = '{$segment}' LIMIT 1;");
			$link = (($page['redirectlink'] == '') || ($page['redirectlink'] == 'NULL')) ? href($page['id']) : $page['redirectlink'];
			$title = $page['title'];
			$out .= ' <span>></span> <a href="' . $link . '"'.(($i==count($storage->segments)-1) ? ' class="active"' : '').'>' . $title . '</a>'."\n";
		endfor;
	}
    return $out;
}



function calendar($id = 1, $date = array(), $objid) {

    $out = '';



    $month_names = c('month.names');

    $day_names = c('day.shortnames');

    $day = 1;

    $today = 0;



	$year = isset($date['y']) ? $date['y'] : date('Y');

	$month = isset($date['m']) ? abs($date['m']) : date('n');



    $month_num = count($month_names);



    $next_year = $year;

    $prev_year = $year;



    $next_month = $month + 1;

    $prev_month = $month - 1;

    if ($next_month == 13) {

        $next_month = 1;

        $next_year = $year + 1;

    }

    if ($prev_month == 0) {

        $prev_month = 12;

        $prev_year = $year - 1;

    }

    if ($year == date('Y') && $month == date('n')) {

        $today = date('j');

    }

    $first_day_in_month = date('N', mktime(0,0,0, $month, 1, $year));

    $days_in_month = date("t", mktime(0, 0, 0, $month, 1, $year));

	$day_list = array_fill(1, $days_in_month, 0);



	$upcoming_slug = db_retrieve('slug', c("table.pages"), 'id', 27);

	$past_slug = db_retrieve('slug', c("table.pages"), 'id', 33);



    $out .= '<table id="calendar">';

    $out .= '<tr><td class="prev"><a href="'.href($id, array('y' => $prev_year, 'm' => $prev_month)).'" id="cmla" class="left"></a></td><td id="cm-date" colspan="5">' . $month_names[$month][l()] . ' ' . $year . '</td><td class="next"><a href="'.href($id, array('y' => $next_year, 'm' => $next_month)).'" id="cmra" class="right"></a></td></tr>';

    $out .= '<tr id="days">';

    for ($i = 1; $i <= 7; $i++) {

        $out .= '<td class="header">' . $day_names[$i][l()] . '</td>';

    }

    $out .= '</tr>';

    

    $total_place = db_fetch("SELECT sum(place) * 2 as qnt from obj_places where objid={$objid} and visibility=1 and language='".l()."'");

    $total_place = $total_place['qnt'];



    $resdate = db_fetch_all("SELECT day(resdate) as day, month(resdate) as month, year(resdate) as year from ".c("table.cart")." where objid={$objid} and sold=1 and resdate between '".date('Y-m-d H:i:s')."' and '".date('Y-m-d H:i:s', strtotime('+ 30 DAYS'))."' group by orderid");

    if (!empty($resdate)) {

    	$res_flip = array();

    	$i = 1;

	    foreach ($resdate as $value) {

	    	if (isset($res_flip[$value['day']]) && $res_flip[$value['day']]['day'] == $value['day']) {

	    		$i++;

		    	$value['count'] = $i;

	    	} else {

	    		$i = 1;

		    	$value['count'] = $i;

		    }

	    	$res_flip[$value['day']] = $value;

	    }

	    foreach ($day_list as $key => $value) {

	    	if (!isset($res_flip[$key]))

	    		$reserved[$key] = array('day' => 0, 'month' => 0, 'year' => 0);

	    	else

		    	$reserved[$key] = $res_flip[$key];

	    }

	    unset($resdate, $res_flip);

    } else {

    	$reserved = $day_list;

    }

    

    while ($day <= $days_in_month) {

        $out .= '<tr>';

        for ($i = 1; $i <= 7; $i++) {

            $class = '';

            if ($i > 4) {

                $class = ' weekend';

            }

            if ($day == $today) {

                $class = ' today';

            }

            if (($first_day_in_month == $i || $day > 1) && ($day <= $days_in_month)) {

            	if ($day == $reserved[$day]['day'] && $month == $reserved[$day]['month'] && $year == $reserved[$day]['year']) {

            	    $class = ($total_place > $reserved[$day]['count']) ? ' res' : ' res-full';

            	    $link = (date('Ymd', strtotime($year.$month.$day)) > $year.$month.$day) ? $upcoming_slug : $past_slug;

	                $out .= '<td class="day'.$class.'"><div class="number"><a href="'.href($link, array('y' => $year, 'm' => $month, 'd' => $day)).'">'.$day.'</a></div></td>';

            	} else {

                	$out .= '<td class="day'.$class.'"><div class="number">'.$day.'</div></td>';

            	}

                $day++;

            } else {

                $out .= '<td '.$class.'>&nbsp;</td>';

            }

        }

        $out .= '</tr>';

    }

    $out .= '</table>';

    return $out;

}



function contact_home(){

    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 1 and deleted=0 AND id =6;";

	$newshome = db_fetch($sql);

    if (empty($newshome))

        return NULL;

    $out = NULL;

	$i=0;

	$link = href($newshome['id']);

    $out = $newshome["description"];

    return $out;

}



function video_home(){
	$out  = '';	
	$i = 1;
	$slides = db_fetch_all("SELECT * FROM " . c("table.galleries") . " WHERE  language = '" . l() . "' AND deleted=0 AND menuid=10 AND visibility = 1 order by position desc" );
		foreach($slides as $slide) :
		$vid = str_replace('http://www.youtube.com/watch?','',str_replace('https://youtu.be/','',$slide['link']));
		$out.='
		<div class="vid left">
			<a href="http://www.youtube.com/v/'.$vid.'?fs=1&amp;autoplay=1" class="various fancybox.iframe">
				<img src="'.$slide['image1'].'" alt="" width="320" height="220" />
			</a>
		</div>
		';      
	    $i++;
	    endforeach;
    return $out;
}

function g_image_gallery_home(){
	$out  = '';	
	$i = 1;
	$slides = db_fetch_all("SELECT * FROM " . c("table.galleries") . " WHERE  language = '" . l() . "' AND deleted=0 AND menuid=46 AND visibility = 1 order by position desc" );
		foreach($slides as $slide) :
		
		$out.='
		<a href="'.$slide['link'].'" target="_blank" style="background-image:url(\'https://tripplanner.ge/image.php?f='.$slide['image1'].'&w=300&h=180\');" data-hover="https://tripplanner.ge/image.php?f='.$slide['image1'].'&w=300&h=180" class="g-partner-logos"></a>
		';      
	    $i++;
	    endforeach;
    return $out;
}

function g_news_hashes()
{
	$sql = "SELECT `meta_keys` FROM ".c("table.pages")." WHERE language='" . l() . "' AND visibility = 1 AND menuid = 28 AND `deleted`='0' AND `meta_keys`!='NULL' ORDER BY `postdate` DESC";
    $keys = db_fetch_all($sql);

    $metakeys = array();
    foreach ($keys as $value) {
    	$ex = explode(",", $value['meta_keys']);

    	foreach ($ex as $v) {
    		$trim = trim($v, " ");

    		if(!in_array($trim, $metakeys)){
    			$metakeys[] = $trim;
    		}
    	}
    }

    return $metakeys;
}


function news($limit = 4)
{
	$h = (isset($_GET['h']) && !empty($_GET['h'])) ? ' AND FIND_IN_SET("'.trim($_GET['h']).'", Replace(`meta_keys`,", ",","))' : '';
	$s = (isset($_GET['s']) && !empty($_GET['s'])) ? ' AND `title` LIKE "%'.trim($_GET['s']).'%"' : '';

    $sql = "SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND visibility = 1 AND menuid = 28 AND `deleted` = '0'{$h}{$s} ORDER BY postdate DESC LIMIT 0,{$limit};";

    //echo $sql;
    $news = db_fetch_all($sql);
    if (empty($news))
        return NULL;
    $out = NULL;
	$count = 0;
    foreach ($news AS $item)
    {
		$count++;
        $link = href($item['id']);
        
        // " 

        $out .=  '
        	<div class="col-sm-3">
				<div class="Item">
					<div class="TopInfo">
						<a href="'.$link.'"><div class="Background g-load-after" data-imgurl="https://tripplanner.ge/image.php?f='.$item['image1'].'&w=350&h=280"></div> 
						<div class="Date">'.g_convert_date($item["postdate"]).'</div></a>
					</div>
					<div class="BottomInfo" style="min-height:80px;">
						<div class="Title"><a href="'.$link.'" style="color: #27774d;">'.g_cut($item['title'], 30).'</a></div>  							
						<div class="Text"><a href="'.$link.'">'.g_cut($item['description'], 30).'</a></div>
					</div>
					<div class="Buttons">
						<a href="'.$link.'">'.l('more').'</a> 
					</div>
				</div>
			</div>
        ';
    }
    return $out;
}

function g_convert_date($date)
{
	global $c;
    if (empty($date))
        return NULL;
    
    $parts = explode('-', date('Y-n-j', strtotime($date)));
    if(isset($parts[0], $parts[1], $parts[2])){

    	if(isset($c['month.names'][$parts[1]][l()])){
    		$month = $c['month.names'][$parts[1]][l()];
    		return $parts[2] ." ". $month . ", " . $parts[0];
    	}
    		
    }
    
    return NULL;
    
}



function online_shop(){

	$cat=db_fetch_all("SELECT * from pages where language='".l()."' and visibility=1 and deleted=0 and masterid=3");

    foreach ($cat as $c) {

		$children = db_fetch_all("SELECT id, title, menutype, image1, menuid from ".c("table.pages")." where masterid = {$c['id']} and visibility=1 and deleted=0 and language='".l()."' ORDER BY position "); 

	}



            $i=0;

			$n = 1;

			$x = 1;

			$out = NULL;

		      if(!empty($children)) :

			    foreach ($children AS $child) {

		            $list = db_fetch_all("SELECT * FROM catalogs WHERE menuid = '".$child['menutype']."' and visibility=1 and deleted=0 and language='".l()."' ORDER BY position;");

		            if(!empty($list)):

						foreach($list as $p):

						$i+=0.2;

						if($p['menuid']==5){$n = 3;}

				        if($p['menuid']==6){$n = 2;}

						$out.='

					      <div class="col-sm-12 showbox wow fadeInUp" data-wow-delay="'.$i.'s">

					        <div class="product fix geo">

					          <div class="img left">

					            <img src="crop.php?img='.$p['image1'].'&n='.$n.'" class="img-responsive">

					          </div>

					          <div class="col-sm-10 right">

						          <h3>

						            '.$p['title'].'

						          </h3>';

						          if($p['brand']):

							          $out.='<h4>

							            '.$p['brand'].'

							          </h4>';

						          endif;

						          $out.= $p['description'] .'

						          <div class="fix" style="height:50px;">

						            <div class="note left">

						              '.l('note').'

						            </div>

						            <div class="cent">

							            <div class="quantity left bd" id="qnt'.$p['id'].'">

							              <input name="quantity" type="text" value="1" class="qnt-inp bd">

							              <div class="arrows right">

							                <img src="_website/images/arrow-sort-up.png" data-id="'.$p['id'].'" data-dir="up" class="qnt-arr">

							                <img src="_website/images/arrow-sort-down.png" data-id="'.$p['id'].'" data-dir="down" class="qnt-arr">

							              </div>

							            </div>

							            <div class="addbask left">

							              <a href="javascript:;" class="bd" onclick="add_to_basket('.$p['id'].');">'.l('add.cart').'</a>

							            </div>

						            </div>

						          </div>

						          <div class="fix cent">

							          <div class="price left">

							            '.round($p['price']).'

							            <input type="hidden" id="pr'.$p["id"].'" value="'.round($p['price']).'" /></td>

							          </div>

						          </div>

					          </div>	

					        </div>

					      </div>

						';

						endforeach;

		            endif;   		  

			   }

        	else :

		$products = db_fetch_all("

			SELECT * FROM ".c("table.catalogs")." WHERE language = '" . l() . "' AND visibility = 1 and deleted=0 ORDER BY position

		");

		if (empty($products))

	        return NULL;

			    foreach ($products AS $p) {

					$i+=0.2;

					if($p['menuid']==5){$n = 3;}

			        if($p['menuid']==6){$n = 2;}

					$out.='

				      <div class="col-sm-12 showbox wow fadeInUp" data-wow-delay="'.$i.'s">

				        <div class="product fix geo">

				          <div class="img left">

				            <img src="crop.php?img='.$p['image1'].'&n='.$n.'" class="img-responsive">

				          </div>

				          <div class="col-sm-10 right">

					          <h3>

					            '.$p['title'].'

					          </h3>';

					          if($p['brand']):

						          $out.='<h4>

						            '.$p['brand'].'

						          </h4>';

					          endif;

					          $out.= $p['description'] .'

					          <div class="fix" style="height:50px;">

					            <div class="note left">

					              '.l('note').'

					            </div>

					            <div class="cent">

						            <div class="quantity left bd" id="qnt'.$p['id'].'">

						              <input name="quantity" type="text" value="1" class="qnt-inp bd">

						              <div class="arrows right">

						                <img src="_website/images/arrow-sort-up.png" data-id="'.$p['id'].'" data-dir="up" class="qnt-arr">

						                <img src="_website/images/arrow-sort-down.png" data-id="'.$p['id'].'" data-dir="down" class="qnt-arr">

						              </div>

						            </div>

						            <div class="addbask left">

						              <a href="javascript:;" class="bd" onclick="add_to_basket('.$p['id'].');">'.l('add.cart').'</a>

						            </div>

					            </div>

					          </div>

					          <div class="fix cent">

						          <div class="price left">

						            '.round($p['price']).'

						            <input type="hidden" id="pr'.$p["id"].'" value="'.round($p['price']).'" /></td>

						          </div>

					          </div>

				          </div>	

				        </div>

				      </div>

					';

			   }

        	endif;

	return $out;

}



function about_home($id){

    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 1 and deleted=0 AND id =".$id;

	$newshome = db_fetch($sql);

    if (empty($newshome))

        return NULL;

    $out = NULL;

	$i=0;

	$link = href($newshome['id']);

    $out .= '

                <h2>'.$newshome["title"].'</h2>

                '.$newshome["description"];

            if($newshome['id'] == 2):    

              $out .= ' <div class="more"><a href="'.$link.'">'. l('more') .'</a></div>

		    ';

		    endif;



    return $out;

}





function subscribe()

{

	if(isset($_POST['send'])){

	   	$email = trim(db_escape($_POST['email']));

		$result = db_fetch("SELECT email FROM subscribe WHERE email='".$email."'");

		if(!empty($result)){

			return l("email.already.indb");

		}else{

			if(empty($email)){

				return l("enter.email");

			}else{

				db_query("INSERT INTO subscribe SET email='$email'");

				return l("successfully.subscribed");

			}

		}

	}



}



function product_count() {

	$sql = "SELECT sum(quantity) as cnt FROM cart WHERE ".((isset($_SESSION["user"])) ? " userid='".$_SESSION["user"]["id"] . "'" :" session='" . session_id() . "'" )." and sold=0 and pid<>0;";

    $homepage = db_fetch($sql);

    if (empty($homepage))

        return NULL;

    return (($homepage["cnt"] != '')?($homepage["cnt"]):'0');

}





// New





function products_home()

{



    $sql = "SELECT * FROM ".c("table.pages")." WHERE masterid=2 AND language = '" . l() . "' AND visibility = 1 and deleted=0 order by position";

    $homepage = db_fetch_all($sql);

    if (empty($homepage))

        return NULL;

    		$out = '';

		    foreach ($homepage AS $home) {

				//$link = href(3, array(), l(), $home['id']);

				$link = href($home['id']);

				$out .= '

				      <div class="section">

				        <div class="container">

				          <div class="row">

				            <div class="col-md-offset-2 col-md-8 pt-off-md">

				              <div class="section-title">

				                <h2><a href="'.$link.'">'.$home['title'].'</a></h2>

				              </div>

				              <div class="img">

				                <a href="'.$link.'" class="dib">

				                  <img src="'.$home['image1'].'" class="img-responsive center-block" alt="">

				                </a>

				              </div>

				            </div>

				          </div>

				        </div>

				      </div>

	               '."\n";

		   }



    return $out;

}



function similar_products($id,$pid)

{

    $sql = "SELECT * FROM ".c("table.catalogs")." WHERE menuid='".$id."' AND id<>'".$pid."' AND language = '" . l() . "' AND visibility = 1 and deleted=0 order by position";

    $homepage = db_fetch_all($sql);

    if (empty($homepage))

        return NULL;

    $out = NULL;

	$cat=db_fetch("SELECT * from pages where language='".l()."' and menutype=".$id);

	$out.= ' 

          <div class="product-list">

            <div class="title">

              <h2>'.l('similar.products').'</h2>

            </div>

            <div class="list row">';

			    foreach ($homepage AS $home) {

					$link = href(6, array(), l(), $home['id']);

					$out .= '

			              <div class="col-md-3">

			                <div class="item">

			                  <div class="img">

			                    <a href="'.$link.'"><img src="'.$home['image1'].'" width="270" height="200" class="img-responsive" alt=""></a>

			                  </div>

			                  <div class="title">

			                    <h3><a href="'.$link.'">'.$home['title'].'</a></h3>

			                  </div>

			                </div>

			              </div>

		               '."\n";

			   }

	    $out .='</div> </div>';

    return $out;

}



function basket_cnt()

{

	$sql = db_fetch("SELECT count(*) as cnt FROM cart WHERE sold=0 and quantity>0 and ".((isset($_SESSION["user"])) ? " userid='".$_SESSION["user"]["id"] . "'" :" session='" . session_id() . "'"));

    if (empty($sql))

        return 0;



	$count = NULL;

	$count = $sql['cnt'];



	return $count;

}



function pages($masterid){

	$sql = "SELECT * FROM ".c("table.pages")." WHERE masterid = '".$masterid."' AND language = '" . l() . "' AND visibility = 1 and deleted=0";

	$pages = db_fetch_all($sql);

    if (empty($pages))

        return NULL;

	$out = NULL;

      foreach ($pages as $page) {

	      $out .= '<div class="list col-md-3">

		      		  <div class="title">

			            <h3>'.$page['title'].'</h3>

			          </div>

			          <ul class="menu">';

					  $list = db_fetch_all("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND visibility = 1 AND masterid = {$page['id']} AND `deleted` = '0' ORDER BY position;");

					  foreach($list as $item):

					  	  $link = href($item['id']);

					      $out .= '<li><a href="'.$link.'">'.$item['title'].'</a></li>';

					  endforeach; 

				  $out .= '</ul></div>'; 

	  }

    return $out;

}



function searchCatalog($id){

	$sql = "SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND visibility = 1 AND masterid = 6 AND `deleted` = '0' ORDER BY position;";

	$pages = db_fetch_all($sql);



    if (empty($pages))

        return NULL;

	

	if(isset($_GET['cat'])) {

		$sql = "SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND visibility = 1 AND masterid = 6 AND `deleted` = '0' AND menutype=".db_escape($_GET['cat'])." ORDER BY position;";

		$cat = db_fetch($sql);

	}

	

	$out = NULL;

	$out .= '<button type="button" name="cat" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="'.(isset($_GET['cat']) ? $_GET['cat'] : '').'">'.(isset($cat['title']) ? $cat['title'] : l('hauptkatalog')).'<span class="caret"></span></button>

		<input type="hidden" name="cat" value="'.(isset($_GET['cat']) ? $_GET['cat'] : '').'"/>

                <ul class="dropdown-menu">';

      foreach ($pages as $page) {

	  	  //$link = href($page['id']);

	      $out .= '<li><a href="'.href($id).'?cat='.$page['id'].'">'.$page['title'].'</a></li>'; 

	  }

	  $out .= "</ul>";

    return $out;

}









  function menu($id=1) {

  	  $items=db_fetch_all("select * from pages where language='".l()."' and masterid=".$id." order by position");

  	  $out="";

  	  foreach($items as $item) {

  	  	  $out .= '<li><a href="'.href($item["id"]).'">'.$item["title"].'</a></li>';

  	  }

  	  if(count($items)>0)

  	  	  return '<ul>'.$out.'</ul>';

  	  else 

  	  	  return $out;

  }

  function menu_count($id=1) {

  	  $items=db_fetch_all("select * from pages where language='".l()."' and masterid=".$id." order by position");

	  return count($items);

  }

  function menu_title($id=1, $column = false) {

  	  $items=db_fetch("select * from pages where language='".l()."' and id=".$id." order by position");
  	  if($column){
  	  	return $items[$column];
  	  }
	  return $items["title"];

  }

  function menu_desc($id=1) {

  	  $items=db_fetch("select * from pages where language='".l()."' and id=".$id." order by position");

	  return $items["description"];

  }

  function menu_visibility($id=1) { 

  	  $items=db_fetch("select * from pages where language='".l()."' and id=".$id." order by position");

	  return $items["visibility"];

  }

function g_user_exists($email, $password = false){
	$passSql = ($password) ? " AND `userpass`='".md5($password)."'" : "";
	$userSql = "SELECT * FROM `site_users` WHERE `username`='".$email."' AND `deleted`=0".$passSql;

	$userFetch = db_fetch($userSql);
	if(isset($userFetch["id"]) && !empty($userFetch["id"])){
		return $userFetch;
	}
	return false;
}

function g_user_recover($email, $recover){
	$userSql = "SELECT `id` FROM `site_users` WHERE `username`='".$email."' AND `recover`='".$recover."' AND `deleted`=0";

	$userFetch = db_fetch($userSql);
	if(isset($userFetch["id"]) && !empty($userFetch["id"])){
		return true;
	}
	return false;
}

function g_userinfo($email = false){
	if($email){
		$username = $email;
	}else{
		$username = (isset($_SESSION["trip_user"])) ? $_SESSION["trip_user"] : '';	
	}
	
	$userinfo = "SELECT * FROM `site_users` WHERE `username`='".$username."'";
	$query = db_fetch($userinfo);
	return $query;
}

function g_send_email($args){
	if(file_exists("_plugins/PHPMailer/PHPMailerAutoload.php")){
		require_once("_plugins/PHPMailer/PHPMailerAutoload.php");
		

		$out = false;	
		$mail = new PHPMailer;
		// $mail->SMTPDebug = 1; 
		$SENDER_EMAIL = "forget2@tripplanner.ge";
		$SENDER_PASSWORD = "TJ,+u9Kgu2R^YI0H";

		$mail->isSMTP(); 
		$mail->CharSet = 'UTF-8';
		$mail->Host = "tripplanner.ge";
		$mail->SMTPAuth = true;
		$mail->Username = $SENDER_EMAIL;
		$mail->Password = $SENDER_PASSWORD;
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;

		$mail->setFrom($SENDER_EMAIL, "Trip Planner");
		$mail->addAddress($args["sendTo"]); 
		$mail->addReplyTo($SENDER_EMAIL);
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');

		if(isset($args['attachment'])){
			if(is_array($args['attachment'])){
				$i=1;
				foreach ($args['attachment'] as $attachment) {
					$attname = "attachment #".$i;
					$mail->addAttachment($attachment, $attname); 
					$i++;
				}
			}else{
				$mail->addAttachment($args['attachment'], "attachment"); 
			}
		}

		$mail->isHTML(true);                                  

		$mail->Subject = $args['subject'];
		$mail->Body = $args['body'];
		// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
		    $out = false;
		} else {
		    $out = true;
		}
	}
}

class g_requestProtection{
	public $hash;

	public function generate()
	{
		$this->hash = $_SESSION["CSRF_token"] = md5(uniqid());
	}

	public function meta_tag()
	{
		$this->generate();
		return sprintf("<meta name=\"CSRF_token\" value=\"%s\">\n", $this->hash);
	}
} 

function g_usertop(){
	$out = "<form action=\"javascript:void(0)\" method=\"post\">";
	$out .= sprintf("<input type=\"hidden\" name=\"CSRF_token\" value=\"%s\">", $_SESSION["CSRF_token"]);
	if(isset($_SESSION["trip_user"])){		
		$out .= sprintf("<a href=\"%s\" class=\"HeaderUserPanel\">", href(68)."#cartitems");
		$background = (isset($_SESSION["trip_user_info"]["picture"]) && !empty($_SESSION["trip_user_info"]["picture"])) ? ' style="background-image: url('.$_SESSION["trip_user_info"]["picture"].')"' : '';
		
		$out .= "<div class=\"UserImage\" ".$background."></div>";
		if(isset($_SESSION["trip_user_info"]["firstname"])){
			$usersfirstname = g_cut($_SESSION["trip_user_info"]["firstname"], 16);
			$out .= sprintf("<span class=\"UserText\">%s, %s</span>", l("hi"), $usersfirstname);	
		}else{
			$out .= sprintf("<div class=\"UserText\">%s</div>", l("hi"));
		}
		
		$out .= "</a>";
	}else{
		require_once('_plugins/php-graph-sdk-5.x/src/Facebook/autoload.php'); 
		$fb = new Facebook\Facebook([
			'app_id' => '1985700118125179', // Replace {app-id} with your app id
			'app_secret' => '7a90c0447042b3290718a670f199f028',
			'default_graph_version' => 'v2.2',
		]);

		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl('https://tripplanner.ge/'.l().'/?ajax=true&fb-callback=true', $permissions);


		$out .= "<div class=\"HeaderUserPanel\">";
		$out .= "<div class=\"UserImage\"></div>";
		$out .= sprintf("<div class=\"UserText\">%s</div>", menu_title(68));
		$out .= "</div>";

		$out .= "<div class=\"LoginDivHead\">";
		$out .= sprintf("<a href=\"%s\" class=\"FacebookLogin\" style=\"background:url('_website/img/fb_login_%s.png') no-repeat\"></a>", $loginUrl, l());
		$out .= "<div class=\"DropDownLogin\">";
		$out .= sprintf(
			"<div class=\"Title\">%s</div>",
			l("or")
		);
		$out .= "<div class=\"row\">";

		$out .= "<div class=\"form-group col-sm-12\">";
		$out .= "<div class=\"MaterialForm top-login-email-box\">";
		$out .= "<input type=\"text\" class=\"top-login-email\" name=\"top-login-email\" autocomplete=\"off\" />";
		$out .= "<span class=\"highlight\"></span>";
		$out .= "<span class=\"bar\"></span>";
		$out .= sprintf("<label>%s</label>", l("email"));
		$out .= "<div class=\"ErrorText gErrorText\"></div>";
		$out .= "</div>";
		$out .= "</div>";

		$out .= "<div class=\"form-group col-sm-12\">";
		$out .= "<div class=\"MaterialForm top-login-password-box\">";
		$out .= "<input type=\"password\" autocomplete=\"off\" class=\"top-login-password\" name=\"top-login-password\" />";
		$out .= "<span class=\"highlight\"></span>";
		$out .= "<span class=\"bar\"></span>";
		$out .= sprintf("<label>%s</label>", l("password"));
		$out .= "<div class=\"ErrorText gErrorText\" style=\"position:absolute\"></div>";
		$out .= "</div>";
		$out .= "</div>";

		$out .= "<div class=\"form-group col-sm-12 margin_0\">";
		$out .= sprintf("<a href=\"%s\" class=\"ForgetPassLink\">%s<span style=\"font-family: 'DejaVuSans';\">?</span></a>", href('70'), menu_title('70'));
		$out .= "</div>";
		
		$out .= "<div class=\"form-group col-sm-12 margin_0\">";
		$out .= sprintf("<button type=\"submit\" class=\"GreenCircleButton toploginButtonTri\">%s</button>", l("login"));
		$out .= "</div>";

		$out .= "<div class=\"form-group col-sm-12 text-center margin_0\">";
		$out .= sprintf(
			"<a href=\"%s\" class=\"GreenLink_1\"><span>%s</span></a>",
			href('69'),
			menu_title('69')
		);
		$out .= "</div>";

		$out .= "</div>";
		$out .= "</div>";
		$out .= "</div>";
	}
	$out .= "</form>";
	return $out;
}

function g_cut($text,$number)
{
	$charset = 'UTF-8';
	$length = $number;
	$string = strip_tags($text);
	if(mb_strlen($string, $charset) > $length) {
		$string = mb_substr($string, 0, $length, $charset) . '...';
	}
	else
	{
		$string=$text;
	}
	return $string; 
}

function g_changeprofilephoto(){
	if(!isset($_SESSION["trip_user"])){
		return false;
		exit;
	}
	$target_dir = "files/userphotos/";
	$target_file = $target_dir . basename($_FILES["profile-photo"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["profile-photo"]["tmp_name"]);
	    if($check !== false) {
	       $uploadOk = 1;
	    } else {
	       $uploadOk = 0;
	    }
	}

	if ($_FILES["profile-photo"]["size"] > 1000000) {
	    $uploadOk = 0;
	    echo '<script>';
	    echo '$("#ErrorModal .modal-dialog .modal-body .Title").text("'.l("error").'");';
	    echo '$("#ErrorModal .modal-dialog .modal-body .Text").text("'.l("maximagesize").'");';
        echo '$("#ErrorModal").modal("show");';
	    echo '</script>';
	    return false;
	}

	// if(@is_array(getimagesize($target_file))){
	// } else {
	//     $uploadOk = 0;
	//     return false;
	// }
	
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    $uploadOk = 0;
	}
	
	if ($uploadOk == 0) {
		return false;
	} else {
		$username = str_replace(array("@","."),"",$_SESSION["trip_user"]);
		$newFileName = $target_dir . $username.time() .".". $imageFileType;

	    if (move_uploaded_file($_FILES["profile-photo"]["tmp_name"], $newFileName)) {
	    	$fullPath = WEBSITE_BASE . $newFileName;
	    	// $selectOld = "SELECT `picture` FROM `site_users` WHERE 
	    	// `username`='".$_SESSION["trip_user"]."' AND 
	    	// `deleted`=0"; 
	    	// $fetch = db_fetch($selectOld);

	    	
	    	// if(isset($fetch["picture"]) && file_exists($fetch["picture"])){
	    	// 	unlink($fetch["picture"]); 
	    	// }

	    	$update = "UPDATE `site_users` SET 
	        `picture`='".$fullPath ."' 
	        WHERE 
	        `username`='".$_SESSION["trip_user"]."' AND 
	        `deleted`=0"; 
		    if(db_query($update)){
		    	unset($_SESSION["trip_user_info"]); 
				$_SESSION["trip_user_info"] = g_userinfo();
		    	return true;
		    }
	    }
	    return false;
	}
}


function g_places($categories = false, $startedplace = false, $orderBy = '`title` ASC', $limit = false, $menuid = false)
{ 
	$menuid = ($menuid) ? " AND `menuid`={$menuid}" : " AND `menuid`=36";
	$categories = ($categories) ? " AND `categories`={$categories}" : "";
	$startedplace = ($startedplace) ? " AND `startedplace`=1" : "";
	$limit = ($limit) ? $limit : "";
	$planner_show = (empty($startedplace)) ? " AND `planner_show`=1" : "";
	//$type = (empty($type)) ? " AND `planner_show`=1" : "";
	$sql = "SELECT 
	`catalogs`.`id`, 
	`catalogs`.`title`, 
	`catalogs`.`description`, 
	`catalogs`.`image1`, 
	`catalogs`.`map_coordinates`, 
	`catalogs`.`regions`, 
	`catalogs`.`categories`,
	(
		SELECT 
		`pages`.`menutitle`
		FROM 
		`pages`
		WHERE 
		`pages`.`language`='".l()."' AND 
		`pages`.`id`=`catalogs`.`categories` AND 
		`pages`.`deleted`=0
	) AS menutitle
	FROM 
	`catalogs` 
	WHERE 
	`language`='".l()."'{$menuid} AND `visibility`=1 AND `deleted`=0 AND `title`!='' AND `map_coordinates`!=''{$categories}{$startedplace}{$planner_show} ORDER BY {$orderBy} {$limit}";
	//echo $sql;
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_places_admin(){
	$sql = "SELECT `id`, `title`, `description`, `image1`, `map_coordinates`, `regions`, `categories` FROM `catalogs` WHERE `language`='".l()."' AND `menuid`=36 AND `visibility`=1 AND `deleted`=0 AND `title`!='' AND `map_coordinates`!='' ORDER BY `title` ASC";
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_sights_list($from = 0, $to = 10)
{
	$sql = "SELECT `id`, `title`, `image1` FROM `catalogs` WHERE `language`='".l()."' AND `menuid`=36 AND `visibility`=1 AND `deleted`=0 AND `sight_show`=1 ORDER BY `position` ASC LIMIT {$from}, {$to}";
	//echo $sql;
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_homepage_counts()
{
	$sql = "SELECT 
		(SELECT COUNT(`id`) FROM `catalogs` WHERE `menuid` =24 and `visibility`=1 and `deleted`=0 and `language` = 'ge') as tours, 
		(SELECT COUNT(`id`) FROM `catalogs` WHERE `language`='ge' AND `menuid`=36 AND `visibility`=1 AND `deleted`=0) as locations, 
		(SELECT COUNT(`id`) FROM `pages` WHERE `language`='".l()."' AND `menuid`=27 AND `visibility`=1 AND `deleted`=0) as regions 
		FROM `attached` limit 1";
	$fetch = db_fetch($sql);
	return $fetch;
}

function g_get_place_by_id($id)
{
	$sql = "SELECT `id`, `title` FROM `catalogs` WHERE `language`='".l()."' AND `menuid`=36 AND `visibility`=1 AND `deleted`=0 AND `id`='{$id}' ORDER BY `position` ASC";
	//echo $sql;
	$fetch = db_fetch($sql);
	return $fetch;
}

function g_categories()
{
	$sql = "SELECT `id`,`title`,`image1` FROM `pages` WHERE `language`='".l()."' AND `menuid`=34 AND `visibility`=1 AND `deleted`=0";
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_transports()
{
	$sql = "SELECT * FROM `pages` WHERE `language`='".l()."' AND `menuid`=40 AND `visibility`=1 AND `deleted`=0";
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_getlist($menuid)
{
	$sql = "SELECT `id`,`title`,`image1` FROM `pages` WHERE `language`='".l()."' AND `menuid`='".$menuid."' AND `visibility`=1 AND `deleted`=0";
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_places_with_tour_count()
{
	$sql = "SELECT 
	(
		SELECT 
		COUNT(`catalogs`.`id`)
		FROM 
		`catalogs`
		WHERE 
		`catalogs`.`menuid`=24 AND 
		`catalogs`.`language`='".l()."' AND 
		FIND_IN_SET(`pages`.`id`,`catalogs`.`regions`) AND 
		`catalogs`.`deleted`=0 AND 
		`catalogs`.`show_tripplanner`=2 AND 
		`catalogs`.`visibility`=1 
	) as tour_counted,
	`pages`.`id`,
	`pages`.`title`,
	`pages`.`image1` 
	FROM 
	`pages`
	 WHERE 
	 `pages`.`language`='".l()."' AND 
	 `pages`.`menuid`=27 AND 
	 `pages`.`visibility`=1 AND 
	 `pages`.`deleted`=0";
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_categories_with_tour_count()
{
	$sql = "SELECT 
	(
		SELECT 
		COUNT(`catalogs`.`id`)
		FROM 
		`catalogs`
		WHERE 
		`catalogs`.`menuid`=24 AND 
		`catalogs`.`language`='ge' AND 
		FIND_IN_SET(`pages`.`id`,`catalogs`.`categories`) AND 
		`catalogs`.`deleted`=0 AND 
		`catalogs`.`visibility`=1 AND 
		`catalogs`.`show_tripplanner`=2
	) as tour_counted,
	`pages`.`id`,
	`pages`.`title`,
	`pages`.`image1` 
	FROM 
	`pages`
	 WHERE 
	 `pages`.`language`='".l()."' AND 
	 `pages`.`menuid`=34 AND 
	 `pages`.`visibility`=1 AND 
	 `pages`.`deleted`=0";
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_listselect($menuid, $columns = false)
{
	$cols = "*";
	if($columns && is_array($columns)){
		$cols = implode(",", $columns);
	}
	$sql = "SELECT ".$cols." FROM `pages` WHERE `language`='".l()."' AND `menuid`='".$menuid."' AND `visibility`=1 AND `deleted`=0";
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_regions()
{
	$sql = "SELECT 
	(
		SELECT 
		COUNT(`catalogs`.`id`) 
		FROM `catalogs` 
		WHERE 
		`language`='".l()."' AND 
		`menuid`=36 AND 
		`visibility`=1 AND 
		`deleted`=0 AND 
		`planner_show`=1 AND 
		`startedplace`!=1 AND 
		`map_coordinates`!='' AND 
		FIND_IN_SET(`pages`.`id`, `catalogs`.`regions`) AND 
		(
			FIND_IN_SET(108, `categories`) OR 
			FIND_IN_SET(107, `categories`) OR 
			FIND_IN_SET(105, `categories`) OR 
			FIND_IN_SET(106, `categories`)
		)
	) AS placeCouned, 
	`id`,
	`title` 
	FROM 
	`pages` 
	WHERE 
	`language`='".l()."' AND 
	`menuid`=27 AND 
	`visibility`=1 AND 
	`deleted`=0 
	ORDER BY `position` ASC";
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_get_place_map_coordinates($places){

	$map_coordinates = array();
	if(preg_match_all("/\[(\d+)\]/", $places, $matches)){
		
		if(isset($matches[1])){
			$in = implode(",",$matches[1]);
	    	$sql = "SELECT `title`,`image1`, `description`, `map_coordinates` FROM `catalogs` WHERE `id` IN (".$in.") AND `language`='".l()."' AND `menuid`=36";
	    	
	    	$map_coordinates = db_fetch_all($sql);
			// echo "<pre>";
			// print_r($map_coordinates);
			// echo "</pre>";
	    }
  	}
  	return $map_coordinates;
}

function g_transfer_start_places(){
	$sql = "SELECT * FROM `".c("table.catalogs")."` WHERE menuid=42 and planner_show=1 and visibility=1 and deleted=0 and language = '" . l() . "' order by position asc";
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_ajax_catalog_list_load(){
	$filter = "";
	$count = "SELECT count(*) as cnt FROM `".c("table.catalogs")."` WHERE visibility=1 and deleted=0 and language = '" . l() . "' order by id desc";
    $count = db_fetch($count);

    // pager
    $page = (int)$_POST["current_page"];
    $per_page = c('catalog.per_page');
    $count = $count['cnt'];
    $page_max = ceil($count / $per_page);
    $page = ($page > $page_max && $page_max != 0) ? $page_max : $page;
    $limit = " LIMIT " . (($page - 1) * $per_page) . ", {$per_page}";
    // pager end
    

    // Filter start
    if(isset($_POST['cat']) && !empty($_POST['cat'])){
        $ex = explode(",", $_POST['cat']); 
        $cat = "";
        if(count($ex)){
            $cat = " AND (";
            for($i=0;$i<count($ex);$i++){
                $cat .= "FIND_IN_SET('".(int)$ex[$i]."', `categories`) OR ";
            }
            $cat = substr($cat, 0, -3);
            $cat .= ")";
            $filter .= $cat;
        }
        
    }

    if(isset($_POST['reg']) && !empty($_POST['reg'])){
        $ex = explode(",", $_POST['reg']); 
        $reg = "";
        if(count($ex)){
            $reg = " AND (";
            for($i=0;$i<count($ex);$i++){
                $reg .= "FIND_IN_SET('".(int)$ex[$i]."', `regions`) OR ";
            }
            $reg = substr($reg, 0, -3);
            $reg .= ")";
            $filter .= $reg;
        }
    }
    if(isset($_POST['pri']) && !empty($_POST['pri']) && is_numeric($_POST['pri'])){
        $filter .= " AND `price`>=".(int)$_POST['pri'];
    }
    // Filter end
    $userid = (isset($_SESSION["cartsession"])) ? $_SESSION["cartsession"] : 0;
    $sql = "SELECT 
    (SELECT MAX(`price`) FROM `".c("table.catalogs")."` WHERE menuid =24 and visibility=1 and deleted=0 and language = '" . l() . "' ".$filter." and `show_tripplanner`=2) AS maxPrice,
    (SELECT MIN(`price`) FROM `".c("table.catalogs")."` WHERE menuid =24 and visibility=1 and deleted=0 and language = '" . l() . "' ".$filter." and `show_tripplanner`=2) AS minPrice,
    (SELECT COUNT(`id`) FROM `".c("table.catalogs")."` WHERE menuid =24 and visibility=1 and deleted=0 and language = '" . l() . "' ".$filter." and `show_tripplanner`=2) AS counted,
    `catalogs`.`id`, 
    `catalogs`.`idx`, 
    `catalogs`.`title`, 
    `catalogs`.`image1`, 
    `catalogs`.`price`, 
    `catalogs`.`slug`, 
    `catalogs`.`total_dayes` as day_count, 
    `catalogs`.`tourists`, 
    `cart`.`id` AS cartId
    FROM `".c("table.catalogs")."` 
    LEFT JOIN `cart` ON `catalogs`.`id`=`cart`.`pid` AND `cart`.`userid`='".$userid."'
    WHERE menuid =24 and `show_tripplanner`=2 and visibility=1 and deleted=0 and language = '" . l() . "' ".$filter." order by id desc"."{$limit}";
    // echo $sql;
    $res = db_fetch_all($sql);
    return $res;
}

function g_homepage_tours($top_tour = false, $top_offers = false){
	$top_tour = ($top_tour) ? ' and `top_tour`=1' : '';
	$top_offers = ($top_offers) ? ' and `top_offers`=1' : '';
	$limit = " LIMIT 8";
	$userid = (isset($_SESSION["cartsession"])) ? $_SESSION["cartsession"] : 0;
	$sql = "SELECT 
    (SELECT COUNT(`id`) FROM `".c("table.catalogs")."` WHERE menuid =24 and visibility=1 and deleted=0 and language = '" . l() . "' and `show_tripplanner`=2) AS counted,
    `catalogs`.`id`, 
    `catalogs`.`idx`, 
    `catalogs`.`title`, 
    `catalogs`.`image1`, 
    `catalogs`.`price`, 
    `catalogs`.`slug`, 
    `catalogs`.`total_dayes` as day_count, 
    `catalogs`.`tourists`, 
    `cart`.`id` AS cartId
    FROM `".c("table.catalogs")."` 
    LEFT JOIN `cart` ON `catalogs`.`id`=`cart`.`pid` AND `cart`.`userid`='".$userid."'
    WHERE `menuid` =24 and `show_tripplanner`=2 and `visibility`=1 and `deleted`=0 and `language` = '" . l() . "'{$top_tour}{$top_offers} order by `id` desc"."{$limit}"; // 
    $res = db_fetch_all($sql); 
    return $res;
}

function g_inside_tours_rand(){
	$userid = (isset($_SESSION["cartsession"])) ? $_SESSION["cartsession"] : 0;
	$sql = "SELECT 
    (SELECT COUNT(`id`) FROM `".c("table.catalogs")."` WHERE menuid =24 and visibility=1 and deleted=0 and language = '" . l() . "') AS counted,
    `catalogs`.`id`, 
    `catalogs`.`idx`, 
    `catalogs`.`title`, 
    `catalogs`.`image1`, 
    `catalogs`.`price`, 
    `catalogs`.`slug`, 
    `catalogs`.`total_dayes` as day_count, 
    `catalogs`.`tourists`, 
    `cart`.`id` AS cartId
    FROM `".c("table.catalogs")."` 
    LEFT JOIN `cart` ON `catalogs`.`id`=`cart`.`pid` AND `cart`.`userid`='".$userid."'
    WHERE `menuid` =24 and `visibility`=1 and `deleted`=0 and `language` = '" . l() . "' order by rand() LIMIT 4"; // 
    $res = db_fetch_all($sql); 
    return $res;
}

function g_random($length)
{
	$bytes = openssl_random_pseudo_bytes($length * 2);
	return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
}

function g_clearOldUnpayedCartItmens(){

	$delete = "DELETE FROM `cart` WHERE `website`='tripplanner' AND (`status`='unpayed' || `status`='invoiced') AND `startdate`<'".date("Y-m-d")."' + interval 2 day";
	db_query($delete);

}

function g_cart($payStatus = "unpayed", $limit = ""){
	g_clearOldUnpayedCartItmens();
	
	if(isset($_SESSION["trip_user"])){
        $userid = $_SESSION["trip_user"];
    }else{
        if(isset($_SESSION["cartsession"]))
        {
            $userid = $_SESSION["cartsession"];
        }else{
            $userid = 0;
        }
    }

    $payStatus = ($payStatus=="payed") ? "(`cart`.`status`='payed' || `cart`.`status`='invoiced') AND ": "`cart`.`status`='unpayed' AND "; 
    
	$sql = "SELECT 
	`cart`.`id`,
	`cart`.`tourplaces`, 
	`cart`.`startdate`,  
	`cart`.`startdate2`,  
	`cart`.`type`,  
	`cart`.`timetrans`,  
	`cart`.`totalprice`,  
	`cart`.`double`,  
	`cart`.`guests`,  
	`cart`.`children`,  
	`cart`.`childrenunder`,  
	`cart`.`guests2`, 
	`cart`.`children2`,   
	`cart`.`childrenunder2`,   
	`cart`.`roud1_price`,  
	`cart`.`roud2_price`,  
	`cart`.`uniq`,  
	`cart`.`transport_name1`,  
	`cart`.`transport_name2`,  
	`cart`.`wherepickup`,  
	`cart`.`wherepickup2`,  
	`cart`.`attachment`,  
	`cart`.`hotels`,  
	`cart`.`cuisune`,  
	`cart`.`insurance`,  
	`cart`.`guide`,  
	`cart`.`status` AS cStatus,  
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
	`cart`.`userid`='".$userid."' AND  
	{$payStatus} 
	`cart`.`website`='tripplanner' 
	ORDER BY `cart`.`date` DESC ".$limit;
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_cart_count($userid){
	$countSql = "SELECT COUNT(`id`) as counted FROM `cart` WHERE `userid`='".$userid."' AND `status`='unpayed' AND `website`='tripplanner'"; 
    $countFetch = db_fetch($countSql);
    $countCartitem = (isset($countFetch['counted'])) ? $countFetch['counted'] : 0;
    return $countCartitem;
}

function g_getDrivingDistance($lat1, $long1, $lat2, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

    return array('distance' => $dist, 'time' => $time, 'rows' => $response_a['rows']);
}

function g_getDrivingMultipleDistance($origins, $destinations)
{
	$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$origins."&destinations=".$destinations."&mode=driving&language=pl-PL&key=".$c['google.key'];
	// echo $url; 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    // $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
    $d = 0;
    foreach ($response_a['rows'][0]['elements'] as $v) {
    	$d += (int)$v['distance']['text'];
    }

    return array('distance' => $d);
}


function g_ongoing_tour_one_person_price($crew, $min, $price, $margin, $income = 0)
{
	$outPrice = 0;
	// echo $margin;
	$bep = ceil((float)((float)$price * (int)$margin) / 100);


	if($crew<=$min){
		$outPrice = ((float)$price - $bep) / $crew;
	}else{
		$outPrice = (float)$price / $crew;
	}
	
	return $outPrice;
}

function g_planner_checkboxmodules($lists){
	$html = "";
    foreach ($lists as $v):
        $html .= "<div class=\"CheckBoxItem\">";
        $html .= sprintf(
            "<input class=\"TripCheckbox\" type=\"checkbox\" name=\"layout\" id=\"%s\" value=\"%s\" data-map=\"%s\" data-title=\"%s\" data-categories=\"%s\" onclick=\"ColorDistance()\" />", 
            $v["id"], 
            $v["id"], 
            str_replace(":",",", $v["map_coordinates"]), 
            $v["title"],
            $v["categories"]
        );
        $html .= sprintf("<label class=\"pull-left Text FontNormal\" for=\"%s\">", $v["id"]);
        $html .= $v["title"];
        $html .= "<div class=\"PositionRelative\">";
        $html .= "<div class=\"ShowWindow1\">";
        $html .= sprintf("<div class=\"Title\">%s</div>", $v["title"]);
        
        if(!empty($v["image1"]) && $v["image1"]!=""):
            $html .= sprintf("<div class=\"Image LoadImage\" data-image=\"%s\"></div>", $v["image1"]);
        endif;
        $html .= "<div class=\"Text\">";
        $html .= strip_tags($v["description"], "<p><a><strong>");
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</label>";
        $html .= "</div>";
    endforeach;
    return $html;
}

function g_generate_invoice($invoiceId, $html){
	require_once('_plugins/tcpdf/tcpdf.php');

	$invoiceId = time();
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Trip Planner');
	$pdf->SetTitle('Invoice #'.$invoiceId);
	$pdf->SetSubject('Invoice #'.$invoiceId);
	$pdf->SetKeywords('Invoice, trip, planner');
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	$fontname = TCPDF_FONTS::addTTFfont('/home4/tripplanner/public_html/_website/fonts/bpg_glaho_sylfaen.ttf', 'TrueTypeUnicode', '', 96);

	// use the font
	$pdf->SetFont($fontname, '', 14, '', false);
	$pdf->AddPage();

$html = <<<EOD
	{$html}
EOD;

	$pdf->writeHTML($html, true, false, true, false, '');
	$fileName = "/home4/tripplanner/public_html/invoice/". md5('sha1'.time()).".pdf";
	$pdf->Output($fileName, 'F');
	return $fileName;
}

function g_generate_tour_info($title, $html)
{
	require_once('_plugins/tcpdf/tcpdf.php');

	$invoiceId = time();
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Trip Planner');
	$pdf->SetTitle($title);
	$pdf->SetSubject($title);

	$pdf->SetKeywords('trip, planner');
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	$fontname = TCPDF_FONTS::addTTFfont('/home4/tripplanner/public_html/_website/fonts/bpg_glaho_sylfaen.ttf', 'TrueTypeUnicode', '', 96);

	// use the font
	$pdf->SetFont($fontname, '', 14, '', false);
	$pdf->AddPage();

$html = <<<EOD
	{$html}
EOD;

	$pdf->writeHTML($html, true, false, true, false, '');
	$fileName = "/home4/tripplanner/public_html/infotour/". md5('sha1'.time().uniqid()).".pdf";
	$pdf->Output($fileName, 'F');
	return $fileName;
}

function g_sent_order_mail(
	$status = "payed", 
	$payStatus = "payed", 
	$statusColor = "green", 
	$uniq = "",
	$user_trip = false 
){
	if(!$user_trip){
		$user_trip = $_SESSION["trip_user"];
	}
	if(!isset($_SESSION["trip_user_info"])){
		$user_select = "SELECT * FROM `site_users` WHERE `email`='".$user_trip."' AND `deleted`=0";
		$_SESSION["trip_user_info"] = db_fetch($user_select);
	}

	if($uniq!=""){
		$addUniq = " AND `cart`.`uniq`='".$uniq."'";
	}else{
		$addUniq = " AND `cart`.`mailsent`=0";
	}

	$order_sql = "SELECT 
	`cart`.`id`,
	`cart`.`tourplaces`, 
	`cart`.`startdate`,  
	`cart`.`startdate2`,  
	`cart`.`type`,  
	`cart`.`timetrans`,  
	`cart`.`totalprice`,  
	`cart`.`double`,  
	`cart`.`guests`,   
	`cart`.`children`,  
	`cart`.`childrenunder`,  
	`cart`.`guests2`, 
	`cart`.`children2`,   
	`cart`.`childrenunder2`,   
	`cart`.`timetrans2`,   
	`cart`.`roud1_price`,  
	`cart`.`roud2_price`,  
	`cart`.`uniq`,  
	`cart`.`transport_name1`,  
	`cart`.`transport_name2`,  
	`cart`.`startplace` AS startplacex,  
	`cart`.`endplace` AS endplacex,  
	`cart`.`startplace2` AS startplacex2,  
	`cart`.`endplace2` AS endplacex2,  
	`cart`.`hotels`,  
	`cart`.`guide`,  
	`cart`.`cuisune`, 
	`cart`.`damzgvevi`, 
	`cart`.`dazgveuli`, 
	`cart`.`misamarti`, 
	`cart`.`dabtarigi`, 
	`cart`.`pasporti`, 
	`cart`.`piradinomeri`, 
	`cart`.`telefonis`, 
	(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=startplacex AND `language`='".l()."' AND `deleted`=0) AS startPlaceName, 
	(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=endplacex AND `language`='".l()."' AND `deleted`=0) AS endPlaceName,  
	(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=startplacex2 AND `language`='".l()."' AND `deleted`=0) AS startPlaceName2, 
	(SELECT `catalogs`.`title` FROM `catalogs` WHERE `catalogs`.`id`=endplacex2 AND `language`='".l()."' AND `deleted`=0) AS endPlaceName2,
	`catalogs`.`image1`, 
	`catalogs`.`title`, 
	`catalogs`.`categories`,  
	`catalogs`.`regions`,  
	`catalogs`.`overview`,  
	`catalogs`.`includes`,  
	`catalogs`.`content`,  
	`catalogs`.`description`,  
	`catalogs`.`price` 
	FROM 
	`cart`
	LEFT JOIN `catalogs` ON `catalogs`.`id`=`cart`.`pid` AND `catalogs`.`language`='".l()."'
	WHERE 
	`cart`.`userid`='{$user_trip}' AND  
	`cart`.`status`='{$status}' AND 
	`cart`.`website`='tripplanner'{$addUniq}";
	// echo $order_sql;
	$fetch_orders = db_fetch_all($order_sql);
	$email_text = "";
	$info_mail_file = false;
	$info_mail_html = "";

	if(count($fetch_orders)){
		$theHoleTotalPrice = 0;
		
		if($status=="invoiced"){
			$email_text .= "<h2>".l("invoice_title")."</h2>";
			$email_text .= "<p>&nbsp;</p>";			
			$email_text .= "<p>".l("invoice_text")."</p>";
			$email_text .= "<p>&nbsp;</p>";
			$email_text .= "<p>".l("invoice_signature3")."</p>";
			$email_text .= "<p>&nbsp;</p>";
			$email_text .= "<p>Tripplanner.ge</p>";
			$email_text .= "<p>".s("Email")."</p>";
			$email_text .= "<p>".s("invphone")."</p>";
		}else{
			$email_text .= "<h2>".l("invoice_title")."</h2>";
			$email_text .= "<p>&nbsp;</p>";
			$email_text .= "<p>".l("pay_text")."</p>";
			$email_text .= "<p>&nbsp;</p>";
			$email_text .= "<p>".l("invoice_signature3")."</p>";
			$email_text .= "<p>&nbsp;</p>";
			$email_text .= "<p>Tripplanner.ge</p>";
			$email_text .= "<p>".s("Email")."</p>";
			$email_text .= "<p>".s("invphone")."</p>";
		}

		$email_text .= "<div style=\"width:100%; text-align:left\">
		<img src=\"https://tripplanner.ge/_website/img/header_logo.png\" alt=\"logo\" border=\"0\" width=\"150\" align=\"left\" />
		</div><br />";
		
		// $_SESSION["currency"]
		$ongoingTourInvoice = "";
		$plannedTripInvoice = "";
		$transfersInvoices = "";
		foreach ($fetch_orders as $o) {
			$theHoleTotalPrice += $o['totalprice'];
			switch($o['type']){
				case "ongoing":
					// Info file start
					$info_mail_html = "<table style=\"width:100%\">";

					// -- title
					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= "<h1 style=\"color:#27774d;\">".$o["title"]."</h1>";
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= "&nbsp;";
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					// -- image
					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= "<img src=\"".$o["image1"]."\" alt=\"\" width=\"630\" />";
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= "&nbsp;";
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					// -- categories
					$categories_names = array();
					$categories_list = explode(",", $o['categories']);
					foreach ($categories_list as $cat) {
						$fetch = db_fetch("SELECT `title` FROM `pages` WHERE `id`='".$cat."' AND `language`='".l()."'");
						$categories_names[] = $fetch["title"]; 
					}
					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= "<h2 style=\"color:#27774d;\">".implode(", ", $categories_names)."</h2>";
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					// -- regions
					$regions_names = array();
					$regions_list = explode(",", $o['regions']);
					foreach ($regions_list as $reg) {
						$fetch = db_fetch("SELECT `title` FROM `pages` WHERE `id`='".$reg."' AND `language`='".l()."'");
						$regions_names[] = $fetch["title"]; 
					}
					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= "<h2 style=\"color:#27774d;\">".implode(", ", $regions_names)."</h2>";
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= "&nbsp;";
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					// -- overview
					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= "<h2 style=\"background-color:#27774d; line-height:35px; padding:5px; color:white\">&nbsp;&nbsp;".l("overview")."</h2>";
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= str_replace(
						array("<h1>","</h1>", "<h2>","</h2>", "<h3>","</h3>"), 
						array("<h4>","</h4>", "<h4>","</h4>", "<h4>","</h4>"), 
						strip_tags($o["overview"], "<p><a><ul><li><h1><h2><h3><h4><h5><h6>")
					);
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= "&nbsp;";
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					// -- Tour description
					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= "<h2 style=\"background-color:#27774d; line-height:35px; padding:5px; color:white\">&nbsp;&nbsp;".l("tourdescription")."</h2>";
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= str_replace(
						array("<h1>","</h1>", "<h2>","</h2>", "<h3>","</h3>"), 
						array("<h4>","</h4>", "<h4>","</h4>", "<h4>","</h4>"), 
						strip_tags($o["description"], "<p><a><ul><li><h1><h2><h3><h4><h5><h6>")
					);
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= "&nbsp;";
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					// -- Tour includes
					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= "<h2 style=\"background-color:#27774d; line-height:35px; padding:5px; color:white\">&nbsp;&nbsp;".l("tourincludes")."</h2>";
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";

					$info_mail_html .= "<tr>";
					$info_mail_html .= "<td colspan=\"2\">";
					$info_mail_html .= str_replace(
						array("<h1>","</h1>", "<h2>","</h2>", "<h3>","</h3>"), 
						array("<h4>","</h4>", "<h4>","</h4>", "<h4>","</h4>"), 
						strip_tags($o["includes"], "<p><a><ul><li><h1><h2><h3><h4><h5><h6>")
					);
					$info_mail_html .= "</td>";
					$info_mail_html .= "</tr>";
					

					$info_mail_html .= "</table>";
					
					$info_mail_file[] = g_generate_tour_info($o["title"], $info_mail_html);
					// Info file end


					$ongoingTourInvoice .= '<tr>';
					$ongoingTourInvoice .= "<td style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\">{$o['startdate']}</td>";
					$ongoingTourInvoice .= "<td style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\">{$o['title']}</td>";
					$ongoingTourInvoice .= "<td style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\">{$o['guests']}</td>";
					$ongoingTourInvoice .= '<td>';

					if($o['childrenunder']>0){
						$ongoingTourInvoice .= "<p style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\"><strong>".l("underchildrenages").":</strong> {$o['childrenunder']}</p>";
					}

					if($o['children']>0){
						$ongoingTourInvoice .= "<p style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\"><strong>".l("childrenages").":</strong> {$o['children']}</p>";
					}

					$ongoingTourInvoice .= '</td>';
					/* start price */
					if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="usd"){
						$devide = (float)s("currencyusd");
						$ccc = "$";
					}else if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="eur"){
						$devide = (float)s("courseeur");
						$ccc = "&euro;";
					}else{
						$devide = 1;
						$ccc = l('gel');
					}
					$ongoingTourInvoice .= "<td style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\">".(int)($o['totalprice'] / $devide)." ".$ccc."</td>";
					/* end price */
					$ongoingTourInvoice .= '</tr>';

					break;
				case "transport":
					$transfersInvoices .= '<tr>';
					$transfersInvoices .= "<td style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\">{$o['startdate']} {$o['timetrans']}</td>";
					$transfersInvoices .= '<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">';
					$transfersInvoices .= "<p>{$o['startPlaceName']} &gt;&gt; {$o['endPlaceName']}</p>";
					$transfersInvoices .= '</td>';
					$transfersInvoices .= '<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">';
					$transfersInvoices .= $o["transport_name1"];
					$transfersInvoices .= '</td>';
					$transfersInvoices .= '<td>';
					$transfersInvoices .= "<p style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\"><strong>".l("adults").":</strong> {$o['guests']}</p>";
					if($o['childrenunder']>0){
						$transfersInvoices .= "<p style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\"><strong>".l("underchildrenages").":</strong> {$o['childrenunder']}</p>";
					}
					if($o['children']>0){
						$transfersInvoices .= "<p style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\"><strong>".l("childrenages").":</strong> {$o['children']}</p>";
					}
					$transfersInvoices .= '</td>';
					/* start price */
					if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="usd"){
						$devide = (float)s("currencyusd");
						$ccc = "$";
					}else if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="eur"){
						$devide = (float)s("courseeur");
						$ccc = "&euro;";
					}else{
						$devide = 1;
						$ccc = l('gel');
					}
					$transfersInvoices .= "<td style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\">".(int)($o['roud1_price'] / $devide)." ".$ccc."</td>";
					/* end price */
					$transfersInvoices .= '</tr>';

					if(!empty($o['startPlaceName2']) && !empty($o['endPlaceName2'])){
						
						$transfersInvoices .= '<tr>';
						$transfersInvoices .= "<td colspan=\"5\">".l("return")."</td>";
						$transfersInvoices .= '</tr>';

						$transfersInvoices .= '<tr>';
						$transfersInvoices .= "<td style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\">{$o['startdate2']} {$o['timetrans2']}</td>";
						$transfersInvoices .= '<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">';
						$transfersInvoices .= "<p>{$o['startPlaceName2']} &gt;&gt; {$o['endPlaceName2']}</p>";
						$transfersInvoices .= '</td>';
						$transfersInvoices .= '<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">';
						$transfersInvoices .= $o["transport_name2"];
						$transfersInvoices .= '</td>';
						$transfersInvoices .= '<td>';
						$transfersInvoices .= "<p style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\"><strong>".l("adults").":</strong> {$o['guests2']}</p>";
						if($o['childrenunder2']>0){
							$transfersInvoices .= "<p style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\"><strong>".l("underchildrenages").":</strong> {$o['childrenunder2']}</p>";
						}
						if($o['children2']>0){
							$transfersInvoices .= "<p style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\"><strong>".l("childrenages").":</strong> {$o['children2']}</p>";
						}
						$transfersInvoices .= '</td>';
						/* start price */
						if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="usd"){
							$devide = (float)s("currencyusd");
							$ccc = "$";
						}else if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="eur"){
							$devide = (float)s("courseeur");
							$ccc = "&euro;";
						}else{
							$devide = 1;
							$ccc = l('gel');
						}
						$transfersInvoices .= "<td style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\">".(int)($o['roud2_price'] / $devide)." ".$ccc."</td>";
						/* end price */
						$transfersInvoices .= '</tr>';
					}
					// $email_text .= "<br />";					
					break;
				case "plantrip":
					$sql = "SELECT `title`, `image1`, `categories`, `regions`, `description` FROM `catalogs` WHERE `id` IN(".$o['tourplaces'].") AND `menuid`=36 AND `deleted`=0 AND `language`='".l()."' ORDER BY FIELD(`id`, ".$o['tourplaces'].")"; 
					$fetch = db_fetch_all($sql);		

					$placesArray = array();
					$placesArray[] = $o['startPlaceName'];
					foreach ($fetch as $v) {
						$placesArray[] = $v['title'];

						// Info file Start
						$info_mail_html = "<table>";

						// -- title
						$info_mail_html .= "<tr>";
						$info_mail_html .= "<td colspan=\"2\">";
						$info_mail_html .= "<h1 style=\"color:#27774d;\">".$v["title"]."</h1>";
						$info_mail_html .= "</td>";
						$info_mail_html .= "</tr>";

						$info_mail_html .= "<tr>";
						$info_mail_html .= "<td colspan=\"2\">";
						$info_mail_html .= "&nbsp;";
						$info_mail_html .= "</td>";
						$info_mail_html .= "</tr>";

						// -- image
						$info_mail_html .= "<tr>";
						$info_mail_html .= "<td colspan=\"2\">";
						$info_mail_html .= "<img src=\"".$v["image1"]."\" alt=\"\" width=\"630\" />";
						$info_mail_html .= "</td>";
						$info_mail_html .= "</tr>";

						$info_mail_html .= "<tr>";
						$info_mail_html .= "<td colspan=\"2\">";
						$info_mail_html .= "&nbsp;";
						$info_mail_html .= "</td>";
						$info_mail_html .= "</tr>";

						// -- categories
						$categories_names = array();
						$categories_list = explode(",", $v['categories']);
						foreach ($categories_list as $cat) {
							$fetch = db_fetch("SELECT `title` FROM `pages` WHERE `id`='".$cat."' AND `language`='".l()."'");
							$categories_names[] = $fetch["title"]; 
						}
						$info_mail_html .= "<tr>";
						$info_mail_html .= "<td colspan=\"2\">";
						$info_mail_html .= "<h2 style=\"color:#27774d;\">".implode(", ", $categories_names)."</h2>";
						$info_mail_html .= "</td>";
						$info_mail_html .= "</tr>";

						// -- regions
						$regions_names = array();
						$regions_list = explode(",", $v['regions']);
						foreach ($regions_list as $reg) {
							$fetch = db_fetch("SELECT `title` FROM `pages` WHERE `id`='".$reg."' AND `language`='".l()."'");
							$regions_names[] = $fetch["title"]; 
						}
						$info_mail_html .= "<tr>";
						$info_mail_html .= "<td colspan=\"2\">";
						$info_mail_html .= "<h2 style=\"color:#27774d;\">".implode(", ", $regions_names)."</h2>";
						$info_mail_html .= "</td>";
						$info_mail_html .= "</tr>";

						$info_mail_html .= "<tr>";
						$info_mail_html .= "<td colspan=\"2\">";
						$info_mail_html .= "&nbsp;";
						$info_mail_html .= "</td>";
						$info_mail_html .= "</tr>";

						$info_mail_html .= "<tr>";
						$info_mail_html .= "<td colspan=\"2\">";
						$info_mail_html .= str_replace(
							array("<h1>","</h1>", "<h2>","</h2>", "<h3>","</h3>"), 
							array("<h4>","</h4>", "<h4>","</h4>", "<h4>","</h4>"), 
							strip_tags($v["description"], "<p><a><ul><li><h1><h2><h3><h4><h5><h6>")
						);
						$info_mail_html .= "</td>";
						$info_mail_html .= "</tr>";
						
						$info_mail_html .= "</table>";
						
						$info_mail_file[] = g_generate_tour_info($v["title"], $info_mail_html);
						// Info file end

					}
					
					$Hotelfetch = db_fetch("SELECT `title` FROM `pages` WHERE `id`=".$o['hotels']." AND `menuid`=37 AND `deleted`=0 AND `language`='".l()."'");


					
					
					$cuisuneInvoice = '';
					if(
						isset($o['cuisune']) && 
						preg_match_all("/\d+\:\d+/", $o['cuisune'], $matches))
					{
						if(is_array($matches)){
							foreach ($matches as $match) {
								foreach ($match as $m):
								$explode = explode(":", $m);
								if(isset($explode[0]) && isset($explode[1])){

									$Cuisunefetch = db_fetch("SELECT `title` FROM `pages` WHERE `id`=".(int)$explode[1]." AND `menuid`=38 AND `deleted`=0 AND `language`='".l()."'");
									
									$cuisuneInvoice .= "{$Cuisunefetch['title']} x{$explode[0]}; ";

								}
								endforeach;
							}
						}
					}

					$Guidefetch = db_fetch("SELECT `title` FROM `pages` WHERE `id`=".$o['guide']." AND `menuid`=39 AND `deleted`=0 AND `language`='".l()."'");
					

					$Transportfetch = db_fetch("SELECT `title` FROM `pages` WHERE `id`=".$o['transport_name1']." AND `menuid`=40 AND `deleted`=0 AND `language`='".l()."'");
					


					$plannedTripInvoice .= '<tr>';
					$plannedTripInvoice .= "<td style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\">{$o['startdate']} - {$o['startdate2']}</td>";
					$plannedTripInvoice .= '<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">';
					$plannedTripInvoice .= "<p>".implode(" &gt; ", $placesArray)."</p>";
					$plannedTripInvoice .= '</td>';
					$plannedTripInvoice .= '<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">';
					
					if(isset($Hotelfetch['title']) && !empty($Hotelfetch['title'])){
						$plannedTripInvoice .= "<p><strong>".l("hotel").":</strong> {$Hotelfetch['title']}</p>";
					}

					if(isset($cuisuneInvoice) && !empty($cuisuneInvoice)){
						$plannedTripInvoice .= "<p><strong>".l("cuisune").":</strong> {$cuisuneInvoice}</p>";
					}

					
					if(isset($Guidefetch['title']) && !empty($Guidefetch['title'])){
						$plannedTripInvoice .= "<p><strong>".l("guide").":</strong> {$Guidefetch['title']}</p>";
					}

					
					if(isset($Transportfetch['title']) && !empty($Transportfetch['title'])){
						$plannedTripInvoice .= "<p><strong>".l("transport").":</strong> {$Transportfetch['title']}</p>";
					}

					$plannedTripInvoice .= '</td>';
					$plannedTripInvoice .= '<td>';
					$plannedTripInvoice .= "<p style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\"><strong>".l("adults").":</strong> {$o['guests']}</p>";
					if($o['childrenunder']>0){
						$plannedTripInvoice .= "<p style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\"><strong>".l("underchildrenages").":</strong> {$o['childrenunder']}</p>";
					}
					if($o['children']>0){
						$plannedTripInvoice .= "<p style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\"><strong>".l("childrenages").":</strong> {$o['children']}</p>";
					}
					$plannedTripInvoice .= '</td>';
					/* start price */
					if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="usd"){
						$devide = (float)s("currencyusd");
						$ccc = "$";
					}else if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="eur"){
						$devide = (float)s("courseeur");
						$ccc = "&euro;";
					}else{
						$devide = 1;
						$ccc = l('gel');
					}
					$plannedTripInvoice .= "<td style=\"margin:0; padding:0; line-height: 14px; font-size: 14px;\">".(int)($o['totalprice'] / $devide)." ".$ccc."</td>";
					/* end price */
					$plannedTripInvoice .= '</tr>';
					break;
			}
		}


		if(
			!empty($o['damzgvevi']) && 
			!empty($o['dazgveuli']) && 
			!empty($o['misamarti']) && 
			!empty($o['dabtarigi']) && 
			!empty($o['pasporti']) && 
			!empty($o['piradinomeri']) && 
			!empty($o['telefonis']) 
		){
			// $email_text .= "<strong style=\"line-height:26px;\"><img src=\"https://tripplanner.ge/_website/img/incurance.png\" alt=\"\" width=\"23\" align=\"left\" style=\"float:left; margin-right:10px;\" />+ Free Insurance: </strong><br />";
			// $email_text .= "<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\" style=\"border:solid 1px #cccccc; width:450px; margin:15px 0\">";

			// $email_text .= "<tr>";
			// $email_text .= "<th style=\"background-color:#12693b; color:white\">".l("damzgvevi")."</th>";
			// $email_text .= "<td>{$o['damzgvevi']}</td>";
			// $email_text .= "</tr>";

			// $email_text .= "<tr>";
			// $email_text .= "<th style=\"background-color:#12693b; color:white\">".l("dazgveuli")."</th>";
			// $email_text .= "<td>{$o['dazgveuli']}</td>";
			// $email_text .= "</tr>";

			// $email_text .= "<tr>";
			// $email_text .= "<th style=\"background-color:#12693b; color:white\">".l("address")."</th>";
			// $email_text .= "<td>{$o['misamarti']}</td>";
			// $email_text .= "</tr>";

			// $email_text .= "<tr>";
			// $email_text .= "<th style=\"background-color:#12693b; color:white\">".l("dob")."</th>";
			// $email_text .= "<td>{$o['dabtarigi']}</td>";
			// $email_text .= "</tr>";

			// $email_text .= "<tr>";
			// $email_text .= "<th style=\"background-color:#12693b; color:white\">".l("pasportisnomeri")."</th>";
			// $email_text .= "<td>{$o['pasporti']}</td>";
			// $email_text .= "</tr>";

			// $email_text .= "<tr>";
			// $email_text .= "<th style=\"background-color:#12693b; color:white\">".l("piradinomeri")."</th>";
			// $email_text .= "<td>{$o['piradinomeri']}</td>";
			// $email_text .= "</tr>";

			// $email_text .= "<tr>";
			// $email_text .= "<th style=\"background-color:#12693b; color:white\">".l("telefonisnomeri")."</th>";
			// $email_text .= "<td>{$o['telefonis']}</td>";
			// $email_text .= "</tr>";

			// $email_text .= "</table>";
		}

		// $email_text .= "<br />";
		// $email_text .= "<br />";
		// $email_text .= "<h2 style='color:#555555'>".l("totalpricefinal").": {$theHoleTotalPrice} ".l('gel')."</h2>";
		// $email_text .= "<h2 style='color:{$statusColor}'>Payment status: {$payStatus}</h2>";


		////////////////////// Invoice Start ///////////////////////
		$invoiveHtml = '<table border="0" cellpadding="0" cellspacing="0" class="maintable">';
		$invoiveHtml .= '<tr>';
		$invoiveHtml .= '<td align="center" colspan="2"><img src="https://tripplanner.ge/_website/img/header_logo.png" alt="logo" align="center" width="256" /></td>';
		$invoiveHtml .= '</tr>';
		$invoiveHtml .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
		$invoiveHtml .= '<tr>';
		$invoiveHtml .= '<td align="left">';
		$invoiveHtml .= "<h2 style=\"margin:0; padding:0 0 10px 0; line-height: 28px; font-size: 22px; color: #2d7b52;\">{$_SESSION["trip_user_info"]["firstname"]} {$_SESSION["trip_user_info"]["lastname"]}</h2>";
		$invoiveHtml .= "<p style=\"margin:0; padding:5px 0; font-size: 16px;\"><strong>".l("piradinomeri").":</strong> {$_SESSION["trip_user_info"]["pn"]}</p>";
		$invoiveHtml .= "<p style=\"margin:0; padding:5px 0; font-size: 16px;\"><strong>".l("telefonisnomeri").":</strong> {$_SESSION["trip_user_info"]["mobile"]}</p>";
		$invoiveHtml .= "<p style=\"margin:0; padding:5px 0; font-size: 16px;\"><strong>".l("email").":</strong> {$_SESSION["trip_user_info"]["email"]}</p>";
		$invoiveHtml .= '</td>';
		$invoiveHtml .= '<td align="right">';
		$invoiveHtml .= "<p style=\"margin:0; padding:5px 0; font-size: 16px;\"><strong>#</strong> {$o["id"]}</p>";
		$invoiveHtml .= "<p style=\"margin:0; padding:5px 0; font-size: 16px;\"><strong>".l("date").":</strong> ". date("d/m/Y") ."</p>";
		$invoiveHtml .= '</td>';
		$invoiveHtml .= '</tr>';
		$invoiveHtml .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
		
		if(isset($ongoingTourInvoice) && !empty($ongoingTourInvoice)){
			// On going tour
			$invoiveHtml .= '<tr>';
			$invoiveHtml .= '<td colspan="2"><h3 style="margin:0 0 15px 0; padding:0; font-size: 16px; ">'.menu_title(63).'</h3></td>';
			$invoiveHtml .= '</tr>';
			$invoiveHtml .= '<tr>';
			$invoiveHtml .= '<td colspan="2">';
			$invoiveHtml .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
			$invoiveHtml .= '<tr style="background-color: #2d7b52">';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("date").'</th>';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("title").'</th>';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("adults").'</th>';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("children").'</th>';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("price").'</th>';
			$invoiveHtml .= '</tr>';
			
			$invoiveHtml .= $ongoingTourInvoice;

			$invoiveHtml .= '</table>';
			$invoiveHtml .= '</td>';
			$invoiveHtml .= '</tr>';
			
			$invoiveHtml .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
		}
			
		// planned tour
		if(isset($plannedTripInvoice) && !empty($plannedTripInvoice)){
			$invoiveHtml .= '<tr>';
			$invoiveHtml .= '<td colspan="2"><h3 style="margin:0 0 15px 0; padding:0; font-size: 16px; ">'.l("plannedtrip").'</h3></td>';
			$invoiveHtml .= '</tr>';
			$invoiveHtml .= '<tr>';
			$invoiveHtml .= '<td colspan="2">';
			$invoiveHtml .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
			$invoiveHtml .= '<tr style="background-color: #2d7b52">';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("date").'</th>';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.menu_title(110).'</th>';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("services").'</th>';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("adults").' & '.l("children").'</th>';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("price").'</th>';
			$invoiveHtml .= '</tr>';

			$invoiveHtml .= $plannedTripInvoice;
			$invoiveHtml .= '</table>';
			$invoiveHtml .= '</td>';
			$invoiveHtml .= '</tr>';			
			$invoiveHtml .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
		}

		if(isset($transfersInvoices) && !empty($transfersInvoices))
		{
			// transfers
			$invoiveHtml .= '<tr>';
			$invoiveHtml .= '<td colspan="2"><h3 style="margin:0 0 15px 0; padding:0; font-size: 16px; ">'.menu_title(62).'</h3></td>';
			$invoiveHtml .= '</tr>';
			$invoiveHtml .= '<tr>';
			$invoiveHtml .= '<td colspan="2">';
			$invoiveHtml .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
			$invoiveHtml .= '<tr style="background-color: #2d7b52">';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("date").' & '.l("time").'</th>';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("from").' - '.l('destination').'</th>';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("transport").'</th>';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("adults").' & '.l("children").'</th>';
			$invoiveHtml .= '<th style="margin:0; padding:0; font-size: 13px; color: white;">'.l("price").'</th>';
			$invoiveHtml .= '</tr>';

			$invoiveHtml .= $transfersInvoices;

			$invoiveHtml .= '</table>';
			$invoiveHtml .= '</td>';
			$invoiveHtml .= '</tr>';
		
			$invoiveHtml .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
		}		

		// $invoiveHtml .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';

		$invoiveHtml .= '<tr>';
		$invoiveHtml .= '<td colspan="2" style="textalign:right"><span style="font-size:10px">'.l("paymentdescription").'</span></td>';
		$invoiveHtml .= '</tr>';
		
		$invoiveHtml .= '<tr>';
		$invoiveHtml .= '<td>'.l("totalpricefinal").'</td>';
		/*start price*/
		if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="usd"){
			$devide = (float)s("currencyusd");
			$ccc = "$";
		}else if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="eur"){
			$devide = (float)s("courseeur");
			$ccc = "&euro;";
		}else{
			$devide = 1;
			$ccc = l('gel');
		}
		$invoiveHtml .= "<td align=\"right\">".(int)($theHoleTotalPrice / $devide)." ".$ccc."</td>";
		/*start price*/

		$invoiveHtml .= '</tr>';

		$invoiveHtml .= '<tr>';
		$invoiveHtml .= '<td>'.l("status").'</td>';
		if($status=="payed"){
			$invoiveHtml .= "<td align=\"right\" style=\"color:green\">".l("payed")."</td>";
		}else{
			$invoiveHtml .= "<td align=\"right\" style=\"color:red\">".l("unpayed")."</td>";
		}
		$invoiveHtml .= '</tr>';

		$invoiveHtml .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
		
		// Bank Requiries
		$invoiveHtml .= '<tr>';
		$invoiveHtml .= '<td colspan="2">';
		$invoiveHtml .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
		$invoiveHtml .= '<tr>';
		$invoiveHtml .= '<td colspan="2">';
		$invoiveHtml .= '<h3 style="margin:0 0 15px 0; padding:0; font-size: 16px; ">'.l("bankrequirement").'</h3>';
		$invoiveHtml .= '</td>';
		$invoiveHtml .= '</tr>';

		$invoiveHtml .= '<tr style="margin:0; padding:0; font-size: 14px;">';
		$invoiveHtml .= '<td><strong>'.l("company").': </strong></td>';
		$invoiveHtml .= "<td>".s('ltd')."</td>";
		$invoiveHtml .= '</tr>'; 
		$invoiveHtml .= '<tr style="margin:0; padding:0; font-size: 14px;">';
		$invoiveHtml .= '<td><strong>'.l("address").': </strong></td>';
		$invoiveHtml .= "<td>".s('invaddress')."</td>";
		$invoiveHtml .= '</tr>'; 
		$invoiveHtml .= '<tr style="margin:0; padding:0; font-size: 14px;">';
		$invoiveHtml .= '<td><strong>'.l("bank").': </strong></td>';
		$invoiveHtml .= "<td>".s('invbank')."</td>";
		$invoiveHtml .= '</tr>';
		$invoiveHtml .= '<tr style="margin:0; padding:0; font-size: 14px;">';
		$invoiveHtml .= '<td><strong>'.l("bank").' #: </strong></td>';
		$invoiveHtml .= "<td>".s('invbankcode')."</td>";
		$invoiveHtml .= '</tr>';
		$invoiveHtml .= '<tr style="margin:0; padding:0; font-size: 14px;">';
		$invoiveHtml .= '<td><strong>'.l("accountnumber").' #: </strong></td>';
		$invoiveHtml .= "<td>".s('invaccount')."</td>";
		$invoiveHtml .= '</tr>';
		$invoiveHtml .= '</table>';
		$invoiveHtml .= '</td>';
		$invoiveHtml .= '</tr>';

		

		// $invoiveHtml .= '<tr>';
		// $invoiveHtml .= '<td>Pay status</td>';
		// $invoiveHtml .= "<td style='color:{$statusColor}'>{$payStatus}</td>";
		// $invoiveHtml .= '</tr>';
		$invoiveHtml .= '</table>';

		$invoiceFilePath = g_generate_invoice($o["id"], $invoiveHtml);
		////////////////////// Invoice End ///////////////////////

		$subject = ($status=="payed") ? l("payedsubject") : l("invoicesubject");

		if(count($info_mail_file)>0){
			$info_mail_file[] = $invoiceFilePath; 
			g_send_email(array(
				"sendTo"=>$user_trip, 
				"subject"=>$subject, 
				"attachment"=>$info_mail_file, 
				"body"=>$email_text 
			));

			g_send_email(array(
				"sendTo"=>"info@tripplanner.ge", 
				"subject"=>$subject, 
				"attachment"=>$info_mail_file,
				"body"=>$email_text 
			));
		}else{
			g_send_email(array(
				"sendTo"=>$user_trip, 
				"subject"=>$subject, 
				"attachment"=>$invoiceFilePath, 
				"body"=>$email_text 
			));

			g_send_email(array(
				"sendTo"=>"info@tripplanner.ge", 
				"subject"=>$subject, 
				"attachment"=>$invoiceFilePath,
				"body"=>$email_text 
			));
		}

		$mailsent = db_query("UPDATE `cart` SET `mailsent`=1, `attachment`='".$invoiceFilePath."' WHERE `userid`='{$user_trip}' AND `status`='".$status."' AND `website`='tripplanner'");
	}
}


function g_array_group($arr){
	//$arr = array(1,2,3,4,5);
	$temp = array();
	$result = array();
	foreach($arr as $a){
	  if(count($temp) <= 1){
	   $temp[] = $a;
	  }else if(count($temp)==2){
	    $result[] = $temp;
	    array_shift($temp);
	    $temp[] = $a;
	  }
	}

	$result[] = array($arr[count($arr)-2],  $arr[count($arr)-1]);

	return $result;
}

function g_gift(){
	$fetch = db_fetch("SELECT `menutitle`, `image1` FROM `pages` WHERE `id`=221 AND `language`='".l()."'");
	return $fetch;
}

function gnb(){
	$html = file_get_contents('http://www.nbg.ge/rss.php');
	$file_path = "/home4/tripplanner/public_html/_currency/currency.xml"; 
	$myfile = fopen($file_path, "w+") or die("Unable to open file!");
	fwrite($myfile, (string)$html);
	fclose($myfile);


	$file_get = file_get_contents($file_path);

	if(preg_match_all("'<description>(.*?)</description>'si", $file_get, $matches)){
		$table = str_replace(array("<description><![CDATA[", "]]></description>"), "", $matches[0][1]);
		
		if(preg_match_all("'<tr>(.*?)</tr>'si", $table, $matches2)){
			foreach ($matches2[0] as $v) {
				if(preg_match_all("'<td>(.*?)</td>'si", $v, $matches3)){
					
					if(isset($matches3[0][0]) && isset($matches3[0][2])){
						$cur = strtoupper(str_replace(array("<td>","</td>"), "", $matches3[0][0]));
						$curVal = str_replace(array("<td>","</td>"), "", $matches3[0][2]);
						
						if($cur=="USD"){
							db_query("UPDATE `settings` SET `value` = '".(float)$curVal."' WHERE `key` ='currencyusd'");
							echo "Updated USD";
						}else if($cur=="EUR"){
							db_query("UPDATE `settings` SET `value` = '".(float)$curVal."' WHERE `key` ='courseeur'");
							echo "Updated EUR";
						}
					}
				}
			}
		}
	}
}