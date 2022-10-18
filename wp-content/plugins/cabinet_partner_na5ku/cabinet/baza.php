<?php

$debug = 0;

ini_set('display_errors', $debug);
ini_set('display_startup_errors', $debug);
ini_set('session. bug_compat_warn', $debug);
ini_set('session.bug_compat_42', $debug);
if ($debug) {
    error_reporting(-1);
}

//Cabinet plugin
define('NA5KU_CDN_URL', 'https://cdn.edu-masters.com/');
$API_URL = 'https://api.edu-masters.com/';
//$API_URL = 'https://api.na5ku.gl.ge/';

define('NA5KU_API_URL', $API_URL);
define('NA5KU_PLATON_URL', 'https://secure.platononline.com/payment/auth');

define('NA5KU_APP_VER', '2022.01.17');

$dir_name = dirname(__FILE__) . '/';
define('NA5KU_PLUGIN_DIR', dirname(__FILE__) . '/../'); // with "/"
define('NA5KU_PLUGIN_DIR_URL', plugin_dir_url(dirname(__DIR__ . '/../'))); // with "/"

list($wrapper, $path) = explode('://', NA5KU_PLUGIN_DIR_URL, 2);
list($wrapper, $path) = explode('/', $path, 2);

define('NA5KU_PLUGIN_DIR_URL_WITHOUT_DOMAIN', $path); // with "/"
define('NA5KU_CABINET_DIR', dirname(__FILE__)); // with "/"

// папка скрипта
$script_folder = "/";
//Внешная ссылка на папку скрипта
$my_site = "http://" . $_SERVER['HTTP_HOST'] . "/";
$my_site2 = $_SERVER['HTTP_HOST'];

$mail_from = "noreply@$my_site2";

$kurs = 0.39;
$files_white_list = array();

date_default_timezone_set("Europe/Kiev");

if (!defined('NA5KU_SITE_API_KEY')) {
    $siteApiKey = get_option('mc_na5ku_api_key') ? get_option('mc_na5ku_api_key') : '';
    define('NA5KU_SITE_API_KEY', $siteApiKey);
}





