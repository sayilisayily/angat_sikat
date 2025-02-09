<?php
include('../connection.php');

// Initialize an array to hold validation errors
$errors = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user_id from POST
    $user_id = $_POST['user_id'];

    // Validate input
    if (empty($user_id)) {
        $errors[] = 'User ID is required.';
    }

    // Check for validation errors before proceeding
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
        echo json_encode($data);
        exit;
    } else {
        // Prepare the SQL query using a prepared statement
        $query = "UPDATE users SET archived = 0 WHERE user_id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters and execute the query
            $stmt->bind_param('i', $user_id);

            if ($stmt->execute()) {
                $data['success'] = true;
                $data['message'] = 'User recovered successfully!';
            } else {
                $data['success'] = false;
                $data['errors'] = ['database' => 'Failed to recover user to the database.'];
            }

            $stmt->close();
        } else {
            $data['success'] = false;
            $data['errors'] = ['database' => 'Failed to prepare the recover statement.'];
        }
    }
}

// Output the JSON response
echo json_encode($data);
?>
