$(document).ready(function () {
  $("#archivePurchasesTable").DataTable({
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

$(document).on("click", ".recover-btn", function () {
  var purchaseId = $(this).data("id"); // Get the purchase_id from the button's data-id attribute
  $("#recover_purchase_id").val(purchaseId); // Set the value of the hidden input
});

$(document).on("click", ".delete-btn", function () {
  var purchaseId = $(this).data("id"); // Get the purchase_id from the button's data-id attribute
  $("#delete_purchase_id").val(purchaseId); // Set the value of the hidden input
});

$("#confirmRecoverBtn").on("click", function () {
  var purchaseId = $("#recover_purchase_id").val(); // Get the item ID from the hidden input field

  // Send an AJAX request to delete the item
  $.ajax({
    url: "recover_purchase.php", // PHP file to handle deletion
    type: "POST",
    data: { purchase_id: purchaseId },
    dataType: "json",
    success: function (response) {
      try {
        if (response.success) {
          // Show success message (optional)
          console.log(response.message);

          // Hide any existing error messages
          $("#recoverErrorMessage").addClass("d-none");

          // Show success message
          $("#recoverSuccessMessage")
            .removeClass("d-none")
            .text(response.message);

          // Close the modal after a short delay
          setTimeout(function () {
            $("#recoverModal").modal("hide");

            // Reset the form and hide the success message
            $("#recoverSuccessMessage").addClass("d-none");
            location.reload();
          }, 2000);
        } else {
          // Show validation errors
          $("#recoverSuccessMessage").addClass("d-none");

          $("#recoverErrorMessage").removeClass("d-none");
          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`;
          }
          $("#recoverErrorList").html(errorHtml);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error deleting item:", error);
      console.log(xhr.responseText);
    },
  });
});

$("#confirmDeleteBtn").on("click", function () {
  var purchaseId = $("#delete_purchase_id").val(); // Get the item ID from the hidden input field

  // Send an AJAX request to delete the item
  $.ajax({
    url: "delete_purchase.php", // PHP file to handle deletion
    type: "POST",
    data: { purchase_id: purchaseId },
    dataType: "json",
    success: function (response) {
      try {
        if (response.success) {
          // Show success message (optional)
          console.log(response.message);

          // Hide any existing error messages
          $("#deleteErrorMessage").addClass("d-none");

          // Show success message
          $("#deleteSuccessMessage")
            .removeClass("d-none")
            .text(response.message);

          // Close the modal after a short delay
          setTimeout(function () {
            $("#deleteModal").modal("hide");

            // Reset the form and hide the success message
            $("#deleteSuccessMessage").addClass("d-none");
            location.reload();
          }, 2000);
        } else {
          // Show validation errors
          $("#deleteSuccessMessage").addClass("d-none");

          $("#deleteErrorMessage").removeClass("d-none");
          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`;
          }
          $("#deleteErrorList").html(errorHtml);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error deleting item:", error);
      console.log(xhr.responseText);
    },
  });
});
