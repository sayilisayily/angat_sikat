<?php
include '../connection.php';
include '../session_check.php';

// Check if user is logged in and has officer role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.html");
    exit();
}

include '../user_query.php';
$sql = "SELECT * FROM organizations WHERE archived = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Organizations Management</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon_sikat.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
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
                <h2 class="mb-4"><span class="text-warning fw-bold me-2">|</span>Organizations
                    <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addOrganizationModal"
                        style="height: 40px; width: 200px; border-radius: 8px; font-size: 12px;">
                        <i class="fa-solid fa-plus"></i> Add Organization
                    </button>
                </h2>
                
                <div class="table-responsive">
                    <table id="organizationsTable" class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Acronym</th>
                                <th>Logo</th>
                                <th>Members</th>
                                <th>Status</th>
                                <th>Color</th> <!-- Added column for organization color -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $organization_logo = $row['organization_logo']; // Assuming the logo is stored as the file name
                                    // Check if logo exists and construct the path
                                    $logo_path = !empty($organization_logo) && file_exists('uploads/' . $organization_logo) 
                                                ? 'uploads/' . $organization_logo 
                                                : 'uploads/default_logo.png';

                                    // Get the organization color
                                    $organization_color = !empty($row['organization_color']) ? $row['organization_color'] : '#FFFFFF'; // Default to white if no color is set
                                    
                                    // Display the organization data in the table
                                    echo "<tr>
                                            <td>{$row['organization_name']}</td>
                                            <td>{$row['acronym']}</td>
                                            <td><img src='$logo_path' alt='Logo' style='width: 50px; height: 50px; object-fit: cover;'></td>
                                            <td>{$row['organization_members']}</td>
                                            <td>{$row['organization_status']}</td>
                                            <td style='background-color: {$organization_color}; color: white; text-align: center;'> <!-- Display color -->
                                                {$organization_color}
                                            </td>
                                            <td>
                                                <button class='btn btn-primary btn-sm edit-btn mb-3' 
                                                        data-bs-toggle='modal' 
                                                        data-bs-target='#editOrganizationModal' 
                                                        data-id='{$row['organization_id']}'>
                                                    <i class='fa-solid fa-pen'></i> Edit
                                                </button>
                                                <button class='btn btn-danger btn-sm archive-btn mb-3' 
                                                        data-id='{$row['organization_id']}'>
                                                    <i class='fa-solid fa-box-archive'></i> Archive
                                                </button>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No organizations found</td></tr>"; // Updated colspan to 7
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    <!-- Add Organization Modal -->
    <div class="modal fade" id="addOrganizationModal" tabindex="-1" role="dialog" aria-labelledby="addOrganizationLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="addOrganizationForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addOrganizationLabel">Add New Organization</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form fields -->
                        <div class="form-group mb-3">
                            <label for="organization_name">Organization Name</label>
                            <input type="text" class="form-control" id="organization_name" name="organization_name"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="acronym">Organization Acronym</label>
                            <input type="text" class="form-control" id="acronym" name="acronym"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="organization_logo">Logo</label>
                            <input type="file" class="form-control" id="organization_logo" name="organization_logo"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="organization_members">Members</label>
                            <input type="number" class="form-control" id="organization_members"
                                name="organization_members" min="1" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="organization_status">Status</label>
                            <select class="form-control" id="organization_status" name="organization_status">
                                <option value="Probationary">Probationary</option>
                                <option value="Level I">Level I</option>
                                <option value="Level II">Level II</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <div class="col-sm-3">
                                <label for="organization_color">Color</label>
                                <input type="color" class="form-control" id="organization_color" 
                                    name="organization_color" value="#FFFFFF" required>
                            </div>

                            <div class="col-sm-3">
                            </div>
                        </div>

                        <!-- Success Message Alert -->
                        <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
                            Organization added successfully!
                        </div>
                        <!-- Error Message Alert -->
                        <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert">
                            <ul id="errorList"></ul> <!-- List for showing validation errors -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Organization</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Organization Modal -->
    <div class="modal fade" id="editOrganizationModal" tabindex="-1" role="dialog"
        aria-labelledby="editOrganizationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="editOrganizationForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editOrganizationLabel">Edit Organization</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden field for organization ID -->
                        <input type="hidden" id="editOrganizationId" name="organization_id">
                        <!-- Existing logo hidden field -->
                        <input type="hidden" id="existingLogo" name="existing_logo" value="">

                        <!-- Other form fields -->
                        <div class="form-group mb-3">
                            <label for="editOrganizationName">Organization Name</label>
                            <input type="text" class="form-control" id="editOrganizationName" name="organization_name"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="acronym">Organization Acronym</label>
                            <input type="text" class="form-control" id="editAcronym" name="acronym"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editOrganizationLogo">Logo</label>
                            <input type="file" class="form-control" id="editOrganizationLogo" name="organization_logo"
                                accept="image/*">
                        </div>
                        <div class="form-group mb-3">
                            <label for="editOrganizationMembers">Members</label>
                            <input type="number" class="form-control" id="editOrganizationMembers"
                                name="organization_members" min="1" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editOrganizationStatus">Status</label>
                            <select class="form-control" id="editOrganizationStatus" name="organization_status">
                                <option value="Probationary">Probationary</option>
                                <option value="Level I">Level I</option>
                                <option value="Level II">Level II</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <div class="col-sm-3">
                                <label for="organization_color">Color</label>
                                <input type="color" class="form-control" id="editOrganizationColor"
                                    name="organization_color" required>
                            </div>
                            <div class="col-sm-3">
                            </div>
                        </div>
                        <!-- Success Message Alert -->
                        <div id="editSuccessMessage" class="alert alert-success d-none mt-3" role="alert">
                            Organization updated successfully!
                        </div>
                        <!-- Error Message Alert -->
                        <div id="editErrorMessage" class="alert alert-danger d-none mt-3" role="alert">
                            <ul id="editErrorList"></ul> <!-- List for showing validation errors -->
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
                    Are you sure you want to archive this organization?
                    <input type="hidden" id="archiveId">
                    <!-- Success Message Alert -->
                    <div id="archiveSuccessMessage" class="alert alert-success d-none mt-3" role="alert">
                            Organization archived successfully!
                        </div>
                        <!-- Error Message Alert -->
                        <div id="archiveErrorMessage" class="alert alert-danger d-none mt-3" role="alert">
                            <ul id="archiveErrorList"></ul> <!-- List for showing validation errors -->
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

    <!-- Backend Scripts -->
    <script src="js/organizations.js"></script>
</body>

</html>

<?php
$conn->close();
?>