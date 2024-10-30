<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ANGAT SIKAT</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    /* Custom styles for the form */
    .container-fluid {
      height: 100vh;
    }
    .form-section {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 100%;
    }
    .image-section {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0;
      height: 100%;
    }
    .image-section img {
      max-width: 90%;
      height: auto;
    }
    .btn-custom {
      background-color: #1c8130;
      color: #fff;
    }
    .btn-custom:hover {
      background-color: #145923;
      color: #fff;
    }
    .signin-btn {
      background-color: transparent;
      color: #1c8130;
      border: none;
      padding: 0;
      text-align: center;
      margin-top: 10px;
      text-decoration: underline;
      cursor: pointer;
    }
    .signin-btn:hover {
      color: #145923;
    }
    input.form-control {
      padding: 8px;
    }
    h3 {
      margin-bottom: 20px;
    }
    button {
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <?php
    include('connection.php'); // Make sure the database connection file is included
  ?>

  <div class="container-fluid d-flex align-items-center justify-content-center">
    <div class="row w-100 no-gutters">
      <!-- Image Section -->
      <div class="col-md-6 image-section">
        <img src="images/register.jpg" alt="Budget Planning Image">
      </div>

      <!-- Form Section -->
      <div class="col-md-6">
        <div class="form-section">
          <h3>Registration</h3>

          <!-- Registration Form -->
          <form id="registrationForm" action="registration.php" method="POST">
            <div class="row">
              <!-- Username -->
              <div class="col-md-6 mb-2">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" required>
              </div>
          
              <!-- Username -->
              <div class="col-md-6 mb-2">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required>
              </div>
            </div>
          
            <div class="row">
              <!-- First Name -->
              <div class="col-md-6 mb-2">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" name="fname" id="firstname" placeholder="Enter First Name" required>
              </div>

              <!-- Last Name -->
              <div class="col-md-6 mb-2">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lname" id="lastname" placeholder="Enter Last Name" required>
              </div>
            </div>
          
            <div class="row">
              <!-- Organization -->
              <div class="col-md-6 mb-2">
                <label for="organization" class="form-label">Organization</label>
                <select class="form-select" name="organization" id="organization" required>
                  <option value="">Select Organization</option>
                  <?php
                    $query = "SELECT organization_id, organization_name FROM organizations";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                      while ($org = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$org['organization_id']}'>{$org['organization_name']}</option>";
                      }
                    } else {
                      echo "<option value=''>No Organizations Available</option>";
                    }
                  ?>
                </select>
              </div>

              <!-- Role -->
              <div class="col-md-6 mb-2">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" name="role" id="role" required>
                  <option value="officer">Officer</option>
                  <option value="member">Member</option>
                </select>
              </div>
          
              
            </div>
          
            <div class="row">
              <!-- Password -->
              <div class="col-md-6 mb-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
              </div>

              <!-- Confirm Password -->
              <div class="col-md-6 mb-2">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmpassword" name="confirm_password" placeholder="Re-type Password" required>
              </div>
            </div>
          
            <!-- Submit Button -->
            <button type="submit" class="btn btn-custom w-100 py-2 fs-5 mt-3">Sign Up</button>
          
            <!-- Sign In Button -->
            <div class="text-center">
              <p class="mb-0">Have an account? <a class="signin-btn" href="./authentication-login.html">Sign In</a></p>
            </div>
          </form>
          
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
