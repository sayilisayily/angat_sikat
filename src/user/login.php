<?php
// Start session
session_start();

// Include database connection
include 'connection.php';

// Initialize response array
$response = ['success' => false, 'message' => '', 'errors' => [], 'redirect_url' => ''];

// Maximum allowed failed attempts
$max_attempts = 3;
// Timeframe for resetting failed attempts (e.g., 1 hour)
$reset_timeframe = 3600; // in seconds (1 hour)

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

            // Check if the account is locked
            if ($user['is_locked']) {
                $response['errors'][] = "Your account has been locked due to multiple failed login attempts. Please contact support.";
            } else {
                // Handle failed attempts based on last_failed_attempt
                $current_time = time();
                $last_failed_time = strtotime($user['last_failed_attempt']);

                // Reset failed attempts if enough time has passed
                if ($user['failed_attempts'] > 0 && ($current_time - $last_failed_time) > $reset_timeframe) {
                    $resetAttemptsQuery = "UPDATE users SET failed_attempts = 0 WHERE email = '$email'";
                    mysqli_query($conn, $resetAttemptsQuery);
                    $user['failed_attempts'] = 0; // Reset locally
                }

                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Reset failed attempts on successful login
                    $resetAttemptsQuery = "UPDATE users SET failed_attempts = 0, last_failed_attempt = NULL WHERE email = '$email'";
                    mysqli_query($conn, $resetAttemptsQuery);

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
                    } else {
                        $response['errors'][] = "Unknown user role.";
                    }
                } else {
                    // Increment failed attempts and set last_failed_attempt timestamp
                    $newFailedAttempts = $user['failed_attempts'] + 1;
                    $updateAttemptsQuery = "UPDATE users SET failed_attempts = $newFailedAttempts, last_failed_attempt = NOW() WHERE email = '$email'";
                    mysqli_query($conn, $updateAttemptsQuery);

                    // Lock the account if failed attempts exceed the maximum
                    if ($newFailedAttempts >= $max_attempts) {
                        $lockAccountQuery = "UPDATE users SET is_locked = 1 WHERE email = '$email'";
                        mysqli_query($conn, $lockAccountQuery);
                        $response['errors'][] = "Your account has been locked due to multiple failed login attempts. Please contact support.";
                    } else {
                        $remainingAttempts = $max_attempts - $newFailedAttempts;
                        $response['errors'][] = "Incorrect password. You have $remainingAttempts attempts remaining.";
                    }
                }
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
