<?php
$menu_active[$a] = 'active';
//print_r($a);
if ($a == "open_new") $menu_active[$a] = 'active_add';
$messagesApi = new Messages();
$count_sms = $messagesApi->getCountMessages([
    'id' => $user_data['id'],
    'manager_id' => $user_data['manager_id']
]);
//var_dump('count_SMS', $count_sms);

if ($user_data['manager_id']) {
    if (isset($count_sms['data']['messages'])) {
        $count_sms = $count_sms['data']['messages'];
    }
} else {
    $count_sms = 0;
}


if ($count_sms > 99) $count_sms = 99;
if ($count_sms > 0) $count_sms = "<div class='checker'>$count_sms</div>";
else $count_sms = "";
$orderOne = [];

$menuItems = 2;
if (get_option('mc_na5ku_hideFAQ') != '1') {
    $menuItems++;
}
if (get_option('mc_na5ku_hideSamples') != '1') {
    $menuItems++;
}
if (get_option('mc_na5ku_hideEarn') != '1') {
    $menuItems++;
}
if (get_option('mc_na5ku_hideDiscount') != '1') {
    $menuItems++;
}

if ($menuItems < 3) {
    $menuItems = 4;
}
?>
<style>
    #vertical-nav ul li {
        width: calc(100% / <?=$menuItems?>);
    }
</style>

<div class='main-content'>
    <div class='row'>
        <div class='col-md-12'>
            <!-- Vertical Nav -->
            <nav id='vertical-nav' class='clearfix'>
                <ul>
                    <li class='add-order <?= $menu_active['open_new'] ?>'>
                        <a href='/cabinet/zakaz.write'>
                            <span>Добавить заказ</span>
                        </a>
                    </li>
                    <li class='<?= $menu_active['main'] ?><?= $menu_active['open_pre'] ?><?= $menu_active['edit_zakaz'] ?><?= $menu_active['open_zakaz'] ?>'>
                        <a href='/cabinet/'>
                            <span>Ваши заказы</span>
                        </a>
                    </li>
                    <?php if (get_option('mc_na5ku_hideFAQ') != '1') { ?>
                        <li class='<?= $menu_active['faq'] ?>'>
                            <a href='/cabinet/faq/'>
                                <span>F.A.Q.</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (get_option('mc_na5ku_hideSamples') != '1') { ?>
                        <li class='<?= $menu_active['examples'] ?>'>
                            <a href='/cabinet/examples/'>
                                <span>Примеры работ</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (get_option('mc_na5ku_hideEarn') != '1') { ?>
                        <li class='<?= $menu_active['friends'] ?>'>
                            <a href='/cabinet/earn/'>
                                <span>ПОМОГАЙТЕ И ЭКОНОМЬТЕ</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (get_option('mc_na5ku_hideDiscount') != '1') { ?>
                        <li class='<?= $menu_active['discount'] ?>'>
                            <a href='/cabinet/discount/'>
                                <span>Скидки</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
