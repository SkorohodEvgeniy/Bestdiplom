<?php
$country = $GenSettings->getCountry($user_data['valuta']);

?><!-- Hidden Popup -->
<div class="hidden">
    <div id="popup" class="popup">
        <h3>Редактировать профиль</h3>
        <p>
            <span id='text_send_pro'>Загрузка</span>
        </p>
        <form id="profile_form" onsubmit='do_pro();return false;' autocomplete="off">
            <p>Ваша почта:
                <span id='j_mail'></span>
            </p>

            <div class="mb-10">
                <input type="text" name="name" id='j_name' class="form-control" placeholder="Ваше имя" required>
            </div>

            <?php
            if (!$user_data['mail']) { ?>
                <div class="mb-10">
                    <input type="text" name="new_mail" id="j_mail_form" placeholder="Введите почту" class="form-control"
                           required>
                </div>
            <?php } ?>

            <div class="mb-10">
                <input type="text" name="phone" class="form-control phone-input" id='j_phone' required
                       placeholder="<?= $country['country_phone_placeholder'] ?>"
                       data-phone-mask="<?= $country['country_phone_mask'] ?>">
            </div>

            <div class="mb-10">
                <input type="password" name="new_pass" placeholder="Новый пароль" class="form-control">
            </div>
            <div class="mb-10">
                <input type="password" name="new_pass_conf" placeholder="Повторите новый пароль" class="form-control">
            </div>

            <div class="form-group">
                <button class="button">Подтвердить</button>
            </div>
        </form>
    </div>
</div>
