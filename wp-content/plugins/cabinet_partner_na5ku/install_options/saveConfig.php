<?php
$successMSG = false;

if (isset($_POST['wphw_submit'])) {
    na5kuUpdateConf('mc_bg_valuta');
    na5kuUpdateConf('mc_bg_button_color');
    na5kuUpdateConf('mc_bg_ref_id');
    na5kuUpdateConf('mc_na5ku_bootstrap');
    na5kuUpdateConf('mc_na5ku_jq341');
    na5kuUpdateConf('mc_na5ku_uniq');
    na5kuUpdateConf('mc_na5ku_api_key');
    na5kuUpdateConf('mc_bg_type_lang');

    $successMSG = true;
}

if (isset($_POST['wphw_submit-na5ku-cabinet'])) {
    /** MAIN FORM */
    na5kuUpdateConf('mc_bg_text_title');
    na5kuUpdateConf('mc_bg_phone1');
    na5kuUpdateConf('mc_bg_phone2');
    na5kuUpdateConf('mc_bg_text_footer');
    na5kuUpdateConf('mc_na5ku_cabinet_css');
    na5kuUpdateConf('mc_na5ku_cabinet_js');

    /** NAVIGATION */
    na5kuUpdateConf('mc_na5ku_hideFAQ');
    na5kuUpdateConf('mc_na5ku_hideSamples');
    na5kuUpdateConf('mc_na5ku_hideEarn');
    na5kuUpdateConf('mc_na5ku_hideDiscount');

    /** ORDER FORM */
    na5kuUpdateConf('mc_na5ku_subjectReplaceSpec');
    na5kuUpdateConf('mc_na5ku_hidePrePrice');
    na5kuUpdateConf('mc_na5ku_hidePages');

    $successMSG = true;
}

if (isset($_POST['wphw_submit-na5ku-mini'])) {
    na5kuUpdateConf('mc_home_reg_action');
    na5kuUpdateConf('mc_home_reg_action_placeholder');
    na5kuUpdateConf('mc_mini_show_types');

    $successMSG = true;
}

if (isset($_POST['wphw_submit_logo'])) {
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    if (isset($_FILES['mc_bg_header_logo']['name'])) {
        $file = &$_FILES['mc_bg_header_logo'];
        $overrides = ['test_form' => false];
        $movefile = wp_handle_upload($file, $overrides);
        if ($movefile && empty($movefile['error'])) {
            $chk4 = update_option('mc_bg_header_logo', $movefile['url']);
        } else {
            echo "Файл не загрузился!\n";
        }

        $successMSG = true;
    }

}

if (isset($_POST['wphw_submit-na5ku-form'])) {
    na5kuUpdateConf('mc_na5ku_inline_form_action');
    na5kuUpdateConf('mc_na5ku_inline_addOptions');
    na5kuUpdateConf('mc_na5ku_inline_form_bg');

    $varName = 'mc_na5ku_inline_form_padding_top';
    $varValue = intval($_POST[$varName]);
    if ($varValue < 0 || $varValue > 1000) {
        $varValue = 0;
    }
    if (get_option($varName) != $varValue) {
        update_option($varName, $varValue);
    }

    $varName = 'mc_na5ku_inline_form_padding_bottom';
    $varValue = intval($_POST[$varName]);
    if ($varValue < 0 || $varValue > 1000) {
        $varValue = 0;
    }
    if (get_option($varName) != $varValue) {
        update_option($varName, $varValue);
    }

    $varName = 'mc_na5ku_inline_form_padding_left';
    $varValue = intval($_POST[$varName]);
    if ($varValue < 0 || $varValue > 1000) {
        $varValue = 0;
    }
    if (get_option($varName) != $varValue) {
        update_option($varName, $varValue);
    }

    $varName = 'mc_na5ku_inline_form_padding_right';
    $varValue = intval($_POST[$varName]);
    if ($varValue < 0 || $varValue > 1000) {
        $varValue = 0;
    }
    if (get_option($varName) != $varValue) {
        update_option($varName, $varValue);
    }

    $successMSG = true;
}

if (isset($_POST['wphw_submit-na5ku-calc'])) {
    na5kuUpdateConf('mc_na5ku_inline_calc_action');
    na5kuUpdateConf('mc_na5ku_inline_calc_bg');
    na5kuUpdateConf('mc_na5ku_inline_calc_bg2');
    na5kuUpdateConf('mc_na5ku_inline_calc_bgBorder');

    $varName = 'mc_na5ku_inline_calc_padding_top';
    $varValue = intval($_POST[$varName]);
    if ($varValue < 0 || $varValue > 1000) {
        $varValue = 0;
    }
    if (get_option($varName) != $varValue) {
        update_option($varName, $varValue);
    }

    $varName = 'mc_na5ku_inline_calc_padding_bottom';
    $varValue = intval($_POST[$varName]);
    if ($varValue < 0 || $varValue > 1000) {
        $varValue = 0;
    }
    if (get_option($varName) != $varValue) {
        update_option($varName, $varValue);
    }

    $varName = 'mc_na5ku_inline_calc_padding_left';
    $varValue = intval($_POST[$varName]);
    if ($varValue < 0 || $varValue > 1000) {
        $varValue = 0;
    }
    if (get_option($varName) != $varValue) {
        update_option($varName, $varValue);
    }

    $varName = 'mc_na5ku_inline_calc_padding_right';
    $varValue = intval($_POST[$varName]);
    if ($varValue < 0 || $varValue > 1000) {
        $varValue = 0;
    }
    if (get_option($varName) != $varValue) {
        update_option($varName, $varValue);
    }

    $successMSG = true;
}
