import $ from 'jquery';

$(document).ready(function() {
    console.log('AUE');

    $(document).ready(function() {
        $('#searchModifier').select2({
            width: '100%', // Adjust the width as needed
            placeholder: 'Select search modifier', // Optional placeholder text
            allowClear: true, // Enable clearing selected options
            closeOnSelect: false,
            theme: "bootstrap-5"
        });
    });

    $('#submitBtn').on('click', function() {
        var formData = $('#jobSearchForm').serialize();

        $.ajax({
            type: 'POST',
            url: '/your-api-endpoint', // Replace with your actual API endpoint
            data: formData,
            success: function(response) {
                // Handle success response
                console.log(response);
            },
            error: function(error) {
                // Handle error response
                console.error(error);
            }
        });
    });
});