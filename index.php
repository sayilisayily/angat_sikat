<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANGAT-SIKAT System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your custom stylesheet -->
    <style>
        /* Custom styles based on system palette */
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #FFB000;
            font-size: 2.5rem;
            font-weight: bold;
        }
        p {
            color: #666666;
            font-size: 1.1rem;
        }
        .btn-primary {
            background-color: #FFB000;
            border-color: #FFB000;
            color: #fff;
            width: 100%;
            margin-top: 10px;
        }
        .btn-primary:hover {
            background-color: #e69a00;
            border-color: #e69a00;
        }
        .btn-secondary {
            background-color: #0B9BA5;
            border-color: #0B9BA5;
            color: #fff;
            width: 100%;
            margin-top: 10px;
        }
        .btn-secondary:hover {
            background-color: #087f8b;
            border-color: #087f8b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ANGAT-SIKAT</h1>
        <p>Your trusted budgeting and expense tracking system for CCATian program planning.</p>
        <a href="authentication-login.php" class="btn btn-primary">Login</a>
        <a href="authentication-register.php" class="btn btn-secondary">Register</a>
    </div>
</body>
</html>
