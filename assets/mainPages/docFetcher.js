import $ from 'jquery';

$(document).ready(function () {
    var guidsArray = [];

    $('table tbody tr').each(function () {
        var dataIdValue = $(this).data('id');
        guidsArray.push(dataIdValue);
    });

    var postData = {
        guids: guidsArray
    };

    //TODO: fix with env vars
    $.ajax({
        type: 'POST',
        url: 'http://45.90.35.14:8081/api/v1/analytics/orders',
        contentType: 'application/json',
        data: JSON.stringify(postData),
        success: function (responseData) {
            responseData.data.forEach(function (item, index) {
                var tableRow = $('tr[data-id="' + item.guid + '"]');

                if (item.filePath) {
                    var downloadLink = '<a class="btn btn-primary" href="' + item.filePath + '" download>Скачать файл</a>';
                    tableRow.find('#downloadLink-' + item.guid).html(downloadLink);
                } else {
                    var generateButton = '<button class="generate-button btn btn-primary" data-guid="' + item.guid + '">Сгенерировать файл</button>';
                    tableRow.find('#downloadLink-' + item.guid).html(generateButton);
                }

                tableRow.find('#status-' + item.guid).append(item.status);
            });

            $('.generate-button').on('click', function (e) {
                e.preventDefault();
                var guid = $(this).data('guid');
                generateFile(guid);
            });
        },
        error: function (error) {
            console.error('Ошибка при выполнении AJAX-запроса:', error);
        }
    });
});


function generateFile(guid) {
    // TODO: fix with env vars
    var generateUrl = 'http://45.90.35.14:8081/api/v1/files/excel?guid=' + guid;

    $.ajax({
        type: 'POST',
        url: generateUrl,
        success: function (response) {
            console.log('Файл успешно сгенерирован:', response);
        },
        error: function (error) {
            console.error('Ошибка при генерации файла:', error);
        }
    });
}