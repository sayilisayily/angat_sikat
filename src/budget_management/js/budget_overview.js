$(document).ready(function () {
  $(document).ready(function () {
    // Toggle visibility for balance values and change eye icon
    $(".toggle-eye").click(function () {
      var balanceValue = $(this).siblings(".balance-value");
      var balancePlaceholder = $(this).siblings(".balance-placeholder");
      var icon = $(this);

      // Toggle the visibility
      balanceValue.toggle();
      balancePlaceholder.toggle();

      // Toggle the eye icon
      if (balanceValue.is(":visible")) {
        icon.removeClass("fa-eye").addClass("fa-eye-slash"); // Change to eye-slash when visible
      } else {
        icon.removeClass("fa-eye-slash").addClass("fa-eye"); // Change to eye when hidden
      }
    });
  });

  const notificationBtn = document.getElementById("notificationBtn");
  const notificationDropdown = document.getElementById("notificationDropdown");
  const notificationList = document.getElementById("notificationList");
  const notificationCount = document.getElementById("notificationCount");
  const noNotifications = document.getElementById("noNotifications");

  // Toggle Dropdown Visibility
  notificationBtn.addEventListener("click", () => {
    const isVisible = notificationDropdown.style.display === "block";
    notificationDropdown.style.display = isVisible ? "none" : "block";
  });

  // Load Notifications Dynamically
  function loadNotifications() {
    fetch("../get_notifications.php")
      .then((response) => response.json())
      .then((data) => {
        notificationList.innerHTML = ""; // Clear existing notifications
        if (data.length > 0) {
          data.forEach((notification) => {
            const notificationItem = document.createElement("div");
            notificationItem.classList.add("notification-item");
            notificationItem.style.padding = "10px";
            notificationItem.style.borderBottom = "1px solid #ccc";
            notificationItem.textContent = notification.message;

            // Add data-id attribute for the notification ID
            notificationItem.dataset.id = notification.id;

            // Attach click event to mark as read
            notificationItem.addEventListener("click", () => {
              markAsRead(notification.id);
              notificationItem.style.opacity = 0.5; // Visual indicator (optional)
            });

            notificationList.appendChild(notificationItem);
          });

          notificationCount.textContent = data.length;
          notificationCount.style.display = "inline-block";
          noNotifications.style.display = "none";
        } else {
          noNotifications.style.display = "block";
          notificationCount.style.display = "none";
        }
      })
      .catch((error) => {
        console.error("Error loading notifications:", error);
      });
  }

  function updateNotificationCount() {
    const currentCount = parseInt(notificationCount.textContent, 10) || 0;
    if (currentCount > 0) {
      notificationCount.textContent = currentCount - 1;
      if (currentCount - 1 === 0) {
        notificationCount.style.display = "none";
        noNotifications.style.display = "block";
      }
    }
  }

  // Initial Load
  loadNotifications();

  // Optionally, refresh notifications periodically (e.g., every 30 seconds)
  setInterval(loadNotifications, 30000);

  // Close dropdown if clicked outside
  document.addEventListener("click", (e) => {
    if (
      !notificationBtn.contains(e.target) &&
      !notificationDropdown.contains(e.target)
    ) {
      notificationDropdown.style.display = "none";
    }
  });

  // Function to mark a notification as read
  async function markAsRead(notificationId) {
    try {
      await fetch("../notification_read.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ id: notificationId }),
      });

      // Optional: update notification count after marking as read
      updateNotificationCount();
    } catch (error) {
      console.error("Error marking notification as read:", error);
    }
  }

  // Submit Beginning Balance Form
  $("#editBeginningBalanceForm").on("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
      url: "update_beginning_balance.php", // PHP script to update the balance
      type: "POST",
      data: formData, // Use formData object
      contentType: false, // Important for file upload
      processData: false, // Important for file upload
      success: function (response) {
        try {
          // Parse the JSON response (ensure it's valid JSON)
          response = JSON.parse(response);
          console.log(response);

          if (response.success) {
            // Hide any existing error messages
            $("#errorMessage1").addClass("d-none");

            // Show success message
            $("#successMessage1").removeClass("d-none");

            // Close the modal after a short delay
            setTimeout(function () {
              $("#editBeginningBalanceModal").modal("hide");
              location.reload();
            }, 2000);
          } else {
            // Hide any existing success messages
            $("#successMessage1").addClass("d-none");

            // Show validation errors
            $("#errorMessage1").removeClass("d-none");
            let errorHtml = "";
            for (let field in response.errors) {
              errorHtml += `<li>${response.errors[field]}</li>`;
            }
            $("#errorList1").html(errorHtml);
          }
        } catch (error) {
          console.error("Error parsing JSON response:", error);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error updating event:", error);
        console.log(response);
      },
    });
  });

  // Submit Cash on Hand form
  $("#editCashOnBankForm").on("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
      url: "update_cash_on_bank.php",
      type: "POST",
      data: formData, // Use formData object
      contentType: false, // Important for file upload
      processData: false, // Important for file upload
      success: function (response) {
        try {
          // Parse the JSON response (ensure it's valid JSON)
          response = JSON.parse(response);
          console.log(response);

          if (response.success) {
            // Hide any existing error messages
            $("#errorMessage2").addClass("d-none");

            // Show success message
            $("#successMessage2").removeClass("d-none");

            // Close the modal after a short delay
            setTimeout(function () {
              $("#editCashOnHandModal").modal("hide");
              location.reload();
            }, 2000);
          } else {
            // Hide any existing success messages
            $("#successMessage2").addClass("d-none");

            // Show validation errors
            $("#errorMessage2").removeClass("d-none");
            let errorHtml = "";
            for (let field in response.errors) {
              errorHtml += `<li>${response.errors[field]}</li>`;
            }
            $("#errorList2").html(errorHtml);
          }
        } catch (error) {
          console.error("Error parsing JSON response:", error);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error updating event:", error);
        console.log(response);
      },
    });
  });
});

