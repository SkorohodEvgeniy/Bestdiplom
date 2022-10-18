jQuery(document).ready(function () {
    //Form label animation
    var ctaForm = $('.js-cta-form');
    var ctaFromElemens = ctaForm.find('.js-cta-form-item');
    ctaFromElemens.each(function () {
        var input = $(this).find('.wpcf7-form-control');
        input.on('focus', function () {
            $(this).closest('.js-cta-form-item').addClass('is-focused');
        });
        input.on('blur', function () {
            if ($(this).val() == '') {
                $(this).closest('.js-cta-form-item').removeClass('is-focused');
            }
        });
    });

    $('.init-select2').select2({
        dropdownCssClass: "na5ku-init-select2",
        language: document.na5kuSelect2Lang
    });

    $('#deadline, .orderDeadline').datetimepicker({
        minTime: '09:00',
        maxTime: '22:00',
    });

    //check session
    $.ajax({
        url: '/cabinet/action/checkSession',
        dataType: 'JSON',
        xhrFields: {
            withCredentials: true
        }
    }).done(function (json) {
        if (json && json.auth) {
            $('.manage-login-user').removeClass('hidden');
        } else {
            $('.manage-login-guest').removeClass('hidden');
            $('.form-na5ku-email').removeClass('hidden');
            $('.form-na5ku-phone').removeClass('hidden');
        }

        if (json.needPhone) {
            $('.form-na5ku-phone').removeClass('hidden');
            $('.form-na5ku-phone input').attr('placeholder', json.needPhonePlaceholder).attr('data-phone-mask', json.needPhoneMask);
            turnOnPhoneMask('.form-na5ku-phone input');
        }

        $('.manage-login-container').removeClass('hidden');
    }).fail(function () {
        console.log('CHECK SESSION FAILED!!!');
        $('.manage-login-guest').removeClass('hidden');
        $('.manage-login-container').removeClass('hidden');

    });
});

function toggleAddRequirements(obj) {
    $(obj).parents('form').find('.toggle-requirements').toggle(300);
}

function new_register(form) {
    var formData = new FormData(form);

    if (form.context) {
        var submittedByName = form.context.activeElement.name;
        var submittedByValue = form.context.activeElement.value;

        if (submittedByName) {
            formData.append(submittedByName, submittedByValue);
        }
    }

    $(form).find('.reg_text_send_header').html('<b class="api-response-success">Отправка...</b>');
    $.ajax({
        type: "POST",
        url: "/cabinet/action/inlineForm",
        data: formData,
        async: true,
        cache: false,

        contentType: false,
        processData: false,
        success: function (data, status, xhr) {
            var response = JSON.parse(data);
            $(form).find('.reg_text_send_header').html(response.msg);
        }
    }).fail(function () {
        console.log('CHECK ANSWER FAILED!!!');
        $(form).find('.reg_text_send_header').html('<b class="api-response-danger">Сервер вернул плохой ответ</b>');
    });
}

function do_count_filesNew(fileInput) {
    var laz_files_count = fileInput.files;

    if (laz_files_count.length > 0) {
        let parent = $(fileInput).parent('.calculation-upload-container');
        let counter = $(parent[0].form).find('.files-counter');
        console.log(counter[0]);
        $(counter[0]).html('Количество файлов: ' + laz_files_count.length);
    } else $('#file_c').html('');

}


