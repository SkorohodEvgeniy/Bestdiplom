<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
global $user_data;
$orderOne = $orderApi->get([
    'id' => isset($forceId) ? $forceId : $_GET['id']
]);
$id = 0;
$typeOrderApi = new TypeOrder();
$subjectOrderApi = new SubjectOrder();


$zakaz = $orderOne['data'];
//print_r($zakaz);
//die();
if ($zakaz['client_id'] != $user_data['id']) {
    $not_for_me = true;
} else {
    $id = $zakaz['id'];
}


if ($not_for_me) {
    die('<meta http-equiv="refresh" content="0; url=/cabinet/">');
}

$notif = $orderOne = $orderApi->notif([
    'id' => $zakaz['id_for_client']
]);

if ($notif['notifPaidFull'] == 1) {
    $a2 = "show_file";
}

$type = $typeOrderApi->get([
    'id' => $zakaz['type']
]);
$type = $type['data'];


$subject = $subjectOrderApi->get([
    'id' => $zakaz['special']
]);
$specialnost = $subject['data'];

$zakaz['type'] = $type;

$zakaz['special'] = $specialnost;

if ($zakaz['pay_valuta'] == 1) $valuta = "UAH";
else if ($zakaz['pay_valuta'] == 3) $valuta = "USD";
else $valuta = "RUB";

