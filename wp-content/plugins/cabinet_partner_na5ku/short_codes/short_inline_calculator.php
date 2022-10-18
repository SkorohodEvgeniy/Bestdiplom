<?php

/**
 * @return string
 */
function na5ku_inline_calculator()
{
    $color = get_option('mc_bg_button_color');
    $valutaStr = na5ku_getValutaStr();

    if (!$color) {
        $color = NA5KU_CNF_DEF_COLOR;
    }

    $registerText = get_option('mc_na5ku_inline_calc_action');
    if (!$registerText) {
        $registerText = 'Узнать точную стоимость';
    }


    $return = renderJSConst() . '
    <script>
        document.NA5KU_CALC_type_date="' . __("Выберите дату", NA5KU_LANG_PACK_DOMAIN) . '!";
        document.NA5KU_CALC_something_went_wrong="' . __("Что-то пошло не так", NA5KU_LANG_PACK_DOMAIN) . '!";
        document.NA5KU_CALC_sending="' . __("Отправка...", NA5KU_LANG_PACK_DOMAIN) . '";
        document.NA5KU_CALC_redirecting="' . __("Перенаправление...", NA5KU_LANG_PACK_DOMAIN) . '";
    </script>
    <form class="na5ku-order-form na5ku-calc-form calculator-form" onsubmit="na5kuInlineCalcSubmit(this); return false;"
          autocomplete="off" onchange="na5kuInlineCalcPrice(this);">
        <div class="form-group">
            <label class="price-label"><span class="calcCenaTotal">-</span>  <span class="calcCenaValuta">' . __($valutaStr, NA5KU_LANG_PACK_DOMAIN) . '</span></label>
        </div>
        <div class="form-group">
            <label class="form-label">' . __("Тип работы", NA5KU_LANG_PACK_DOMAIN) . ':</label>
            <select name="type" class="form-control init-select2 workType na5ku-type-list" tabindex="-1" aria-hidden="true"></select>
        </div>

        <div class="form-group deadlineGroup">
            <label class="form-label">' . __("Дата сдачи", NA5KU_LANG_PACK_DOMAIN) . ':</label>
            <input type="text" name="date" placeholder="' . __("Выберите дату", NA5KU_LANG_PACK_DOMAIN) . '" readonly="" class="form-control orderDeadline">
            <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span>
        </div>
        <div class="form-group mb-0">
            <div class="calculation-range-container">
                <p class="range-info">' . __("Количество страниц", NA5KU_LANG_PACK_DOMAIN) . ': <span
                            class="range-result"><span
                                class="range-number">1</span></span></p>
                <input type="range" class="calculation-range pagesCount" min="1" max="150" value="1"
                       name="original" oninput="orderPagesRange(this)"
                       style="background-image: linear-gradient(to right, rgb(143, 175, 64) 0%, rgb(143, 175, 64) 21.1111%, rgb(243, 243, 243) 21.1111%, rgb(243, 243, 243) 100%);">
            </div>
        </div>';

    if (get_option('mc_na5ku_uniq')) {
        $return .= '<div class="form-group mb-0">
            <div class="calculation-range-uniq-container">
                <p class="range-info">' . __("Уникальность", NA5KU_LANG_PACK_DOMAIN) . ': <span
                            class="range-result"><span
                                class="range-number">50</span></span></p>
                <input type="range" class="calculation-range-uniq uniqCount" min="1" max="90" value="50"
                       name="uniq" oninput="orderUniqRange(this)"
                       style="background-image: linear-gradient(to right, rgb(143, 175, 64) 0%, rgb(143, 175, 64) 21.1111%, rgb(243, 243, 243) 21.1111%, rgb(243, 243, 243) 100%);">
            </div>
        </div>';
    }

    $return .= '
        <div class="form-group text-center">
            <div class="response-msg"></div>
            <button class="button" type="submit"
                    style="background: ' . $color . '">' . __($registerText, NA5KU_LANG_PACK_DOMAIN) . '</button>
        </div>
    </form>
    ' . renderCalcJSAndCSSReg();

    return $return;
}

/**
 * @return string
 */
function renderCalcJSAndCSSReg()
{
    $bgColor = get_option('mc_na5ku_inline_calc_bg');
    $bgColor2 = get_option('mc_na5ku_inline_calc_bg2');
    $bgColorBorder = get_option('mc_na5ku_inline_calc_bgBorder');
    $paddings = [];
    $paddings['top'] = get_option('mc_na5ku_inline_calc_padding_top');
    $paddings['bottom'] = get_option('mc_na5ku_inline_calc_padding_bottom');
    $paddings['right'] = get_option('mc_na5ku_inline_calc_padding_right');
    $paddings['left'] = get_option('mc_na5ku_inline_calc_padding_left');

    if (!$bgColor) {
        $bgColor = '#fafafa';
    }
    if (!$bgColor2) {
        $bgColor2 = '#f1f1f1';
    }
    if (!$bgColorBorder) {
        $bgColorBorder = '#ededed';
    }

    wp_enqueue_style('na5ku-inline-calc.css');
    wp_enqueue_style('na5ku-select2.css');
    wp_enqueue_script('na5ku-select2.full.min.js');
    wp_enqueue_script('na5ku-select2.lang.js');

    wp_enqueue_style('jquery.datetimepicker.css');
    wp_enqueue_script('jquery.datetimepicker.js');


    $return = '<style>
        :root {
            --na5ku-inline-calc-bg: ' . $bgColor . ';
            --na5ku-inline-calc-bg2: ' . $bgColor2 . ';
            --na5ku-inline-calc-bgBorder: ' . $bgColorBorder . ';
        }
        
        .na5ku-order-form.na5ku-calc-form {
            background-color: ' . $bgColor . ';
        ' . ($paddings['top'] !== false ? 'padding-top: ' . $paddings['top'] . 'px !important;' : '') . ($paddings['bottom'] !== false ? 'padding-bottom: ' . $paddings['bottom'] . 'px !important;' : '') . ($paddings['right'] !== false ? 'padding-right: ' . $paddings['right'] . 'px !important;' : '') . ($paddings['left'] !== false ? 'padding-left: ' . $paddings['left'] . 'px !important;' : '') . '
        }
    </style>';

    wp_enqueue_script('na5ku-inline-calc.js');
    return $return;
}
