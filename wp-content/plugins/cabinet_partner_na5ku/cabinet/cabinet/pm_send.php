<?php

session_start();
header('Content-Type: text/html; charset=windows-1251');
error_reporting(error_reporting() & ~E_NOTICE);
require_once('../f.php');
$p = post($_GET["p"]);
$a = post($_GET["a"]);
$a3 = post($_GET["a3"]);
$a4 = post($_GET["a4"]);
$a5 = post($_GET["a5"]);
$act3 = post($_POST["action3"]);
$modal_action = convert_from_utf($_POST['action']);


if (isset($_GET["id"])) $id = post($_GET["id"]);
else $id = post($_POST["id"]);

if (isset($_GET["key"])) $key = post($_GET["key"]);
else $key = post($_POST["key"]);

if (isset($_GET["a2"])) $a2 = post($_GET["a2"]);
else $a2 = post(convert_from_utf($_POST["a2"]));


$user_data;
if (strlen($_SESSION['zakaz_key']) < 32) {
    $_SESSION['zakaz_data'] = post($_COOKIE['zakaz_data']);
    $_SESSION['zakaz_type'] = post($_COOKIE['zakaz_type']);
    $_SESSION['zakaz_id'] = post($_COOKIE['zakaz_id']);
    $_SESSION['zakaz_u'] = post($_COOKIE['zakaz_u']);
    $_SESSION['zakaz_key'] = post($_COOKIE['zakaz_key']);
}
$check_session = check_session();


if ($a == "get_button") {
    if ($a2 == "edit_main") die("��������� ���������");
    else if ($a2 == "edit_manager") die("�������");
    else if ($a2 == "contact_client") die("��������� ���������");
    else if ($a2 == "contact_author") die("��������� ���������");
    else if ($a2 == "edit_type") die("��������");
    else if ($a2 == "edit_dostup") die("���������");
    else if ($a2 == "edit_pre") die("�����������");
    else if ($a2 == "edit_client") die("�����������");
    else if ($a2 == "edit_author") die("�����������");
    else if ($a2 == "edit_srok") die("��������");
    else if ($a2 == "finish") die("���������");
    else if ($a2 == "cancel") die("�������� �����");
    else if ($a2 == "open") die("�������");
    else if ($a2 == "agree") die("�������");
    else if ($a2 == "disagree") die("��������");
    else if ($a2 == "edit") die("��������� �� ���������");
    else if ($a2 == "write_new_comm") die("��������");
    else if ($a2 == "write_new_comm_client") die("��������");
    else die("���������");
}


if (!$check_session) die('<meta http-equiv="refresh" content="0; url=/exit">');
$db = db_connect();

if (!($user_data['type'] == "5")) die('<meta http-equiv="refresh" content="0; url=/exit">');
if (!($user_data['manager_id'])) die('<meta http-equiv="refresh" content="0; url=/cabinet">');


if ($act3 == "��������� ���������") {

    $comment = post($_POST['text']);
    $file_names = upload_file('files');
    for ($i = 0; $i < count($file_names); $i++) {
        $this_link = $file_names[$i];
        $n = $i + 1;
        $comment .= "<br><a href='$this_link' target='_blank'><span style='font-size: 25px;'><img src='/images/download.png' width='25' border='0'> ���� $n</span></a>";
    }
    if (strlen($comment) < 2) {
        $_SESSION["pm_short"] = true;
    } else {
        $comment = base64_encode($comment);
        $theme = "themes tested";
        $theme = base64_encode($theme);
        $now_t = time();


        $ttt = time();
        $q = "insert into `local_sms`(`to`,`type_his`,`from`,`type_my`,`text`,`theme`,`time`) values('$user_data[manager_id]','3','$user_data[id]','5','$comment','$theme','$now_t')";

        // echo $q;


        if (baza_do_only($q)) {
            $text = "������ ����!<br> ������ $user_data[login] ������� ��� ������ ��������� . ����� ���������: " . base64_decode($comment) . "<br>����� �������� - ������� �� ����.";
//			send_mail_to_manager($text,"��� ������ ��������� �� �������",1);
            $_SESSION["pm_added"] = true;
        }

    }


}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '<meta http-equiv="refresh" content="0; url=/cabinet/pm/">';


db_disconnect($db);



