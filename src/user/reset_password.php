<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reset Password</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon_sikat.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />

  <style>
    /* Include your existing styles here */
  </style>
</head>

<body>
  <div class="page-wrapper">
    <div class="container d-flex align-items-center justify-content-center" style="max-width: 900px">
      <div class="form-container shadow-lg rounded">
        <div class="form-section">
          <h2 class="text-center">Reset Your Password</h2>
          <form action="update_password.php" method="post">
            <div class="mb-3 input-group">
              <input type="password" name="new_password" class="form-control" placeholder="New Password" required />
            </div>
            <div class="mb-3 input-group">
              <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required />
            </div>
            <button type="submit" class="btn w-100 mb-4" style="background-color: #3e7044; color: white;">
              Save New Password
            </button>
          </form>
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