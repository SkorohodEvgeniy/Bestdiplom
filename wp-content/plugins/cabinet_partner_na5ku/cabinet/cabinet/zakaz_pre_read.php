<?php

$premoderationAPI = new Premoderation();
$id = $_GET['id'];
$get = $premoderationAPI->getOne([
    'id' => $id
]);


//$q="select * from `zakaz_forma` where `id`='$id'";
//$zakaz=baza_do_one($q);
$not_for_me = false;
$zakaz = $get['data'];
if ($zakaz['client_id'] != $user_data['id']) {
    $not_for_me = true;
}
if ($zakaz['status'] != 1) $not_for_me = true;
if ($not_for_me)
    die('<meta http-equiv="refresh" content="0; url=/cabinet/">');


//echo "<pre>";
//die(var_dump($zakaz));
//echo "</pre>";

//$q="Select * From `zakaz_types` where `id`='$zakaz[z_t]'";
//$type=baza_do_one($q);
$type = $zakaz['type']['type'];
$zakaz['z_t'] = iconv('UTF-8', 'WINDOWS-1251', $type);
$zakaz['date_start']++;
$zakaz['date_start']--;
$zakaz['srok']++;
$zakaz['srok']--;

if ($zakaz['valuta'] == 1) $valuta = "UAH";
else if ($zakaz['valuta'] == 3) $valuta = "USD";
else $valuta = "RUB";

$zakaz['show_price_after']++;
$zakaz['show_price_after']--;
$zakaz['show_skidka']++;
$zakaz['show_skidka']--;
$zakaz['show_procent']++;
$zakaz['show_procent']--;
?>
<div class="row">
    <div class="col-md-12">
        <div class="cabinet-tabs">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab1"><span>Информация о заказе</span></a></li>
            </ul>
            <div class="tab-content">
                <div id="tab1" class="tab-pane fade in active">
                    <div class="tab-wrap">
                        <div class='row'>
                            <?php
                            if (isset($_SESSION['pre_edit_m'])) {
                                echo $_SESSION['pre_edit_m'];
                            }
                            if (isset($_SESSION['upload_file_wf'])) {
                                echo $_SESSION['upload_file_wf'];
                            }
                            if (isset($_SESSION['pre_edit_m'])) {
                                unset($_SESSION['pre_edit_m']);
                            }
                            if (isset($_SESSION['upload_file_wf'])) {
                                unset($_SESSION['upload_file_wf']);
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="back-to-orders"><a href="/cabinet/"><span class="fa fa-reply"></span>К
                                        списку заказов</a></div>
                            </div>

                            <div class="col-md-7 mb-30">
                                <div class="row">
                                    <div class="col-md-12 mb-20 clearfix">
                                        <div class="info-title">
                                            <h3>Информация о заказе</h3>
                                        </div>
                                        <div class="edit-cancel-buttons">
                                            <!--											<a class="button edit-button" href='/cabinet/edit/zakaz--->
                                            <? //=$id?><!--'>Редактировать</a>-->
                                            <a class="button cancel-button options" href="#laz-popup"
                                               onclick="load_del_form(<?= $id ?>)">Удалить</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-wrap">
                                    <table class="table cabinet-table">
                                        <tbody>
                                        <tr>
                                            <td>Тип заказа</td>
                                            <td><?= $type ?></td>
                                        </tr>
                                        <tr>
                                            <td>Тема работы</td>
                                            <td><?= iconv('Windows-1251', 'UTF-8', base64_decode($zakaz['theme'])) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Количество страниц</td>
                                            <td><?= $zakaz['pages'] ?></td>
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
                                            <td>Дача подачи заявки</td>
                                            <td><?= date("Y/m/d H:i", $zakaz['date_start']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Дата сдачи работы</td>
                                            <td><?= date("Y/m/d H:i", $zakaz['srok']) ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-5 mb-30">
                                <div class="row">
                                    <div class="col-md-12 mb-30 clearfix">
                                        <div class="finances-title">
                                            <h3>Финансы</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-wrap mb-30">
                                    <table class="table cabinet-table">
                                        <tbody>
                                        <tr>
                                            <td>Ориентировочная стоимость заказа<br>(с учетом скидки)</td>
                                            <td><?= number_format($zakaz['show_price_after'], 0, ',', ' ') ?> <?= $valuta ?></td>
                                        </tr>
                                        <tr>
                                            <td>Ориентировочная скидка</td>
                                            <td><?= number_format($zakaz['show_skidka'], 0, ',', ' ') ?> <?= $valuta ?></td>
                                        </tr>
                                        <tr>
                                            <td>Процент скидки</td>
                                            <td><?= number_format($zakaz['show_procent'], 0, ',', ' ') ?> %</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="more-info">
                                    <p><strong>Подробная
                                            информация: </strong><br><?= iconv('Windows-1251', 'UTF-8', nl2br(show_good(base64_decode($zakaz['commnets'])))) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="finances-title pre_files col-md-12 md-20">
                            <h3>Ваши файлы</h3>
                        </div>
                    </div>
                    <div class="files-wrap">
                        <div class="row">
                            <div class="your-files files-item">
                                <table class="table your-files-table">
                                    <tbody>
                                    <?php

                                    $n = 0;
                                    $tmp_link__ = '';
                                    $tmp_link_ = '';
                                    $tmp_link_ = '';
                                    $ext = '';

                                    $files_d = explode(",", $zakaz['file_link']);
                                    for ($i = 0; $i < count($files_d); $i++) if (strlen($files_d[$i]) > 0) {
                                        $n++;
                                        $tmp_link__ = end(explode("/", $files_d[$i]));
                                        $tmp_link_ = explode(".", $tmp_link__);
                                        $tmp_link = $tmp_link_[0];
                                        $ext = end($tmp_link_);

                                        echo "<tr><td><a href='$files_d[$i]' target='_blank' class='file-link'>Файл $n.$ext</a></td></tr>";
                                    }
                                    if ($n == 0) echo "<tr><td>Нет файлов.</td></tr>";
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function load_del_form(id) {
        $("#l-p-title").html("Удалить заказ");
        $("#l-p-loading").html("");
        $("#l-p-text").html("<div class='alert alert-warning'>Вы действительно хотите удалить заказ?</div><input value='<?=$id?>' hidden name='id'><input name='action' hidden value='del_pre_zakaz'>");
        $("#l-p-submit").show();
    }
</script>
<style>
    .fa-reply:after {
        content: '\00a0'
    }
</style>	
