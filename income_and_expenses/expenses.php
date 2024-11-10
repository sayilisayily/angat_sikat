<?php
include '../connection.php';
include '../session_check.php'; 

$sql = "SELECT * FROM expenses WHERE organization_id = $organization_id"; // Adjust the organization_id as needed
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <title> Expenses Table </title>
</head>
<body>

<?php //include 'sidebar.php'; ?>

<div class="container mt-5 p-5">
    <h2 class="mb-4">Expenses 
        <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
            <i class="fa-solid fa-plus"></i> Add Expense
        </button>
    </h2>
    <table id="expensesTable" class="table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Reference</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    echo "<tr>
                            <td>{$row['category']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['reference']}</td>
                            
                            <td>
                                <button class='btn btn-primary btn-sm edit-btn' 
                                        data-bs-toggle='modal' 
                                        data-bs-target='#editExpenseModal' 
                                        data-id='{$row['expense_id']}'>
                                    <i class='fa-solid fa-pen'></i> Edit
                                </button>
                                <button class='btn btn-danger btn-sm archive-btn' 
                                        data-id='{$row['expense_id']}'>
                                    <i class='fa-solid fa-box-archive'></i> Archive
                                </button>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No expenses found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Expense Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="addExpenseForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExpenseLabel">Add New Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Category Field -->
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="activities">Activities</option>
                            <option value="purchases">Purchases</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                    
                    <!-- Title Field -->
                    <div class="form-group mt-3">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <!-- Amount Field -->
                    <div class="form-group mt-3">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                    </div>
                    
                    <!-- Reference (File Upload) Field -->
                    <div class="form-group mt-3">
                        <label for="reference">Reference (File Upload)</label>
                        <input type="file" class="form-control" id="reference" name="reference" accept=".pdf,.jpg,.png,.doc,.docx" required>
                    </div>

                    <!-- Success Message Alert -->
                    <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
                        Expense added successfully!
                    </div>  

                    <!-- Error Message Alert -->
                    <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert">
                        <ul id="errorList"></ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Expense Modal -->
<div class="modal fade" id="editExpenseModal" tabindex="-1" role="dialog" aria-labelledby="editExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editExpenseForm" action="update_expense.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editExpenseModalLabel">Edit Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editItemId" name="item_id">

                    <div class="form-group">
                        <label for="editCategory">Category</label>
                        <select class="form-control" id="editCategory" name="category" required>
                            <option value="" disabled selected>Select a category</option>
                            <option value="activities">Activities</option>
                            <option value="purchases">Purchases</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editTitle">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="editAmount">Amount</label>
                        <input type="number" class="form-control" id="editAmount" name="amount" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="editReference">Reference (Upload File)</label>
                        <input type="file" class="form-control" id="editReference" name="reference">
                    </div>

                    <!-- Success Message Alert -->
                    <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
                        Expense updated successfully!
                    </div>
                    <!-- Error Message Alert -->
                    <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert">
                        <ul id="errorList"></ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Archive Confirmation Modal -->
<div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="archiveModalLabel">Archive Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to archive this expense?
                <input type="hidden" id="archiveItemId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmArchiveBtn" class="btn btn-danger">Archive</button>
            </div>
        </div>
    </div>
</div>

<!-- BackEnd -->
<script>
    $(document).ready(function() {
    $('#expensesTable').DataTable({
        "paging": true,
        "searching": true,
        "info": true,
        "lengthChange": true,
        "pageLength": 10,
        "ordering": true,
        "order": [],
    });
});

// Handle Add Expense Form Submission
$('#addExpenseForm').on('submit', function(event) {
    event.preventDefault(); 

    $.ajax({
        url: 'add_expense.php',
        type: 'POST',
        data: $(this).serialize(), // Required for FormData
        success: function(response) {
            try {
                // Parse the JSON response (in case it's returned as a string)
                response = JSON.parse(response);
                console.log(response);

                if (response.success) {
                    // Hide any existing error messages
                    $('#errorMessage').addClass('d-none');

                    // Show success message
                    $('#successMessage').removeClass('d-none');

                    // Close the modal after a short delay
                    setTimeout(function() {
                        $('#addExpenseModal').modal('hide');

                        // Reset the form and hide the success message
                        $('#addExpenseForm')[0].reset();
                        $('#successMessage').addClass('d-none');

                        // Reload the page to reflect the new expense
                        location.reload();
                    }, 2000); // Adjust the delay as needed (2 seconds here)

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
            console.error('Error adding expense:', error);
        }
    });
});

$('.edit-btn').on('click', function() {
      var expenseId = $(this).data('id'); // Get expense_id from the button
      console.log("Selected Expense ID:", expenseId); // Log the event ID for debugging

      // Send an AJAX request to fetch the event details using the expense ID
      $.ajax({
          url: 'get_expense_details.php', // PHP file to fetch expense data
          type: 'POST',
          data: { expense_id: expenseId },
          dataType: 'json',
          success: function(response) {
              if(response.success) {
                  // Populate the form with expense data
                  $('#editExpenseId').val(response.data.expense_id);  // Hidden field for event ID
                  $('#editTitle').val(response.data.title);  
                  $('#editAmount').val(response.data.amount);
                  $('#editReference').val(response.data.reference);
                  // Show the modal
                  $('#editExpensetModal').modal('show');
              } else {
                  console.log("Error fetching data: ", response.message);
              }
          },
          error: function(xhr, status, error) {
              console.error("AJAX Error: ", error);
          }
      });
  });
 

// Handle Edit Event Form Submission
$('#editExpenseForm').on('submit', function(event) {
    event.preventDefault(); 

    $.ajax({
        url: 'update_expense.php', 
        type: 'POST',
        data: $(this).serialize(), 
        success: function(response) {
            try {
                // Parse the JSON response (ensure it's valid JSON)
                response = JSON.parse(response);
                console.log(response);

                if (response.success) {
                    // Hide any existing error messages
                    $('#errorMessage').addClass('d-none');

                    // Show success message
                    $('#successMessage').removeClass('d-none');

                    // Close the modal after a short delay
                    setTimeout(function() {
                        $('#editExpenseModal').modal('hide'); 

                        // Reset the form and hide the success message
                        $('#editExpenseForm')[0].reset();
                        $('#successMessage').addClass('d-none');
                        location.reload(); 
                    }, 2000); 
                } else {
                    // Show validation errors
                    $('#successMessage').addClass('d-none');

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
            console.error('Error updating event:', error);
            console.log(xhr.responseText);
        }
    });
});

</script>
</body>
</html>

<?php
$conn->close();
?>
