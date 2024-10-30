<?php
// Include database connection
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $organization_id = $_POST['organization_id'];
    $cash_on_hand = $_POST['cash_on_hand'];

    // Prepare and execute the update query
    $query = "UPDATE organizations SET cash_on_hand = ? WHERE organization_id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param('di', $cash_on_hand, $organization_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Cash on Hand updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating Cash on Hand.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing the update query.']);
    }

    $stmt->close();
    $conn->close();
}
?>
