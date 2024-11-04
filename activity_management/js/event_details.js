$(document).ready(function () {
    //Submit Add Item Form
    $('#addItemForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting in the traditional way

            $.ajax({
                url: 'add_item.php', // The PHP file that processes adding the item
                type: 'POST',
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    try {
                        // Parse the JSON response
                        response = JSON.parse(response);

                        if (response.success) {
                            // Hide any error messages
                            $('#errorMessage').addClass('d-none');

                            // Show success message
                            $('#successMessage').removeClass('d-none');

                            // Close the modal after a short delay
                            setTimeout(function() {
                                $('#addItemModal').modal('hide');

                                // Reset the form and hide the success message
                                $('#addItemForm')[0].reset();
                                $('#successMessage').addClass('d-none');

                                // Reload the page to reflect the new item
                                location.reload();
                            }, 2000); // Adjust the delay as needed
                        } else {
                            // Hide any success messages
                            $('#successMessage').addClass('d-none');

                            // Show error messages
                            $('#errorMessage').removeClass('d-none');
                            let errorHtml = '';
                            for (let field in response.errors) {
                                errorHtml += `<li>${response.errors[field]}</li>`;
                            }
                            $('#errorList').html(errorHtml);
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error adding item:', error);
                }
            });
        });
    });
    // Fetch and populate Edit Item Modal
    $('.edit-btn').on('click', function() {
        var itemId = $(this).data('id'); // Corrected to retrieve item_id from the button
        console.log("Selected Item ID:", itemId); // Log the item ID for debugging

        $.ajax({
            url: 'get_item_details.php', // Your PHP script for fetching the item details
            type: 'POST',
            data: {item_id: itemId},
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.success) {
                    // Populate the modal fields with the item data
                    $('#edit_item_id').val(response.data.item_id);
                    $('#edit_description').val(response.data.description);
                    $('#edit_quantity').val(response.data.quantity);
                    $('#edit_unit').val(response.data.unit);
                    $('#edit_amount').val(response.data.amount);

                    // Show the modal
                    $('#editItemModal').modal('show');
                } else {
                    // Display an error message if fetching failed
                    console.log("Error fetching data: ", response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", error);
                console.log("Status:", status);
                console.log("Response Text:", xhr.responseText); // Log full response for debugging
            }
        });
    });


        // Handle form submission for updating the item
        $('#editItemForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'update_item.php', // URL of your PHP script for updating the item
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Parse the JSON response
                    var result = JSON.parse(response);
                    console.log(response);

                    if (result.success) {
                        // Hide any existing error messages
                        $('#errorMessage').addClass('d-none');

                        // Show success message
                        $('#successMessage').removeClass('d-none');
                        
                        setTimeout(function() {
                            $('#editItemModal').modal('hide');

                            // Reset the form and hide the success message
                            $('#editItemForm')[0].reset();
                            $('#successMessage').addClass('d-none');
                            location.reload();
                        }, 2000); 
                    } else {
                        // Show validation errors
                        $('#editsuccessMessage').addClass('d-none');

                        $('#errorMessage').removeClass('d-none');
                        let errorHtml = '';
                        for (let field in response.errors) {
                            errorHtml += `<li>${response.errors[field]}</li>`;
                        }
                        $('#errorList').html(errorHtml);
                    }
                },
                error: function() {
                    console.error('Error updating event:', error);
                }
            });
        });

        // Pass data to Delete Modal
        $('#deleteItemModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var itemId = button.data('id');
            var eventId = button.data('event-id'); // Get the event_id

            // Update the modal's field
            var modal = $(this);
            modal.find('#delete_item_id').val(itemId);
            modal.find('#delete_event_id').val(eventId); // Pass event_id to the form if needed
        });