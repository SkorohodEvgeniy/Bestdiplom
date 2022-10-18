jQuery(document).ready(function () {
    if (typeof (NA5KU_API_URL) === 'undefined') {
        return;
    }

    jQuery.ajax({
        url: NA5KU_API_URL + "app/getVersion",
        method: 'GET',
        dataType: 'JSON'
    }).done(function (json) {
        if (json && json.code == 200 && json.data) {
            if (json.data.version != NA5KU_APP_VER) {
                let html = '<div class="update-nag">Доступна для скачивания <a href="' + NA5KU_API_URL + 'cabinet_partner_na5ku.zip">Na5ku Кабинет версия <b>' + json.data.version + '</b>.zip</a></div>';
                jQuery('#wpbody-content').prepend(html);
            }
        } else {
            console.log('GET LIST FAILED - EMPTY!!!');
        }
    }).fail(function () {
        console.log('GET LIST FAILED!!!');
    });
});



