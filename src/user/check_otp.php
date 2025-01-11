<?php
session_start();

// Check if the entered OTP matches the one stored in the session
if ($_POST['otp'] == $_SESSION['otp']) {
    // OTP is correct, redirect to password reset page
    header("Location: reset_password.php");
    exit();
} else {
    // Wrong OTP
    $_SESSION['error'] = "Invalid OTP. Please try again.";
    header("Location: verify_otp.php");
    exit();
}
?>