<?php
// Include database connection
include('connection.php');

// Initialize an array to hold validation errors
$errors = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $organization_id = $_POST['organization_id'];
    $current_beginning_balance = $_POST['current_beginning_balance'] ?? 0; // Read-only value
    $add_amount = $_POST['add_amount'] ?? 0;
    $subtract_amount = $_POST['subtract_amount'] ?? 0;

    // Validation
    if ($add_amount < 0 && $subtract_amount < 0) {
        $errors['amount'] = 'Either Add amount or Subtract amount must be non-negative.';
    }

    // If there are validation errors, return them
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        // Fetch the current beginning balance, income, and balance for the organization
        $fetch_query = "
            SELECT 
                beginning_balance, 
                income, 
                balance, 
                expense
            FROM organizations 
            WHERE organization_id = ?";
        $fetch_stmt = $conn->prepare($fetch_query);

        if ($fetch_stmt) {
            $fetch_stmt->bind_param('i', $organization_id);
            $fetch_stmt->execute();
            $fetch_stmt->bind_result($current_beginning_balance_db, $current_income, $current_balance, $total_expenses);
            $fetch_stmt->fetch();
            $fetch_stmt->close();

            // Ensure values exist
            $current_income = $current_income ?? 0;
            $current_balance = $current_balance ?? 0;
            $total_expenses = $total_expenses ?? 0;
            $current_beginning_balance_db = $current_beginning_balance_db ?? 0;

            // Update the beginning balance with the add_amount and subtract_amount
            $new_beginning_balance = $current_beginning_balance_db + (float)$add_amount - (float)$subtract_amount;

            // Update income based on the add_amount (adding to the total income)
            $new_income = $current_income + (float)$add_amount;

            // Calculate the new balance
            $new_balance = $current_balance + (float)$add_amount - (float)$subtract_amount;

            // Ensure the balance accounts for expenses
            $adjusted_balance = $new_balance - $total_expenses;

            // Update the organization's beginning_balance, income, and balance fields
            $update_query = "UPDATE organizations SET beginning_balance = ?, income = ?, balance = ? WHERE organization_id = ?";
            $update_stmt = $conn->prepare($update_query);

            if ($update_stmt) {
                $update_stmt->bind_param('dddi', $new_beginning_balance, $new_income, $adjusted_balance, $organization_id);

                if ($update_stmt->execute()) {
                    $data['success'] = true;
                    $data['message'] = 'Beginning balance, income, and balance updated successfully!';
                } else {
                    $data['success'] = false;
                    $data['errors'] = ['database' => 'Failed to update the database.'];
                }

                $update_stmt->close();
            } else {
                $data['success'] = false;
                $data['errors'] = ['database' => 'Failed to prepare the update statement.'];
            }
        } else {
            $data['success'] = false;
            $data['errors'] = ['database' => 'Failed to prepare the fetch statement.'];
        }
    }
}

echo json_encode($data);
?>
