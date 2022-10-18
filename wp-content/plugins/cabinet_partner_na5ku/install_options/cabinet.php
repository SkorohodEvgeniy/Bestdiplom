<?php if ($successMSG): ?>
    <div id="message" class="updated below-h2">
        <p>Данные обновились</p>
    </div>
<?php endif; ?>
<form method="post" action="?page=na5ku-cabinet-setup&a=cabinet">
    <table class="form-table">
        <tr>
            <td width="40%" scope="row">Title для кабинета</td>
            <td>
                <input type="text" name="mc_bg_text_title"
                       value="<?php echo get_option('mc_bg_text_title'); ?>" style="width:350px;"/>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Номер телефона</td>
            <td>
                <input type="text" name="mc_bg_phone1"
                       value="<?php echo get_option('mc_bg_phone1'); ?>" style="width:350px;"/>
            </td>
        </tr>
        <tr>
            <td width="40%" scope="row">Номер телефона (усли у вас 2 номера)</td>
            <td>
                <input type="text" name="mc_bg_phone2"
                       value="<?php echo get_option('mc_bg_phone2'); ?>" style="width:350px;"/>
            </td>
        </tr>
        <tr>
            <td width="40%" scope="row">Укажите надпись в футере <p class="form-help">(© Copyright --NAME COMPANY--)</p>
            </td>
            <td>
                <input type="text" name="mc_bg_text_footer"
                       value="<?php echo get_option('mc_bg_text_footer'); ?>" style="width:350px;"/>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Ссылка на ваши стили для кабинета<p class="form-help">(не обязательный
                    параметр)</p></td>
            <td>
                <input type="text" name="mc_na5ku_cabinet_css"
                       value="<?php echo get_option('mc_na5ku_cabinet_css'); ?>" style="width:350px;"/>
            </td>
        </tr>
        <tr>
            <td width="40%" scope="row">Ссылка на ваш скрипт для кабинета<p class="form-help">(не обязательный
                    параметр)</p></td>
            <td>
                <input type="text" name="mc_na5ku_cabinet_js"
                       value="<?php echo get_option('mc_na5ku_cabinet_js'); ?>" style="width:350px;"/>
            </td>
        </tr>

        <tr>
            <td colspan="10">
                <hr>
                <h3>Форма добавления заказа:</h3>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Выводить <b>
                    <i>специальность</i>
                </b> вместо <b>
                    <i>предмета</i>
                </b>
                <p class="form-help">(перед активацией получите разрешение от администрации)</p></td>
            <td>
                <select name="mc_na5ku_subjectReplaceSpec" id="" style="width:350px;">
                    <option value="0">Нет
                    </option>
                    <option <?php if (get_option('mc_na5ku_subjectReplaceSpec') == '1') {
                        echo "selected";
                    } ?> value="1">Да
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Скрыть <b>
                    <i>предварительную стоимость</i>
                </b>
                <p class="form-help"></p></td>
            <td>
                <select name="mc_na5ku_hidePrePrice" id="" style="width:350px;">
                    <option value="0">Нет
                    </option>
                    <option <?php if (get_option('mc_na5ku_hidePrePrice') == '1') {
                        echo "selected";
                    } ?> value="1">Да
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Скрыть <b>
                    <i>к-во страниц</i>
                </b>
                <p class="form-help">(Отключание к-ва страниц может привезти к спаду вашего дохода)</p></td>
            <td>
                <select name="mc_na5ku_hidePages" id="" style="width:350px;">
                    <option value="0">Нет
                    </option>
                    <option <?php if (get_option('mc_na5ku_hidePages') == '1') {
                        echo "selected";
                    } ?> value="1">Да
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="10">
                <hr>
                <h3>Навигация:</h3>
            </td>
        </tr>
        <tr>
            <td width="40%" scope="row">Скрыть <b>
                    <i>FAQ</i>
                </b>
                <p class="form-help"></p></td>
            <td>
                <select name="mc_na5ku_hideFAQ" id="" style="width:350px;">
                    <option value="0">Нет
                    </option>
                    <option <?php if (get_option('mc_na5ku_hideFAQ') == '1') {
                        echo "selected";
                    } ?> value="1">Да
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Скрыть <b>
                    <i>Примеры работ</i>
                </b>
                <p class="form-help"></p></td>
            <td>
                <select name="mc_na5ku_hideSamples" id="" style="width:350px;">
                    <option value="0">Нет
                    </option>
                    <option <?php if (get_option('mc_na5ku_hideSamples') == '1') {
                        echo "selected";
                    } ?> value="1">Да
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Скрыть <b>
                    <i>Помогайте и экономьте</i>
                </b>
                <p class="form-help"></p></td>
            <td>
                <select name="mc_na5ku_hideEarn" id="" style="width:350px;">
                    <option value="0">Нет
                    </option>
                    <option <?php if (get_option('mc_na5ku_hideEarn') == '1') {
                        echo "selected";
                    } ?> value="1">Да
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <td width="40%" scope="row">Скрыть <b>
                    <i>Скидки</i>
                </b>
                <p class="form-help"></p></td>
            <td>
                <select name="mc_na5ku_hideDiscount" id="" style="width:350px;">
                    <option value="0">Нет
                    </option>
                    <option <?php if (get_option('mc_na5ku_hideDiscount') == '1') {
                        echo "selected";
                    } ?> value="1">Да
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="10" align="center">
                <input type="submit" name="wphw_submit-na5ku-cabinet" value="Сохранить" class="btn btn-success"/>
            </td>
        </tr>
    </table>
</form>
