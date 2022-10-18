<?php if ($successMSG): ?>
    <div id="message" class="updated below-h2">
        <p>Данные обновились</p>
    </div>
<?php endif; ?>
<form enctype="multipart/form-data" action="?page=na5ku-cabinet-setup&a=logo" method="POST">
    <table class="form-table">
        <tr>
            <th>Добавьте логотип</th>
            <td><input name="mc_bg_header_logo" type="file"/>
                <input name="wphw_submit_logo" type="submit" value="Сохранить" class="btn btn-success"/>
            </td>
            <td><img src="<?php echo get_option('mc_bg_header_logo'); ?>"
                     style="max-height: 40%;max-width: 40%" alt=""></td>
        </tr>
    </table>
</form>