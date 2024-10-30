<?php
// Include database connection
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $organization_id = 1;
    $cash_on_bank = $_POST['cash_on_bank'];

    // Fetch current cash_on_hand and balance from the database
    $fetch_query = "SELECT cash_on_hand, balance FROM organizations WHERE organization_id = ?";
    $fetch_stmt = $conn->prepare($fetch_query);
    
    if ($fetch_stmt) {
        $fetch_stmt->bind_param('i', $organization_id);
        $fetch_stmt->execute();
        $fetch_stmt->bind_result($cash_on_hand, $balance);
        $fetch_stmt->fetch();
        $fetch_stmt->close();

        // Check if the new cash_on_bank plus cash_on_hand is greater than the balance
        if (($cash_on_bank + $cash_on_hand) > $balance) {
            // If the condition is not met, return an error message
            echo json_encode(['success' => false, 'message' => 'Cash on Bank plus Cash on Hand cannot exceed the Balance.']);
        } else {
            // Proceed with the update if the condition is met
            $update_query = "UPDATE organizations SET cash_on_bank = ? WHERE organization_id = ?";
            $update_stmt = $conn->prepare($update_query);

            if ($update_stmt) {
                $update_stmt->bind_param('di', $cash_on_bank, $organization_id);

                if ($update_stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Cash on Bank updated successfully!']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error updating Cash on Bank.']);
                }

                $update_stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Error preparing the update query.']);
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching current values from the database.']);
    }

    $conn->close();
}
?>
