<?php
$ref_data = $user_data;
$promo_code = "fr012-" . (pow($user_data['id'], 3) + 13);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>

<div class="row">
    <div class="col-md-12">
        <div class="page-wrap">
            <div class="icon-title dollar">
                <h2>Помогайте друзьям и экономьте</h2>
            </div>
            <div class="procent-block">
                <div class="image"></div>
                <div class="descr">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="left-block">
                                <p>Посоветуйте нас другу, сбросьте ему свой промокод на скидку 10%. </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="right-block">
                                <p>При оплате заказа друг должен ввести ваш промокод. Друг получит скидку 10%, а Вам на
                                    счет поступит 10% от стоимости его работы.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $orderApi = new Order();

            $count = $orderApi->paidCount([
                'id' => $user_data['id']
            ]);


            //            $q="select count(*) as 'c' from `zakaz` where (`pay_client`='1' or `pay_predoplata`='1') and `client_id`='$user_data[id]'";
            //            $info=baza_do_one($q);
            $info = $count['data'];
            if ($info > 0) {
                $no_z = "Нет заказов";
                $no_z_t = "alert alert-success";
                ?>
                <form class="promocode-form">
                    <div class="form-group clearfix">
                        <label>Ваш промокод:</label>
                        <input type="text" value='<?= $promo_code ?>' readonly>
                    </div>
                </form>
            <?php } else {
                $no_z = "Промокод станет доступным после того как вы оплатите свой первый заказ";
                $no_z_t = "alert alert-warning";
            }
            ?>
            <table class="table table-bordered money-table">
                <thead>
                <tr>
                    <th>ID друга</th>
                    <th>Номер заказа</th>
                    <th>Бонус, <?= $user_data['valutaSTR'] ?></th>
                    <th>%</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                <?php

                $zakazPartner = $orderApi->localPartnerOrder([
                    'promo' => $promo_code,
                    'valuta' => $user_data['valuta']
                ]);

                $zakaz = $zakazPartner['data'];
                if (count($zakaz) == 0) {
                    echo "<tr><td colspan=5><div class='$no_z_t'>$no_z</div></td></tr>";

                } else {
                    for ($i = 0; $i < count($zakaz); $i++) {
                        $za = $zakaz[$i];


                        if ($za['pay_predoplata'] || $za['pay_client']) {

                            $za['status'] = 'Зачислено';
                        } else $za['status'] = 'Ждет оплаты клиентом';

                        $za['bonus'] = $za['cena_skidka'] * $za['ref_proc'] / 100;
                        echo "
	<tr>
		<td>$za[client_id]</td>
		<td>$za[id_for_client]</td>
		<td class='money-td'>$za[bonus]</td>
		<td class='money-td'>$za[ref_proc]</td>
		<td>$za[status]</td>
	</tr>
";
                    }
                }

                ?>

                </tbody>
            </table>
            <div class="icon-title question">
                <h2>Вопросы/Ответы:</h2>
            </div>
            <div class="faq-list">
                <ol>
                    <li>
                        <div class="question">Как воспользоваться этой акцией?</div>
                        <div class="answer">
                            <p>Все просто - скопируйте промокод с этой страницы и сбросьте его другу, который еще не
                                пользовался услугами нашей компании. Вашему другу нужно будет ввести промокод при оплате
                                заказа. Он получит 10% скидки, а вы 10% от стоимости его заказа на бонусный счет.</p>
                        </div>
                    </li>
                    <li>
                        <div class="question">Как воспользоваться промокодом?</div>
                        <div class="answer">
                            <p>Раздел "ваши заказы" - нажмите на нужный заказ - кнопка "ввести промокод" - в диалоговом
                                окне введите промокод. Клиент может воспользоваться промокодом при оплате своего ПЕРВОГО
                                заказа и уменьшить его стоимость на 10%.</p>
                        </div>
                    </li>
                    <li>
                        <div class="question">Как я пойму, что друг оплатил заказ?</div>
                        <div class="answer">
                            <p>В таблице на этой странице будут отображены все люди, которые ввели ваш промокод. Также
                                вы будете видеть статус их заказа - оплачен он или нет. Как только заказ будет оплачен -
                                вы получите деньги на свой бонусный счет.</p>
                        </div>
                    </li>
                    <li>
                        <div class="question">Как я могу потратить полученные деньги?</div>
                        <div class="answer">
                            <p>Вы можете потратить полученные средства на оплату своих заказов на нашем сайте. Для этого
                                перед оплатой работы, на странице заказа нажмите кнопку "уменьшить цену" и введите сумму
                                средств, которую хотите использовать. Стоимость заказа будет снижена на введенную сумму,
                                а средства будут списаны с бонусного счета</p>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
