<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $organization_id = 1; // Change as needed or fetch from the session

    // Validate inputs
    $errors = [];
    if (empty($title)) {
        $errors[] = "Title is required.";
    }
    if (empty($amount) || !is_numeric($amount)) {
        $errors[] = "Valid amount is required.";
    }
    if (empty($date)) {
        $errors[] = "Date is required.";
    }

    // If no errors, insert the expense entry
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO expenses (title, amount, date, description, organization_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssi", $title, $amount, $date, $description, $organization_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Expense added successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add expense.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'errors' => $errors]);
    }
}

$conn->close();
?>
