jQuery(document).ready(function () {
    if (typeof (NA5KU_API_URL) === 'undefined') {
        return;
    }

    if ($('.calculation-range-uniq').length > 0) {
        $.each($('.calculation-range-uniq'), function (index, item) {
            orderUniqRange(item);
        })
    }

    jQuery.ajax({
        url: NA5KU_API_URL + 'type/list',
        method: 'POST',
        data: {
            "data": {
                "valuta": NA5KU_VALUTA
            }
        },
        dataType: 'JSON',
        success: function (json) {
            let typeStr = '';

            json.data.forEach(type => {
                typeStr += '<option value="' + type.id + '">' + (NA5KU_TYPES_LANG == 'ua' ? type.type_ua : type.type) + '</option>';
            });

            jQuery('.na5ku-type-list').html(typeStr);

            if (typeof ($().select2) != 'undefined') {
                $('.na5ku-type-list').select2();
            }
        }
    });
});

function orderUniqRange(rangeCalc) {
    let rangeVal = $(rangeCalc).val();
    let max = $(rangeCalc).attr('max'),
        min = $(rangeCalc).attr('min');
    let range = max - min;
    let percent = 0;
    if (range) {
        percent = Math.round((rangeVal - min) / range * 100);
    }

    $(rangeCalc).parent('.calculation-range-uniq-container').find('.range-number').text(rangeVal + "%");
    $(rangeCalc).css({'background-image': 'linear-gradient(to right,' + na5kuCalcRangeColor + ' 0%, ' + na5kuCalcRangeColor + ' ' + percent + '%,#f3f3f3 ' + percent + '%,#f3f3f3 100%'});
}

function turnOnPhoneMask(selector) {
    var inputs = $(selector);

    for(var i=0;i<inputs.length;i++){
        $(inputs[i]).mask($(inputs[i]).attr('data-phone-mask'));
    }
}
