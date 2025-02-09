<?php
include('../connection.php');

// Initialize an array to hold validation errors
$errors = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the organization_id from POST
    $organization_id = $_POST['organization_id'];

    // Validate input
    if (empty($organization_id)) {
        $errors[] = 'Organization ID is required.';
    }

    // Check for validation errors before proceeding
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
        echo json_encode($data);
        exit;
    } else {
        // Prepare the SQL query using a prepared statement
        $query = "UPDATE organizations SET archived = 0 WHERE organization_id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters and execute the query
            $stmt->bind_param('i', $organization_id);

            if ($stmt->execute()) {
                $data['success'] = true;
                $data['message'] = 'Organization recovered successfully!';
            } else {
                $data['success'] = false;
                $data['errors'] = ['database' => 'Failed to recover organization to the database.'];
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
