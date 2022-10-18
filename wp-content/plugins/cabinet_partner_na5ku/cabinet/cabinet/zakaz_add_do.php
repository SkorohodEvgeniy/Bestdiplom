<?php

$type = (int)post($_POST['type']);
$pages = (int)post($_POST['pages']);
$original = isset($_POST['original']) ? intval($_POST['original']) : 50;

$srok = post($_POST['srok']);
$predmet = intval($_POST['predmet']);
$specialty = intval($_POST['specialty']);
$vuz = '';
$theme = post($_POST['theme']);
$must_do = post($_POST['must_do']);

$calc = post($_POST['calc']);
$show_procent = post($_POST['show_procent']);
$show_skidka = post($_POST['show_skidka']);
$phone = post($_POST['phone']);
$price_original = '';
if (isset($_POST['original'])) {
    $original = post($_POST['original']);
}
if (isset($_POST['price_original'])) {
    $price_original = post($_POST['price_original']);
}

if ($original < 0) $original = 0;
if ($original > 100) $original = 100;

//do safe input
if ($pages < 0) $pages = 0;
if ($pages > 150) $pages = 150;


//check data
$err_m = "";
$hidePhone = false;
if (!check_phone($user_data['phone'])) {
    if (!check_phone($phone)) {
        $err_m .= "<li>Введите телефон</li>";
    } else {
        $user_update_phone = $userApi->updatePhone([
            'phone' => $phone,
            'id' => $user_data['id']
        ]);
        $hidePhone = true;
    }
}

if ($predmet == 0 && get_option('mc_na5ku_subjectReplaceSpec') != '1') {
    $err_m .= "<li>Введите предмет</li>";
}

if ($specialty == 0 && get_option('mc_na5ku_subjectReplaceSpec') == '1') {
    $err_m .= "<li>Введите специальность</li>";
}

if (strlen($theme) < 5) {
    $err_m .= "<li>Введена очень короткая тема</li>";
}
if (strlen($srok) < 5) {
    $err_m .= "<li>Введите срок</li>";
} else {
    list($year, $month, $day_) = explode('/', $srok);
    list($day, $hour_) = explode(' ', $day_);
    list($hour, $min) = explode(':', $hour_);
    $srok_tmp = mktime($hour, $min, 0, $month, $day, $year);
    if ($srok_tmp < time() + 6 * 60 * 60) $srok_tmp = time() + 6 * 60 * 60;
    $srok = date("Y/m/d H:i", $srok_tmp);
}

$Files = new Files();

$uploadedFiles = $Files->checkUploadedFiles('upload2');
if (isset($_SESSION['upload_file_wf']) && $_SESSION['upload_file_wf']) {
    $err_m = $_SESSION['upload_file_wf'];
}
$filesToUpload = array();

for ($i = 0; $i < count($uploadedFiles['links']); $i++) {
    $filesToUpload[] = array(
        'tmp_name' => $uploadedFiles['links'][$i],
        'name' => $uploadedFiles['names'][$i]
    );
}

if ($filesToUpload) {
    $uploadedFiles = $Files->uploadFiles($filesToUpload);
} else {
    $uploadedFiles = array();
}


$uploaded_files = '';
$fileLinks = [];
$n = 0;

if (isset($_POST['file_up']) && count($_POST['file_up']) > 0) {
    foreach ($_POST['file_up'] as $file_name) {
        $file_name = $Files->cutFileLink(post($file_name));
        $fileLinks[] = $file_name;
        $ext = $Files->getFileExt($file_name);
        $n++;
        $uploaded_files .= "<div class='uploaded-file'><input type='text' hidden name='file_up[]' value='$file_name'><a href='$file_name' target='_blank'>File $n.$ext</a></div>";
    }
}

foreach ($uploadedFiles as $uploadedFile) {
    $n++;
    $file_name = $Files->cutFileLink($uploadedFile);
    $fileLinks[] = $file_name;
    $ext = $Files->getFileExt($file_name);
    $uploaded_files .= "<div class='uploaded-file'><input type='text' hidden name='file_up[]' value='$file_name'><a href='$file_name' target='_blank'>File $n.$ext</a></div>";
}

if (!$err_m) {
    $save_data['theme'] = base64_encode(iconv('UTF-8', 'WINDOWS-1251', $theme));
    $save_data['srok'] = $srok_tmp;
    $save_data['date_start'] = time();
    $text = $must_do . ((strlen($vuz) > 0) ? "\nВуз: $vuz" : "");
    $save_data['commnets'] = base64_encode(iconv('UTF-8', 'WINDOWS-1251', $text));

    $premoderation = new Premoderation();

    $newOrder = $premoderation->set(array(
        'theme' => $save_data['theme'],
        'themeUTF' => $theme,
        'original' => $original,
        'pages' => $pages,
        'z_t' => $type,
        'date_start' => $save_data['date_start'],
        'client_id' => $user_data['id'],
        'manager_id' => $save_data['manager'],
        'commnets' => $save_data['commnets'],
        'commnetsUTF' => $text,
        'subject' => $predmet,
        'specialty' => $specialty,
        'ref_id' => $user_data['mc_bg_ref_id'],
        'show_procent' => $show_procent,
        'show_skidka' => $show_skidka,
        'show_price_after' => $calc,
        'show_price' => $price_original,
        'tmp_mail' => $user_data['login'],
        'valuta' => $user_data['valuta'],
        'srok' => $save_data['srok'],
        'fileLinks' => $fileLinks,
    ));


    if ($newOrder['code'] == 200) {
        $added_zakaz = true;

        //event reg
        $time = time();
        $baza_event = base64_encode("Получен новый заказ с формы <a href='$my_site' target='_blank'>$my_site</a>, обработайте его");
        reg_event('18', '1', '4', $baza_event);

        $event = reg_event('18', $save_data['manager'], '3', $baza_event);


        $_SESSION['add']['ok_m'] = "Ваш заказ принят на модерацию. Скоро он появится у вас в профиле</b><br>Перенаправление в <a href='/cabinet/' style='color:black'><b>кабинет пользователя</b></a>" . laz_meta("/cabinet/", 3);
    } elseif ($newOrder['code'] == 403) {
        foreach ($newOrder['data'] as $message) {
            $err_m .= '<li>' . $message . '</li>';
        }
    } else {
        $err_m .= '<li>Что-то пошло не так</li>';
    }
}

if ($err_m) {
    $_SESSION['add']['type'] = $type;
    $_SESSION['add']['pages'] = $pages;
    $_SESSION['add']['srok'] = $srok;
    $_SESSION['add']['predmet'] = $predmet;
    $_SESSION['add']['specialty'] = $specialty;
    $_SESSION['add']['vuz'] = $vuz;
    $_SESSION['add']['theme'] = $theme;
    $_SESSION['add']['must_do'] = $must_do;
    $_SESSION['add']['original'] = $original;
    $_SESSION['add']['uploaded_files'] = isset($uploaded_files) && $uploaded_files ? $uploaded_files : '';
    $_SESSION['add']['err_m'] = $err_m;

    if($hidePhone){
        $_SESSION['add']['err_m'].='<script>$(".form-na5ku-phone").hide();</script>';
    }
}


echo laz_meta("/cabinet/zakaz.write");
