<?php
// Start the session
session_start();

// Check if the user is logged in by verifying session variables
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: ../user/login.html");
    exit();
}

// Define session timeout duration (e.g., 5 minutes = 300 seconds)
$timeout_duration = 300;

// Check if the session activity timestamp exists
if (isset($_SESSION['LAST_ACTIVITY'])) {
    // Calculate elapsed time since last activity
    $elapsed_time = time() - $_SESSION['LAST_ACTIVITY'];

    // If the session has expired, destroy it and redirect to login page
    if ($elapsed_time > $timeout_duration) {
        session_unset(); // Clear session data
        session_destroy(); // Destroy the session
        header("Location: ../user/login.html?message=Session expired."); // Redirect to login with a message
        exit(); // Stop further script execution
    }
}

// Update the last activity timestamp to the current time
$_SESSION['LAST_ACTIVITY'] = time();

// Retrieve user details from session variables
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role']; // For roles like 'admin', 'officer', etc.
$organization_id = $_SESSION['organization_id']; // The organization the user belongs to
?>
