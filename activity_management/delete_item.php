<?php
// Database connection
require 'connection.php';

// Check if 'item_id' is set in POST request
if (isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']); // Sanitize item_id

    // Prepare delete statement
    $stmt = $conn->prepare("DELETE FROM event_items WHERE item_id = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    // Bind parameter and execute
    $stmt->bind_param("i", $item_id);
    if ($stmt->execute()) {
        // Redirect back to the event details page with success message
        header("Location: event_details.php?event_id=" . $_POST['event_id'] . "&message=Item+deleted+successfully");
        exit();
    } else {
        echo "Error deleting item: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "No item ID provided.";
}
?>
