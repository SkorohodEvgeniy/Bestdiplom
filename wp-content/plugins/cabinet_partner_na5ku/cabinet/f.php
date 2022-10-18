<?php
//error_reporting(0);

$ip = $_SERVER['REMOTE_ADDR'];

//Соединюсь с базой данных
require_once(__DIR__ . "/baza.php");
require_once(__DIR__ . '/f2.php');
require_once(__DIR__ . '/f3.php');


function get_ogr($result)
{
    global $users_lvl_ogranichenie;
    $ogr[1] = $users_lvl_ogranichenie[$result['lvl']];
    $ogr[2] = $result['ogr_max'];
    $ogranichenie = max($ogr);
    return $ogranichenie;
}

function only_eng($check)
{
    $result = true;
    $check = strtolower($check);
    $white_arr = array(
        'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
        'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z',
        'x', 'c', 'v', 'b', 'n', 'm',
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '.', '_', '@', '-'
    );
    for ($i = 0; $i < strlen($check); $i++) {
        if (!in_array($check[$i], $white_arr)) {
            $result = false;
            break;
        }
    }
    return $result;


}

function send_mail_to_author($text, $title = "Заказ", $id, $type, $t = "all", $sp = "all")
{
    global $db;
    global $mail_from;
    $headers .= "From: $mail_from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    if ($id == "all") {
        if ($t != 'all') {
            $query = "select min_lvl from `zakaz_types` where `id`='$t'";
            $t_min_lvl = baza_do_one($query);
            $add .= "and `lvl`>'" . ($t_min_lvl['min_lvl'] - 1) . "' ";
        }
        if ($sp != 'all') {
            $add .= "and special like '%,$sp,%' ";
        }
    } else $add = "and `id`='$id'";
    if ($type == 2) $type = "guests"; else $type = "users";
    $query = "select mail,login,name from `$type` where `active`='1' $add";

    $result = baza_do($query);

    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    $title = enc($title);
    $text = enc($text);
    for ($i = 0; $i < count($result); $i++) {
        if (check_mail_pre($result[$i]["mail"]))
            mailer($result[$i]["mail"], $title, $text, $headers);
    }


}

function send_sms_to_author($text, $id, $type)
{
    global $db;
    $add = "and `id`='$id'";
    if ($type == 2) $type = "guests"; else $type = "users";
    $query = "select mail,login,name,phone from `$type` where `active`='1' $add";

    $result = baza_do($query);

    for ($i = 0; $i < count($result); $i++) {
        if (check_mail_pre($result[$i]["mail"]))
            $phone = $result[$i]["phone"];
    }


    if (is_numeric($phone))
        sms_send($text, $phone);

}

function send_sms_to_client($text, $id)
{
    global $db;
    $query = "select * from `zakaz` where `id`='$id'";
    $zakaz = baza_do_one($query);
    if ($zakaz['client_id'] > 0) {
        $query = "Select * From `clients` where `id`='$zakaz[client_id]'";
        $client_name = baza_do_one($query);
        $phone = $client_name['phone'];
    } else {
        $phone = $zakaz['client_phone'];
    }
    $text .= "\n\nНомер заказа: " . $zakaz['id_for_client'];
    if (is_numeric($phone))
        sms_send($text, $phone);
}

function send_mail_to_client($text, $id)
{
    global $db;
    global $my_site;

    $query = "select * from `zakaz` where `id`='$id'";
    $zakaz = baza_do_one($query);
    if ($zakaz['client_id'] > 0) {
        $query = "Select * From `clients` where `id`='$zakaz[client_id]'";
        $client_name = baza_do_one($query);
        $mails = $client_name['mail'];
    } else {
        $mails = $zakaz['client_mail'];
    }
    global $mail_from;
    $headers .= "From: $mail_from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $text .= "<br><br>Номер заказа: " . $zakaz['id_for_client'];

    $title = "[$zakaz[id_for_client]] Оповещение";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    $title = enc($title);
    $text = enc($text);
    if (check_mail_pre($mails))
        mailer($mails, $title, $text, $headers);
}

function send_mail_to_client_id($text, $id, $title = "Успешная регистрация")
{
    global $db;
    global $my_site;
    global $mail_from;
    //$query="select * from `zakaz` where `id`='$id'";
    //$zakaz=baza_do_one($query);
    if (true) {
        $query = "Select * From `clients` where `id`='$id'";
        $client_name = baza_do_one($query);
        $mails = $client_name['mail'];
    } else {
        $mails = $zakaz['client_mail'];
    }
    global $mail_from;
    $headers .= "From: $mail_from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    $title = enc($title);
    $text = enc($text);
    if (check_mail_pre($mails))
        mailer($mails, $title, $text, $headers);
}


