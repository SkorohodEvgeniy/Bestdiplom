// const API_URL = window.location.protocol + '//api.edu-masters.com/';
const API_URL = 'https://api.edu-masters.com/';

function do_enter() {

    let data = sendRequest('login', 'POST', jQuery("#enter_form_1").serialize(), function (response, statusCode) {

        let code = response.code;
        let data = response.data;

        if (code === 0) {
            jQuery("#ent_pass").val("");
            let token = data.token;
            localStorage.setItem('api_token', token);
            document.cookie = "api_token=" + token + '; path=/';
            jQuery("#text_send").replaceWith("<span id='text_send'><div class='api-response-success'>Успех!</div></span>");
            setTimeout(function () {
                document.location.href = '/cabinet';
            }, 3000);
        } else {
            jQuery("#text_send").replaceWith("<span id='text_send'><div class='api-response-danger'>" + data + "</div></span>");
        }
    });

    return jQuery("#text_send").replaceWith("<span id='text_send'><div class='api-response-success'>" + "отправка" + "</div></span>");
}

function forgotpassword() {
    sendRequest('forgotpassword', 'POST', jQuery("#modal-forgot-password-form").serialize(), function (response, statusCode) {

        let data = response.data,
            code = response.code,
            email = response.email;
        if (code == '200') {
            jQuery('#modal-forgot-password-message').html(data);
            setTimeout(function () {
                document.location.href = '/';
            }, 3000);
        } else if (email != "undefined") {
            jQuery('#modal-forgot-password-message').html(data.email);
        }
    })
}

function register() {
    jQuery('#register-popup_message_HEAD').html('');
    sendRequest('register', 'POST', jQuery('#na5ku-reg-form-inline').serialize(), function (response, statusCode) {
        let data = response.data,
            code = response.code;

        if (code == '200') {
            jQuery('#register-popup_message_HEAD').html('<span class="reg-success api-response-success">Успешная регистрация, перенаправление...</span>');
            document.cookie = "api_token=" + data.token + '; path=/';
            setTimeout(function () {
                document.location.href = '/cabinet';
            }, 300);
        } else if (code == '499') {
            jQuery('#register-popup_message_HEAD').html(data);
            return false;
        } else {
            jQuery('#register-popup_message_HEAD').html(data.email);
        }
    })
}


function get_types() {
    sendRequest('type/list', 'POST', {}, function (response, $statusCode) {
        let data = response.data,
            select;

        for (var key in data) {
            if (!data.hasOwnProperty(key)) {
                continue;
            }
            select += "<option value='" + data[key].id + "'>" + data[key].type + "</option>";
        }
        $('body').find('#type').append(select);
    })
}

function getSubject() {
    sendRequest('subject/getList', 'POST', {}, function (response, $statusCode) {
        let data = response.data,
            select;
        for (var key in data) {
            if (!data.hasOwnProperty(key)) {
                continue;
            }
            select += "<option value='" + data[key].id + "'>" + data[key].name + "</option>";
        }
        $('body').find('.js-example-basic-single').append(select);
    })
}

function sendRequest(url, method, data, successCallback) {

    let token = getCookieByName('api_token');
    let customHeaders = {};

    if (token) {
        customHeaders.Authorization = 'Bearer ' + token;
    }

    if (typeof (data) == 'object') {
        data.ref_id = NA5KU_REF_ID;
        data.valuta = NA5KU_VALUTA;
        data.SITE_API_KEY = NA5KU_API_KEY;
    } else if (!Array.isArray(data)) {
        data += '&ref_id=' + NA5KU_REF_ID + '&valuta=' + NA5KU_VALUTA + '&SITE_API_KEY=' + NA5KU_API_KEY;
    } else {
        data['ref_id'] = NA5KU_REF_ID;
        data['valuta'] = NA5KU_VALUTA;
        data['SITE_API_KEY'] = NA5KU_API_KEY;
    }

    return jQuery.ajax({
        type: method,
        url: NA5KU_API_URL + url,
        data,
        success: function (response, $statusCode) {
            let code = response.code;
            if (code == 400) {
                //alert(response.data);
            }

            successCallback(response, $statusCode);
        },
        headers: {
            ...customHeaders
        }
    })
}

function isAuthorized() {
    return !!localStorage.api_token;
}

function loadUser() {
    if (!isAuthorized()) {
        window.location.href = '/';
        console.error('User is not logged in!');
        return;
    }
    console.info('sending the rquest');
    sendRequest('get_current_user', 'GET', {}, function (response, status) {
        jQuery('.jq-data-user').attr('title', response.data.login);
        jQuery('.jq-data-user > a').html(response.data.login);
    });
}

function get_price(pr_code, sel_c, sel_type, diffDays, valuta, original) {
    sendRequest('getPrice', 'POST', {
        'promo': pr_code,
        'count': sel_c,
        'type': sel_type,
        'original': original,
        'days': diffDays,
        'valuta': valuta
    }, function (response, statusCode) {
        var obj = JSON.parse(response);
        $('#price_show').html(obj.now);
        $('input[name="calc"]').val(obj.now);
        $('.calcCenaTotal').html(obj.now);

        if (obj.sk_count > 0) {
            $('input[name="show_procent"]').val(obj.procent);
            $('input[name="show_skidka"]').val(obj.sk_count);
            if (obj.valuta == 1) {
                $('#procent_now').html("(c учетом накопительной скидки ");
                $('#procent_now2').html(" - " + obj.sk_count + " UAH)");
            } else if (obj.valuta == 3) {
                $('#procent_now').html("(c учетом накопительной скидки ");
                $('#procent_now2').html(" - " + obj.sk_count + " USD)");
            } else {
                $('#procent_now').html("(c учетом накопительной скидки " + obj.procent + " %");
                $('#procent_now2').html(" - " + obj.sk_count + " RUB)");
            }
        } else {
            $('input[name="show_skidka"]').val(0);
            $('input[name="show_procent"]').val(0);

            $('#procent_now').html("");
            $('#procent_now2').html("");
        }
    });

}

function updateNamePhone() {
    sendRequest('user/updateNamePhone', 'POST', jQuery('#reg-form_st2').serialize(), function (response, statusCode) {
        let data = response.data,
            code = response.code;
        if (code == '201') {
            setTimeout(function () {
                document.location.href = '/cabinet';
            }, 1000);
        } else {
            jQuery('#register-popup_message_HEAD').html(data.email);
        }
    })
}

jQuery(document).ready(function () {
    jQuery('.forgot-password').click(function () {
        jQuery('.modal-backdrop').hide();
        jQuery('#login').hide();
        jQuery('#register').hide();
    });
    jQuery('.register').click(function () {
        jQuery('.modal-backdrop').hide();
        jQuery('#login').hide();
    });
    jQuery('.login').click(function () {
        jQuery('.modal-backdrop').hide();
        jQuery('#register').hide();
    });
});

function getCookieByName(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