// Submit Cash on Hand form
$("#editCashOnHandForm").on("submit", function (e) {
  e.preventDefault();
  let formData = new FormData(this);

  $.ajax({
    url: "update_cash_on_hand.php",
    type: "POST",
    data: formData, // Use formData object
    contentType: false, // Important for file upload
    processData: false, // Important for file upload
    success: function (response) {
      try {
        // Parse the JSON response (ensure it's valid JSON)
        response = JSON.parse(response);
        console.log(response);

        if (response.success) {
          // Hide any existing error messages
          $("#errorMessage3").addClass("d-none");

          // Show success message
          $("#successMessage3").removeClass("d-none");

          // Close the modal after a short delay
          setTimeout(function () {
            $("#editCashOnHandModal").modal("hide");
            location.reload();
          }, 2000);
        } else {
          // Hide any existing success messages
          $("#successMessage3").addClass("d-none");

          // Show validation errors
          $("#errorMessage3").removeClass("d-none");
          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`;
          }
          $("#errorList3").html(errorHtml);
        }
      } catch (error) {
        console.error("Error parsing JSON response:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error updating event:", error);
      console.log(response);
    },
  });
});

$(document).on("click", ".edit-btn", function () {
  var allocationId = $(this).data("id"); // Retrieve allocation_id from button
  console.log("Selected Event ID:", allocationId);
  // Use AJAX to get the budget allocation data
  $.ajax({
    url: "get_budget_allocation.php", // PHP file to fetch budget data
    type: "POST",
    data: { allocation_id: allocationId }, // Send allocation_id to server
    dataType: "json",
    success: function (response) {
      if (response.success) {
        // Populate the form fields in the modal with data from the response
        $("#edit_allocation_id").val(response.allocation_id); // Hidden input
        $("#edit_allocated_budget").val(response.allocated_budget); // Read-only field
        $("#addBudget").val(""); // Clear the add budget input
        $("#subtractBudget").val(""); // Clear the subtract budget input

        // Show the modal
        $("#editBudgetModal").modal("show");
      } else {
        alert(response.message || "Failed to fetch data for editing.");
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", error);
      alert("An error occurred while fetching budget allocation data.");
    },
  });
});

//Submit Budget Allocation Form
$("#addBudgetForm").on("submit", function (e) {
  e.preventDefault(); // Prevent the default form submission behavior

  $.ajax({
    url: "add_budget.php",
    type: "POST",
    data: $(this).serialize(),
    success: function (response) {
      try {
        // Parse the JSON response (ensure it's valid JSON)
        response = JSON.parse(response);
        console.log(response);

        if (response.success) {
          // Hide any existing error messages
          $("#errorMessage4").addClass("d-none");

          // Show success message
          $("#successMessage4").removeClass("d-none");

          // Close the modal after a short delay
          setTimeout(function () {
            $("#addBudgetModal").modal("hide");
            location.reload();
          }, 2000);
        } else {
          // Hide any existing success messages
          $("#successMessage4").addClass("d-none");

          // Show validation errors
          $("#errorMessage4").removeClass("d-none");
          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`;
          }
          $("#errorList4").html(errorHtml);
        }
      } catch (error) {
        console.error("Error parsing JSON response:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error updating budget:", error);
      console.log(response);
    },
  });
});

//Submit Budget Allocation Form
$("#editBudgetForm").on("submit", function (e) {
  e.preventDefault(); // Prevent the default form submission behavior

  $.ajax({
    url: "update_budget.php",
    type: "POST",
    data: $(this).serialize(),
    success: function (response) {
      try {
        // Parse the JSON response (ensure it's valid JSON)
        response = JSON.parse(response);
        console.log(response);

        if (response.success) {
          // Hide any existing error messages
          $("#errorMessage").addClass("d-none");

          // Show success message
          $("#successMessage").removeClass("d-none");

          // Close the modal after a short delay
          setTimeout(function () {
            $("#editBudgetModal").modal("hide");
            location.reload();
          }, 2000);
        } else {
          // Hide any existing success messages
          $("#successMessage").addClass("d-none");

          // Show validation errors
          $("#errorMessage").removeClass("d-none");
          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`;
          }
          $("#errorList").html(errorHtml);
        }
      } catch (error) {
        console.error("Error parsing JSON response:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error updating budget:", error);
      console.log(response);
    },
  });
});
