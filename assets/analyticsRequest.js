import $ from 'jquery';

$(document).ready(function() {
    console.log('AUE');

    $(document).ready(function() {
        $('#searchModifier').select2({
            width: '100%',
            placeholder: 'Выберите модификатор поиска',
            allowClear: true,
            closeOnSelect: false,
            theme: "bootstrap-5"
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

        $('#industry').select2({
            width: '100%',
            placeholder: 'Выберите индустрию',
            allowClear: true,
            closeOnSelect: false,
            theme: "bootstrap-5"
        });


        $('#submitBtn').on('click', function(event) {
            event.preventDefault();

            var formData = {
                searchText: $('#searchField').val(),
                hasSalary: $('#hasSalary').is(':checked'),
                qualificationLevel: $('#qualificationLevel').val(),
                region: $("#region").select2("val"),
                hasVmi: $('#vmi').is(':checked'),
                searchModifier:  $("#searchModifier").select2("val"),
                industry: $('#industry').val(),
                employment: $('#employment').val(),
                schedule: $('#schedule').val(),
                experience: $('#experience').val()
            };

            $.ajax({
                type: 'POST',
                url: '/handle-request',
                data: formData,
                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });
    });
});