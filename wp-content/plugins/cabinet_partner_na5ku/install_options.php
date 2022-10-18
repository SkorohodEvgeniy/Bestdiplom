<h2>Настройки кабинета</h2>
<h4>Версия: <?= NA5KU_APP_VER ?></h4>

<?php

$successMSG = false;
$a = isset($_GET['a']) ? $_GET['a'] : '';

require_once(__DIR__ . '/install_options/saveConfig.php');

$navActive = [];
$allNav = ['main', 'logo', 'cabinet', 'inline-form', 'inline-calc', 'instructions', 'mini-form', 'last-jobs', 'changelog'];
if (!in_array($a, $allNav)) {
    $a = 'main';
}
foreach ($allNav as $navKey) {
    $navActive[$navKey] = '';
}
$navActive[$a] = 'na5ku-nav-active';
?>
<div class="wrap na5ku-admin-config">
    <div id="icon-options-general" class="icon32">
        <br>
    </div>

    <style>
        .na5ku-admin-config .form-help {
            color: #bbb;
        }

        .na5ku-admin-config .na5ku-nav {
            opacity: .7;
            background-color: #0073aa;
            border-color: #0073aa;
            color: white;
        }

        .na5ku-admin-config .na5ku-nav:hover,
        .na5ku-admin-config .na5ku-nav:active,
        .na5ku-admin-config .na5ku-nav:focus {
            opacity: .8;
            color: white;
            background-color: #0073aa !important;
            border-color: #0073aa !important;
        }

        .na5ku-admin-config .na5ku-nav-active {
            opacity: 1;
        }

        .na5ku-admin-config pre {
            display: block;
            padding: 9.5px;
            margin: 10px 0;
            font-size: 13px;
            line-height: 1.42857143;
            color: #333;
            word-break: break-all;
            word-wrap: break-word;
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .na5ku-admin-config .btn {
            display: inline-block;
            color: white;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .na5ku-admin-config .btn-success {
            color: #fff;
            background-color: #5cb85c;
            border-color: #4cae4c;
        }

        .na5ku-admin-config .btn-success:hover {
            color: #fff;
            background-color: #5cb85c;
            border-color: #4cae4c;
            opacity: .8;
        }

        .na5ku-admin-config .alert {
            position: relative;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }

        .na5ku-admin-config .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .na5ku-admin-config .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .na5ku-admin-config .alert-primary {
            color: #004085;
            background-color: #cce5ff;
            border-color: #b8daff;
        }

        .na5ku-admin-config .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }
    </style>

    <a class="btn btn-primary na5ku-nav <?= $navActive['main'] ?>" href="?page=<?= NA5KU_ADMIN_LINK ?>&a=main">
        Основные
    </a>
    <a class="btn btn-primary na5ku-nav <?= $navActive['cabinet'] ?>" href="?page=<?= NA5KU_ADMIN_LINK ?>&a=cabinet">
        Кабинет
    </a>
    <a class="btn btn-primary na5ku-nav <?= $navActive['logo'] ?>" href="?page=<?= NA5KU_ADMIN_LINK ?>&a=logo">
        Логотип
    </a>
    <a class="btn btn-primary na5ku-nav <?= $navActive['mini-form'] ?>"
       href="?page=<?= NA5KU_ADMIN_LINK ?>&a=mini-form">
        Мини форма
    </a>
    <a class="btn btn-primary na5ku-nav <?= $navActive['inline-form'] ?>"
       href="?page=<?= NA5KU_ADMIN_LINK ?>&a=inline-form">
        Inline форма
    </a>
    <a class="btn btn-primary na5ku-nav <?= $navActive['inline-calc'] ?>"
       href="?page=<?= NA5KU_ADMIN_LINK ?>&a=inline-calc">
        Inline калькулятор
    </a>
    <a class="btn btn-primary na5ku-nav <?= $navActive['last-jobs'] ?>"
       href="?page=<?= NA5KU_ADMIN_LINK ?>&a=last-jobs">
        Последние работы
    </a>
    <a class="btn btn-primary na5ku-nav <?= $navActive['instructions'] ?>"
       href="?page=<?= NA5KU_ADMIN_LINK ?>&a=instructions">
        Инструкции
    </a>
    <a class="btn btn-primary na5ku-nav <?= $navActive['changelog'] ?>"
       href="?page=<?= NA5KU_ADMIN_LINK ?>&a=changelog">
        Changelog
    </a>

    <div class="metabox-holder">
        <div class="postbox" style="padding: 20px;">
            <?php
            switch ($a) {
                case 'cabinet':
                    require_once(__DIR__ . '/install_options/cabinet.php');
                    break;
                case 'logo':
                    require_once(__DIR__ . '/install_options/logo.php');
                    break;
                case 'inline-form':
                    require_once(__DIR__ . '/install_options/inline-form.php');
                    break;
                case 'mini-form':
                    require_once(__DIR__ . '/install_options/mini-form.php');
                    break;
                case 'inline-calc':
                    require_once(__DIR__ . '/install_options/inline-calc.php');
                    break;
                case 'instructions':
                    require_once(__DIR__ . '/install_options/instructions.php');
                    break;
                case 'changelog':
                    require_once(__DIR__ . '/install_options/changelog.php');
                    break;
                case 'last-jobs':
                    require_once(__DIR__ . '/install_options/last-jobs.php');
                    break;
                default:
                    require_once(__DIR__ . '/install_options/main.php');
                    break;
            }
            ?>
        </div>
    </div>

</div>

