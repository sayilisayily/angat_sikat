<?php
include('connection.php');

$response = ['success' => false, 'errors' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];
    $disapproval_reason = isset($_POST['disapproval_reason']) ? trim($_POST['disapproval_reason']) : null;

    if (empty($id) || empty($action)) {
        $response['errors'][] = 'Invalid request data.';
    } else {
        $new_status = ($action === 'approve') ? 'approved' : 'disapproved';

        // Fetch title, category, and organization_id
        $title_query = "SELECT title, category, organization_id FROM budget_approvals WHERE approval_id = ?";
        $stmt = $conn->prepare($title_query);
        
        if ($stmt) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $title = $row['title'];
                $category = $row['category'];
                $organization_id = $row['organization_id'];
                $stmt->close();

                // Update the related table based on category
                if ($category === 'Activities') {
                    $update_query = "UPDATE events SET event_status = ? WHERE title = ?";
                } elseif ($category === 'Purchases') {
                    $update_query = "UPDATE purchases SET purchase_status = ? WHERE title = ?";
                } elseif ($category === 'Maintenance') {
                    $update_query = "UPDATE maintenance SET maintenance_status = ? WHERE title = ?";
                }
                
                if (isset($update_query)) {
                    $status_stmt = $conn->prepare($update_query);
                    $status_stmt->bind_param('ss', $new_status, $title);
                    $status_stmt->execute();
                    $status_stmt->close();
                }

                // Update the budget approval status
                $update_approval_query = "UPDATE budget_approvals SET status = ?, disapproval_message = ? WHERE approval_id = ?";
                $approval_stmt = $conn->prepare($update_approval_query);
                $approval_stmt->bind_param('ssi', $new_status, $disapproval_reason, $id);

                if ($approval_stmt->execute()) {
                    // Insert notification for users
                    $notification_message = "Your budget request for '$title' has been $new_status.";
                    
                    if ($new_status === 'disapproved' && !empty($disapproval_reason)) {
                        $notification_message .= " Reason: $disapproval_reason";
                    }

                    $insert_notification_query = "
                        INSERT INTO notifications (recipient_id, organization_id, message, is_read, created_at)
                        SELECT user_id, ?, ?, 0, NOW()
                        FROM users
                        WHERE organization_id = ?";

                    $notification_stmt = $conn->prepare($insert_notification_query);
                    if ($notification_stmt) {
                        $notification_stmt->bind_param('isi', $organization_id, $notification_message, $organization_id);
                        
                        if ($notification_stmt->execute()) {
                            $response['success'] = true;
                            $response['message'] = ($action === 'approve')
                                ? 'Budget request approved successfully!'
                                : 'Budget request disapproved successfully with a reason.';
                        } else {
                            $response['errors'][] = 'Failed to send notifications: ' . $conn->error;
                        }

                        $notification_stmt->close();
                    } else {
                        $response['errors'][] = 'Failed to prepare notification query: ' . $conn->error;
                    }
                } else {
                    $response['errors'][] = 'Database update failed for budget approval: ' . $conn->error;
                }
                $approval_stmt->close();
            } else {
                $response['errors'][] = 'Approval record not found.';
            }
        } else {
            $response['errors'][] = 'Failed to prepare statement for fetching title and category: ' . $conn->error;
        }
    }
}

echo json_encode($response);
?>
