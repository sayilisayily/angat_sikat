<?php
include '../connection.php';

if (isset($_POST['adviser_id'])) {
    $adviser_id = $_POST['adviser_id'];

    $query = "SELECT * FROM advisers WHERE adviser_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $adviser_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $event]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Event not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No event ID provided.']);
}
?>
