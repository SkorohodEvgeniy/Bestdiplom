<?php
$FAQ = [];
if ($user_data['valuta'] == 2) {

    $FAQ[] = [
        'q' => 'Как я могу связаться с исполнителем?',
        'a' => '
        <p>1) Нажмите на тему вашего заказа:</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-37-36.png"><br>
        <p>2) Перейдите во вкладку чат для связи с личным менеджером:</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-38-26.png"><br>
        <p>Личный менеджер передаст автору все необходимую информацию. Если у автора возникнут вопросы - Вам их передаст личный менеджер через данный чат.</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-38-36.png"><br>
        <p>Цифра в названии вкладки показывает, что по данному заказу есть непрочитанное сообщение от вашего личного менеджера.</p>

',
    ];
    $FAQ[] = [
        'q' => 'Как увидеть детальную информацию о моем заказе?',
        'a' => '
        <p>Нажмите на тему вашего заказа</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-38-51.png"><br>
',
    ];
    $FAQ[] = [
        'q' => 'Не могу найти свой заказ',
        'a' => '
        <p>После авторизации в личном кабинете вы попадаете в раздел “ваши заказы”. Ваш заказ будет находится в одной из вкладок: “заказы в работе”, “завершенные заказы”, “отмененные заказы”.</p>
        <p>Цифра в названии вкладки указывает сколько заказов находится в конкретной вкладке.</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-39-10.png"><br>
',
    ];
    $FAQ[] = [
        'q' => 'Как я могу оплатить заказ?',
        'a' => '
        <p>1) Нажмите на тему вашего заказа:</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-39-22.png"><br>
        <p>В данном окне вы можете увидеть всю информацию о вашем заказе, стоимость работы и блок с кнопками для оплаты.</p>
        <p>2) Для внесения предоплаты нажмите “заплатить предоплату”:</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-39-33.png"><br>
',
    ];
    $FAQ[] = [
        'q' => 'Как мне получить готовую работу?',
        'a' => '
        <p>1) Нажмите на тему вашего заказа (обращаем ваше внимание, что готовая работа будет находиться в разделе “завершенные заказы”):</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2020-01-16_01-25-20.png"><br>
        <p>2) Перейдите во вкладку “файлы”:</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-39-48.png"><br>
        <p>3) В данной вкладке вы можете скачать превью работы (примерно половина выполненной работы). Полную версию работы вы сможете скачать после оплаты остатка.</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-39-56.png"><br>
        <p>4) Для оплаты остатка вернитесь во вкладку “информация о заказе и оплата”:</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-40-05.png"><br>
        <p>5) Нажмите “заплатить” и после оплаты во вкладке “файлы” станет доступна полная версия работы:</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2020-01-16_01-26-37.png"><br>
',
    ];
    $FAQ[] = [
        'q' => 'Как ввести промокод на скидку?',
        'a' => '
        <p>1) Нажмите на тему вашего заказа:</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-40-22.png"><br>
        <p>Кнопка для ввода промокода находится сразу под кнопкой для внесения предоплаты:</p>
        <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-40-33.png"><br>
        <p><b>Важно:</b> промокод необходимо вводить до внесения первой оплаты в заказе</p>
',
    ];
    $FAQ[] = [
        'q' => 'Как я могу передать исполнителю материалы необходимые для выполнения работы?',
        'a' => '
    <p>1) Нажмите на тему вашего заказа:</p>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-41-02.png"><br>
    <p>2) Далее есть 2 способа: через вкладку "чат с личным менеджером" и через вкладку “файлы”.</p>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-41-15.png"><br>
    <p>Если вы выбрали вкладку чат, то в правой части экрана вы можете прикрепить файлы в переписку с вашим личным менеджером:</p>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-41-24.png"><br>
    <p>Если вы выбрали вкладку “файлы”, то вы можете прикрепить ваши файлы к заказу нажав “добавить файл”. В этой же вкладке будут находиться файлы, что вы прикрепляли к заказу при его оформлении.</p>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-41-33.png"><br>
',
    ];
    $FAQ[] = [
        'q' => 'У меня есть замечания по работе, хочу чтобы переделали',
        'a' => '
    <p>1) Нажмите на тему вашего заказа:</p>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2020-01-16_01-27-15.png"><br>
    <p>2) Далее есть 2 варианта: </p>
    <p><ul>
        <li>расписать замечания личному менеджеру через вкладку "чат с личным менеджером"</li>
        <li>нажать кнопку “на доработку” и расписать свои замечания в появившемся окне</li>
    </ul></p>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-41-50.png"><br>
    <p>Распишите максимально подробно ваши замечания. Вашу работу обязательно переделают в соответствии с вашими пожеланиями. В случае, если новые требования не соответствуют изначальным, то правка будет за доплату.</p>
