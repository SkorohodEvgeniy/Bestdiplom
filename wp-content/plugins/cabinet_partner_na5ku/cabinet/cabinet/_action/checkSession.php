<?php

$json['needPhonePlaceholder'] = '';
$json['needPhoneMask'] = '';

$Config = new GenSettings();
if($json['auth']){
    $config = $Config->getCountry($user_data['valuta']);
} else {
    $config = $Config->getCountry($user_data['mc_bg_valuta']);
}

$json['needPhonePlaceholder'] = $config['country_phone_placeholder'];
$json['needPhoneMask'] = $config['country_phone_mask'];
