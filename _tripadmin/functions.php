<?php

defined('DIR') OR exit;

function getUserRight($userid, $action="", $subaction="") {
   	$user = db_fetch("SELECT * FROM " . c('table.users') . " WHERE id = '" . $userid . "';");
	if($user["usercat"]=="Administrator")
		return true;
	$access = db_fetch("SELECT count(*) AS cnt FROM " . c('table.user_access') . " WHERE userid = '" . $userid . "' AND action = '" . $action . "';");
	if($access["cnt"]>0) {
		return true;
	}
	return false;
}

function str_lreplace($search, $replace, $subject) {
	$pos = strrpos($subject, $search);
	if($pos === false) {
		return $subject;
	} else {
		return substr_replace($subject, $replace, $pos, strlen($search));
	}
}

function utf82lat($string="")
{
	$utf8 = array("ა", "ბ", "გ", "დ", "ე", "ვ", "ზ", "თ", "ი", "კ", "ლ", "მ", "ნ", "ო", "პ", "ჟ", "რ", "ს", "ტ", "უ", "ფ", "ქ", "ღ", "ყ", "შ", "ჩ", "ც", "ძ", "წ", "ჭ", "ხ", "ჯ", "ჰ", );
	$lat  = array("a", "b", "g", "d", "e", "v", "z", "t", "i", "k", "l", "m", "n", "o", "p", "j", "r", "s", "t", "u", "f", "q", "gh", "k", "sh", "ch", "ts", "dz", "ts", "ch", "kh", "dj", "h", );
	$out = str_replace($utf8, $lat, $string);
	return $out;
}

function utf82lat2($string="")
{
	$utf8 = array("ა", "ბ", "გ", "დ", "ე", "ვ", "ზ", "თ", "ი", "კ", "ლ", "მ", "ნ", "ო", "პ", "ჟ", "რ", "ს", "ტ", "უ", "ფ", "ქ", "ღ", "ყ", "შ", "ჩ", "ც", "ძ", "წ", "ჭ", "ხ", "ჯ", "ჰ", );
	$lat  = array("a", "b", "g", "d", "e", "v", "z", "T", "i", "k", "l", "m", "n", "o", "p", "J", "r", "s", "t", "u", "f", "q", "R", "y", "S", "C", "c", "Z", "w", "W", "x", "j", "h", );
	$out = str_replace($utf8, $lat, $string);
	return $out;
}


function trace($data, $title = NULL)
{
//    include_once DIR . '_tripadmin/firephp/FirePHP.class.php';
//    return FirePHP::getInstance(TRUE)->log($data, $title);
}

function c($key = NULL, $default = NULL)
{
    $config = Storage::instance()->get('configuration');
    if (empty($key))
        return $config;
    return array_key_exists($key, $config) ? $config[$key] : $default;
}

// Get Admin Language Variables
function a($key)
{
	global $a;
	return (isset($a[$key])) ? $a[$key] : '';
}

function s($key = '')
{
    $value = NULL;
    $storage = Storage::instance();
	$settings_sql = "SELECT `key`, `value` FROM ".c('table.settings')." WHERE `language` = '{$storage->language}' AND `deleted` = 0 AND `key` = '{$key}';";
	$settings_item = db_fetch($settings_sql);
	$value = $settings_item["value"];
    return $value;
}

function a_s($key = '')
{
    $value = NULL;
    $storage = Storage::instance();
	$settings_sql = "SELECT `key`, `value` FROM ".c('table.admin_settings')." WHERE `language` = '{$storage->language}' AND `deleted` = 0 AND `key` = '{$key}';";
	$settings_item = db_fetch($settings_sql);
	$value = $settings_item["value"];
    return $value;
}

function v()
{
	return (sha1(c('site.url'))==c('admin.hash')) ? TRUE : FALSE;
}

