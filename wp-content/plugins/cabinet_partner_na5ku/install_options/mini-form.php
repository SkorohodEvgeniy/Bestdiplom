<?php if ($successMSG): ?>
    <div id="message" class="updated below-h2">
        <p>Данные обновились</p>
    </div>
<?php endif; ?>
<form method="post" action="?page=na5ku-cabinet-setup&a=mini-form">
    <pre>Шорт - [<?= SHORT_MINI_FORM ?>]</pre>
    <table class="form-table">
        <tr>
            <td width="40%" scope="row">Текст кнопки регистрации</td>
            <td><input type="text" name="mc_home_reg_action" placeholder="Зарегистрироваться"
                       value="<?php echo get_option('mc_home_reg_action'); ?>" style="width:350px;"/></td>
        </tr>
        <tr>
            <td width="40%" scope="row">Подсказка поля почты</td>
            <td><input type="text" name="mc_home_reg_action_placeholder" placeholder="Электронная почта *"
                       value="<?php echo get_option('mc_home_reg_action_placeholder'); ?>" style="width:350px;"/></td>
        </tr>

        <tr>
            <td width="40%" scope="row">Показывать типы заказов</td>
            <td><select name="mc_mini_show_types" id="" style="width:350px;">
                    <option value="1">Да
                    </option>
                    <option <?php if (get_option('mc_mini_show_types') == '0') {
                        echo "selected";
                    } ?> value="0">Нет
                    </option>
                </select>
        </tr>

        <tr>
            <th scope="row">&nbsp;</th>
            <td style="padding-top:10px;  padding-bottom:10px;">
                <input type="submit" name="wphw_submit-na5ku-mini" value="Сохранить" class="btn btn-success"/>
            </td>
        </tr>
    </table>
</form>
