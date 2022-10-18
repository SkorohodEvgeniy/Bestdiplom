<?php if ($successMSG): ?>
    <div id="message" class="updated below-h2">
        <p>Данные обновились</p>
    </div>
<?php endif; ?>
<form method="post" action="?page=na5ku-cabinet-setup&a=inline-form">
    <div class="alert alert-success">В форме поле <b>email</b> появится <b>автоматически</b>, если пользователь не
        авторизован/зарегистрирован.
    </div>
    <pre>Шорт для горизонтальной формы - [<?= SHORT_INLINE_FORM ?>]
Шорт для вертикальной формы - [<?= SHORT_INLINE_FORM_VERTICAL ?>]</pre>
    <table class="form-table">
        <tr>
            <td width="40%" scope="row">Текст кнопки регистрации для <b>[<?= SHORT_INLINE_FORM ?>]</b></td>
            <td><input type="text" name="mc_na5ku_inline_form_action" placeholder="Узнать стоимость"
                       value="<?php echo get_option('mc_na5ku_inline_form_action'); ?>"
                       style="width:350px;"/></td>
        </tr>
        <tr>
            <td width="40%" scope="row">Показать кнопку <b><i>дополнительные требования</i></b></td>
            <td><select name="mc_na5ku_inline_addOptions" id="" style="width:350px;">
                    <option value="1">Да
                    </option>
                    <option <?php if (get_option('mc_na5ku_inline_addOptions') == '-1') {
                        echo "selected";
                    } ?> value="-1">Нет
                    </option>
                </select>
        </tr>
        <tr>
            <td width="40%" scope="row">Цвет фона <p class="form-help">(По умолчанию RGB: 255, 255, 255)</p></td>
            <td><input type="color" name="mc_na5ku_inline_form_bg"
                       value="<?php echo get_option('mc_na5ku_inline_form_bg') ? get_option('mc_na5ku_inline_form_bg') : '#ffffff'; ?>"
                       style="width:350px;"/>
            </td>
        </tr>
        <tr>
            <td width="40%" scope="row">Отступ сверху (px)</td>
            <td><input type="number" name="mc_na5ku_inline_form_padding_top" min="0" max="1000"
                       value="<?php echo get_option('mc_na5ku_inline_form_padding_top') !== false ? intval(get_option('mc_na5ku_inline_form_padding_top')) : 20; ?>"
                       style="width:350px;"/></td>
        </tr>
        <tr>
            <td width="40%" scope="row">Отступ снизу (px)</td>
            <td><input type="number" name="mc_na5ku_inline_form_padding_bottom" min="0" max="1000"
                       value="<?php echo get_option('mc_na5ku_inline_form_padding_bottom') !== false ? intval(get_option('mc_na5ku_inline_form_padding_bottom')) : 20; ?>"
                       style="width:350px;"/></td>
        </tr>
        <tr>
            <td width="40%" scope="row">Отступ слева (px)</td>
            <td><input type="number" name="mc_na5ku_inline_form_padding_left" min="0" max="1000"
                       value="<?php echo get_option('mc_na5ku_inline_form_padding_left') !== false ? intval(get_option('mc_na5ku_inline_form_padding_left')) : 20; ?>"
                       style="width:350px;"/></td>
        </tr>
        <tr>
            <td width="40%" scope="row">Отступ справа (px)</td>
            <td><input type="number" name="mc_na5ku_inline_form_padding_right" min="0" max="1000"
                       value="<?php echo get_option('mc_na5ku_inline_form_padding_right') !== false ? intval(get_option('mc_na5ku_inline_form_padding_right')) : 20; ?>"
                       style="width:350px;"/></td>
        </tr>
        <tr>
            <th scope="row">&nbsp;</th>
            <td style="padding-top:10px;  padding-bottom:10px;">
                <input type="submit" name="wphw_submit-na5ku-form" value="Сохранить" class="btn btn-success"/>
            </td>
        </tr>
    </table>
</form>