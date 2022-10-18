<?php

//session_start();
//header('Content-Type: text/html; charset=windows-1251');
//error_reporting(error_reporting() & ~E_NOTICE);
//require_once('../install/function.php');


$p = $_GET["p"];
$a = $_GET["a"];
$a2 = $_GET["a2"];
$a3 = $_GET["a3"];
$a4 = $_GET["a4"];
$a5 = $_GET["a5"];
$id = '';

$paymentApiPlaton = new PaymentUA();
$paymentApiRu = new PaymentRU();

// Google Analytics Client ID
$googleCId = strval(preg_replace('/^GA[0-9]+\.[0-9]+\./', '', $_COOKIE["_ga"]));

$modal_action = isset($_POST['action']) ? $_POST['action'] : '';

$need_reload = "<script>need_reload=true;</script>";
$need_noreload = "<script>need_reload=false;</script>";
$need_close = "<script>setTimeout(function() {\$('#modal_close').trigger('click');},1500);</script>";
$submit_hide = "<script>$('#l-p-submit').hide();$('#modal_submit').hide();submit_hide=true;</script>";


if (isset($_GET["id"])) {
    $id = post($_GET["id"]);
} else {
    $id = post($_POST["id"]);
}

if (isset($_GET["a2"])) $a2 = $_GET["a2"];
else $a2 = $_POST["a2"];


global $user_data;
$order = $orderApi->getId([
    'id' => $id
]);


//$check_session=check_session();
//if(!$check_session)die('<meta http-equiv="refresh" content="0; url=/exit">');

//$db = db_connect();


//$query = "select * from `zakaz` where `id`='$id'";
//$zakaz = baza_do_one($query);
$zakaz = $order['data'];


//echo "<pre>";
//var_dump($zakaz['client_id'], $user_data['id']);
//echo "</pre>";


$white_acts = array("del_pre_zakaz", "ref_money_get", "ref_money_edit", "ref_get_info");
if ($zakaz['client_id'] != $user_data['id']) {
//if ($zakaz['client_id'] != $user_data['id']) {
    echo "<center><b style='color:red'>Ошибка, что-то пошло не так! Перезагрузка страницы.$need_reload</b></center>";
    return;
}


