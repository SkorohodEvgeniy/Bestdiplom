<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../../baza.php");
require_once("../../f.php");
require_once("../../f2.php");
require_once("../../f3.php");

$mail = $_POST['email'];

//Password restore step
$user_data;
$check_session = check_session();
$db = db_connect();
//Check exist user by mail
$q = "select * from `clients` where `login`='$mail'";
$logins = baza_do($q);
//        $logins=baza_do_one($q);
//if user was not found show error
//die(var_dump($logins,$mail,$q));
if (empty($logins)) {
    die(getErrorResponse('<span style="color:#ff6363;">Пользователя с таким эмейлом не существует </span>'));
}
// TODO: process the user

//if existen user was found send mail with reset data
if (count($logins) > 0) {
    $rand_code = md5(rand()) . md5(rand()) . md5(time() . rand());
    $q = "update `clients` set `rand_code`='$rand_code' where `login`='$mail'";
    baza_do_only($q);
    $t = time();
    $ip = $_SERVER['REMOTE_ADDR'];
    $q = "insert into `forgot_passwords` (`login`,`time`,`ip`) values('$mail','$t','$ip')";
    baza_do_only($q);
    if (check_mail_pre($logins[0]['login'])) {
        $send_mail = $logins[0]['login'];

        $title = "Восстановление пароля";
        $text = "Здравствуйте!<br>";
        $text .= "Для установки нового пароля пройдите по ссылке:<br>";
        $link .= "$my_site/cabinet/forgot-password/?a=help_me&a2=step3&mail=$mail&code=$rand_code";
        $text .= "<a href='$link'>$link</a>";
        $text .= "<br>Если это были не вы - проигнорируйте данное письмо.";
        mailer($send_mail, $title, $text);
    } else {
        die(getErrorResponse('<span style="color:#ff6363;">Incorrect mail format (' . $logins['login'] . ')</span>'));
    }
}
die(getResponse('<H4 style="color:#b4fa32;">Что бы сменить пароль проверьте почту, и проследуйте по ссылке.</H4>'));

/**
 * Get ajax response.
 *
 * String $data
 * String $status
 */
function getResponse($data, $status = 'ok')
{
    $responseData = [
        'status' => $status,
        'message' => $data
    ];
    return (json_encode($responseData));
}

/**
 * Get ajax error response.
 *
 * String $data
 */
function getErrorResponse($data)
{
    return getResponse($data, 'error');
}
