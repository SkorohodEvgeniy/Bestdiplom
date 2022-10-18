<?php
/**
 *
 *  @package HREFLANG Tags\Includes\Variables
 *  @since 1.3.3
 *
 */

if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
$hreflanguages = array();
$hreflanguages['it'] = array('language' => 'it','english_name' => 'ru-UA', 'iso' => array('it'));//ru-UA
$hreflanguages['it_IT'] = array('language' => 'it_IT','english_name' => 'ru-BY', 'iso' => array('it'));//ru-BY
$hreflanguages['fr'] = array('language' => 'fr','english_name' => 'ru-KZ', 'iso' => array('fr'));//ru-KZ
$hreflanguages['fr_CH'] = array('language' => 'fr_CH','english_name' => 'uk-UA', 'iso' => array('fr'));//uk-UA
$hreflanguages['es'] = array('language' => 'es','english_name' => 'by', 'iso' => array('es'));//by
$hreflanguages['de'] = array('language' => 'de','english_name' => 'kz', 'iso' => array('de'));//kz
$hreflanguages['zh_Hant'] = array('language' => 'zh_Hant','english_name' => 'uk', 'iso' => array('zh'));//uk
$hreflanguages['x-default'] = array('language' => '','english_name' => ' X-Default',);
$hreflanguages['ru'] = array('language' => 'ru','english_name' => 'Russian ru', 'iso' => array('ru'));
$hreflanguages['ru_RU'] = array('english_name' => 'Russian ru_Ru');
unset($hreflanguages['de_CH_informal']);
unset($hreflanguages['de_DE_formal']);
$hreflanguages = hreflang_array_sort($hreflanguages,'english_name');

global $hreflanguages;

									if($lang == "it"){
										$lang_n = "ru_UA";
									} else if($lang == "it_IT"){
										$lang_n = "ru_BY";
									} else if($lang == "fr"){
										$lang_n = "ru_KZ";
									} else if($lang == "fr_CH"){
										$lang_n = "uk_UA";
									} else if($lang == "es"){
										$lang_n = "by";
									} else if($lang == "de"){
										$lang_n = "kz";
									} else if($lang == "zh_Hant"){
										$lang_n = "uk";
									} else {
										$lang_n = str_replace('_','-', $lang);
									}