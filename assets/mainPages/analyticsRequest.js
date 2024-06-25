import $ from 'jquery';

$(document).ready(function() {
    $('#searchModifier').select2({
        width: '100%',
        placeholder: 'Выберите модификатор поиска',
        allowClear: true,
        closeOnSelect: false,
        theme: "bootstrap-5"
    });

    $('#qualificationLevel').select2({
        width: '100%',
        placeholder: 'Выберите уровень квалификации',
        allowClear: true,
        closeOnSelect: false,
        theme: "bootstrap-5"
    });

    $('.toggle-all-industries').click(function() {
        $('.industry-group').toggle();
    });

    $('.toggle-industry').click(function() {
        var target = $(this).data('target');
        $(target).toggle();
    });

    $('#region').select2({
        width: '100%',
        placeholder: 'Выберите регион',
        allowClear: true,
        closeOnSelect: false,
        theme: "bootstrap-5"
    });

    $('#selectAllRegionsButton').click(function(event) {
        event.preventDefault();

        var allValues = $('#region option').map(function() {
            return $(this).val();
        }).get();

        $('#region').val(allValues).trigger('change');
    });

    $('#selectAllIndustriesButton').click(function(event) {
        event.preventDefault();

        var allValues = $('#industry option').map(function() {
            return $(this).val();
        }).get();

        $('#industry').val(allValues).trigger('change');
    });

    industries.forEach(function(industry) {
        $('#industry-' + industry).select2({
            width: '100%',
            placeholder: 'Выберите индустрию',
            allowClear: true,
            closeOnSelect: false,
            theme: "bootstrap-5"
        });

        $('#selectAllIndustriesButton-' + industry).click(function(event) {
            event.preventDefault();

            var allValues = $('#industry-' + industry +' option').map(function() {
                return $(this).val();
            }).get();

            $('#industry-' + industry).val(allValues).trigger('change');
        });
    });


    $('#submitBtn').on('click', function(event) {
        event.preventDefault();

        var industryValues = $('[id^="industry-"]').map(function() {
            return $(this).val();
        }).get();

        var formData = {
            searchField: $('#searchField').val(),
            hasSalary: $('#hasSalary').is(':checked'),
            region: $("#region").select2("val"),
            vmi: $('#vmi').is(':checked'),
            searchModifier:  $("#searchModifier").select2("val"),
            industry: industryValues,
            employment: $('#employment').val(),
            schedule: $('#schedule').val(),
            experience: $('#experience').val()
        };

        $.ajax({
            type: 'POST',
            url: '/handle-request',
            data: formData,
            success: function (response) {
                if (response && response.document_uuid) {
                    var redirectUrl = '/request/' + response.document_uuid;
                    window.location.href = redirectUrl;
                }
            },
            error: function (error) {
                console.error(error);

                if (error.responseJSON && error.responseJSON.error_messages) {
                    var errorContainer = $('#errorContainer');
                    var errorList = $('#errorList');
                    errorList.empty();

                    $.each(error.responseJSON.error_messages, function (index, errorMessage) {
                        errorList.append('<li>' + errorMessage + '</li>');
                    });

                    errorContainer.show();
                }
            }
        });
    });
});