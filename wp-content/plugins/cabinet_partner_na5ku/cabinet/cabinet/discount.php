<?php
$orderApi = new Order();
$summ = $orderApi->sumPaidForOrder([
    'id' => $user_data['id']
]);


//$q="select sum(paid_pre + paid_next) as 's' from `zakaz` where `client_id`='$user_data[id]' and `status`<8";
//echo $q;
//$summ=baza_do_one($q);
$summ = $summ['data'][0];
$summ = $summ['s'];


$procent_will = $skidka_will[0];
$summ_need = $skidka_need[0];
$procent_now = 0;
for ($i = count($skidka_need) - 1; $i >= 0; $i--) {
    if ($summ > $skidka_need[$i]) {
        $procent_now = $skidka_will[$i];
        $procent_will = $skidka_will[$i + 1];
        $summ_need = $skidka_need[$i + 1];
        break;
    }
}
$summ_need++;
$summ_need--;
if ($summ_need == 0) {
    $div_procent = 100;
    $div_procent2 = 100;
} else {

    $div_procent = (int)($summ / $summ_need * 100);
    if ($div_procent < 1) $div_procent = 1;
    if ($div_procent > 100) $div_procent = 100;
    $div_procent2 = (int)($procent_now / 80 * 100);
    if ($div_procent2 < 1) $div_procent2 = 1;
    if ($div_procent2 > 100) $div_procent2 = 100;
}
if ($div_procent < 0)
    $div_text = "Сумма: " . number_format($summ, 0, ',', ' ') . " / " . number_format($summ_need, 0, ',', ' ') . " " . $user_data['valutaSTR'];

else {
    if ($summ_need == 0) $summ_need = $skidka_need[count($skidka_need) - 1];
    $div_text = "Сумма: " . number_format($summ, 0, ',', ' ') . " / " . number_format($summ_need, 0, ',', ' ') . " " . $user_data['valutaSTR'];
}


if ($div_procent2 < 0)
    $div_text2 = "Скидка: $procent_now% / $procent_will%";
else {
    if ($procent_will == 0) $procent_will = $skidka_will[count($skidka_will) - 1];
    $div_text2 = "Скидка: $procent_now% / $procent_will%";
}

/*
<div class="row">
	<div class="col-md-12">
		<div class="progress">
			<div role="progressbar" aria-valuenow="<?=$div_procent?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$div_procent?>%" class="progress-bar progress-bar-success"> </div>
			<div class="progress-percent text-left"><?=$div_text?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="progress">
			<div role="progressbar" aria-valuenow="<?=$div_procent2?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$div_procent2?>%" class="progress-bar progress-bar-success"> </div>
			<div class="progress-percent"><?=$div_text2?></div>
		</div>
	</div>
</div>
*/

?>
<div class="row">
    <div class="col-md-12">
        <div class="page-wrap">
            <div class="icon-title safe">
                <h2 style='margin: 0 !important;'>Накопительная система</h2>
            </div>
            <div class="icon-title sale">
                <p>У нас действует накопительная скидка. При достижении определенной суммы указанной на графике вы
                    будете получать указанный % скидки на все свои заказы. Больше тратите - больше экономите.</p>
            </div>
            <div class="storage-wrap">
                <div class="storage-system">
                    <div class="economy">Вы экономите</div>
                    <div class="tree-0 active"></div>
                    <div class="tree-5 <?= (($procent_will > 5) ? "active" : "") ?>"></div>
                    <div class="tree-10 <?= (($procent_will > 10) ? "active" : "") ?>"></div>
                    <div class="tree-15 <?= (($procent_will == 15 && $procent_now == 15) ? "active" : "") ?> "></div>
                </div>
                <div class="spend-system">
                    <div class="spend">Вы тратите</div>
                    <div class="spend-0 <?= (($procent_now == 0) ? "active" : "") ?>">
                        0 <?= $user_data['valutaSTR'] ?></div>
                    <div class="spend-5 <?= (($procent_now == 5) ? "active" : "") ?>">
                        1000 <?= $user_data['valutaSTR'] ?></div>
                    <div class="spend-10 <?= (($procent_now == 10) ? "active" : "") ?>">
                        5000 <?= $user_data['valutaSTR'] ?></div>
                    <div class="spend-15 <?= (($procent_will == 15) ? "active" : "") ?>">
                        10000 <?= $user_data['valutaSTR'] ?></div>
                </div>
                <div class="storage-total">Всего потрачено: <span>
					<?= number_format($summ, 0, ',', ' ') ?>
                        <?= $user_data['valutaSTR'] ?> - скидка <?= $procent_now ?>%</span></div>
            </div>

            <?php

            $count = $orderApi->paidCount([
                'id' => $user_data['id']
            ]);


            //            $q="select count(*) as 'c' from `zakaz` where (`pay_client`='1' or `pay_predoplata`='1') and `client_id`='$user_data[id]'";
            //            $info2=baza_do_one($q);
            $info2 = $count['data'];
            // echo $q;

            $info = $orderApi->paidCount([
                'id' => $user_data['id']
            ]);


            //            $q="select id from `zakaz` where `promo_code`='fr015-$user_data[id]'";
            //            $info=baza_do_one($q);
            $info = $info['data'];


            if ($info > 0 || $info2 > 0) {
            } else {
                ?>

                <div class="icon-title sale">
                    <h2>Скидка на перый заказ 5%</h2>
                    <p>Нажми на кнопку "промокод" на странице заказа и введи
                        <strong>fr015-<?= $user_data['id'] ?></strong>. Вы получите скидку на ваш первый заказ.</p>
                </div>
            <?php } ?>
            <div class="icon-title money">
                <h2>15% скидки на работы по одной методичке</h2>
                <p>Закажите с другом работы по одной методичке и получите 15% скидки на каждую работу. Данная скидка
                    применяется к контрольным, курсовым, расчетным работам, где нужно выполнить одинаковое задание но по
                    разным вариантам или темам.</p>
            </div>
        </div>
    </div>
</div>