function router()
{
    $request_uri = explode('/', $_SERVER['REQUEST_URI']);
    $script_name = explode('/', $_SERVER['SCRIPT_NAME']);
    $segments = array_diff_assoc($request_uri, $script_name);
    if (empty($segments))
    {
        return array(
            'language' => c('languages.default'),
            'slug' => NULL,
            'segments' => array()
        );
    }
    foreach($_GET as $key=>$value) {
        $_GET[$key] = str_replace("'", "", str_replace('"', '', $_GET[$key]));
    }
    $segments = array_values($segments);
    $language_id = rtrim(sef($segments[0]), '/');
    $has_language = in_array($language_id, c('languages.all'));
    $uri['language'] = $has_language ? $language_id : c('languages.default');
    $has_language AND $segments = array_slice($segments, 1);
    $last_slug = (count($segments) == 0) ? "" : $segments[count($segments) - 1];
    $qs_position = strpos($last_slug, '?');
    FALSE === $qs_position OR $segments[count($segments) - 1] = substr($last_slug, 0, $qs_position);
    foreach ($segments as $key => $value)
    {
        $segments[$key] = rtrim(sef($value), '/');
        if (empty($segments[$key]))
            unset($segments[$key]);
    }
    if (!empty($segments) && isset($segments[0])) {
        $uri['adminslug'] = $segments[0];
        $uri['slug'] = (string) trim(implode('/', $segments), '/');
        $uri['segments'] = $segments;
    } else {
        $uri['adminslug'] = NULL;
        $uri['slug'] = NULL;
        $uri['segments'] = array();
    }
    $uri['request_uri'] = $request_uri;
    return $uri;
}

function sanitize_input($data)
{
    if (is_array($data) OR is_object($data))
    {
        foreach ($data as $key => $value)
            $data[$key] = sanitize_input($value);
    }
    elseif (is_string($data))
    {
        $data = xss($data);
        $data = stripslashes($data);
        strpos($data, "\r") !== FALSE AND $data = str_replace(array("\r\n", "\r"), "\n", $data);
    }
    return $data;
}

