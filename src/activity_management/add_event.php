<?php

include 'connection.php';
include '../session_check.php';  // Assuming session_check.php sets the organization_id in the session

$errors = [];
$data = [];

// Validate and sanitize inputs
$title = isset($_POST['title']) ? mysqli_real_escape_string($conn, $_POST['title']) : null;
$plan_id = isset($_POST['plan_id']) ? mysqli_real_escape_string($conn, $_POST['plan_id']) : null;
$venue = isset($_POST['venue']) ? mysqli_real_escape_string($conn, $_POST['venue']) : null;
$start_date = isset($_POST['start_date']) ? mysqli_real_escape_string($conn, $_POST['start_date']) : null;
$end_date = isset($_POST['end_date']) ? mysqli_real_escape_string($conn, $_POST['end_date']) : null;
$type = isset($_POST['type']) ? mysqli_real_escape_string($conn, $_POST['type']) : null;
// Validate the event title
if (empty($title)) {
    $errors['title'] = 'Event title is required.';
} else {
    // Check if the event with the same title already exists for the organization
    $query = "SELECT * FROM events WHERE title = '$title' AND organization_id = $organization_id";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $errors['title'] = 'An event with this title already exists.';
    }
}

// Validate the plan_id
if (empty($plan_id)) {
    $errors['plan_id'] = 'Event plan_id is required.';
} else {
    // Check if the event with the same plan_id already exists for the organization
    $query = "SELECT * FROM events WHERE plan_id = '$plan_id' AND organization_id = $organization_id";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $errors['plan_id'] = 'Event already exists for this plan_id.';
    }
}

// Validate other fields
if (empty($venue)) {
    $errors['venue'] = 'Event venue is required.';
}

if (empty($start_date)) {
    $errors['start_date'] = 'Event start date is required.';
}

if (empty($end_date)) {
    $errors['end_date'] = 'Event end date is required.';
}

if (!empty($start_date) && !empty($end_date) && (strtotime($start_date) > strtotime($end_date))) {
    $errors['date'] = 'Invalid event start and end date.';
}

// Check for duplicate event start date and venue where status = Approved
if (empty($errors)) {
    $check_query = "SELECT * FROM events 
                    WHERE event_start_date = '$start_date' 
                      AND event_venue = '$venue' 
                      AND event_status = 'Approved'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $errors['conflict'] = 'An event with the same date and venue already exists and is approved.';
    }
}

// If there are no errors, proceed to insert the event
if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    // Insert event into database
    $query = "INSERT INTO events (title, plan_id, event_venue, event_start_date, event_end_date, event_type, event_status, accomplishment_status, organization_id) 
              VALUES ('$title', '$plan_id', '$venue', '$start_date', '$end_date', '$type', 'Pending', 0, $organization_id)";
    
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
