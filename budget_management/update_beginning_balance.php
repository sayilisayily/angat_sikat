<?php
// Include database connection
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $organization_id = $_POST['organization_id'];
    $beginning_balance = $_POST['beginning_balance'];

    // Fetch current expenses for the organization
    $fetch_query = "SELECT SUM(amount) as total_expenses FROM expenses WHERE organization_id = ?";
    $fetch_stmt = $conn->prepare($fetch_query);
    
    if ($fetch_stmt) {
        $fetch_stmt->bind_param('i', $organization_id);
        $fetch_stmt->execute();
        $fetch_stmt->bind_result($total_expenses);
        $fetch_stmt->fetch();
        $fetch_stmt->close();

        // Calculate new balance (beginning balance - total expenses)
        $balance = $beginning_balance - $total_expenses;

        // Prepare and execute the update query to update beginning balance and balance
        $update_query = "UPDATE organizations SET beginning_balance = ?, balance = ? WHERE organization_id = ?";
        $update_stmt = $conn->prepare($update_query);

        if ($update_stmt) {
            $update_stmt->bind_param('ddi', $beginning_balance, $balance, $organization_id);

            if ($update_stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Beginning balance and balance updated successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating beginning balance and balance.']);
            }

            $update_stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Error preparing the update query.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching expenses from the database.']);
    }

    $conn->close();
}
?>
