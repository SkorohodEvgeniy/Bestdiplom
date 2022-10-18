<?php

/**
 * @return string
 */
function na5ku_form_inline()
{
    global $dbLang;
    $formData = [];
    $SubjectOrder = new SubjectOrder;
    $APIAnswer = $SubjectOrder->getList($dbLang);
    $formData['subjects'] = $APIAnswer['data'];
    if ($dbLang == 'ua') {
        $key = '_ua';
    } else {
        $key = '';
    }

    $color = get_option('mc_bg_button_color');
    if (!$color) {
        $color = NA5KU_CNF_DEF_COLOR;
    }
    list($colorR, $colorG, $colorB) = sscanf($color, "#%02x%02x%02x");
    $registerText = get_option('mc_na5ku_inline_form_action');
    if (!$registerText) {
        $registerText = 'Узнать стоимость';
    }
    $id = uniqid('file_uploader_');

    $return =
        renderJSConst() . '
    <form onsubmit="new_register(this); return false;" class="na5ku-order-form js-cta-form"
          autocomplete="off">
        <div class="row">
            <div class="col-sm-12">
                <div class="cta-form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="cta-form-wrapper">
                                <div class="row px-4">
                                    <div class="col-md-6">
                                        <div class="form-item js-cta-form-item always-focused">
                                            <label><b>' . __("Тип работы", NA5KU_LANG_PACK_DOMAIN) . '</b></label>
                                            <select name="professions"
                                                    class="wpcf7-form-control init-select2 na5ku-type-list">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-item js-cta-form-item always-focused">
                                            <label><b>' . __("Предмет", NA5KU_LANG_PACK_DOMAIN) . '</b></label>
                                            <select name="subject" class="wpcf7-form-control init-select2">
                                                <option value="">---</option>';
    foreach ($formData["subjects"] as $subject) {
        $return .= '<option value="' . $subject["id"] . '">' . $subject["name" . $key] . '</option>';
    }
    $return .= '</select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-item js-cta-form-item always-focused">
                                            <label>' . __("Количество страниц", NA5KU_LANG_PACK_DOMAIN) . '</label>
                                            <select name="pages" class="wpcf7-form-control init-select2">';
    for ($i = 1; $i <= 150; $i++) {
        $return .= '<option value="' . $i . '">' . $i . '</option>';
    }
    $return .= ' </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-item js-cta-form-item">
                                            <label for="deadline">' . __("Срок", NA5KU_LANG_PACK_DOMAIN) . '</label>
                                            <input type="text" name="deadline"
                                                   class="wpcf7-form-control orderDeadline">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-na5ku-theme">
                                        <div class="form-item js-cta-form-item">
                                            <label for="topic">' . __("Тема", NA5KU_LANG_PACK_DOMAIN) . '</label>
                                            <input type="text" name="theme"  class="wpcf7-form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 nav-div-guest hidden">
                                        <div class="form-item js-cta-form-item form-na5ku-email ">
                                            <label for="email">' . __("E-mail", NA5KU_LANG_PACK_DOMAIN) . '</label>
                                            <input type="email" name="mail"  class="wpcf7-form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 inline-form-phone">
                                        <div class="form-item is-focused js-cta-form-item form-na5ku-phone hidden">
                                            <label for="email2" class="">' . __("Телефон", NA5KU_LANG_PACK_DOMAIN) . '</label>
                                            <input type="text" name="phone" class="wpcf7-form-control">
                                        </div>
                                    </div>
                                    
                                    ';
    if (get_option('mc_na5ku_uniq')) {
        $return .= '<div class="col-md-12"><div class="form-group mb-0">
            <div class="calculation-range-uniq-container">
                <p class="range-info">' . __("Уникальность", NA5KU_LANG_PACK_DOMAIN) . ': <span
                            class="range-result"><span
                                class="range-number">50</span></span></p>
                <input type="range" class="calculation-range-uniq uniqCount" min="1" max="90" value="50"
                       name="uniq" oninput="orderUniqRange(this)"
                       style="background-image: linear-gradient(to right, rgb(143, 175, 64) 0%, rgb(143, 175, 64) 21.1111%, rgb(243, 243, 243) 21.1111%, rgb(243, 243, 243) 100%);">
            </div>
        </div></div>';
    }
    if (get_option("mc_na5ku_inline_addOptions") != "-1") {
        $return .= '
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12 text-center toggle-requirements-block">
                                                    <a href="javascript://" onclick="toggleAddRequirements(this)"
                                                       class="toggle-requirements-link">' . __("Дополнительные требования", NA5KU_LANG_PACK_DOMAIN) . '</a>
                                                </div>
                                            </div>
                                            <div class="row toggle-requirements">
                                                <div class="col-sm-12 two_inp">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <label class="must-do-label">
                                                        <textarea
                                                                  rows="5"
                                                                  name="must_do"
                                                                  class="jq-submit"
                                                                  placeholder="' . __("Дополнительные требования", NA5KU_LANG_PACK_DOMAIN) . ' (' . __("Не обязательно", NA5KU_LANG_PACK_DOMAIN) . ')"></textarea>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="calculation-upload-container"
                                                           for="' . $id . '">
                                                        <input type="file" name="upload2[]"
                                                               id="' . $id . '" class="calculation-upload-input"
                                                               onchange="do_count_filesNew(this)"
                                                               multiple>
                                                        <label for="' . $id . '">' . __("Прикрепить файлы", NA5KU_LANG_PACK_DOMAIN) . '</label>
                                                    </label>
                                                    <p class="files-counter"></p>
                                                    <p class="calculation-form-required-info">' . __("Удерживайте", NA5KU_LANG_PACK_DOMAIN) . '
                                                        <span
                                                                class="info-ctrl">ctrl</span>
                                                        ' . __("для добавления нескольких файлов.", NA5KU_LANG_PACK_DOMAIN) . '
                                                    </p>
                                                </div>
                                            </div>
                                        </div>';
    }
    $return .= ' </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 cta-form-control">
                <label class="reg_text_send_header"></label>
                <button type="submit" class="cta__button"
                        style="background: ' . $color . '">' . __($registerText, NA5KU_LANG_PACK_DOMAIN) . '</button>
            </div>

        </div>
    </form>
' . renderJSAndCSSReg();
    return $return;
}

