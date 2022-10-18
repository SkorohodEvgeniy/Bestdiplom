<?php
require_once('forgot-password/change-password-functions.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Восстановление пароля</title>
    <link rel="stylesheet" href="../../wp-content/cabinet/cabinet/css/change-password.css">
    <script src="../../wp-content/cabinet/js/jquery-1.9.1.js"></script>
    <script src="../../wp-content/cabinet/cabinet/js/password-restore-logic.js"></script>
</head>

<body class='login_body'>
<div class="login">
    <h2 class="login-header">Восстановление пароля</h2>
    <?php
    if ($check_session) die('<meta http-equiv="refresh" content="0; url=/cabinet/">');
    echo "<title>Сброс пароля</title>";
    $a = post($_POST['a']);
    $a2 = post($_GET['a2']);
    $mail = post($_POST['mail']);
    $code = post($_POST['code']);

    $a_array = array("help_me", "step2", "step3");
    if (!in_array($a, $a_array)) $a = "help_me";
    if ($a2 == "step3") {
        $a = "step3";
        $mail = post($_GET['mail']);
        $code = post($_GET['code']);
    }
    echo "<form method='POST' class='login-container'>";

    if (!empty ($_POST['a']) && $_POST['a'] == 'new_password_partner' && !empty($_POST['code1']) && !empty($_POST['code2'])) {
        change_password(post($_REQUEST['mail']), post($_POST['code2']));
        $error = processPostLogin('mail', 'code2');    // TODO: process the error!
        if (empty($error)) {
            echo "<center>Сохранено. Пароль изменен. Войдите в кабинет</center>";
            echo '<meta http-equiv="refresh" content="3; url=/cabinet"/>';
        } else {
            die($error);
        }
        header("Location: /cabinet");
    } else if ($a == "help_me") {
        echo "<center><input name='mail' type='email' placeholder='Почта' style='width: 80%' value='$mail'></center>";
        echo "<input name='a' hidden type='text' value='step2'><br>";
        echo "<center><input type='submit' value='Отправить' class='f-text' style='width: 30%;background: #8bbede;color:white'></center>";
    } else if ($a == "step2") {
        $q = "select * from `clients` where `login`='$mail'";
        $logins = baza_do($q);
        if (count($logins) == 1) {
            $rand_code = md5(rand()) . md5(rand()) . md5(time() . rand());
            $q = "update `clients` set `rand_code`='$rand_code' where `login`='$mail'";
            baza_do_only($q);
            $t = time();
            $ip = $_SERVER['REMOTE_ADDR'];
            $q = "insert into `forgot_passwords` (`login`,`time`,`ip`) values('$mail','$t','$ip')";
            baza_do_only($q);
            if (check_mail_pre($logins[0]['mail'])) {
                $send_mail = $logins[0]['mail'];

                $title = "Восстановление пароля";
                $title = "Восстановление пароля";
                $text = "Ссылка сброса пароля: <a href='" . $my_site . "/forgot-password/?a=help_me&a2=step3&mail=$mail&code=$rand_code'>ссылка</a><br>
					Или скопируйте этот код в форму и нажмите на кнопку сброса: <b>$rand_code</b>
			";
                mailer($send_mail, $title, $text, $headers);
                echo "<center><input name='mail' readonly type='email' placeholder='Почта' style='width: 80%' value='$mail'></center><br>";
                echo "<center><input name='code' type='text' placeholder='Код' style='width: 80%' value=''></center><br>";
                echo "<input name='a' hidden type='text' value='step3'>";
                echo "<center><input type='submit' value='Сбросить'  style='width: 30%;background: #8bbede;color:white'></center>";
            } else {
                echo "< center><b style='color:red'>У пользователя введена неверная почта!</b></center>";
            }

        } else {
            echo "<center><b style='color:red'>Пользователь не найден!</b></center>";
            echo "<center><input name='mail' type='email' class='f-text' placeholder='Почта' style='width: 80%' value='$mail'></center><br>";
            echo "<input name='a' hidden type='text' value='step2'>";
            echo "<center><input type='submit' value='Отправить' style='width: 30%;background: #8bbede;color:white'></center>";
        }
    } else if ($a == "step3") {
        $client = get_client($code, $mail);
        if ($client['rand_code'] == $code) {
            echo "<center style='font-size: 16pt;'>Введите новый пароль<b style='color:green'>$new_pass</b></center>";
            echo "<center><input name='code1' class='confirmable-pass code1' type='text' placeholder='Пароль' id='' style='width: 80%'></center><br>";
            echo "<center><input name='code2' class='confirmable-pass code2' type='text' placeholder='Повторите пароль' id='' style='width: 80%' value=''></center><br>";
            echo "<input name='a' hidden type='text' value='new_password_partner'>";
            echo "<input name='partner_id' hidden type='text' value='$client[id]'>";
            echo "<center><input class='btn-change-pass' type='submit' value='Сменить'></center>";
            echo "<center class='passErr'></center>";


        } else {
            echo "<center><b style='color:red'>Неверный код сброса!</b></center>";

        }

    }

    echo "</form>";
    ?>
    </form>
</div>
</body>
</html>
