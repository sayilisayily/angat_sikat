<?php

include 'connection.php';

$errors = [];
$data = [];

// Validate the purchase title (make sure it's not empty or a duplicate)
if (empty($_POST['title'])) {
    $errors['title'] = 'Purchase title is required.';
} else {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    
    // Check if a purchase with the same title already exists
    $query = "SELECT * FROM purchases WHERE title = '$title'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $errors['database_check'] = 'Error checking for duplicate title: ' . mysqli_error($conn);
    } elseif (mysqli_num_rows($result) > 0) {
        $errors['title'] = 'A purchase with this title already exists.';
    }
}

// Validate organization_id (ensure it exists and is a valid integer)
if (empty($_POST['organization_id'])) {
    $errors['organization_id'] = 'Organization ID is required.';
} elseif (!filter_var($_POST['organization_id'], FILTER_VALIDATE_INT)) {
    $errors['organization_id'] = 'Invalid organization ID.';
} else {
    $organization_id = (int) $_POST['organization_id'];
}

// If there are errors, return them in the response
if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    // Attempt to insert the purchase if no validation errors
    $query = "INSERT INTO purchases (title, purchase_status, completion_status, organization_id) 
              VALUES ('$title', 'Pending', 0, '$organization_id')";
    
    if (mysqli_query($conn, $query)) {
        $data['success'] = true;
        $data['message'] = 'Purchase added successfully!';
    } else {
        $data['success'] = false;
        $data['errors'] = [
            'database' => 'Failed to add purchase to the database: ' . mysqli_error($conn)
        ];
    }
}

// Output the JSON-encoded response
echo json_encode($data);

?>
