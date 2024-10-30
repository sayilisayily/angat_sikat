<?php

include 'connection.php';

$errors = [];
$data = [];

// Validate the event title (make sure it's not a duplicate)
if (empty($_POST['title'])) {
    $errors['title'] = 'Event title is required.';
} else {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    
    // Check if the event with the same title already exists
    $query = "SELECT * FROM events WHERE title = '$title'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $errors['title'] = 'An event with this title already exists.';
    }
}

// Validate other fields
if (empty($_POST['venue'])) {
    $errors['venue'] = 'Event venue is required.';
}

if (empty($_POST['start_date'])) {
    $errors['start_date'] = 'Event start date is required.';
}

if (empty($_POST['end_date'])) {
    $errors['end_date'] = 'Event end date is required.';
}

// If there are no errors, proceed to insert the event
if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    // Insert event into database
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    
    $query = "INSERT INTO events (title, event_venue, event_start_date, event_end_date, event_type, event_status, accomplishment_status, organization_id) 
              VALUES ('$title', '$venue', '$start_date', '$end_date', '$type', 'Pending', 0, 1)";
    
    if (mysqli_query($conn, $query)) {
        $data['success'] = true;
        $data['message'] = 'Event added successfully!';
    } else {
        $data['success'] = false;
        $data['errors'] = ['database' => 'Failed to add event to the database.'];
    }
}

echo json_encode($data);

?>