function send_sms_to_client2($text, $phone)
{

    if (is_numeric($phone))
        sms_send($text, $phone);
}

function send_mail_to_client2($text, $title, $mails)
{
    global $mail_from;
    $headers .= "From: $mail_from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    $title = enc($title);
    $text = enc($text);
    if (check_mail_pre($mails))
        mailer($mails, $title, $text, $headers);
}


function send_mail_to_manager($text, $title = "Заказ", $id)
{
    global $db;
    global $mail_from;
    if ($id != "all") $add = "and `id`='$id'";
    $title = enc($title);
    $text = enc($text);
    $headers .= "From: $mail_from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $query = "select mail,login,name from `managers` where `active`='1' $add";
    $result = baza_do($query);
    for ($i = 0; $i < count($result); $i++) {
        if (check_mail_pre($result[$i]["mail"]))
            mailer($result[$i]["mail"], $title, $text, $headers);
    }
}


function send_sms_to_manager($text, $id)
{
    global $db;
    if ($id != "all") $add = "and `id`='$id'";

    $query = "select mail,login,name,phone from `managers` where `active`='1' $add";
    $result = baza_do_one($query);


    $phone = $result['phone'];

    if (is_numeric($phone))
        sms_send($text, $phone);

}

function sms_send($text, $num)
{
    global $sms_send_user;
    // Подключаемся к серверу
    $client = new SoapClient ('http://turbosms.in.ua/api/wsdl.html');

    //echo "<br>СМС $num:<br>";


    // Данные авторизации
    $auth = array(
        'login' => $sms_send_user['login'],
        'password' => $sms_send_user['password']
    );
    // Авторизируемся на сервере
    $result = $client->Auth($auth);

    // Результат авторизации
    //echo iconv('UTF-8','WINDOWS-1251', $result->AuthResult) . '<br>
    //';

    // Получаем количество доступных кредитов
    $result = $client->GetCreditBalance();
    //echo iconv('UTF-8', 'WINDOWS-1251',$result->GetCreditBalanceResult) . '<br>
    //';

    // Текст сообщения ОБЯЗАТЕЛЬНО отправлять в кодировке UTF-8
    $text = iconv('windows-1251', 'utf-8', $text);

    // Данные для отправки
    $sms = array(
        'sender' => $sms_send_user['sender'],
        'destination' => '+' . "$num",
        'text' => $text
    );

    // Отправляем сообщение на один номер.
    // Подпись отправителя может содержать английские буквы и цифры. Максимальная длина - 11 символов.
    // Номер указывается в полном формате, включая плюс и код страны
    $result = $client->SendSMS($sms);
    //echo  iconv ('windows-1251', 'utf-8',$result->SendSMSResult->ResultArray[0]);
    //echo  iconv ('windows-1251', 'utf-8',$result->SendSMSResult->ResultArray[1]);
    //echo "<br>";

}

function get_kurs()
{
    $f = file('https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11');
    $result = json_decode($f[0], true);
    $kurs = $result[0]['buy'];
    if (!is_numeric($kurs)) $kurs = 0.39;
    return $kurs;
}


function set_modal($link_name = "Ajax", $title = "Заголовок", $width = 500, $height = 200, $type = 1, $link = "index.php", $link_title = "", $link_color = "")
{
    $result = "
		<script type='text/javascript' src='ajax/jquery-1.7.2.js'></script>
		<script type='text/javascript' src='ajax/uwnd.js'></script>		
		<link href='ajax/ajax.css' rel='StyleSheet' />";
    if ($type == 1) $result .= "	
		<a href='javascript://' onclick=\"new _uWnd('ajax','$title','$width','$height',{shadow:1, autosize:0, modal: 1, close:1, header:1, nomove: 0, fixed:1, resize: 0, max:1, popup: 1},{xml:false,url:'$link'})\" title='$link_title' style='color: $link_color'>$link_name</a>
		";
    else $result .= "	
		<a href='javascript://' onclick=\"new _uWnd('ajax','$title','$width','$height',{shadow:1, autosize:0, modal: 1, close:1, header:1, nomove: 0, fixed:1, resize: 0, max:1, popup: 1},'$link')\" title='$link_title' style='color: $link_color'>$link_name</a>
		";
    return $result;
}

function check_mail_pre($mail)
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


function convert_from_utf($text)
{
    return iconv('UTF-8', 'WINDOWS-1251', $text);
}


