<?php


$q = "select * from `zakaz_forma` where `id`='$id'";
$zakaz = baza_do_one($q);
if ($zakaz['client_id'] != $user_data['id']) {
    $not_for_me = true;
}
if ($zakaz['status'] != 1) $not_for_me = true;
if ($not_for_me) {

    die('<meta http-equiv="refresh" content="0; url=/cabinet/">');
}


$type = "";
$query = "select * From `zakaz_types` where `active`='1'";
$types = baza_do($query);
for ($i = 0; $i < count($types); $i++) {
    $this_t = $types[$i];
    $type_ids[] = $this_t['id'];
    if ($zakaz['z_t'] == $this_t['id']) $selected = "selected"; else $selected = "";
    $type .= "<option value='$this_t[id]' $selected>" . iconv('UTF-8', 'WINDOWS-1251', $this_t['type']) . "</option>";

}


$zakaz['date_start']++;
$zakaz['date_start']--;
$zakaz['srok']++;
$zakaz['srok']--;


if ($zakaz['valuta'] == 1) $valuta = "���.";
else $valuta = "���.";


$zakaz['show_price_after']++;
$zakaz['show_price_after']--;
$zakaz['show_skidka']++;
$zakaz['show_skidka']--;
$zakaz['show_procent']++;
$zakaz['show_procent']--;


if ($a3 == "do") {

    $theme = post($_POST["theme"]);
    $new_type = (int)post($_POST["new_type"]);
    $new_pages = (int)post($_POST["pages"]);
    $new_date = post($_POST["new_date"]);
    $original = (int)post($_POST["original"]);
    $commnets = base64_encode(post($_POST["commnets"]));
    if ($new_pages < 1 || $new_pages > 150) $new_pages = 1;

    if ($original < 0) $original = 0;
    if ($original > 100) $original = 100;
    $original = 0;


    $q = "update `zakaz_forma` set `z_t`='$new_type',`pages`='$new_pages',`original`='$original',`commnets`='$commnets' where `id`='$id'";
    baza_do_only($q);

    if (strlen($theme) > 4) {
        $theme = base64_encode($theme);
        $q = "update `zakaz_forma` set `theme`='$theme' where `id`='$id'";
        baza_do_only($q);
    } else {
        $_SESSION['pre_edit_m'] .= "<div class='alert alert-danger'>������� �������� ����</div>";
    }

    if (strlen($new_date) < 5) {
        $_SESSION['pre_edit_m'] .= "<div class='alert alert-danger'>������� ����</div>";
    } else {

        list($year, $month, $day_) = explode('/', $new_date);
        list($day, $hour_) = explode(' ', $day_);
        list($hour, $min) = explode(':', $hour_);
        $srok_tmp = mktime($hour, $min, 0, $month, $day, $year);
        if ($srok_tmp < time() + 6 * 60 * 60) $srok_tmp = time() + 6 * 60 * 60;
        $q = "update `zakaz_forma` set `srok`='$srok_tmp' where `id`='$id'";
        baza_do_only($q);
    }


    $files_to_delete = $_POST['pre_uploaded_files_delete'];
    $files_to_delete[] = "";
    $files_to_delete[] = "";
    $new_files = "";
    $files_d = explode(",", $zakaz['file_link']);
    for ($i = 0; $i < count($files_d); $i++) if (strlen($files_d[$i]) > 4) {

        $tmp_link = end(explode("/", $files_d[$i]));


        if (in_array($tmp_link, $files_to_delete)) {
            $tmp_link = $dir_name . "/ups/$tmp_link";

            $f = fopen($tmp_link, "a+");
            fclose($f);
            unlink($tmp_link);
        } else {
            $new_files .= ",$files_d[$i]";
        }
    }
    $file_up = upload_file("files");
    for ($i = 0; $i < count($file_up); $i++)
        if (strlen($file_up[$i]) > 0) $new_files .= ",$file_up[$i]";

    if ($new_files != $zakaz['file_link']) {
        $q = "update `zakaz_forma` set `file_link`='$new_files' where `id`='$id'";
        baza_do_only($q);
    }


    //after save changes
    $q = "select * From `zakaz_forma` where `id`='$id'";
    $zakaz = baza_do_one($q);
    $type = $zakaz['z_t'];

    $q = "select * from `zakaz_types` where `id`='$type'";
    $type_info = baza_do_one($q);

    $pages = $zakaz['pages'];

    $sel_c_pr = ($pages / $type_info['st_ob'] - 1) * $type_info['pr_ob'];
    if ($sel_c_pr < 0) $sel_c_pr = 0;

    $days = ($zakaz['srok'] - mktime(0, 0, 0, date("m"), date("d"), date("Y"))) / (24 * 60 * 60);
    $days = round($days);
    $sel_d_pr = (1 - $days / $type_info['st_sr']) * $type_info['pr_spex'];

    if ($sel_d_pr < 0) $sel_d_pr = 0;
    if ($days == 0) {
        $sel_d_pr = 0;
    }
    $nadb = $sel_c_pr + $sel_d_pr;

    if ($nadb > $type_info['pr_max_nadb']) $nadb = $type_info['pr_max_nadb'];

    $price_original = $type_info['pr_original'] + $nadb;

    $calc = (int)post($_POST['calc']);
    $show_procent = (int)post($_POST['show_procent']);
    $show_skidka = (int)post($_POST['show_skidka']);

    $q = "update `zakaz_forma` set `show_price`='$price_original',`show_procent`='$show_procent',`show_skidka`='$show_skidka',`show_price_after`='$calc' where `id`='$id'";
    baza_do_only($q);


    if (strlen($_SESSION['pre_edit_m']) == 0) $_SESSION['pre_edit_m'] = "<div class='alert alert-success'>��������� ��������� �������</div>";
    echo laz_meta("/cabinet/premoder/zakaz-$id", 0);
    db_disconnect($db);
    die();
}


