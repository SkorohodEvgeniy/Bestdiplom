<?php

/**
 * @return string
 */
function renderJSConst()
{
    include_once __DIR__ . '/../cabinet/baza.php';
    if (!defined('NA5KU_JS_CONSTS_RENDERED')) {
        define('NA5KU_JS_CONSTS_RENDERED', 1);
    } else {
        return '';
    }

    wp_enqueue_style('na5ku-guest.css');

    if (get_option('mc_na5ku_jq341') != -1) {
        wp_enqueue_script('na5ku-jquery-3.4.1.js');
    }

    wp_enqueue_script('na5ku-login-register.js');

    $mc_bg_ref_id = get_option('mc_bg_ref_id');
    $mc_bg_valuta = get_option('mc_bg_valuta');
    $NA5KU_API_KEY = get_option('mc_na5ku_api_key');
    $NA5KU_TYPES_LANG = get_option('mc_bg_type_lang');
    $valutaID = na5ku_getValutaId();
    $NA5KU_API_URL = NA5KU_API_URL;
    $NA5KU_APP_VER = NA5KU_APP_VER;
    $NA5KU_DB_LANG = NA5KU_DB_LANG;

    $mc_bg_button_color = get_option('mc_bg_button_color');
    if (!$mc_bg_button_color) {
        $mc_bg_button_color = NA5KU_CNF_DEF_COLOR;
    }

    $select2Lang = 'ru';

    if (NA5KU_DB_LANG === 'ua') {
        $select2Lang = 'uk';
    }

    return <<<HTML
    <style>
        :root {
            --na5ku-buttons-bg: {$mc_bg_button_color};
        }
    </style>
    <script>
        var NA5KU_APP_VER = '{$NA5KU_APP_VER}';
        var NA5KU_API_URL = '{$NA5KU_API_URL}';
        var NA5KU_API_KEY = '{$NA5KU_API_KEY}';
        var NA5KU_REF_ID = '{$mc_bg_ref_id}';
        var NA5KU_VALUTA = '{$mc_bg_valuta}';
        var NA5KU_TYPES_LANG = '{$NA5KU_TYPES_LANG}';
        
        if(typeof(na5kuCalcSelect2Lang) === 'undefined'){
            var na5kuCalcSelect2Lang = "{$select2Lang}";
            var na5kuCalcValuta = "{$valutaID}";
            var na5kuCalcRangeColor = "{$mc_bg_button_color}";
        }
    </script>
HTML;
}

function na5ku_getValutaStr()
{
    switch (get_option('mc_bg_valuta')) {
        case 'ru':
            return 'RUB';
        case 'usd':
            return 'USD';
        default:
            return 'UAH';
    }
}

function na5ku_getValutaId()
{
    switch (get_option('mc_bg_valuta')) {
        case 'ru':
            return 2;
        case 'usd':
            return 3;
        default:
            return 1;
    }
}
