<?php
// Start session
session_start();

// Include database connection
include 'connection.php';

// Initialize response array
$response = ['success' => false, 'message' => '', 'errors' => [], 'redirect_url' => ''];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form inputs
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = $_POST['password'];

    // Check if email and password are provided
    if (empty($email) || empty($password)) {
        $response['errors'][] = "Please enter both email and password.";
    } else {
        // Prepare query to check if the user exists
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        // Check if the user exists
        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables based on user data
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['organization_id'] = $user['organization_id'];

                // Set success message and redirect URL based on role
                $response['success'] = true;
                $response['message'] = "Login successful!";
                if ($user['role'] === 'admin') {
                    $response['redirect_url'] = '../dashboard/admin_dashboard.php';
                } elseif ($user['role'] === 'officer') {
                    $response['redirect_url'] = '../dashboard/officer_dashboard.php';
                } elseif ($user['role'] === 'member') {
                    $response['redirect_url'] = '../dashboard/member_dashboard.php';
                } else {
                    $response['errors'][] = "Unknown user role.";
                }
            } else {
                $response['errors'][] = "Incorrect password.";
            }
        } else {
            $response['errors'][] = "User not found.";
        }
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close database connection
mysqli_close($conn);
?>
