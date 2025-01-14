<?php
// Include the database connection file
include '../connection.php';
include '../session_check.php'; 
include '../user_query.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Information -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title and Favicon -->
    <title>Budget Approvals & Activities Table</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon_sikat.png"/>

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    <link rel="stylesheet" href="../budget_management/css/budget.css">
    <link rel="stylesheet" href="../activity_management/css/activities.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap.min.css" />

    <!-- JavaScript Libraries -->
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>

    <style>
        #sidebar > div > div > span {
            color: #fff;
            font-size: 20px;
            position: absolute;
            margin-left: 80px;
        }

        #sidebarnav > li > a > span {
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
                                <button id="notificationBtn"
                                    style="background-color: transparent; border: none; padding: 0; position: relative;">
                                    <lord-icon src="https://cdn.lordicon.com/lznlxwtc.json" trigger="hover"
                                        colors="primary:#004024" style="width:30px; height:30px;">
                                    </lord-icon>
                                    <!-- Notification Count Badge -->
                                    <span id="notificationCount" style="
                                    position: absolute;
                                    top: -5px;
                                    right: -5px;
                                    background-color: red;
                                    color: white;
                                    font-size: 12px;
                                    padding: 2px 6px;
                                    border-radius: 50%;
                                    display: none;">0</span>
                                </button>
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

            <style>
                .table-responsive {
                    overflow-x: auto; /* Enable horizontal scrolling */
                    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
                    width: 100%; /* Ensure it takes full width */
                    height: auto; /* Allow height to adjust */
                }

                table {
                    width: 100%; /* Full width for the table */
                    border-collapse: collapse; /* Collapse borders */
                }

                th, td {
                    text-align: left; /* Align text to the left */
                    padding: 12px; /* Padding for table cells */
                }

                th {
                    background-color: #007bff; /* Header background color */
                    color: white; /* Header text color */
                }

                .btn {
                    font-size: 12px; /* Button font size */
                }

                @media (max-width: 768px) {
                    .table-responsive {
                        display: block; /* Ensure it's a block-level element */
                        overflow-x: auto; /* Enable horizontal scrolling */
                    }

                    table {
                        min-width: 600px; /* Set a minimum width for the table to enable scrolling */
                    }

                    th, td {
                        white-space: nowrap; /* Prevent text wrapping in table cells */
                    }
                }

                /* Custom Scrollbar Styles */
                .table-responsive::-webkit-scrollbar {
                    height: 8px; /* Height of horizontal scrollbar */
                }

                .table-responsive::-webkit-scrollbar-thumb {
                    background: rgba(0, 0, 0, 0.3); /* Color of the scrollbar thumb */
                    border-radius: 4px; /* Round edges of the scrollbar thumb */
                }

                .table-responsive::-webkit-scrollbar-thumb:hover {
                    background: rgba(0, 0, 0, 0.5); /* Darker on hover */
                }

                .table-responsive::-webkit-scrollbar-track {
                    background: transparent; /* Transparent track */
                }
            </style>

            <div class="container mt-4 p-5">
                <h2 class="mb-4">
                    <span class="text-warning fw-bold me-2">|</span> Budget Approvals Archive
                </h2>

                <!-- Approval Table -->
                <div class="table-responsive" style="max-height: 400px;">
                    <table id="budgetApprovalsArchive" class="table mt-4">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Attachment</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch data from budget_approvals table for archived records
                            $approvalsQuery = "SELECT * FROM budget_approvals WHERE organization_id = $organization_id AND archived = 1"; // Hardcoded for testing
                            $approvalsResult = mysqli_query($conn, $approvalsQuery);
                            
                            while ($row = mysqli_fetch_assoc($approvalsResult)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo ucfirst($row['category']); ?></td>
                                    <td>
                                        <a href="uploads/<?php echo $row['attachment']; ?>"
                                        class='link-offset-2 link-underline link-underline-opacity-0' target="_blank">
                                            <?php echo $row['attachment']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php 
                                        // Display status but don't allow editing
                                        if ($row['status'] == 'Pending') {
                                            echo "<span class='badge rounded-pill pending'>";
                                        } elseif ($row['status'] == 'Approved') {
                                            echo "<span class='badge rounded-pill approved'>";
                                        } elseif ($row['status'] == 'Disapproved') {
                                            echo "<span class='badge rounded-pill disapproved'>";
                                        }
                                        echo ucfirst($row['status']); 
                                        ?>
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Non-admin users can recover or delete archived records -->
                                        <button class='btn btn-primary btn-sm recover-btn mb-3' data-bs-toggle='modal'
                                                data-bs-target='#recoverModal'
                                                data-id="<?php echo $row['approval_id']; ?>">
                                            <i class='fa-solid fa-hammer'></i> Recover
                                        </button>
                                        <button class='btn btn-danger btn-sm delete-btn mb-3' data-bs-toggle='modal'
                                                data-bs-target='#deleteModal'
                                                data-id="<?php echo $row['approval_id']; ?>">
                                            <i class='fa-solid fa-trash'></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recover Event Modal -->
            <div class="modal fade" id="recoverModal" tabindex="-1" aria-labelledby="recoverLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Recover Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Success message -->
                            <div id="recoverSuccessMessage" class="alert alert-success d-none"></div>
                                
                                <!-- Error message -->
                                <div id="recoverErrorMessage" class="alert alert-danger d-none">
                                    <ul id="recoverErrorList"></ul>
                                </div>
                            <div class="modal-body">
                                <p>Are you sure you want to recover this request?</p>

                                <!-- Hidden form for item and event IDs -->
                                <form id="recoverForm">
                                    <input type="hidden" name="approval_id" id="recover_approval_id"> <!-- Event ID -->
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger" id="confirmRecoverBtn">Recover</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Success message -->
                            <div id="deleteSuccessMessage" class="alert alert-success d-none"></div>
                                
                                <!-- Error message -->
                                <div id="deleteErrorMessage" class="alert alert-danger d-none">
                                    <ul id="deleteErrorList"></ul>
                                </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this request?</p>

                                <!-- Hidden form for item and event IDs -->
                                <form id="deleteForm">
                                    <input type="hidden" name="approval_id" id="delete_approval_id"> <!-- Event ID -->
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>                                
            <script src="js/budget_approvals_archive.js"></script>
            <script>
                $(document).ready(function () {
                    // Toggle the sidebar using the bars icon
                    $('#sidebarToggle').on('click', function () {
                        $('#sidebar').toggleClass('active');
                        $('#content').toggleClass('active');
                        $(this).toggleClass('active');
                    });
                });
            </script>

        </div>
        <!-- End of 2nd Body Wrapper -->
    </div>
    <!-- End of Overall Body Wrapper -->
</body>

</html>