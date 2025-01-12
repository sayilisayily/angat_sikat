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
