<?php

$formSubject = $formType = $formPages = $formSpecialty = 0;
$defaultOriginal = 50;
$defaultType = 6;
$formOriginal = $defaultOriginal;
$formDeadline = $formTheme = $formFiles = $formRequirements = $formVuz = '';
$formMessageOK = $formMessageErr = false;

/** CHECK SESSIONS */
if (isset($_SESSION['add2']) && isset($_SESSION['add2']['vas_saved']) && $_SESSION['add2']['vas_saved']) {
    if (isset($_SESSION['add2']['theme'])) {
        $formTheme = $_SESSION['add2']['theme'];
    }

    if (isset($_SESSION['add2']['type'])) {
        $formType = intval($_SESSION['add2']['type']);
    }

    if (isset($_SESSION['add2']['predmet'])) {
        $formSubject = intval($_SESSION['add2']['predmet']);
    }

    if (isset($_SESSION['add2']['specialty'])) {
        $formSpecialty = intval($_SESSION['add2']['specialty']);
    }

    if (isset($_SESSION['add2']['original'])) {
        $formOriginal = $_SESSION['add2']['original'];
    }

    if (isset($_SESSION['add2']['pages'])) {
        $formPages = intval($_SESSION['add2']['pages']);
    }

    if (isset($_SESSION['add2']['srok'])) {
        $formDeadline = $_SESSION['add2']['srok'];
    }
    unset($_SESSION['add2']);
}

if (isset($_SESSION['add'])) {
    if (isset($_SESSION['add']['theme'])) {
        $formTheme = $_SESSION['add']['theme'];
    }

    if (isset($_SESSION['add']['type'])) {
        $formType = intval($_SESSION['add']['type']);
    }

    if (isset($_SESSION['add']['predmet'])) {
        $formSubject = intval($_SESSION['add']['predmet']);
    }

    if (isset($_SESSION['add']['specialty'])) {
        $formSpecialty = intval($_SESSION['add']['specialty']);
    }

    if (isset($_SESSION['add']['original'])) {
        $formOriginal = $_SESSION['add']['original'];
    }

    if (isset($_SESSION['add']['pages'])) {
        $formPages = intval($_SESSION['add']['pages']);
    }

    if (isset($_SESSION['add']['srok'])) {
        $formDeadline = $_SESSION['add']['srok'];
    }

    if (isset($_SESSION['add']['uploaded_files'])) {
        $formFiles = $_SESSION['add']['uploaded_files'];
    }

    if (isset($_SESSION['add']['must_do'])) {
        $formRequirements = $_SESSION['add']['must_do'];
    }

    if (isset($_SESSION['add']['vuz'])) {
        $formVuz = $_SESSION['add']['vuz'];
    }

    /** Messages */

    if (isset($_SESSION['add']['ok_m'])) {
        $formMessageOK = $_SESSION['add']['ok_m'];
    }

    if (isset($_SESSION['add']['err_m'])) {
        $formMessageErr = $_SESSION['add']['err_m'];
    }

    //unset($_SESSION['add']);
}

if (isset($_SESSION['theme']) && $_SESSION['theme']) {
    $formTheme = $_SESSION['theme'];
}
/** /CHECK SESSIONS */

/** CHECK INPUT */
if (isset($_GET['ttopic']) && $_GET['ttopic']) {
    $formTheme = base64_decode($_GET['ttopic']);
}

if (isset($_GET['formDeadline']) && $_GET['formDeadline']) {
    $formDeadline = post($_GET['formDeadline']);
}

if (isset($_POST['type'])) {
    $formType = intval($_POST['type']);

} elseif (isset($_GET['worktype'])) {
    $formType = intval($_GET['worktype']);
}

if (isset($_GET['tWorkType']) && $_GET['tWorkType']) {
    $tWorkType = $_GET['tWorkType'];
} else {
    $tWorkType = NULL;
}

if (isset($_GET['original']) && $_GET['original']) {
    $formOriginal = intval($_GET['original']);
}

