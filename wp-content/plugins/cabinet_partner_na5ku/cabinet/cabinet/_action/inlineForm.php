<?php
$email = post($_POST['mail']);
$phone = isset($_POST['phone']) ? post($_POST['phone']) : '';
$needRedirect = false;
$_SESSION['api_token'] = '';
$errMessage = "";
$orderData = [];
$orderData['type'] = intval(post($_POST['professions']));
$orderData['predmet'] = intval(post($_POST['subject']));
$orderData['pages'] = intval(post($_POST['pages']));
$orderData['srok'] = post($_POST['deadline']);
$orderData['theme'] = post($_POST['theme']);
$orderData['original'] = intval(post($_POST['uniq']));
$orderData['must_do'] = post($_POST['must_do']);


if ($orderData['original'] < 0) $orderData['original'] = 0;
if ($orderData['original'] > 100) $orderData['original'] = 100;

if ($orderData['pages'] < 0) $orderData['pages'] = 0;
if ($orderData['pages'] > 150) $orderData['pages'] = 150;

if (!$orderData['predmet']) {
    $errMessage .= "<li>Введите предмет</li>";
}
if (strlen($orderData['theme']) < 5) {
    $errMessage .= "<li>Введена очень короткая тема</li>";
}
if (strlen($orderData['srok']) < 5) {
    $errMessage .= "<li>Введите срок</li>";
} else {

    list($year, $month, $day_) = explode('/', $orderData['srok']);
    list($day, $hour_) = explode(' ', $day_);
    list($hour, $min) = explode(':', $hour_);
    $orderData['deadline'] = mktime($hour, $min, 0, $month, $day, $year);
    if ($orderData['deadline'] < time() + 6 * 60 * 60) $orderData['deadline'] = time() + 6 * 60 * 60;
    $orderData['srok'] = date("Y/m/d H:i", $orderData['deadline']);
}

if (!$errMessage) {
    $Files = new Files();
    $uploadedFiles = $Files->checkUploadedFiles('upload2');
    if (isset($_SESSION['upload_file_wf']) && $_SESSION['upload_file_wf']) {
        $errMessage = $_SESSION['upload_file_wf'];
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
}
$hidePhone = false;
if (!$json['auth'] || !check_phone($user_data['phone'])) {
    if (!check_phone($phone)) {
        $errMessage .= '<span class="api-response-danger"><li>Введите телефон</li></span>';
    }

    if ($user_data['id']) {
        $user_update_phone = $userApi->updatePhone([
            'phone' => $phone,
            'id' => $user_data['id']
        ]);

        if ($user_update_phone['code'] == 201) {
            $hidePhone = true;
        } else {
            $errMessage .= '<span class="api-response-danger"><li>Мы не смогли обновить телефон</li></span>';
        }
    }
}

if (!$errMessage) {
    if (!$json['auth']) {
        switch (strtolower(get_option('mc_bg_valuta'))) {
            case 'ru':
                $valuta = 2;
                break;
            case 'usd':
                $valuta = 3;
                break;
            default:
                $valuta = 1;
        }
        $user = new User();
        $apiResponse = $user->register([
            'email' => $email,
            'phone' => $phone,
            'ref_id' => get_option('mc_bg_ref_id'),
            'valuta' => $valuta,
        ]);
        if (isset($apiResponse['data'])) {
            if (is_array($apiResponse['data'])) {
                if (isset($apiResponse['data']['email'])) {
                    foreach ($apiResponse['data']['email'] as $msg) {
                        $errMessage .= $msg . '<br>';
                    }
                } elseif (isset($apiResponse['data']['token']) && $apiResponse['data']['token']) {
                    setcookie('api_token', $apiResponse['data']['token'], time() + 3600 * 24 * 365, '/');
                    $_SESSION['api_token'] = $apiResponse['data']['token'];

                    $user = $userApi->getCurrent();
                    if (isset($user['data']) && isset($user['data']['id']) && $user['data']['id']) {
                        if ($user_data) {
                            $user_data = $user_data + $user['data'];
                        } else {
                            $user_data = $user['data'];
                        }
                    }
                }
            } elseif (is_string($apiResponse['data'])) {
                $errMessage .= $apiResponse['data'];
            }
        } else {
            $errMessage .= '<span class="api-response-danger">API не вернул ответ</span>';
        }
    } else {
        $_SESSION['api_token'] = $_COOKIE['api_token'];
    }
}

if (!$errMessage) {
    if (!$_SESSION['api_token']) {
        $errMessage .= '<li>Проблемы с авторизацией</li>';
    }
}

if (!$errMessage) {
    $save_data = [];
    $orderData['themeWIN'] = base64_encode(iconv('UTF-8', 'WINDOWS-1251', $orderData['theme']));
    $orderData['must_doWIN'] = base64_encode(iconv('UTF-8', 'WINDOWS-1251', $orderData['must_do']));
}

if (!$errMessage) {
    $premoderation = new Premoderation();
    $newOrder = $premoderation->set(array(
        'theme' => $orderData['themeWIN'],
        'themeUTF' => $orderData['theme'],
        'original' => $orderData['original'],
        'pages' => $orderData['pages'],
        'z_t' => $orderData['type'],
        'date_start' => time(),
        'client_id' => $user_data['id'],
        'commnets' => $orderData['must_doWIN'],
        'subject' => $orderData['predmet'],
        'ref_id' => $user_data['mc_bg_ref_id'],
        'show_procent' => 0,//
        'show_skidka' => 0,//
        'show_price_after' => 0,//
        'show_price' => 0,//
        'tmp_mail' => $user_data['login'],
        'valuta' => $user_data['valuta'],
        'srok' => $orderData['deadline'],
        'fileLinks' => $fileLinks,
    ));
}

if (!$errMessage) {
    if ($newOrder['code'] == 200) {
        $time = time();
        $baza_event = base64_encode("Получен новый заказ с формы <a href='$my_site' target='_blank'>$my_site</a>, обработайте его");
        reg_event('18', '1', '4', $baza_event);
        $event = reg_event('18', $save_data['manager'], '3', $baza_event);
    } else {
        print_r($newOrder);
        $errMessage .= '<li>Проблемы с созданием заказа</li>';
    }
}

if ($errMessage) {
    $json['msg'] .= '<div class="api-response-danger">' . $errMessage . '</div>';
    if ($hidePhone) {
        $json['msg'] .= '<script>$(".form-na5ku-phone").hide();</script>';
    }
} else {
    $json['msg'] .= '<b class="api-response-success">Ваш заказ принят на модерацию. Скоро он появится у вас в профиле. Перенаправление...</b>' . laz_meta('/cabinet/', 1);
}


unset($_SESSION['api_token']);
