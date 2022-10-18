<?php


function db_connect($baza_host, $baza_user, $baza_password, $baza_table)
{
    $db_connect_result = new mysqli($baza_host, $baza_user, $baza_password, $baza_table);
    $db_connect_result->query("SET NAMES 'utf8'");
    return $db_connect_result;
}

function db_disconnect($dase_db)
{
    $dase_db->close();
}

function http($data)
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

function obrabotka($obrabotka_dannie)
{
    if ($obrabotka_dannie == null) return false;
    while (($obrabotka_dannie_stroka = $obrabotka_dannie->fetch_assoc()) != false) {
        $obrabotka_dannie_result[] = $obrabotka_dannie_stroka;

    }
    return $obrabotka_dannie_result;
}

function from_utf($text)
{
    return iconv('UTF-8', 'WINDOWS-1251', $text);
}

function to_utf($text, $needBR = true)
{
    return enc($text, $needBR);
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

function convert_from_utf($text)
{
    return iconv('UTF-8', 'WINDOWS-1251', $text);
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

function reg_event($type, $to_id, $to_t, $text, $text2 = "")
{
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

    $eventApi = new EventCenter();
    $event = $eventApi->set([
        'type' => $type,
        'to_id' => $to_id,
        'to_t' => $to_t,
        'text' => $text,

    ]);
    return $event;
}

function laz_meta($link, $t = 0)
{
    return "<script> window.setTimeout(function(){location.href = '$link'}," . ($t * 1000) . ")</script>";
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


function showFAQ($q, $a, $opened = false)
{
    $id = uniqid('faq_');
    return '
    <div class="panel panel-faq">
        <div class="panel-heading">

            <a data-toggle="collapse" data-parent="#accordion" href="#' . $id . '" class="' . ($opened ? '' : 'collapsed') . '" aria-expanded="false">
                <div class="panel-title text-left">' . $q . ' <span class="arrow fa fa-lg fa-angle-down"></span></div></a>

        </div>
        <div id="' . $id . '" class="panel-collapse collapse ' . ($opened ? 'in' : '') . '" aria-expanded="false">
            <div class="panel-body text-left">
                ' . $a . '
            </div>
        </div>
    </div>
    ';
}


function showExamples($file)
{

    return '
        <div class="col-sm-4 col-md-3 text-center file-col">
            <a href="' . $file['link'] . '" class="file-link" target="_blank">
                <div class="file">
                    <div class="file-type">' . $file['type'] . '</div> 
                    <div class="file-desc">
                        <div class="file-icon">' . $file['icon'] . '</div>
                    </div>
                    <div class="file-info">
                        <div class="file-title">' . $file['title'] . '</div>
                        <div class="file-download">Скачать <span class="fa fa-download"></span></div>
                    </div>
                </div>
            </a>
        </div>
    ';
}

function check_phone($phone_number)
{
    $phone_number = str_replace(array("(", ")", "+", "-", " "), array(""), $phone_number);
    if (!is_numeric($phone_number) || strlen($phone_number) <= 5) {
        return false;
    } else {
        return true;
    }
}