function input($input = INPUT_GET, $name = NULL, $default = FALSE, $input_array = FALSE)
{
    if (empty($name)) {
        $array = filter_input_array($input);
        return empty($array) ? array() : array_filter($array);
    }
    if (is_array($name)) {
        foreach ($name as $key => $value) {
            if (!filter_has_var($input, $key) || filter_input($input, $key) == '')
                $array[$key] = null;
            elseif (is_int($default))
                $array[$key] = filter_input($input, $key, FILTER_SANITIZE_NUMBER_INT);
            elseif (is_string($default))
                $array[$key] = filter_input($input, $key, FILTER_SANITIZE_STRING);
            else
                $array[$key] = filter_input($input, $key);
        }
        return $array;
    }
    if ($input_array) {
        if (is_int($default))
            $array = filter_input($input, $name, FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
        elseif (is_string($default))
            $array = filter_input($input, $name, FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
        else
            $array = filter_input($input, $name, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        return $array;
    }
    if (!filter_has_var($input, $name) || filter_input($input, $name) == '')
        return $default;
    if (is_int($default))
        return filter_input($input, $name, FILTER_SANITIZE_NUMBER_INT);
    if (is_string($default))
        return filter_input($input, $name, FILTER_SANITIZE_STRING);
    return filter_input($input, $name);
}

function get($name = NULL, $default = FALSE, $input_array = FALSE)
{
    return input(INPUT_GET, $name, $default, $input_array);
}

function post($name = NULL, $default = FALSE, $input_array = FALSE)
{
    return input(INPUT_POST, $name, $default, $input_array);
}

function cookie($name = NULL, $default = FALSE, $input_array = FALSE)
{
    return input(INPUT_COOKIE, $name, $default, $input_array);
}

function db_query($sql)
{
    $result = Storage::instance()->get('database_link');
    if($result){
        $prep = $result->prepare($sql);
        $prep->execute();
    }
   

    Storage::instance()->total_queries++;
    return $prep;
}

function db_fetch($sql)
{
    $result = db_query($sql);
    if ($result === FALSE)
        return FALSE;
    return $result->fetch(PDO::FETCH_ASSOC);
}

function db_fetch_all($sql)
{
    $result = db_query($sql);
    if ($result === FALSE)
        return FALSE;
    $fetchAll = $result->fetchAll(PDO::FETCH_ASSOC);
        
    return $fetchAll;
}

function db_retrieve($column, $table, $field, $value, $other = NULL, $log = FALSE)
{
    is_numeric($value) OR $value = "'{$value}'";
    empty($other) OR $other = ' ' . $other;
    $sql = "SELECT `{$column}` FROM `{$table}` WHERE `{$field}` = {$value} {$other};";
    $log AND trace($sql, 'db_retrieve() SQL');
    $result = db_fetch($sql);
    if (empty($result))
        return FALSE;
    return $result[$column];
}

function db_row_exists($clause, $table = 'pages')
{
    $sql = db_fetch("SELECT 1 FROM {$table} WHERE {$clause} LIMIT 1");
    if (!$sql)
        return FALSE;
    else
        return TRUE;
}

function db_insert($table, $data = array())
{
    $fields = array();
    $columns = array();
    foreach ($data as $field => $value)
    {
        $fields[] = "`{$field}`";
        $value = db_escape($value);
        $columns[] = (is_numeric($value) OR 'NULL' === $value) ? $value : '\'' . $value . '\'';
    }
    return 'INSERT INTO `' . $table . '` (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $columns) . ');';
}

function db_update($table, $data = array(), $other = NULL)
{
    $set = array();
    foreach ($data as $field => $value)
    {
        $value = db_escape($value);
        $set[] = "`{$field}` = " . ((is_numeric($value) OR 'NULL' === $value) ? $value : '\'' . $value . '\'');
    }
    return 'UPDATE `' . $table . '` SET ' . implode(', ', $set) . (empty($other) ? NULL : ' ' . $other) . ';';
}

function db_delete($table, $data = array(), $other = NULL)
{
    $del = array();
    foreach ($data as $field => $value)
    {
        $value = db_escape($value);
        $del[] = "`{$field}` = " . ((is_numeric($value) OR 'NULL' === $value) ? $value : '\'' . $value . '\'');
    }
    return 'DELETE FROM `' . $table . '` WHERE ' . implode(' AND ', $del) . (empty($other) ? NULL : ' ' . $other) . ';';
}

function db_escape($value)
{
    if ($value === '')
        return 'NULL';
    switch (gettype($value))
    {
        case 'string':
            $value = $value;
            break;
        case 'boolean':
            $value = (int)$value;
            break;
        case 'double':
            $value = sprintf('%F', $value);
            break;
        default:
            $value = $value === NULL ? 'NULL' : $value;
            break;
    }
    return (string) $value;
}

function get_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    else
        return $_SERVER['REMOTE_ADDR'];
}

function sef($string)
{
    $string = preg_replace('/[^-ა-ჰa-zA-Z0-9_+\/ ]/', NULL, $string);
    $string = preg_replace('/[-_+\/ ]+/', '-', trim($string));
    return strtolower($string);
}

function curl_get($url)
{
    $request = curl_init($url);
    if (FALSE === $request)
        return FALSE;
    curl_setopt_array($request, array(
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_TIMEOUT => 10
    ));
    $response = curl_exec($request);
    curl_close($request);
    return $response;
}

function email($from = array(), $to = array(), $subject = NULL, $body = NULL, $xmailer = "")
{
    $headers = array(
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=utf-8',
        'X-Mailer: '.$xmailer,
        'From: ' . $from
    );
    return mail($to, $subject, $body, implode(PHP_EOL, $headers));
}

function redirect($url)
{
    if (headers_sent())
    {
        $js = '<script type=\"text/javascript\"><!-- ';
        $js .= 'window.location.replace(' . $url . ');';
        $js .= ' //--></script>';
        $html = '<noscript>';
        $html .= '<meta http-equiv="refresh" content="0; url=' . $url . '" />';
        $html .= '</noscript>';
        exit($js . $html);
    }
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $url);
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    exit;
}

