$(document).ready(function () {
  $("#advisersTable").DataTable({
    paging: true,
    searching: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    ordering: true,
    order: [],
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
});

// Handle Add User Form Submission
$("#addAdviserForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    url: "add_adviser.php",
    type: "POST",
    data: formData, // Send the FormData object
    processData: false, // Prevent jQuery from processing the data
    contentType: false, // Required for FormData
    success: function (response) {
      try {
        // Parse the JSON response (in case it's returned as a string)
        response = JSON.parse(response);
        console.log(response);

        if (response.success) {
          // Hide any existing error messages
          $("#errorMessage").addClass("d-none");

          // Show success message
          $("#successMessage").removeClass("d-none");

          // Close the modal after a short delay
          setTimeout(function () {
            $("#addAdviserModal").modal("hide");

            // Reset the form and hide the success message
            $("#addAdviserForm")[0].reset();
            $("#successMessage").addClass("d-none");

            // Reload the page to reflect the new user
            location.reload();
          }, 2000); // Adjust the delay as needed (2 seconds here)
        } else {
          // Hide any existing success messages
          $("#successMessage").addClass("d-none");

          // Show error messages
          $("#errorMessage").removeClass("d-none");
          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`;
          }
          $("#errorList").html(errorHtml);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error adding user:", error);
    },
  });
});

// Handle Edit User Modal
$(".edit-btn").on("click", function () {
  var adviserId = $(this).data("id"); // Get adviser_id from the button
  console.log("Selected Adviser ID:", adviserId); // Log the user ID for debugging

  // Send an AJAX request to fetch the user details using the user ID
  $.ajax({
    url: "get_adviser_details.php", // PHP file to fetch user data
    type: "POST",
    data: { adviser_id: adviserId },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        // Populate the form with user data
        $("#editAdviserId").val(response.data.adviser_id); // Hidden field for user ID
        $("#edit_first_name").val(response.data.first_name); // Match DB field names
        $("#edit_last_name").val(response.data.last_name);
        $("#edit_position").val(response.data.position);
        $("#edit_organization").val(response.data.organization_id); // Use organization_id

        // Clear previous error messages
        $("#editErrorMessage").addClass("d-none");
        $("#editErrorList").empty();

        // Show the modal
        $("#editUserModal").modal("show");
      } else {
        console.error("Error fetching data:", response.message);
        alert("Error: " + response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", error);
      alert("Failed to fetch user details. Please try again.");
    },
  });
});

// Handle Edit User Form Submission
$("#editAdviserForm").on("submit", function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    url: "update_adviser.php",
    type: "POST",
    data: formData, // Send the FormData object
    processData: false, // Prevent jQuery from processing the data
    contentType: false,
    success: function (response) {
      try {
        // Parse the JSON response (ensure it's valid JSON)
        response = JSON.parse(response);
        console.log(response);

        if (response.success) {
          // Hide any existing error messages
          $("#editErrorMessage").addClass("d-none");

          // Show success message
          $("#editSuccessMessage").removeClass("d-none");

          // Close the modal after a short delay
          setTimeout(function () {
            $("#editAdviserModal").modal("hide");

            // Reset the form and hide the success message
            $("#editAdviserForm")[0].reset();
            $("#editSuccessMessage").addClass("d-none");
            location.reload();
          }, 2000);
        } else {
          // Show validation errors
          $("#editSuccessMessage").addClass("d-none");

          $("#editErrorMessage").removeClass("d-none");
          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`;
          }
          $("#editErrorList").html(errorHtml);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error updating user:", error);
      console.log(xhr.responseText);
    },
  });
});

// Event delegation for dynamically loaded buttons (Archive)
$(document).on("click", ".archive-btn", function () {
  var adviserId = $(this).data("id");
  $("#archiveId").val(adviserId);
  $("#archiveModal").modal("show");
  console.log("Selected User ID: " + adviserId);
});

// Handle archive confirmation when "Archive" button in modal is clicked
$("#confirmArchiveBtn").on("click", function () {
  var adviserId = $("#archiveId").val(); // Get the organization ID from the hidden input field

  // Send an AJAX request to archive the organization
  $.ajax({
    url: "archive_adviser.php", // PHP file to handle archiving
    type: "POST",
    data: { adviser_id: adviserId },
    dataType: "json",
    success: function (response) {
      try {
        if (response.success) {
          // Show success message (optional)
          console.log(response.message);
          // Hide any existing error messages
          $("#archiveErrorMessage").addClass("d-none");

          // Show success message
          $("#archiveSuccessMessage").removeClass("d-none");

          // Close the modal after a short delay
          setTimeout(function () {
            $("#archiveModal").modal("hide");
            $("#archiveSuccessMessage").addClass("d-none");
            location.reload();
          }, 2000);
        } else {
          // Show validation errors
          $("#archiveSuccessMessage").addClass("d-none");

          $("#archiveErrorMessage").removeClass("d-none");
          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`;
          }
          $("#archiveErrorList").html(errorHtml);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error archiving organization:", error);
      console.log(xhr.responseText);
    },
  });
});
