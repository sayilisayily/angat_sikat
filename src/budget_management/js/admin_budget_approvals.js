$(document).ready(function () {
  $("#approvalsTable").DataTable({
    paging: true,
    searching: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    ordering: true,
    order: [],
  });
});

// JavaScript to handle the modal data population
document.addEventListener("DOMContentLoaded", function () {
  const confirmationModal = document.getElementById("confirmationModal");
  const confirmIdInput = document.getElementById("confirmId");
  const confirmActionInput = document.getElementById("confirmAction");
  const confirmDisapprovalReason = document.getElementById(
    "confirmDisapprovalReason"
  );
  const actionText = document.getElementById("actionText");
  const reasonContainer = document.getElementById("reasonContainer");
  const disapprovalReasonInput = document.getElementById("disapprovalReason");

  confirmationModal.addEventListener("show.bs.modal", function (event) {
    const button = event.relatedTarget;
    const action = button.getAttribute("data-action");
    const id = button.getAttribute("data-id");

    confirmIdInput.value = id;
    confirmActionInput.value = action;
    actionText.textContent = action === "approve" ? "approve" : "disapprove";

    // Show or hide reason input based on action
    if (action === "disapprove") {
      reasonContainer.classList.remove("d-none");
    } else {
      reasonContainer.classList.add("d-none");
      disapprovalReasonInput.value = ""; // Clear the field when not used
    }
  });

  // Handle confirmation form submission
  $("#confirmationForm").on("submit", function (e) {
    e.preventDefault();

    var formData = $(this).serialize(); // Serialize the form data
    var actionType = $("#confirmAction").val(); // Get action type

    // Add disapproval reason if applicable
    if (actionType === "disapprove") {
      var disapprovalReason = $("#disapprovalReason").val().trim(); // Get textarea value

      if (!disapprovalReason) {
        alert("Please provide a reason for disapproval."); // Ensure reason is not empty
        return;
      }

      // Append disapproval reason to form data
      formData +=
        "&disapproval_reason=" + encodeURIComponent(disapprovalReason);
    }

    // AJAX request to process approval/disapproval
    $.ajax({
      url: "update_approval_status.php",
      type: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        try {
          if (response.success) {
            $("#successMessage")
              .removeClass("d-none")
              .text(
                actionType === "approve"
                  ? "Request successfully approved."
                  : "Request has been disapproved."
              );

            $("#errorMessage").addClass("d-none");

            // Refresh notifications immediately
            loadNotifications();

            // Close modal and reload page
            setTimeout(function () {
              $("#confirmationModal").modal("hide");
              $("#successMessage").addClass("d-none");
              location.reload();
            }, 2000);
          } else {
            // Display validation errors
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
        console.error("Error processing approval/disapproval:", error);
        console.log(xhr.responseText);
      },
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
});
