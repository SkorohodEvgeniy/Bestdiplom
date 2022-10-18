<?php
session_start();
function getCallbackUrl($referer)
{
    if (!isset($_SERVER['HTTP_REFERER'])) {
        return '/';
    }
    $parsed_url = parse_url($_SERVER['HTTP_REFERER']);
    parse_str($parsed_url['query'], $query_array);
    //print_r($parsed_url);
    if ((isset($query_array['a']) && $query_array['a'] !== 'open_new') || strpos($parsed_url['path'], "dex_") > 1 || isset($query_array['a2'])) { // So user was at some profile page

        return '/';
    }

    return $_SERVER['HTTP_REFERER'];
}

//index_au_zakaz_comment.php
//http://na5ku.com.ua.lazika.ge/guarantee/
//http://na5ku.com.ua.lazika.ge/index_au_zakaz_comment.php

header('Content-Type: text/html; charset=windows-1251');
error_reporting(error_reporting() & ~E_NOTICE);
error_reporting(error_reporting() & ~E_NOTICE);


$_SESSION['zakaz_data'] = "";
$_SESSION['zakaz_type'] = "";
$_SESSION['zakaz_id'] = "";
$_SESSION['zakaz_u'] = "";
$_SESSION['zakaz_key'] = "";
$_SESSION['zakaz_key2'] = "";
$_SESSION['zakaz_not_my'] = "";

$_SESSION['ref_zakaz_data'] = "";
$_SESSION['ref_zakaz_type'] = "";
$_SESSION['ref_zakaz_id'] = "";
$_SESSION['ref_zakaz_u'] = "";
$_SESSION['ref_zakaz_key'] = "";
$_SESSION['ref_zakaz_key2'] = "";
$_SESSION['ref_zakaz_not_my'] = "";

setcookie("zakaz_data", "", time() - 1);
setcookie("zakaz_type", "", time() - 1);
setcookie("zakaz_id", "", time() - 1);
setcookie("zakaz_u", "", time() - 1);
setcookie("zakaz_key", "", time() - 1);
setcookie("zakaz_key2", "", time() - 1);
setcookie("zakaz_not_my", "", time() - 1);
setcookie("api_token", "", time() - 1);

session_destroy();


printf('<script>delete localStorage.api_token;</script><meta http-equiv="refresh" content="0; url=/">');
?>
