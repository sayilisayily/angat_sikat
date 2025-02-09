<?php
include('../connection.php');

// Initialize an array to hold validation errors
$errors = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the adviser_id from POST
    $adviser_id = $_POST['adviser_id'];

    // Validate input
    if (empty($adviser_id)) {
        $errors[] = 'adviser ID is required.';
    }

    // Check for validation errors before proceeding
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
        echo json_encode($data);
        exit;
    } else {
        // Prepare the SQL query using a prepared statement
        $query = "UPDATE advisers SET archived = 0 WHERE adviser_id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters and execute the query
            $stmt->bind_param('i', $adviser_id);

            if ($stmt->execute()) {
                $data['success'] = true;
                $data['message'] = 'Adviser recovered successfully!';
            } else {
                $data['success'] = false;
                $data['errors'] = ['database' => 'Failed to recover adviser to the database.'];
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
