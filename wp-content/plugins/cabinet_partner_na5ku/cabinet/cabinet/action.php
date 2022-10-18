<?php

$json = [];
$json['status'] = false;
$json['msg'] = '';
$json['needPhone'] = true;

if (isset($user_data) && isset($user_data['id']) && $user_data['id']) {
    $json['auth'] = true;
    if (check_phone($user_data['phone'])) {
        $json['needPhone'] = false;
    }
} else {
    $json['auth'] = false;
}


$a2 = $_GET['a2'];
if ($a2 == 'checkSession') {
    require_once(__DIR__ . '/_action/checkSession.php');
} elseif ($a2 == 'inlineForm') {
    require_once(__DIR__ . '/_action/inlineForm.php');
} elseif ($a2 == 'gateway') {
    require_once(__DIR__ . '/_action/gateway.php');
} else {
    $json['msg'] .= 'Wrong Action';
}

echo json_encode($json);

die();