/**
 * @return string
 */
function na5ku_form_inline_vertical()
{
    global $dbLang;
    $formData = [];
    $SubjectOrder = new SubjectOrder;
    $APIAnswer = $SubjectOrder->getList($dbLang);
    $formData['subjects'] = $APIAnswer['data'];
    if ($dbLang == 'ua') {
        $key = '_ua';
    } else {
        $key = '';
    }

    $color = get_option('mc_bg_button_color');
    if (!$color) {
        $color = NA5KU_CNF_DEF_COLOR;
    }
    list($colorR, $colorG, $colorB) = sscanf($color, "#%02x%02x%02x");
    $registerText = get_option('mc_na5ku_inline_form_action');
    if (!$registerText) {
        $registerText = 'Узнать стоимость';
    }
    $id = uniqid('file_uploader_');


    $return = renderJSConst() . '
    <form onsubmit="new_register(this); return false;" class="na5ku-order-form na5ku-order-form-vertical"
          autocomplete="off">
        <div class="form-wrapper js-cta-form cta-form-wrapper">
            <div class="form-column">
                <div class="form-item js-cta-form-item always-focused">
                    <label><b>' . __("Тип работы", NA5KU_LANG_PACK_DOMAIN) . '</b></label>
                    <select name="professions"  class="wpcf7-form-control init-select2 na5ku-type-list"></select>
                </div>
                <div class="form-item js-cta-form-item always-focused">
                    <label><b>' . __("Предмет", NA5KU_LANG_PACK_DOMAIN) . '</b></label>
                    <select name="subject" class="wpcf7-form-control init-select2">
                        <option value="">---</option>';
    foreach ($formData["subjects"] as $subject) {
        $return .= '<option value="' . $subject["id"] . '">' . $subject["name" . $key] . '</option>';
    }
    $return .= '</select>
                </div>
                <div class="form-item js-cta-form-item">
                    <label>' . __("Тема", NA5KU_LANG_PACK_DOMAIN) . '</label>
                    <input type="text" name="theme" class="wpcf7-form-control">
                </div>
            </div>
            <div class="form-column">
                <div class="form-item js-cta-form-item always-focused">
                    <label>' . __("Количество страниц", NA5KU_LANG_PACK_DOMAIN) . '</label>
                    <select name="pages" class="wpcf7-form-control init-select2">';
    for ($i = 1; $i <= 150; $i++) {
        $return .= '<option value="' . $i . '">' . $i . '</option>';
    }
    $return .= '</select>
                </div>
                <div class="form-item js-cta-form-item">
                    <label for="deadline2">' . __("Срок", NA5KU_LANG_PACK_DOMAIN) . '</label>
                    <input type="text" name="deadline" class="wpcf7-form-control orderDeadline">
                </div>
                <div class="form-item js-cta-form-item form-na5ku-email nav-div-guest hidden">
                    <label for="email2">' . __("E-mail", NA5KU_LANG_PACK_DOMAIN) . '</label>
                    <input type="email" name="mail" class="wpcf7-form-control">
                </div>
                <div class="form-item is-focused js-cta-form-item form-na5ku-phone hidden">
                    <label for="email2" class="">' . __("Телефон", NA5KU_LANG_PACK_DOMAIN) . '</label>
                    <input type="text" name="phone" class="wpcf7-form-control">
                </div>
            </div>';
    if (get_option('mc_na5ku_uniq')) {
        $return .= '<div class="row"><div class="col-md-12"><div class="form-group mb-0">
            <div class="calculation-range-uniq-container">
                <p class="range-info">' . __("Уникальность", NA5KU_LANG_PACK_DOMAIN) . ': <span
                            class="range-result"><span
                                class="range-number">50</span></span></p>
                <input type="range" class="calculation-range-uniq uniqCount" min="1" max="90" value="50"
                       name="uniq" oninput="orderUniqRange(this)"
                       style="background-image: linear-gradient(to right, rgb(143, 175, 64) 0%, rgb(143, 175, 64) 21.1111%, rgb(243, 243, 243) 21.1111%, rgb(243, 243, 243) 100%);">
            </div>
        </div></div></div>';
    }
    if (get_option("mc_na5ku_inline_addOptions") != "-1") {
        $return .= '
                <div class="row">
                    <div class="col-md-12 text-center toggle-requirements-block">
                        <a href="javascript://" onclick="toggleAddRequirements(this)"
                           class="toggle-requirements-link">' . __("Дополнительные требования", NA5KU_LANG_PACK_DOMAIN) . '</a>
                    </div>
                </div>
                <div class="row toggle-requirements">
                    <div class="col-md-12 two_inp">
                        <label class="must-do-label">
                            <textarea
                                      rows="5"
                                      name="must_do"
                                      class="jq-submit"
                                      placeholder="' . __("Дополнительные требования", NA5KU_LANG_PACK_DOMAIN) . ' (' . __("Не обязательно", NA5KU_LANG_PACK_DOMAIN) . ')"></textarea>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label class="calculation-upload-container"
                               for="' . $id . '">
                            <input type="file" name="upload2[]"
                                   id="' . $id . '" class="calculation-upload-input"
                                   onchange="do_count_filesNew(this)"
                                   multiple>
                            <label for="' . $id . '">' . __("Прикрепить файлы", NA5KU_LANG_PACK_DOMAIN) . '</label>
                        </label>
                        <p class="files-counter"></p>
                        <p class="calculation-form-required-info">' . __("Удерживайте", NA5KU_LANG_PACK_DOMAIN) . '
                            <span
                                    class="info-ctrl">ctrl</span>
                            ' . __("для добавления нескольких файлов.", NA5KU_LANG_PACK_DOMAIN) . '
                        </p>
                    </div>
                </div>';

    }
    $return .= '</div>
        <div class="row">
            <div class="col-md-12 text-center">
                <label class="reg_text_send_header"></label>
                <button type="submit"
                        class="cta__button"
                        style="background: ' . $color . '">' . __($registerText, NA5KU_LANG_PACK_DOMAIN) . '</button>
            </div>
        </div>

    </form>' .
        renderJSAndCSSReg();

    return $return;
}

