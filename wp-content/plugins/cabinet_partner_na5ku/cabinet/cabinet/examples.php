<?php
$EXAMPLES = [];


if ($user_data['valuta'] == 2) {

    $EXAMPLES[] = [
        'title' => 'Дипломная по международному менеджменту',
        'link' => NA5KU_CDN_URL . '/files/examples/ru_Дипломная по международному менеджменту.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];


    $EXAMPLES[] = [
        'title' => 'Задачи по математике',
        'link' => NA5KU_CDN_URL . '/files/examples/ru_Задачи по математике.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];


    $EXAMPLES[] = [
        'title' => 'Контрольная по программированию',
        'link' => NA5KU_CDN_URL . '/files/examples/ru_Контрольная по программированию.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];


    $EXAMPLES[] = [
        'title' => 'Курсовая работа',
        'link' => NA5KU_CDN_URL . '/files/examples/ru_Курсовая работа.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];


    $EXAMPLES[] = [
        'title' => 'Реферат финансы',
        'link' => NA5KU_CDN_URL . '/files/examples/ru_Реферат финансы.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];


    $EXAMPLES[] = [
        'title' => 'Сочинение на английском',
        'link' => NA5KU_CDN_URL . '/files/examples/ru_Сочинение на английском.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];


    $EXAMPLES[] = [
        'title' => 'Чертеж',
        'link' => NA5KU_CDN_URL . '/files/examples/ru_Чертеж.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];


    $EXAMPLES[] = [
        'title' => 'Эссе',
        'link' => NA5KU_CDN_URL . '/files/examples/ru_Эссе.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];
} else {

    $EXAMPLES[] = [
        'title' => 'Курсовая работа',
        'link' => NA5KU_CDN_URL . '/files/examples/ua_Курсовая_работа.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];

    $EXAMPLES[] = [
        'title' => 'Дипломная работа по маркетингу',
        'link' => NA5KU_CDN_URL . '/files/examples/ua_Дипломная работа по маркетингу.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];

    $EXAMPLES[] = [
        'title' => 'Реферат по маркетингу',
        'link' => NA5KU_CDN_URL . '/files/examples/ua_реферат по маркетингу.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];

    $EXAMPLES[] = [
        'title' => 'Контрольная работа по мировой экономике',
        'link' => NA5KU_CDN_URL . '/files/examples/ua_Контрольная работа по мировой экономике.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];

    $EXAMPLES[] = [
        'title' => 'Эссе по экономике',
        'link' => NA5KU_CDN_URL . '/files/examples/ua_эссе по экономике.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];

    $EXAMPLES[] = [
        'title' => 'Задачи по высшей математике',
        'link' => NA5KU_CDN_URL . '/files/examples/ua_задачи по высшей математике.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];

    $EXAMPLES[] = [
        'title' => 'Задачи по бухгалтерскому учету и аудиту',
        'link' => NA5KU_CDN_URL . '/files/examples/ua_задачи по бухгалтерскому учету и аудиту.pdf',
        'type' => '.pdf',
        'icon' => '<img class="" src="/cabinet/img/Adobe_PDF_icon.svg" />',
    ];

    $EXAMPLES[] = [
        'title' => 'Чертежи',
        'link' => NA5KU_CDN_URL . '/files/examples/ua_чертежи.png',
        'type' => '.png',
        'icon' => '<img class="" src="/cabinet/img/insert-picture-icon.svg" />',
    ];
}


?>


<div class="cabinet-examples">
    <div class="row">
        <?php
        foreach ($EXAMPLES as $example) {
            echo showExamples($example);
        }
        ?>
    </div>

</div>