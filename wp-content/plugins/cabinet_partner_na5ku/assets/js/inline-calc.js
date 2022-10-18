jQuery(document).ready(function () {
    if (typeof (NA5KU_API_URL) === 'undefined') {
        return;
    }
    $('.init-select2').select2({
        dropdownCssClass: "na5ku-init-select2",
        language: na5kuCalcSelect2Lang
    });

    $('#deadline, .orderDeadline').datetimepicker({
        minTime: '09:00',
        maxTime: '22:00',
    });

    $.each($('.calculation-range'), function (index, item) {
        orderPagesRange(item);
    })

    $.each($('.calculation-range-uniq'), function (index, item) {
        orderUniqRange(item);
    })


    na5kuInlineCalcPrice($('.calculator-form')[0]);
});


function orderPagesRange(rangeCalc) {
    if (typeof (rangeCalc) === 'undefined') {
        var rangeCalc = $('.calculation-range');
    }
    let rangeVal = $(rangeCalc).val();

    let max = $(rangeCalc).attr('max'),
        min = $(rangeCalc).attr('min');
    let range = max - min;
    let percent = 0;

    if (range) {
        percent = Math.round((rangeVal - min) / range * 100);
    }

    $(rangeCalc).parent('.calculation-range-container').find('.range-number').text(rangeVal);
    $(rangeCalc).css({'background-image': 'linear-gradient(to right,' + na5kuCalcRangeColor + ' 0%, ' + na5kuCalcRangeColor + ' ' + percent + '%,#f3f3f3 ' + percent + '%,#f3f3f3 100%'});
}


function na5kuInlineCalcPrice(form) {
    var type = $(form).find('.workType');
    var deadline = $(form).find('.orderDeadline');
    var pagesCount = $(form).find('.pagesCount');
    var original = $(form).find('.uniqCount');

    if (typeof (type) === 'undefined' || !type.length) {
        return;
    }
    if (typeof (deadline) === 'undefined' || !deadline.length) {
        return;
    }
    if (typeof (pagesCount) === 'undefined' || !pagesCount.length) {
        return;
    }
    if (typeof (original) === 'undefined' || !original.length) {
        original = 50;
    } else {
        original = $(original[0]).val();
    }

    type = $(type[0]).val();
    deadline = $(deadline[0]).val();
    pagesCount = $(pagesCount[0]).val();


    if (deadline.length < 5) {
        return;
    }


    var date_t = calcExplode('/', deadline);
    var date_t_ = calcExplode(' ', date_t[2]);
    date_t[2] = date_t_[0];
    date_t[1]--;
    var secondDate = new Date(date_t[0], date_t[1], date_t[2]);
    var firstDate = new Date();
    var diffDays;
    var oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds

    if (firstDate.getTime() > secondDate.getTime()) {
        diffDays = 1
    } else {
        diffDays = Math.ceil(Math.abs((firstDate.getTime() - secondDate.getTime()) / (oneDay)));
        if (diffDays < 1) {
            diffDays = 1;
        }
    }
    calc_get_price(form, '', pagesCount, type, diffDays, na5kuCalcValuta, original);
}

function calc_get_price(form, pr_code, sel_c, sel_type, diffDays, valuta, original) {
    sendRequest('getPrice', 'POST', {
        'promo': pr_code,
        'count': sel_c,
        'type': sel_type,
        'original': original,
        'days': diffDays,
        'valuta': valuta
    }, function (response, statusCode) {
        var obj = JSON.parse(response);
        $(form).find('#price_show').html(obj.now);
        $(form).find('input[name="calc"]').val(obj.now);
        $(form).find('.calcCenaTotal').html(obj.now);
    });
}


function calcExplode(delimiter, string, limit) {
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

function na5kuInlineCalcSubmit(form) {
    var type = $(form).find('.workType');
    var deadline = $(form).find('.orderDeadline');
    var pagesCount = $(form).find('.pagesCount');
    var original = $(form).find('.uniqCount');

    $(form).find('.response-msg').html(document.NA5KU_CALC_sending);

    if (typeof (type) === 'undefined' || !type.length) {
        $(form).find('.response-msg').html('Type not found');
        return;
    }
    if (typeof (deadline) === 'undefined' || !deadline.length) {
        $(form).find('.response-msg').html('Deadline not found');
        return;
    }
    if (typeof (pagesCount) === 'undefined' || !pagesCount.length) {
        $(form).find('.response-msg').html('Pages count not found');
        return;
    }
    if (typeof (original) === 'undefined' || !original.length) {
        original = 50;
    } else {
        original = $(original[0]).val();
    }

    type = $(type[0]).val();
    deadline = $(deadline[0]).val();
    pagesCount = $(pagesCount[0]).val();

    if (deadline.length < 5) {
        $(form).find('.response-msg').html('<b class="api-response-danger">' + document.NA5KU_CALC_type_date + '</b>');
        return;
    }

    $.ajax({
        url: "/cabinet/action/checkSession",
        dataType: 'JSON',
        xhrFields: {
            withCredentials: true
        }
    }).done(function (json) {
        if (json && json.auth) {
            location.href = '/cabinet/zakaz.write?worktype=' + type + '&formDeadline=' + encodeURI(deadline) + '&tpages=' + pagesCount + '&original=' + original;
            $(form).find('.response-msg').html('<b class="api-response-success">' + document.NA5KU_CALC_redirecting + '</b>');
        } else {
            $('.reg-btn')[1].click();
            $(form).find('.response-msg').html('');
        }
    }).fail(function () {
        console.log('CHECK SESSION FAILED!!!');
        $(form).find('.response-msg').html('<b class="api-response-danger">' + document.NA5KU_CALC_something_went_wrong + '</b>');
        $('.reg-btn')[1].click();
    });
}
