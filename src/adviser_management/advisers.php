<?php
include '../connection.php';
include '../session_check.php';
include '../user_query.php';

// Check if user is logged in and has officer role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.html");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Advisers Management</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/angatsikat.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <!--Custom CSS for Sidebar-->
    <link rel="stylesheet" href="../html/sidebar.css" />
    <!--Custom CSS for Activities-->
    <link rel="stylesheet" href="../activity_management/css/activities.css" />
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
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>
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

        <!-- End of 2nd Body Wrapper -->
        <div class="container mt-5 p-5">
            <h2 class="mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-warning fw-bold me-2">|</span>Advisers
                    <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addAdviserModal"
                        style="height: 40px; width: 200px; border-radius: 8px; font-size: 12px;">
                        <i class="fa-solid fa-plus"></i> Add Adviser
                    </button>
                </div>
                <a href="advisers_archive.php" class="text-gray text-decoration-none fw-bold" 
                    style="font-size: 14px;">
                    View Archive
                </a>
            </h2>
            
            <div class="table-responsive">
                <table id="advisersTable" class="table">
                    <thead>
                        <tr>
                            <th>Picture</th> <!-- New Column for Picture -->
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Position</th>
                            <th>Organization</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch advisers and join with organizations table to get organization name
                        $adviserQuery = "SELECT advisers.*, organizations.organization_name 
                                        FROM advisers
                                        JOIN organizations ON advisers.organization_id = organizations.organization_id WHERE advisers.archived = 0";
                        $adviserResult = $conn->query($adviserQuery);

                        if ($adviserResult->num_rows > 0) {
                            while ($adviserRow = $adviserResult->fetch_assoc()) {
                                // Check if there's a picture and display it, or use a placeholder image
                                $picture = !empty($adviserRow['picture']) ? "uploads/" . $adviserRow['picture'] : "path/to/default-image.jpg";
                                echo "<tr>
                                        <td>
                                            <img src='$picture' alt='Adviser Picture' class='img-fluid' style='width: 50px; height: 50px; object-fit: cover; border-radius: 50%;'>
                                        </td>
                                        <td>{$adviserRow['first_name']}</td>
                                        <td>{$adviserRow['last_name']}</td>
                                        <td>{$adviserRow['position']}</td>
                                        <td>{$adviserRow['organization_name']}</td>
                                        <td>
                                            <button class='btn btn-primary btn-sm edit-btn mb-3' 
                                                    data-bs-toggle='modal' 
                                                    data-bs-target='#editAdviserModal' 
                                                    data-id='{$adviserRow['adviser_id']}'>
                                                <i class='fa-solid fa-pen'></i> Edit
                                            </button>
                                            <button class='btn btn-danger btn-sm archive-btn mb-3' 
                                                    data-id='{$adviserRow['adviser_id']}'>
                                                <i class='fa-solid fa-box-archive'></i> Archive
                                            </button>
                                        </td>
                                    </tr>";
                            }
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    <!-- End of Overall Body Wrapper -->
    <!-- Add Adviser Modal -->
    <div class="modal fade" id="addAdviserModal" tabindex="-1" role="dialog" aria-labelledby="addAdviserLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="addAdviserForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAdviserLabel">Add New Adviser</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Success Message Alert -->
                    <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
                            Adviser added successfully!
                        </div>

                        <!-- Error Message Alert -->
                        <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert">
                            <ul id="errorList"></ul>
                        </div>
                    <div class="modal-body">
                        <!-- First Name and Last Name Row -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name" required>
                                </div>
                            </div>
                        </div>

                        <!-- Organization -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="organization" class="form-label">Organization</label>
                                <select class="form-select" name="organization_id" id="organization_id" required>
                                    <option value="">Select Organization</option>
                                    <?php
                                    $query = "SELECT organization_id, organization_name FROM organizations";
                                    $result = mysqli_query($conn, $query);
                                    if ($result) {
                                        while ($org = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$org['organization_id']}'>{$org['organization_name']}</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No Organizations Available</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Position -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="position" class="form-label">Position</label>
                                <select class="form-select" name="position" id="position" required>
                                    <option value="">Select Position</option>
                                    <option value="Senior Adviser">Senior Adviser</option>
                                    <option value="Junior Adviser">Junior Adviser</option>
                                </select>
                            </div>
                        </div>

                        <!-- Picture -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="picture" class="form-label">Picture</label>
                                <input type="file" class="form-control" name="picture" id="picture" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Adviser</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>

    <!-- Edit Adviser Modal -->
    <div class="modal fade" id="editAdviserModal" tabindex="-1" role="dialog" aria-labelledby="editAdviserLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="editAdviserForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Success Message Alert -->
                    <div id="editSuccessMessage" class="alert alert-success d-none mt-3" role="alert">
                            Adviser updated successfully!
                        </div>

                        <!-- Error Message Alert -->
                        <div id="editErrorMessage" class="alert alert-danger d-none mt-3" role="alert">
                            <ul id="editErrorList"></ul>
                        </div>
                    <div class="modal-body">
                        <!-- Hidden field for user ID -->
                        <input type="hidden" id="editAdviserId" name="adviser_id">
                        <!-- Form fields -->
                        <!-- First Name and Last Name Row -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text" class="form-control" name="first_name" id="edit_first_name" placeholder="Enter First Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text" class="form-control" name="last_name" id="edit_last_name" placeholder="Enter Last Name" required>
                                </div>
                            </div>
                        </div>

                        <!-- Organization -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="organization" class="form-label">Organization</label>
                                <select class="form-select" name="organization_id" id="edit_organization" required>
                                    <option value="">Select Organization</option>
                                    <?php
                                    $query = "SELECT organization_id, organization_name FROM organizations";
                                    $result = mysqli_query($conn, $query);
                                    if ($result) {
                                        while ($org = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$org['organization_id']}'>{$org['organization_name']}</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No Organizations Available</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Position -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="position" class="form-label">Position</label>
                                <select class="form-select" name="position" id="edit_position" required>
                                    <option value="">Select Position</option>
                                    <option value="Senior Adviser">Senior Adviser</option>
                                    <option value="Junior Adviser">Junior Adviser</option>
                                </select>
                            </div>
                        </div>

                        <!-- Picture -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="picture" class="form-label">Picture</label>
                                <input type="file" class="form-control" name="picture" id="edit_picture" accept="image/*">
                            </div>
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
                    <h5 class="modal-title" id="archiveModalLabel">Archive Adviser</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Success Message Alert -->
                <div id="archiveSuccessMessage" class="alert alert-success d-none mt-3" role="alert">
                        Adviser archived successfully!
                    </div>
                    <!-- Error Message Alert -->
                    <div id="archiveErrorMessage" class="alert alert-danger d-none mt-3" role="alert">
                        <ul id="archiveErrorList"></ul> <!-- List for showing validation errors -->
                    </div>
                <div class="modal-body">
                    Are you sure you want to archive this adviser?
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
    </div>

    <!-- Backend Scripts -->
    <script src="js/advisers.js"></script>

</body>

</html>

<?php
$conn->close();
?>