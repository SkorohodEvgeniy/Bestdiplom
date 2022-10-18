<?php

//ini_set('session.bug_compat_warn', 0);
//ini_set('session.bug_compat_42', 0);
//
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
define('DOING_AJAX', 1);

require_once '../../../../../../wp-config.php';
require_once '../../../api_wrappers/User.php';
require_once '../../install/function.php';
$userApi = new User();

$mail = '';
$code = '';

if (isset($_GET['mail'])) {
    $mail = post($_GET['mail']);
}
if (isset($_GET['code'])) {
    $code = post($_GET['code']);
}

$checked = $userApi->checkedForgotPassword([
    'login' => $mail,
    'code' => $code
]);

//var_dump(isset($checked) && $checked['code'] == 200);


?><!DOCTYPE HTML>
<html>
<head>
    <title>Востановление пароля</title>
    <style>

        /*  LOGIN FORM    */


        .nosamepass {
            display: none;
        }

        .login_body {
            background: white;
        }

        .login {
            width: 400px;
            height: 400px;
            top: 50%;
            left: 50%;
            position: fixed;
            margin: -200px -200px;
            font-size: 16px;
        }

        /* Reset top and bottom margins from certain elements */
        .login-header,
        .login p {
            margin-top: 0;
            margin-bottom: 0;
        }


        .login-header {
            text-transform: uppercase;
            text-align: center;
            line-height: 1.4;
            color: #27436f;
            background-color: rgba(39, 67, 111, 0.3);
            border-bottom: 1px solid rgba(39, 67, 111, 0.5);
            padding: 10px;
        }


        .btn-change-pass {
            background-color: #ff6150;
            font-family: "pfhighwaysanspro-light", sans-serif;
            -webkit-border-radius: 20px;
            border-radius: 20px;
            width: 100%;
            line-height: 48px;
            border: none;
            outline: none;
            padding: 0 15px;
            display: block;
            text-align: center;
            color: #fff;
            font-size: 25px;
            text-transform: uppercase;
            -webkit-transition: all .5s ease;
            transition: all .5s ease;
            max-width: 225px;
        }

        .login-container {
            background: #ebebeb;
            padding: 12px;
        }

        /* Every row inside .login-container is defined with p tags */
        .login p, .login_remember_me_div {
            padding: 12px;
        }

        .stay_div {
            display: inline-block;
            vertical-align: middle;
            height: 15px;
            float: left;
        }

        .forgot_div {
            float: right;
        }

        .forgot_div span {
            float: right;
            position: relative;
            top: 2px;
        }

        .login a:hover span {
            color: red;
        }

        .login .help {
            text-align: center;
        }


        .login input.confirmable-pass {
            width: 100%;
            outline: none;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            height: 40px;
            line-height: 40px;
            text-indent: 10px;
            border: 1px solid #555;
            font-size: 16px;
            -webkit-transition: all .5s ease;
            transition: all .5s ease;
        }

        .login input[type="checkbox"] {
            width: 13px;
            border: 0 !important;
            outline: 0 !important;
            vertical-align: bottom;
            position: relative;
            top: 2px;
        }


        .login input[type="text"],
        .login input[type="email"],
        .login input[type="password"] {
            background: #fff;
            border-color: #bbb;
            color: #555;
        }

        /* Text fields' focus effect */
        .login input[type="email"]:focus,
        .login input[type="password"]:focus {
        }


        .login input[type="submit"]:hover {
            background-color: #ff6150;
            color: #fff;
            opacity: .7;
        }


    </style>
</head>

<body class='login_body'>
<div class="login">


    <?php

    if (isset($checked) && $checked['code'] == 200) {
        echo "<h3 class=\"login-header\">" . $checked['data'] . "</h3>";
    } else {
        echo "<h3 class=\"login-header\">Что то пошло не так. <br>Или код не найден, или у нас проблемы :(</h3>";
    }


    ?>

