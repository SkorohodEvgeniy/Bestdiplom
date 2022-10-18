<?php
error_reporting(error_reporting() & ~E_NOTICE);

$ip = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ?
    $_SERVER["HTTP_CF_CONNECTING_IP"] :
    $_SERVER["REMOTE_ADDR"];

//Соединюсь с базой данных
require_once(__DIR__ . "/baza.php");
require_once(__DIR__ . '/f2.php');
// require_once('f3.php');

function db_connect()
{

    global $baza_host;
    global $baza_user;
    global $baza_password;
    global $baza_table;

    $db_connect_result = new mysqli($baza_host, $baza_user, $baza_password, $baza_table);
    $db_connect_result->query("SET NAMES 'utf8'");
    return $db_connect_result;
}


//Закрою соединение с базой данных
function db_disconnect($dase_db)
{
    $dase_db->close();
}

function db_close($dase_db)
{
    $dase_db->close();
}

function obrabotka($obrabotka_dannie)
{
    if ($obrabotka_dannie == null) return false;
    while (($obrabotka_dannie_stroka = $obrabotka_dannie->fetch_assoc()) != false) {
        $obrabotka_dannie_result[] = $obrabotka_dannie_stroka;

    }
    return $obrabotka_dannie_result;
}


function baza_do($query)
{
    global $db;
    $res = $db->query($query);
    if (!$res) {
        echo "<center><b style='color:red'>$query " . $db->error . "</b></center>";
        return null;
    }
    $result = obrabotka($res);
    return $result;

}

function baza_do_one($query)
{
    global $db;
    $res = $db->query($query);
    if (!$res) {
        echo "<center><b style='color:red'>$query " . $db->error . "</b></center>";
        return null;
    }
    $result = obrabotka($res);
    return $result[0];

}

function baza_do_only($query)
{
    global $db;
    if ($db->query($query)) return true;
    else {
        echo "<center><b style='color:red'>$query " . $db->error . "</b></center>";
        return false;
    }

}

function check_session()
{
    global $user_data;
    global $_SESSION;
    global $_COOKIE;
    $r = false;
    $db = db_connect();
    $ip = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ?
        $_SERVER["HTTP_CF_CONNECTING_IP"] :
        $_SERVER["REMOTE_ADDR"];
    //$_SESSION['zakaz_data']="5b843956e103e564c8ed5f028e9747ea";

    $sess_name = $_SESSION['zakaz_data'];
    $sess_type = $_SESSION['zakaz_type'];
    $sess_key = $_SESSION['zakaz_key'];
    $sess_key2 = $_SESSION['zakaz_key2'];
    $sess_id = $_SESSION['zakaz_id'];


    //echo $_SESSION['zakaz_key'];


    if (strlen($_SESSION['zakaz_key']) > 32) {
        $sess_name = $_SESSION['zakaz_data'];
        $sess_type = $_SESSION['zakaz_type'];
        $sess_key = $_SESSION['zakaz_key'];
        $sess_key2 = $_SESSION['zakaz_key2'];
        $sess_id = $_SESSION['zakaz_id'];
    } else {
        //$dddd="zakaz_key";
        //echo $_SESSION[$dddd]."<br>".$_COOKIE[$dddd];
        //die();
        $sess_name = $_COOKIE['zakaz_data'];
        $sess_type = $_COOKIE['zakaz_type'];
        $sess_key = $_COOKIE['zakaz_key'];
        $sess_key2 = $_COOKIE['zakaz_key2'];
        $sess_id = $_COOKIE['zakaz_id'];/**/
    }

    /**/

    if (!is_numeric($sess_id)) $sess_id = (int)$sess_id;
    $sess_type = post($sess_type);

    $query = "Select * From `clients` Where `id`='$sess_id'";
    $tmp3 = $db->query($query);
    $result3 = obrabotka($tmp3);

    $result = $result3[0];
    //print_r($result3);
    //die();


    $user_pass = $result['password'];
    $user_login = $result['login'];


    $check = md5(strtolower($user_login) . md5($user_pass));
    $name = md5(strtolower($user_login) . $check) . md5(strtolower($user_login) . $sess_id);

    $true_key = md5($name . $name . $sess_id . $check . $sess_key2 . $ip) . md5($sess_type . $name . $sess_type . $sess_type . $check . $sess_key2 . $ip);
    //$true_key=md5($name.$name.$result[0]['id'].$check).md5($baza.$name.$baza.$baza.$check);
    //$sess_key=md5($sess_name.$sess_name.$sess_id.$check2).md5($sess_type.$sess_name.$sess_type.$sess_type.$check2);
    //echo "<br>$true_key<br>$sess_key";


    if ($true_key == $sess_key) {
        $r = true;
        $user_data = $result;
    } else $r = false;


    db_disconnect($db);
    $user_data['types'] = $t;
    $tt = $user_data['type'];
    $all_t[1] = "users";
    $all_t[2] = "guests";
    $all_t[3] = "managers";
    $all_t[4] = "admins";
    $all_t[5] = "clienst";
    $user_data['type2'] = $all_t[$tt];
    return $r;
}

