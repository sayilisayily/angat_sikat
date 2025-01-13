document
  .getElementById("collaborator_na")
  .addEventListener("change", function () {
    const checkboxes = document.querySelectorAll(
      "#collaborators .form-check-input:not(#collaborator_na)"
    );
    checkboxes.forEach((cb) => (cb.checked = !this.checked));
  });

function addSpecificObjective() {
  const container = document.getElementById("specificObjectivesContainer");
  const newInput = `<div class="input-group mb-2">
            <input type="text" class="form-control" name="specific_objectives[]" placeholder="Specific Objective">
            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">-</button>
        </div>`;
  container.insertAdjacentHTML("beforeend", newInput);
}

function addImplementationPlan() {
  const container = document.getElementById("implementationPlanContainer");
  const newInput = `<div class="input-group mb-2">
            <input type="text" class="form-control" name="activities[]" placeholder="Activity">
            <input type="date" class="form-control" name="target_dates[]">
            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">-</button>
        </div>`;
  container.insertAdjacentHTML("beforeend", newInput);
}

function addGuideline() {
  const container = document.getElementById("implementingGuidelinesContainer");
  const newInput = `<div class="input-group mb-2">
            <input type="text" class="form-control" name="guidelines[]" placeholder="Guideline">
            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">-</button>
        </div>`;
  container.insertAdjacentHTML("beforeend", newInput);
}

document.addEventListener("DOMContentLoaded", () => {
  // Prefill the event start date when an event is selected
  document
    .getElementById("event_title")
    .addEventListener("change", function () {
      const selectedOption = this.options[this.selectedIndex];
      document.getElementById("event_start_date").value =
        selectedOption.getAttribute("data-start-date");
      document.getElementById("event_id").value =
        selectedOption.getAttribute("data-event-id");
    });
});

document.getElementById("event_title").addEventListener("change", function () {
  const selectedOption = this.options[this.selectedIndex];
  const eventId = selectedOption.getAttribute("data-event-id");

  // Set the event_start_date field
  document.getElementById("event_id").value = eventId || "";
});

document
  .getElementById("proposal_title")
  .addEventListener("change", function () {
    const selectedOption = this.options[this.selectedIndex];
    const eventId = selectedOption.getAttribute("data-event-id");

    // Set the event_start_date field
    document.getElementById("proposal_id").value = eventId || "";
  });

document.getElementById("permit_title").addEventListener("change", function () {
  const selectedOption = this.options[this.selectedIndex];
  const eventAmount = selectedOption.getAttribute("data-amount");
  const eventId = selectedOption.getAttribute("data-event-id");

  // Set the event_start_date field
  document.getElementById("total_amount").value = eventAmount || "";
  document.getElementById("permit_id").value = eventId || "";
});

document
  .getElementById("liquidation_title")
  .addEventListener("change", function () {
    const selectedOption = this.options[this.selectedIndex];
    const eventAmount = selectedOption.getAttribute("data-amount");
    const eventId = selectedOption.getAttribute("data-event-id");

    // Set the event_start_date field
    document.getElementById("liquidation_amount").value = eventAmount || "";
    document.getElementById("liquidation_id").value = eventId || "";
  });

document
  .getElementById("accomplishment_title")
  .addEventListener("change", function () {
    const selectedOption = this.options[this.selectedIndex];
    const eventVenue = selectedOption.getAttribute("data-venue");
    const eventStartDate = selectedOption.getAttribute("data-start-date");
    const eventId = selectedOption.getAttribute("data-event-id");

    // Set the event_start_date field
    document.getElementById("accomplishment_venue").value = eventVenue || "";
    document.getElementById("accomplishment_start_date").value =
      eventStartDate || "";
    document.getElementById("accomplishment_id").value = eventId || "";
  });
$(document).ready(function () {
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