/**
 * @return string
 */
function renderJSAndCSSReg()
{
    global $dbLang;
    $color = get_option('mc_bg_button_color');
    $bgColor = get_option('mc_na5ku_inline_form_bg');
    $paddings = [];
    $paddings['top'] = get_option('mc_na5ku_inline_form_padding_top');
    $paddings['bottom'] = get_option('mc_na5ku_inline_form_padding_bottom');
    $paddings['right'] = get_option('mc_na5ku_inline_form_padding_right');
    $paddings['left'] = get_option('mc_na5ku_inline_form_padding_left');

    if (!$bgColor) {
        $bgColor = '#fff';
    }

    wp_enqueue_style('na5ku-inline-form.css');
    wp_enqueue_style('na5ku-select2.css');
    wp_enqueue_script('na5ku-select2.full.min.js');
    wp_enqueue_script('na5ku-select2.lang.js');

    wp_enqueue_style('jquery.datetimepicker.css');
    wp_enqueue_script('jquery.datetimepicker.js');


    $return = '
    <script>
       document.na5kuSelect2Lang = "' . ($dbLang == 'ru' ? 'ru' : 'uk') . '";
    </script>

    <style>
        .na5ku-order-form .toggle-requirements-link {
            border-bottom: 1px dashed' . $color . ';
            color: ' . $color . ';
        }

        .na5ku-order-form .toggle-requirements-link:hover {
            color: ' . $color . 'aa;
        }

        .na5ku-order-form .calculation-range {
            background: linear-gradient(to right, ' . $color . ' 0%, #f3f3f3 0%);
        }

        .na5ku-order-form .calculation-range::-webkit-slider-thumb {
            box-shadow: 0 0 0px 5px' . $color . ';
        }

        .na5ku-order-form .calculation-range::-moz-range-thumb {
            box-shadow: 0 0 0px 5px' . $color . ';
        }

        .na5ku-order-form .calculation-range::-ms-thumb {
            box-shadow: 0 0 0px 5px' . $color . ';
        }

        .na5ku-order-form .toggle-requirements-link {
            color: ' . $color . ' !important;
            border-bottom-color: ' . $color . ' !important;
        }

        .na5ku-order-form {
            background-color: ' . $bgColor . ';
        ' . ($paddings['top'] !== false ? 'padding-top: ' . $paddings['top'] . 'px !important;' : '') . ($paddings['bottom'] !== false ? 'padding-bottom: ' . $paddings['bottom'] . 'px !important;' : '') . ($paddings['right'] !== false ? 'padding-right: ' . $paddings['right'] . 'px !important;' : '') . ($paddings['left'] !== false ? 'padding-left: ' . $paddings['left'] . 'px !important;' : '') . '
        }
    </style>
    ';
    wp_enqueue_script('na5ku-inline-form.js');
    wp_enqueue_script('na5ku-maskedInput');
    return $return;
}