function check_session_ref()
{
    global $ref_data;
    global $_SESSION;
    global $_COOKIE;
    $r = false;
    $db = db_connect();
    $ip = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ?
        $_SERVER["HTTP_CF_CONNECTING_IP"] :
        $_SERVER["REMOTE_ADDR"];
    //$_SESSION['zakaz_data']="5b843956e103e564c8ed5f028e9747ea";

    $sess_name = $_SESSION['ref_zakaz_data'];
    $sess_type = $_SESSION['ref_zakaz_type'];
    $sess_key = $_SESSION['ref_zakaz_key'];
    $sess_key2 = $_SESSION['ref_zakaz_key2'];
    $sess_id = $_SESSION['ref_zakaz_id'];


    //echo $_SESSION['zakaz_key'];


    if (strlen($_SESSION['ref_zakaz_key']) > 32) {
        $sess_name = $_SESSION['ref_zakaz_data'];
        $sess_type = $_SESSION['ref_zakaz_type'];
        $sess_key = $_SESSION['ref_zakaz_key'];
        $sess_key2 = $_SESSION['ref_zakaz_key2'];
        $sess_id = $_SESSION['ref_zakaz_id'];
    } else {
        //$dddd="zakaz_key";
        //echo $_SESSION[$dddd]."<br>".$_COOKIE[$dddd];
        //die();
        $sess_name = $_COOKIE['ref_zakaz_data'];
        $sess_type = $_COOKIE['ref_zakaz_type'];
        $sess_key = $_COOKIE['ref_zakaz_key'];
        $sess_key2 = $_COOKIE['ref_zakaz_key2'];
        $sess_id = $_COOKIE['ref_zakaz_id'];/**/
    }

    /**/

    if (!is_numeric($sess_id)) $sess_id = (int)$sess_id;
    $sess_type = post($sess_type);

    $query = "Select * From `ref_users` Where `id`='$sess_id'";
    $tmp3 = $db->query($query);
    $result3 = obrabotka($tmp3);

    $result = $result3[0];
    //print_r($result3);
    //die();


    $user_pass = $result['password'];
    $user_login = $result['login'];


    $check = md5(strtolower($user_login) . md5($user_pass));
    $name = md5(strtolower($user_login) . $check) . md5(strtolower($user_login) . $sess_id);

    $true_key = md5($name . $name . $sess_id . $check . $sess_key2 . $ip) . md5($sess_type . $name . $sess_type . $sess_type . $check . $sess_key2 . $ip);
    //$true_key=md5($name.$name.$result[0]['id'].$check).md5($baza.$name.$baza.$baza.$check);
    //$sess_key=md5($sess_name.$sess_name.$sess_id.$check2).md5($sess_type.$sess_name.$sess_type.$sess_type.$check2);
    //echo "<br>$true_key<br>$sess_key";


    if ($true_key == $sess_key) {
        $r = true;
        $ref_data = $result;
    } else $r = false;

    db_disconnect($db);
    $ref_data['types'] = $t;
    $tt = $ref_data['type'];
    $all_t[1] = "users";
    $all_t[2] = "guests";
    $all_t[3] = "managers";
    $all_t[4] = "admins";
    $all_t[5] = "clienst";
    $all_t[6] = "ref";
    $ref_data['type2'] = $all_t[$tt];
    return $r;
}

function post($data)
{
    if (empty($data)) {
        return $data;
    }
    while (true) {
        if (is_array($data)) $data = $data[0];
        else break;
    }
    $result = str_replace('\'', "", $data);
    $len = strlen($data) - 1;
    if ($len < 0) $len = 0;
    if ($result[$len] == '\\') $result[$len] = '';
    //$result=str_replace('"',"",$result);
    $result = show_good($result);
    $result = trim($result);
    $result = htmlspecialchars($result, ENT_QUOTES, 'ISO-8859-1');

    return $result;
}

function show_good($text)
{
    $symbol = htmlspecialchars('&#774;', ENT_QUOTES, 'ISO-8859-1');
    $text = str_replace($symbol, "Ї", $text);
    $symbol = htmlspecialchars('&#776;', ENT_QUOTES, 'ISO-8859-1');
    $text = str_replace($symbol, "І", $text);
    $symbol = htmlspecialchars('&#8722;', ENT_QUOTES, 'ISO-8859-1');
    $text = str_replace($symbol, "-", $text);
    $symbol = htmlspecialchars('&#239;', ENT_QUOTES, 'ISO-8859-1');
    $text = str_replace($symbol, "Ї", $text);
    $symbol = '&#922;';
    $text = str_replace($symbol, "К", $text);
    $symbol = '&#8722;';
    $text = str_replace($symbol, "-", $text);
    $symbol = '&#774;';
    $text = str_replace($symbol, "Ї", $text);
    $symbol = '&#776;';
    $text = str_replace($symbol, "І", $text);
    $symbol = '&#239;';
    $text = str_replace($symbol, "Ї", $text);

    $symbol = '&#1104;';
    $text = str_replace($symbol, "ё", $text);
    return $text;
}


