<?php
session_start();
include 'connection.php';

$response = ['success' => false, 'message' => '', 'errors' => [], 'redirect_url' => ''];

$max_attempts = 3;
$reset_timeframe = 3600;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim(mysqli_real_escape_string($conn, $_POST['identifier']));
    $password = $_POST['password'];

    if (empty($identifier) || empty($password)) {
        $response['errors'][] = "Please enter both email/username and password.";
    } else {
        // Check if the identifier is an email
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT * FROM users WHERE email = '$identifier'";
        } else {
            $query = "SELECT * FROM users WHERE username = '$identifier'";
        }

        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            if ($user['is_locked']) {
                $response['errors'][] = "Your account has been locked due to multiple failed login attempts. Please contact support.";
            } else {
                $current_time = time();
                $last_failed_time = strtotime($user['last_failed_attempt']);

                if ($user['failed_attempts'] > 0 && ($current_time - $last_failed_time) > $reset_timeframe) {
                    $resetAttemptsQuery = "UPDATE users SET failed_attempts = 0 WHERE email = '{$user['email']}'";
                    mysqli_query($conn, $resetAttemptsQuery);
                    $user['failed_attempts'] = 0;
                }

                if (password_verify($password, $user['password'])) {
                    $resetAttemptsQuery = "UPDATE users SET failed_attempts = 0, last_failed_attempt = NULL WHERE email = '{$user['email']}'";
                    mysqli_query($conn, $resetAttemptsQuery);

                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['organization_id'] = $user['organization_id'];

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
                    $newFailedAttempts = $user['failed_attempts'] + 1;
                    $updateAttemptsQuery = "UPDATE users SET failed_attempts = $newFailedAttempts, last_failed_attempt = NOW() WHERE email = '{$user['email']}'";
                    mysqli_query($conn, $updateAttemptsQuery);

                    if ($newFailedAttempts >= $max_attempts) {
                        $lockAccountQuery = "UPDATE users SET is_locked = 1 WHERE email = '{$user['email']}'";
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

header('Content-Type: application/json');
echo json_encode($response);
mysqli_close($conn);
?>
