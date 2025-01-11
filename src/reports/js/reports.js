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
    const eventStartDate = selectedOption.getAttribute("data-start-date");
    const eventId = selectedOption.getAttribute("data-event-id");
    const eventVenue = selectedOption.getAttribute("data-venue");

    // Set the event_start_date field
    document.getElementById("proposal_start_date").value = eventStartDate || "";
    document.getElementById("proposal_id").value = eventId || "";
    document.getElementById("proposal_venue").value = eventVenue || "";
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
