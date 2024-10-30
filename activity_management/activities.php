<?php
include 'connection.php';

$sql = "SELECT * FROM events WHERE archived = 0 and organization_id = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include '../head.php'; ?>
        <title> Events Table </title>
    </head>
<body>

<div class="container mt-5 p-5">
    <h2 class="mb-4">Activities 
        <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addEventModal">
            <i class="fa-solid fa-plus"></i> Add Activity
        </button>
    </h2>
    <table id="eventsTable" class="table">
        <thead>
            <tr>
                <th rowspan=2>Title</th>
                <th rowspan=2>Venue</th>
                <th colspan=2> Date </th>
                <th rowspan=2>Type</th>
                <th rowspan=2>Status</th>
                <th rowspan=2>Accomplished</th>
                <th rowspan=2>Actions</th>
            </tr>
            <tr>
              <th>Start</th>
              <th>End</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $checked = $row['accomplishment_status'] ? 'checked' : '';
                    $disabled = ($row['event_status'] !== 'Approved') ? 'disabled' : '';
                    echo "<tr>
                            <td><a class='link-offset-2 link-underline link-underline-opacity-0' href='event_details.php?event_id={$row['event_id']}'>{$row['title']}</a></td>
                            <td>{$row['event_venue']}</td>
                            <td>{$row['event_start_date']}</td>
                            <td>{$row['event_end_date']}</td>
                            <td>{$row['event_type']}</td>
                            <td>";
                              if ($row['event_status'] == 'Pending') {
                                echo " <span class='badge rounded-pill pending'> ";
                              } else if ($row['event_status'] == 'Approved') {
                                echo " <span class='badge rounded-pill approved'> ";
                              } else if ($row['event_status'] == 'Disapproved') {
                                echo " <span class='badge rounded-pill disapproved'> ";
                              }
                              echo "
                              {$row['event_status']}
                              </span>
                            </td>
                            <td>
                                <input type='checkbox' 
                                       class='form-check-input' 
                                       onclick='toggleAccomplishment({$row['event_id']}, this.checked)' 
                                       $checked 
                                       $disabled>
                            </td>
                            <td>
                                <button class='btn btn-primary btn-sm edit-btn mb-3' 
                                        data-bs-toggle='modal' 
                                        data-bs-target='#editEventModal' 
                                        data-id='{$row['event_id']}'>
                                    <i class='fa-solid fa-pen'></i> Edit
                                </button>
                                <button class='btn btn-danger btn-sm archive-btn mb-3' 
                                        data-id='{$row['event_id']}'>
                                    <i class='fa-solid fa-box-archive'></i> Archive
                                </button>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center'>No events found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="addEventForm">
        <div class="modal-header">
          <h5 class="modal-title" id="addEventLabel">Add New Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Form fields -->
          <div class="form-group row mb-2">
            <div class="col">
              <label for="title">Event Title</label>
              <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="col">
              <label for="venue">Venue</label>
              <input type="text" class="form-control" id="venue" name="venue">
            </div>
          </div>
          <div class="form-group row mb-2">
            <div class="col">
              <label for="start_date">Start Date</label>
              <input type="date" class="form-control" id="start_date" name="start_date">
            </div>
            <div class="col">
              <label for="end_date">End Date</label>
              <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
          </div>
          <div class="form-group row mb-2">
            <div class="col">
              <label for="type">Event Type</label>
              <select class="form-control" id="type" name="type">
                <option value="Income">Income</option>
                <option value="Expense">Expense</option>
              </select>
            </div>
          </div>

          <!-- Success Message Alert -->
          <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
                Event added successfully!
          </div>  
          <!-- Error Message Alert -->
          <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert">
              <ul id="errorList"></ul> <!-- List for showing validation errors -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Event</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="editEventForm" action="update_event.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Hidden field for event ID -->
          <input type="hidden" id="editEventId" name="event_id">

          <!-- Other form fields -->
          <div class="form-group">
            <label for="editEventTitle">Event Title</label>
            <input type="text" class="form-control" id="editEventTitle" name="title" required>
          </div>
          <div class="form-group">
            <label for="editEventVenue">Event Venue</label>
            <input type="text" class="form-control" id="editEventVenue" name="event_venue" required>
          </div>
          <div class="form-group">
            <label for="editEventStartDate">Start Date</label>
            <input type="date" class="form-control" id="editEventStartDate" name="event_start_date" required>
          </div>
          <div class="form-group">
            <label for="editEventEndDate">End Date</label>
            <input type="date" class="form-control" id="editEventEndDate" name="event_end_date" required>
          </div>
          <div class="form-group">
            <label for="editEventType">Event Type</label>
            <select class="form-control" id="editEventType" name="event_type" required>
              <option value="Income">Income</option>
              <option value="Expense">Expense</option>
            </select>
          </div>
          <input type="hidden" id="editEventStatus" name="event_status">
          <input type="hidden" id="editAccomplishmentStatus" name="accomplishment_status">
        </div>
        <!-- Success Message Alert -->
        <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
          Event updated successfully!
        </div>  
        <!-- Error Message Alert -->
        <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert">
          <ul id="errorList"></ul> <!-- List for showing validation errors -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Archive Confirmation Modal -->
<div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="archiveModalLabel">Archive Event</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  Are you sure you want to archive this event?
                  <input type="hidden" id="archiveEventId">
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" id="confirmArchiveBtn" class="btn btn-danger">Archive</button>
              </div>
          </div>
      </div>
  </div>
  
<!-- BackEnd -->
<script src="js/activities.js"></script>
</body>
</html>

<?php
$conn->close();
?>
