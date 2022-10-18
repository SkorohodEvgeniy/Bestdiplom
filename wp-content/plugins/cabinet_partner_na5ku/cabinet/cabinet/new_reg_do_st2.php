<?php

session_start();
header('Content-Type: text/html; charset=windows-1251');
error_reporting(error_reporting() & ~E_NOTICE);

require_once('f.php');
$db = db_connect();

$name_search = post($_POST["full_name_st2"]);
$name = enc(post($_POST["full_name_st2"]));
$phone = post($_POST["phone_st2"]);
$ref_id = post($_POST["ref_id"]);

if ($news != 123) $news = 0; else $news = 1;
if (strlen($name) < 3) die(json_encode(['status' => 'error', 'message' => '<b style=\'color:red\'>Вы ввели очень короткое имя</b>']));
if (!is_numeric($phone)) die(json_encode(['status' => 'error', 'message' => '<b style=\'color:red\'>Введите телефон правильно</b>']));


$q = "update `clients` set `name`='$name',`phone`='$phone', `name_search`='$name_search' where `ref_id`='$ref_id'";
baza_do_only($q);
var_dump($q);
?>
