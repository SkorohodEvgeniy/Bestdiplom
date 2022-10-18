$(function() {
    //ajax error reporting
    var openForgotPassword = ($('#flag-open-forgot-password').length > 0);
    if(openForgotPassword) {
        var message = $('#flag-open-forgot-password').text();
        $('#modal-forgot-password-message').text(message);
        $('#modal-forgot-password-message').show();
        $('#modal-forgot-password').modal('show');
    }

    $(document).on('click', '.jq-forgot-password', function() {
        // $('#laz-popup').magnificPopup('close');
        $('.jq-enter-form-close').click();
        $('#modal-forgot-password').modal('show');
        return false;
    });

    // submit forgot-password form modal
    $('#modal-forgot-password-submit').on('click', function (event) {
        $.ajax({
            type: "POST",
            url: "cabinet/forgot-password/ajax.php",
            data: $("#modal-forgot-password-form").serialize(),
            success: function(response, status, xhr) {
                var data = JSON.parse(response);
                $('#modal-forgot-password-message').html(data.message);
                $('#modal-forgot-password-message').show();
                console.log(data.status);
                console.log(data);
                if (data.status == "ok"){
                    setTimeout(function(){
                        window.location.reload(1);
                    }, 3000);

                }else if(data.status == "error"){
                    $('#forgot-popup-succes').click();
                }


            }
        });
        // $('#modal-forgot-password-form').submit();
    });
});


function do_enter() {
    return $("#text_send").replaceWith("<span id='text_send'>" + sending + "</span>"), $.ajax({
        type: "POST",
        url: "/enter_do.php",
        data: $("#enter_form_1").serialize(),
        success: function(e) {
            $("#ent_pass").val(""), "true" == e || $("#text_send").replaceWith("<span id='text_send'>" + e + "</span>")
        }
    }), !1
}

function do_reg() {
    return $("#reg_text_send").replaceWith("<span id='reg_text_send'>" + sending + "</span>"), $.ajax({
        type: "POST",
        url: "/reg_do.php",
        data: $("#reg_form_1").serialize(),
        success: function(e) {
            "true" == e || $("#reg_text_send").replaceWith("<span id='reg_text_send'>" + e + "</span>")
        }
    }), !1
}

function load_profile_form() {
    $("#text_send_pro").html(loading);
    $("#text_body_pro").show();
    $("#profile_form").hide();
    $.ajax({
        type: "POST",
        url: "/cabinet/profile.get",
        success: function(e) {
            $("#profile_form").show();

            var t = jQuery.parseJSON(e);
            console.log(t);
            $("#send_b_pro").show();
            $("#text_send_pro").html('');
            $("#j_mail").html(t.mail);
            $("#j_name").val(t.name);
            $("#j_mail_form").val(t.mail);
            $("#j_phone").val(t.phone);
            if(t.news==1) $("#j_news").attr("checked", true);else $("#j_news").prop("checked", false);
            turnOnPhoneMask('.phone-input')
        }
    });


}

function do_pro() {
    $("#text_send_pro").html(sending);
    $.ajax({
        type: "POST",
        url: "/cabinet/profile.do",
        data: $("#profile_form").serialize(),
        success: function(e) {
            // console.info('Profile done: ', e);
            $("#text_send_pro").html(e)
        }
    });

}

var sending = "Обработка данных...",
    loading = "Обработка данных...";

var need_reload=false;
var submit_hide=false;
function send_lpform_data(){
    $("#l-p-submit").hide();
    $("#l-p-loading").html("Обработка данных..."), $.ajax({
        type: "POST",
        url: "/cabinet/action.do",
        data: $("#l-p-form").serialize(),
        success: function(e) {
            $("#l-p-loading").html("");
            $("#l-p-text").html(e);
            if(need_reload){
                reload_page();
            }
        }
    });
    return false;
}

function load_form(title,action,id){
    $("#l-p-title").html(title);
    $("#l-p-loading").html("Обработка данных...");
    $("#l-p-text").html("");
    $("#l-p-submit").hide();
    submit_hide=false;

    $.ajax({
        type: "GET",
        url: "/cabinet/action.get?a2="+action+"&id="+id,
        success: function(e) {
            $("#l-p-loading").html("");
            $("#l-p-text").html(e);
            if(!submit_hide)$("#l-p-submit").show();

            if(need_reload){
                reload_page();
            }
        }
    });
}

function reload_page(){
    setTimeout(function() { location.reload();},2000);
}
function close_modal(){
    $('#modal_close').trigger('click');
}

function explode(delimiter, string, limit) {
    //  discuss at: http://phpjs.org/functions/explode/
    // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    //   example 1: explode(' ', 'Kevin van Zonneveld');
    //   returns 1: {0: 'Kevin', 1: 'van', 2: 'Zonneveld'}

    if (arguments.length < 2 || typeof delimiter === 'undefined' || typeof string === 'undefined') return null;
    if (delimiter === '' || delimiter === false || delimiter === null) return false;
    if (typeof delimiter === 'function' || typeof delimiter === 'object' || typeof string === 'function' || typeof string ===
        'object') {
        return {
            0: ''
        };
    }
    if (delimiter === true) delimiter = '1';

    // Here we go...
    delimiter += '';
    string += '';

    var s = string.split(delimiter);

    if (typeof limit === 'undefined') return s;

    // Support for limit
    if (limit === 0) limit = 1;

    // Positive limit
    if (limit > 0) {
        if (limit >= s.length) return s;
        return s.slice(0, limit - 1)
            .concat([s.slice(limit - 1)
                .join(delimiter)
            ]);
    }

    // Negative limit
    if (-limit >= s.length) return [];

    s.splice(s.length + limit);
    return s;
}

function base64_decode( data ) {	// Decodes data encoded with MIME base64
    //
    // +   original by: Tyler Akins (http://rumkin.com)


    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i=0, enc='';

    do {  // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));

        bits = h1<<18 | h2<<12 | h3<<6 | h4;

        o1 = bits>>16 & 0xff;
        o2 = bits>>8 & 0xff;
        o3 = bits & 0xff;

        if (h3 == 64)	  enc += String.fromCharCode(o1);
        else if (h4 == 64) enc += String.fromCharCode(o1, o2);
        else			   enc += String.fromCharCode(o1, o2, o3);
    } while (i < data.length);

    return enc;
}


function do_count_files(){
    var laz_files_count=$('#file_val')[0].files;

    // var laz_files_count=explode(',',$('#file_val').val());
    //alert (laz_files_count.length);
    var tmp_string=laz_files_count[0];
    if(laz_files_count.length>0){
        $('#file_c').html('Количество файлов: '+laz_files_count.length);
    }
    else $('#file_c').html('');

}
