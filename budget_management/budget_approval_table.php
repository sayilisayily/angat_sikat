<?php
// Include the database connection file
include 'connection.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Budget Approvals</title>
    <!--Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Selectize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>


    <div class="container mt-4 p-5">
        <h2>Budget Approvals <button type="button" class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#budgetApprovalModal"><i class="fa-solid fa-paper-plane"></i> Request Budget Approval</button></h2>

        <!-- Approval Table -->
        <table id="budgetApprovalsTable" class="table mt-4">
            <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Attachment</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Fetch data from budget_approvals table for non-admin users
            $approvalsQuery = "SELECT * FROM budget_approvals WHERE organization_id = 1 AND archived = 0"; // Hardcoded for testing
            $approvalsResult = mysqli_query($conn, $approvalsQuery);
            while ($row = mysqli_fetch_assoc($approvalsResult)) {
                ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo ucfirst($row['category']); ?></td>
                    <td><a href="uploads/<?php echo $row['attachment']; ?>" class='link-offset-2 link-underline link-underline-opacity-0' target="_blank"><?php echo $row['attachment']; ?></a></td>
                    <td>
                        <?php 
                        // Display status but don't allow editing
                        if ($row['status'] == 'Pending') {
                            echo " <span class='badge rounded-pill pending'> ";
                        } else if ($row['status'] == 'Approved') {
                            echo " <span class='badge rounded-pill approved'> ";
                        } else if ($row['status'] == 'Disapproved') {
                            echo " <span class='badge rounded-pill disapproved'> ";
                        }
                        echo ucfirst($row['status']); 
                        ?>
                    </span>
                    </td>
                    <td>
                        <!-- Non-admin users can edit other fields except status -->
                        <button class='btn btn-primary btn-sm edit-btn mb-3' 
                            data-bs-toggle='modal' 
                            data-bs-target='#editBudgetApprovalModal' 
                            data-id="<?php echo $row['approval_id']; ?>"><i class='fa-solid fa-pen'></i> Edit
                        </button>
                        <button class='btn btn-danger btn-sm archive-btn mb-3' data-id="<?php echo $row['approval_id']; ?>"><i class='fa-solid fa-trash'></i> Delete</button>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>



    <!-- Add Budget Approval Modal -->
    <div class="modal fade" id="budgetApprovalModal" tabindex="-1" aria-labelledby="budgetApprovalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="budgetApprovalModalLabel">Budget Approval Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <form id="addBudgetApprovalForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <select name="title" class="form-control" required>
                                <option value="">Select Title</option>
                                <!-- Fetch titles from events, purchases, and maintenance -->
                                <?php
                                // Fetch events
                                $event_query = "SELECT title FROM events where archived=0 and organization_id = 1";
                                $event_result = mysqli_query($conn, $event_query);
                                echo "<optgroup label='Events'>";
                                while ($row = mysqli_fetch_assoc($event_result)) {
                                    echo "<option value='" . $row['title'] . "'>" . $row['title'] . "</option>";
                                }
                                echo "</optgroup>";

                                // Fetch purchases
                                $purchase_query = "SELECT title FROM purchases";
                                $purchase_result = mysqli_query($conn, $purchase_query);
                                echo "<optgroup label='Purchases'>";
                                while ($row = mysqli_fetch_assoc($purchase_result)) {
                                    echo "<option value='" . $row['title'] . "'>" . $row['title'] . " </option>";
                                }
                                echo "</optgroup>";

                                // Fetch maintenance
                                $maintenance_query = "SELECT title FROM maintenance";
                                $maintenance_result = mysqli_query($conn, $maintenance_query);
                                while ($row = mysqli_fetch_assoc($maintenance_result)) {
                                    echo "<option value='" . $row['title'] . "'>" . $row['title'] . " (Maintenance)</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="attachment" class="form-label">Attachment:</label>
                            <input type="file" name="attachment" id="attachment" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <!-- Success Message Alert -->
                    <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
                            Event added successfully!
                    </div>  
                    <!-- Error Message Alert -->
                    <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert">
                        <ul id="errorList"></ul> <!-- List for showing validation errors -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Approval Modal -->
    <div class="modal fade" id="editBudgetApprovalModal" tabindex="-1" aria-labelledby="editBudgetApprovalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBudgetApprovalModalLabel">Edit Budget Approval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    
                    <form id="editBudgetApprovalForm" enctype="multipart/form-data">
                        <input type="hidden" name="approval_id" id="editApprovalId">
                        
                        <div class="form-group">
                            <label for="editTitle">Title</label>
                            <select name="title" class="form-control" id="editTitle" required>
                                <option value="">Select Title</option>
                                <!-- Fetch titles from events, purchases, and maintenance -->
                                <?php
                                // Fetch events
                                $event_query = "SELECT title FROM events where archived=0 and organization_id = 1";
                                $event_result = mysqli_query($conn, $event_query);
                                echo "<optgroup label='Events'>";
                                while ($row = mysqli_fetch_assoc($event_result)) {
                                    echo "<option value='" . $row['title'] . "'>" . $row['title'] . "</option>";
                                }
                                echo "</optgroup>";

                                // Fetch purchases
                                $purchase_query = "SELECT title FROM purchases";
                                $purchase_result = mysqli_query($conn, $purchase_query);
                                echo "<optgroup label='Purchases'>";
                                while ($row = mysqli_fetch_assoc($purchase_result)) {
                                    echo "<option value='" . $row['title'] . "'>" . $row['title'] . "</option>";
                                }
                                echo "</optgroup>";

                                // Fetch maintenance
                                $maintenance_query = "SELECT title FROM maintenance";
                                $maintenance_result = mysqli_query($conn, $maintenance_query);
                                while ($row = mysqli_fetch_assoc($maintenance_result)) {
                                    echo "<option value='" . $row['title'] . "'>" . $row['title'] . " (Maintenance)</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editAttachment" class="form-label">Attachment:</label>
                            <input type="file" name="attachment" id="editAttachment" class="form-control">
                            <div id="currentAttachment" class="mt-2"></div> <!-- Display current file -->
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>

                    <div id="editMessage" class="alert d-none"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Archive Confirmation Modal -->
    <div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="archiveModalLabel">Confirm Archive</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Are you sure you want to archive this budget approval?
            <input type="hidden" id="archiveBudgetApprovalId" value=""> <!-- Hidden input to store the ID -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmArchiveBtn">Archive</button>
        </div>
        </div>
    </div>
    </div>


<script>
    $(document).ready(function() {
        $('#budgetApprovalsTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "ordering": true,
            "order": [],
        });
    });

    // Add Budget Approval Form Submission via AJAX
    $('#addBudgetApprovalForm').on('submit', function(e) {
        e.preventDefault();

        // Create FormData object to include file uploads
        let formData = new FormData(this);

        $.ajax({
            url: 'budget_approval.php', // Add form submission PHP file
            type: 'POST',
            data: formData, // Use formData object
            contentType: false, // Important for file upload
            processData: false, // Important for file upload
            success: function(response) {
                try {
                    response = JSON.parse(response);
                    if (response.success) {
                        // Hide any existing error messages
                        $('#errorMessage').addClass('d-none');

                        // Show success message
                        $('#successMessage').removeClass('d-none');

                        setTimeout(function() {
                            $('#budgetApprovalModal').modal('hide'); // Hide modal after success

                            // Reset the form and hide the success message
                            $('#addBudgetApprovalForm')[0].reset();
                            $('#successMessage').addClass('d-none');

                            location.reload(); 
                        }, 2000); // Reload after 2 seconds
                    } else {
                        // Hide any existing success messages
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
                console.error('Error adding event:', error);
            }
        });
    });


    $(document).on('click', '.edit-btn', function() {
        var approvalId = $(this).data('id');

        // Use AJAX to get the budget approval data
        $.ajax({
            url: 'get_budget_approval.php',  // Modify to match your actual PHP file path
            type: 'POST',
            data: {approval_id: approvalId},
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Populate the form fields in the modal
                    $('#editApprovalId').val(approvalId);
                    $('#editTitle').val(response.title);
                    $('#currentAttachment').html('<strong>Current Attachment:</strong> ' + response.attachment);
                    
                    // Show the modal
                    $('#editBudgetApprovalModal').modal('show');
                } else {
                    alert('Failed to fetch data for editing.');
                }
            },
            error: function() {
                alert('Error occurred while fetching budget approval data.');
            }
        });
    });

    $('#editBudgetApprovalForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: 'update_budget_approval.php', // Edit form submission PHP file
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    $('#editMessage').removeClass('d-none alert-danger').addClass('alert-success').text(result.message);
                    setTimeout(function() {
                        $('#editBudgetApprovalModal').modal('hide'); // Hide modal after success
                        location.reload(); // Reload the page
                    }, 2000); // Reload after 2 seconds
                } else {
                    $('#editMessage').removeClass('d-none alert-success').addClass('alert-danger').text(result.message);
                }
            },
            error: function() {
                $('#editMessage').removeClass('d-none alert-success').addClass('alert-danger').text('Error submitting form.');
            }
        });
    });

    // Event delegation for dynamically loaded archive buttons (for budget approval)
    $(document).on('click', '.archive-btn', function() {
        var budgetApprovalId = $(this).data('id'); // Get the budget approval ID from the button
        $('#archiveBudgetApprovalId').val(budgetApprovalId); // Store the ID in the hidden input field
        $('#archiveModal').modal('show'); // Show the archive confirmation modal
    });

    // Handle archive confirmation when the "Archive" button in modal is clicked
    $('#confirmArchiveBtn').on('click', function() {
        var budgetApprovalId = $('#archiveBudgetApprovalId').val(); // Get the budget approval ID from the hidden input field
        
        // Send an AJAX request to archive the budget approval
        $.ajax({
            url: 'archive_budget_approval.php', // PHP file to handle archiving
            type: 'POST',
            data: { id: budgetApprovalId }, // Send the budget approval ID
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Optionally show a success message
                    //alert(response.message);

                    // Reload the page or DataTable to reflect the changes (replace with your method)
                    location.reload(); // Reload the page (or update the table dynamically)
                } else {
                    // Show an error message if something goes wrong
                    alert("Error archiving budget approval: " + response.message);
                }

                // Close the modal after archiving
                $('#archiveModal').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error);
            }
        });
    });

    $(document).ready(function () {
            // Toggle the sidebar using the bars icon
            $('#sidebarToggle').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
                $(this).toggleClass('active');
            });
        });
</script>
</body>
</html>
