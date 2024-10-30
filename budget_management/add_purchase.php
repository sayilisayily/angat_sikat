<?php

include 'connection.php';

$errors = [];
$data = [];

// Validate the event title (make sure it's not a duplicate)
if (empty($_POST['title'])) {
    $errors['title'] = 'Purchase title is required.';
} else {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    
    // Check if the event with the same title already exists
    $query = "SELECT * FROM purchases WHERE title = '$title'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $errors['title'] = 'An event with this title already exists.';
    }
}

// If there are no errors, proceed to insert the event
if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    // Insert purchase into database
    
    $query = "INSERT INTO purchases (title, purchase_status, completion_status, organization_id) 
              VALUES ('$title', 'Pending', 0, 1)";
    
    if (mysqli_query($conn, $query)) {
        $data['success'] = true;
        $data['message'] = 'Purchase added successfully!';
    } else {
        $data['success'] = false;
        $data['errors'] = ['database' => 'Failed to add purchase to the database.'];
    }
}

echo json_encode($data);

?>
