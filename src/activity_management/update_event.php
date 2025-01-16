<?php
// Include database connection
include('connection.php');
include '../session_check.php';

// Initialize an array to hold validation errors
$errors = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate fields
    if (empty($_POST['title'])) {
        $errors[] = 'Event title is required.';
    } else {
        $title = mysqli_real_escape_string($conn, $_POST['title']); // Correctly set $title here
        $event_id = mysqli_real_escape_string($conn, $_POST['event_id']); // Set $event_id for use
        // Check for duplicate event title
        $query = "SELECT * FROM events WHERE title = '$title' AND event_id != '$event_id' AND organization_id = $organization_id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $errors[] = 'An event with this title already exists.';
        }
    }

    if (empty($_POST['event_venue'])) {
        $errors['event_venue'] = 'Event venue is required.';
    } else {
        $venue = mysqli_real_escape_string($conn, $_POST['event_venue']);
    }

    if (empty($_POST['event_start_date'])) {
        $errors['start_date'] = 'Event start date is required.';
    } else {
        $start_date = mysqli_real_escape_string($conn, $_POST['event_start_date']);
    }

    if (empty($_POST['event_end_date'])) {
        $errors['end_date'] = 'Event end date is required.';
    } else {
        $end_date = mysqli_real_escape_string($conn, $_POST['event_end_date']);
    }

    if ((strtotime($_POST['event_start_date'])) > (strtotime($_POST['event_end_date']))) {
        $errors['date'] = 'Invalid event start and end date.';
    }

    $type = mysqli_real_escape_string($conn, $_POST['event_type']);

    // Check for duplicate event start date and venue where status = Approved
    $check_query = "SELECT * FROM events 
                    WHERE event_start_date = '$start_date' 
                      AND event_venue = '$venue' 
                      AND event_status = 'Approved'
                      AND event_id != '$event_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $errors['conflict'] = 'An event with the same start date and venue already exists and is approved.';
    }

    // If there are validation errors, return them
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        // Prepare and execute the update query
        $query = "UPDATE events SET 
                    title = '$title', 
                    event_venue = '$venue', 
                    event_start_date = '$start_date', 
                    event_end_date = '$end_date', 
                    event_type = '$type'
                  WHERE event_id = '$event_id'";

        if (mysqli_query($conn, $query)) {
            $data['success'] = true;
            $data['message'] = 'Event updated successfully!';
        } else {
            $data['success'] = false;
            $data['errors'] = ['database' => 'Failed to update event in the database.'];
        }
    }
}

echo json_encode($data);
?>
