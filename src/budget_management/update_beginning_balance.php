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
    $add_amount = $_POST['add_amount'] ?? 0;
    $subtract_amount = $_POST['subtract_amount'] ?? 0;
    $reference = $_FILES['reference'];

    // Validation
    if ($add_amount < 0 && $subtract_amount < 0) {
        $errors['amount'] = 'Add amount or Subtract amount must not be negative.';
    }

    // File upload validation
    if ($reference['error'] !== UPLOAD_ERR_OK) {
        $errors['reference'] = 'Failed to upload the reference file.';
    } else {
        $allowed_extensions = ['pdf', 'jpg', 'png', 'docx'];
        $file_extension = pathinfo($reference['name'], PATHINFO_EXTENSION);

        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
            $errors['reference'] = 'Only PDF, JPG, PNG, and DOCX files are allowed.';
        }
    }

    // If there are validation errors, return them
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        // Handle file upload
        $reference_filename = uniqid('ref_') . '.' . $file_extension;
        $upload_dir = 'uploads/references/';

        if (!move_uploaded_file($reference['tmp_name'], $upload_dir . $reference_filename)) {
            $data['success'] = false;
            $data['errors'] = ['file_upload' => 'Failed to save the reference file.'];
            echo json_encode($data);
            exit;
        }

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

            $current_income = $current_income ?? 0;
            $current_balance = $current_balance ?? 0;
            $total_expenses = $total_expenses ?? 0;
            $current_beginning_balance_db = $current_beginning_balance_db ?? 0;

            $new_beginning_balance = $current_beginning_balance_db + (float)$add_amount - (float)$subtract_amount;
            $new_income = $current_income + (float)$add_amount - (float)$subtract_amount;
            $new_balance = $current_balance + (float)$add_amount - (float)$subtract_amount;
            $adjusted_balance = $new_balance - $total_expenses;

            if ($adjusted_balance < 0) {
                $errors['balance'] = 'The resulting balance cannot be negative.';
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {
                $update_query = "UPDATE organizations SET beginning_balance = ?, income = ?, balance = ? WHERE organization_id = ?";
                $update_stmt = $conn->prepare($update_query);

                if ($update_stmt) {
                    $update_stmt->bind_param('dddi', $new_beginning_balance, $new_income, $adjusted_balance, $organization_id);

                    if ($update_stmt->execute()) {
                        // Insert into beginning_balance_history
                        $insert_balance_query = "
                            INSERT INTO beginning_balance_history (organization_id, amount, reference, created_by) 
                            VALUES (?, ?, ?, ?)";
                        $insert_balance_stmt = $conn->prepare($insert_balance_query);

                        if ($insert_balance_stmt) {
                            $created_by = $user_id; // Assuming user_id from session
                            $insert_balance_stmt->bind_param('idis', $organization_id, $new_beginning_balance, $reference_filename, $created_by);
                            $insert_balance_stmt->execute();
                            $insert_balance_stmt->close();
                        }

                        // Insert into balance_history
                        $insert_balance_history_query = "
                            INSERT INTO balance_history (organization_id, balance, updated_at, created_by) 
                            VALUES (?, ?, NOW(), ?)";
                        $insert_balance_history_stmt = $conn->prepare($insert_balance_history_query);

                        if ($insert_balance_history_stmt) {
                            $insert_balance_history_stmt->bind_param('idi', $organization_id, $adjusted_balance, $created_by);
                            $insert_balance_history_stmt->execute();
                            $insert_balance_history_stmt->close();
                        }

                        // Insert into income_history
                        $insert_income_history_query = "
                            INSERT INTO income_history (organization_id, income, updated_at, created_by) 
                            VALUES (?, ?, NOW(), ?)";
                        $insert_income_history_stmt = $conn->prepare($insert_income_history_query);

                        if ($insert_income_history_stmt) {
                            $insert_income_history_stmt->bind_param('idi', $organization_id, $new_income, $created_by);
                            $insert_income_history_stmt->execute();
                            $insert_income_history_stmt->close();
                        }

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
            }
        } else {
            $data['success'] = false;
            $data['errors'] = ['database' => 'Failed to prepare the fetch statement.'];
        }
    }
}

echo json_encode($data);
?>
