
$(document).ready(function () {
    // Trigger the modal opening
    $('#editBeginningBalanceModal').on('show.bs.modal', function (event) {
        var modal = $(this);
        var organization_id = modal.find('input[name="organization_id"]').val();

        // Fetch current beginning balance
        $.ajax({
            url: 'get_beginning_balance.php', // PHP script to fetch the balance
            type: 'POST',
            dataType: 'json',
            data: { organization_id: organization_id },
            success: function (response) {
                if (response.success) {
                    // Populate the input field with the current balance
                    modal.find('#beginningBalance').val(response.beginning_balance);
                } else {
                    $('#editMessage').removeClass('d-none alert-success').addClass('alert-danger').text(response.message);
                }
            },
            error: function () {
                $('#editMessage').removeClass('d-none alert-success').addClass('alert-danger').text('Error fetching beginning balance.');
            }
        });
    });

    // Submit the form via AJAX
    $('#editBeginningBalanceForm').on('submit', function (e) {
        e.preventDefault();

        var form_data = $(this).serialize();

        $.ajax({
            url: 'update_beginning_balance.php', // PHP script to update the balance
            type: 'POST',
            data: form_data,
            success: function (response) {
                // Handle success response
                $('#editMessage').removeClass('d-none alert-danger').addClass('alert-success').text('Beginning balance updated successfully.');
                // Optionally, close the modal after a short delay
                setTimeout(function() {
                    $('#editBeginningBalanceModal').modal('hide');
                    location.reload(); 
                }, 2000);
            },
            error: function () {
                // Handle error response
                $('#editMessage').removeClass('d-none alert-success').addClass('alert-danger').text('Error updating beginning balance.');
            }
        });
    });


    $('#editCashOnBankModal').on('show.bs.modal', function (event) {
        var modal = $(this);
        var organization_id = modal.find('input[name="organization_id"]').val();

        $.ajax({
            url: 'get_cash_on_bank.php',
            type: 'POST',
            dataType: 'json',
            data: { organization_id: organization_id },
            success: function (response) {
                if (response.success) {
                    modal.find('#cashOnBank').val(response.cash_on_bank);
                } else {
                    $('#editMessage').removeClass('d-none alert-success').addClass('alert-danger').text(response.message);
                }
            },
            error: function () {
                $('#editMessage').removeClass('d-none alert-success').addClass('alert-danger').text('Error fetching Cash on Bank.');
            }
        });
    });

    // Fetch and populate Cash on Hand
    $('#editCashOnHandModal').on('show.bs.modal', function (event) {
        var modal = $(this);
        var organization_id = modal.find('input[name="organization_id"]').val();

        $.ajax({
            url: 'get_cash_on_hand.php',
            type: 'POST',
            dataType: 'json',
            data: { organization_id: organization_id },
            success: function (response) {
                if (response.success) {
                    modal.find('#cashOnHand').val(response.cash_on_hand);
                } else {
                    $('#editMessage').removeClass('d-none alert-success').addClass('alert-danger').text(response.message);
                }
            },
            error: function () {
                $('#editMessage').removeClass('d-none alert-success').addClass('alert-danger').text('Error fetching Cash on Hand.');
            }
        });
    });

    // Submit Cash on Bank form
    $('#editCashOnBankForm').on('submit', function (e) {
        e.preventDefault();

        var form_data = $(this).serialize();

        $.ajax({
            url: 'update_cash_on_bank.php',
            type: 'POST',
            data: form_data,
            success: function (response) {
                $('#editMessage').removeClass('d-none alert-danger').addClass('alert-success').text('Cash on Bank updated successfully.');
                setTimeout(function() {
                    $('#editCashOnBankModal').modal('hide');
                    location.reload(); 
                }, 2000);
            },
            error: function () {
                $('#editMessage').removeClass('d-none alert-success').addClass('alert-danger').text('Error updating Cash on Bank.');
            }
        });
    });

    // Submit Cash on Hand form
    $('#editCashOnHandForm').on('submit', function (e) {
        e.preventDefault();

        var form_data = $(this).serialize();

        $.ajax({
            url: 'update_cash_on_hand.php',
            type: 'POST',
            data: form_data,
            success: function (response) {
                $('#editMessage').removeClass('d-none alert-danger').addClass('alert-success').text('Cash on Hand updated successfully.');
                setTimeout(function() {
                    $('#editCashOnHandModal').modal('hide');
                    location.reload(); 
                }, 2000);
            },
            error: function () {
                $('#editMessage').removeClass('d-none alert-success').addClass('alert-danger').text('Error updating Cash on Hand.');
            }
        });
    });

});

$(document).on('click', '.edit-btn', function() {
        var allocationId = $(this).data('id');

        // Use AJAX to get the budget allocation data
        $.ajax({
            url: 'get_budget_allocation.php',  // Modify to match your actual PHP file path
            type: 'POST',
            data: {allocation_id: allocationId},
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Populate the form fields in the modal
                    $('#allocated_budget').val(response.allocated_budget);
                    $('#allocationId').val(allocationId); // Ensure this input exists in your modal
                    
                    // Show the modal
                    $('#editBudgetModal').modal('show');
                } else {
                    alert('Failed to fetch data for editing.');
                }
            },
            error: function() {
                alert('Error occurred while fetching budget allocation data.');
            }
        });
    });
    
    $('#editBudgetForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission behavior

        var formData = $(this).serialize();

        $.ajax({
            url: 'update_budget.php', 
            type: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                $('#editMessage').removeClass('d-none alert-danger').addClass('alert-success').text('Budget Allocation updated successfully.');
                // Optionally, close the modal after a short delay
                setTimeout(function() {
                    $('#editBudgetModal').modal('hide');
                    location.reload(); 
                }, 2000);
            },
            error: function () {
                // Handle error response
                $('#editMessage').removeClass('d-none alert-success').addClass('alert-danger').text('Error updating beginning balance.');
            }
        });
    });