function show_pages($result_2)
{
    $vsego = $result_2;
    global $n_1;
    global $a;
    global $a2;
    $page = (int)$_GET['page'];
    $page--;
    if ($page < 0) $page = 0;
    $n_1 = $page * 100;
    if ($n_1 > ($vsego)) {
        $n_1 = (int)$vsego / 100;
        $n_1 = $n_1 * 100;
    }
    echo "<div align='center'>";

    if ($vsego > 100) {
        echo "Страницы: ";
        if ($vsego > 1000) $vsego = 1000;
        if ($vsego > 1000) {

        } else {
            if ($vsego % 100 == 0) $max = $vsego / 100;
            else $max = (int)$vsego / 100 + 1;
            for ($i == 1; $i <= $max; $i++) {
                if ($page == ($i - 1)) echo "<a href='index.php?a=$a&a2=$a2&page=$i' style='color:black'><b>$i</b></a> ";
                else echo "<a href='index.php?a=$a&a2=$a2&page=$i'  style='color:black'>$i</a> ";
            }
        }
    }
    echo "</div>";

}


function reg_event($type, $to_id, $to_t, $text, $text2 = "")
{
    global $db;
    $all_t = array();
    $all_t[0] = "";
    $all_t[1] = "У вас новое сообщение от $text";
    $all_t[2] = "В проекте $text автор добавил файл и завершил его";
    $all_t[3] = "$text2 сделал ставку в проекте $text";
    $all_t[4] = "$text2 подал заявку в проект $text";
    $all_t[5] = "Автор оставил комментарий в проекте $text";
    $all_t[6] = "Получена предоплата по проекту $text";
    $all_t[7] = "Получена окончательная оплата по проекту $text";
    $all_t[8] = "Ваша заявка по проекту $text принята, приступайте";
    $all_t[9] = "Ваша заявка по проекту $text отклонена";
    $all_t[10] = "Проект $text отменен";
    $all_t[11] = "Получены правки по проекту $text";
    $all_t[12] = "Проект $text завершен";
    $all_t[13] = "Оплата по проекту $text выполнена - $text2";
    $all_t[14] = "Для вас создан персональный проект";
    $all_t[15] = "Получен новый заказ, обработайте его";
    $all_t[16] = "В проекте $text автор $text2 добавил антиплагиат";
    $all_t[17] = "В проекте $text автор $text2 добавил план";
    $all_t[18] = "Получен новый заказ с формы, обработайте его";
    $all_t[19] = "Вы получили отзыв в проекте $text";
    $all_t[30] = "Клиент оставил комментарий в проекте $text";
    $stop_types = array(2, 3, 4, 16, 17, 33, 12, 15, 18);
    if (in_array($type, $stop_types)) return true;
    $text = $all_t[$type];
    $text = base64_encode($text);
    $time = time();
    $q = "insert into `event_center`(`type`,`date`,`to_type`,`to_id`,`text`) values('$type','$time','$to_t','$to_id','$text')";
    baza_do_only($q);

}

function int_to_str_month($int)
{
    switch ($int) {
        case 1:
            $f_m = "Января";
            break;

        case 2:
            $f_m = "Февраля";
            break;
        case 3:
            $f_m = "Марта";
            break;

        case 4:
            $f_m = "Апреля";
            break;
        case 5:
            $f_m = "Мая";
            break;

        case 6:
            $f_m = "Июня";
            break;
        case 7:
            $f_m = "Июля";
            break;

        case 8:
            $f_m = "Августа";
            break;
        case 9:
            $f_m = "Сентября";
            break;

        case 10:
            $f_m = "Октября";
            break;
        case 11:
            $f_m = "Ноября";
            break;

        case 12:
            $f_m = "Декабря";
            break;
    }

    return $f_m;
}

function get_unread_event_counter()
{
    global $user_data;
    global $db;

    $query = "select count(*) as 'count' from `event_center` where `to_type`='$user_data[type]' and `to_id`='$user_data[id]' and `read`='0'";
    $events_c = baza_do_one($query);
    $events_c = $events_c['count'];
    $events_c++;
    $events_c--;
    if ($events_c > 0)
        return "($events_c)";


}


function new_dir($name)
{
    if (!is_dir($name)) {
        return mkdir($name, 0777, true);
    } else return true;

}

function enc($str)
{
    $str = trim($str);
    $tmp = strtolower(mb_detect_encoding($str, 'UTF-8,CP1251'));
    if ($tmp != "utf-8") {

        $str = iconv($tmp, 'UTF-8', $str);
    }
    $str = str_replace("\n", "<br>", $str);
    return $str;
}
