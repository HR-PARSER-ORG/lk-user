import $ from 'jquery';
import {showNotification} from "../components/notification";

const API_URL = process.env.API_URL;
const API_PORT = process.env.API_PORT;

$(document).ready(function () {
    var guidsArray = [];
    var firstRequest = true;
    var prevRequestData = null;

    $('table tbody tr').each(function () {
        var dataIdValue = $(this).data('id');
        guidsArray.push(dataIdValue);
    });

    var postData = {
        guids: guidsArray
    };

    var statusColorMapping = {
        'START_PARSING': 'bg-warning text-dark',
        'PARSING': 'bg-warning text-dark',
        'POST_PROCESSING': 'bg-warning text-dark',
        'MATHEMATICS': 'bg-warning text-dark',
        'PARSING_ERROR': 'bg-danger',
        'COMPLETE': 'bg-success',
        'START_CREATE_DOCUMENT': 'bg-warning text-dark',
        'COMPLETE_WITH_DOCUMENT': 'bg-success',
        'CREATING_DOCUMENT': 'bg-warning text-dark'
    };

    function updateData() {
        $.ajax({
            type: 'POST',
            url: `${API_URL}:${API_PORT}/api/v1/analytics/orders`,
            contentType: 'application/json',
            data: JSON.stringify(postData),
            success: function (responseData) {
                responseData.data.forEach(function (item, index) {
                    var tableRow = $('tr[data-id="' + item.guid + '"]');
                    var statusCell = tableRow.find('#status-' + item.guid);
                    var vacancyCount = tableRow.find('#count-' + item.guid);

                    statusCell.text(item.status);
                    vacancyCount.text(item.vacancyCount);

                    var classes = statusColorMapping[item.status];
                    if (classes) {
                        statusCell.html('<span style="width: 200px" class="badge ' + classes + '">' + item.status + '</span>');
                    }

                    if (item.filePath) {
                        if (item.status === 'COMPLETE_WITH_DOCUMENT') {
                            var downloadLink = '<a style="width: 200px" class="btn btn-primary" href="' + item.filePath + '" download>Скачать файл</a>';
                            tableRow.find('#downloadLink-' + item.guid).html(downloadLink);
                        }
                    } else {
                        if (item.status === 'COMPLETE') {
                            var generateButton = '<button style="width: 200px" class="w-500 generate-button btn btn-primary" data-guid="' + item.guid + '">Сгенерировать файл</button>';
                            tableRow.find('#downloadLink-' + item.guid).html(generateButton);
                        }
                    }
                });

                $('.generate-button').on('click', function (e) {
                    e.preventDefault();
                    var guid = $(this).data('guid');
                    var button = $(this);

                    button.removeClass('btn-primary').addClass('btn-success');

                    button.prop('disabled', true).text('Генерация...');

                    generateFile(guid);
                });

                compareRequests(prevRequestData, responseData);

                prevRequestData = responseData;

                firstRequest = false;
            },
            error: function (error) {
                console.error('Ошибка при выполнении AJAX-запроса:', error);
            }
        });
    }

    updateData();

    setInterval(updateData, 5000);
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

function compareRequests(prevRequest, curRequest) {
    if (!prevRequest) {
        return false;
    }

    for (const curItem of curRequest.data) {
        const prevItem = prevRequest.data.find(item => item.guid === curItem.guid);

        if (!prevItem) {
            continue;
        }

        if ((curItem.status === 'COMPLETE_WITH_DOCUMENT' || curItem.status === 'COMPLETE') &&
            (prevItem.status !== 'COMPLETE_WITH_DOCUMENT' && prevItem.status !== 'COMPLETE')) {
            if (curItem.status === 'COMPLETE_WITH_DOCUMENT') {
                showNotification("Документ готов!", 'id: ' + curItem.guid)
            }
            if (curItem.status === 'COMPLETE') {
                showNotification("Парсинг закончен!", 'id: ' + curItem.guid)
            }
        }
    }
}
