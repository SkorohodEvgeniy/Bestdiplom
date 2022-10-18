<?php

/**
 * @return string
 */
function mini_form()
{
    $registerText = get_option('mc_home_reg_action');
    if (!$registerText) {
        $registerText = 'Зарегистрироваться';
    }

    $emailPlaceholder = get_option('mc_home_reg_action_placeholder');
    if (!$emailPlaceholder) {
        $emailPlaceholder = 'Электронная почта *';
    }

    $showTypes = get_option('mc_mini_show_types');
    wp_enqueue_script('na5ku-mini-form.js');
    wp_enqueue_style('na5ku-mini-form.css');

    $result = renderJSConst() . '
    <div class="row">
        <div class="col-md-12">
            <form class="jq-local-registration-container mini-form" method="post"
                  onsubmit="na5ku_miniForm(this); return false;">';

    if ($showTypes == 1) {
        $result .= '<div class="form-group clearfix">
                    <select class="na5ku-type-list" name="type"></select>
                </div>';
    }

    $result .= ' <div class="form-group clearfix">
                    <input type="email" name="email" placeholder="' . __($emailPlaceholder, NA5KU_LANG_PACK_DOMAIN) . '"
                           class="mail_reg_home" value="" required>
                </div>
                <div class="form-group clearfix">
                    <button type="submit"
                           class="btn btn-default price-button">' . __($registerText, NA5KU_LANG_PACK_DOMAIN) . '</button>
                </div>
                <div class="info jq-local-registration-result" style="color:#c30;"></div>
                <input type="hidden" name="ref_id" value="' . get_option('mc_bg_ref_id') . '">
                <input type="hidden" name="valuta" value="' . get_option('mc_bg_valuta') . '">
                <input type="hidden" name="formid" value="price-form">
            </form><!-- /form -->
        </div>
    </div>
    ';

    return $result;
}
