<?php
/**
 * Plugin Name: Na5ku API Cabinet
 * Description: Na5ku API cabinet for our partners
 * Version: 2020.9.29
 */

define('NA5KU_ADMIN_LINK', 'na5ku-cabinet-setup');
require_once __DIR__ . '/api_wrappers/BaseApiWrapper.php';
require_once __DIR__ . '/api_wrappers/TypeOrder.php';
require_once __DIR__ . '/api_wrappers/SubjectOrder.php';
require_once __DIR__ . '/api_wrappers/GenSettings.php';
$dbLang = get_option('mc_bg_valuta');
define('NA5KU_DB_LANG', $dbLang);
define('NA5KU_PLUGIN_URL', str_replace(home_url() . '/', '', plugins_url()) . '/cabinet_partner_na5ku');
add_action('admin_menu', 'cabinetPartnerNa5kuMenu');

function cabinetPartnerNa5kuMenu()
{
    add_menu_page('Настройки партнерского кабинета', 'Настройки кабинета', 'manage_options',
        NA5KU_ADMIN_LINK, 'renderContent', 'dashicons-welcome-learn-more');
}


require_once __DIR__ . "/short_codes/short_functions.php";
require_once __DIR__ . "/short_codes/short_code_button.php";
require_once __DIR__ . "/short_codes/short_mini_form.php";
require_once __DIR__ . "/short_codes/short_inline_form.php";
require_once __DIR__ . "/short_codes/short_inline_calculator.php";
require_once __DIR__ . "/short_codes/short_last_jobs.php";

require_once __DIR__ . "/routes/routes.php";

define('SHORT_BUTTONS_NAV', 'button_register_login');
define('SHORT_MINI_FORM', 'button_register_line');
define('SHORT_INLINE_FORM', 'na5ku_form_inline');
define('SHORT_INLINE_FORM_VERTICAL', 'na5ku_form_inline_vertical');
define('SHORT_INLINE_CALCULATOR', 'na5ku_inline_calculator');
define('SHORT_LAST_JOBS', 'na5ku_last_jobs');

define('NA5KU_CNF_DEF_COLOR', '#8080ff');

if (!defined('NA5KU_LANG_PACK_DOMAIN')) {
    define('NA5KU_LANG_PACK_DOMAIN', 'cabinet_partner_na5ku');
}

add_shortcode(SHORT_BUTTONS_NAV, 'button_register_login_r');
add_shortcode(SHORT_MINI_FORM, 'mini_form');
add_shortcode(SHORT_INLINE_FORM, 'na5ku_form_inline');
add_shortcode(SHORT_INLINE_FORM_VERTICAL, 'na5ku_form_inline_vertical');
add_shortcode(SHORT_INLINE_CALCULATOR, 'na5ku_inline_calculator');
add_shortcode(SHORT_LAST_JOBS, 'na5ku_last_jobs');


function na5kuScriptsAdminka()
{
    wp_register_script('na5ku-adminka.js', plugin_dir_url(__FILE__) . 'assets/js/adminka.js', array('jquery'), time());
    wp_enqueue_script('na5ku-adminka.js');
}

wp_register_style('na5ku-bootstrap.css', NA5KU_CDN_URL . 'lib/bootstrap-3.3.5-dist/css/bootstrap.min.css', array(), '3.3.5');

