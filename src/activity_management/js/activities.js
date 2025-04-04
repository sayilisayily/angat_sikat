$(document).ready(function () {
  $("#eventsTable").DataTable({
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

// Add an event listener to the title selector dropdown
document.getElementById("title").addEventListener("change", function () {
  const selectedOption = this.options[this.selectedIndex];

  if (selectedOption && selectedOption.value) {
    // Extract data from the selected option
    const id = selectedOption.getAttribute("data-id") || "";

    // Populate the modal fields
    document.getElementById("id").value = id;
  } else {
    // Clear the fields if no title is selected
    document.getElementById("id").value = "";
  }
});

// Function to set min date to today
function restrictPastDates(inputId) {
  let today = new Date().toISOString().split("T")[0];
  document.getElementById(inputId).setAttribute("min", today);
}

// Apply restrictions to Add Event modal fields
restrictPastDates("start_date");
restrictPastDates("end_date");

// Apply restrictions to Edit Event modal fields
restrictPastDates("editEventStartDate");
restrictPastDates("editEventEndDate");

// Ensure the restriction is applied when the modals are opened
document
  .getElementById("addEventModal")
  .addEventListener("shown.bs.modal", function () {
    restrictPastDates("start_date");
    restrictPastDates("end_date");
  });

document
  .getElementById("editEventModal")
  .addEventListener("shown.bs.modal", function () {
    restrictPastDates("editEventStartDate");
    restrictPastDates("editEventEndDate");
  });

// Ensure End Date cannot be earlier than Start Date
function validateEndDate(startDateId, endDateId) {
  document.getElementById(startDateId).addEventListener("change", function () {
    let startDate = this.value;
    document.getElementById(endDateId).setAttribute("min", startDate);
  });
}

// Apply validation for Add Event modal
validateEndDate("start_date", "end_date");

// Apply validation for Edit Event modal
validateEndDate("editEventStartDate", "editEventEndDate");

// Global variables to store event details
let eventIdToUpdate;
let newStatus;

// Show the first confirmation modal
function showConfirmationModal(eventId, isChecked) {
  eventIdToUpdate = eventId; // Store the event ID
  newStatus = isChecked ? 1 : 0; // Store the new accomplishment status

  // Show the first confirmation modal
  $("#confirmationModal").modal("show");
}

// Handle first confirmation
$("#confirmUpdateBtn").on("click", function () {
  // Close the first modal
  $("#confirmationModal").modal("hide");

  // Open the final confirmation modal
  setTimeout(() => {
    $("#doubleConfirmModal").modal("show");
  }, 300);
});

// Handle final confirmation
$("#doubleConfirmBtn").on("click", function () {
  // Send an AJAX request to update the accomplishment status
  $.ajax({
    url: "update_accomplishment.php", // PHP file to handle status update
    type: "POST",
    data: {
      event_id: eventIdToUpdate,
      accomplishment_status: newStatus,
    },
    dataType: "json",
    success: function (response) {
      try {
        if (response.success) {
          // Show success message
          $("#successMessage").removeClass("d-none").text(response.message);
          $("#errorMessage").addClass("d-none");

          // Close the final confirmation modal and reload page
          setTimeout(function () {
            $("#doubleConfirmModal").modal("hide");
            location.reload();
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

  // Close final modal after confirmation
  $("#doubleConfirmModal").modal("hide");
});

// Add an event listener to the title selector dropdown
document.getElementById("title").addEventListener("change", function () {
  const selectedOption = this.options[this.selectedIndex];

  if (selectedOption && selectedOption.value) {
    // Extract data from the selected option
    const planId = selectedOption.getAttribute("data-plan-id") || "";
    const startDate = selectedOption.getAttribute("data-date") || "";
    const type = selectedOption.getAttribute("data-type") || "";
    const amount = selectedOption.getAttribute("data-amount") || "";

    // Populate the modal fields
    document.getElementById("plan_id").value = planId;
    document.getElementById("start_date").value = startDate;
    document.getElementById("type").value = type;
    document.getElementById("amount").value = amount;
  } else {
    // Clear the fields if no title is selected
    document.getElementById("plan_id").value = "";
    document.getElementById("start_date").value = "";
    document.getElementById("type").value = "";
    document.getElementById("amount").value = "";
  }
});

// Handle Add Event Form Submission
$("#addEventForm").on("submit", function (event) {
  event.preventDefault();

  $.ajax({
    url: "add_event.php",
    type: "POST",
    data: $(this).serialize(),
    success: function (response) {
      try {
        // Parse the JSON response (in case it's returned as a string)
        response = JSON.parse(response);
        console.log(response);

        if (response.success) {
          // Hide any existing error messages
          $("#errorMessage1").addClass("d-none");

          // Show success message
          $("#successMessage1").removeClass("d-none");

          // Close the modal after a short delay
          setTimeout(function () {
            $("#addEventModal").modal("hide");

            // Reset the form and hide the success message
            $("#addEventForm")[0].reset();
            $("#successMessage1").addClass("d-none");

            // Reload the page to reflect the new event
            location.reload();
          }, 2000); // Adjust the delay as needed (2 seconds here)
        } else {
          // Hide any existing success messages
          $("#successMessage1").addClass("d-none");

          // Show error messages
          $("#errorMessage1").removeClass("d-none");
          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`;
          }
          $("#errorList1").html(errorHtml);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error adding event:", error);
    },
  });
});

$(".edit-btn").on("click", function () {
  var eventId = $(this).data("id"); // Get event_id from the button
  console.log("Selected Event ID:", eventId); // Log the event ID for debugging

  // Send an AJAX request to fetch the event details using the event ID
  $.ajax({
    url: "get_event_details.php", // PHP file to fetch event data
    type: "POST",
    data: { event_id: eventId },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        // Populate the form with event data
        $("#editEventId").val(response.data.event_id); // Hidden field for event ID
        $("#editEventTitle").val(response.data.title);
        $("#editEventVenue").val(response.data.event_venue);
        $("#editEventStartDate").val(response.data.event_start_date);
        $("#editEventEndDate").val(response.data.event_end_date);
        $("#editEventType").val(response.data.event_type);

        // Show the modal
        $("#editEventModal").modal("show");
      } else {
        console.log("Error fetching data: ", response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error: ", error);
    },
  });
});

// Handle Edit Event Form Submission
$("#editEventForm").on("submit", function (event) {
  event.preventDefault();

  $.ajax({
    url: "update_event.php",
    type: "POST",
    data: $(this).serialize(),
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
            $("#editEventModal").modal("hide");

            // Reset the form and hide the success message
            $("#editEventForm")[0].reset();
            $("#successMessage2").addClass("d-none");
            location.reload();
          }, 2000);
        } else {
          // Show validation errors
          $("#successMessage2").addClass("d-none");

          $("#errorMessage2").removeClass("d-none");
          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`;
          }
          $("#errorList2").html(errorHtml);
        }
      } catch (error) {
        console.error("Error parsing JSON:", error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error updating event:", error);
      console.log(xhr.responseText);
    },
  });
});

// Event delegation for dynamically loaded buttons (Archive)
$(document).on("click", ".archive-btn", function () {
  var eventId = $(this).data("id"); // Get event_id from the button
  $("#archiveEventId").val(eventId); // Store the event ID in the hidden input field
  $("#archiveModal").modal("show"); // Show the archive confirmation modal
  console.log("Selected Event ID: " + eventId);
});

// Handle archive confirmation when "Archive" button in modal is clicked
$("#confirmArchiveBtn").on("click", function () {
  var eventId = $("#archiveEventId").val(); // Get the event ID from the hidden input field

  // Send an AJAX request to archive the event
  $.ajax({
    url: "archive_event.php", // PHP file to handle archiving
    type: "POST",
    data: { event_id: eventId },
    dataType: "json",
    success: function (response) {
      try {
        if (response.success) {
          // Show success message (optional)
          console.log(response.message);
          // Hide any existing error messages
          $("#errorMessage3").addClass("d-none");

          // Show success message
          $("#successMessage3").removeClass("d-none");

          // Close the modal after a short delay
          setTimeout(function () {
            $("#archiveModal").modal("hide");
            $("#successMessage3").addClass("d-none");
            location.reload();
          }, 2000);
        } else {
          // Show validation errors
          $("#successMessage3").addClass("d-none");

          $("#errorMessage3").removeClass("d-none");
          let errorHtml = "";
          for (let field in response.errors) {
            errorHtml += `<li>${response.errors[field]}</li>`;
          }
          $("#errorList3").html(errorHtml);
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
