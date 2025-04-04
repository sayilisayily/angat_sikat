<?php
include '../connection.php';
include '../session_check.php'; 
include '../user_query.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Archive Legend Table</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/angatsikat.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <!--Custom CSS for Sidebar-->
    <link rel="stylesheet" href="../html/sidebar.css" />
    <!--Custom CSS for Budget Overview-->
    <link rel="stylesheet" href="../activity_management/css/activities.css" />
    <!--Boxicon-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Lordicon (for animated icons) -->
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <!-- Selectize -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
        integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
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
                        <img src="../assets/images/logos/angatsikat.png" alt="Angat Sikat Logo" class="logo contain"
                            style="width: 45px; height: auto;" />
                            <span class="logo-text">ANGATSIKAT</span>
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>

                <style>
                    .logo-text {
                        font-size: 23px; /* Adjust font size */
                        color: #fff; /* Set text color */
                        font-weight: bold; /* Make text bold */
                        text-transform: uppercase; /* Transform text to uppercase */
                        margin-left: 10px;
                    }
                </style>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="../dashboard/admin_dashboard.php" aria-expanded="false">
                                <i class="bx bxs-dashboard" style="color: #fff; font-size: 35px;"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="../archive/archive_legend.php" aria-expanded="false">
                                <i class="bx bxs-archive" style="color: #fff; font-size: 35px;"></i>
                                <span class="hide-menu">Archive Legend</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="../activity_management/admin_calendar.php" aria-expanded="false"
                                data-tooltip="Manage Events">
                                <i class="bx bx-calendar" style="color: #fff; font-size: 35px;"></i>
                                <span class="hide-menu">Calendar</span>
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
                                cursor: pointer;
                                /* Ensure pointer cursor for better UX */
                            }

                            .sidebar-link:hover {
                                background-color: #FFB000;
                                /* Hover color */
                            }

                            .sidebar-link.active {
                                background-color: #FFB000;
                                /* Active color */
                            }

                            .scroll-sidebar {
                                overflow: auto;
                                /* Enable scrolling */
                            }

                            /* Hide scrollbar for WebKit browsers (Chrome, Safari) */
                            .scroll-sidebar::-webkit-scrollbar {
                                display: none;
                                /* Hide scrollbar */
                            }

                            /* Hide scrollbar for IE, Edge, and Firefox */
                            .scroll-sidebar {
                                -ms-overflow-style: none;
                                /* IE and Edge */
                                scrollbar-width: none;
                                /* Firefox */
                            }
                        </style>

                        <script>
                            document.querySelectorAll('.sidebar-link').forEach(link => {
                                link.addEventListener('click', function () {
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

                        <li class="sidebar-item">
                            <a class="sidebar-link" aria-expanded="false" data-tooltip="Budget"
                                onclick="toggleSubmenu(event)">
                                <i class="bx bx-file-find" style="color: #fff; font-size: 35px;"></i>
                                <span class="hide-menu">Audit Logs</span>
                            </a>
                            <div class="submenu">
                                <a href="../audit_logs/account_logs.php">Account Logs</a>
                                <a href="../audit_logs/balance_logs.php">Balance Logs</a>
                            </div>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="../user_management/users.php" aria-expanded="false"
                                data-tooltip="Users">
                                <i class="bx bx-user" style="color: #fff; font-size: 35px;"></i>
                                <span class="hide-menu">Users</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="../organization_management/organizations.php"
                                aria-expanded="false" data-tooltip="Organizations">
                                <i class="bx bx-group" style="color: #fff; font-size: 35px;"></i>
                                <span class="hide-menu">Organizations</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="../adviser_management/advisers.php" aria-expanded="false"
                                data-tooltip="Events">
                                <i class="bx bx-user-pin" style="color: #fff; font-size: 35px;"></i>
                                <span class="hide-menu">Advisers</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="../budget_management/admin_budget_approval_table.php"
                                aria-expanded="false" data-tooltip="Events">
                                <i class="bx bx-book-content" style="color: #fff; font-size: 35px;"></i>
                                <span class="hide-menu">Approval</span>
                            </a>
                        </li>

                        <li class="sidebar-item profile-container">
                            <a class="sidebar-link" href="../user/admin_profile.php" aria-expanded="false"
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
                                        <li><a class="dropdown-item" href="../user/admin_profile.php"><i
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
                <h2 class="mb-4"><span class="text-warning fw-bold me-2">|</span> Archive Legend</h2>

                <!-- Years Table -->
                <div class="mb-5">
                    <h3>Years
                        <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addYearModal"
                            style="height: 40px; width: 200px; border-radius: 8px; font-size: 12px;">
                            <i class="fa-solid fa-plus"></i> Add Year
                        </button>
                    </h3>
                    <div class="table-responsive">
                        <table id="yearsTable" class="table">
                            <thead>
                                <tr>
                                    <th>Period</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $years_query = "SELECT * FROM years";
                                $years_result = $conn->query($years_query);

                                if ($years_result->num_rows > 0) {
                                    while ($year = $years_result->fetch_assoc()) {
                                        $status_class = $year['status'] === 'Active' ? 'approved' : 'disapproved';

                                        echo "<tr>
                                            <td>{$year['name']}</td>
                                            <td>" . date('F d, Y', strtotime($year['start_date'])) . "</td>
                                            <td>" . date('F d, Y', strtotime($year['end_date'])) . "</td>
                                            <td><span class='badge rounded-pill {$status_class}'>{$year['status']}</span></td>
                                            <td>
                                                <button class='btn btn-primary btn-sm edit-year-btn mb-3' 
                                                        data-bs-toggle='modal' 
                                                        data-bs-target='#editYearModal' 
                                                        data-id='{$year['year_id']}'>
                                                    <i class='fa-solid fa-pen'></i> Edit
                                                </button>
                                                <button class='btn btn-danger btn-sm delete-year-btn mb-3' 
                                                        data-id='{$year['year_id']}'>
                                                    <i class='fa-solid fa-trash'></i> Delete
                                                </button>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center'>No years found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Semesters Table -->
                <div>
                    <h3>Semesters
                        <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addSemesterModal"
                            style="height: 40px; width: 200px; border-radius: 8px; font-size: 12px;">
                            <i class="fa-solid fa-plus"></i> Add Semester
                        </button>
                    </h3>
                    <div class="table-responsive">
                        <table id="semestersTable" class="table">
                            <thead>
                                <tr>
                                    <th>Period</th>
                                    <th>Year</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $semesters_query = "SELECT s.*, y.name AS year_name FROM semesters s JOIN years y ON s.year_id = y.year_id";
                                $semesters_result = $conn->query($semesters_query);

                                if ($semesters_result->num_rows > 0) {
                                    while ($semester = $semesters_result->fetch_assoc()) {
                                        $status_class = $semester['status'] === 'Active' ? 'approved' : 'disapproved';

                                        echo "<tr>
                                            <td>{$semester['name']}</td>
                                            <td>{$semester['year_name']}</td>
                                            <td>" . date('F d, Y', strtotime($semester['start_date'])) . "</td>
                                            <td>" . date('F d, Y', strtotime($semester['end_date'])) . "</td>
                                            <td><span class='badge rounded-pill {$status_class}'>{$semester['status']}</span></td>
                                            <td>
                                                <button class='btn btn-primary btn-sm edit-semester-btn mb-3' 
                                                        data-bs-toggle='modal' 
                                                        data-bs-target='#editSemesterModal' 
                                                        data-id='{$semester['semester_id']}'>
                                                    <i class='fa-solid fa-pen'></i> Edit
                                                </button>
                                                <button class='btn btn-danger btn-sm delete-semester-btn mb-3' 
                                                        data-id='{$semester['semester_id']}'>
                                                    <i class='fa-solid fa-trash'></i> Delete
                                                </button>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No semesters found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add Year Modal -->
            <div class="modal fade" id="addYearModal" tabindex="-1" role="dialog" aria-labelledby="addYearLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="addYearForm" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addYearLabel">Add New Year</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Success Message Alert -->
                            <div id="yearSuccessMessage" class="alert alert-success d-none mt-3" role="alert">
                                    Year added successfully!
                                </div>

                                <!-- Error Message Alert -->
                                <div id="yearErrorMessage" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="yearErrorList"></ul>
                                </div>
                            <div class="modal-body">

                                <!-- Start Date Field -->
                                <div class="form-group mt-3">
                                    <label for="year_start_date">Start Date</label>
                                    <input type="date" class="form-control" id="year_start_date" name="year_start_date" required>
                                </div>

                                <!-- End Date Field -->
                                <div class="form-group mt-3">
                                    <label for="year_end_date">End Date</label>
                                    <input type="date" class="form-control" id="year_end_date" name="year_end_date" required>
                                </div>

                                <!-- Status Field -->
                                <div class="form-group mt-3">
                                    <label for="year_status">Status</label>
                                    <select name="year_status" id="year_status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Year</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add Semester Modal -->
            <div class="modal fade" id="addSemesterModal" tabindex="-1" role="dialog" aria-labelledby="addSemesterLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="addSemesterForm" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addSemesterLabel">Add New Semester</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Success Message Alert -->
                            <div id="semesterSuccessMessage" class="alert alert-success d-none mt-3" role="alert">
                                    Semester added successfully!
                                </div>

                                <!-- Error Message Alert -->
                                <div id="semesterErrorMessage" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="semesterErrorList"></ul>
                                </div>
                            <div class="modal-body">

                                <!-- Year Dropdown Field -->
                                <div class="form-group mt-3">
                                    <label for="semester_year">Year</label>
                                    <select name="semester_year" id="semester_year" class="form-control" required>
                                        <option value="">Select Year</option>
                                        <?php
                                        $years_query = "SELECT year_id, name FROM years";
                                        $years_result = $conn->query($years_query);
                                        if ($years_result->num_rows > 0) {
                                            while ($year = $years_result->fetch_assoc()) {
                                                echo "<option value='{$year['year_id']}'>{$year['name']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Type Field -->
                                <div class="form-group mt-3">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="">Select Type</option>
                                        <option value="First">First</option>
                                        <option value="Second">Second</option>
                                    </select>
                                </div>

                                <!-- Start Date Field -->
                                <div class="form-group mt-3">
                                    <label for="semester_start_date">Start Date</label>
                                    <input type="date" class="form-control" id="semester_start_date" name="semester_start_date" required>
                                </div>

                                <!-- End Date Field -->
                                <div class="form-group mt-3">
                                    <label for="semester_end_date">End Date</label>
                                    <input type="date" class="form-control" id="semester_end_date" name="semester_end_date" required>
                                </div>

                                <!-- Status Field -->
                                <div class="form-group mt-3">
                                    <label for="semester_status">Status</label>
                                    <select name="semester_status" id="semester_status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Semester</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Edit Semester Modal -->
            <div class="modal fade" id="editSemesterModal" tabindex="-1" role="dialog" aria-labelledby="editSemesterLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="editSemesterForm" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSemesterLabel">Edit Semester</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Success Message Alert -->
                            <div id="semesterEditSuccessMessage" class="alert alert-success d-none mt-3" role="alert">
                                    Semester updated successfully!
                                </div>

                                <!-- Error Message Alert -->
                                <div id="semesterEditErrorMessage" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="semesterEditErrorList"></ul>
                                </div>
                            <div class="modal-body">

                                <!-- Hidden input to store the semester ID -->
                                <input type="hidden" id="editSemesterId" name="semester_id">

                                <!-- Year Dropdown Field -->
                                <div class="form-group mt-3">
                                    <label for="editSemesterYear">Year</label>
                                    <select name="semester_year" id="editSemesterYear" class="form-control" required>
                                        <option value="">Select Year</option>
                                        <?php
                                        $years_query = "SELECT year_id, name FROM years";
                                        $years_result = $conn->query($years_query);
                                        if ($years_result->num_rows > 0) {
                                            while ($year = $years_result->fetch_assoc()) {
                                                echo "<option value='{$year['year_id']}'>{$year['name']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Type Field -->
                                <div class="form-group mt-3">
                                    <label for="editType">Type</label>
                                    <select name="type" id="editType" class="form-control" required>
                                        <option value="">Select Type</option>
                                        <option value="First">First</option>
                                        <option value="Second">Second</option>
                                    </select>
                                </div>

                                <!-- Start Date Field -->
                                <div class="form-group mt-3">
                                    <label for="editStartDate">Start Date</label>
                                    <input type="date" class="form-control" id="editStartDate" name="semester_start_date" required>
                                </div>

                                <!-- End Date Field -->
                                <div class="form-group mt-3">
                                    <label for="editEndDate">End Date</label>
                                    <input type="date" class="form-control" id="editEndDate" name="semester_end_date" required>
                                </div>

                                <!-- Status Field -->
                                <div class="form-group mt-3">
                                    <label for="editStatus">Status</label>
                                    <select name="semester_status" id="editStatus" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
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


            <!-- Edit Year Modal -->
            <div class="modal fade" id="editYearModal" tabindex="-1" role="dialog" aria-labelledby="editYearLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="editYearForm" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editYearLabel">Edit Year</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Success Message Alert -->
                            <div id="yearEditSuccessMessage" class="alert alert-success d-none mt-3" role="alert">
                                    Year updated successfully!
                                </div>

                                <!-- Error Message Alert -->
                                <div id="yearEditErrorMessage" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="yearEditErrorList"></ul>
                                </div>
                            <div class="modal-body">

                                <!-- Hidden input to store the year ID -->
                                <input type="hidden" id="editYearId" name="year_id">

                                <!-- Start Date Field -->
                                <div class="form-group mt-3">
                                    <label for="editYearStartDate">Start Date</label>
                                    <input type="date" class="form-control" id="editYearStartDate" name="year_start_date" required>
                                </div>

                                <!-- End Date Field -->
                                <div class="form-group mt-3">
                                    <label for="editYearEndDate">End Date</label>
                                    <input type="date" class="form-control" id="editYearEndDate" name="year_end_date" required>
                                </div>

                                <!-- Status Field -->
                                <div class="form-group mt-3">
                                    <label for="editYearStatus">Status</label>
                                    <select name="year_status" id="editYearStatus" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
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
                            <h5 class="modal-title" id="archiveModalLabel">Archive Income</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Success Message Alert -->
                        <div id="archiveSuccessMessage" class="alert alert-success d-none mt-3" role="alert">
                                Expense archived successfully!
                            </div>
                            <!-- Error Message Alert -->
                            <div id="archiveErrorMessage" class="alert alert-danger d-none mt-3" role="alert">
                                <ul id="archiveErrorList"></ul> <!-- List for showing validation errors -->
                            </div>
                        <div class="modal-body">
                            Are you sure you want to archive this expense?
                            <input type="hidden" id="archiveId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" id="confirmArchiveBtn" class="btn btn-danger">Archive</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End of 2nd Body Wrapper -->
    </div>
    <!-- End of Overall Body Wrapper -->

    <!-- BackEnd -->
    <script src="js/archive_legend.js">
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>