function na5kuScripts()
{
    if (is_admin()) {
        return;
    }

    wp_register_script('na5ku-jquery-3.4.1.js', NA5KU_CDN_URL . 'lib/jquery/jquery-3.4.1.min.js', array('jquery'), 1);
    wp_register_script('na5ku-bootstrap.js', NA5KU_CDN_URL . 'lib/bootstrap-3.3.5-dist/js/bootstrap.min.js', array('jquery'), '3.3.5');
    wp_register_script('main.js', plugin_dir_url(__FILE__) . 'js/main.js', array('jquery'), time());
    wp_register_script('na5ku-select2.full.min.js', NA5KU_CDN_URL . 'lib/select2/select2.full.min.js', array('jquery'), 2);
    wp_register_script('na5ku-select2.lang.js', NA5KU_CDN_URL . 'lib/select2/i18n/' . (NA5KU_DB_LANG === 'ru' ? 'ru' : 'uk') . '.js', array('jquery'), 1);
    wp_register_script('na5ku-inline-form.js', plugin_dir_url(__FILE__) . 'assets/js/inline-form.js', array('jquery'), time());
    wp_register_script('na5ku-mini-form.js', plugin_dir_url(__FILE__) . 'assets/js/mini-form.js', array('jquery'), time());
    wp_register_script('na5ku-inline-calc.js', plugin_dir_url(__FILE__) . 'assets/js/inline-calc.js', array('jquery'), time());
    wp_register_script('na5ku-last-jobs.js', plugin_dir_url(__FILE__) . 'assets/js/last-jobs.js', array('jquery'), time());
    wp_register_script('na5ku-front.js', plugin_dir_url(__FILE__) . 'assets/js/front.js', array('jquery'), time());
    wp_register_script('na5ku-maskedInput', NA5KU_CDN_URL .'lib/masked-input/maskedinput.min.js', array('jquery'), time());

    wp_register_script('na5ku-login-register.js', plugin_dir_url(__FILE__) . 'assets/js/login-register.js', array('jquery'), time());
    wp_register_script('jquery.datetimepicker.js', NA5KU_CDN_URL . 'lib/datetime/jquery.datetimepicker.js', array('jquery'), 1);

    wp_register_style('magnific-popup.css', NA5KU_CDN_URL . 'lib/magnific-popup/magnific-popup.css', array(), time());
    wp_register_style('all.css', NA5KU_CDN_URL . 'lib/fontawesome-free-5.7.2-web/css/all.css', array(), 1);
    wp_register_style('fontawesome-free-5.7.2.css', NA5KU_CDN_URL . 'lib/fontawesome-free-5.7.2-web/css/all.css', array(), 1);
    wp_register_style('regular.css', NA5KU_CDN_URL . 'lib/fontawesome-free-5.7.2-web/css/regular.css', array(), time());
    wp_register_style('fontawesome.css', NA5KU_CDN_URL . 'lib/fontawesome-free-5.7.2-web/css/fontawesome.css', array(), 1);
    wp_register_style('fontawesome4.6.css', NA5KU_CDN_URL . 'lib/font-awesome-4.6.1/css/font-awesome.min.css', array(), 1);
    wp_register_style('solid.css', NA5KU_CDN_URL . 'lib/fontawesome-free-5.7.2-web/css/solid.css', array(), 1);
    wp_register_style('na5ku-guest.css', plugin_dir_url(__FILE__) . 'assets/css/na5ku-guest.css', array(), time());
    wp_register_style('na5ku-inline-form.css', plugin_dir_url(__FILE__) . 'assets/css/inline-form.css', array(), time());
    wp_register_style('na5ku-mini-form.css', plugin_dir_url(__FILE__) . 'assets/css/mini-form.css', array(), time());
    wp_register_style('na5ku-inline-calc.css', plugin_dir_url(__FILE__) . 'assets/css/inline-calc.css', array(), time());
    wp_register_style('na5ku-last-jobs.css', plugin_dir_url(__FILE__) . 'assets/css/last-jobs.css', array(), time());
    wp_register_style('na5ku-select2.css', NA5KU_CDN_URL . 'lib/select2/select2.min.css', array(), 2);
    wp_register_style('jquery.datetimepicker.css', NA5KU_CDN_URL . 'lib/datetime/jquery.datetimepicker.css', array(), 1);


    /** CALL */
    wp_enqueue_script('main.js', '', '', time());
    wp_enqueue_script('na5ku-front.js', '', '', time());
    wp_enqueue_style('magnific-popup.css');

    wp_enqueue_style('all.css');
    wp_enqueue_style('regular.css');
    wp_enqueue_style('fontawesome.css');
    wp_enqueue_style('solid.css');
}

function renderContent()
{
    ob_start();
    include_once(__DIR__ . '/install_options.php');
    $content = ob_get_clean();
    echo $content;
}

function na5kuUpdateConf($varName)
{
    $varValue = $_POST[$varName];
    if (get_option($varName) != $varValue) {
        update_option($varName, $varValue);
    }
}

function frontHeader()
{
    echo renderJSConst();
}

function guestHeader()
{
    if (get_option('mc_na5ku_bootstrap') != -1) {
        wp_enqueue_style('na5ku-bootstrap.css');
        wp_enqueue_script('na5ku-bootstrap.js');
    }

    echo renderJSConst();
}

add_action('wp_enqueue_scripts', 'na5kuScripts', 1);
add_action('admin_enqueue_scripts', 'na5kuScripts', 1);
add_action('admin_enqueue_scripts', 'na5kuScriptsAdminka', 1);
add_action('admin_head', 'frontHeader', 1);
add_action('wp_enqueue_scripts', 'guestHeader', 1);

