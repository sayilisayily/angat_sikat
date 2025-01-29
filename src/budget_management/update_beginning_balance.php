<?php
// Include database connection
include('connection.php');
include '../session_check.php';

// Initialize an array to hold validation errors
$errors = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $organization_id = $_POST['organization_id'];
    $current_beginning_balance = $_POST['current_beginning_balance'] ?? 0; // Read-only value
    $add_amount = floatval($_POST['add_amount'] ?? 0);
    $subtract_amount = floatval($_POST['subtract_amount'] ?? 0);
    $title = $_POST['title'];
    $created_by = $user_id;
    $reference = $_FILES['reference'] ?? null;

    // Validation: Ensure at least one of add_amount or subtract_amount is positive
    if ($add_amount < 0 || $subtract_amount < 0) {
        $errors['amount'] = 'Add amount or Subtract amount must not be negative.';
    }

    // Validate file upload
    if ($reference && $reference['error'] === UPLOAD_ERR_OK) {
        $allowed_extensions = ['pdf', 'jpg', 'png', 'docx'];
        $file_extension = strtolower(pathinfo($reference['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            $errors['reference'] = 'Only PDF, JPG, PNG, and DOCX files are allowed.';
        }
    } else {
        $errors['reference'] = 'Failed to upload the reference file.';
    }

    // If there are validation errors, return them
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
        echo json_encode($data);
        exit;
    }

    // Handle file upload
    $reference_filename = uniqid('ref_') . '.' . $file_extension;
    $upload_dir = 'uploads/references/';

    if (!move_uploaded_file($reference['tmp_name'], $upload_dir . $reference_filename)) {
        $data['success'] = false;
        $data['errors'] = ['file_upload' => 'Failed to save the reference file.'];
        echo json_encode($data);
        exit;
    }

    // Fetch current beginning balance, balance, and total expenses for the organization
    $fetch_query = "SELECT beginning_balance, balance, expense FROM organizations WHERE organization_id = ?";
    $fetch_stmt = $conn->prepare($fetch_query);

    if (!$fetch_stmt) {
        $data['success'] = false;
        $data['errors'] = ['database' => 'Failed to prepare fetch statement.'];
        echo json_encode($data);
        exit;
    }

    $fetch_stmt->bind_param('i', $organization_id);
    $fetch_stmt->execute();
    $fetch_stmt->bind_result($current_beginning_balance_db, $current_balance, $total_expenses);
    $fetch_stmt->fetch();
    $fetch_stmt->close();

    $current_beginning_balance_db = $current_beginning_balance_db ?? 0;
    $current_balance = $current_balance ?? 0;
    $total_expenses = $total_expenses ?? 0;

    // Calculate new balances
    if ($title === 'Balance from Previous Term')  {
        $new_beginning_balance = $current_beginning_balance_db + $add_amount - $subtract_amount;
        $new_balance = $current_balance + $add_amount - $subtract_amount;
        $adjusted_balance = $new_balance - $total_expenses;

        // Ensure balance does not go negative
        if ($adjusted_balance < 0) {
            $data['success'] = false;
            $data['errors'] = ['balance' => 'The resulting balance cannot be negative.'];
            echo json_encode($data);
            exit;
        }

        // Update the organization balances
        $update_query = "UPDATE organizations SET beginning_balance = ?, balance = ? WHERE organization_id = ?";
        $update_stmt = $conn->prepare($update_query);

        if (!$update_stmt) {
            $data['success'] = false;
            $data['errors'] = ['database' => 'Failed to prepare update statement.'];
            echo json_encode($data);
            exit;
        }

        $update_stmt->bind_param('ddi', $new_beginning_balance, $adjusted_balance, $organization_id);

        if (!$update_stmt->execute()) {
            $data['success'] = false;
            $data['errors'] = ['database' => 'Failed to update organization balance.'];
            echo json_encode($data);
            exit;
        }

        $update_stmt->close();
        

        // Insert into beginning_balance_history
        $insert_balance_query = "INSERT INTO beginning_balance_history (organization_id, amount, reference, created_by) VALUES (?, ?, ?, ?)";
        $insert_balance_stmt = $conn->prepare($insert_balance_query);

        if ($insert_balance_stmt) {
            $insert_balance_stmt->bind_param('idsi', $organization_id, $new_beginning_balance, $reference_filename, $created_by);
            $insert_balance_stmt->execute();
            $insert_balance_stmt->close();
        }
        
        // Insert into balance_history
        $insert_balance_history_query = "INSERT INTO balance_history (organization_id, balance, updated_at, created_by) VALUES (?, ?, NOW(), ?)";
        $insert_balance_history_stmt = $conn->prepare($insert_balance_history_query);

        if ($insert_balance_history_stmt) {
            $insert_balance_history_stmt->bind_param('idi', $organization_id, $adjusted_balance, $created_by);
            $insert_balance_history_stmt->execute();
            $insert_balance_history_stmt->close();
        }
    } else {
    // Check if a record exists in beginning_balance_summary
    $check_query = "SELECT summary_id, total_profit FROM beginning_balance_summary WHERE organization_id = ? AND title = ?";
    $stmt_check = $conn->prepare($check_query);
    $stmt_check->bind_param('is', $organization_id, $title);
    $stmt_check->execute();
    $stmt_check->bind_result($existing_summary_id, $existing_total_profit);
    $stmt_check->fetch();
    $stmt_check->close();

    // Calculate the net change for beginning balance summary
    $net_change = $add_amount - $subtract_amount;

    if ($existing_summary_id) {
        // If record exists, update the total_profit
        $update_summary_query = "UPDATE beginning_balance_summary SET total_profit = total_profit + ? WHERE summary_id = ?";
        $stmt_update = $conn->prepare($update_summary_query);
        $stmt_update->bind_param('di', $net_change, $existing_summary_id);

        if (!$stmt_update->execute()) {
            $data['success'] = false;
            $data['errors'] = ['database' => 'Failed to update beginning balance summary.'];
            echo json_encode($data);
            exit;
        }

        $stmt_update->close();
    } else {
        // Insert a new record if not found
        $insert_summary_query = "INSERT INTO beginning_balance_summary (organization_id, title, total_profit) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($insert_summary_query);
        $stmt_insert->bind_param('isd', $organization_id, $title, $net_change);

        if (!$stmt_insert->execute()) {
            $data['success'] = false;
            $data['errors'] = ['database' => 'Failed to insert beginning balance summary.'];
            echo json_encode($data);
            exit;
        }

        $stmt_insert->close();
    }
}
    $data['success'] = true;
    $data['message'] = 'Beginning balance updated successfully!';
}

echo json_encode($data);
?>
