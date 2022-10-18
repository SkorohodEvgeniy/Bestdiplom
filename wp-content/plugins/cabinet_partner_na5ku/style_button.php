<?php
ini_set('display_errors', 'Off');
header("Content-Type: text/html; charset=utf-8");
$color = &get_option('mc_bg_button_color');
?>
<style>
    .reg-btn {
        background-color: <?=$color?>;
        padding-top: 5px !important;
        padding-bottom: 5px !important;
        margin-top: 15px;
        color: #fff !important;
    }

    .login-btn {
        position: relative;
        color: <?=$color?> !important;
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        font-weight: 400;
        line-height: 60px;
        margin: 0 20px 0 25px;
    }

    .button_cabinet_active li {
        float: left;
        list-style-type: none;
    }

    .button_cabinet_active > li > a {
        padding: 20px 20px;
    }
</style>
