<?php
if (!$check_session) die('<meta http-equiv="refresh" content="0; url=/exit">');
if (!($user_data['manager_id'])) die('<meta http-equiv="refresh" content="0; url=/cabinet">');
if ($a2 == "show_old")
    $sql_add = "";
else
    $sql_add = "limit 10";

$q = "select count(*) as 'c' from `local_sms` where (`to`='$user_data[id]' and `type_his`='5' and `type_my`='3' and `from`='$user_data[manager_id]') || (`to`='1' and `type_his`='3' and `type_my`='5' and `from`='$user_data[id]')  and `deleted`='0' order by id desc $sql_add";
$pm_c = baza_do_one($q);
$pm_c = $pm_c['c'];

$q = "select * from `local_sms` where (`to`='$user_data[id]' and `type_his`='5' and `type_my`='3' and `from`='$user_data[manager_id]') || (`to`='$user_data[manager_id]' and `type_his`='3' and `type_my`='5' and `from`='$user_data[id]')  and `deleted`='0' order by id desc $sql_add";
$pm = baza_do($q);


?>
<div class="row">
    <div class="col-md-12">
        <div class="cabinet-tabs">
            <ul class="nav nav-tabs">

                <li class="active"><a data-toggle="tab" href="#tab3"><span>Сообщение менеджеру</span></a></li>
            </ul>
            <div class="tab-content">

                <div id="tab3" class="tab-pane fade in active">
                    <div class="messages-wrap">
                        <div class="row">
                            <?php if ($_SESSION['pm_added']) {
                                unset($_SESSION['pm_added']); ?>
                                <div class='alert alert-success'>
                                    Сообщение отправлено успешно.
                                </div>
                            <?php } ?>
                            <?php
                            echo $_SESSION['upload_file_wf'];
                            unset($_SESSION['upload_file_wf']);
                            ?>
                            <?php if ($_SESSION['pm_short']) {
                                unset($_SESSION['pm_short']); ?>
                                <div class='alert alert-danger'>
                                    Слишком короткое сообщение
                                </div>
                            <?php } ?>

                            <?php if ($pm_c > 10) { ?>
                                <?php if ($a2 == "show_old") { ?>
                                    <a href='/cabinet/pm/?a2=hide_old'>
                                        <div class='alert alert-info'>
                                            Скрыть старые сообщения
                                        </div>
                                    </a>
                                <?php } else { ?>
                                    <a href='/cabinet/pm/?a2=show_old'>
                                        <div class='alert alert-info'>
                                            Показать старые сообщения
                                        </div>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                            <div class="col-md-12">
                                <?php

                                if (count($pm) == 0) $comment_author = "<div align='center'>Нет сообщений. Напишите нам.</div>";
                                else {
                                    $old_d = 0;
                                    $comment_author = "";

                                    for ($i = count($pm) - 1; $i >= 0; $i--) {
                                        $q = "update`local_sms` set `read`='1' where `id`='{$pm[$i]['id']}'";
                                        if ($pm[$i]['read'] != '1' && $pm[$i]['type_his'] == 5) baza_do_only($q);


                                        if ($old_d != date('j', $pm[$i]['time'])) {

                                            $old_d = date('j', $pm[$i]['time']);
                                        }

                                        if ($pm[$i]['type_his'] == 5) {
                                            $comment_author .= "
			<div class='message-item'>
				<div class='message-info clearfix'>
					<div class='name'>Менеджер</div>
					<div class='time'>" . date('H:i:s', $pm[$i]['time']) . "</div>
					<div class='date'>" . date('j.m.Y', $pm[$i]['time']) . "</div>
				</div>
			
				<div class='row'>
					<div class='col-md-12'>
						<div class='avatar'><img src='/cabinet/img/avatar.png' alt='avatar'></div>
						<div class='text' style='overflow-x: auto;'>
							<p>" . show_good(nl2br(base64_decode($pm[$i]['text']))) . "</p>
						</div>
					</div>
				</div>
			</div>
			";
                                        } else {

                                            $comment_author .= "
			<div class='message-item author-item'>
				<div class='message-info clearfix'>
					<div class='name'>Вы</div>
					<div class='time'>" . date('H:i:s', $pm[$i]['time']) . "</div>
					<div class='date'>" . date('j.m.Y', $pm[$i]['time']) . "</div>
				</div>
			
				<div class='row'>
					<div class='col-md-12'>
						<div class='avatar'><img src='/cabinet/img/author-avatar.png' alt='avatar'></div>
						<div class='text' style='overflow-x: auto;'>
							<p>" . show_good(nl2br(base64_decode($pm[$i]['text']))) . "</p>
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
                            <form class="add-message-form" enctype='multipart/form-data' action='/cabinet/pm.do'
                                  method='post'>
                                <input value="<?= $zakaz['id'] ?>" hidden name="id">
                                <input name="action3" hidden value="отправить сообщение">
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
											</span><span class="fileupload-preview"></span></div>
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

<?php
$q = "UPDATE `comment_client` SET `read_by_client`='1' where `zakaz_id`='$id'";
baza_do_only($q);
?>

<style>
    .fa-reply:after {
        content: '\00a0'
    }
</style>	
