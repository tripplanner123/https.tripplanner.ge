<?php
version_compare(PHP_VERSION, '5.0.0', '<') AND exit('PHP version on the server (' . PHP_VERSION . ') is way tooooo old. Upgrade to PHP 5.0 and greater...');

error_reporting(PRODUCTION ? 0 : E_ALL & ~E_STRICT);
ini_set('display_errors', PRODUCTION ? FALSE : TRUE);
ini_set('session.cookie_httponly', 1);

// Folders
define('DIR', str_replace('\\', '/', getcwd()) . '/');
define('JAVASCRIPT', '_javascript2');
define('WEBSITE', '_website');
define('WEBSITE_BASE', 'https://tripplanner.ge/');
define('CMS', '_tripadmin');  

session_start();
header('X-Frame-Options: DENY');

require_once DIR . '_modules/captcha/php-captcha.inc.php';
// Include registry/storage
require_once DIR . CMS . '/class.storage.php';
$storage = Storage::instance();

// Setup configuration
$conf_manager = require DIR . CMS .'/config.php';
$conf_tables = require DIR . CMS .'/config.tables.php';
$conf_website = array();
file_exists(DIR . WEBSITE . '/config.php') AND $conf_website = require_once DIR . WEBSITE . '/config.php';
$storage->configuration = array_merge($conf_manager, $conf_website, $conf_tables);

// Include essential functions
require_once DIR . CMS .'/functions.php';
require_once DIR . CMS . "/languages/" . c('languages.admin') . ".php";

// Set error and exception handlers
// set_error_handler('error_handler');
// set_exception_handler('exception_handler');
// Shutdown hook/callback
// register_shutdown_function('shutdown_handler');
// Set timezone
// $error_state = error_reporting(~E_NOTICE & ~E_STRICT);
if (function_exists('date_default_timezone_set'))
{
    $timezone = c('date.timezone');
    date_default_timezone_set(empty($timezone) ? date_default_timezone_get() : $timezone);
}
// error_reporting($error_state);
// error_reporting(0);

// Disable magic_quotes
get_magic_quotes_runtime() AND set_magic_quotes_runtime(0);

// Deny requesting GLOBALS
if (ini_get('register_globals'))
{
    (isset($_REQUEST['GLOBALS']) OR isset($_FILES['GLOBALS'])) AND exit(1);
    $global_variables = array_keys($GLOBALS);
    $global_variables = array_diff($global_variables, array(
                '_COOKIE', '_ENV', '_GET',
                '_FILES', '_POST', '_REQUEST',
                '_SERVER', '_SESSION', 'GLOBALS'
            ));
    foreach ($global_variables as $name)
        unset($GLOBALS[$name]);
}

// Sanitize input
$_GET = sanitize_input($_GET);
$_POST = sanitize_input($_POST);
$_COOKIE = sanitize_input($_COOKIE);


// Connect to DB
try {
    $hostname = c('database.hostname');
    $dbname = c('database.name');
    $username = c('database.username');
    $password = c('database.password');
    $db_link = new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8", $username, $password);
    $storage->database_link = $db_link;
}
catch(PDOException $e)
{
   echo $e->getMessage();
}
// $db_link = @mysql_connect(c('database.hostname'), c('database.username'), c('database.password')) OR exit('Could not connect to database.');
// $storage->database_link = $db_link;
// mysql_select_db(c('database.name'), $db_link) OR exit('Database table does not exists.');
// db_query('SET NAMES ' . c('database.charset') . ';');


// Route URI
$router = router();
$storage->slug = $router['slug'];
$storage->adminslug = $router['adminslug'];
$storage->segments = $router['segments'];
$storage->language = $router['language'];
// Load language items
$language_sql = "SELECT `key`, `value` FROM ".c('table.language_data')." WHERE `language` = '{$storage->language}' AND `deleted` = 0;";
$language_items = db_fetch_all($language_sql);
if (empty($language_items))
    $storage->language_items = array();
else
{
    $new_language_items = array();
    foreach ($language_items AS $key => $value) {
        $new_language_items[$value['key']] = $value['value'];
    }
    $storage->language_items = $new_language_items;
}

// Language helper
function l($key = NULL)
{
    $storage = Storage::instance();
    if (empty($key))
        return $storage->language;
    return array_key_exists($key, $storage->language_items) ? $storage->language_items[$key] : NULL;
}

function l_long($language)
{
    $language_sql = c('languages.full');
    return isset($language_sql[$language]) ? $language_sql[$language] : NULL;
}

// Unset unessential variables
unset($conf_manager, $conf_website, $error_state, $db_link, $language_sql, $language_items);

$storage->total_queries = 0;
