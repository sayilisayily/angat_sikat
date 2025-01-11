<?php
include '../connection.php';

// Initialize an array to hold any errors
$errors = [];
$data = [];

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize inputs
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $fname = trim(mysqli_real_escape_string($conn, $_POST['fname']));
    $lname = trim(mysqli_real_escape_string($conn, $_POST['lname']));
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (empty($username) || empty($fname) || empty($lname) || empty($email) || empty($password) || empty($confirm_password) || empty($position)) {
        $errors[] = "All fields are required.";
    }

    // Check if email ends with "cvsu.edu.ph"
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@cvsu.edu.ph')) {
        $errors[] = "Invalid email. Email must be a valid format and end with 'cvsu.edu.ph'.";
    }

    // Validate password strength (minimum 8 characters, at least one uppercase, one lowercase, one number, and one special character)
    if (strlen($password) < 8 || 
        !preg_match('/[A-Z]/', $password) || 
        !preg_match('/[a-z]/', $password) || 
        !preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number.";
    }

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if username or email already exists
    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Username or email is already taken.";
    }

    // If no errors, proceed with insertion
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert the user into the database
        $sql = "INSERT INTO users (username, first_name, last_name, organization_id, role, email, password, position) 
                VALUES ('$username', '$fname', '$lname', '$organization', '$role', '$email', '$hashed_password', '$position')";

        if (mysqli_query($conn, $sql)) {
            // Registration successful
            $data['success'] = true;
            $data['message'] = 'User added successfully!';
        } else {
            $data['success'] = false;
            $data['errors'] = ['database' => 'Failed to add user to the database.'];
        }
    }
}

echo json_encode($data);
?>
