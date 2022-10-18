jQuery(document).ready(function () {
    //check session
    $.ajax({
        url: "/cabinet/action/checkSession",
        dataType: 'JSON',
        xhrFields: {
            withCredentials: true
        }
    }).done(function (json) {
        if (json && json.auth) {
            $('.nav-div-logged-in').removeClass('hidden').addClass('nav-actual');
        } else {
            $('.nav-div-guest').removeClass('hidden').addClass('nav-actual');
        }
    }).fail(function () {
        console.log('CHECK SESSION FAILED!!!');
        $('.nav-div-guest').removeClass('hidden');
    });

    //move our modals
    $('.na5ku-modals-div').appendTo($('body'));
});
