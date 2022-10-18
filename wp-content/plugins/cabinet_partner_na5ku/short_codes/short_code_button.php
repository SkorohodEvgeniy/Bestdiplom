<?php

/**
 * @return string
 */
function button_register_login_r()
{
    $color = get_option('mc_bg_button_color');

    $return = renderJSConst() . '
	<div class="na5ku-cabinet-buttons">
        <div class="button_cabinet_active">
            <div class="nav-div-logged-in hidden">
                <div class="na5ku-cabinet-buttons">
                    <a class="login-btn" href="/cabinet"
                       style="font-size: 13px; padding: 19px 6px;">' . __("Кабинет", NA5KU_LANG_PACK_DOMAIN) . '</a>
                </div>
                <div class="na5ku-cabinet-buttons">
                    <a class="reg-btn" href="/exit">' . __("Выход", NA5KU_LANG_PACK_DOMAIN) . '</a>
                </div>
            </div>

            <div class="nav-div-guest hidden">
                <div class="na5ku-cabinet-buttons btn-input">
                    <a class="login-btn" href="#" data-toggle="modal" data-target="#na5ku-login"><i
                                class="fas fa-sign-in-alt"></i>' . __("Вход", NA5KU_LANG_PACK_DOMAIN) . '</a>
                </div>
                <div class="na5ku-cabinet-buttons btn-reg" style="margin-top: 20px;">
                    <a class="reg-btn" href="#" data-toggle="modal"
                       data-target="#na5ku-register">' . __("Регистрация", NA5KU_LANG_PACK_DOMAIN) . '</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="na5ku-modals-div">
        <!-- Modal -->
        <div id="na5ku-login" class="lr-modal modal fade" role="dialog">
            <div class="modal-dialog">
    
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><img
                                    src="' . NA5KU_PLUGIN_DIR_URL . 'cabinet/images/modal/close.png" alt="">
                        </button>
                        <h4 class="modal-title">' . __("Вход", NA5KU_LANG_PACK_DOMAIN) . '</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-inline" id="enter_form_1">
                            <div class="banner-form__wrapper">
                                <div style="text-align: center;">
                                    <span id="text_send"><b style="color:#ff6363"></b></span>
                                </div>
    
                                <div class="form-group">
                                    <label for="loginEmail" class="sr-only">E-mail</label>
                                    <input type="email" name="login" class="form-control" id="loginEmail"
                                           placeholder="' . __("E-mail", NA5KU_LANG_PACK_DOMAIN) . '">
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="sr-only">Пароль</label>
                                    <input type="password" name="password" class="form-control" id="inputPassword"
                                           placeholder="' . __("Пароль", NA5KU_LANG_PACK_DOMAIN) . '">
                                </div>
                                <input type="submit" onclick="do_enter(); return false;"
                                       value="' . __("ВОЙТИ", NA5KU_LANG_PACK_DOMAIN) . '"
                                       class="btn btn-default">
                                <div class="form-group">
                                    <span class="modal_links">
                                        <a href="#" data-toggle="modal" data-target="#na5ku-register" data-dismiss="modal"
                                           class="register">' . __("Регистрация", NA5KU_LANG_PACK_DOMAIN) . '</a>
                                        <span>|</span>
                                        <a href="#"
                                        data-dismiss="modal"
                                           data-toggle="modal"
                                           data-target="#na5ku-forgot-password"
                                           class="forgot-password">' . __("Забыли пароль?", NA5KU_LANG_PACK_DOMAIN) . '</a>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
    
            </div>
        </div>
    
        <!-- Modal -->
        <div id="na5ku-register" class="lr-modal modal fade" role="dialog">
            <div class="modal-dialog">
    
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><img
                                    src="' . NA5KU_PLUGIN_DIR_URL . 'cabinet/images/modal/close.png" alt="">
                        </button>
                        <h4 class="modal-title">' . __("Регистрация", NA5KU_LANG_PACK_DOMAIN) . '</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-inline" id="na5ku-reg-form-inline" onsubmit="register(); return false;">
                            <div class="banner-form__wrapper">
                                <div class="form-group">
                                    <label for="registerEmail" class="sr-only">' . __("E-mail", NA5KU_LANG_PACK_DOMAIN) . '</label>
                                    <input type="email" class="form-control" id="registerEmail" name="email"
                                           placeholder="' . __("E-mail", NA5KU_LANG_PACK_DOMAIN) . '">
                                </div>
                                <div id="register-popup_message_HEAD"><b style="color:red"></b></div>
                                <input type="hidden" name="ref_id" value="' . get_option("mc_bg_ref_id") . '">
                                <input type="hidden" name="valuta" value="' . get_option("mc_bg_valuta") . '">
                                <input type="submit" value="' . __("Зарегистрироваться", NA5KU_LANG_PACK_DOMAIN) . '"
                                       class="btn btn-default">
                                <div class="form-group">
                                      <span class="modal_links"><a href="#" data-toggle="modal" data-target="#na5ku-login" data-dismiss="modal"
                                                                   class="login">' . __("Вход", NA5KU_LANG_PACK_DOMAIN) . '</a> <span>|</span>
                                        <a href="#" data-toggle="modal" data-target="#na5ku-forgot-password" data-dismiss="modal"
                                         class="forgot-password">' . __("Забыли пароль?", NA5KU_LANG_PACK_DOMAIN) . '</a>
                                     </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
    
            </div>
        </div>
    
        <!-- Modal -->
        <div id="na5ku-forgot-password" class="lr-modal modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><img
                                src="' . NA5KU_PLUGIN_DIR_URL . 'cabinet/images/modal/close.png" alt="">
                    </button>

                    <h4 class="modal-title">' . __("Востановление пароля", NA5KU_LANG_PACK_DOMAIN) . '</h4>
                </div>
                <div class="modal-body">
                    <form class="form-inline" id="modal-forgot-password-form">
                        <div class="banner-form__wrapper">
                            <div class="form-group">
                                <span id="modal-forgot-password-message"></span>
                                <label for="forgotPass-email" class="sr-only">' . __("E-mail", NA5KU_LANG_PACK_DOMAIN) . '</label>
                                <input type="text" class="form-control" id="forgotPass-email" name="email"
                                       placeholder="' . __("E-mail", NA5KU_LANG_PACK_DOMAIN) . '">
                            </div>
                            <label class="form-label forgetInfo">
                                ' . __("Введите свой адрес электронной почты, и мы отправим вам новый пароль.", NA5KU_LANG_PACK_DOMAIN) . '</label>
                            <input type="submit" id="modal-forgot-password-submit"
                                   onclick="forgotpassword(); return false;" value="' . __("Отправить", NA5KU_LANG_PACK_DOMAIN) . '"
                                   class="btn btn-default">
                                   <div class="form-group">
                                      <span class="modal_links"><a href="#" data-toggle="modal" data-target="#na5ku-login" data-dismiss="modal"
                                                                   class="login">' . __("Вход", NA5KU_LANG_PACK_DOMAIN) . '</a> <span>|</span>
                                        <a href="#" data-toggle="modal" data-target="#na5ku-register" data-dismiss="modal"
                                           class="register">' . __("Регистрация", NA5KU_LANG_PACK_DOMAIN) . '</a>
                                     </span>
                                </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>
    
    <style>
        .popup {
            position: relative;
            background: #fff;
            max-width: 370px;
            margin: 0 auto;
            padding: 20px 25px;
        }

        .mfp-container {
            position: fixed;
        }

        .dropdown-menu {
            display: none
        }

        .dropdown-menu.menu_lvl_1 {
            position: absolute;
            left: 100%;
            top: 0;
            padding: 0;
        }

        .reg-btn {
            background-color: ' . $color . ';
            padding: 5px 20px !important;
            margin-top: 15px;
            color: #fff !important;
        }

        .login-btn {
            position: relative;
            color: ' . $color . ' !important;
            font-family: "Roboto", sans-serif;
            font-size: 16px;
            font-weight: 400;
            line-height: 60px;
            margin: 0 20px 0 25px;
        }

        .lr-modal .modal-content {
            background-color: ' . $color . ';
            border: none;
            border-radius: 0;
            box-shadow: none;
        }

        .lr-modal .modal-header {
            border-bottom: 0;
        }

        .lr-modal .close {
            color: #fff;
            opacity: 1;
            font-size: 20px;
        }

        .lr-modal .modal-title {
            text-align: center;
            color: white;
            font-family: "Rubik", sans-serif;
            font-size: 25px;
            font-weight: 500;
            line-height: 36px;
            text-transform: uppercase;
        }

        .lr-modal .banner-form__wrapper {
            margin: 0;
        }

        .lr-modal .modal-content input[type="submit"] {
            background-color: #FF860F;
            border-radius: 2px;
            color: white;
            font-size: 24px;
            font-weight: 400;
            line-height: 18px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .lr-modal .banner-form__wrapper input {
            width: 310px !important;
            margin-bottom: 30px;
            display: block;
        }

        .banner-form__wrapper input[type="submit"] {
            background-color: #f88525;
            border-radius: 1px;
            color: white;
            font-family: "Open Sans", sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 40px;
            text-transform: uppercase;
        }

        .banner-form__wrapper input, .banner-form__wrapper select {
            margin-right: 15px;
            height: 50px;
            width: 250px !important;
            border: none;
            box-shadow: none;
            border-radius: 0;
        }

        .lr-modal .modal_links {
            text-align: center;
            display: block;
            width: 310px;
        }

        .lr-modal .modal_links a, .lr-modal .modal_links span {
            color: #aaf4ff;
            font-family: "Open Sans", sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 36px;
            text-decoration: underline;
        }

        .lr-modal .modal-dialog {
            width: 340px;
            margin-top: 10%;
        }

        .na5ku-cabinet-buttons {
            display: inline-block;
        }

        #text_send,
        #register-popup_message_HEAD {
            text-align: center;
            padding: 15px 0;
            display: block;
            color: white;
        }

        #modal-forgot-password-form .form-label.forgetInfo {
            line-height: 1;
            font-size: 16px;
            color: white;
            display: block;
            padding-bottom: 10px;

        }

        #modal-forgot-password-form #modal-forgot-password-message {
            line-height: 1;
            font-size: 16px;
            color: white;
            display: block;
            padding-bottom: 10px;
            text-align: center;
        }

        .na5ku-cabinet-buttons .nav-div-logged-in,
        .na5ku-cabinet-buttons .nav-div-guest {

        }

        .hidden {
            display: none !important;
        }

    </style>
	';

    return $return;
}