if (isset($_GET['tpages']) && $_GET['tpages']) {
    $tpages = intval($_GET['tpages']);
} else {
    $tpages = 0;
}
if (isset($_GET['comment']) && $_GET['comment']) {
    $formRequirements = $_GET['comment'];
    $formRequirements = str_replace(' ', '+', $formRequirements);
    $formRequirements = base64_decode($formRequirements);
}

/** /CHECK INPUT */

$premodarationApi = new Premoderation();
$TypeOrder = new TypeOrder;
$SubjectOrder = new SubjectOrder;
$SpecialtyOrder = new SpecialtyOrder;

$APIAnswer = $premodarationApi->count([
    'id' => $user_data['id']
]);
$formaCount = $APIAnswer['data'];
$APIAnswer = $TypeOrder->getList($dbLang);
$types = $APIAnswer['data'];
$APIAnswer = $SubjectOrder->getList($dbLang);
$subjects = $APIAnswer['data'];
$APIAnswer = $SpecialtyOrder->getList($dbLang);
$Specialty = $APIAnswer['data'];
$typeSelect = '';
$subjectSelect = '';
$specialSelect = '';
$typeKey = get_option('mc_bg_type_lang') == 'ua' ? '_ua' : '';
foreach ($types as $type) {
    $selected = '';
    if ($formType == $type['id'] || $tWorkType == $type['type']) {
        $selected = 'selected';
    }

    if (!$formType && !$tWorkType && !isset($_SESSION['professions'])) {
        if ($defaultType == $type['id']) {
            $selected = 'selected';
        }
    }

    if (isset($_SESSION['professions']) && $_SESSION['professions'] == $type['id']) {
        $selected = 'selected';
    }

    $typeSelect .= '<option ' . $selected . ' value="' . $type['id'] . '">' . $type['type' . $typeKey] . '</option>';
}

foreach ($subjects as $subject) {
    $selected = '';
    if ($formSubject == $subject['id']) {
        $selected = 'selected';
    }

    $subjectSelect .= '<option ' . $selected . ' value="' . $subject['id'] . '">' . $subject['name'] . '</option>';
}
foreach ($Specialty as $specialty) {
    $selected = '';
    if ($formSpecialty == $specialty['id']) {
        $selected = 'selected';
    }

    $specialSelect .= '<option ' . $selected . ' value="' . $specialty['id'] . '">' . $specialty['specialnost'] . '</option>';
}

$pagesSelect = '';
for ($i = 1; $i <= 150; $i++) {
    $selected = '';
    if ($formPages == $i || $tpages == $i) {
        $selected = 'selected';
    }

    $pagesSelect .= '<option ' . $selected . ' value=' . $i . '>' . $i . '</option>';
}

//$types_form = "<select class='form-control' name='type' id='type' onchange='do_pre_price()'></select>";

