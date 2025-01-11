<?php
session_start();
require '../user/phpmailer/index.php'; // Ensure this points to the correct location of the PHPMailer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get the email from the form
$email = $_POST['email'];

// Generate a random 6-digit OTP
$otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

// Store the OTP and email in session for verification later
$_SESSION['otp'] = $otp;
$_SESSION['email'] = $email;

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 0; // Enable verbose debug output (0 means no debug output)
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.example.com'; // Specify your SMTP server
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'reyesnoely7'; // Your SMTP username
    $mail->Password = 'your_password'; // Your SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to

    // Recipients
    $mail->setFrom('your_email@example.com', 'Your Name');
    $mail->addAddress($email); // Add recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Your OTP Code';
    $mail->Body    = "Your OTP code is: <strong>$otp</strong>";

    // Send the email
    $mail->send();
    header("Location: verify_otp.php"); // Redirect to OTP verification page
    exit();
} catch (Exception $e) {
    $_SESSION['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("Location: forgot_password.php"); // Redirect back to the forgot password page
    exit();
}
?>