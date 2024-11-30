$(document).ready(function() {
    $('#pick_location_id').change(function() {
        let pickLocationId = $(this).val();
        let dropLocationSelect = $('#drop_location_id');
        let findButton = $('input[type="submit"]'); // Assuming the submit button is the "Find" button

        // Disable the Find button while making the AJAX request
        findButton.prop('disabled', true).val('Loading...');

        $.ajax({
            url: '{{ route('get.drop.locations') }}',
            method: 'GET',
            data: { pick_location_id: pickLocationId },
            success: function(response) {
                dropLocationSelect.empty(); // Clear existing options
                
                if (response.length > 0) {
                    dropLocationSelect.prop('disabled', false); // Enable dropdown
                    $.each(response, function(index, address) {
                        dropLocationSelect.append(new Option(address.title, address.id));
                    });
                } else {
                    dropLocationSelect.prop('disabled', true); // Disable dropdown
                    dropLocationSelect.append(new Option('No locations available', ''));
                }
            },
            error: function(xhr) {
                console.error('Error fetching drop locations:', xhr);
                alert('An error occurred while fetching drop locations. Please try again later.');
                dropLocationSelect.prop('disabled', true); // Disable dropdown on error
            },
            complete: function() {
                // Re-enable the Find button after the AJAX request completes
                findButton.prop('disabled', false).val('Find');
            }
        });
    });
});