$(document).ready(function () {
  $("#purchasesTable").DataTable({
    paging: true,
    searching: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    ordering: true,
    order: [],
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
  fetch("../../get_notifications.php")
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
    await fetch("../../notification_read.php", {
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

// Global variables to store event details
let purchaseIdToUpdate;
let newStatus;

// Show confirmation modal and store event details
function showConfirmationModal(purchaseId, isChecked) {
  purchaseIdToUpdate = purchaseId; // Store the purchase ID
  newStatus = isChecked ? 1 : 0; // Store the new completion status

  // Show the confirmation modal
  $("#confirmationModal").modal("show");
}

// Handle confirmation when "Confirm" button in modal is clicked
$("#confirmUpdateBtn").on("click", function () {
  // Get event ID and new status from global variables
  var purchaseId = purchaseIdToUpdate;
  var status = newStatus;

  // Send an AJAX request to update the completion status
  $.ajax({
    url: "update_completion.php", // PHP file to handle status update
    type: "POST",
    data: {
      purchase_id: purchaseId,
      completion_status: status,
    },
    dataType: "json",
    success: function (response) {
      try {
        if (response.success) {
          // Show success message
          $("#successMessage").removeClass("d-none").text(response.message);
          // Hide any existing error messages
          $("#errorMessage").addClass("d-none");

          // Close the modal after a short delay
          setTimeout(function () {
            $("#confirmationModal").modal("hide");
            // Optionally, you can reload the page or update the table if necessary
            location.reload(); // or update the checkbox or table directly
          }, 2000);
        } else {
          // Show validation errors
          $("#successMessage").addClass("d-none");
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
      console.error("Error updating accomplishment status:", error);
      console.log(xhr.responseText);
    },
  });
});

// Reset modal and close when the cancel button is clicked
$("#confirmationModal .btn-secondary").on("click", function () {
  // Hide any error or success messages
  $("#successMessage").addClass("d-none");
  $("#errorMessage").addClass("d-none");

  setTimeout(function () {
    // Optionally, you can reload the page or update the table if necessary
    location.reload(); // or update the checkbox or table directly
  }, 500);
});

// Add an event listener to the title selector dropdown
document.getElementById("title").addEventListener("change", function () {
  const selectedOption = this.options[this.selectedIndex];

  if (selectedOption && selectedOption.value) {
    // Extract data from the selected option
    const planId = selectedOption.getAttribute("data-plan-id") || "";
    const amount = selectedOption.getAttribute("data-amount") || "";

    // Populate the modal fields
    document.getElementById("plan_id").value = planId;
    document.getElementById("amount").value = amount;
  } else {
    // Clear the fields if no title is selected
    document.getElementById("plan_id").value = "";
    document.getElementById("amount").value = "";
  }
});
// Handle Add purchase Form Submission
$("#addPurchaseForm").on("submit", function (event) {
  event.preventDefault(); // Prevent the form from submitting the default way

  $.ajax({
    url: "add_purchase.php",
    type: "POST",
    data: $(this).serialize(),
    success: function (response) {
      try {
        // Parse the JSON response (in case it's returned as a string)
        response = JSON.parse(response);

        if (response.success) {
          // Hide any existing error messages
          $("#addErrorMessage").addClass("d-none");

          // Show success message
          $("#addSuccessMessage").removeClass("d-none");

          // Close the modal after a short delay
          setTimeout(function () {
            $("#addPurchaseModal").modal("hide");

            // Reset the form and hide the success message
            $("#addPurchaseForm")[0].reset();
            $("#addSuccessMessage").addClass("d-none");

            // Reload the page to reflect the new purchase
            location.reload();
          }, 2000); // Adjust the delay as needed (2 seconds here)
        } else {
          // Hide any existing success messages
          $("#addSuccessMessage").addClass("d-none");

          // Show error messages
          $("#addErrorMessage").removeClass("d-none");
          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`;
          }
          $("#addErrorList").html(errorHtml);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error adding purchase:", error);
    },
  });
});

$(".edit-btn").on("click", function () {
  var purchaseId = $(this).data("id");
  console.log("Selected Purchase ID:", purchaseId);

  $.ajax({
    url: "get_purchase_details.php",
    type: "POST",
    data: { purchase_id: purchaseId },
    dataType: "json",
    success: function (response) {
      console.log("AJAX Response:", response); // Log response
      if (response.success) {
        $("#editPurchaseId").val(response.data.purchase_id);
        $("#editPurchaseTitle").val(response.data.title);
        $("#editPurchaseModal").modal("show");
      } else {
        console.error("Error fetching data:", response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error: ", error);
    },
  });
});

// Handle Edit Purchase Form Submission
$("#editPurchaseForm").on("submit", function (event) {
  event.preventDefault(); // Prevent default form submission

  $.ajax({
    url: "update_purchase.php", // PHP script for updating the purchase
    type: "POST",
    data: $(this).serialize(), // Serialize form data
    success: function (response) {
      try {
        // Parse the JSON response
        response = JSON.parse(response);
        console.log(response);

        if (response.success) {
          // Hide error messages if present
          $("#errorMessage2").addClass("d-none");

          // Show success message
          $("#successMessage2").removeClass("d-none").text(response.message);

          // Close the modal and reload the page
          setTimeout(function () {
            $("#editPurchaseModal").modal("hide"); // Hide modal
            $("#editPurchaseForm")[0].reset(); // Reset the form
            $("#successMessage2").addClass("d-none"); // Hide success message
            location.reload(); // Reload page
          }, 2000);
        } else {
          // Show validation errors
          $("#successMessage2").addClass("d-none"); // Hide success message
          $("#errorMessage2").removeClass("d-none"); // Show error messages

          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`; // Build error list
          }
          $("#errorList2").html(errorHtml); // Display errors
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error updating purchase:", error);
      console.log(xhr.responseText); // Log response for debugging
    },
  });
});

// Purchase delegation for dynamically loaded buttons (Archive)

$(document).on("click", ".archive-btn", function () {
  var purchaseId = $(this).data("id"); // Get purchase_id from the button

  // Debugging: Log the button and purchaseId
  console.log("Archive button clicked:", this);
  console.log("Extracted Purchase ID:", purchaseId);

  // Check if purchaseId exists
  if (purchaseId) {
    $("#archivePurchaseId").val(purchaseId); // Store the Purchase ID in the hidden input field
    $("#archiveModal").modal("show"); // Show the archive confirmation modal
  } else {
    console.error("Error: No purchase ID found on the archive button.");
  }
});

// Handle archive confirmation when "Archive" button in modal is clicked
$(document).on("click", "#confirmArchiveBtn", function () {
  var purchaseId = $("#archivePurchaseId").val(); // Get the Purchase ID from the hidden input field

  // Confirm purchase ID is set before AJAX
  if (!purchaseId) {
    console.error("Error: Purchase ID not set in hidden input field.");
    return;
  }

  // Send an AJAX request to archive the purchase
  $.ajax({
    url: "archive_purchase.php", // PHP file to handle archiving
    type: "POST",
    data: { purchase_id: purchaseId },
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
      console.error("Error archiving event:", error);
      console.log(xhr.responseText);
    },
  });
});
