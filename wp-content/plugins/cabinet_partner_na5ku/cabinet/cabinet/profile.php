<?php
session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//require_once __DIR__ . "../install/function.php";
//require_once('../f.php');

$p = isset($_GET['p']) ? post($_GET["p"]) : '';
$a = isset($_GET['a']) ? post($_GET["a"]) : '';
$a2 = isset($_GET['a2']) ? post($_GET["a2"]) : '';
$a3 = isset($_GET['a3']) ? post($_GET["a3"]) : '';
$a4 = isset($_GET['a4']) ? post($_GET["a4"]) : '';
$a5 = isset($_GET['a5']) ? post($_GET["a5"]) : '';

global $user_data;


$modal_action = isset($_POST['action']) ? convert_from_utf($_POST['action']) : "";


if (isset($_GET["id"])) {
    $id = post($_GET["id"]);
} else {
    $id = isset($_POST["id"]) ? post($_POST["id"]) : "";
}

if (isset($_GET["key"])) {
    $key = post($_GET["key"]);
} else {
    $key = isset($_POST["key"]) ? post($_POST["key"]) : "";
}

if (isset($_GET["a2"])) {
    $a2 = post($_GET["a2"]);
} else {
    $a2 = isset ($_POST["a2"]) ? post(convert_from_utf($_POST["a2"])) : "";
}


//if (strlen($_SESSION['zakaz_au_key']) < 32) {
//    $_SESSION['zakaz_au_data'] = post($_COOKIE['zakaz_au_data']);
//    $_SESSION['zakaz_au_type'] = post($_COOKIE['zakaz_au_type']);
//    $_SESSION['zakaz_au_id'] = post($_COOKIE['zakaz_au_id']);
//    $_SESSION['zakaz_au_u'] = post($_COOKIE['zakaz_au_u']);
//    $_SESSION['zakaz_au_key'] = post($_COOKIE['zakaz_au_key']);
//}
//$check_session=check_session();
//
//if(!$check_session)die('<meta http-equiv="refresh" content="0; url=/exit">');


//$db=db_connect();
if ($a2 == "save") {

    $new_mail = $_POST["new_mail"];

//    $user_update = $userApi->updateProfile([
//        'mail'=>$new_mail
//    ]);


    if (!check_mail_pre($user_data['mail'])) {
        if (!check_mail_pre($new_mail)) {
            die("<b style='color:red'>Введите почту правильно</b>");
        } else {

            $q = "select * from `clients` where `login`='$new_mail'";
            $tmp = baza_do($q);
            if (count($tmp) != 0) die("<b style='color:red'>Почта уже есть в нашей базе</b>");
            else {
                $q = "update `clients` set `login`='$new_mail',`mail`='$new_mail' where `id`='$user_data[id]'";
                if (baza_do_only($q)) {
                    echo "<b style='color:green'>Почта привязана успешно</b><br>";
                    $done = true;
                    $user_data['mail'] = $new_mail;
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $baza = 'clients';
                    $vrem = time() + (24 * 60 * 60 + 1) * 1000;
                    $check = md5(strtolower($user_data['mail']) . md5(trim($user_data['password'])));
                    $check2 = $check;
                    $name = md5(strtolower($user_data['mail']) . $check) . md5(strtolower($user_data['mail']) . $user_data['id']);
                    $result[0]['id'] = $user_data['id'];

                    $_SESSION['zakaz_data'] = $name;
                    $_SESSION['zakaz_type'] = $baza;
                    $_SESSION['zakaz_id'] = $user_data['id'];
                    $_SESSION['zakaz_u'] = $user_data['mail'];
                    $key2 = md5($name . $name . $user_data['id'] . $check2 . $ip) . md5($baza . $name . $baza . $baza . $check2 . $ip);
                    $_SESSION['zakaz_key'] = md5($name . $name . $result[0]['id'] . $check2 . $key2 . $ip) . md5($baza . $name . $baza . $baza . $check2 . $key2 . $ip);
                    $_SESSION['zakaz_key2'] = $key2;
                    $_SESSION["zakaz_tmp"] = "";
                    $query = "insert into `log_enter`(`date`,`success`,`ip`,`login`,`password`,`type_login`,`login_id`) values('$now_t','1','$ip','$log_user','','$log_type','" . $result[0]['id'] . "')";
                    baza_do_only($query);
                    $query = "update $baza set `last_enter`='$now_t' where `id`='" . $result[0]['id'] . "'";
                    baza_do_only($query);
                }
            }
        }
    }


    $name = post($_POST["name"]);
    $phone = post($_POST["phone"]);
    $new_pass = $_POST["new_pass"];
    $new_pass_conf = $_POST["new_pass_conf"];
    $news = isset($_POST["news"]) ? post($_POST["news"]) : '';
    if ($news != 123) $news = 0; else $news = 1;
    if (strlen($name) < 3) die("<b style='color:red'>Вы ввели очень короткое имя</b>");
    if(!check_phone($phone)){
        die("<b style='color:red'>Введите телефон правильно</b>");
    }

    $name = iconv('UTF-8', 'WINDOWS-1251', $name);
    $name_search = strtolower($name);
//    $name_search = enc($name_search);
    $name_search = $name_search;
    $name = base64_encode($name);
    $done = false;


    if ($user_data['name'] != $name) {
        $user_update_name = $userApi->updateName([
            'name' => $name,
            'name_search' => $name_search,
            'id' => $user_data['id']
        ]);
        if ($user_update_name['code'] == 201) {
            $done = true;
        }
    }
    if ($user_data['phone'] != $phone) {
        $user_update_phone = $userApi->updatePhone([
            'phone' => $phone,
            'id' => $user_data['id']
        ]);
        if ($user_update_phone['code'] == 201) {
            $done = true;
        }
    }
    if ($user_data['news'] != $news) {
        $user_update_news = $userApi->updateNews([
            'news' => $news,
            'id' => $user_data['id']
        ]);
        if ($user_update_news['code'] == 201) {
            $done = true;
        }

    }

    if (strlen($new_pass) < 4) echo '';
    else {


        $new_pass = md5(md5($new_pass));
        $new_pass_conf = md5(md5($new_pass_conf));
        if ($new_pass != $new_pass_conf) die("<b style='color:red'>Пароли не совпали</b>");
        if ($user_data['password'] != $new_pass) {

            $user_update_password = $userApi->updatePassword([
                'password' => $new_pass,
                'id' => $user_data['id']
            ]);
            if ($user_update_password['code'] == 201) {
                $done = true;
            }

        }
    }

    if ($done) {
        echo laz_meta("", 2);
        // echo '<meta http-equiv="refresh" content="2; url=index.php">';
        die("<b style='color:green'>Данные изменены успешно</b>");
    } else {
        die("<b style='color:green'>Ничего нового не обнаружено</b>");
    }
} else {

    $user_data['name'] = base64_decode($user_data['name']);
    $j_arr['name'] = iconv('WINDOWS-1251', 'UTF-8', $user_data['name']);
    if (check_mail_pre($user_data['mail'])) $j_arr['mail'] = $user_data['mail'];
    else $j_arr['mail'] = '';
    $j_arr['phone'] = $user_data['phone'];
    $j_arr['news'] = $user_data['news'];
    echo json_encode($j_arr);
}


?>
