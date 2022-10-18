<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
define('DOING_AJAX', 1);

if (!isset($_COOKIE['api_token']) && (!isset($_GET['a']) || $_GET['a'] != 'load')) {
    header('Location: /');
}
header('Content-Type: text/html; charset=utf-8');


require_once "../../../../wp-config.php";
if (!defined('NA5KU_SITE_API_KEY')) {
    $siteApiKey = get_option('mc_na5ku_api_key') ? get_option('mc_na5ku_api_key') : '';
    define('NA5KU_SITE_API_KEY', $siteApiKey, 1);
}

$_GET = array_map('stripslashes_deep', $_GET);
$_POST = array_map('stripslashes_deep', $_POST);
$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
$_SERVER = array_map('stripslashes_deep', $_SERVER);
$_REQUEST = array_map('stripslashes_deep', $_REQUEST);

require_once NA5KU_PLUGIN_DIR . '/api_wrappers/User.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/Order.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/Messages.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/Premoderation.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/GenSettings.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/TypeOrder.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/SubjectOrder.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/SpecialtyOrder.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/CommentClient.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/EventCenter.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/Manager.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/Promo.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/PaymentUA.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/PaymentRU.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/Referer.php';
require_once NA5KU_PLUGIN_DIR . '/api_wrappers/Files.php';
require_once NA5KU_CABINET_DIR . "/install/function.php";

$GenSettings = new GenSettings();
$userApi = new User();
$orderApi = new Order();


//var_dump('WINDOWS',mb_internal_encoding("WINDOWS-1251"));


$p = isset($_GET["p"]) ? $_GET["p"] : NULL;
$a = isset($_GET["a"]) ? $_GET["a"] : NULL;
$a2 = isset($_GET["a2"]) ? $_GET["a2"] : NULL;
$a3 = isset($_GET["a3"]) ? $_GET["a3"] : NULL;
$a4 = isset($_GET["a4"]) ? $_GET["a4"] : NULL;
$a5 = isset($_GET["a5"]) ? $_GET["a5"] : NULL;

$db = db_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


$table_name = $table_prefix . 'options';
$query = "SELECT * FROM $table_name WHERE `option_name` = 'mc_bg_header_logo' or `option_name` = 'mc_bg_phone1' or 
              `option_name` = 'mc_bg_phone2' or `option_name` = 'mc_bg_text_footer' or `option_name` = 'mc_bg_valuta' or `option_name` = 'mc_bg_ref_id' or `option_name` = 'mc_bg_text_title'";
$wpConfigs = baza_do($query);


if (!$wpConfigs) {
    die('Пройдите установку');
}
$user_data = [];
foreach ($wpConfigs as $wpConfig) {
    $key = $wpConfig['option_name'];
    $user_data[$key] = $wpConfig['option_value'];
}

if (!$user_data['mc_bg_ref_id'] && !$siteApiKey) {
    die('В конфигурации необходимо указать REF ID или API KEY');
}

//данные пользователя
$user = $userApi->getCurrent();

if (!(isset($user['data']) && isset($user['data']['id']) && $user['data']['id'])) {
    if ($a == 'load') {
        require_once NA5KU_CABINET_DIR . '/cabinet/action.php';
    } else {
        echo laz_meta('/');
        die('Перенаправление гостя...');
    }
}

if (!isset($user['data']) || !is_array($user['data'])) {
    $user = array('data' => array());
}

if ($user_data) {
    $user_data = array_merge($user_data, $user['data']);
} else {
    $user_data = $user['data'];
}

//бонусные деньги
$userBalanceData = $userApi->get_ref_money([
    'valuta' => isset($user_data['valuta']) ? $user_data['valuta'] : 1,
    'id' => isset($user_data['id']) ? $user_data['id'] : 0
]);

if (isset($userBalanceData) && isset($userBalanceData['data']) && is_array($userBalanceData['data'])) {
    $user_data = array_merge($user_data, $userBalanceData['data']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($a == "open_zakaz" && $a2 == "file_add") {
        include(NA5KU_CABINET_DIR . '/cabinet/zakaz_read.php');
    } elseif ($a == "profile" && $a2 == "save") {
        include(NA5KU_CABINET_DIR . '/cabinet/profile.php');
    } elseif ($a == "zakaz_comm") {
        include(NA5KU_CABINET_DIR . '/cabinet/zakaz_comm.php');
    } elseif ($a == "zakaz_add_do") {
        include(NA5KU_CABINET_DIR . '/cabinet/zakaz_add_do.php');
    } elseif ($a == "profile" && $a2 == NULL) {
        include(NA5KU_CABINET_DIR . '/cabinet/profile.php');
    } elseif ($a == "modal.do") {
        include(NA5KU_CABINET_DIR . '/cabinet/modal.php');
    } elseif ($a == "load") {
        include(NA5KU_CABINET_DIR . '/cabinet/action.php');
    }
} else {
    if ($a == "modal") {
        include(NA5KU_CABINET_DIR . '/cabinet/modal.php');
    } elseif ($a == 'load') {
        require_once NA5KU_CABINET_DIR . '/cabinet/action.php';
    } else {
        require_once NA5KU_CABINET_DIR . '/index_main_client.php';
    }
}

