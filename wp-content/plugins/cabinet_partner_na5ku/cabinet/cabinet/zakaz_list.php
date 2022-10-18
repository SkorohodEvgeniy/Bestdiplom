<?php
//


$premodarationApi = new Premoderation();
$typeOrderApi = new TypeOrder();
$subjectOrderApi = new SubjectOrder();

/* get count of zakazes */
//active
//$query = "Select count(*) From `zakaz` where `status`<'6' $filter_add";
//$q = "Select count(*) From `zakaz_forma` where `status`='1' $filter_add";

//return;
$activeOrders = $orderApi->activeCount([
    'id' => $user_data['id']
]);

$finishOrders = $orderApi->finishedCount([
    'id' => $user_data['id']
]);

$canceledOrders = $orderApi->canceledCount([
    'id' => $user_data['id']
]);
$premiderationOrder = $premodarationApi->count([
    'id' => $user_data['id']
]);
//var_dump("finish", $finishOrders);
//var_dump("canceled", $canceledOrders);
//var_dump("activeOrders", $activeOrders);
//var_dump('premiderationOrder', $premiderationOrder);


//$result_2 = baza_do_one($q);
$zakaz_au_all3 = $premiderationOrder['data'];

$result_2 = $activeOrders['data'];
//$result_2 += $zakaz_au_all3;
$count['active'] = $result_2 + $zakaz_au_all3;

//done
//$query = "Select count(*) From `zakaz` where (`status`='7' or `status`='6') $filter_add";
//$result_2 = baza_do_one($query);
$count['done'] = $finishOrders['data'];

//canceled
//$query = "Select count(*) From `zakaz` where `status`='8' $filter_add";
//$result_2 = baza_do_one($query);
$count['canceled'] = $canceledOrders['data'];


$all_status[1] = "Ожидает предоплату";
$all_status[2] = "Ожидает предоплату";
$all_status[3] = "Мы пишем вашу работу";
$all_status[4] = "Мы пишем вашу работу";
$all_status[5] = "Мы пишем вашу работу";
$all_status[6] = "Ваша работа готова";
$all_status[7] = "Ваша работа готова";
$all_status[8] = "Отменен";
$c_can = 0;
$c_active = 0;
$c_done = 0;

echo "
<div class='row'>
  <div class='col-md-12'>
    <div class='cabinet-tabs'>
    <ul class='nav nav-tabs'>
      <li class='active'><a data-toggle='tab' href='#tab1'><span>Заказы в работе</span><div class='checker' id='c_active'>0</div></a></li>
      <li><a data-toggle='tab' href='#tab2'><span>Завершенные заказы</span><div class='checker' id='c_done'>0</div></a></li>
      <li><a data-toggle='tab' href='#tab3'><span>Отмененные заказы</span><div class='checker' id='c_can'>0</div></a></li>
    </ul>
";


