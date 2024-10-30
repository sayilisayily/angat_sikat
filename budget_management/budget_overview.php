<?php
// Include the database connection file
include 'connection.php';

// Fetch organization data
$organization_id = 1; // Set this dynamically based on user session or login
$query = "SELECT 
            beginning_balance,
            cash_on_bank,
            cash_on_hand,
            balance
          FROM 
            organizations 
          WHERE 
            organization_id = $organization_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

$beginning_balance = $row['beginning_balance'];
$cash_on_bank = $row['cash_on_bank'];
$cash_on_hand = $row['cash_on_hand'];
$balance = $row['balance']; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Management</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Custom Css -->
    <link rel="stylesheet" href="css/styles.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../sidebar.js"></script>
</head>
<body>

<?php //include '../sidebar.php'; ?>

<div class="container mt-5">
    
    <h2 class="mb-3"> Budget Management </h2>
    <!-- Balance Card -->
    <div class="row">
        <div class="col-md">
            <div class="card text-white gradient-card mb-3 py-4">
                <div class="card-header">Balance</div>
                <div class="card-body">
                    <h3 class="card-title">₱<?php echo number_format($balance, 2); ?></h3>
                </div>
            </div>
        </div>      
    </div>
    <div class="row">

        <!-- Beginning Balance Card -->
        <div class="col-md-4">
            <div class="card gradient-card-2 text-white mb-3 py-4">
                <div class="card-body">
                    <h5 class="card-title">₱<?php echo number_format($beginning_balance, 2); ?></h5>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span>Beginning Balance</span>
                    <button class="btn btn-light edit-balance-btn" data-bs-toggle="modal" data-bs-target="#editBeginningBalanceModal" data-id="<?php echo $organization_id; ?>"><i class="fa-solid fa-pen"></i> Edit</button>
                </div>
            </div>
        </div>

        <!-- Cash on Bank Card -->
        <div class="col-md-4">
            <div class="card text-white gradient-card-3 mb-3 py-4">
                <div class="card-body">
                    <h5 class="card-title">₱<?php echo number_format($cash_on_bank, 2); ?></h5>   
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span>Cash on Bank</span>
                    <button class="btn btn-light edit-balance-btn" data-bs-toggle="modal" data-bs-target="#editCashOnBankModal" data-id="<?php echo $organization_id; ?>"><i class="fa-solid fa-pen"></i> Edit</button>
                </div>
            </div>
        </div>


        <!-- Cash on Hand Card -->
        <div class="col-md-4">
            <div class="card text-white gradient-card-1 mb-3 py-4">
                <div class="card-body">
                    <h5 class="card-title">₱<?php echo number_format($cash_on_hand, 2); ?></h5>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span>Cash on Hand</span>
                    <button class="btn btn-light edit-balance-btn" data-bs-toggle="modal" data-bs-target="#editCashOnHandModal" data-id="<?php echo $organization_id; ?>"><i class="fa-solid fa-pen"></i> Edit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <h4 class="col"><div class="vr"></div> Budget Allocation </h4>
        <h4 class="col"> Budget Status </h4>
    </div>
    <div class="row">
        
        <div id="budgetStructure" class="col" style="width: 500px; height: 350px;"></div>   
        <div id="budgetStatus" class="col" style="width: 500px; height: 350px;"></div>
    </div>

    <div class="tablecontainer mt-3 p-4">
        <h4 class="mb-4"> Budget Allocation </h4>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>Category</th>
                    <th>Allocated Budget</th>
                    <th>Total Spent</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM budget_allocation";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                }

                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td>₱<?php echo number_format($row['allocated_budget'], 2); ?></td>
                        <td>₱<?php echo number_format($row['total_spent'], 2); ?></td>
                        <td>
                            <button class="btn btn-primary edit-btn" 
                                    data-id="<?php echo $row['allocation_id']; ?>" 
                                    data-bs-toggle="modal" data-bs-target="#editBudgetModal"><i class="fa-solid fa-pen"></i> Edit</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Modals -->
<!-- Edit Beginning Balance Modal -->
<div class="modal fade" id="editBeginningBalanceModal" tabindex="-1" aria-labelledby="editBeginningBalanceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBeginningBalanceLabel">Edit Beginning Balance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBeginningBalanceForm">
                    <div class="mb-3">
                        <label for="beginningBalance" class="form-label">Beginning Balance</label>
                        <input type="number" step="0.01" class="form-control" id="beginningBalance" name="beginning_balance" required>
                    </div>
                    <input type="hidden" name="organization_id" value="<?php echo $organization_id; ?>">
                </form>
            </div>
            <div id="editMessage" class="alert d-none" role="alert"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="editBeginningBalanceForm" class="btn btn-primary">Save changes</button>
            </div>
            
        </div>
    </div>
