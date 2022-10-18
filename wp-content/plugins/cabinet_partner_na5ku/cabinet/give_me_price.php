<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
error_reporting(error_reporting() & ~E_NOTICE);
require_once('f.php');
$p = post($_GET["p"]);
$a = post($_GET["a"]);
$a3 = post($_GET["a3"]);
$a4 = post($_GET["a4"]);
$type = post($_GET["type"]);


$user_data;
$check_session = check_session();
$db = db_connect();
if ($check_session) {
    $q = "select sum(paid_pre + paid_next) as 's' from `zakaz` where `client_id`='$user_data[id]' and `status`<8";
    //echo $q;
    $summ = baza_do_one($q);
    $summ = $summ['s'];
    $procent_will = $skidka_will[0];
    $summ_need = $skidka_need[0];
    $procent_now = 0;
    for ($i = count($skidka_need) - 1; $i >= 0; $i--) {
        if ($summ > $skidka_need[$i]) {
            $procent_now = $skidka_will[$i];
            $procent_will = $skidka_will[$i + 1];
            $summ_need = $skidka_need[$i + 1];
            break;
        }
    }
}

$promo = post($_GET["promo"]);
$promo = iconv('WINDOWS-1251', 'UTF-8', $promo);
$promo = "";//заглушка промокода
if (strlen($promo) > 2) {
    $q = "select * from `promo` where `active`='1' and `code`='$promo'";
    $promo = baza_do_one($q);
    $procent = $promo['procent'];

}
$procent++;
$procent--;
$procent_now++;
$procent_now--;
if ($procent_now > $procent) $procent = $procent_now;
////////
$procent_ = $procent;
$promo['promo_valuta']++;
$promo['promo_valuta']--;
if ($promo['promo_valuta'] == 0)
    $procent = (100 - $procent) / 100;

////////
$count = post($_GET["count"]);
$count++;
$count--;
if ($count < 1) $count = 1;
if ($count > 100) $count = 100;

////////
$type = post($_GET["type"]);
$q = "select * from `zakaz_types` where `id`='$type'";
$type = baza_do_one($q);
if ($type['active'] != 1) die("Выбран неверный тип!");


////////
$days = post($_GET["days"]);
$days++;
$days--;
if ($days < 0) $days = 0;

//count price
$sel_c_pr = ($count / $type['st_ob'] - 1) * $type['pr_ob'];
if ($sel_c_pr < 0) $sel_c_pr = 0;

//data price
$sel_d_pr = (1 - $days / $type['st_sr']) * $type['pr_spex'];
if ($sel_d_pr < 0) $sel_d_pr = 0;
if ($days == 0) {
    $sel_d_pr = 0;
}

$nadb = $sel_c_pr + $sel_d_pr;
if ($nadb > $type['pr_max_nadb']) $nadb = $type['pr_max_nadb'];
$summ_ = ($type['pr_original'] + $nadb);

if ($promo['promo_valuta'] == 0) {
    $summ = ($type['pr_original'] + $nadb) * $procent;
    // echo $procent;
} else {
    if ($promo['promo_valuta'] == 1) {
        $summ = ($type['pr_original'] + $nadb) - $procent;
        //$procent_="0";

    } else {
        $summ = $type['pr_original'] + $nadb;
        $procent_ = "0";

    }
}
// echo $summ;
if ($summ < 0) $summ = 0;
$summ = (int)$summ;
$summ_ = $summ_ - $summ;
$summ_ = (int)$summ_;

$promo['promo_valuta']++;
$promo['promo_valuta']--;
$show['procent'] = $procent_;
$show['valuta'] = 1;
$show['now'] = $summ;
$show['sk_count'] = $summ_;
echo json_encode($show);

db_disconnect($db);
?>
