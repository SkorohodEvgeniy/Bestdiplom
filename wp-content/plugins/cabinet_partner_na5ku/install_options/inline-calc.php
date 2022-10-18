<?php if ($successMSG): ?>
    <div id="message" class="updated below-h2">
        <p>Данные обновились</p>
    </div>
<?php endif; ?>
<form method="post" action="?page=na5ku-cabinet-setup&a=inline-calc">
    <div class="alert alert-warning">Для полноценной работы данной формы требуется наличие на сайте шорта
        <b>[<?= SHORT_BUTTONS_NAV ?>]</b></div>
    <pre>Шорт для калькулятора - [<?= SHORT_INLINE_CALCULATOR ?>]</pre>
    <table class="form-table">
        <tr>
            <td width="40%" scope="row">Текст кнопки регистрации для <b>[<?= SHORT_INLINE_CALCULATOR ?>]</b></td>
            <td><input type="text" name="mc_na5ku_inline_calc_action" placeholder="Узнать точную стоимость"
                       value="<?php echo get_option('mc_na5ku_inline_calc_action'); ?>"
                       style="width:350px;"/></td>
        </tr>
        <tr>
            <td width="40%" scope="row">Цвет фона <p class="form-help">(По умолчанию RGB: 250, 250, 250)</p></td>
            <td><input type="color" name="mc_na5ku_inline_calc_bg"
                       value="<?php echo get_option('mc_na5ku_inline_calc_bg') ? get_option('mc_na5ku_inline_calc_bg') : '#fafafa'; ?>"
                       style="width:350px;"/>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Цвет границ калькулятора <p class="form-help">(По умолчанию RGB: 237, 237,
                    237)</p></td>
            <td><input type="color" name="mc_na5ku_inline_calc_bgBorder"
                       value="<?php echo get_option('mc_na5ku_inline_calc_bgBorder') ? get_option('mc_na5ku_inline_calc_bgBorder') : '#ededed'; ?>"
                       style="width:350px;"/>
            </td>
        </tr>
        <tr>
            <td width="40%" scope="row">Цвет фона цены <p class="form-help">(По умолчанию RGB: 241, 241, 241)</p></td>
            <td><input type="color" name="mc_na5ku_inline_calc_bg2"
                       value="<?php echo get_option('mc_na5ku_inline_calc_bg2') ? get_option('mc_na5ku_inline_calc_bg2') : '#f1f1f1'; ?>"
                       style="width:350px;"/>
            </td>
        </tr>
        <tr>
            <td width="40%" scope="row">Отступ сверху (px)</td>
            <td><input type="number" name="mc_na5ku_inline_calc_padding_top" min="0" max="1000"
                       value="<?php echo get_option('mc_na5ku_inline_calc_padding_top') !== false ? intval(get_option('mc_na5ku_inline_calc_padding_top')) : 20; ?>"
                       style="width:350px;"/></td>
        </tr>
        <tr>
            <td width="40%" scope="row">Отступ снизу (px)</td>
            <td><input type="number" name="mc_na5ku_inline_calc_padding_bottom" min="0" max="1000"
                       value="<?php echo get_option('mc_na5ku_inline_calc_padding_bottom') !== false ? intval(get_option('mc_na5ku_inline_calc_padding_bottom')) : 20; ?>"
                       style="width:350px;"/></td>
        </tr>
        <tr>
            <td width="40%" scope="row">Отступ слева (px)</td>
            <td><input type="number" name="mc_na5ku_inline_calc_padding_left" min="0" max="1000"
                       value="<?php echo get_option('mc_na5ku_inline_calc_padding_left') !== false ? intval(get_option('mc_na5ku_inline_calc_padding_left')) : 20; ?>"
                       style="width:350px;"/></td>
        </tr>
        <tr>
            <td width="40%" scope="row">Отступ справа (px)</td>
            <td><input type="number" name="mc_na5ku_inline_calc_padding_right" min="0" max="1000"
                       value="<?php echo get_option('mc_na5ku_inline_calc_padding_right') !== false ? intval(get_option('mc_na5ku_inline_calc_padding_right')) : 20; ?>"
                       style="width:350px;"/></td>
        </tr>
        <tr>
            <th scope="row">&nbsp;</th>
            <td style="padding-top:10px;  padding-bottom:10px;">
                <input type="submit" name="wphw_submit-na5ku-calc" value="Сохранить" class="btn btn-success"/>
            </td>
        </tr>
    </table>
</form>
