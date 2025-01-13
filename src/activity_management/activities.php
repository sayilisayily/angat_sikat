<?php
include 'connection.php';
include '../session_check.php'; 
include '../user_query.php';

// Check if user is logged in and has officer role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'officer') {
    header("Location: ../user/login.html");
    exit();
}

$sql = "SELECT * FROM events WHERE archived = 0 AND organization_id = $organization_id";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Activities Table</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon_sikat.png"/>
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <!--Custom CSS for Activities-->
    <link rel="stylesheet" href="css/activities.css" />
    <!--Boxicon-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Lordicon (for animated icons) -->
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <!--Bootstrap Script-->
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JavaScript for responsive components and modals -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JavaScript for table interactions and pagination -->
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap.min.css" />

    <style>
        #sidebar>div>div>span {
            color: #fff;
            font-size: 20px;
            position: absolute;
            margin-left: 80px;
        }

        #sidebarnav>li>a>span {
            color: #fff;
        }
        .body-wrapper {
            height: 100vh; /* Ensures the element has a height */
            overflow-x: hidden;  /* Hide horizontal overflow */
            overflow-y: auto;    /* Allow vertical scrolling when content overflows */
            background-color: white; /* Change this to match your design */
        }

        /* For webkit browsers (Chrome, Safari) */
        .body-wrapper::-webkit-scrollbar {
            width: 8px;  /* Set scrollbar width */
        }

        .body-wrapper::-webkit-scrollbar-track {
            background: transparent;  /* Track color */
        }

        .body-wrapper::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.5);  /* Thumb color */
            border-radius: 10px;  /* Rounded corners */
        }

        .body-wrapper::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.8);  /* Thumb color on hover */
        }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar" id="sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a class="text-nowrap logo-img">
                        <img src="../assets/images/logos/neon_sikat.png" alt="Angat Sikat Logo" class="logo contain"
                            style="width: 60px; height: auto;" />
                    </a>
                    <span class="logo-text">ANGATSIKAT</span>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="../dashboard/officer_dashboard.php" aria-expanded="false">
                                <i class="bx bxs-dashboard" style="color: #fff; font-size: 35px;"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <style>
                            .submenu {
                                display: none;
                                padding-left: 20px;
                                background-color: #00542F;
                            }

                            .submenu a {
                                display: block;
                                padding: 5px 10px;
                                text-decoration: none;
                                color: #fff;
                                background-color: #00542F;
                            }

                            .submenu a:hover {
                                background-color: #FFB000;
                            }

                            .sidebar-link {
                                position: relative;
                                cursor: pointer; /* Ensure pointer cursor for better UX */
                            }

                            .sidebar-link:hover {
                                background-color: #FFB000; /* Hover color */
                            }

                            .sidebar-link.active {
                                background-color: #FFB000; /* Active color */
                            }
                            .scroll-sidebar {
                                overflow: auto; /* Enable scrolling */
                            }

                            /* Hide scrollbar for WebKit browsers (Chrome, Safari) */
                            .scroll-sidebar::-webkit-scrollbar {
                                display: none; /* Hide scrollbar */
                            }

                            /* Hide scrollbar for IE, Edge, and Firefox */
                            .scroll-sidebar {
                                -ms-overflow-style: none; /* IE and Edge */
                                scrollbar-width: none; /* Firefox */
                            }
                        </style>

                        <script>
                            document.querySelectorAll('.sidebar-link').forEach(link => {
                                link.addEventListener('click', function() {
                                    // Remove 'active' class from all links
                                    document.querySelectorAll('.sidebar-link').forEach(item => {
                                        item.classList.remove('active');
                                    });

                                    // Add 'active' class to the clicked link
                                    this.classList.add('active');
                                });
                            });

                            function toggleSubmenu(event) {
                                event.preventDefault();
                                const submenus = document.querySelectorAll('.submenu');
                                const currentSubmenu = event.currentTarget.nextElementSibling;

                                // Close all submenus
                                submenus.forEach(submenu => {
                                    if (submenu !== currentSubmenu) {
                                        submenu.style.display = "none";
                                    }
                                });

                                // Toggle the current submenu
                                currentSubmenu.style.display = (currentSubmenu.style.display === "block") ? "none" : "block";
                            }

                            function closeSubmenus() {
                                const submenus = document.querySelectorAll('.submenu');
                                submenus.forEach(submenu => {
                                    submenu.style.display = "none"; // Close all submenus
                                });
                            }
                        </script>
                    </style>

                        <ul id="sidebarnav">
                            <li class="sidebar-item">
                                <a class="sidebar-link" aria-expanded="false" data-tooltip="Budget"
                                    onclick="toggleSubmenu(event)">
                                    <i class="bx bx-wallet" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">Budget</span>
                                </a>
                                <div class="submenu">
                                    <a href="../budget_management/budget_overview.php">Overview</a>
                                    <a href="../budget_management/financial_plan.php">Plan</a>
                                </div>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../budget_management/purchases/purchases.php" aria-expanded="false">
                                    <i class="bx bxs-purchase-tag" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">Purchases</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../budget_management/maintenance/maintenance.php" aria-expanded="false">
                                    <i class="bx bxs-cog" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">MOE</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../activity_management/activities.php" aria-expanded="false"
                                    data-tooltip="Manage Events">
                                    <i class="bx bx-calendar-event" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">Activities</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../activity_management/calendar.php" aria-expanded="false"
                                    data-tooltip="Manage Events">
                                    <i class="bx bx-calendar" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">Calendar</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../budget_management/budget_approval_table.php" aria-expanded="false"
                                    data-tooltip="Manage Events">
                                    <i class="bx bx-book-content" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">Approval</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" aria-expanded="false" data-tooltip="Income & Expenses"
                                    onclick="toggleSubmenu(event)">
                                    <i class="bx bx-dollar-circle" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">Transactions</span>
                                </a>
                                <div class="submenu">
                                    <a href="../income_and_expenses/income.php" onclick="closeSubmenus()">Income</a>
                                    <a href="../income_and_expenses/expenses.php" onclick="closeSubmenus()">Expenses</a>
                                </div>
                            </li>
                        </ul>

                        <script>
                            function toggleSubmenu(event) {
                                event.preventDefault();
                                const submenus = document.querySelectorAll('.submenu');
                                const currentSubmenu = event.currentTarget.nextElementSibling;

                                // Close all submenus
                                submenus.forEach(submenu => {
                                    if (submenu !== currentSubmenu) {
                                        submenu.style.display = "none";
                                    }
                                });

                                // Toggle the current submenu
                                currentSubmenu.style.display = (currentSubmenu.style.display === "block") ? "none" : "block";
                            }

                            function closeSubmenus() {
                                const submenus = document.querySelectorAll('.submenu');
                                submenus.forEach(submenu => {
                                    submenu.style.display = "none"; // Close all submenus
                                });
                            }
                        </script>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="../reports/reports.php" aria-expanded="false"
                                data-tooltip="Manage Events">
                                <i class="bx bx-bar-chart-alt-2" style="color: #fff; font-size: 35px;"></i>
                                <span class="hide-menu">Reports</span>
                            </a>
                        </li>

                        <li class="sidebar-item profile-container">
                            <a class="sidebar-link" href="../user/profile.php" aria-expanded="false"
                                data-tooltip="Profile" style="display: flex; align-items: center; padding: 0.5rem;">
                                <div class="profile-pic-border"
                                    style="height: 4rem; width: 4rem; display: flex; justify-content: center; align-items: center; overflow: hidden; border-radius: 50%; border: 2px solid #ccc;">
                                    <img src="<?php echo !empty($profile_picture) ? '../user/' . htmlspecialchars($profile_picture) : '../user/uploads/default.png'; ?>"
                                        alt="Profile Picture" class="profile-pic"
                                        style="height: 100%; width: 100%; object-fit: cover;" />
                                </div>
                                <span class="profile-name" style="margin-left: 0.5rem; font-size: 0.9rem;">
                                    <?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?>
                                </span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- Sidebar End -->

        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item">
                                <!-- Notification Icon -->
                                <div style="position: relative; display: inline-block;">
                                    <button id="notificationBtn" style="background-color: transparent; border: none; padding: 0;">
                                        <lord-icon src="https://cdn.lordicon.com/lznlxwtc.json" trigger="hover" 
                                            colors="primary:#004024" style="width:30px; height:30px;">
                                        </lord-icon>
                                        <!-- Notification Count Badge -->
                                        <span id="notificationCount" style="position: absolute; top: -5px; right: -5px; 
                                            background-color: red; color: white; font-size: 12px; padding: 2px 6px; 
                                            border-radius: 50%; display: none;">0</span>
                                    </button>

                                    <!-- Notification Dropdown -->
                                    <div id="notificationDropdown" class="dropdown-menu p-2 shadow" 
                                        style="display: none; position: absolute; right: 0; top: 35px; width: 300px; max-height: 400px; 
                                        overflow-y: auto; background-color: white; border-radius: 5px; z-index: 1000;">
                                        <p style="margin: 0; font-weight: bold; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                                            Notifications
                                        </p>
                                        <div id="notificationList">
                                            <!-- Notifications will be dynamically loaded here -->
                                        </div>
                                        <p id="noNotifications" style="text-align: center; margin-top: 10px; color: gray; display: none;">
                                            No new notifications
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <!-- Profile Dropdown -->
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle d-flex align-items-center"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
                                        <img class="border border-dark rounded-circle"
                                            src="<?php echo !empty($profile_picture) ? '../user/' . $profile_picture : '../user/uploads/default.png'; ?>"
                                            alt="Profile"
                                            style="width: 40px; height: 40px; margin-left: 10px; object-fit: cover;">
                                        <span class="visually-hidden">
                                            <?php echo htmlspecialchars($user['username']); ?>
                                        </span>
                                        <div class="d-flex flex-column align-items-start ms-2">
                                            <span style="font-weight: bold; color: #004024;">
                                                <?php echo htmlspecialchars($fullname); ?>
                                            </span>
                                            <span style="font-size: 0.85em; color: #6c757d;">
                                                <?php echo htmlspecialchars($email); ?>
                                            </span>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="../user/profile.php"><i
                                                    class="bx bx-user"></i> My Profile</a>
                                        </li>
                                        <li><a class="dropdown-item" href="../user/logout.php"><i
                                                    class="bx bx-log-out"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
       

            <div class="container mt-5 p-5">
                <h2 class="mb-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-warning fw-bold me-2">|</span> Activities
                        <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addEventModal"
                        style="height: 40px; width: 200px; border-radius: 8px; font-size: 12px;">
                            <i class="fa-solid fa-plus"></i> Add Activity
                        </button>
                    </div>
                    <a href="activities_archive.php" class="text-gray text-decoration-none fw-bold" 
                            style="font-size: 14px;">
                                View Archive
                    </a>
                </h2>
                <table id="eventsTable" class="table">
                    <thead>
                        <tr>
                            <th rowspan=2>Title</th>
                            <th rowspan=2>Venue</th>
                            <th colspan=2 style="text-align: center;"> Date </th>
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
                                        <td>" . date('F j, Y', strtotime($row['event_start_date'])) . "</td>
                                        <td>" . date('F j, Y', strtotime($row['event_end_date'])) . "</td>
                                        <td>{$row['event_type']}</td>
                                        <td>";
                                        if ($row['event_status'] == 'Pending') {
                                            echo " <span class='badge rounded-pill pending'> ";
                                        } elseif ($row['event_status'] == 'Approved') {
                                            echo " <span class='badge rounded-pill approved'> ";
                                        } elseif ($row['event_status'] == 'Disapproved') {
                                            echo " <span class='badge rounded-pill disapproved'> ";
                                        }
                                        echo "
                                            {$row['event_status']}
                                            </span>
                                            </td>
                                            <td>
                                                <input type='checkbox' 
                                                class='form-check-input' 
                                                onclick='showConfirmationModal({$row['event_id']}, this.checked)' 
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
                </div>
            </div>

            <!-- Confirmation Modal -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Confirm Accomplishment Status Change</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to change the accomplishment status of this event?
                            <!-- Success Message Alert -->
                            <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
                                Status updated successfully!
                            </div>
                            <!-- Error Message Alert -->
                            <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert">
                                <ul id="errorList"></ul> <!-- List for showing validation errors -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirmUpdateBtn">Confirm</button>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Add Event Modal -->
            <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
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
                                        <!-- Plan ID -->
                                        <input type="hidden" id="plan_id" name="plan_id">
                                        <!-- Event title dropdown -->
                                        <select class="form-control" id="title" name="title">
                                            <option value="">Select Event Title</option>
                                            <?php
                                            // Query to fetch titles with category 'Activities'
                                            $title_query = "SELECT plan_id, title, date, type, amount FROM financial_plan WHERE category = 'Activities' AND organization_id = $organization_id OR type = 'Income' AND organization_id = $organization_id";
                                            $result = mysqli_query($conn, $title_query);

                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . htmlspecialchars($row['title']) . '" 
                                                            data-plan-id="' . htmlspecialchars($row['plan_id']) . '"
                                                            data-date="' . htmlspecialchars($row['date']) . '" 
                                                            data-amount="' . htmlspecialchars($row['amount']) . '" 
                                                            data-type="' . htmlspecialchars($row['type']) . '">' 
                                                            . htmlspecialchars($row['title']) . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No titles available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="venue">Venue</label>
                                        <input type="text" class="form-control" id="venue" name="venue">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <div class="col">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" readonly>
                                    </div>
                                    <div class="col">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <div class="col">
                                        <label for="type">Event Type</label>
                                        <input type="text" class="form-control" id="type" name="type" readonly>                                 
                                    </div>
                                    <div class="col">
                                        <label for="amount">Event Total Amount</label>
                                        <input type="text" class="form-control" id="amount" name="amount" readonly>                                 
                                    </div>
                                </div>

                                <!-- Success Message Alert -->
                                <div id="successMessage1" class="alert alert-success d-none mt-3" role="alert">
                                    Event added successfully!
                                </div>
                                <!-- Error Message Alert -->
                                <div id="errorMessage1" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="errorList1"></ul> <!-- List for showing validation errors -->
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
            <div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="editEventForm">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Hidden field for event ID -->
                                <input type="hidden" id="editEventId" name="event_id">

                                <!-- Other form fields -->
                                <div class="form-group row mb-2">
                                    <div class="col">
                                        <label for="editEventTitle">Event Title</label>
                                        <input type="text" class="form-control" id="editEventTitle" name="title" required>
                                    </div>
                                    <div class="col">
                                        <label for="editEventVenue">Event Venue</label>
                                        <input type="text" class="form-control" id="editEventVenue" name="event_venue" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <div class="col">
                                        <label for="editEventStartDate">Start Date</label>
                                        <input type="date" class="form-control" id="editEventStartDate" name="event_start_date"
                                            required>
                                    </div>
                                    <div class="col">
                                        <label for="editEventEndDate">End Date</label>
                                        <input type="date" class="form-control" id="editEventEndDate" name="event_end_date"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <div class="col">
                                        <label for="editEventType">Event Type</label>
                                        <input class="form-control" id="editEventType" name="event_type" readonly>
                                    </div>
                                </div>
                                <input type="hidden" id="editEventStatus" name="event_status">
                                <input type="hidden" id="editAccomplishmentStatus" name="accomplishment_status">

                                <!-- Success Message Alert -->
                                <div id="successMessage2" class="alert alert-success d-none mt-3" role="alert">
                                    Event updated successfully!
                                </div>
                                <!-- Error Message Alert -->
                                <div id="errorMessage2" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="errorList2"></ul> <!-- List for showing validation errors -->
                                </div>
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
                            <!-- Success Message Alert -->
                            <div id="successMessage3" class="alert alert-success d-none mt-3" role="alert">
                                    Event archived successfully!
                                </div>
                                <!-- Error Message Alert -->
                                <div id="errorMessage3" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="errorList3"></ul> <!-- List for showing validation errors -->
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" id="confirmArchiveBtn" class="btn btn-danger">Archive</button>
                        </div>
                    </div>
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