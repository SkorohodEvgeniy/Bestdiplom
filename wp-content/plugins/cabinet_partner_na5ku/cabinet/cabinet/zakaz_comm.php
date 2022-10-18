<?php
//header('Content-Type: text/html; charset=windows-1251');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
//die('here');
//require_once('../install/function.php');
//require_once('../../api_wrappers/CommentClient.php');
// TODO: upload the file
global $user_data;
//var_dump('user_data', $user_data);
$commentApi = new CommentClient();

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


//if(strlen($_SESSION['zakaz_key'])<32){
//	$_SESSION['zakaz_data']=post($_COOKIE['zakaz_data']);
//	$_SESSION['zakaz_type']=post($_COOKIE['zakaz_type']);
//	$_SESSION['zakaz_id']=post($_COOKIE['zakaz_id']);
//	$_SESSION['zakaz_u']=post($_COOKIE['zakaz_u']);
//	$_SESSION['zakaz_key']=post($_COOKIE['zakaz_key']);
//}
//$check_session=check_session();


if ($a == "get_button") {
    if ($a2 == "edit_main") die("Сохранить изменения");
    else if ($a2 == "edit_manager") die("Сменить");
    else if ($a2 == "contact_client") die("Отправить сообщение");
    else if ($a2 == "contact_author") die("Отправить сообщение");
    else if ($a2 == "edit_type") die("Изменить");
    else if ($a2 == "edit_dostup") die("Сохранить");
    else if ($a2 == "edit_pre") die("Подтвердить");
    else if ($a2 == "edit_client") die("Подтвердить");
    else if ($a2 == "edit_author") die("Подтвердить");
    else if ($a2 == "edit_srok") die("Изменить");
    else if ($a2 == "finish") die("Завершить");
    else if ($a2 == "cancel") die("Отменить заказ");
    else if ($a2 == "open") die("Открыть");
    else if ($a2 == "agree") die("Принять");
    else if ($a2 == "disagree") die("Отказать");
    else if ($a2 == "edit") die("Отправить на доработку");
    else if ($a2 == "write_new_comm") die("Добавить");
    else if ($a2 == "write_new_comm_client") die("Добавить");
    else die("Отправить");
}


//if(!$check_session)die('<meta http-equiv="refresh" content="0; url=/exit">');
//$db=db_connect();
//if ($user_data['type'] == "5") {
//    $q = "select * from `zakaz` where `id`='$id'";
//    $zakaz = baza_do_one($q);
//    if ($zakaz['client_id'] != $user_data['id'])
//        die('<meta http-equiv="refresh" content="0; url=/cabinet/">');
//
//} else die('<meta http-equiv="refresh" content="0; url=/exit">');


if ($modal_action == "Добавить комментарий клиенту" || $act3 == "Добавить комментарий клиенту") {


//    $query = "select * from `zakaz` where `id`='$id'";
//    $zakaz = baza_do_one($query);

    $zakaz = $orderApi->getId([
        'id' => $id
    ]);
    $zakaz = $zakaz['data'];
    $good = true;
    $comment = post($_POST['text']);


//    $file_names = upload_file('files');
    $file_names = $_FILES;


//    for ($i = 0; $i < count($file_names); $i++) {
//        $this_link = $file_names[$i];
//        $n = $i + 1;
//        $comment .= "<br><a href='$this_link' target='_blank'><span style='font-size: 25px;'><img src='/images/download.png' width='25' border='0'> Файл $n</span></a>";
//    }

    if (strlen($comment) < 2) {
        $_SESSION["tmp_sms"] = "<center><b style='color:red'>Слишком короткое сообщение</b><br></center>";
        $_SESSION["comm_short"] = true;
    } else {
        $this_u_type = $user_data['type'];
        $this_u_id = $user_data['id'];
        $this_u_lo = $user_data['login'];
        $now_t = time();

        $filesCount = count($file_names['files']['tmp_name']);

        $files = [];
        if ($filesCount > 0) {
            for ($i = 0; $i < $filesCount; $i++) {
                if (!is_uploaded_file($_FILES['files']['tmp_name'][$i])) {
                    $filesCount--;
                    continue;
                }
                $files['file_' . $i] = [
                    'tmp_name' => $file_names['files']['tmp_name'][$i],
                    'name' => $file_names['files']['name'][$i]
                ];
            }
        }
        $commentInsert = $commentApi->set([
            'this_u_type' => $this_u_type,
            'this_u_id' => $this_u_id,
            'this_u_lo' => $this_u_lo,
            'now_t' => $now_t,
            'comment' => iconv('UTF-8', 'WINDOWS-1251//IGNORE', $comment),
            'id' => $id,
            'files_count' => $filesCount
        ], $files);

//        echo "<pre>";
//        die(var_dump($commentInsert));
//        echo "</pre>";
//        $query = "insert into `comment_client`(`from_type`,`from_id`,`comment`,`time`,`zakaz_id`,`login`,`read_by_client`) values('$this_u_type','$this_u_id','$comment','$now_t','$id','$this_u_lo','1')";
//        if (baza_do_only($query)) {
        if ($commentInsert['code'] == 200) {

            $updateZakaz = $orderApi->updateStatus([
                'id' => $id
            ]);

//            $q = "update `zakaz` set `date_last_upd`='" . time() . "',`is_archive`='0' where `id`='$id'";
//            baza_do_only($q);
            $text = "<a href='index.php?a=open_zakaz&id=$zakaz[id]'>$zakaz[id_for_client]</a>";


            reg_event(30, 1, 4, $text);//admin
            reg_event(30, $zakaz['manager_id'], 3, $text);//manager
            $_SESSION["tmp_sms"] = "<center><b style='color:green'>Комментарий добавлен</b><br></center>";
            $_SESSION["comm_added"] = true;
        } else $_SESSION["tmp_sms"] = "<center><b style='color:red'>Проблема с базой</b><br></center>";
    }

    //echo '<a href="index.php?a=open_zakaz&id='.$id.'" style="color:black"><center>Перенаправление на страницу заказа</center></a>.';
    echo '<meta http-equiv="refresh" content="0; url=/cabinet/open/' . $zakaz['id_for_client'] . '?a2=show_comments">';
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//db_disconnect($db);


?>
