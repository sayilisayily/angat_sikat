<?php
// Include database connection
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $title = $_POST['title'];
    $event_venue = $_POST['event_venue'];
    $event_start_date = $_POST['event_start_date'];
    $event_end_date = $_POST['event_end_date'];
    $event_type = $_POST['event_type'];
    $accomplishment_status = (int)$_POST['accomplishment_status'];

    // Initialize an array to hold validation errors
    $errors = [];

    // Validate the title
    if (empty($title)) {
        $errors[] = 'Event title is required.';
    }

    // Check if the event with the same title already exists, excluding the current event being updated
    if (empty($errors)) {
        $title = mysqli_real_escape_string($conn, $title);
        $query = "SELECT * FROM events WHERE title = '$title' AND event_id != '$event_id'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $errors[] = 'An event with this title already exists.';
        }
    }

    // If there are validation errors, return them
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    // Prepare and execute update query
    $query = "UPDATE events SET title = ?, event_venue = ?, event_start_date = ?, event_end_date = ?, event_type = ?, accomplishment_status = ? WHERE event_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Error preparing query: ' . $conn->error]);
        exit;
    }

    // Bind parameters with the correct types
    $stmt->bind_param('sssssii', $title, $event_venue, $event_start_date, $event_end_date, $event_type, $accomplishment_status, $event_id);

    // Execute query
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Event updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating event: ' . $stmt->error]);
    }

    $stmt->close();
}
?>