',
    ];
    $FAQ[] = [
        'q' => 'Мне не понравилось как выполнена моя работа, хочу вернуть деньги',
        'a' => '
    <p>1) Нажмите на тему вашего заказа:</p>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2020-01-16_01-28-18.png"><br>
    <p>2) Перейдите во вкладку "чат с личным менеджером" для связи с вашим личным менеджером:</p>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-42-07.png"><br>
    <p>3) Распишите максимально подробно ваши замечания в сообщении к личному менеджеру (замечания для возврата средств принимаются только в письменном виде и только через данный чат). На основании ваших слов работа будет передана в отдел контроля качества для определения суммы возврата.</p>
',
    ];


    $FAQ[] = [
        'q' => 'Что такое уникальность работы и для чего она нужна?',
        'a' => '
    <p>Уникальность текста (оно же оригинальность, оно же антиплагиат) – это особая характеристика, которая показывает, насколько этот текст не похож на другие, уже опубликованные в сети. Чем выше уникальность – тем лучше. Процент уникальности текста вычисляется с помощью специальных программ – антиплагиатов.</p>
    <p>В таблице ниже представлены стандарты уникальности. Если Вы не указали в заказе требование к уникальности, то автор сделает работу с уникальностью в соответствии с таблицей:</p>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2020-01-16_00-46-29.png">
    <p>Обращаем Ваше внимание, что учитывая количество работ написанных на все темы, отсылки к источникам, что встречаются во всех аналогичных работах и часто используемые словосочетания делают невозможным написание работы на 100% уникальности. Уникальность 90% можно считать почти предельной.</p>
    
    ',
    ];

    $FAQ[] = [
        'q' => 'Как Вы проверяете уникальность?',
        'a' => '
<p>Большинство работ мы по стандарту проверяем через программу etxt-антиплагиат,  которую можно скачать на сайте <a href="https://www.etxt.ru/" target="_blank">https://www.etxt.ru/</a></p>
<p>Если же Вам требуется уникальность по какому-либо другому сервису, то необходимо об этом указывать в подробностях заказа.</p>
<p>Если Ваш сервис для проверки уникальности платный либо к нему ограниченный доступ, то потребуется чтобы Вы предоставили доступ нашему автору.</p>
    ',
    ];
} else {
    $FAQ[] = [
        'q' => 'Как я могу связаться с исполнителем?',
        'a' => '
    1) Нажмите на тему вашего заказа: <br>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-37-36.png"><br>
    2) Перейдите во вкладку чат для связи с личным менеджером: <br>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-38-26.png"><br>
    Личный менеджер передаст автору все необходимую информацию. Если у автора возникнут вопросы - Вам их передаст личный менеджер через данный чат.<br>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-38-36.png"><br>
Цифра в названии вкладки показывает, что по данному заказу есть непрочитанное сообщение от вашего личного менеджера.<br>

    ',
    ];


    $FAQ[] = [
        'q' => 'Как увидеть детальную информацию о моем заказе?',
        'a' => '
    Нажмите на тему вашего заказа<br>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-38-51.png"><br>

    ',
    ];


    $FAQ[] = [
        'q' => 'Не могу найти свой заказ',
        'a' => '
    После авторизации в личном кабинете вы попадаете в раздел “ваши заказы”. Ваш заказ будет находится в одной из вкладок: “заказы в работе”, “завершенные заказы”, “отмененные заказы”.<br>
Цифра в названии вкладки указывает сколько заказов находится в конкретной вкладке.<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-39-10.png"><br>


    ',
    ];


    $FAQ[] = [
        'q' => 'Как я могу оплатить заказ?',
        'a' => '
    1) Нажмите на тему вашего заказа:<br>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-39-22.png"><br>
    
    В данном окне вы можете увидеть всю информацию о вашем заказе, стоимость работы и блок с кнопками для оплаты.<br>
    2) Для внесения предоплаты нажмите “заплатить предоплату”:<br>
    <img src="' . NA5KU_CDN_URL . 'img/faq/photo5260384049476775188.jpg"><br>
    

    ',
    ];

    $FAQ[] = [
        'q' => 'Как мне получить готовую работу?',
        'a' => '
    1) Нажмите на тему вашего заказа (обращаем ваше внимание, что готовая работа будет находиться в разделе “завершенные заказы”):<br>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-39-41.png"><br>
    
2) Перейдите во вкладку “файлы”:<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-39-48.png"><br>

3) В данной вкладке вы можете скачать превью работы (примерно половина выполненной работы). Полную версию работы вы сможете скачать после оплаты остатка.<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-39-56.png"><br>

4) Для оплаты остатка вернитесь во вкладку “информация о заказе и оплата”:<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-40-05.png"><br>

