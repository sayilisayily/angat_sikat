<?php
include 'connection.php';

// Example update logic
$allocated_budget = $_POST['allocated_budget'];
$allocation_id = $_POST['allocation_id'];

$query = "UPDATE budget_allocation SET allocated_budget = ? WHERE allocation_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("di", $allocated_budget, $allocation_id);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = "Budget updated successfully.";
} else {
    $response['success'] = false;
    $response['message'] = "Failed to update budget.";
}

$stmt->close();
$conn->close();

// Set the content type to application/json
header('Content-Type: application/json');
// Return the JSON response
echo json_encode($response);
?>
