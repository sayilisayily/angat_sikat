<?php
// Include database connection
include('connection.php');
include '../session_check.php';

// Initialize an array to hold validation errors
$errors = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate organization ID
    if (!isset($_POST['organization_id']) || !is_numeric($_POST['organization_id'])) {
        $errors['organization_id'] = 'Invalid organization ID.';
    }

    // Validate Add and Subtract inputs
    $add_cash_on_hand = isset($_POST['add_cash_on_hand']) ? (float)$_POST['add_cash_on_hand'] : 0;
    $subtract_cash_on_hand = isset($_POST['subtract_cash_on_hand']) ? (float)$_POST['subtract_cash_on_hand'] : 0;

    // Ensure at least one field (add or subtract) is provided
    if ($add_cash_on_hand === 0 && $subtract_cash_on_hand === 0) {
        $errors['cash_on_hand'] = 'Please enter an amount to add or subtract.';
    }

    // Validate file upload (reference)
    if (isset($_FILES['reference']) && $_FILES['reference']['error'] === UPLOAD_ERR_OK) {
        $uploaded_file_path = 'uploads/references' . basename($_FILES['reference']['name']);
        move_uploaded_file($_FILES['reference']['tmp_name'], $uploaded_file_path);
    } else {
        $errors['reference'] = 'File upload failed or not provided.';
    }

    // If there are validation errors, return early
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
        echo json_encode($data);
        exit;
    }

    // Sanitize and assign variables
    $organization_id = (int)$_POST['organization_id'];
    $reference = $uploaded_file_path; // File path for reference
    $created_by = $user_id;

    // Fetch current cash_on_hand, cash_on_bank, and balance from the database
    $fetch_query = "SELECT cash_on_hand, cash_on_bank, balance FROM organizations WHERE organization_id = ?";
    $fetch_stmt = $conn->prepare($fetch_query);

    if ($fetch_stmt) {
        $fetch_stmt->bind_param('i', $organization_id);
        $fetch_stmt->execute();
        $fetch_stmt->bind_result($current_cash_on_hand, $cash_on_bank, $balance);
        $fetch_stmt->fetch();
        $fetch_stmt->close();

        // Calculate the new cash_on_hand value
        $new_cash_on_hand = $current_cash_on_hand + $add_cash_on_hand - $subtract_cash_on_hand;

        // Check if the new cash_on_hand plus cash_on_bank exceeds the balance
        if (($new_cash_on_hand + $cash_on_bank) > $balance) {
            $errors['cash_on_hand'] = 'The total of Cash on Hand and Cash on Bank cannot exceed the Balance.';
            $data['success'] = false;
            $data['errors'] = $errors;
        } elseif ($new_cash_on_hand < 0) {
            $errors['cash_on_hand'] = 'Cash on Hand cannot be negative.';
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {
            // Proceed with the update if validations pass
            $update_query = "UPDATE organizations SET cash_on_hand = ? WHERE organization_id = ?";
            $update_stmt = $conn->prepare($update_query);

            if ($update_stmt) {
                $update_stmt->bind_param('di', $new_cash_on_hand, $organization_id);

                if ($update_stmt->execute()) {
                    // Log the transaction in cash_on_hand_history table
                    $history_query = "INSERT INTO cash_on_hand_history (organization_id, amount, reference, updated_at, created_by) VALUES (?, ?, ?, NOW(), ?)";
                    $history_stmt = $conn->prepare($history_query);

                    if ($history_stmt) {
                        $amount = $add_cash_on_hand - $subtract_cash_on_hand; // Net change in cash_on_hand
                        $history_stmt->bind_param('idss', $organization_id, $amount, $reference, $created_by);

                        if ($history_stmt->execute()) {
                            $data['success'] = true;
                            $data['message'] = 'Cash on Hand updated successfully, and transaction logged!';
                        } else {
                            $data['success'] = false;
                            $data['errors'] = ['database' => 'Failed to log transaction in history table.'];
                        }

                        $history_stmt->close();
                    } else {
                        $data['success'] = false;
                        $data['errors'] = ['database' => 'Failed to prepare the insert statement for history table.'];
                    }
                } else {
                    $data['success'] = false;
                    $data['errors'] = ['database' => 'Failed to update Cash on Hand in the database.'];
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

// Output the result in JSON format
echo json_encode($data);
?>