function check_mail_pre_na5($mail)
{
    if (filter_var($mail, FILTER_VALIDATE_EMAIL) == false) return false;
    else return true;
    $white_arr = array(
        'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
        'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z',
        'x', 'c', 'v', 'b', 'n', 'm',
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '.', '_', '-'
    );
    $mail_ = explode("@", $mail);
    if (count($mail_) != 2) return false;
    else {
        $mail_[0] = strtolower($mail_[0]);
        $mail_[1] = strtolower($mail_[1]);
        $res = true;
        $check = $mail_[0];
        for ($i = 0; $i < strlen($check); $i++) if (!in_array($check[$i], $white_arr)) return false;
        $check = $mail_[1];
        for ($i = 0; $i < strlen($check); $i++) if (!in_array($check[$i], $white_arr)) return false;
        if (strlen($check) < 3) return false;

        $check2_ = explode(".", $check);
        if (strlen($check2_[0]) < 1) return false;
        $ind = count($check2_) - 1;
        if (count($check2_) == 1 || count($check2_) == 0) return false;
        if (strlen($check2_[$ind]) < 1) return false;
    }
    return $res;
    return preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+(?:[-_.]?[a-z0-9]+)+(?:[-_.]?[a-z0-9]+)+(?:[-_.]?[a-z0-9]+))?@[a-z0-9]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $mail);
}


function notise_all_managers($theme)
{
    global $db;
    global $my_site;
    $text = "Прилетел заказ '$theme' с сайта $my_site, проверьте админку https://kabinetavtora.com/";
    $q = "select * from `managers` where `active`='1'";
    $managers = baza_do($q);
    for ($i = 0; $i < count($managers); $i++) {
        if (check_mail_pre_na5($managers[$i]['mail'])) $mails[] = $managers[$i]['mail'];
    }

    global $mail_from;
    $headers .= "From: $mail_from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $title = "Заказ с формы";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    $title = enc2($title);
    $text = enc2($text);
    for ($i = 0; $i < count($mails); $i++) {
        mailer($mails[$i], $title, $text, $headers);
    }
    mailer("zakaz@na5ku.com.ua", $title, $text, $headers);
}

function enc2($str)
{
    $str = trim($str);
    $tmp = strtolower(mb_detect_encoding($str, 'UTF-8,CP1251'));
    if ($tmp != "utf-8") {

        $str = iconv($tmp, 'UTF-8', $str);
    }
    $str = str_replace("\n", "<br>", $str);
    return $str;
}

function mailer($to, $subject, $message, $headers = "")
{
    global $mail_from;
    // $headers .= "From: $mail_from\r\n";
    // $headers .= "MIME-Version: 1.0\r\n";
    // $headers .= "Content-type: text/plain; charset=windows-1251\r\n";


    $message .= "<br><br>Пожалуйста, не отвечайте на это сообщение. Ответы на этот электронное письмо попадают в 
        почтовый ящик, который не проверяют. Все вопросы, связанные с вашим заказом оставляйте на странице заказа в 
        разделе комментарии. Также вы можете написать своему менеджеру с помощью раздела «Сообщения» на сайте.";


    $subject = enc2($subject);
    $message = enc2($message);
    $headers = array
    (
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset="UTF-8";',
        'Content-Transfer-Encoding: 7bit',
        'Date: ' . date('r', $_SERVER['REQUEST_TIME']),
        'Message-ID: <' . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>',
        "From: $mail_from",
        // 'Reply-To: ' . $to,
        // 'Return-Path: ' . $set['site_email'],
        'X-Mailer: PHP v' . phpversion(),
        'X-Originating-IP: ' . $_SERVER['SERVER_ADDR'],
    );

    mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $message, implode("\n", $headers));

}


function get_ref_money()
{
    global $user_data;
    if ($user_data['valuta'] == 1) $valuta = "UAH";
    else if ($user_data['valuta'] == 3) $valuta = "USD";
    else $valuta = "RUB";

    $q = "select sum(cena_skidka*ref_proc/100) as 's' from `zakaz` where `pay_valuta`='$user_data[valuta]' and `ref_id`='$user_data[id]' and (`pay_predoplata`='1' or `pay_client`='1')";
    $sum = baza_do_one($q);
    $sum['s']++;
    $sum['s']--;

    $q = "select sum(count_done) as 's' from `ref_money` where `ref_id`='$user_data[id]'";
    $sum_done = baza_do_one($q);
    // print_r($q);
    $sum_done['s']++;
    $sum_done['s']--;
    $can = $sum['s'] - $sum_done['s'];
    if ($can < 0) $can = 0;
    $can++;
    $can--;

    $result['money'] = $can;
    $result['valuta_id'] = $user_data['valuta'];
    $result['valuta'] = $valuta;
    return $result;
}

?>