function convert_date($date)
{
    if (empty($date))
        return NULL;
    $parts = explode('-', date('Y-n-j', strtotime($date)));
    switch ($parts[1])
    {
        case 1:
            $month = "იანვარი";
            break;
        case 2:
            $month = "თებერვალი";
            break;
        case 3:
            $month = "მარტი";
            break;
        case 4:
            $month = "აპრილი";
            break;
        case 5:
            $month = "მაისი";
            break;
        case 6:
            $month = "ივნისი";
            break;
        case 7:
            $month = "ივლისი";
            break;
        case 8:
            $month = "აგვისტო";
            break;
        case 9:
            $month = "სექტემბერი";
            break;
        case 10:
            $month = "ოქტომბერი";
            break;
        case 11:
            $month = "ნოემბერი";
            break;
        case 12:
            $month = "დეკემბერი";
            break;
        default:
            return NULL;
    }
    return $parts[2] ." ". $month . ", " . $parts[0];
}

function template($file, $variables = array())
{
    $templatefiles = array(
        DIR . '_website/templates/' . $file . '.php',
        DIR . '_tripadmin/templates/' . $file . '.php',
        DIR . '_tripadmin/templates/default' . $file . '.php'
    );
    foreach ($templatefiles as $templatefile)
    {
        if (!file_exists($templatefile))
            continue;
        ob_start() AND extract($variables);
        include $templatefile;
        return ob_get_clean();
    }
}

function plugin_template($file, $variables = array())
{
    $files = array(
        DIR . '_plugins/templates/' . $file . '.php',
    );
    foreach ($files as $template)
    {
        if (!file_exists($template))
            continue;
        ob_start() AND extract($variables);
        include $template;
        return ob_get_clean();
    }
}

function site_template($file, $variables = array())
{
    $files = array(
        '_website/templates/' . $file . '.php',
        '_tripadmin/templates/' . $file . '.php',
        '_tripadmin/templates/default' . $file . '.php'
    );
    foreach ($files as $template)
    {
        if (!file_exists($template))
            continue;
        ob_start() AND extract($variables);
        include $template;
        return ob_get_clean();
    }
}

function error_handler($errno, $errstr, $errfile, $errline)
{
    // TODO: Log errors?
    exit('<b>Error</b>: ' . $errstr . PHP_EOL);
}

function exception_handler($exception)
{
    // TODO: Log errors?
    exit('<b>Error</b>: ' . $exception->getMessage() . PHP_EOL);
}

function shutdown_handler()
{
    //$storage = Storage::instance();
    //$storage->memory_usage = number_format((memory_get_peak_usage() - START_MEMORY) / 1024, 2) . ' KB';
    //$storage->execution_time = number_format(microtime(TRUE) - START_TIME, 5) . ' seconds';
}

function current_id()
{
    $storage = Storage::instance();
    $storage->is_from_list = 0;
    $default = c('section.default');
    if (empty($storage->segments))
        return $default;
    if(!isset($storage->segments[count($storage->segments) - 1])) redirect(href(1));
    $last_segment = $storage->segments[count($storage->segments) - 1];
    if (is_numeric($last_segment)) {
        $storage->is_from_list = 1;
        $segs = array();
        for($i=0; $i<count($storage->segments) - 2; $i++) $segs[] = $storage->segments[$i];
        $curseg = implode('/', $segs);
        $sql = "SELECT category,id FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND slug = '{$curseg}' LIMIT 1;";
        $item = db_fetch($sql);
        if($item["category"]==16) {
            $sql = "SELECT id FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND slug = '{$curseg}' LIMIT 1;";
            $section = db_fetch($sql);
            $userid = (isset($_SESSION["cartsession"])) ? $_SESSION["cartsession"] : 0;
            $sqlx = "SELECT 
                `catalogs`.*, 
                `cart`.`id` AS cartId 
                from 
                ".c("table.catalogs")." 
                LEFT JOIN `cart` ON `catalogs`.`id`=`cart`.`pid` AND `cart`.`userid`='".$userid."'
                where 
                `catalogs`.`id` = {$last_segment} and 
                `catalogs`.`deleted`=0 and 
                `catalogs`.`language`='".l()."' limit 1";
            $product = db_fetch($sqlx);

            $storage->product = $product;
            return $section['id'];
        } else {
            return $last_segment;
        }
    }
    $sql = "SELECT id FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND slug = '{$storage->slug}' LIMIT 1;";
    $section = db_fetch($sql);
    return $section['id'];
}