?>
    <div class="row">
        <div class="col-md-12">
            <?php if ($formMessageErr) { ?>
                <div class='alert alert-danger'><?= $formMessageErr ?></div>
            <?php }
            //not ELSE
            if ($formaCount > 9) {
                echo "<div class='alert alert-danger'>К-во ваших заказов на премодерации превысил лимит. Ждите...</div>";
            } elseif ($formMessageOK) { ?>
                <div class='alert alert-success'><?= $formMessageOK ?></div>
            <?php }
            else {
            ?>
            <div class='row'>
                <div class="col-xs-12">
                    <h1>УЗНАЙ СТОИМОСТЬ РАБОТЫ</h1>
                </div>
            </div>
            <div class='row'>
                <div class="col-xs-12 nopadding">
                    <div class="arrs">
                        <ul class="arrs-list">
                            <li>
                                <div class="arrs-ico">
                                    <img
                                            src="<?= NA5KU_PLUGIN_DIR_URL ?>cabinet/cabinet/img/arrico1.png"
                                            alt="">
                                </div>
                                <div class="arrs-txt"> Заполните онлайн-заявку и узнайте предварительную стоимость</div>
                            </li>
                            <li>
                                <div class="arrs-ico">
                                    <img
                                            src="<?= NA5KU_PLUGIN_DIR_URL ?>cabinet/cabinet/img/arrico2.png"
                                            alt="">
                                </div>
                                <div class="arrs-txt"> В течении 2 часов мы сообщим вам точную стоимость заказа</div>
                            </li>
                            <li>
                                <div class="arrs-ico">
                                    <img
                                            src="<?= NA5KU_PLUGIN_DIR_URL ?>cabinet/cabinet/img/arrico3.png"
                                            alt="">
                                </div>
                                <div class="arrs-txt"> В оговоренный срок вы получите готовую работу высокого качества
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <form method='POST' action='/cabinet/zakaz.add' enctype='multipart/form-data' autocomplete="off"
                  onchange='do_pre_price()' class="form-calculation">
                <div class="row" style="background: #efbf43">
                    <link rel='stylesheet' type='text/css'
                          href='<?= NA5KU_CDN_URL ?>lib/datetime/jquery.datetimepicker.css'
                    / >

                    <div class='col-xs-12 text-center'>
                        <br>
                        <h3 style='color: #3b474f'>ИНФОРМАЦИЯ О ЗАКАЗЕ</h3>
                    </div>
                    <?php if (!check_phone($user_data['phone'])) {
                        $country = $GenSettings->getCountry($user_data['valuta']);

                        ?>
                        <div class="col-xs-12 form-group">
                            <div class="row">
                                <div class="col-md-6 mb-10">
                                    <div class="form-na5ku-email">
                                        <input type="text" name="mail"
                                               class="form-control"
                                               value="<?=$user_data['login']?>"
                                               disabled
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-10">
                                    <div class="form-na5ku-phone">
                                        <input type="text" name="phone" id="phone"
                                               class="form-control phone-input"
                                               placeholder="<?= $country['country_phone_placeholder'] ?>"
                                               data-phone-mask="<?= $country['country_phone_mask'] ?>"
                                        />
                                    </div>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function (){
                                    turnOnPhoneMask('.phone-input');
                                });
                            </script>
                        </div>
                    <?php } ?>
                    <div class='col-xs-12 col-sm-6 form-group'>
                        <select class='form-control init-select2' name='type' id='type'>
                            <?= $typeSelect ?>
                        </select>
                    </div>
                    <div class='col-xs-12 col-sm-6 form-group'>
                        <div class='col-xs-12 col-sm-5 text-left nopadding <?= get_option('mc_na5ku_hidePages') == '1' ? 'hidden' : '' ?>'>
                            <select class="form-control calculation-select init-select2" id='sel_c' name='pages'>
                                <option value="0">Кол-во страниц</option>
                                <?= $pagesSelect ?>
                            </select>
                        </div>
                        <div class='col-xs-12 col-sm-1 laz_srok_space <?= get_option('mc_na5ku_hidePages') == '1' ? 'hidden' : '' ?>'></div>
                        <div class='col-xs-12  text-right nopadding <?= get_option('mc_na5ku_hidePages') == '1' ? 'col-sm-12' : 'col-sm-6' ?>'>
                            <input type='text' class='form-control' placeholder='Срок' id='datepicker2' name='srok'
                                   value='<?= $formDeadline ?>' required>

                            <input type="hidden" id="valuta" value="<?= $user_data['valuta'] ?>">
                            <script>
                                $('#datepicker2').datetimepicker({
                                    minTime: '09:00',
                                    maxTime: '22:00',
                                });
                            </script>
                        </div>
                    </div>
                    <div class='col-xs-12 form-group <?= get_option('mc_na5ku_hidePrePrice') == '1' ? 'col-sm-12' : 'col-sm-6' ?>'>
                        <?php if (get_option('mc_na5ku_subjectReplaceSpec') == '1') { ?>
                            <div class='col-xs-12 nopadding'>
                                <select name="specialty" class="init-select2 form-control">
                                    <option value="0">Введите специальность</option>
                                    <?= $specialSelect ?>
                                </select>
                            </div>
                        <?php } else { ?>
                            <div class='col-xs-12 nopadding'>
                                <select name="predmet" class="init-select2 form-control">
                                    <option value="0">Введите предмет</option>
                                    <?= $subjectSelect ?>
                                </select>
                            </div>
                        <?php } ?>
                        <div class='col-xs-12 nopadding'>
                            <input type='text' class='form-control'
                                   placeholder='Тема - укажите в этом поле тему Вашего заказа' name='theme'
                                   value='<?= $formTheme ?>'
                                   required>
                        </div>
                        <div class='col-xs-12 nopadding'>
                        <textarea class='form-control' placeholder='Требования (не обязательно)' name='must_do'
                                  style='resize: vertical;min-height: 100px;'><?= $formRequirements ?></textarea>
                        </div>
                        <?php if (get_option('mc_na5ku_uniq')): ?>
                            <div class="form-group">
                                <div class="calculation-range-uniq-container">
                                    <p class="range-info" style="font-weight: 700; color: #5b5b5b;">Уникальность:
                                        <span
                                                class="range-result"><span
                                                    class="range-number"><?= $formOriginal ?></span></span>
                                        <i class="fa fa-question-circle fa-lg question-icon init-tooltip-question"
                                           data-html="true" data-toggle="tooltip" data-placement="top" title="
