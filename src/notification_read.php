<?php
include 'connection.php';
include 'session_check.php'; // Authentication check

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $notification_id = $data['id'];

    // Mark the notification as read, checking both recipient_id and organization_id
    $query = "
        UPDATE notifications 
        SET is_read = 1 
        WHERE id = $notification_id 
          AND recipient_id = $user_id
          AND organization_id = (SELECT organization_id FROM users WHERE user_id = $user_id)
    ";
    mysqli_query($conn, $query);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Notification ID not provided.']);
}

?>