function generate_params($optionals = NULL) {
	$params = array();
	if($optionals==NULL)
		$optionals = array('menu', 'id', 'idx', 'gameid');
	foreach ($optionals as $name)
	{
		if (($option = get($name)) === FALSE)
			continue;
		$params[$name] = $option;
	}
	return $params;
}

function ahref($route = array(), $params = array(), $language = NULL)
{
    $url = c('site.url');
    $base_file = c('site.base');
    empty($base_file) OR $url .= $base_file . '/';
    $url .= empty($language) ? (count(c('languages.all')) == 1 ? NULL : l() . '/') : $language . '/';
    $url .= c('admin.slug');
    
    if(count($route) && is_array($route)){
        $route = array_filter($route);
        foreach ($route as $key => $value) {
            $url .= '/'.$value;
        }
    }

    if(count($params) && is_array($params)){
        $params = array_filter($params);
        empty($params) OR $url .= '?' . http_build_query($params);
    }
    
    return $url;
}

function href($section = NULL, $params = array(), $language = NULL, $product = NULL)
{
    $url = c('site.url');
    if (empty($section))
        return $url;
    $base_file = c('site.base');
    empty($base_file) OR $url .= $base_file . '/';

    if (empty($language)) {
        if (count(c('languages.all')) > 1)
            $url .= l() . '/';
        else
            $url .= $language . '/';
        $language = l();
    } else {
        $url .= $language . '/';
    }
    if (is_numeric($section)) {
        $section_res = db_fetch("SELECT redirectlink, menuid, slug FROM " . c("table.pages") . " WHERE language = '{$language}' AND id = {$section} LIMIT 1;");
        if (empty($section_res))
            return $url;
        if (!empty($section_res['redirectlink']))
            return strtr($section_res['redirectlink'], array(':lang' => $language));
        $menuslug = db_fetch("SELECT slug FROM " . c("table.pages") . " WHERE language = '{$language}' AND menutype = '".$section_res["menuid"]."' LIMIT 1;");

        $section_params = c('section.parameters');
        $section_params = array_key_exists($section, $section_params) ? $section_params[$section] + $params : $params;
        $query_string = empty($section_params) ? NULL : '?' . http_build_query($section_params);

        if(!empty($product)) {
            $sql = "SELECT * FROM " . c("table.catalogs") . " WHERE language = '{$language}' AND id = {$product} LIMIT 1;";
            $prod = db_fetch($sql);
            $product_slug = $prod["slug"];
            return $url . $section_res['slug'] . '/' . $product_slug . '/' . $product . $query_string;
        }
        
        if (is_from_list($section_res['menuid'])) 
            $url .= $menuslug['slug'] . '/' . $section_res['slug'] . '/' . $section . $query_string;
        else
            $url .= $section_res['slug'] . $query_string;
    } else {
        $query_string = empty($params) ? NULL : '?' . http_build_query($params);
        $url .= $section . $query_string;
    }
    return $url;
}

function is_from_list($menu_id)
{
    $list_types = c('section.types.lists');
    $lists = array();
    foreach ($list_types as $list)
        $lists[] = '\'' . $list . '\'';
    $sql = 'SELECT id FROM ' . c("table.menus") . ' WHERE type IN (' . implode(', ', $lists) . ');';
    $menus = db_fetch_all($sql);
    if (empty($menus))
        return FALSE;
    $menu_ids = array();
    foreach ($menus as $menu)
        $menu_ids[] = $menu['id'];
    empty($menu_id) AND $menu_id = Storage::instance()->section['menuid'];
    return in_array($menu_id, $menu_ids);
}

function get_idx($id)
{
    return db_retrieve('idx', c("table.pages"), 'id', $id, "AND `language` = '" . l() . "' LIMIT 1");
}

function get_id($idx)
{
    return db_retrieve('id', c("table.pages"), 'idx', $idx);
}

function is_home()
{
    $section = Storage::instance()->get('section');
    return (c('section.default') == $section['id']);
}