?>
<link rel='stylesheet' type='text/css' href='<?= NA5KU_CDN_URL ?>lib/datetime/jquery.datetimepicker.css'/ >
<script src='<?= NA5KU_CDN_URL ?>lib/datetime/jquery.datetimepicker.js'></script>
<div class="row">
    <form method='post' enctype='multipart/form-data' action='/cabinet/edit/zakaz-<?= $id ?>.do'>
        <div class="col-md-12">
            <div class="cabinet-tabs">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1"><span>���������� � ������</span></a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab1" class="tab-pane fade in active">
                        <div class="tab-wrap">
                            <div class='row'>
                                <?php
                                echo $_SESSION['pre_edit_m'];
                                echo $_SESSION['upload_file_wf'];
                                unset($_SESSION['pre_edit_m']);
                                unset($_SESSION['upload_file_wf']);
                                ?>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="back-to-orders"><a href="/cabinet/"><span class="fa fa-reply"></span>�
                                            ������ �������</a></div>
                                </div>
                                <div class="col-md-7 mb-30">
                                    <div class="row">
                                        <div class="col-md-12 mb-20 clearfix">
                                            <div class="info-title">
                                                <h3>���������� � ������</h3>
                                            </div>
                                            <div class="edit-cancel-buttons">
                                                <a href='/cabinet/premoder/zakaz-<?= $id ?>' class="button edit-button">�����</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-wrap">
                                        <table class="table cabinet-table">
                                            <tbody>

                                            <tr>
                                                <td>���� ������</td>
                                                <td><input name='theme' value='<?= base64_decode($zakaz['theme']) ?>'
                                                           required class='form-control'></td>
                                            </tr>
                                            <tr>
                                                <td>���������� �������</td>
                                                <td id='page_c_span'><?= $zakaz['pages'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan=2><input name='pages' id='sel_c'
                                                                     value='<?= $zakaz['pages'] ?>' type='range' min='1'
                                                                     max='150' step='1' required class='form-control'
                                                                     oninput="page_c();" onchange="do_pre_price()"></td>
                                            </tr>
                                            <?php
                                            //dont display orig
                                            $zakaz['original'] = 0;
                                            if ($zakaz['original'] > 0) echo "
												<tr>
													<td>�������������� ������</td>
													<td>$zakaz[original] %</td>
												</tr>	
												";
                                            ?>
                                            <tr>
                                                <td>���� ������ ������</td>
                                                <td><?= date("Y/m/d H:i", $zakaz['date_start']) ?></td>
                                            </tr>
                                            <tr>
                                                <td>���� ����� ������</td>
                                                <td><input type='text' name='new_date' id='datetime'
                                                           value='<?= date("Y/m/d H:i", $zakaz['srok']) ?>'
                                                           class='form-control' onchange="do_pre_price()">
                                                    <script>$('#datetime').datetimepicker();</script>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-30">
                                    <div class="row">
                                        <div class="col-md-12 mb-30 clearfix">
                                            <div class="finances-title">
                                                <h3>�������</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-wrap mb-30">
                                        <table class="table cabinet-table">
                                            <tbody>
                                            <tr>
                                                <td>��������������� ��������� ������<br>(� ������ ������)</td>
                                                <td>
                                                    <span id='price_now'><?= number_format($zakaz['show_price_after'], 0, ',', ' ') ?></span> <?= $valuta ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>��������������� ������</td>
                                                <td>
                                                    <span id='procent_now'><?= number_format($zakaz['show_skidka'], 0, ',', ' ') ?></span> <?= $valuta ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>������� ������</td>
                                                <td>
                                                    <span id='procent_now2'><?= number_format($zakaz['show_procent'], 0, ',', ' ') ?></span>
                                                    %
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="more-info">
                                        <p><strong>��������� ����������: </strong><br>
                                            <textarea name='commnets' class='form-control'
                                                      style='resize: vertical;min-height: 150px;'><?= show_good(base64_decode($zakaz['commnets'])) ?></textarea>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="finances-title pre_files col-md-12 md-20">
                                <h3>���� �����</h3>
                            </div>
                        </div>
                        <div class="files-wrap">
                            <div class="row">
                                <div class="your-files files-item">
                                    <table class="table ">
                                        <tbody>
                                        <tr id='files_alert' hidden>
                                            <td>
                                                <div class='alert alert-warning'>���� ����� ������ ��� ������ ��
                                                    ��������� ���������!
                                                </div>
                                            </td>
                                        </tr>
                                        <?php

                                        $n = 0;
                                        $files_d = explode(",", $zakaz['file_link']);
                                        for ($i = 0; $i < count($files_d); $i++) if (strlen($files_d[$i]) > 0) {
                                            $n++;
                                            $tmp_link__ = end(explode("/", $files_d[$i]));
                                            $tmp_link_ = explode(".", $tmp_link__);
                                            $tmp_link = $tmp_link_[0];
                                            $ext = end($tmp_link_);

                                            echo "
												<tr id='tr_$tmp_link'><td>
													<a href='$files_d[$i]' target='_blank' class='file-link'>���� $n.$ext</a>
													<input type='checkbox' name='pre_uploaded_files_delete[]' value='$tmp_link__' id='file_$tmp_link' hidden> 
													<a href='javascript://' onclick='del_check(\"$tmp_link\")'><span class='fa fa-remove'></span></a></span>
												</td></tr>";
                                        }
                                        if ($n == 0) echo "<tr><td>��� ������.</td></tr>";
                                        ?>
                                        </tbody>
                                    </table>
                                    <div class="form-group add-files">
                                        <div data-provides="fileupload" class="fileupload fileupload-new">
											<span class="btn btn-file">
												<span class="fileupload-new">�������� ����</span>
												<span class="fileupload-exists">�������� ����</span>
												<input type="file" name="files[]" multiple id='file_val'
                                                       onchange="do_count_files();"></span><span id='file_c'
                                                                                                 style='font-size: 10px;'>
											</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12 mb-30 clearfix text-center' style='padding-top: 20px;'>
                                    <input type='submit' class='button edit-button submit_btn' value='���������'
                                           style='display: inline'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input id='calc' name='calc' hidden value='0'>
        <input id='show_procent' name='show_procent' hidden value='0'>
        <input id='show_skidka' name='show_skidka' hidden value='0'>

    </form>
</div>

<style>
    .cabinet-table td {
        vertical-align: middle !important;
    }
</style>

<script>
    function page_c() {
        var sel_c = $('#sel_c').val();
        $('#page_c_span').html(sel_c);
    }

    function del_check(name) {
        if (confirm("�� �������?")) {
            $("#tr_" + name).hide();
            $("#files_alert").show();
            $("#file_" + name).prop('checked', true);
        }
    }

    function do_pre_price() {
        var pr_code = $('#pr_code').val();


        var sel_type = $('#type').val();
        var sel_c = $('#sel_c').val();
        var sel_d = $('#datetime').val();
        // var summ=pr[sel_type];


        var oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
        var firstDate = new Date(2016, 8, 3);

        if (sel_d.length < 5) sel_d = '2016/08/03 14:33';
        var date_t = explode('/', sel_d);
        var date_t_ = explode(' ', date_t[2]);
        date_t[2] = date_t_[0];
        var secondDate = new Date(date_t[0], date_t[1], date_t[2]);
        //alert(secondDate);

        if (secondDate.getTime() < firstDate.getTime()) secondDate = firstDate;
        var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime()) / (oneDay)));
        if (diffDays < 1) {
            diffDays = 0;
        }


        $.ajax({
            type: 'POST',
            url: '/wp-content/cabinet/give_me_price.php?act=skidka_val&promo=' + pr_code + '&count=' + sel_c + '&type=' + sel_type + '&days=' + diffDays,


            success: function (data) {
                var obj = jQuery.parseJSON(data);
                $('#price_now').html(obj.now);
                $('input[name="calc"]').val(obj.now);
                if (obj.sk_count > 0) {
                    $('input[name="show_procent"]').val(obj.procent);
                    $('input[name="show_skidka"]').val(obj.sk_count);
                    if (obj.valuta == 0)
                        $('#procent_now').html(obj.procent + " %");
                    else
                        $('#procent_now').html(obj.procent + " ���.");
                    $('#procent_now2').html(obj.sk_count);
                } else {
                    $('input[name="show_skidka"]').val(0);
                    $('input[name="show_procent"]').val(0);

                    $('#procent_now').html("0");
                    $('#procent_now2').html("0");
                }
            }
        });

    }

    do_pre_price();
</script>
<style>
    .fa-reply:after {
        content: '\00a0'
    }
</style>	
