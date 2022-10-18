<?php
//$user_data['mc_bg_valuta']
if ($user_data['valuta'] == 2) {
    $user_data['valutaSTR'] = 'RUB';
    $valuta = "RUB";
} elseif ($user_data['valuta'] == 3) {
    $user_data['valutaSTR'] = 'USD';
    $valuta = "USD";
} else {
    $user_data['valutaSTR'] = 'UAH';
    $valuta = "UAH";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <!-- SEO Meta -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- Favicon
    <link rel="shortcut icon" href="/cabinet/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="/cabinet/img/favicon/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/cabinet/img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/cabinet/img/favicon/apple-touch-icon-114x114.png"> -->
    <!-- Title -->
    <title><?= $user_data['mc_bg_text_title'] ?></title>
    <!-- CSS -->
    <!-- build:css css/vendor.min.css-->
    <link rel="stylesheet" href="<?= NA5KU_CDN_URL ?>lib/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= NA5KU_CDN_URL ?>lib/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="<?= NA5KU_CDN_URL ?>lib/font-awesome-4.6.1/css/font-awesome.min.css">

    <!-- endbuild-->
    <link rel="stylesheet"
          href="<?= NA5KU_PLUGIN_DIR_URL ?>cabinet/cabinet/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet"
          href="<?= NA5KU_PLUGIN_DIR_URL ?>assets/css/cabinet.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= NA5KU_CDN_URL ?>lib/select2/select2.min.css">
    <link rel="stylesheet" href="<?= NA5KU_PLUGIN_DIR_URL ?>css/base/jquery-ui-1.9.2.custom.min.css">
    <!-- IE8 --><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        if (typeof (NA5KU_API_URL) === "undefined") {
            var NA5KU_API_URL = '<?= NA5KU_API_URL ?>';
        }
        if (typeof (NA5KU_REF_ID) === "undefined") {
            var NA5KU_REF_ID = '<?= get_option('mc_bg_ref_id') ?>';
        }
        if (typeof (NA5KU_VALUTA) === "undefined") {
            var NA5KU_VALUTA = '<?= get_option('mc_bg_valuta') ?>';
        }
    </script>
    <script src="<?= NA5KU_CDN_URL ?>lib/jquery/jquery-3.4.1.min.js"></script>
    <script src="<?= NA5KU_PLUGIN_DIR_URL ?>js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="<?= NA5KU_PLUGIN_DIR_URL ?>cabinet/cabinet/js/lazik.js?v=<?= time() ?>"></script>
    <script src="<?= NA5KU_CDN_URL ?>lib/masked-input/maskedinput.min.js"></script>
    <script src="<?= NA5KU_CDN_URL ?>lib/datetime/jquery.datetimepicker.js"></script>
    <script src="<?= NA5KU_CDN_URL ?>lib/select2/select2.full.min.js"></script>
    <script src="<?= NA5KU_PLUGIN_DIR_URL ?>cabinet/cabinet/js/cabinet.js?v=<?= time() ?>"></script>
    <script src="<?= NA5KU_PLUGIN_DIR_URL ?>js/main.js?v=<?= time() ?>"></script>
    <?php
    echo renderJSConst();
    ?>
    <style>
        :root {
            --na5ku-main-color: <?= get_option('mc_bg_button_color') ?>;
        }
    </style>

</head>
<!--  <script>-->
<!--      $( function() {-->
<!--          $( ".cabinet-tabs" ).tabs();-->
<!--      } );-->
<!--  </script>-->
<body>


<!-- Header -->
<header id="header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Navbar -->
                <nav class="main-menu clearfix">
                    <div class="logo" style="padding-top: 10px;">
                        <a href="/">
                            <img
                                    src="<?= get_option('mc_bg_header_logo') ?>" alt="logo">
                        </a>
                    </div>
                    <div class="right-side">
                        <div class="phones">
                            <a href="tel:<?= $user_data['mc_bg_phone1'] ?>"
                               class="phone"><?= $user_data['mc_bg_phone1'] ?></a>
                            <a href="tel:<?= $user_data['mc_bg_phone2'] ?>"
                               class="phone"><?= $user_data['mc_bg_phone2'] ?></a>
                        </div>
                        <div class="user jq-data-user" title=''>
                            <a href="/cabinet/" class="login"><?php
                                $tmp = $user_data['name_search'];
                                $tmp = explode(" ", $tmp);
                                if (is_array($tmp)) $tmp = $tmp[0];
                                echo substr($tmp, 0, 10);
                                ?></a>
                        </div>
                        <div class="balance">
                            <div class="money">Баланс:
                                <span><?= $user_data['bonus_money'] ?> <?= $user_data['valutaSTR'] ?></span>
                            </div>
                        </div>
                        <a href="#popup" class="menu-button options" onclick="load_profile_form()">Настройки</a>
                        <a
                                href="/exit" class="menu-button logout">Выход
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>


<!-- Main Content -->
<main id="main" class="active-orders">
    <div class="container">

        <?php
        require_once(__DIR__ . '/cabinet/menu.php');
        $orderNotifs = $userApi->getOrderNotifs();
        if ($orderNotifs) {
            $orderNotifs = array_filter($orderNotifs, function ($notif) {
                return $notif['notifPaidFull'] == 1;
            });
        }

        if ($orderNotifs) {
            $a = "open_zakaz";
            $notif = array_shift($orderNotifs);
            $forceId = $notif['order']['id_for_client'];
        }

        //die(var_dump($_POST,$a));
        if ($a == "open_zakaz") require_once($dir_name . 'cabinet/zakaz_read.php');
        else if ($a == "open_pre") require_once($dir_name . 'cabinet/zakaz_pre_read.php');
        else if ($a == "edit_zakaz") require_once($dir_name . 'cabinet/zakaz_pre_edit.php');
        else if ($a == "zakaz_comm") require_once($dir_name . 'cabinet/zakaz_comm.php');
        else if ($a == "pm") {
            echo '<div style="width: 100%;text-align: center; padding-bottom: 10px" ><strong>Уважаемый клиент! Все вопросы относительно выполнения заказа задавайте после его создания, на странице заказа во вкладке «Чат». Данный раздел просим Вас использовать только для общих вопросов, не касающихся написания работ.
</strong></div>';
            require_once($dir_name . 'cabinet/pm_read.php');
        } else if ($a == "friends") require_once($dir_name . 'cabinet/earn.php');
        else if ($a == "faq") require_once($dir_name . 'cabinet/faq.php');
        else if ($a == "examples") require_once($dir_name . 'cabinet/examples.php');
        else if ($a == "discount") require_once($dir_name . 'cabinet/discount.php');
// else if($a=="sms" || $a=="sms_open" || $a=="sms_read")require_once('profile_sms.php');
        else if ($a == "open_new") {

            require_once($dir_name . '/cabinet/zakaz_add.php');
        } else require_once($dir_name . 'cabinet/zakaz_list.php');


        ?>
    </div>
</main>
<!-- Footer -->
<footer id="footer">
    <div class="footer-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright"> <?= get_option('mc_bg_text_footer') ?></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php


require_once($dir_name . 'cabinet/sett_form.php');

?>
<!--POPUP WINDOW FOR WORKING-->
<div class="hidden">
    <div id="laz-popup" class="popup">
        <h3 id='l-p-title'>Загрузка</h3>
        <p>
            <span id='l-p-loading'>Загрузка данных...</span>
        </p>
        <form id='l-p-form'>
            <div class='row' id='l-p-text'></div>
            <div class="form-group clearfix" id='l-p-submit'>
                <br>
                <button class="button" onclick='send_lpform_data();return false;'>Подтвердить</button>
            </div>
        </form>
    </div>
</div>


<!-- JS -->
<!-- build:js js/vendor.min.js-->
<!--    herrrrrrrt-->
<script src="<?= NA5KU_CDN_URL ?>lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="<?= NA5KU_CDN_URL ?>lib/magnific-popup/jquery.magnific-popup.js"></script>
<script src="<?= NA5KU_CDN_URL ?>lib/jquery.matchHeight.js"></script>
<!-- endbuild-->
<script src="<?= NA5KU_PLUGIN_DIR_URL ?>cabinet/cabinet/js/common.js"></script>


<?

$premoderationApi = new Premoderation();
$premoderation = $premoderationApi->count(['id' => $user_data['id']]);

$orderApi = new Order();
$order = $orderApi->getCount(['id' => $user_data['id']]);

//echo "<pre>";
//var_dump($order);
//echo "</spre>";
//$q = "select * FROM `zakaz_forma` where `client_id`='$user_data[id]'";
//$check_c = baza_do_one($q);
//$q = "select * FROM `zakaz` where `client_id`='$user_data[id]'";
//$check_b = baza_do_one($q);
//
if ($user_data['valuta'] == 2) {
    $phonePlaceholder = '+7 (___) ___-__-__';
    $phoneMask = '+7 (999) 999-99-99';
} else {
    $phonePlaceholder = '+380 (__) ___-__-__';
    $phoneMask = '+380 (99) 999-99-99';
}
if ($user_data['name'] == '-' && ($order['data'] >= 1 || $premoderation['data'] >= 1)) { ?>

    <div id="reg-message" style="display:block;">
        <div class="mfp-bg mfp-fade mfp-ready" style="height: 100%; position: absolute;"></div>
        <div class="mfp-wrap mfp-auto-cursor mfp-fade mfp-ready" tabindex="-1"
             style="top: 0px; position: absolute; height: 455px;">
            <div class="mfp-container">
                <div class="mfp-container1" style="position: fixed;width: 100%;height: 100%;top: 0;z-index: 1;"></div>
                <div class="mfp-content">
                    <div id="register-popup_message" class="popup">
                        <form class="contacts-form" id="reg-form_st2">
                            <div style="    float: right;margin-right: -40px; margin-top: -20px; cursor: pointer"
                                 class="close_fio">X
                            </div>
                            <div style="text-align: center;">Чтобы мы могли сообщить вам стоимость вашей работы –
                                укажите ваш номер телефона.
                            </div>
                            <div class="content_st2">
                                <div class="form-group">
                                    <input type="text" name="full_name_st2" placeholder="Ваше имя" required
                                           class="form-control">
                                    <br>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="phone_st2" placeholder="<?= $phonePlaceholder ?>" required
                                           class="phone-input form-control">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="no_tel_me">
                                        <span
                                                style="padding-left: 15px">Не звоните мне</span>
                                    </label>
                                </div>
                                <button class="button" onclick="updateNamePhone(); return false;">Продолжить</button>
                                <br>
                            </div>
                            <script>

                                // Phone mask
                                $(".phone-input").mask("<?= $phoneMask ?>");

                            </script>
                            <div class="content_error">

                            </div>
                        </form>
                    </div>
                </div>
                <!--                        <div class="mfp-preloader reg-message1">Loading...</div>-->
            </div>
        </div>
    </div>
<? } ?>
<script>
    $(document).ready(function () {
        $('.close_fio').click(function () {
            $('#reg-message').hide();
        });
        $('.mfp-container1').click(function () {
            $('#reg-message').hide();
        })
    });
</script>
<?php

if (get_option('mc_na5ku_cabinet_css')) {
    echo '<link rel="stylesheet" href="' . get_option('mc_na5ku_cabinet_css') . '">';
}

if (get_option('mc_na5ku_cabinet_js')) {
    echo '<script src="' . get_option('mc_na5ku_cabinet_js') . '"></script>';
}
?>

</body>
</html>