function title()
{
    $title = NULL;
	$maintitle = NULL;
    $storage = Storage::instance();
	$settings_sql = "SELECT `key`, `value` FROM ".c('table.settings')." WHERE `language` = '{$storage->language}' AND `deleted` = 0 AND `key` = 'sitetitle';";
	$settings_item = db_fetch($settings_sql);
	$maintitle = $settings_item["value"];
    if (!is_home())
        $title = ' - ' . $storage->section['title'];
    return $maintitle . $title;
}

function in()
{
    return (isset($_SESSION['user']) AND !empty($_SESSION['user']));
}

function xss($data)
{
    // return $data;
    if (is_array($data) OR is_object($data))
    {
        foreach ($data as $key => $value)
            $data[$key] = xss($value);
        return $data;
    }
    if (trim($data) === '')
    {
        return $data;
    }
    $data = str_replace(array('&', '&lt;', '&gt;'), array('&amp;', '&lt;', '&gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
    do
    {
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    }
    while ($old_data !== $data);
    return $data;
}

function child_of($section, $parent_idx = NULL)
{
    if (FALSE === ($section_idx = get_idx($section)))
        return FALSE;
    if (!$parent_idx)
    {
        $parent_idx = Storage::instance()->section['idx'];
        if ($section_idx == $parent_idx)
            return TRUE;
    }
    $sql = "SELECT menuid, masterid, attached FROM " . c("table.pages") . " WHERE idx = {$parent_idx} LIMIT 1;";
    $result = db_fetch($sql);
    if (empty($result))
        return FALSE;
    $attached = db_retrieve('name', c("table.menus"), 'id', $result['menuid'], 'LIMIT 1');
    if ($result['attached'] == $attached)
        return TRUE;
    if ($section_idx == $result['masterid'])
        return TRUE;
    return empty($result['masterid']) ? FALSE : child_of($section, $result['masterid']);
}

function new_slug($slug, $parent = NULL, $edit = FALSE)
{
    $id = empty($edit) ? $parent : db_retrieve('masterid', c("table.pages"), 'id', $parent, 'and language = "'.l().'" LIMIT 1');
    $text = ltrim((empty($parent) ? NULL : db_retrieve('slug', c("table.pages"), 'id', $id, 'and language = "'.l().'" LIMIT 1')) . '/' . sef($slug), '/');
	$slug = utf82lat($text);
	return $slug;
}

function category_to_type($category_id)
{
    switch ($category_id)
    {
        default:
            return 'Text';
        case 2:
            return 'Home Page';
        case 3:
            return 'About Page';
        case 4:
            return 'Search Page';
        case 5:
            return 'Sitemap Page';
        case 6:
            return 'Feedback Page';
        case 7:
            return 'Wizard Page';
        case 8:
            return 'News Page';
        case 9:
            return 'Articles Page';
        case 10:
            return 'Events Page';
        case 11:
            return 'List Page';
        case 12:
            return 'Photo Page';
        case 13:
            return 'Video Page';
        case 14:
            return 'Audio Page';
        case 15:
            return 'Poll Page';
        case 16:
            return 'Catalog Page';
    }
}

function html_decode($value, $sec = ""){
	switch($sec){
		case "pdf":
		$ret = html_entity_decode($value, ENT_COMPAT, 'UTF-8');
		$ret = str_replace("&nbsp;"," ",$ret);
		return $ret;
		break;
		default:
		return html_entity_decode($value, ENT_COMPAT, 'UTF-8');
		break;
	}
}

function rand_string($length = 20, $symbols = false) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if ($symbols)
        $characters .= '!@#$%^&*()-_=+<>?';
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $random_string;
}

function sitemap_xml() {
    $lang = c('languages.all');
    $lang_num = count($lang);
    $out = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
    if ($lang_num > 1) {
        $out .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";
    } else {
        $out .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
    }
    $sitemap = db_fetch_all("SELECT id, menuid, lastupdate FROM ".c("table.catalogs")." WHERE language='".$lang[0]."' AND visibility=1 AND deleted=0 ORDER by postdate DESC");
    foreach ($sitemap AS $item) {
        $cat=db_fetch("SELECT id FROM ".c("table.pages")." WHERE language='".$lang[0]."' AND menutype=".$item["menuid"]);
        $out .= '<url>'."\n";
        $out .= '<loc>'.href($cat["id"], array(), $lang[0], $item['id']).'</loc>'."\n";
        if ($lang_num > 1) {
            foreach ($lang as $l) {
                $out .= '<xhtml:link rel="alternate" hreflang="'.$l.'" href="'.href($cat["id"], array(), $l, $item['id']).'" />'."\n";
            }
        }
        $out .= '<lastmod>'.date("Y-m-d", strtotime($item["lastupdate"])).'</lastmod>'."\n";
        $out .= '<changefreq>weekly</changefreq>'."\n";
        $out .= '<priority>0.8</priority>'."\n";
        $out .= '</url>'."\n";
    }
    $sitemap = db_fetch_all("SELECT id, redirectlink, category, menuid, lastupdate FROM ".c("table.pages")." WHERE language='".$lang[0]."' and visibility=1 AND deleted=0 ORDER by postdate DESC");
    foreach ($sitemap as $item) {
        if ($item["redirectlink"]!="")
            continue;
        switch ($item["category"]):
            case 2:
            case 4:
            case 5:
            case 6:
            case 12:
                continue 2;
            case 0:
                $priority = 0.8;
                $freq = "weekly";
                break;
            case 1:
                $priority = 0.7;
                $freq = "weekly";
                break;
            case 8:
            case 9:
            case 10:
            case 16:
                $priority = 0.6;
                $freq = "weekly";
                break;
            default:
                $priority = 0.5;
                $freq = "monthly";
                break;
        endswitch;
        $out .= '<url>'."\n";
        $out .= '<loc>'.href($item["id"], array(), $lang[0]).'</loc>'."\n";
        if ($lang_num > 1) {
            foreach ($lang as $l) {
                $out .= '<xhtml:link rel="alternate" hreflang="'.$l.'" href="'.href($item["id"], array(), $l).'" />'."\n";
            }
        }
        $out .= '<lastmod>'.date("Y-m-d", strtotime($item["lastupdate"])).'</lastmod>'."\n";
        $out .= '<changefreq>'.$freq.'</changefreq>'."\n";
        $out .= '<priority>'.$priority.'</priority>'."\n";
        $out .= '</url>'."\n";
    }
    $out .= '</urlset>'."\n";
    return $out;
}

function keyword_count_sort($first, $sec)
{
    return $sec[1] - $first[1];
}

function keyword_maker($str, $minWordLen = 3, $minWordOccurrences = 2, $maxWords = 10, $restrict = false, $asArray = false)
{
    $str = preg_replace('/[^\p{L}ა-ჰ0-9\s]/u', ' ', strip_tags($str));
    $str = trim(preg_replace('/\s/', ' ', $str));

    $words = explode(' ', $str);

    if ($restrict == false) {
        $commonWords = array('და','რომ','იყო','იყოს','არი','არის','იგი','მის','მისი','მას','ხომ','ვერ','როცა','შორის','თქვენ','თქვენი','ჩვენ','ჩვენი','ჩვენს','ჩემი','შენ','შენი','არა','არად','რად','ანუ','მაინც','დიახ','ვის','ვიცი','ჰქონოდა','ჰქონდა','იცის','იცის','ერთ','ერთი','ორი','სამი','ოთხი','ხუთი','ექვსი','შვიდი','რვა','ცხრა','ათი','ერთმა','ორმა','სამმა','ოთხმა','ხუთმა','ექვსმა','შვიდმა','რვამ','ცხრამ','ათმა','მეორე','მესამე','მეოთხე','მეხუთე','მეექვსე','მეშვიდე','მერვე','მეცხრე','მეათე','მანამდე','შემდეგ','მაშ','ყოველი','გარდა','ამისა','ყოველი','ყოველ','წელი','წელს','წლის','წლით','თანახმა','თანახმად','ვარ','შესახებ','როდის','რათა','რადგან','რომელიც','ჩანს','მათი','მათ','ზოგან','მან','რაც','როგორც','უნდა','სანამ','არც','ასეთი','ასეთია','მიერ','აძლევს','რომლებიც','რომლის','რომელსაც','მაგრამ','ვისთანაც','ვისთვისაც','ასევე','ყველა','ყველას','შიდა','ამიტომ','უშუალოდ','შესაბამისად','შესაბამისი','შემთხვევაში','იღებს','სხვა','სხვისი','აღწერს','ტოლია','მაშინვე','უფრო','აქვს','კაი','რატომ','გამო','ადრე','სულ','ყველაზე','რამ','რამე','ერთად','სად','აგე','რას','მინდა','გითხრათ','გითხრა','ვთქვა','ბოლოს','მოხდეს','აღარ','აზრს','გვინდა','მხოლოდ','ხოლო','არიან','იქნება','მთელი','თავიანთ','თავიანთი','თავისი','თავის','მსგავსი','მსგავსად','მიიღო','მიიღეს','მეშვეობით','წყალს','დღის','დროს','არჩევა','აირჩია','განმავლობაში','იცლება','ამბავს','წინაშე','წინაშეა','სურათზე','სურათის','სურათს','მასში','მისთვის','იციან','ზუსტად','ბოლომდე','თავისთვის','თავისთვისაც','თითქოს','რაღა','რაღათ','რაღად','თითქმის','ვინღა','ვიღაც','ვინმე','ვინმეს','კიდევ','ზედ','ვიდრე','ნახვა','ვნახე','თუნდ','თუნდაც','ნურც','ზოგი','იმაზე','ჩემო','ერთგვარი','შედეგად','ეხება','გააჩნია','დიდი','შეიძლება','უკვე','რომელიმე','საკმაოდ','საიტი','მადლობა','თუმცა','მაგალითად','საჭიროა','ამისათვის','სხვადასხვა','როდესაც','იყენებენ','ხდება','მქონე','შეგვიძლია','აგრეთვე','ისინი','დაახლოებით','დაახლოვებით','ხოლმე','მეტ','თავად','if','or','the','and','are','com','for','from','how','that','the','this','was','what','when','should','where','there','those','before','after','such','who','will','with','und','about','know','www','это','для','Благодаря');
        $words = array_udiff($words, $commonWords,'strcasecmp');
    }
    // if ($restrict == true) {
    //     $allowedWords =  array();
    //     $words = array_uintersect($words, $allowedWords,'strcasecmp');
    // }

    $keywords = array();
    while(($c_word = array_shift($words)) !== null)
    {
        if(mb_strlen($c_word, 'utf-8') < $minWordLen) continue;

        $c_word = strtolower($c_word);
        if(array_key_exists($c_word, $keywords)) $keywords[$c_word][1]++;
        else $keywords[$c_word] = array($c_word, 1);
    }
    usort($keywords, 'keyword_count_sort');

    $final_keywords = array();
    foreach($keywords as $keyword_det)
    {
        if($keyword_det[1] < $minWordOccurrences) break;
        array_push($final_keywords, $keyword_det[0]);
    }
    $final_keywords = array_slice($final_keywords, 0, $maxWords);
    return $asArray ? $final_keywords : implode(', ', $final_keywords);
}

function text_limit($string, $limit=130, $break=".", $end="")
{
    $nbsp = array("&nbsp;");
    $del_nbsp = array(" ");
    $string = str_replace($nbsp, $del_nbsp, $string);
    $string = preg_replace("/\s\s+/", " ", strip_tags($string));
    if(mb_strlen($string, "utf-8") <= $limit)
        return $string;
    if(false !== ($breakpoint = mb_strpos($string, $break, $limit, "utf-8"))) {
       if($breakpoint < mb_strlen($string, "utf-8") - 1) {
            $string = mb_substr($string, 0, $breakpoint, "utf-8") . $end;
        }
    }
    return $string;
}

function text_match($string, $match="")
{
    if ($string=="")
        return NULL;
    $match_arr = explode(" ",$match);
    foreach($match_arr as $item) {
        if (isset($item) && $item!="" && strpos($string, $item) !== false)
            return $string;
    }
    return $match." - ".$string;
}