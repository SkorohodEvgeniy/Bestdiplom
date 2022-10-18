<?php
error_reporting(error_reporting() & ~E_NOTICE);


function upload_file($name)
{
    global $_FILES;
    global $files_white_list;
    global $script_folder;

    $q = 'SELECT value from `general_settings` where `param`="CLIENT_EXT_ALLOWED"';
    $extSTR = baza_do_one($q);
    $files_white_list = explode(',', $extSTR['value']);
    die();

    $_SESSION['upload_file_wf'] = "";
    $uploaddir = dirname(__FILE__) . '/ups/';
    for ($i = 0; $i < count($_FILES[$name]['tmp_name']); $i++) {
        if (strlen($_FILES[$name]['tmp_name'][$i]) > 2) {
            $ext = end(explode('.', strtolower($_FILES[$name]['name'][$i])));
            $uploadfile_name = "attach_" . time() . rand(1000, 9999) . ".$ext";
            $uploadfile = $uploaddir . $uploadfile_name;
            $uploadfile2 = "https://" . $_SERVER['HTTP_HOST'] . "/$script_folder/ups/$uploadfile_name";
            for ($iii = 0; $iii < 5; $iii++) $uploadfile2 = str_replace("//", "/", $uploadfile2);
            $uploadfile2 = str_replace("https:/", "https://", $uploadfile2);

            if (in_array($ext, $files_white_list)) {
                if (move_uploaded_file($_FILES[$name]['tmp_name'][$i], $uploadfile)) {
                    $link[] = $uploadfile2;
                } else $_SESSION['upload_file_wf'] .= "<center><span style='color:red'>Ошибка загрузки файла <b>" . $_FILES[$name]['name'][$i] . "</b>. Проблема при копировании</span></center><br>";
            } else $_SESSION['upload_file_wf'] .= "<div class='alert alert-danger'>Ошибка загрузки файла <b>" . $_FILES[$name]['name'][$i] . "</b>. Запрешенный формат файла: <b>$ext</b></div>";
        }
    }

    if ($_SESSION['upload_file_wf'] == "") unset($_SESSION['upload_file_wf']);

    return $link;

}