if ($count['active'] == 0) {
    $list_active = "
  <div class='tab-wrap'>
    <div class='alert alert-success'>
    У вас нет активных заказов.
    </div>
  </div>
  ";
} else {

    $list_active = "
  <div class='tab-wrap'>
    <div class='row hidden-xs'>
      <div class='col-md-7 col-sm-7'>
        <div class='col-title'>Информация о заказе</div>
      </div>
      <div class='col-md-3 col-sm-3'>
        <div class='col-title status'>Статус</div>
      </div>
      <div class='col-md-2 col-sm-2'>
        <div class='col-title price'>Цена</div>
      </div>
    </div>
  </div>  
";
    $zakaz = $orderApi->active([
        'id' => $user_data['id']
    ]);
//    $q = "Select * From `zakaz` where `status`<'6' $filter_add ORDER BY id desc  LIMIT 0,100";
//    $zakaz = baza_do($q);


    $zakaz = $zakaz['data'];

    for ($i = 0; $i < count($zakaz); $i++) {
        $z = $zakaz[$i];

        /**
         * получение Тип работы
         */
//        $type = $typeOrderApi->get([
//            'id' => $z['type']
//        ]);
        $z['tema'] = base64_decode($z['tema']);

//        $q = "select * from `zakaz_types` where `id`='$z[type]'";
//        $type = baza_do_one($q);
//        $z['type'] = iconv('UTF-8', 'WINDOWS-1251', $type['type']);
//        $z['type'] = $type['data'];
        /**
         * получение Темы работы
         */
//        $subject = $subjectOrderApi->get([
//            'id' => $z['special']
//        ]);
//        echo "<pre>";
//        var_dump();
//        echo "</pre>";
//        $q = "select * from `zakaz_subject` where `id`='$z[special]'";
        $specialnost = $z['subject']['name'];//$subject['data'];
//        die(var_dump($specialnost));
        $z['special'] = $specialnost;

        $z['date_end']++;
        $z['date_end']--;
        $z['date_end'] = date("d/m/Y", $z['date_end']);

        if ($z['pay_valuta'] == 1) $z['pay_valuta'] = "UAH";
        else if ($z['pay_valuta'] == 3) $z['pay_valuta'] = "USD";
        else $z['pay_valuta'] = "RUB";

        if ($z['cena_skidka'] == 0 && $z['status'] != 8) {
            $z['cena_skidka'] = "Оценивается";
            $z['pay_valuta'] = "";

        } else
            $z['cena_skidka'] = number_format($z['cena_skidka'], 0, ',', ' ');


//        $q = "select count(*) as 'c' from `comment_client` where `zakaz_id`='{$z['id']}' and `read_by_client`='0'";
//        $unread_comments = baza_do_one($q);

        if (isset($unread_comments['c']) && $unread_comments['c'] > 0)
            $unread_comments = "<left><b>у вас новое сообщение в проекте</b></left>";
        else $unread_comments = '';
        $unread_events = '';
        if ($z['client_event_plan']) $unread_events .= "<left><a href='/cabinet/open/$z[id_for_client]'><b>в заказе добавлен план работы</b></a></left>";
        if ($z['client_event_anti']) $unread_events .= "<left><a href='/cabinet/open/$z[id_for_client]'><b>в заказе изменен антиплагиат</b></a></left>";

        $status_ = $z['status'];
        $status = $all_status[$status_];
        if ($status_ == 3 && $z['pay_predoplata'] != 1 && $z['pay_client'] != 1) $status = $all_status[2];//мы ждем (если заказ особенный)
        if ($z['cena_skidka'] == "Оценивается") $status = "";
        if (($z['pay_predoplata'] == 1 || $z['pay_client'] == 1) && $status_ < 3) $status = $all_status[3];//мы пишем если оплачено раньше чем нашли автора


//        if ($status == "" || $status == "Ожидает предоплату") {
//            $unread_events = "";
//            $q = "UPDATE `zakaz` SET `client_event_plan`='0',`client_event_anti`='0' where `id`='$z[id]'";
//            baza_do_only;
//        }
        $list_active .= " 
  <div class='active-orders-item clearfix'>
    <div class='row'>
      <div class='col-md-7 col-sm-7'>
        <div class='title'><a href='/cabinet/open/${z['id_for_client']}'>" . iconv('Windows-1251', 'UTF-8', $z['tema']) . "</a></div>
        <div class='pages'>{$z['type']['type']} / ${z['special']}</div>
        <div class='deadline'>Сроки выполнения заказа: <span>$z[date_end]</span></div>
      </div>
      <div class='col-md-3 col-sm-3'>
        <div class='prepayment'>$status</div>
      </div>
      <div class='col-md-2 col-sm-2'>
         <div class='money'>$z[cena_skidka] $z[pay_valuta]</div>
      </div>
    </div>
    <div class='row'>
      <div class='col-md-7 col-sm-7'>
        <div class='order-id'>ID заказа: $z[id_for_client]</div>
      </div>
      <div class='col-md-5 col-sm-5'>
        <div class='comments'><a href='/cabinet/open/$z[id_for_client]'>$unread_comments</a>$unread_events</div>
      </div>
    </div>
  </div>
";
        $c_active++;
    }

//premod
    $premoderationGet = $premodarationApi->get([
        'id' => $user_data['id']
    ]);
//    $q = "Select * From `zakaz_forma` where `status`='1' and `client_id`='$user_data[id]' ORDER BY id desc ";
//    $zakaz = baza_do($q);
    $zakaz = $premoderationGet['data'];
    for ($i = 0; $i < count($zakaz); $i++) {
        $z = $zakaz[$i];

        $z['theme'] = base64_decode($z['theme']);
        $type = iconv('UTF-8', 'Windows-1251', $z['type']['type']);
        $z['z_t'] = iconv('UTF-8', 'WINDOWS-1251', $type);

        $z['srok']++;
        $z['srok']--;
        $z['srok'] = date("d/m/Y", $z['srok']);

        $list_active .= " 
  <div class='active-orders-item clearfix'>
    <div class='row'>
      <div class='col-md-7 col-sm-7'>
        <div class='title'><a href='/cabinet/premoder/zakaz-$z[id]'>" . iconv('windows-1251', 'utf-8', $z['theme']) . "</a></div>
        <div class='pages'>$z[z_t]</div>
        <div class='deadline'>Сроки выполнения заказа: <span>$z[srok]</span></div>
      </div>
      <div class='col-md-3 col-sm-3'>
        <div class='prepayment'>Ожидает модерации</div>
      </div>
      <div class='col-md-2 col-sm-2'>
        
      </div>
    </div>
    <div class='row'>
      
    </div>
  </div>
";
        $c_active++;
    }

}
//$count['done'] = 0;
if ($count['done'] == 0) {
    $list_done = "
  <div class='tab-wrap'>
    <div class='alert alert-success'>
    У вас нет завершенных заказов.
    </div>
  </div>
  ";
} else {
    $list_done = "
  <div class='tab-wrap'>
    <div class='row hidden-xs'>
      <div class='col-md-7 col-sm-7'>
        <div class='col-title'>Информация о заказе</div>
      </div>
      <div class='col-md-3 col-sm-3'>
        <div class='col-title status'>Статус</div>
      </div>
      <div class='col-md-2 col-sm-2'>
        <div class='col-title price'>Цена</div>
      </div>
    </div>
  </div>  
";
    $orderFinished = $orderApi->finished([
        'id' => $user_data['id']
    ]);


//    $q = "Select * From `zakaz` where (`status`='7' or `status`='6') $filter_add ORDER BY id desc  LIMIT 0,100";
//    $zakaz = baza_do($q);
    $zakaz = $orderFinished['data'];
    for ($i = 0; $i < count($zakaz); $i++) {
        $z = $zakaz[$i];


        $z['tema'] = iconv('Windows-1251', 'utf-8', base64_decode($z['tema']));

//        $type = $typeOrderApi->get([
//            'id' => $z['type']
//        ]);

        $type = $z['type']['type'];


//        $q = "select * from `zakaz_types` where `id`='$z[type]'";
//        $type = baza_do_one($q);
//        $type = $type['data'];


        $z['type'] = iconv('UTF-8', 'WINDOWS-1251', $type);


//        $subject = $subjectOrderApi->get([
//            'id' => $z['special']
//        ]);
//        $specialnost = $subject['data'];
//        $q = "select * from `zakaz_subject` where `id`='$z[special]'";
//        $specialnost = baza_do_one($q);

        $specialnost = $z['subject']['name'];
        $z['special'] = iconv('UTF-8', 'WINDOWS-1251', $specialnost);

        $z['date_end']++;
        $z['date_end']--;
        $z['date_end'] = date("d/m/Y", $z['date_end']);

        if ($z['pay_valuta'] == 1) $z['pay_valuta'] = "UAH";
        else if ($z['pay_valuta'] == 3) $z['pay_valuta'] = "USD";
        else $z['pay_valuta'] = "RUB";

        $tmp_cena = $z['cena_skidka'];
        $z['cena_skidka'] = number_format($z['cena_skidka'], 0, ',', ' ');


//        $commentClientApi = new CommentClient();
//        $unread_comments = $commentClientApi->countNoRead([
//            'id' => $z['id']
//        ]);

//        echo "<pre>";
//        var_dump("unread_comments",$unread_comments );
//        echo "</pre>";

//        $q = "select count(*) as 'c' from `comment_client` where `zakaz_id`='{$z['id']}' and `read_by_client`='0'";
//        $unread_comments = baza_do_one($q);
//        $unread_comments = $unread_comments['data'];

        $unread_comments = count($z['client_comments']);
        if (isset($unread_comments) && $unread_comments > 0)
            $unread_comments = "<center><b>у вас новое сообщение в проекте</b></center>";
        else $unread_comments = '';

        $status_ = $z['status'];
        $status = $all_status[$status_];
        if ($status_ == 3 && $z['pay_predoplata'] != 1 && $z['pay_client'] != 1) $status = $all_status[2];//мы ждем (если заказ особенный)
        if ($z['cena_skidka'] == "Оценивается") $status = "";
        if (($z['pay_predoplata'] == 1 || $z['pay_client'] == 1) && $status_ < 3) $status = $all_status[3];//мы пишем если оплачено раньше чем нашли автора

        $paid = $z['paid_pre'] + $z['paid_next'];
        $pay_need = $tmp_cena - $paid;
        $pay_need -= $z["penya_to_system"];

        if ($pay_need < 0) $pay_need = 0;
        $pay_need = $pay_need + $z["cena_d_cl"] - $z['paid_dor'];
        if ($pay_need < 0) $pay_need = 0;

        if ($pay_need > 0 && $status == "Ваша работа готова") $status = "Работа готова, оплатите остаток";

        $list_done .= " 
    <div class='active-orders-item clearfix'>
      <div class='row'>
        <div class='col-md-7 col-sm-7'>
          <div class='title'><a href='/cabinet/open/$z[id_for_client]'>$z[tema]</a></div>
          <div class='pages'>$type / $special</div>
          <div class='deadline'>Сроки выполнения заказа: <span>$z[date_end]</span></div>
        </div>
        <div class='col-md-3 col-sm-3'>
           <div class='prepayment'>$status</div>
        </div><div class='col-md-2 col-sm-2'>
           <div class='money'>$z[cena_skidka] $z[pay_valuta]</div>
        </div>
      </div>
      <div class='row'>
        <div class='col-md-7 col-sm-7'>
          <div class='order-id'>ID заказа: $z[id_for_client]</div>
        </div>
        <div class='col-md-5 col-sm-5'>
          <div class='comments'><a href='/cabinet/open/$z[id_for_client]'>$unread_comments</a></div>
        </div>
      </div>
    </div>
  ";
        $c_done++;
    }
}
//$count['canceled'] = 0;
if ($count['canceled'] == 0) {
    $list_canceled = "
  <div class='tab-wrap'>
    <div class='alert alert-success'>
    У вас нет отмененных заказов.
    </div>
  </div>
  ";
} else {
    $list_canceled = "
  <div class='tab-wrap'>
    <div class='row hidden-xs'>
      <div class='col-md-9 col-sm-9'>
        <div class='col-title'>Информация о заказе</div>
      </div>
      <div class='col-md-2 col-sm-2'>
        <div class='col-title price'>Цена</div>
      </div>
    </div>
  </div>  
";


    $orderCanceled = $orderApi->canceled([
        'id' => $user_data['id']
    ]);
//        echo "<pre>";
//        var_dump("orderCanceled",$orderCanceled );
//        echo "</pre>";


//    $q = "Select * From `zakaz` where `status`='8' $filter_add ORDER BY id desc  LIMIT 0,100";
//    $zakaz = baza_do($q);
    $zakaz = $orderCanceled['data'];
    for ($i = 0; $i < count($zakaz); $i++) {
        $z = $zakaz[$i];
        $z['tema'] = iconv('Windows-1251', 'Utf-8', base64_decode($z['tema']));
        $type = $z['type']['type'];
        $specialnost = $z['subject']['name'];

        $z['type'] = iconv('WINDOWS-1251', 'UTF-8', $type);
        $z['special'] = iconv('WINDOWS-1251', 'UTF-8', $specialnost);

        $z['date_end']++;
        $z['date_end']--;
        $z['date_end'] = date("d/m/Y", $z['date_end']);

        if ($z['pay_valuta'] == 1) $z['pay_valuta'] = "UAH";
        else if ($z['pay_valuta'] == 3) $z['pay_valuta'] = "USD";
        else $z['pay_valuta'] = "RUB";

        $z['cena_skidka'] = number_format($z['cena_skidka'], 0, ',', ' ');

        $unread_comments = count($z['client_comments']);

        if (isset($unread_comments) && $unread_comments > 0)
            $unread_comments = "<center><b>у вас новое сообщение в проекте</b></center>";
        else $unread_comments = '';

        $list_canceled .= " 
    <div class='active-orders-item clearfix'>
      <div class='row'>
        <div class='col-md-9 col-sm-9'>
          <div class='title'><a href='/cabinet/open/$z[id_for_client]'>$z[tema]</a></div>
          <div class='pages'>$type / $special</div>
          <div class='deadline'>Сроки выполнения заказа: <span>$z[date_end]</span></div>
        </div>
        <div class='col-md-2 col-sm-2'>
           <div class='money'>$z[cena_skidka] $z[pay_valuta]</div>
        </div>
      </div>
      <div class='row'>
        <div class='col-md-7 col-sm-7'>
          <div class='order-id'>ID заказа: $z[id_for_client]</div>
        </div>
        <div class='col-md-5 col-sm-5'>
          <div class='comments'><a href='/cabinet/open/$z[id_for_client]'>$unread_comments</a></div>
        </div>
      </div>
    </div>
  ";
        $c_can++;
    }
}


echo "
<div class='tab-content'>
    <div id='tab1' class='tab-pane fade in active'>$list_active</div>
    <div id='tab2' class='tab-pane fade'>$list_done</div>
    <div id='tab3' class='tab-pane fade'>$list_canceled</div>
</div>
  </div>
</div>
</div>
</div>
";
$c_active += 0;
$c_done += 0;
$c_can += 0;
?>


<script>

    $("#c_active").html("<?=$c_active?>");

    $("#c_done").html("<?=$c_done?>");
    $("#c_can").html("<?=$c_can?>");


    <?php
    if ($c_active == 0) echo "$('#c_active').addClass('checker_disabled');";
    if ($c_done == 0) echo "$('#c_done').addClass('checker_disabled');";
    if ($c_can == 0) echo "$('#c_can').addClass('checker_disabled');";
    ?>
</script>