if ($a == "open_zakaz") {
    $all_status[1] = "Ожидает предоплату";
    $all_status[2] = "Ожидает предоплату";
    $all_status[3] = "Мы пишем вашу работу";
    $all_status[4] = "Мы пишем вашу работу";
    $all_status[5] = "Мы пишем вашу работу";
    $all_status[6] = "Ваша работа готова";
    $all_status[7] = "Ваша работа готова";
    $all_status[8] = "Отменен";

    $status_ = $zakaz['status'];
    $status = $all_status[$status_];

    if ($status_ == 3 && $zakaz['pay_predoplata'] != 1 && $zakaz['pay_client'] != 1) $status = $all_status[2];//мы ждем (если заказ особенный)
    if (($zakaz['pay_predoplata'] == 1 || $zakaz['pay_client'] == 1) && $status_ < 3) $status = $all_status[3];//мы пишем если оплачено раньше чем нашли автора
    if ($zakaz['cena_skidka'] == 0 && $status_ != 8) {
        $status = "Оценивается";
        $proc = "0";
    }
    $paid = $zakaz['paid_pre'] + $zakaz['paid_next'];
    $pay_need = $zakaz['cena_skidka'] - $paid;

    $pay_need -= $zakaz["penya_to_system"];

    if ($pay_need < 0) $pay_need = 0;
    $pay_need = $pay_need + $zakaz["cena_d_cl"] - $zakaz['paid_dor'];
    if ($pay_need < 0) $pay_need = 0;

    if ($pay_need > 0 && $status == "Ваша работа готова") $status = "Оплатите остаток, чтобы скачать полную версию работы";

    switch ($status) {
        case "Ожидаем предоплату":
            $color = "#CCFF66";
            $proc = "10";
            break;
        case "Оплатите остаток":
            $color = "#CCFF66";
            $proc = "90";
            break;
        case "Мы пишем вашу работу":
            $color = "#99FF99";
            $proc = "30";
            break;
        case "Ваша работа готова":
            $color = "#009900";
            $proc = "100";
            break;
        default:
            $proc = "0";
            $color = "#CCFF66";
            break;
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="progress">
                <div role="progressbar" aria-valuenow="<?= $proc ?>" aria-valuemin="0" aria-valuemax="100"
                     style="width:<?= $proc ?>%" class="progress-bar progress-bar-success"></div>
                <div class="progress-percent"><?= $status ?></div>
            </div>
        </div>
    </div>


<?php }
if ($a2 == "file_add") {
    $file_names = $_FILES;
    $filesCount = count($file_names['userfile']['tmp_name']);
    $files = [];
    for ($i = 0; $i < $filesCount; $i++) {
        $files['file_' . $i] = [
            'tmp_name' => $file_names['userfile']['tmp_name'][$i],
            'name' => $file_names['userfile']['name'][$i]
        ];
    }

    $orderAttachment = $orderApi->setAttachment([
        'id' => $zakaz['id'],
        'filesCount' => $filesCount
    ], $files);

    $saveAttachment = $orderApi->setOrderAttach([
        'id' => $zakaz['id'],
        'file' => $orderAttachment['data']
    ]);

    if ($saveAttachment['code'] == 200) {
        $_SESSION['file_added'] = true;
    }
    echo '<style>* {display: none}</style>';
    echo laz_meta("/cabinet/open/$zakaz[id_for_client]?a2=show_file", 0);
    die();
} else if ($a2 == "show_file") {
    $active[2]['tab'] = "active";
    $active[2]['cont'] = " in active";
} else if ($a2 == "show_comments" || $a2 == "show_old" || $a2 == "hide_old") {
    $active[3]['tab'] = "active";
    $active[3]['cont'] = " in active";
} else {
    $active[1]['tab'] = "active";
    $active[1]['cont'] = " in active";
}

$commentApi = new CommentClient();

$comment = $commentApi->countNoRead([
    'id' => $id
]);;
$garantyTextTmp = $user_data['valuta'] == 1 ? $GenSettings->garantyTextUA() : $GenSettings->garantyTextRU();
$garantyText = $garantyTextTmp['value'];
?>

<div class="row">
    <div class="col-md-12">
        <div class="cabinet-tabs">
            <ul class="nav nav-tabs">
                <li class="<?= $active[1]['tab'] ?>">
                    <a data-toggle="tab" href="#tab1">
                        <span>Информация о заказе и оплата</span>
                    </a>
                </li>
                <li class="<?= $active[2]['tab'] ?>">
                    <a data-toggle="tab" href="#tab2"
                       onclick="mark_as_read('<?= $zakaz['id'] ?>')">
                        <span>Файлы</span><?php
                        if ($zakaz['client_event_plan'] > 0) $f_ev += $zakaz['client_event_plan'];
                        if ($zakaz['client_event_anti'] > 0) $f_ev += $zakaz['client_event_anti'];
                        if ($f_ev > 0) echo "<div class='checker' id='mark_as_read'>$f_ev</div>";
                        ?>
                    </a>
                </li>
                <li class="<?= $active[3]['tab'] ?>">
                    <a data-toggle="tab" href="#tab3"
                       onclick="mark_as_read_sms('<?= $zakaz['id'] ?>')">
                        <span>Чат</span><?php
                        $unread_comments = $comment['data'];
                        if ($unread_comments > 0) echo "<div class='checker' id='mark_as_read_sms'>$unread_comments</div>"; ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content">

                <div id="tab1" class="tab-pane fade in <?= $active[1]['cont'] ?>">
                    <div class="tab-wrap">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="back-to-orders">
                                    <a href="/cabinet/">
                                        <span class="fa fa-reply"></span>
                                        К
                                        списку заказов
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-7 mb-30">
                                <div class="row">
                                    <div class="col-md-12 mb-20 clearfix">
                                        <div class="info-title">
                                            <h3>Информация о заказе</h3>
                                        </div>
                                        <div class="edit-cancel-buttons">

                                        </div>
                                    </div>
                                </div>
                                <div class="table-wrap">
                                    <table class="table cabinet-table">
                                        <tbody>
                                        <tr>
                                            <td>Номер заказа</td>
                                            <td><?= $zakaz['id_for_client'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Тип заказа</td>
                                            <td><?= $zakaz['type'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Предмет</td>
                                            <td><?= $zakaz['special'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Тема работы</td>
                                            <td><?= iconv('WINDOWS-1251', 'UTF-8', base64_decode($zakaz['tema'])) ?></td>
                                        </tr>
                                        <?php
                                        if ($zakaz['original'] > 0) echo "
											<tr>
												<td>Оригинальность работы</td>
												<td>$zakaz[original] %</td>
											</tr>	
											";
                                        ?>
                                        <tr>
                                            <td>Дата подачи заявки</td>
                                            <td><?= date("Y/m/d H:i", $zakaz['date_start']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Дата сдачи работы</td>
                                            <td><?= date("Y/m/d H:i", $zakaz['date_end']) ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-5 mb-30">
                                <div class="row">
                                    <div class="col-md-12 mb-20 clearfix">
                                        <div class="finances-title">
                                            <h3>Финансы</h3>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($zakaz['cena_skidka'] > 0) { ?>
                                    <div class="table-wrap mb-30">
                                        <table class="table cabinet-table">
                                            <tbody>
                                            <tr>
                                                <td>Стоимость заказа:
                                                    <br>
                                                    (с учетом скидки)
                                                </td>
                                                <td><?= number_format($zakaz['cena_skidka'], 0, ',', ' ') ?> <?= $valuta ?></td>
                                            </tr>
                                            <?php if ($zakaz['cena_skidka'] != $zakaz['cena_original']) { ?>
                                                <tr>
                                                    <td>Оригинальная цена:</td>
                                                    <td><?= number_format($zakaz['cena_original'], 0, ',', ' ') ?> <?= $valuta ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Скидка:</td>
                                                    <td><?= number_format($zakaz['cena_original'] - $zakaz['cena_skidka'], 0, ',', ' ') ?> <?= $valuta ?></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if ($zakaz["penya_to_system"] > 0) { ?>
                                                <tr>
                                                    <td>Скидка за задержку:</td>
                                                    <td><?= number_format($zakaz['penya_to_system'], 0, ',', ' ') ?> <?= $valuta ?></td>
                                                </tr>
                                                <?php
                                                $pay_need -= $zakaz["penya_to_system"];
                                                if ($pay_need < 0) $pay_need = 0;
                                            } ?>

                                            <?php


                                            foreach ($zakaz['rework'] as $rework) {
                                                if ($rework['amount_client'] > 0) {
                                                    $zakaz["cena_d_cl"] += $rework['amount_client'];
                                                    $zakaz["paid_dor"] += $rework['paid_client'];
                                                    $pay_need += $rework['amount_client'] - $rework['paid_client'];
                                                }
                                            }

                                            ?>

                                            <?php if ($zakaz["cena_d_cl"] > 0) { ?>
                                                <tr>
                                                    <td>Стоимость дополнений:</td>
                                                    <td><?= number_format($zakaz['cena_d_cl'], 0, ',', ' ') ?> <?= $valuta ?></td>
                                                </tr>
                                            <?php } ?>

                                            <tr>
                                                <td>Заплачено:</td>
                                                <td><?= number_format($paid + $zakaz["paid_dor"], 0, ',', ' ') ?> <?= $valuta ?></td>
                                            </tr>
                                            <tr>
                                                <td>Осталось заплатить:</td>
                                                <?php if ($pay_need < 0) $pay_need = 0; ?>
                                                <td><?= number_format($pay_need, 0, ',', ' ') ?> <?= $valuta ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php if ($zakaz['status'] < 8) { ?>

                                        <?php if ($zakaz['pay_predoplata'] != 1 && $zakaz['pay_client'] != 1 && $zakaz['status'] != 6) {
                                            $show_pay_via_ref = true;
                                            ?>
                                            <div class="form-group clearfix">
                                                <button type="submit" class="button pay-button options"
                                                        style='width: 100%; margin:0;' href="#laz-popup"
                                                        onclick='load_form("Предоплата","lets_pay_pre",<?= $zakaz['id'] ?>)'>
                                                    Заплатить предоплату
                                                </button>
                                            </div>

                                        <?php } ?>

                                        <?php if ($zakaz['pay_predoplata'] != 1 && $zakaz['pay_client'] != 1 && $zakaz['status'] <= 6 && $zakaz['cena_skidka'] > 0) { ?>
                                            <?php if (strlen($zakaz['promo_code']) < 2) { ?>
                                                <div class="form-group clearfix">
                                                    <button type="submit" class="button pay-button options "
                                                            style='width: 100%; margin:0;' href="#laz-popup"
                                                            onclick='load_form("Промокод","get_promo_form",<?= $zakaz['id'] ?>)'>
                                                        Ввести промокод
                                                    </button>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if ($zakaz['status'] == 6 && $zakaz['pay_client'] != 1) {
                                            $show_pay_via_ref = true; ?>
                                            <div class="form-group clearfix">
                                                <button type="submit" class="button pay-button options"
                                                        style='width: 100%; margin:0;' href="#laz-popup"
                                                        onclick='load_form("Оплата за работу","lets_pay",<?= $zakaz['id'] ?>)'>
                                                    Заплатить
                                                </button>
                                            </div>
                                        <?php } ?>

                                        <?php if ($zakaz['pay_client'] != 1 && $zakaz['cena_skidka'] > 0 && false) { ?>
                                            <div class="form-group clearfix">
                                                <button type="submit" class="button pay-button options"
                                                        style='width: 100%; margin:0;' href="#laz-popup"
                                                        onclick='load_form("Уменьшить цену","lets_pay_ref",<?= $zakaz['id'] ?>)'>
                                                    Уменьшить цену
                                                </button>
                                            </div>
                                        <?php } ?>

                                        <?php
                                        foreach ($zakaz['rework'] as $rework) {
                                            //NEW DORS
                                            if ($rework['amount_client'] > 0) {
                                                $reworkBalance = $rework['amount_client'] - $rework['paid_client'];
                                                if ($reworkBalance > 0) {
                                                    ?>
                                                    <div class="form-group clearfix">
                                                        <button type="submit" class="button pay-button options rework"
                                                                style='width: 100%; margin:0;' href="#laz-popup"
                                                                onclick='load_form("Оплата за доработки","lets_pay_dor","<?= $zakaz['id'] ?>&dorID=<?= $rework['id'] ?>")'>
                                                            Заплатить за доработки
                                                            - <?= number_format($reworkBalance, 2) ?>
                                                        </button>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="table-wrap mb-30">
                                        <table class="table cabinet-table">
                                            <tbody>
                                            <tr>
                                                <td>Стоимость заказа:</td>
                                                <td>Пожалуйста, подождите</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>
                                <?php if ((strlen($zakaz['code_preview']) > 32 || strlen($zakaz['code_full']) > 32) && $zakaz['status'] > 5 && $zakaz['status'] < 8) { ?>
                                    <?php if ($zakaz['pay_client'] == 1 && $pay_need <= 0 || 1) { ?>
                                        <?php if ($zakaz['ocenka_done'] != 1) { ?>
                                            <div class="form-group clearfix">
                                                <button type="submit" class="button pay-button options"
                                                        style='width: 100%; margin:0;' href="#laz-popup"
                                                        onclick='load_form("Оценить заказ","rating",<?= $zakaz['id'] ?>)'>
                                                    Оценить заказ
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group clearfix">
                                                <button type="submit" class="button pay-button options"
                                                        style='width: 100%; margin:0;' href="#laz-popup"
                                                        onclick='load_form("Изменить оценку","edit_rating",<?= $zakaz['id'] ?>)'>
                                                    Изменить оценку
                                                </button>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($zakaz['pay_predoplata']) { ?>
                                    <div class="text-center">
                                        <span class="init-tooltip pointer" title="<?= nl2br($garantyText) ?>"
                                              data-placement="top" data-toggle="modal" data-target="#garantyModal">Условия гарантийного срока <i
                                                    class="fa fa-question-circle"></i></span>
                                    </div>
                                    <div id="garantyModal" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Условия гарантийного срока</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?= nl2br($garantyText) ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Закрыть
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function () {
                                            $('.init-tooltip').tooltip({html: true});
                                        });
                                    </script>
                                    <style>
                                        .tooltip-inner {
                                            max-width: 350px;
                                        }
                                    </style>
                                <?php } ?>


                            </div>
                            <div class="col-md-12">
                                <div class="more-info">
                                    <p>
                                        <strong>Подробная
                                            информация:
                                        </strong>
                                        <br><?= nl2br(show_good(iconv('WINDOWS-1251', 'UTF-8', base64_decode($zakaz['podrobnosti'])))) ?>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class='row' hidden>
                        <div class="finances-title pre_files col-md-12 md-20">
                            <h3>Ваши файлы</h3>
                        </div>
                    </div>
                </div>

                <div id="tab2" class="tab-pane fade <?= $active[2]['cont'] ?>">
                    <div class="files-wrap">
                        <div class="row">
                            <?php if ($_SESSION['file_added']) {
                                unset($_SESSION['file_added']); ?>
                                <?php if (strlen($_SESSION['upload_file_wf']) > 0) {
                                    echo $_SESSION['upload_file_wf'];
                                    unset($_SESSION['upload_file_wf']);
                                } else { ?>
                                    <div class='alert alert-success'>
                                        Действие выполнено успешно.
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <div class="col-md-12">
                                <?php


                                if ($notif['notifPaidFull'] == 1) {
                                    $orderApi->notifRead([
                                        'id' => $zakaz['id_for_client']
                                    ]);
                                    echo '<div class="alert alert-info alert-dismissible" role="alert">Спасибо, мы получили вашу оплату! Теперь вам доступна полная версия работы в данном разделе.</div>';
                                }
                                ?>
                            </div>

                            <div class="col-md-6">
                                <div class="block-title">
                                    <h3>Файлы загруженные автором</h3>
                                </div>
                                <div class="files-loaded files-item">
                                    <div class="all-files">
                                        <?php if (($zakaz['pay_predoplata'] == 1 || $zakaz['pay_client'] == 1) && $zakaz['status'] > 0 && strlen($zakaz['plan_link']) > 3 && $zakaz['status'] < 8) {
                                            $plan_is = true; ?>
                                            <div class="file">
                                                <a href="https://kabinetavtora.com/preview.php?id=<?= $zakaz['id_for_client'] ?>&key=<?= $zakaz['plan_key'] ?>&type=plan&a=download"
                                                   class="link" target='_blank'>
                                                    <div class="title">Файл план работы
                                                    </div> <?= (($zakaz['file_date_plan'] > 0) ? date("H:i:s d/m/Y", $zakaz['file_date_plan']) : "") ?>
                                                </a>
                                            </div>
                                        <?php } ?>

                                        <?php if (strlen($zakaz['antiplagiat']) > 3 && ($zakaz['pay_client'] == 1 && $pay_need <= 0) && $zakaz['status'] > 5 && $zakaz['status'] < 8) {
                                            $plan_is = true; ?>
                                            <div class="file">
                                                <a href="https://kabinetavtora.com/preview.php?id=<?= $zakaz['id_for_client'] ?>&key=<?= $zakaz['anti_key'] ?>&type=anti&a=download"
                                                   class="link" target='_blank'>
                                                    <div class="title">Файл антиплагиата
                                                    </div> <?= (($zakaz['file_date_anti'] > 0) ? date("H:i:s d/m/Y", $zakaz['file_date_anti']) : "") ?>
                                                </a>
                                            </div>
                                        <?php } ?>

                                        <?php if ((strlen($zakaz['code_preview']) > 32 || strlen($zakaz['code_full']) > 32) && $zakaz['status'] > 5 && $zakaz['status'] < 8) { ?>
                                            <?php if ($zakaz['pay_client'] == 1 && $pay_need <= 0) { ?>
                                                <div class="file">
                                                    <a href="https://kabinetavtora.com/preview.php?id=<?= $zakaz['id_for_client'] ?>&key=<?= $zakaz['code_full'] ?>&type=full&a=download"
                                                       target="_blank" class="link">
                                                        <div class="title">Готовая работа
                                                        </div> <?= (($zakaz['file_date_full'] > 0) ? date("H:i:s d/m/Y", $zakaz['file_date_full']) : "") ?>
                                                    </a>
                                                </div>
                                            <?php } else {
                                                $show_pre_text = true;
                                                ?>
                                                <div class="file">
                                                    <a href="https://kabinetavtora.com/preview.php?id=<?= $zakaz['id_for_client'] ?>&key=<?= $zakaz['code_preview'] ?>&a=download"
                                                       target="_blank" class="link">
                                                        <div class="title">Превью работы
                                                        </div> <?= (($zakaz['file_date_full'] > 0) ? date("H:i:s d/m/Y", $zakaz['file_date_full']) : "") ?>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        <?php } else if ($plan_is != true) { ?>
                                            <div class="file">
                                                <div class="title">
                                                    <p><b>Нет файлов.</b></p>
                                                </div>
                                            </div>
                                        <?php } ?>


                                    </div>
                                    <?php if ($show_pre_text) { ?>
                                        <div class="files-loaded-info">
                                            <p>Полная версия работы доступна после полной оплаты</p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="block-title">
                                    <h3>Ваши файлы</h3>
                                </div>
                                <div class="your-files files-item">
                                    <table class="table your-files-table">
                                        <tbody>
                                        <?php

                                        $n = 0;
                                        $files_d = explode(",", base64_decode($zakaz['file_data']));
                                        for ($i = 0; $i < count($files_d); $i++) if (strlen($files_d[$i]) > 0) {
                                            $n++;
                                            $tmp_link_arr = explode("/", $files_d[$i]);

                                            $tmp_link__ = end($tmp_link_arr);


                                            $tmp_link_ = explode(".", $tmp_link__);
                                            $tmp_link = $tmp_link_[0];
                                            $ext = end($tmp_link_);

                                            if ($tmp_link_arr[2] == $_SERVER['HTTP_HOST']) {
                                                $f_time = filemtime($dir_name . "ups/" . $tmp_link__);
                                                $f_time++;
                                                $f_time--;
                                                echo "<tr><td><a href='$files_d[$i]' target='_blank' class='file-link'>Файл $n.$ext</a> </td><td>" . date("H:i:s d/m/Y", $f_time) . "</td>";
                                            } else
                                                echo "<tr><td><a href='$files_d[$i]' target='_blank' class='file-link'>Файл $n.$ext</a> </td><td></td>";
                                            // echo"<td>".date("H:i:s",$f_time)."</td>";
                                            // echo"<td>".date("d/m/Y",$f_time)."</td>";
                                            echo "</tr>";
                                        }
                                        if ($n == 0) echo "<tr><td>Нет файлов.</td></tr>";
                                        ?>
                                        </tbody>
                                    </table>
                                    <form id='file_form' method='POST'
                                          action='/cabinet/add-file/<?= $zakaz['id_for_client'] ?>'
                                          enctype='multipart/form-data'>
                                        <div class="form-group add-files">
                                            <div data-provides="fileupload" class="fileupload fileupload-new">
												<span class="btn btn-file"><span
                                                            class="fileupload-new">Добавить файл</span><span
                                                            class="fileupload-exists">Загрузка файла...</span>
												<input type="file" name="userfile[]" id='file_val'
                                                       onchange="do_count_files();" multiple></span>
                                                <span id='file_c'
                                                      style='font-size: 10px;'></span>
                                            </div>
                                        </div>
                                        <div class="form-group text-center" style='padding-top: 10px;'>
                                            <input type='submit' value='Отправить' class='btn btn-success'>

                                        </div>
                                    </form>
                                    <script>
                                        function check_file_name(name) {
                                            if (name.length > 0) $('#file_form').submit()
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="tab3" class="tab-pane fade <?= $active[3]['cont'] ?>">
                    <div class="messages-wrap">
                        <div class="row">
                            <?php if ($_SESSION['comm_added']) {
                                unset($_SESSION['comm_added']); ?>
                                <div class='alert alert-success'>
                                    Действие выполнено успешно.
                                </div>
                            <?php } ?>
                            <?php if ($_SESSION['comm_short']) {
                                unset($_SESSION['comm_short']); ?>
                                <div class='alert alert-danger'>
                                    Слишком короткое сообщение
                                </div>
                            <?php } ?>

                            <?php

                            $comment = $commentApi->countAllComment([
                                'id' => $zakaz['id']
                            ]);

                            $comm_a_c = $comment['data'];
                            if ($comm_a_c > 10) {
                                ?>
                                <?php if ($a2 == "show_old") { ?>
                                    <a href='/cabinet/open/<?= $zakaz['id_for_client'] ?>?a2=hide_old'>
                                        <div class='alert alert-info'>
                                            Скрыть старые сообщения
                                        </div>
                                    </a>
                                <?php } else { ?>
                                    <a href='/cabinet/open/<?= $zakaz['id_for_client'] ?>?a2=show_old'>
                                        <div class='alert alert-info'>
                                            Показать старые сообщения
                                        </div>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                            <div class="col-md-12">
                                <?php

                                //comments
                                if ($a2 == "show_old") {
                                    $show_old = $commentApi->show_old([
                                        'id' => $zakaz['id'],
                                        'limit' => 100
                                    ]);
                                } else {
                                    $show_old = $commentApi->show_old([
                                        'id' => $zakaz['id'],
                                        'limit' => 10
                                    ]);
                                }


                                $comm_a = $show_old['data'];


                                if (count($comm_a) == 0) {
                                    $comment_author = "<div align='center'>Нет сообщений</div>";
                                } else {

                                    $old_d = 0;
                                    $comment_author = "";
                                    $types[1] = "users";
                                    $types[2] = "guests";
                                    $types[3] = "Менеджер";
                                    $types[4] = "Менеджер";
                                    for ($i = count($comm_a) - 1; $i >= 0; $i--) {
                                        if ($old_d != date('j', $comm_a[$i]['time'])) {

                                            $old_d = date('j', $comm_a[$i]['time']);
                                        }
                                        $type = $comm_a[$i]['from_type'];
                                        $type = $types[$type];
                                        if ($comm_a[$i]['from_type'] == 3 || $comm_a[$i]['from_type'] == 4) {
                                            if ($comm_a[$i]['from_client'] == 1) $type = "Автор";

                                            $fileLinks = '';
                                            if ($comm_a[$i]['files']) {
                                                $n = 0;
                                                $file_names = explode(',', $comm_a[$i]['files']);
                                                foreach ($file_names as $this_link) {
                                                    $n++;
                                                    $fileLinks .= "<div class='files-list'><a href='$this_link' target='_blank'><i class='fa fa-cloud-download fa-lg'></i><span>Файл $n</span></a></div>";
                                                }
                                            }
                                            $comment_author .= "
			<div class='message-item'>
				<div class='message-info clearfix'>
					<div class='name'>$type</div>
					<div class='time'>" . date('H:i:s', $comm_a[$i]['time']) . "</div>
					<div class='date'>" . date('j.m.Y', $comm_a[$i]['time']) . "</div>
				</div>
			
				<div class='row'>
					<div class='col-md-12'>
						<div class='avatar'><img src='" . NA5KU_PLUGIN_DIR_URL . "cabinet/cabinet/img/author-avatar.png' alt='avatar'></div>
						<div class='text'>
						<p>" . show_good(nl2br(iconv('WINDOWS-1251', 'UTF-8', base64_decode($comm_a[$i]['comment'])))) . $fileLinks . "</p>
						</div>

					</div>
				</div>
			</div>
			";
                                        } else {
                                            if ($comm_a[$i]['is_moder'] == 1) {
                                                $st_add = "style='background: #d4f1b7'";
                                                $d_add = "Работа отправлена на доработку - ";
                                            } else {
                                                $st_add = "";
                                                $d_add = "";
                                            }

                                            $fileLinks = '';
                                            if ($comm_a[$i]['files']) {
                                                $n = 0;
                                                $file_names = explode(',', $comm_a[$i]['files']);
                                                foreach ($file_names as $this_link) {
                                                    $n++;
                                                    $fileLinks .= "<div class='files-list'><a href='$this_link' target='_blank'><i class='fa fa-cloud-download fa-lg'></i><span>Файл $n</span></a></div>";
                                                }
                                            }
                                            $comment_author .= "
			<div class='message-item author-item'>
				<div class='message-info clearfix'>
					<div class='name'>Вы</div>
					<div class='time'>" . date('H:i:s', $comm_a[$i]['time']) . "</div>
					<div class='date'>$d_add " . date('j.m.Y', $comm_a[$i]['time']) . "</div>
				</div>
			
				<div class='row'>
					<div class='col-md-12'>
						<div class='avatar'><img src='" . NA5KU_PLUGIN_DIR_URL . "cabinet/cabinet/img/author-avatar.png' alt='avatar'></div>
						<div class='text'>
						
						
						<p>" . show_good(nl2br(iconv('WINDOWS-1251', 'UTF-8', base64_decode($comm_a[$i]['comment'])))) . $fileLinks . "</p>
						</div>
					</div>
				</div>
			</div>
			";
                                        }
                                    }
                                    $comment_author .= "";
                                }
                                echo "$comment_author";
                                ?>

                            </div>
                        </div>
                        <div class="row">
                            <form class="add-message-form" enctype='multipart/form-data' action='/cabinet/comment.do'
                                  method='post'>
                                <input value="<?= $zakaz['id'] ?>" hidden name="id">
                                <input name="action3" hidden value="Добавить комментарий клиенту">
                                <div class="col-md-9">
                                    <div class="form-group clearfix mb-xs-15">
                                        <textarea id="message" name="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group clearfix">
                                        <button type="submit" class="button send-button">Отправить</button>
                                    </div>
                                    <div class="form-group add-files clearfix">
                                        <div data-provides="fileupload" class="fileupload fileupload-new"><span
                                                    class="btn btn-file"><span
                                                        class="fileupload-new">Добавить файл</span><span
                                                        class="fileupload-exists">Изменить файл</span>
											<input type="file" name="files[]" multiple>
											</span>
                                            <span class="fileupload-preview"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .fa-reply:after {
        content: '\00a0'
    }

    .file .title {


        color: #3b98db;
        font-size: 16px;
        text-decoration: underline;
        font-family: "RobotoLight", sans-serif;
        line-height: 33px;
        display: block;
        padding-left: 35px;


    }
</style>
<script>
    function load_can_form(id) {
        $("#l-p-title").html("Отменить заказ");
        $("#l-p-loading").html("");
        $("#l-p-text").html("<div class='alert alert-warning'>Вы действительно хотите отменить заказ?</div><input value='<?=$zakaz['id']?>' hidden name='id'><input name='action' hidden value='cancel_zakaz'>");
        $("#l-p-submit").show();
    }

    function load_uncan_form(id) {
        $("#l-p-title").html("Открыть заказ");
        $("#l-p-loading").html("");
        $("#l-p-text").html("<div class='alert alert-warning'>Вы действительно хотите вновь открыть заказ?</div><input value='<?=$zakaz['id']?>' hidden name='id'><input name='action' hidden value='uncancel_zakaz'>");
        $("#l-p-submit").show();
    }

    function load_files_tab() {
        // return true;
        $.ajax({
            type: "GET",
            url: "/cabinet/action.do?a2=mark_as_read&id=" + id,
            success: function (data) {
                $("#mark_as_read").hide();
            }
        });
    }

    function mark_as_read(id) {
        // return true;
        $.ajax({
            type: "GET",
            url: "/cabinet/action.do?a2=mark_as_read&id=" + id,
            success: function (data) {
                $("#mark_as_read").hide();
            }
        });

    }

    function mark_as_read_sms(id) {
        return true;
        $.ajax({
            type: "GET",
            url: "/cabinet/action.do?a2=mark_as_read_sms&id=" + id,
            success: function (data) {

                $("#mark_as_read_sms").hide();

            }
        });
    }

</script>