if ($modal_action == "del_pre_zakaz") {

    $q = "select * from `zakaz_forma` where `id`='$id'";
    $zakaz = baza_do_one($q);
    if ($zakaz['client_id'] != $user_data['id']) {
        $not_for_me = true;
    }
    if ($zakaz['status'] != 1) $not_for_me = true;
    if ($not_for_me) {
        db_disconnect($db);
        die('<meta http-equiv="refresh" content="0; url=/cabinet/">');
    }


    $q = "update `zakaz_forma` set `status`='3' where `id`='$id'";
    baza_do_only($q);
    echo "<center><b class='good'>Заказ отменен успешно!$need_reload</b></center>";
    return;
} else if ($modal_action == "cancel_zakaz") {

    $q = "select * from `zakaz` where `id`='$id'";
    $zakaz = baza_do_one($q);
    if ($zakaz['client_id'] != $user_data['id']) {
        $not_for_me = true;
    }
    if ($zakaz['status'] > 2) $not_for_me = true;
    else if ($zakaz['pay_client'] == 1 || $zakaz['pay_predoplata'] == 1) $not_for_me = true;

    if ($not_for_me) {
        db_disconnect($db);
        die('<meta http-equiv="refresh" content="0; url=/cabinet/">');
    }


    $q = "update `zakaz` set `status`='8',`timeAction_forHide`=" . time() . " where `id`='$id'";
    baza_do_only($q);
    echo "<center><b class='good'>Заказ отменен успешно!$need_reload</b></center>";
    return;
} else if ($modal_action == "uncancel_zakaz") {

    $q = "select * from `zakaz` where `id`='$id'";
    $zakaz = baza_do_one($q);
    if ($zakaz['client_id'] != $user_data['id']) {
        $not_for_me = true;
    }
    if ($zakaz['status'] != 8) $not_for_me = true;


    if ($not_for_me) {
        db_disconnect($db);
        die('<meta http-equiv="refresh" content="0; url=/cabinet/">');
    }

    if (strlen($zakaz['stavka_au_date']) > 2) $status = 2; else $status = 1;


    $q = "update `zakaz` set `status`='$status' where `id`='$id'";
    baza_do_only($q);
    echo "<center><b class='good'>Заказ отменен успешно!$need_reload</b></center>";
    return;
} else if ($modal_action == "do_edit_promo") {
    $promoApi = new Promo();
    $promo_ = post($_POST["promo"]);
    if (strlen($zakaz['promo_code']) > 1) {
        echo "<center><b class='bad'>У данного заказа уже есть промокод!$need_reload</b></center>";
        return;
    } else if (
    !($zakaz['status'] < 8 && ($zakaz['pay_predoplata'] != 1 && $zakaz['pay_client'] != 1 && $zakaz['status'] != 6))
    ) {
        echo "<center><b class='bad'>Нельзя вводить промокод!</b></center>$need_noreload";
        return;
    }
    if (strlen($promo_) < 2) {
        echo "<center><b class='bad'>Очень короткий код!</b></center>$need_noreload";
        return;
    }

    $tmp_was = $orderApi->checkedPromocode([
        'client_id' => $user_data['id'],
        'id' => $id,
        'promo_code' => $promo_
    ]);

    if (isset($tmp_was['data'])) {
        if (count($tmp_was['data']) > 0) {
            echo "<center><b class='bad'>Вы не можете использовать промокод дважды!</b></center>$need_noreload";
            return;
        }
    }

    $promo = $promoApi->getPromo([
        'code' => $promo_
    ]);

    if (isset($promo['data']) && isset($promo['data']['error'])) {
        echo "<center><b class='bad'>" . $promo['data']['error'] . "</b></center>$need_noreload";
        return;
    }

    $promo = $promo['data'];

    $promo_code = "fr012-" . (pow($user_data['id'], 3) + 13);

    if ($promo_code == $promo_) {
        echo "<center><b class='bad'>Вы не можете использовать собственный промокод!</b></center>$need_noreload";
        return;
    } else if ($promo['active'] != 1 || ($promo['promo_valuta'] != $zakaz['pay_valuta'] && $promo['promo_valuta'] != 0)) {
        echo "<center><b class='bad'>Введенный код недействителен!</b></center>$need_noreload";
        return;
    }

    //Если все окей
    if ($promo['promo_valuta'] == 0) {
        $price_will = (int)($zakaz['cena_original'] / 100 * (100 - $promo['procent']));
    } else {
        $price_will = (int)($zakaz['cena_original'] - $promo['procent']);
    }

    if ($price_will > $zakaz['cena_skidka']) {
        echo "<center><b class='bad'>Система вам выдала бОльшую скидку, нежели введенный промокод!</b></center>$need_noreload";
        return;
    }
    if ($price_will < 1) $price_will = 1;
    $skidka_will = $zakaz['cena_original'] - $price_will;

    $time = time();

    $setPromo = $orderApi->newPromo([
        'cena_skidka' => $price_will,
        'promo_code' => $promo['code'],
        'promo_procent' => $promo['procent'],
        'promo_valuta' => $promo['promo_valuta'],
        'promo_date' => $time,
        'id' => $id
    ]);

    if ($setPromo['code'] == 200) {
        if ($promo['promo_valuta'] == 1) $val = "UAH";
        else if ($promo['promo_valuta'] == 2) $val = "RUB";
        $val = "%";
        echo "<center><b class='good'>Промокод принят!<br>Скидка: $promo[procent] $val</b><center>$need_reload $need_close
		";
        return;
    } else {
        echo "<center><b class='bad'>Ошибка, свяжитесь с менеджером!</b></center>$need_noreload";
    }


} else if ($modal_action == "dorabotka_do") {
    if ($zakaz['status'] < 5) {
        echo "<center><b class='bad'>Вы не можете совершить это действие!$need_reload</b></center>";
        return;
    }
    $manager_comment = post(convert_from_utf($_POST['manager_comment']));

    $preview_uploaded_ = $_POST['pre_uploaded_files'];
    if (count($preview_uploaded_) > 1) $preview_uploaded = implode(",", $preview_uploaded_); else $preview_uploaded = $preview_uploaded_[0];

    $pre_files = $_POST['my_files'];


    $folder_name = dirname(__FILE__) . "/ups/";

    for ($i = 0; $i < count($pre_files); $i++) {
        $n = $i + 1;
        $preview_uploaded .= "<br><a href='" . post($pre_files[$i]) . "' target='_blank' class='dor_files'>Файл $n</a>";
    }
    $manager_comment .= $preview_uploaded . "<br>";
    $comm_len = strlen($manager_comment);

    $dorabotka_max_date = post($_POST['dorabotka_max_date']);
    if (strlen($dorabotka_max_date) > 4) {
        list($year, $month, $day_) = explode('/', $dorabotka_max_date);
        list($day, $hour_) = explode(' ', $day_);
        list($hour, $min) = explode(':', $hour_);
        $dorabotka_max_date = mktime($hour, $min, 0, $month, $day, $year);
        if ($dorabotka_max_date < time()) $dorabotka_max_date = time();

        $manager_comment .= "\n Указан срок:" . date("H:i:s d/m/Y", $dorabotka_max_date);
        $comm_len += 5;

    } else $dorabotka_max_date = "";


    $manager_comment = base64_encode($manager_comment);

    $q = "update `zakaz` set `status`='4',`dorabotka_max_date`='$dorabotka_max_date' where `id`='$id'";
    if (baza_do_only($q)) {
        $this_u_type = $user_data['type'];
        $this_u_id = $user_data['id'];
        $this_u_lo = $user_data['login'];
        $now_t = time();
        if ($comm_len > 4) {
            $query = "insert into `comment_client`(`from_type`,`from_id`,`comment`,`time`,`zakaz_id`,`login`,`is_moder`) values('$this_u_type','$this_u_id','$manager_comment','$now_t','$id','$this_u_lo','1')";
            baza_do_only($query);
        }
        $text = "<a href='index.php?a=open_zakaz&id=$zakaz[id]'>$zakaz[id_for_client]</a>";
        reg_event(11, $zakaz["selected_author_id"], $zakaz["selected_author_type"], $text);//author
        reg_event(11, 1, 4, $text);//admin
        reg_event(11, $zakaz["manager_id"], 3, $text);//admin
        send_mail_to_author("Заказ под номером $zakaz[id_for_client] отправлен на доработку", "Заказ $zakaz[id_for_client]: отправлен на доработку", $zakaz['selected_author_id'], $zakaz['selected_author_type']);
        send_mail_to_manager("Заказ под номером $zakaz[id_for_client] отправлен на доработку", "Заказ $zakaz[id_for_client]: отправлен на доработку", $zakaz['manager_id']);

        echo "<center><b class='good'>Ваш заказ отправлен на доработку!$need_reload</b></center>";
        return;
    } else {
        echo "<center><b class='bad'>Ошибка в базе!$need_noreload</b></center>";
        return;
    }

} else if ($modal_action == "do_rating") {
    if ($zakaz['ocenka_done'] == 1) {
        echo "<center><b class='bad'>Вы уже оценивали этот заказ!$need_reload</b></center>";
        return;
    }
    $good = true;
    $comment = post(convert_from_utf($_POST['text']));
    $rating = post($_POST['rating']);
    if ($rating < 1 || $rating > 5) {
        echo "<center><b class='bad'>Ошибка, вы забыли выбрать оценку!$need_noreload</b></center>";
        return;
    } else {
        $comment = base64_encode($comment);
        $this_u_type = $user_data['type'];
        $this_u_id = $user_data['id'];
        $now_t = time();
        $au_id = $zakaz['selected_author_id'];
        $au_t = $zakaz['selected_author_type'];
        $zz_id = $zakaz['id_for_client'];
        $query = "insert into `ratings_system`(`user_id`,`user_type`,`comment`,`ocenka`,`zakaz_id`,`z_id`,`author_id`,`author_type`,`date`) values('$this_u_id','$this_u_type','$comment','$rating','$id','$zz_id','$au_id','$au_t','$now_t')";
        if (baza_do_only($query)) {
            echo "<center><b class='good'>Спасибо за оценку, ваше мнение очень важно для нас!$need_reload</b></center>";
            $query = "update `zakaz` set `ocenka_done`='1' where `id`='$id'";
            baza_do_only($query);

            $text = "<a href='index.php?a=open_zakaz&id=$zakaz[id]'>$zakaz[id_for_client]</a>";
            reg_event(19, $zakaz["selected_author_id"], $zakaz["selected_author_type"], $text);//author
        } else {
            echo "<center><b class='bad'>Ошибка, проблема с базой!$need_noreload</b></center>";
            return;
        }

    }
} else if ($modal_action == "do_edit_rating") {
    if ($zakaz['ocenka_done'] != 1) {
        echo "<center><b class='bad'>Вы еще не оценивали этот заказ!$need_reload</b></center>";
        return;
    }
    $good = true;
    $comment = post(convert_from_utf($_POST['text']));

    $rating = post($_POST['rating']);
    if ($rating < 1 || $rating > 5) {
        echo "<center><b class='bad'>Ошибка, вы забыли выбрать оценку!$need_noreload</b></center>";
        return;
    } else {
        $comment = base64_encode($comment);
        $this_u_type = $user_data['type'];
        $this_u_id = $user_data['id'];
        $now_t = time();
        $au_id = $zakaz['selected_author_id'];
        $au_t = $zakaz['selected_author_type'];
        $zz_id = $zakaz['id_for_client'];

        $query = "update `ratings_system` set `comment`='$comment',`ocenka`='$rating',`date`='$now_t' where`zakaz_id`='$id'";
        if (baza_do_only($query)) {
            echo "<center><b class='good'>Спасибо за оценку, ваше мнение очень важно для нас!$need_reload</b></center>";
            $query = "update `zakaz` set `ocenka_done`='1' where `id`='$id'";
            baza_do_only($query);

            $text = "<a href='index.php?a=open_zakaz&id=$zakaz[id]'>$zakaz[id_for_client]</a>";
            reg_event(19, $zakaz["selected_author_id"], $zakaz["selected_author_type"], $text);//author
        } else {
            echo "<center><b class='bad'>Ошибка, проблема с базой!$need_noreload</b></center>";
            return;
        }
    }

    //echo '<a href="index.php?a=open_zakaz&id='.$id.'"><center>Закрыть окно</center></a>.<meta http-equiv="refresh" content="3; url=index.php?a=open_zakaz&id='.$id.'">';
} else if ($modal_action == "do_pay_ref" && false) {
    if ($zakaz['cena_skidka'] < 1) {
        echo "<center><b class='bad'>Заказ еще не оценен!</b></center>$submit_hide";
        return;
    }
    if ($zakaz['pay_client'] == 1) {
        echo "<center><b class='good'>Полная оплата уже получена!</b></center>$submit_hide";
        return;
    }


    $pay_need = $zakaz['cena_skidka'] - $zakaz["penya_to_system"];
    $paid = $zakaz['paid_pre'] + $zakaz['paid_next'];
    $pay_ost = $pay_need - $paid;
    if ($pay_ost <= 0) {
        echo "<center><b class='good'>Полная оплата уже получена!</b></center>$submit_hide";
        return;
    }
    $ref_money_info = get_ref_money();
    $can = $ref_money_info['money'];


    if ($zakaz['pay_valuta'] != $ref_money_info['valuta_id']) {
        echo "<center><b class='err'>Валюта заказа не соответствует валюте кеша.</b></center>$submit_hide";
        return;
    }

    if ($zakaz['pay_valuta'] != $user_data['valuta']) $can = 0;
    $max = min($can, $pay_need);


    $val = post(convert_from_utf($_POST['val']));
    $val++;
    $val--;
    $val = (int)$val;
    if ($val > $max) {
        echo "<center><b class='red'>Ставка слишком высокая!</b></center>";
        return;
    }
    if ($val < 0) $val = 0;
    if ($val == 0) {
        echo "<center><b class='red'>Ставка должна быть больше 0!</b></center>";
        return;
    }

    if ($zakaz['skidka_used'] + $val > ($pay_need + $zakaz['skidka_used']) / 2) {
        echo "<center><b class='red'>Нельзя уменьшать цену более чем в 2 раза от изначальной стоимости</b></center>";
        return;
    }


    $new_cena = $zakaz['cena_skidka'] - $val;
    if ($new_cena < 0) $new_cena = 0;
    if (($max - $val) <= 0) {
        $data_full = time();
        $q = "update `zakaz` set `pay_client`='1',`paid_next`='1',`data_full`='$data_full',`cena_skidka`='$new_cena' where `id`='$id'";
    } else {
        $q = "update `zakaz` set `cena_skidka`='$new_cena' where `id`='$id'";
    }
    baza_do_only($q);
    $time = time();
    $skidka_used = $zakaz['skidka_used'] + $val + 0;
    $q = "update `zakaz` set `skidka_date`=$time,`skidka_used`=$skidka_used where `id`='$id'";
    baza_do_only($q);


    $q = "select * from `zakaz` where `id`='$id'";
    $tmp = time();
    $q = "insert into `ref_money`(`ref_id`,`ref_val`,`count`,`count_done`,`date_add`,`rekv`,`status`) 
			values ('$user_data[id]','$user_data[valuta]','$val','$val','$tmp','Zakaz $zakaz[id_for_client]','3')";
    // echo $q;
    if (baza_do_only($q)) {
        echo "<center><b class='good'>Вы успешно снизили цену!</b></center>$need_reload";
        return;
    } else {
        echo "<center><b class='red'>DB ERR!</b></center>";
        return;
    }


} else if ($modal_action == "ref_money_get") {
    $minimum = 1;
    if ($user_data['valuta'] == 2) $val = 'RUB';
    else if ($user_data['valuta'] == 3) $val = 'USD';
    else $val = 'UAH';
    $money_count = post($_POST["money_count"]);
    $money_rekv = post($_POST["money_rekv"]);
    $q = "select sum(cena_skidka*ref_proc/100) as 's' from `zakaz` where `pay_valuta`='$user_data[valuta]' and `ref_id`='$user_data[id]' and (`pay_predoplata`='1' or `pay_client`='1')";
    $sum = baza_do_one($q);
    $sum['s']++;
    $sum['s']--;
    $sum_show = number_format($sum['s'], 2, ',', ' ');

    $q = "select sum(count_done) as 's' from `ref_money` where `ref_id`='$user_data[id]'";
    $sum_done = baza_do_one($q);
    $sum_done['s']++;
    $sum_done['s']--;
    $sum_done_show = number_format($sum_done['s'], 2, ',', ' ');
    $can = $sum['s'] - $sum_done['s'];
    $can_show = number_format($can, 2, ',', ' ');
    $q = "select * from `ref_money` where `ref_id`='$user_data[id]' order by id desc limit 1";
    $last_req = baza_do_one($q);
    if ($last_req['status'] != 1) $can_want = true;

    if ($can_want) {
        if ($can < $minimum) {
            echo "<div class='alert alert-danger'>Вам еще рано делать запрос</div>";
            return;
        } else if ($money_count < $minimum) {
            echo "<div class='alert alert-danger'>Запрос должен быть не меньше $minimum $val</div>";
            return;
        } else if ($money_count > $can) {
            echo "<div class='alert alert-danger'>Вы просите больше, чем положено.<br>Вам доступно $can $val</div>";
            return;
        } else if (strlen($money_rekv) < 3) {
            echo "<div class='alert alert-danger'>Введите реквизиты</div>";
            return;
        } else {
            $tmp = time();
            $q = "insert into `ref_money`(`ref_id`,`ref_val`,`count`,`date_add`,`rekv`) 
			values ('$user_data[id]','$user_data[valuta]','$money_count','$tmp','$money_rekv')";
            if (baza_do_only($q)) {
                echo "<div class='alert alert-success'>Ваш запрос успешно зарегистрирован</div>$need_reload";

                $money_rekv = iconv('UTF-8', 'WINDOWS-1251', $money_rekv);
                send_mail_to_manager("Здравствуйте, прошу вывести <b>$money_count $val</b> на $money_rekv", "Запрос на вывод денег от $user_data[login]", 1);
                return;

            } else {
                echo "<div class='alert alert-danger'>DB ERR!</div>";
                return;
            }
        }
    } else {
        echo "<div class='alert alert-danger'>У вас уже есть один активный запрос</div>";
        return;
    }
} else if ($modal_action == "ref_money_edit") {
    $q = "select * from `ref_money` where `ref_id`='$user_data[id]' order by id desc limit 1";
    $last_req = baza_do_one($q);
    if ($last_req['status'] != 1) {
        echo "<div class='alert alert-danger'>Вы уже не можете редактировать этот запрос.</div>";
        return;
    } else {

        $money_count = post($_POST["money_count"]);
        $money_rekv = post($_POST["money_rekv"]);
        $q = "select sum(cena_skidka*ref_proc/100) as 's' from `zakaz` where `pay_valuta`='$user_data[valuta]' and `ref_id`='$user_data[id]' and (`pay_predoplata`='1' or `pay_client`='1')";
        $sum = baza_do_one($q);
        $sum['s']++;
        $sum['s']--;
        $sum_show = number_format($sum['s'], 2, ',', ' ');

        $q = "select sum(count_done) as 's' from `ref_money` where `ref_id`='$user_data[id]'";
        $sum_done = baza_do_one($q);
        $sum_done['s']++;
        $sum_done['s']--;
        $sum_done_show = number_format($sum_done['s'], 2, ',', ' ');
        $can = $sum['s'] - $sum_done['s'];
        $can_show = number_format($can, 2, ',', ' ');


        if ($can < $minimum) {
            echo "<div class='alert alert-danger'>Вам еще рано делать запрос</div>";
            return;
        } else if ($money_count < $minimum) {
            echo "<div class='alert alert-danger'>Запрос должен быть не меньше $minimum $val</div>";
            return;
        } else if ($money_count > $can) {
            echo "<div class='alert alert-danger'>Вы просите больше, чем положено.<br>Вам доступно $can  $val</div>";
            return;
        } else if (strlen($money_rekv) < 3) {
            echo "<div class='alert alert-danger'>Введите реквизиты</div>";
            return;
        } else {
            $tmp = time();
            $q = "update `ref_money`
		set `count`='$money_count',`date_change`='$tmp',`rekv`='$money_rekv' where `ref_id`='$user_data[id]' and `id`=$last_req[id]";
            if (baza_do_only($q)) {
                echo "<div class='alert alert-success'>Ваш запрос успешно зарегистрирован</div>$need_reload";
                $money_rekv = iconv('UTF-8', 'WINDOWS-1251', $money_rekv);
                send_mail_to_manager("Здравствуйте, Я изменил информацию в моем запросе. Прошу вывести <b>$money_count $val</b> на $money_rekv", "Запрос на вывод денег от $user_data[login]", 1);

                return;
            } else {
                echo "<div class='alert alert-danger'>Введите реквизиты</div>";
                return;
            }
        }


    }
} else if ($a2 == "get_promo_form") {
    if (strlen($zakaz['promo_code']) > 1) {
        echo "<center><b class='bad'>У данного заказа уже есть промокод!</b></center>$submit_hide";
        return;
    }

    echo "
		<center>Введите код на скидку:</center>
		<input type='text' name='promo' style='width: 100%' autocomplete='off'>
		<input value='$id' hidden name='id'>
		<input name='action' hidden value='do_edit_promo'>
	";

} else if ($a2 == "lets_pay_pre") {
    if ($zakaz['cena_skidka'] < 1) {
        echo "<center><b class='bad'>Заказ еще не оценен!</b></center>$submit_hide";
        return;
    }

    if ($zakaz['pay_predoplata'] == 1 || $zakaz['pay_client'] == 1) {
        echo "<center><b class='bad'>Предоплата уже получена!</b></center>$submit_hide";
        return;
    }
    $pay_need = $zakaz['cena_skidka'];
    if ($zakaz['pay_valuta'] == 1) $valuta = "UAH";
    else if ($zakaz['pay_valuta'] == 3) $valuta = "USD";
    else $valuta = "RUB";

    $sd_user = $_COOKIE['sd_user'];
    setcookie("ref_id", "0", time() - 1);
    echo "<center>";
    if ($zakaz['predoplata_must'] > 0) echo "<b>Вы оплатите:</b><br> <span style='font-size: 23px;'>" . number_format($zakaz['predoplata_must'], 0, ',', ' ') . " $valuta</span><br>";
    else
        echo "<b>Вы оплатите 50% от стоимости заказа:</b><br> <span style='font-size: 23px;'>" . number_format((int)($pay_need / 2), 0, ',', ' ') . " $valuta</span><br>";

    echo "<br>$submit_hide";

    $count = (int)($zakaz['cena_skidka'] / 2);
    if ($zakaz['predoplata_must'] > 0) $count = $zakaz['predoplata_must'];
    $dest = "$zakaz[id_for_client]";
    $refApi = new Referer();
    global $user_data;
    $ref_data = $refApi->get([
        'client_id' => $user_data['id']
    ]);


    $type = 'pre-';
    if ($zakaz['pay_valuta'] == 2 || $zakaz['pay_valuta'] == 3) {
        $result_url = "http://" . $_SERVER['HTTP_HOST'] . "/?a=open_zakaz&id=$id";
        if ($zakaz['pay_valuta'] == 3) {
            $valuta = "USD";
        } else {
            $valuta = "RUB";
        }
        $payment = $paymentApiRu->getButton([
            'desc' => 'Предоплата заказа ' . $zakaz['id_for_client'],
            'currency' => $valuta,
            'amount' => round($count, 3),
            'orderId' => intval($zakaz['id']),
            'isRework' => 0,
            'reworkId' => 0,
            'google' => $googleCId,
        ]);

        echo $payment['data'];
    } else {

        $valuta = "UAH";
        $result_url = "http://" . $_SERVER['HTTP_HOST'] . "/cabinet/?a=open_zakaz&id=$id";
//                ["result_url"]=> string(42) "http://na5ku.com.ua/?a=open_zakaz&id=40761"
//                ["amount"]=> string(2) "50"
//                ["description"]=> string(11) "id-6791-199"
//                ["currency"]=> string(3) "UAH"
//                ["ext1"]=> NULL
//                ["ext2"]=> string(20) "512496014.1548847490"
        $payment = $paymentApiPlaton->getButton([
            'api_key' => $ref_data['data']['platon_id'],
            'password' => $ref_data['data']['platon_pass'],
            'params' => [
                'customer' => $ref_data['data']['id'],
                'result_url' => $result_url,
                'amount' => $count,
                'description' => $zakaz['id_for_client'],
                'currency' => $valuta,
                'ext1' => 'surcharge',
                'ext2' => $ref_data['data']['id']
            ]]);

        echo $payment['data'];
    }


    echo "</center>";
} else if ($a2 == "lets_pay") {
    if ($zakaz['cena_skidka'] < 1) {
        echo "<center><b class='bad'>Заказ еще не оценен!</b></center>$submit_hide";
        return;
    }
    if ($zakaz['pay_client'] == 1) {
        echo "<center><b class='good'>Полная оплата уже получена!</b></center>$submit_hide";
        return;
    }
    if ($zakaz['status'] != 6) {
        echo "<center><b class='good'>Еще рано!</b></center>$submit_hide";
        return;
    }

    $pay_need = $zakaz['cena_skidka'] - $zakaz["penya_to_system"];
    $paid = $zakaz['paid_pre'] + $zakaz['paid_next'];
    $pay_ost = $pay_need - $paid;
    if ($pay_ost <= 0) {
        echo "<center><b class='good'>Полная оплата уже получена!</b></center>$submit_hide";
        return;
    }
    if ($zakaz['pay_valuta'] == 1) $valuta = "UAH";
    else if ($zakaz['pay_valuta'] == 3) $valuta = "USD";
    else $valuta = "RUB";

    $sd_user = $_COOKIE['sd_user'];
    setcookie("ref_id", "0", time() - 1);


    echo "$submit_hide<center>
		<b>Всего надо заплатить:</b> " . number_format($pay_need, 0, ',', ' ') . " $valuta<br>
		<b>Вами заплачено:</b> " . number_format($paid, 0, ',', ' ') . " $valuta<br>
		<b>Осталось:</b> " . number_format($pay_ost, 0, ',', ' ') . " $valuta<br>
		<br>
		";


    $dest = "$zakaz[id_for_client]";
    $refApi = new Referer();
    global $user_data;


    $ref_data = $refApi->get([
        'client_id' => $user_data['id']
    ]);
    $count = $pay_ost;
    if ($zakaz['pay_valuta'] == 2 || $zakaz['pay_valuta'] == 3) {
        if ($zakaz['pay_valuta'] == 3) {
            $valuta = "USD";
        } else {
            $valuta = "RUB";
        }

        $result_url = "http://" . $_SERVER['HTTP_HOST'] . "/?a=open_zakaz&id=$id";

        $type = 'order-';

        $payment = $paymentApiRu->getButton([
            'desc' => 'Оплата остатка заказа ' . $zakaz['id_for_client'],
            'currency' => $valuta,
            'amount' => round($count, 3),
            'orderId' => intval($zakaz['id']),
            'isRework' => 0,
            'reworkId' => 0,
            'google' => $googleCId,
        ]);

        echo $payment['data'];

    } else {
        $valuta = "UAH";

        $result_url = "http://" . $_SERVER['HTTP_HOST'] . "/cabinet/?a=open_zakaz&id=$id";

        $payment = $paymentApiPlaton->getButton([
            'api_key' => $ref_data['data']['platon_id'],
            'password' => $ref_data['data']['platon_pass'],
            'params' => [
                'customer' => $ref_data['data']['id'],
                'result_url' => $result_url,
                'amount' => $count,
                'description' => $zakaz['id_for_client'],
                'currency' => $valuta,
                'ext1' => 'surcharge_final',
                'ext2' => $ref_data['data']['id']
            ]]);

        echo $payment['data'];
    }


    echo "</center>";
} else if ($a2 == "lets_pay_ref") {
    if ($zakaz['cena_skidka'] < 1) {
        echo "<center><b class='bad'>Заказ еще не оценен!</b></center>$submit_hide";
        return;
    }
    if ($zakaz['pay_client'] == 1) {
        echo "<center><b class='good'>Полная оплата уже получена!</b></center>$submit_hide";
        return;
    }


    $pay_need = $zakaz['cena_skidka'] - $zakaz["penya_to_system"];
    $paid = $zakaz['paid_pre'] + $zakaz['paid_next'];
    $pay_ost = $pay_need - $paid;
    if ($pay_ost <= 0) {
        echo "<center><b class='good'>Полная оплата уже получена!</b></center>$submit_hide";
        return;
    }
    if ($zakaz['pay_valuta'] == 1) $valuta = "UAH";
    else if ($zakaz['pay_valuta'] == 3) $valuta = "USD";
    else $valuta = "RUB";
    /*
    $q="select sum(cena_skidka*ref_proc/100) as 's' from `zakaz` where `pay_valuta`='$user_data[valuta]' and `ref_id`='$user_data[id]' and (`pay_predoplata`='1' or `pay_client`='1')";
    $sum=baza_do_one($q);
    $sum['s']++;
    $sum['s']--;

    $q="select sum(count_done) as 's' from `ref_money` where `ref_id`='$user_data[id]'";
    $sum_done=baza_do_one($q);
    $sum_done['s']++;
    $sum_done['s']--;
    $can=$sum['s']-$sum_done['s'];
    if($can<0)$can=0;
    */
    $ref_money_info = get_ref_money();
    $can = $ref_money_info['money'];
    if ($zakaz['pay_valuta'] != $ref_money_info['valuta_id']) {
        echo "<center><b class='err'>Валюта заказа не соответствует валюте кеша.</b></center>$submit_hide";
        return;
    }

    $maxPAYCan = ($pay_need + $zakaz['skidka_used']) / 2 - $zakaz['skidka_used'];

    if ($maxPAYCan <= 0) {
        echo "<center><b class='red'>Нельзя уменьшать цену более чем в 2 раза от изначальной стоимости</b></center>";
        return;
    }

    $max = min($can, $pay_need, $maxPAYCan);

    if ($can == 0) {
        echo "<center><b class='err'>У вас нет денег на бонусном счете, чтобы уменьшить цену. Как получить деньги на бонусный счет читайте <a href='/cabinet/earn/' target='_blank' style='cursor: help' title='Кликни'>здесь</a>.</b></center>$submit_hide";
        return;
    }


    echo "<center>
		<b>Всего надо заплатить:</b> " . number_format($pay_need, 0, ',', ' ') . " $valuta<br>
		<b><a href='/cabinet/earn/' target='_blank' style='cursor: help' title='Кликни'><u>Вами заработано</u></a>:</b> " . number_format($can, 0, ',', ' ') . " $valuta<br>
		<b>Сумму можно уменьшить на:</b> " . number_format($max, 0, ',', ' ') . " $valuta<br>
		Введите сумму:
		<input type='number' step='1' min='0' max='$max' name='val' value='$max' style='border: 1px solid gray; padding: 5px; border-radius: 5px;'>
		
		<input value='$id' hidden name='id'>
		<input name='action' hidden value='do_pay_ref'>
		
		
		<br>
		";


    echo "</center>";
} else if ($a2 == "lets_pay_dor") {
    $dorID = isset($_GET['dorID']) ? intval($_GET['dorID']) : 0;
    if ($dorID < 0) {
        $dorID = 0;
    }

    if (!$dorID) {
        echo "<center><b class='bad'>ID доработки не передано</b></center>$submit_hide";
        return;
    }

    $reworkBalance = 0;
    $reworkInfo = [];
    $reworkFilter = array_filter($zakaz['rework'], function ($rework) {
        global $dorID;
        return $rework['id'] == $dorID;
    });

    if (!$reworkFilter) {
        echo "<center><b class='bad'>Доработка не найдена</b></center>$submit_hide";
        return;
    }

    foreach ($reworkFilter as $rework) {
        $reworkInfo = $rework;
        break;
    }

    $reworkBalance = round($reworkInfo['amount_client'] - $reworkInfo['paid_client'], 3);

    if ($reworkBalance <= 0) {
        echo "<center><b class='bad'>Остаток этой дорабоки 0!</b></center>$submit_hide";
        return;
    }

    if ($zakaz['pay_valuta'] == 1) {
        $valuta = "UAH";
    } elseif ($zakaz['pay_valuta'] == 2) {
        $valuta = "RUB";
    } elseif ($zakaz['pay_valuta'] == 3) {
        $valuta = "USD";
    }

    $sd_user = $_COOKIE['sd_user'];
    setcookie("ref_id", "0", time() - 1);

    $pay_need = $reworkInfo['amount_client'];
    $paid = $reworkInfo['paid_client'];

    echo "$submit_hide<center>
		<b>Всего надо заплатить:</b> " . number_format($pay_need, 2, ',', ' ') . " $valuta<br>
		<b>Вами заплачено:</b> " . number_format($paid, 2, ',', ' ') . " $valuta<br>
		<b>Осталось:</b> " . number_format($reworkBalance, 2, ',', ' ') . " $valuta<br>
		<br>
		";

    $refApi = new Referer();
    $ref_data = $refApi->get([
        'client_id' => $user_data['id']
    ]);

    if ($zakaz['pay_valuta'] == 2 || $zakaz['pay_valuta'] == 3) {
        if ($zakaz['pay_valuta'] == 3) {
            $valuta = "USD";
        } else {
            $valuta = "RUB";
        }

        $payment = $paymentApiRu->getButton([
            'desc' => 'Оплата доработки в заказе ' . $zakaz['id_for_client'],
            'currency' => $valuta,
            'amount' => $reworkBalance,
            'orderId' => intval($zakaz['id']),
            'isRework' => 1,
            'reworkId' => intval($reworkInfo['id']),
            'google' => $googleCId,
        ]);

        echo $payment['data'];
    } else {
        $valuta = "UAH";

        $zakaz['id_for_client'] .= '/' . $reworkInfo['id'];

        $result_url = "http://" . $_SERVER['HTTP_HOST'] . "/cabinet/?a=open_zakaz&id=$id";
        $payment = $paymentApiPlaton->getButton([
            'api_key' => $ref_data['data']['platon_id'],
            'password' => $ref_data['data']['platon_pass'],
            'params' => [
                'customer' => $ref_data['data']['id'],
                'result_url' => $result_url,
                'amount' => $reworkBalance,
                'description' => $zakaz['id_for_client'],
                'currency' => $valuta,
                'ext1' => 'surcharge_dor',
                'ext2' => $ref_data['data']['id']
            ]]);

        echo $payment['data'];
    }

    echo "</center>";
} else if ($a2 == "dorabotka") {
    if ($zakaz['status'] < 0.5) {
        echo "<center><b class='bad'>Еще рано!</b></center>$submit_hide";
        return;
    }

    echo "
	<center>Ваш комментарий:
	<br><textarea name='manager_comment' rows='5' class='form-control'></textarea>
	<link rel='stylesheet' type='text/css' href='" . NA5KU_CDN_URL . "lib/datetime/jquery.datetimepicker.css'/ >
	<script src='" . NA5KU_CDN_URL . "lib/datetime/jquery.datetimepicker.js'></script>
	Крайний срок доработки: <input style='border:  solid 1px gray;padding: 5px;' type='text' id='datetimepicker' name='dorabotka_max_date' autocomplete='off'>
	<script>jQuery('#datetimepicker').datetimepicker();</script>
	<br><b>Файлы:</b><br>
	<br>
	Добавить файлы:
	<input name='action' hidden value='Отправить'>
	<div style='height: 150px;overflow-y: auto ;overflow-x: hidden ;'>
		<div id='fileuploader'>Загрузить</div>
		<div id='my_files'></div> 
					

		<input value='$id' hidden name='id'>
		<input name='action' hidden value='dorabotka_do'> 
					
		<script>
		$(document).ready(function()
		{
		$(\"#fileuploader\").uploadFile({
		url:\"/myupload2_fancy.php\",
		fileName:\"userfile\"
		});
		});
		</script>
	</div>
	</center>
	";
} else if ($a2 == "rating") {
    if ($zakaz['ocenka_done'] == 1) {
        echo "<center><b class='bad'>Вы уже оценили этот заказ!</b></center>$submit_hide";
        return;
    }
    echo "
	<center>
	Ваша оценка:
	<select name='rating'>
		<option value='0' selected>Выбрать</option>
		<option value='1'>Ужасно</option>
		<option value='2'>Плохо</option>
		<option value='3'>Не плохо</option>
		<option value='4'>Хорошо</option>
		<option value='5'>Отлично</option>
	</select>
	<br>Ваш комментарий<Br><textarea name='text' class='form-control' rows='5' placeholder=''></textarea>";

    echo "
		
		<input value='$id' hidden name='id'>
		<input name='action' hidden value='do_rating'>
		</center>
	";
} else if ($a2 == "edit_rating") {
    if ($zakaz['ocenka_done'] != 1) {
        echo "<center><b class='bad'>Вы еще не оценивали этот заказ!</b></center>$submit_hide";
        return;
    }
    $q = "select * from `ratings_system` where `zakaz_id`='$id'";
    $rating = baza_do_one($q);
    $rating['comment'] = base64_decode($rating['comment']);

    echo "
	<center>
	Ваша оценка:
	<select name='rating'>
		<option value='0'" . (($rating['ocenka'] == 0) ? "selected" : "") . ">Выбрать</option>
		<option value='1'" . (($rating['ocenka'] == 1) ? "selected" : "") . ">Ужасно</option>
		<option value='2'" . (($rating['ocenka'] == 2) ? "selected" : "") . ">Плохо</option>
		<option value='3'" . (($rating['ocenka'] == 3) ? "selected" : "") . ">Не плохо</option>
		<option value='4'" . (($rating['ocenka'] == 4) ? "selected" : "") . ">Хорошо</option>
		<option value='5'" . (($rating['ocenka'] == 5) ? "selected" : "") . ">Отлично</option>
	</select>
	<br>Ваш комментарий<Br><textarea name='text' class='form-control' rows='5' placeholder=''>$rating[comment]</textarea>";

    echo "
			
	<input value='$id' hidden name='id'>
	<input name='action' hidden value='do_edit_rating'>
	</center>
	";
} else if ($a2 == "download_full") {
    $paid = $zakaz['paid_pre'] + $zakaz['paid_next'];
    $pay_need = $zakaz['cena_skidka'] - $paid;
    $pay_need -= $zakaz["penya_to_system"];
    if ($pay_need < 0) $pay_need = 0;
    $pay_need = $pay_need + $zakaz["cena_d_cl"] - $zakaz['paid_dor'];
    if ($pay_need < 0) $pay_need = 0;


    if ($zakaz['pay_client'] == 1 && $pay_need == 0) {
        if ($zakaz['ocenka_done'] == 1) echo "$submit_hide<center>Благодарим за использование нашего сервиса.</center>
		<iframe src='/preview.php?id=$zakaz[id_for_client]&key=$zakaz[code_full]&type=full&a=download&time=" . time() . "' hidden></iframe>
		";
        else echo "$submit_hide<center>Просим оценить работу автора после сдачи проекта.<br>Сделаем наш сервис лучше вместе!</center>
		<iframe src='/preview.php?id=$zakaz[id_for_client]&key=$zakaz[code_full]&type=full&a=download&time=" . time() . "' hidden></iframe>
		";
    }
} else if ($a2 == "mark_as_read") {
    $q = "select * from `zakaz` where `id`='$id' and `client_id`='$user_data[id]'";
    $info = baza_do_one($q);
    if ($info['id'] > 0) {
        $q = "UPDATE `zakaz` SET `client_event_plan`='0',`client_event_anti`='0' where `id`='$info[id]'";
        baza_do_only($q);
        echo "ok";
    }
} else if ($a2 == "mark_as_read_sms") {
    $q = "select * from `zakaz` where `id`='$id' and `client_id`='$user_data[id]'";
    $info = baza_do_one($q);
    if ($info['id'] > 0) {
        $q = "UPDATE `comment_client` SET `read_by_client`='1' where `zakaz_id`='$info[id]'";
        baza_do_only($q);
        echo "ok";
    }
} else if ($a2 == "ref_get_info") {
    $q = "select * from `ref_money` where `ref_id`='$user_data[id]' order by id desc limit 1";
    $last_req = baza_do_one($q);
    if ($last_req['status'] != 1) {
        echo "done";
        return;
    } else {
        echo json_encode($last_req);
    }
}

db_disconnect($db);