</div>

<!-- Edit Cash on Bank Modal -->
<div class="modal fade" id="editCashOnBankModal" tabindex="-1" aria-labelledby="editCashOnBankLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCashOnBankLabel">Edit Cash on Bank</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCashOnBankForm">
                    <div class="mb-3">
                        <label for="cashOnBank" class="form-label">Cash on Bank</label>
                        <input type="number" step="0.01" class="form-control" id="cashOnBank" name="cash_on_bank" required>
                    </div>
                    <input type="hidden" name="organization_id" value="<?php echo $organization_id; ?>">
                </form>
            </div>
            <div id="editMessage" class="alert d-none" role="alert"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="editCashOnBankForm" class="btn btn-primary">Save changes</button>
            </div>
            
        </div>
    </div>
</div>

<!-- Edit Cash on Hand Modal -->
<div class="modal fade" id="editCashOnHandModal" tabindex="-1" aria-labelledby="editCashOnHandLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCashOnHandLabel">Edit Cash on Hand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCashOnHandForm">
                    <div class="mb-3">
                        <label for="cashOnHand" class="form-label">Cash on Hand</label>
                        <input type="number" step="0.01" class="form-control" id="cashOnHand" name="cash_on_hand" required>
                    </div>
                    <input type="hidden" name="organization_id" value="<?php echo $organization_id; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="editCashOnHandForm" class="btn btn-primary">Save changes</button>
            </div>
            <div id="editMessage" class="alert d-none" role="alert"></div>
        </div>
    </div>
</div>

<!-- Edit Budget Modal -->
<div class="modal fade" id="editBudgetModal" tabindex="-1" aria-labelledby="editBudgetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBudgetModalLabel">Edit Budget</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBudgetForm">
                    <input type="hidden" id="allocationId" name="allocation_id"> <!-- Hidden input for allocation ID -->
                    <div class="mb-3">
                        <label for="allocated_budget" class="form-label">Allocated Budget</label>
                        <input type="number" class="form-control" id="allocated_budget" name="allocated_budget" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="editBudgetForm" class="btn btn-primary">Save changes</button>
            </div>
            <div id="editMessage" class="alert d-none" role="alert"></div>
        </div>
    </div>
</div>

<script>

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
            url: 'update_balance.php',
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
            url: 'update_balance.php',
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
</script>

<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Prepare the data directly from the PHP code
        var data = google.visualization.arrayToDataTable([
            ['Category', 'Amount'],
            <?php

                // Fetch budget allocation data from the database
                $query = "SELECT category, allocated_budget FROM budget_allocation";
                $result = mysqli_query($conn, $query);

                // Loop through the results and output them as JavaScript array elements
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "['" . $row['category'] . "', " . (float)$row['allocated_budget'] . "],";
                }
            ?>
        ]);

        var options = {
            pieHole: 0.6,
            colors: ['#FFDB29', '#5BD2DA', '#595FD7']
        };

        var chart = new google.visualization.PieChart(document.getElementById('budgetStructure'));
        chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Prepare the data directly from the PHP code
        var data = google.visualization.arrayToDataTable([
            ['Category', 'Amount'],
            <?php
                // Fetch balance and total expense data from the database
                $query = "SELECT balance FROM organizations WHERE organization_id = $organization_id"; // Fetch only balance
                $result = mysqli_query($conn, $query);

                // Fetch the balance
                if ($row = mysqli_fetch_assoc($result)) {
                    echo "['Balance', " . (float)$row['balance'] . "],";
                }

                // Now fetch total expenses from the expenses table
                $expenses_query = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE organization_id = $organization_id";
                $expenses_result = mysqli_query($conn, $expenses_query);

                // Fetch the total expenses
                if ($expenses_row = $expenses_result->fetch_assoc()) {
                    echo "['Expense', " . (float)$expenses_row['total_expenses'] . "],";
                }
            ?>
        ]);


        var options = {
            pieHole: 0.6,
            colors: ['#E6E6E6', '#FF7575'],
        };

        var chart = new google.visualization.PieChart(document.getElementById('budgetStatus'));
        chart.draw(data, options);
    }
</script>

</body>
</html>