5) Нажмите “заплатить” и после оплаты во вкладке “файлы” станет доступна полная версия работы:<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-40-13.png"><br>

    ',
    ];

    $FAQ[] = [
        'q' => 'Как ввести промокод на скидку?',
        'a' => '
    1) Нажмите на тему вашего заказа:<br>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-40-22.png"><br>
    
2) Кнопка для ввода промокода находится сразу под кнопкой для внесения предоплаты:<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/photo5260436997833600292.jpg"><br>

<b>Важно:</b> промокод необходимо вводить до внесения первой оплаты в заказе<br>
    
    ',
    ];

    $FAQ[] = [
        'q' => 'Как я могу передать исполнителю материалы необходимые для выполнения работы?',
        'a' => '
1) Нажмите на тему вашего заказа:<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-41-02.png"><br>
2) Далее есть 2 способа: через вкладку "чат с личным менеджером" и через вкладку “файлы”.<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-41-15.png"><br>
Если вы выбрали вкладку чат, то в правой части экрана вы можете прикрепить файлы в переписку с вашим личным менеджером:<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-41-24.png"><br>
Если вы выбрали вкладку “файлы”, то вы можете прикрепить ваши файлы к заказу нажав “добавить файл”. В этой же вкладке будут находиться файлы, что вы прикрепляли к заказу при его оформлении.<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-41-33.png"><br>
    ',
    ];

    $FAQ[] = [
        'q' => 'У меня есть замечания по работе, хочу чтобы переделали',
        'a' => '
    1) Нажмите на тему вашего заказа:<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-41-41.png"><br>
    2) Далее есть 2 варианта: <br>
<ul>
<li>расписать замечания личному менеджеру через вкладку "чат с личным менеджером"</li>
<li>нажать кнопку “на доработку” и расписать свои замечания в появившемся окне</li>
</ul>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-41-50.png"><br>

Распишите максимально подробно ваши замечания. Вашу работу обязательно переделают в соответствии с вашими пожеланиями. В случае, если новые требования не соответствуют изначальным, то правка будет за доплату.<br>

    ',
    ];

    $FAQ[] = [
        'q' => 'Мне не понравилось как выполнена моя работа, хочу вернуть деньги',
        'a' => '
    1) Нажмите на тему вашего заказа:<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-41-59.png"><br>
2) Перейдите во вкладку "чат с личным менеджером" для связи с вашим личным менеджером:<br>
<img src="' . NA5KU_CDN_URL . 'img/faq/2019-11-02_18-42-07.png"><br>
Распишите максимально подробно ваши замечания в сообщении к личному менеджеру (замечания для возврата средств принимаются только в письменном виде и только через данный чат). На основании ваших слов работа будет передана в отдел контроля качества для определения суммы возврата.<br>

    ',
    ];

    $FAQ[] = [
        'q' => 'Что такое уникальность работы и для чего она нужна?',
        'a' => '
    <p>Уникальность текста (оно же оригинальность, оно же антиплагиат) – это особая характеристика, которая показывает, насколько этот текст не похож на другие, уже опубликованные в сети. Чем выше уникальность – тем лучше. Процент уникальности текста вычисляется с помощью специальных программ – антиплагиатов.</p>
    <p>В таблице ниже представлены стандарты уникальности. Если Вы не указали в заказе требование к уникальности, то автор сделает работу с уникальностью в соответствии с таблицей:</p>
    <img src="' . NA5KU_CDN_URL . 'img/faq/2020-01-16_00-46-29.png">
    <p>Обращаем Ваше внимание, что учитывая количество работ написанных на все темы, отсылки к источникам, что встречаются во всех аналогичных работах и часто используемые словосочетания делают невозможным написание работы на 100% уникальности. Уникальность 90% можно считать почти предельной.</p>
    
    ',
    ];

    $FAQ[] = [
        'q' => 'Как Вы проверяете уникальность?',
        'a' => '
<p>Большинство работ мы по стандарту проверяем через программу etxt-антиплагиат,  которую можно скачать на сайте <a href="https://www.etxt.ru/" target="_blank">https://www.etxt.ru/</a></p>
<p>Если же Вам требуется уникальность по какому-либо другому сервису, то необходимо об этом указывать в подробностях заказа.</p>
<p>Если Ваш сервис для проверки уникальности платный либо к нему ограниченный доступ, то потребуется чтобы Вы предоставили доступ нашему автору.</p>
    ',
    ];
}


?>
<div class="panel-group faq" id="accordion">
    <?php
    $autoOpen = false;
    foreach ($FAQ as $faq) {
        echo showFAQ($faq['q'], $faq['a'], $autoOpen);
        $autoOpen = false;
    }
    ?>

</div>
