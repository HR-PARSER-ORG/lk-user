import $ from 'jquery';

const API_URL = process.env.API_URL;
const API_PORT = process.env.API_PORT;

$(document).ready(function () {
    var guidsArray = [];

    $('table tbody tr').each(function () {
        var dataIdValue = $(this).data('id');
        guidsArray.push(dataIdValue);
    });

    var postData = {
        guids: guidsArray
    };

    $.ajax({
        type: 'POST',
        url: `${API_URL}:${API_PORT}/api/v1/analytics/orders`,
        contentType: 'application/json',
        data: JSON.stringify(postData),
        success: function (responseData) {
            responseData.data.forEach(function (item, index) {
                var tableRow = $('tr[data-id="' + item.guid + '"]');

                if (item.filePath) {
                    if (item.status === 'COMPLETE_WITH_DOCUMENT') {
                        var downloadLink = '<a class="btn btn-primary" href="' + item.filePath + '" download>Скачать файл</a>';
                        tableRow.find('#downloadLink-' + item.guid).html(downloadLink);
                    }
                } else {
                    if (item.status === 'COMPLETE') {
                        var generateButton = '<button class="generate-button btn btn-primary" data-guid="' + item.guid + '">Сгенерировать файл</button>';
                        tableRow.find('#downloadLink-' + item.guid).html(generateButton);
                    }
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
    var generateUrl = `${API_URL}:${API_PORT}/api/v1/files/excel?guid=` + guid;

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