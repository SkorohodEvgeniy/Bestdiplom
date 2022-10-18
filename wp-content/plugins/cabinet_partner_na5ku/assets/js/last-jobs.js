jQuery(document).ready(function () {
    if (typeof (NA5KU_API_URL) === 'undefined') {
        return;
    }

    $.ajax({
        url: NA5KU_API_URL + "ordersGuest/getFinishedList",
        method: 'POST',
        data: {
            "data": {
                "valuta": NA5KU_VALUTA
            }
        },
        dataType: 'JSON'
    }).done(function (json) {
        if (json && json.code == 200 && json.data) {
            var order, desktopHTML = '', mobileHTML = '';
            for (var i = 0; i < json.data.length; i++) {
                order = json.data[i];
                desktopHTML += '<tr class="na5ku-job-item">';
                desktopHTML += '<td data-label="Дата" class="na5ku-date">' + order.date + '</td>';
                desktopHTML += '<td data-label="Номер"  class="na5ku-id">' + order.id + '</td>';
                desktopHTML += '<td data-label="Тема" class="na5ku-topic">' + order.topic + '</td>';
                desktopHTML += '<td data-label="Тип" class="na5ku-type">' + order.type + '</td>';
                desktopHTML += '</tr>';

                mobileHTML += '<div class="na5ku-job-item">';
                mobileHTML += '<div class="na5ku-name na5ku-topic"><span>Тема:</span> ' + order.topic + '</div>';
                mobileHTML += '<div class="na5ku-name na5ku-type"><span>Тип:</span> ' + order.type + '</div>';
                mobileHTML += '<div class="na5ku-name na5ku-id"><span>Номер:</span> ' + order.id + '</div>';
                mobileHTML += '<div class="na5ku-name na5ku-date"><span>Дата:</span> ' + order.date + '</div>';
                mobileHTML += '</div>';
            }
            $('.na5ku-last-jobs').children('tbody').html(desktopHTML);
            $('.na5ku-last-jobs-mobile').html(mobileHTML);
        } else {
            console.log('GET LIST FAILED - EMPTY!!!');
        }
    }).fail(function () {
        console.log('GET LIST FAILED!!!');
    });
});

