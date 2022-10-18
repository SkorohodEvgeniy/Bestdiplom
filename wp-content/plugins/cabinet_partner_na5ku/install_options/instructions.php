<li>Добавьте шорт <b>[<?= SHORT_BUTTONS_NAV ?>]</b> для кнопок регистрации/входа</li>
<li>Добавьте шорт <b>[<?= SHORT_MINI_FORM ?>]</b> для mini формы</li>
<li>Добавьте шорт <b>[<?= SHORT_INLINE_FORM ?>]</b> для горизонтальной inline формы</li>
<li>Добавьте шорт <b>[<?= SHORT_INLINE_FORM_VERTICAL ?>]</b> для вертикальной inline формы</li>
<li>Добавьте шорт <b>[<?= SHORT_INLINE_CALCULATOR ?>]</b> для inline калькулятора</li>
<li>Добавьте шорт <b>[<?= SHORT_LAST_JOBS ?>]</b> для таблицы последних заказор</li>
<li>Используя <b>PHP</b> константу <b>NA5KU_LANG_PACK_DOMAIN</b> можете указать домен для языкового пакета</li>
<li>Привет шорт тега:</li>
<pre>&lt;?php echo do_shortcode('[<?= SHORT_BUTTONS_NAV ?>]'); ?></pre>

<li>Вам необходимо одноразово зайти в настройки -> постоянные ссылки и сохранить ничего не меняя.</li>
<li>Если не сработало, то добавьте в начало <b>.htaccess</b> следующий код:</li>
<pre><?php
    require_once "file_htaccess.php";
    ?></pre>
