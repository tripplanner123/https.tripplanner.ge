<?php



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
			$page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND slug = '{$segment}' LIMIT 1;");
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

						<!--<object width="100%" height="100%">

							<param name="movie" value="http://www.youtube.com/v/'.$vid.'?version=3&amp;hl=en_US"></param>

							<param name="allowFullScreen" value="true"></param>

							<param name="allowscriptaccess" value="always"></param>

							<param name="wmode" value="transparent"></param>

							<embed src="http://www.youtube.com/v/'.$vid.'?version=3&amp;hl=en_US" type="application/x-shockwave-flash" width="100%" height="100%" wmode="transparent" allowscriptaccess="always" allowfullscreen="true"></embed>

						</object>-->

						</div>

						';      

	    $i++;

	    endforeach;

    return $out;

}



function news()

{

    $sql = "SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND visibility = 1 AND menuid = 11 AND `deleted` = '0' ORDER BY postdate DESC LIMIT 2;";

    $news = db_fetch_all($sql);

    if (empty($news))

        return NULL;

    $out = NULL;

	$count = 0;

    foreach ($news AS $item)

    {

		$count++;

        $link = href($item['id']);

        if($count % 2 != 0) {

	        $out .= '	

			        <div class="res-content fix">

				        <div class="col-sm-6 content-img">

				          <img src="crop.php?img='.$item['image1'].'&n='.(($count % 2 != 0) ? '5' : '7').'" class="img-responsive">

				        </div>

				        <div class="col-sm-6 news-text">

				          <h4>' . $item['title'] . '</h4>

				          <div class="news-date">' . convert_date($item["postdate"]) . '</div>

				          ' . $item['description'] . '

				        </div>

					</div>

		        ';

        } else {

	        $out .= '	

			        <div class="res-content fix">

				        <div class="clear"></div>

				        <div class="col-sm-6 right content-img">

				          <img src="crop.php?img='.$item['image1'].'&n='.(($count % 2 != 0) ? '5' : '7').'" class="img-responsive">

				        </div>

				        <div class="col-sm-6 news-text right tr">

				          <h4>' . $item['title'] . '</h4>

				          <div class="news-date">' . convert_date($item["postdate"]) . '</div>

				          ' . $item['description'] . '

				        </div>

			        </div>

		        ';

	    }

    }

    return $out;

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

  function menu_title($id=1) {

  	  $items=db_fetch("select * from pages where language='".l()."' and id=".$id." order by position");

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

function g_userinfo(){
	$username = (isset($_SESSION["trip_user"])) ? $_SESSION["trip_user"] : '';
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

		$mail->isSMTP(); 
		$mail->CharSet = 'UTF-8';
		$mail->Host = "mail.404.ge";
		$mail->SMTPAuth = true;
		$mail->Username = "hosting@404.ge";
		$mail->Password = "[KoI!ADw^M;F1X_TXB";
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;

		$mail->setFrom("hosting@404.ge", "Trip Planner");
		$mail->addAddress($args["sendTo"]); 
		$mail->addReplyTo("hosting@404.ge");
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');

		// $mail->addAttachment('/var/tmp/file.tar.gz');         
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   
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

function g_usertop(){
	$out = "";
	if(isset($_SESSION["trip_user"])){
		$out .= "<div class=\"HeaderUserPanel\">";
		$background = (isset($_SESSION["trip_user_info"]["picture"]) && !empty($_SESSION["trip_user_info"]["picture"])) ? ' style="background-image: url('.$_SESSION["trip_user_info"]["picture"].')"' : '';
		$out .= "<div class=\"UserImage\" ".$background."></div>";
		if(isset($_SESSION["trip_user_info"]["firstname"])){
			$usersfirstname = g_cut($_SESSION["trip_user_info"]["firstname"], 16);
			$out .= sprintf("<a href=\"%s\" class=\"UserText\">%s, %s</a>", href(68), l("hi"), $usersfirstname);	
		}else{
			$out .= sprintf("<div class=\"UserText\">Hi!</div>");
		}
		
		$out .= "</div>";
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
		$out .= sprintf("<a href=\"%s\" class=\"FacebookLogin\"></a>", $loginUrl);
		$out .= "<div class=\"DropDownLogin\">";
		$out .= "<div class=\"Title\">OR</div>";
		$out .= "<div class=\"row\">";

		$out .= "<div class=\"form-group col-sm-12\">";
		$out .= "<div class=\"MaterialForm top-login-email-box\">";
		$out .= "<input type=\"text\" class=\"top-login-email\" name=\"top-login-email\" required />";
		$out .= "<span class=\"highlight\"></span>";
		$out .= "<span class=\"bar\"></span>";
		$out .= sprintf("<label>%s</label>", l("email"));
		$out .= "<div class=\"ErrorText gErrorText\"></div>";
		$out .= "</div>";
		$out .= "</div>";

		$out .= "<div class=\"form-group col-sm-12\">";
		$out .= "<div class=\"MaterialForm top-login-password-box\">";
		$out .= "<input type=\"password\" class=\"top-login-password\" name=\"top-login-password\"  required />";
		$out .= "<span class=\"highlight\"></span>";
		$out .= "<span class=\"bar\"></span>";
		$out .= sprintf("<label>%s</label>", l("password"));
		$out .= "<div class=\"ErrorText gErrorText\"></div>";
		$out .= "</div>";
		$out .= "</div>";

		$out .= "<div class=\"form-group col-sm-12 margin_0\">";
		$out .= sprintf("<a href=\"%s\" class=\"ForgetPassLink\">%s</a>", href('70'), menu_title('70'));
		$out .= "</div>";
		
		$out .= "<div class=\"form-group col-sm-12 margin_0\">";
		$out .= sprintf("<button class=\"GreenCircleButton toploginButtonTri\">%s</button>", l("login"));
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

	if ($_FILES["profile-photo"]["size"] > 2000000) {
	    $uploadOk = 0;
	}
	
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

	    	$selectOld = "SELECT `picture` FROM `site_users` WHERE 
	    	`username`='".$_SESSION["trip_user"]."' AND 
	    	`deleted`=0"; 
	    	$fetch = db_fetch($selectOld);

	    	
	    	if(isset($fetch["picture"]) && file_exists($fetch["picture"])){
	    		unlink($fetch["picture"]); 
	    	}

	    	$update = "UPDATE `site_users` SET 
	        `picture`='".$newFileName ."' 
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


function g_places($categories = false, $startedplace = false)
{
	$categories = ($categories) ? " AND `categories`={$categories}" : "";
	$startedplace = ($startedplace) ? " AND `startedplace`=1" : "";
	$planner_show = (empty($startedplace)) ? " AND `planner_show`=1" : "";
	$sql = "SELECT `id`, `title`, `description`, `image1`, `map_coordinates`, `regions`, `categories` FROM `catalogs` WHERE `language`='".l()."' AND `menuid`=36 AND `visibility`=1 AND `deleted`=0 AND `map_coordinates`!=''{$categories}{$startedplace}{$planner_show} ORDER BY `position` ASC";
	//echo $sql;
	$fetch = db_fetch_all($sql);
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
		`catalogs`.`visibility`=1 
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
	if(preg_match_all("/\[(\d+)-(\d+)-(\d+)\]/", $places, $matches)){
		if(isset($matches[1])){
			$in = implode(",",$matches[1]);
	    	$sql = "SELECT `map_coordinates` FROM `catalogs` WHERE `id` IN (".$in.") AND `language`='".l()."' AND `menuid`=36";
	    	$map_coordinates = db_fetch_all($sql);
	    }
  	}
  	return $map_coordinates;
}

function g_transfer_start_places(){
	$sql = "SELECT * FROM `".c("table.catalogs")."` WHERE menuid=42 and planner_show=1 and visibility=1 and deleted=0 and language = '" . l() . "' order by id desc";
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
    (SELECT MAX(`price`) FROM `".c("table.catalogs")."` WHERE menuid =24 and visibility=1 and deleted=0 and language = '" . l() . "' ".$filter.") AS maxPrice,
    (SELECT MIN(`price`) FROM `".c("table.catalogs")."` WHERE menuid =24 and visibility=1 and deleted=0 and language = '" . l() . "' ".$filter.") AS minPrice,
    (SELECT COUNT(`id`) FROM `".c("table.catalogs")."` WHERE menuid =24 and visibility=1 and deleted=0 and language = '" . l() . "' ".$filter.") AS counted,
    `catalogs`.`id`, 
    `catalogs`.`idx`, 
    `catalogs`.`title`, 
    `catalogs`.`image1`, 
    `catalogs`.`price`, 
    `catalogs`.`slug`, 
    `catalogs`.`day_count`, 
    `catalogs`.`tourists`, 
    `cart`.`id` AS cartId
    FROM `".c("table.catalogs")."` 
    LEFT JOIN `cart` ON `catalogs`.`id`=`cart`.`pid` AND `cart`.`userid`='".$userid."'
    WHERE menuid =24 and visibility=1 and deleted=0 and language = '" . l() . "' ".$filter." order by id desc"."{$limit}";
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
    (SELECT COUNT(`id`) FROM `".c("table.catalogs")."` WHERE menuid =24 and visibility=1 and deleted=0 and language = '" . l() . "') AS counted,
    `catalogs`.`id`, 
    `catalogs`.`idx`, 
    `catalogs`.`title`, 
    `catalogs`.`image1`, 
    `catalogs`.`price`, 
    `catalogs`.`slug`, 
    `catalogs`.`day_count`, 
    `catalogs`.`tourists`, 
    `cart`.`id` AS cartId
    FROM `".c("table.catalogs")."` 
    LEFT JOIN `cart` ON `catalogs`.`id`=`cart`.`pid` AND `cart`.`userid`='".$userid."'
    WHERE `menuid` =24 and `visibility`=1 and `deleted`=0 and `language` = '" . l() . "'{$top_tour}{$top_offers} order by `id` desc"."{$limit}"; // 
    $res = db_fetch_all($sql); 
    return $res;
}

function g_random($length)
{
	$bytes = openssl_random_pseudo_bytes($length * 2);
	return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
}

function g_cart(){
	$userid = (isset($_SESSION["cartsession"])) ? $_SESSION["cartsession"] : 0;
	$sql = "SELECT 
	`cart`.`id`,
	`cart`.`tourplaces`,
	`catalogs`.`image1`, 
	`catalogs`.`title`,  
	`catalogs`.`price` 
	FROM 
	`cart`
	LEFT JOIN `catalogs` ON `catalogs`.`id`=`cart`.`pid` AND `catalogs`.`language`='".l()."'
	WHERE 
	`cart`.`userid`='".$userid."'	
	";
	$fetch = db_fetch_all($sql);
	return $fetch;
}

function g_cart_count($userid){
	$countSql = "SELECT COUNT(`id`) as counted FROM `cart` WHERE `userid`='".$userid."'"; 
    $countFetch = db_fetch($countSql);
    $countCartitem = (isset($countFetch['counted'])) ? $countFetch['counted'] : 0;
    return $countCartitem;
}