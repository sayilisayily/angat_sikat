<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $amount = $_POST['amount'];

    // Validate input
    if (empty($description) || empty($quantity) || empty($unit) || empty($amount)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Update the item in the database
    $query = "UPDATE event_items SET description = ?, quantity = ?, unit = ?, amount = ? WHERE item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sdssi', $description, $quantity, $unit, $amount, $item_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Item updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating item.']);
    }

    $stmt->close();
}
?>