Если вы не знаете точный уровень уникальности - мы сделаем по стандартам, которые подходят для большинства ВУЗов.<br>
Работы мы по умолчанию проверяем через <a href='https://www.etxt.ru/' target='_blank'>https://www.etxt.ru/</a><br>
Если же вам требуется уникальность по какому-либо другому сервису, то необходимо об этом указывать в подробностях заказа.<br>
"></i>
                                    </p>
                                    <input type="range" class="calculation-range-uniq uniqCount" min="1" max="90"
                                           value="<?= $formOriginal ?>"
                                           name="original" oninput="orderUniqRange(this)"
                                           style="background-image: linear-gradient(to right, rgb(143, 175, 64) 0%, rgb(143, 175, 64) 21.1111%, rgb(243, 243, 243) 21.1111%, rgb(243, 243, 243) 100%);">
                                    <br>

                                </div>
                            </div>
                        <?php endif; ?>
                        <div class='col-xs-12 nopadding'>
                            <div class="form-group add-files">
                                <div data-provides="fileupload" class="fileupload fileupload-new"> <span
                                            class="btn btn-file"><span class="fileupload-new">Добавить файлы</span><span
                                                class="fileupload-exists">Изменить файлы</span>
                                        <input type="file" name="upload2[]" id='file_val' onchange='do_count_files()'
                                               multiple>
                                        </span>
                                    <span id='file_c' style='font-size: 10px;'></span>
                                </div>
                            </div>
                        </div>
                        <div class='col-xs-12 nopadding'
                             style='font-family: "open_sanssemibold", sans-serif; font-size: 16px; color: #5b5b5b;'>
                            *если у вас есть утвержденный план работы, обязательно прикрепите его
                            <br>
                            Удерживайте ctrl для добавления нескольких файлов.
                        </div>
                        <?php if ($formFiles) { ?>
                            <div class='col-xs-12 nopadding'>
                                <?= $formFiles ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class='col-xs-12 col-sm-6 form-group <?= get_option('mc_na5ku_hidePrePrice') == '1' ? 'hidden' : '' ?>'>
                        <div class='row'>
                            <div class='col-xs-12'>
                                <div class='col-xs-12 zakaz_add_info'>
                                    <div class='col-xs-12 nopadding'></div>
                                    <div class='col-xs-12 text-center'
                                         style='font-family: "open_sanssemibold", sans-serif; font-size: 16px; color: #5b5b5b;'>
                                        <b>Предварительная стоимость работы</b></div>
                                    <div class='col-xs-12 text-center laz_price'
                                         style='font-family: "open_sanssemibold", sans-serif;  color: #414f5c;'>
                                        <b>
                                            <span id="price_show">-</span>
                                            <span id="price_show_valuta"> <?= $user_data['valutaSTR'] ?></span>
                                        </b>
                                    </div>
                                    <div class='col-xs-12 text-center'
                                         style='font-family: "open_sanssemibold", sans-serif; font-size: 16px; color: #5b5b5b;'>
                                        <span id="procent_now"></span>
                                        <span id="procent_now2"></span>
                                    </div>
                                    <div class='col-xs-12'
                                         style='font-family: "open_sanssemibold", sans-serif; font-size: 16px; color: #5b5b5b;'>
                                        На стоимость влияют: тип работы, объем и срок. Чем больше объем работы и короче
                                        срок, тем выше ее стоимость. После получения и оценки заказа менеджером компании
                                        Вы
                                        узнаете его итоговую стоимость
                                    </div>
                                    <div class='col-xs-12 nopadding'></div>
                                </div>
                            </div>
                            <div class='col-xs-12 nopadding'></div>

                        </div>
                    </div>
                    <div class='col-xs-12 nopadding'></div>
                    <div class='col-xs-12 text-center'>
                        <input type="submit" class="button edit-button submit_btn add_sub" value="Заказать работу"
                               style="display: inline">
                        <br>
                        <br>
                    </div>
                    <div class='col-xs-12 text-center'
                         style='font-family: "open_sanssemibold", sans-serif; font-size: 13px; color: #5b5b5b;font-weight: bold;'>
                        Нажимая кнопку 'Заказать работу'
                        <br>
                        Вы принимаете
                        <a href="/rules/">условия публичной оферты</a>

                        <br>
                        <br>
                    </div>


                    <input id='calc' name='calc' hidden value='0'>
                    <input id='show_procent' name='show_procent' hidden value='0'>
                    <input id='show_skidka' name='show_skidka' hidden value='0'>

                </div>
            </form>
        </div>
    </div>


    <style>
        .form-group {
            margin-bottom: 15px !important;
        }

        @media only screen and (min-width: 768px) {
            .form-group {
                margin-bottom: 0px !important;
            }
        }

        @media only screen and (max-width: 991px) {
            .laz_srok_space {
                display: none !important;
            }
        }

        .laz_price {
            font-size: 62px;
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .laz_price {
                font-size: 40px;
            }
        }

        .add_sub {
            padding-right: 40px;
            padding-left: 40px;
            padding-top: 20px;
            padding-bottom: 20px;
            font-weight: bold;
            font-size: 29px;
            color: #fff;
            text-transform: uppercase;
        }

        .add_sub:hover, .add_sub:active {
            background: green;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 34px;
        }

        .select2-container .select2-selection--single {
            height: 34px;
            border: 1px solid #ccc;
        }

        .select2-container {
            width: 100% !important;
        }

        .form-calculation .calculation-range-uniq-container .tooltip-inner {
            max-width: 420px;
        }
    </style>
    <script>
        function do_pre_price() {
            var pr = [];
            var max = [];
            var sp = [];
            var ob = [];
            var st_sr = [];
            var st_ob = [];
            var pr_code = $('#pr_code').val();
            var sel_type = $('#type').val();
            var sel_c = $('#sel_c').val();
            var valuta = $('#valuta').val();
            var valuta = $('#valuta').val();
            var sel_d = $('#datepicker2').val();
            var oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            var original = $('.uniqCount');

            if (typeof (original) === 'undefined' || !original.length) {
                original = 50;
            } else {
                original = $(original[0]).val();
            }

            var firstDate = new Date("<?=date("Y,m,d")?>");

            if (sel_d.length < 5) sel_d = "<?=date("Y/m/d H:i")?>";
            var date_t = explode('/', sel_d);
            var date_t_ = explode(' ', date_t[2]);
            date_t[2] = date_t_[0];
            date_t[1]--;
            var secondDate = new Date(date_t[0], date_t[1], date_t[2]);

            if (secondDate.getTime() < firstDate.getTime()) secondDate = firstDate;
            var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime()) / (oneDay)));
            if (diffDays < 1) {
                diffDays = 0;
            }

            get_price(pr_code, sel_c, sel_type, diffDays, valuta, original);

        }

        do_pre_price();


    </script>
    <script src="<?= NA5KU_PLUGIN_DIR_URL ?>assets/js/front.js" type="text/javascript"></script>
    <script src="<?= NA5KU_PLUGIN_DIR_URL ?>assets/js/inline-calc.js" type="text/javascript"></script>

<?php } ?>
<?php


if (isset($_SESSION['add'])) {
    unset($_SESSION['add']);
}
