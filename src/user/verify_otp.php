<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Verify OTP</title>
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
          <h2 class="text-center">Enter Your OTP</h2>
          <p class="text-center mb-4" style="color: #6c757d; font-size: 0.9rem">
            Enter the 6-digit OTP sent to your email.
          </p>
          <form action="check_otp.php" method="post">
            <div class="mb-3 input-group">
              <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required maxlength="6" />
            </div>
            <button type="submit" class="btn w-100 mb-4" style="background-color: #3e7044; color: white;">
              Verify OTP
            </button>
          </form>
          <div id="countdown" style="text-align: center; margin-top: 10px;">
            <span id="timer">60</span> seconds until you can resend the OTP.
          </div>
          <button id="resendButton" class="btn w-100" style="background-color: #ffc107; color: black; display: none;">
            Resend OTP
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    let countdown = 60;
    const timerElement = document.getElementById('timer');
    const resendButton = document.getElementById('resendButton');

    const interval = setInterval(() => {
      countdown--;
      timerElement.innerText = countdown;

      if (countdown <= 0) {
        clearInterval(interval);
        resendButton.style.display = 'block';
      }
    }, 1000);

    resendButton.addEventListener('click', function() {
      // Implement resend OTP logic here
      alert('OTP resent!'); // Replace with actual resend logic
      countdown = 60; // Reset countdown
      timerElement.innerText = countdown;
      resendButton.style.display = 'none';
      setInterval(() => {
        countdown--;
        timerElement.innerText = countdown;

        if (countdown <= 0) {
          clearInterval(interval);
          resendButton.style.display = 'block';
        }
      }, 1000);
    });
  </script>
</body>

</html>