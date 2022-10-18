<?php if ($successMSG): ?>
    <div id="message" class="updated below-h2">
        <p>Данные обновились</p>
    </div>
<?php endif; ?>
<form method="post" action="?page=na5ku-cabinet-setup&a=main">
    <table class="form-table">
        <tr>
            <td width="40%" scope="row">Свой REF_ID<p class="form-help">(метку использовать нельзя)</p></td>
            <td><input type="text" name="mc_bg_ref_id"
                       value="<?php echo get_option('mc_bg_ref_id'); ?>" style="width:350px;"/>
            </td>
        </tr>
        <tr>
            <td width="40%" scope="row">API KEY сайта<p class="form-help">(не обязательный параметр)</p></td>
            <td><input type="text" name="mc_na5ku_api_key"
                       value="<?php echo get_option('mc_na5ku_api_key'); ?>" style="width:350px;"/>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Валюта <p class="form-help">(изменения отразятся только на новых клиентах)</p>
            </td>
            <td><select name="mc_bg_valuta" id="" style="width:350px;">
                    <option <?php if (get_option('mc_bg_valuta') == 'ua') {
                        echo "selected";
                    } ?> value="ua">UAH
                    </option>
                    <option <?php if (get_option('mc_bg_valuta') == 'ru') {
                        echo "selected";
                    } ?> value="ru">RUB
                    </option>
                    <option <?php if (get_option('mc_bg_valuta') == 'usd') {
                        echo "selected";
                    } ?> value="usd">USD
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td width="40%" scope="row">Язык типов работ
            </td>
            <td><select name="mc_bg_type_lang" id="" style="width:350px;">
                    <option <?php if (get_option('mc_bg_type_lang') == 'ru' ) {
                        echo "selected";
                    } ?> value="ru">Русский
                    </option>
                    <option <?php if (get_option('mc_bg_type_lang') == 'ua') {
                        echo "selected";
                    } ?> value="ua">Українська
                    </option>

                </select>
            </td>
        </tr>
        <tr>
            <td width="40%" scope="row">Выводить поле <b><i>уникальность</i></b> <p class="form-help">(уникальность в заказе)</p></td>
            <td><select name="mc_na5ku_uniq" id="" style="width:350px;">
                    <option value="1">Да
                    </option>
                    <option <?php if (get_option('mc_na5ku_uniq') == '0') {
                        echo "selected";
                    } ?> value="0">Нет
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="10">
                <hr>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Цвет для кнопок <p class="form-help">(По умолчанию RGB: 128, 128, 255)</p></td>
            <td><input type="color" name="mc_bg_button_color"
                       value="<?php echo get_option('mc_bg_button_color') ? get_option('mc_bg_button_color') : NA5KU_CNF_DEF_COLOR; ?>"
                       style="width:350px;"/>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Подключить библиотеку <b><i>jquery 3.4.1</i></b></td>
            <td><select name="mc_na5ku_jq341" id="" style="width:350px;">
                    <option value="1">Да
                    </option>
                    <option <?php if (get_option('mc_na5ku_jq341') == '-1') {
                        echo "selected";
                    } ?> value="-1">Нет
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Подключить библиотеку <b><i>Bootstrap v3.3.5</i></b></td>
            <td><select name="mc_na5ku_bootstrap" id="" style="width:350px;">
                    <option value="1">Да
                    </option>
                    <option <?php if (get_option('mc_na5ku_bootstrap') == '-1') {
                        echo "selected";
                    } ?> value="-1">Нет
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="10" align="center">
                <input type="submit" name="wphw_submit" value="Сохранить" class="btn btn-success"/>
            </td>
        </tr>
    </table>
</form>
