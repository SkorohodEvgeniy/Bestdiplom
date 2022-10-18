function na5ku_miniForm(form) {
    var type = 0;
    try {
        type = jQuery(form).find('.na5ku-type-list').val();
    } catch (e) {
        console.log(e);
    }

    jQuery(form).find('.jq-local-registration-result').html('');

    if (na5kuMini_getCookie('api_token')) {
        if (type) {
            document.location.href = '/cabinet/zakaz.write?worktype=' + type;
        } else {
            document.location.href = '/cabinet';
        }

        return;
    }

    sendRequest('register', 'POST', jQuery(form).serialize(), function (response, statusCode) {
        let data = response.data,
            code = response.code;

        if (typeof (data.email) !== "undefined") {
            jQuery(form).find('.jq-local-registration-result').html(data.email);
            return false;
        }

        if (code == '200' && typeof (data.token) !== 'undefined') {
            document.cookie = "api_token=" + data.token + '; path=/';
            setTimeout(function () {
                if (type) {
                    document.location.href = '/cabinet/zakaz.write?worktype=' + type;
                } else {
                    document.location.href = '/cabinet';
                }
            }, 300);
        } else if (code == '499') {
            jQuery(form).find('.jq-local-registration-result').html(data);
            return false;
        }
    })
}

function na5kuMini_getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
