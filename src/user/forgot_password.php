<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Forgot Password</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon_sikat.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

  <style>
    body {
      margin: 0;
      height: 100vh;
      position: relative;
      overflow: hidden;
      font-family: Arial, sans-serif;
    }

    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: url("../user/CCAT-Campus-Scaled.jpg");
      background-size: cover;
      background-position: center;
      filter: blur(8px);
      z-index: 1;
    }

    .page-wrapper {
      position: relative;
      z-index: 2;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .form-container {
      background-color: rgba(255, 255, 255, 0.9);
      max-width: 850px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 30px;
      z-index: 2;
      display: flex;
      flex-direction: column;
    }

    .form-section {
      flex: 1;
      padding: 20px;
    }

    .input-group {
      margin-bottom: 1rem;
    }
  </style>
</head>

<body>
  <div class="page-wrapper">
    <div class="container d-flex align-items-center justify-content-center" style="max-width: 900px">
      <div class="form-container shadow-lg rounded">
        <div class="form-section">
          <h2 class="text-center">Forgot Your Password?</h2>
          <p class="text-center mb-4" style="color: #6c757d; font-size: 0.9rem">
            Enter your email to receive an OTP for password reset.
          </p>
          <form action="send_otp.php" method="post">
            <div class="mb-3 input-group">
              <input type="email" name="email" class="form-control" placeholder="Enter your Email" required />
            </div>
            <button type="submit" class="btn w-100 mb-4" style="background-color: #3e7044; color: white;">
              Send OTP
            </button>
          </form>
          <!-- Alerts for success or error messages -->
          <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
          <?php endif; ?>
          <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>

</html>