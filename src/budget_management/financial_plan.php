<?php
include 'connection.php';
include '../session_check.php'; 
include '../user_query.php';

// Check if user is logged in and has officer role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'officer') {
    header("Location: ../user/login.html");
    exit();
}

$sql = "SELECT * FROM financial_plan WHERE organization_id = $organization_id";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plan of Activities</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon_sikat.png"/>
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

                            #sidebarnav>li:nth-child(5)>div {
                                background-color: #00542F;
                            }

                            #sidebarnav>li:nth-child(5)>a {
                                background-color: #00542F;
                            }

                            .sidebar-link {
                                cursor: pointer;
                                /* Ensure pointer cursor for better UX */
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
              
            <!-- Table -->
            <style>
                .tablecontainer {
                    padding: 1.5rem; /* Adjust padding */
                    background-color: #f8f9fa; /* Light background for contrast */
                    border-radius: 8px; /* Rounded corners */
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
                    max-height: calc(300vh - 300px); /* Set max height to fill the screen minus some space */
                }

                .table-responsive {
                    overflow-x: auto; /* Enable horizontal scrolling */
                    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
                    width: 100%; /* Ensure it takes full width */
                    height: 1500px; /* Ensure it takes full height */
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
                    .tablecontainer {
                        padding: 1rem; /* Reduce padding for smaller screens */
                    }

                    .table-responsive {
                        transform: scale(1); /* No zoom for better visibility */
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
                .tablecontainer::-webkit-scrollbar,
                .table-responsive::-webkit-scrollbar {
                    width: 8px; /* Width of vertical scrollbar */
                    height: 8px; /* Height of horizontal scrollbar */
                }

                .tablecontainer::-webkit-scrollbar-thumb,
                .table-responsive::-webkit-scrollbar-thumb {
                    background: rgba(0, 0, 0, 0.3); /* Color of the scrollbar thumb */
                    border-radius: 4px; /* Round edges of the scrollbar thumb */
                }

                .tablecontainer::-webkit-scrollbar-thumb:hover,
                .table-responsive::-webkit-scrollbar-thumb:hover {
                    background: rgba(0, 0, 0, 0.5); /* Darker on hover */
                }
            </style>

            <div class="tablecontainer mt-5">
                <h2 class="mb-4">
                    <span class="text-warning fw-bold me-2">|</span> Financial Plan
                    <button class="btn btn-primary ms-3" id="add-btn" data-bs-toggle="modal" data-bs-target="#addPlanModal"
                        style="height: 40px; width: 200px; border-radius: 8px;">
                        <i class="fa-solid fa-plus"></i> Add Plan
                    </button>
                </h2>
                <div class="table-responsive" style="max-height: 400px;">
                    <table id="financialPlanTable" class="table">
                        <thead>
                            <tr>
                                <th class="table-warning">Projected Income</th>
                                <th style="text-align: center;" class="table-warning">Proposed Date</th>
                                <th style="text-align: center;"class="table-warning">Amount</th>
                                <th class="table-warning">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $has_income = false;
                            $has_expenses = false;

                            if ($result->num_rows > 0) {
                                // Loop through income records
                                while ($row = $result->fetch_assoc()) {
                                    if ($row['type'] === 'Income') {
                                        $has_income = true;
                                        echo "<tr>
                                                <td>" . htmlspecialchars($row['title']) . "</td>
                                                <td style='text-align: center;'>" . date('F j, Y', strtotime($row['date'])) . "</td>
                                                <td style='text-align: center;'>₱" . number_format($row['amount'], 2) . "</td>
                                                <td>
                                                    <button class='btn btn-primary btn-sm edit-btn mb-3' 
                                                            data-bs-toggle='modal' 
                                                            data-bs-target='#editPlanModal' 
                                                            data-id='{$row['plan_id']}'>
                                                        <i class='fa-solid fa-pen'></i> Edit
                                                    </button>
                                                    <button class='btn btn-danger btn-sm delete-btn mb-3' 
                                                            data-id='{$row['plan_id']}'>
                                                        <i class='fa-solid fa-trash'></i> Delete
                                                    </button>
                                                </td>
                                            </tr>";
                                    }
                                }

                                if (!$has_income) {
                                    echo "<tr><td colspan='4' class='text-center'>No projected income found</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>

                        <thead>
                            <tr>
                                <th colspan="4" class="table-warning">Projected Expenses</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Reset result pointer for expense segregation
                            $result->data_seek(0); // Move back to the beginning of the result set

                            $categories = ['Activities', 'Purchases', 'Maintenance and Other Expenses'];
                            foreach ($categories as $category) {
                                echo "<tr><th colspan='4' class='table-light'>$category</th></tr>";

                                // Loop through expense records by category
                                $has_expenses_for_category = false;
                                while ($row = $result->fetch_assoc()) {
                                    if ($row['type'] === 'Expense' && $row['category'] === $category) {
                                        $has_expenses = true;
                                        $has_expenses_for_category = true;
                                        echo "<tr>
                                                <td>" . htmlspecialchars($row['title']) . "</td>";

                                        if ($category === 'Activities') {
                                            echo "<td style='text-align: center;'>" . date('F j, Y', strtotime($row['date'])) . "</td>";
                                        } else {
                                            echo "<td></td>";
                                        }

                                        echo "
                                        <td style='text-align: center;'>₱" . number_format($row['amount'], 2) . "</td>
                                        <td>
                                            <button class='btn btn-primary btn-sm edit-btn mb-3' 
                                                    data-bs-toggle='modal' 
                                                    data-bs-target='#editPlanModal' 
                                                    data-id='{$row['plan_id']}'>
                                                <i class='fa-solid fa-pen'></i> Edit
                                            </button>
                                            <button class='btn btn-danger btn-sm delete-btn mb-3' 
                                                    data-id='{$row['plan_id']}'>
                                                <i class='fa-solid fa-trash'></i> Delete
                                            </button>
                                        </td>
                                    </tr>";
                                    }
                                }

                                if (!$has_expenses_for_category) {
                                    echo "<tr><td colspan='4' class='text-center'>No expenses for $category</td></tr>";
                                }

                                // Reset pointer for the next category
                                $result->data_seek(0);
                            }

                            if (!$has_expenses) {
                                echo "<tr><td colspan='4' class='text-center'>No projected expenses found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add Plan Modal -->
            <div class="modal fade" id="addPlanModal" tabindex="-1" role="dialog" aria-labelledby="addPlanLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="addPlanForm">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPlanLabel">Add New Plan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <!-- Success Message Alert -->
                                <div id="successMessage1" class="alert alert-success d-none text-center" role="alert" style="padding: 10px; margin: 0 auto;">
                                    Plan added successfully!
                                </div>
                                <!-- Error Message Alert -->
                                <div id="errorMessage1" class="alert alert-danger d-none text-center" role="alert" style="padding: 10px; margin: 0 auto;">
                                    <ul id="errorList1"></ul> <!-- List for showing validation errors -->
                                </div>
                            <div class="modal-body">
                                <!-- Form fields -->
                                <div class="form-group mb-2">
                                    <div class="col">
                                        <label for="title">Title <span style="color: red;">*</span> <small style="color: red; font-style: italic;">Required</small></label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <div class="col">
                                        <label for="type">Type <span style="color: red;">*</span> <small style="color: red; font-style: italic;">Required</small></label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="">Select Type</option>
                                            <option value="Income">Income</option>
                                            <option value="Expense">Expense</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="category" class="form-label">Category <span style="color: red;">*</span> <small style="color: red; font-style: italic;">Required</small></label>
                                        <select class="form-control" id="category" name="category" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            // Fetch categories
                                            $category_query = "SELECT category FROM categories"; // Only fetch the category column
                                            $category_result = mysqli_query($conn, $category_query);

                                            if (!$category_result) {
                                                // Query error
                                                echo '<option value="">Error loading categories</option>';
                                            } else {
                                                if (mysqli_num_rows($category_result) > 0) {
                                                    while ($category_row = mysqli_fetch_assoc($category_result)) {
                                                        // Use htmlspecialchars to prevent XSS
                                                        echo '<option value="' . htmlspecialchars($category_row['category']) . '">' . htmlspecialchars($category_row['category']) . '</option>';
                                                    }
                                                } else {
                                                    // No categories available
                                                    echo '<option value="">No categories available</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <div class="col">
                                        <label for="date">Proposed Date <span style="color: red;">*</span> <small style="color: red; font-style: italic;">Required</small></label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                    <div class="col">
                                        <label for="amount">Amount <span style="color: red;">*</span> <small style="color: red; font-style: italic;">Required</small></label>
                                        <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submit-btn">Add Plan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Edit Plan Modal -->
            <div class="modal fade" id="editPlanModal" tabindex="-1" role="dialog" aria-labelledby="editPlanModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="editPlanForm">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPlanModalLabel">Edit Plan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <!-- Alerts -->
                                <div id="successMessage2" class="alert alert-success d-none text-center" role="alert" style="padding: 10px; margin: 0 auto;">
                                    Plan updated successfully!
                                </div>
                                <div id="errorMessage2" class="alert alert-danger d-none text-center" role="alert" style="padding: 10px; margin: 0 auto;">
                                    <ul id="errorList2"></ul>
                                </div>
                            <div class="modal-body">
                                <!-- Hidden field for plan ID -->
                                <input type="hidden" id="editPlanId" name="edit_plan_id">
                                <!-- Title -->
                                <div class="form-group mb-2">
                                    <label for="editTitle">Title</label>
                                    <input type="text" class="form-control" id="editTitle" name="edit_title" required>
                                </div>

                                <!-- Type and Category -->
                                <div class="form-group row mb-2">
                                    <div class="col">
                                        <label for="editType">Type</label>
                                        <select class="form-control" id="editType" name="edit_type" required>
                                            <option value="">Select Type</option>
                                            <option value="Income">Income</option>
                                            <option value="Expense">Expense</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="editCategory">Category</label>
                                        <select class="form-control" id="editCategory" name="edit_category" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            // Fetch categories
                                            $category_query = "SELECT category FROM categories"; // Only fetch the category column
                                            $category_result = mysqli_query($conn, $category_query);

                                            if (!$category_result) {
                                                // Query error
                                                echo '<option value="">Error loading categories</option>';
                                            } else {
                                                if (mysqli_num_rows($category_result) > 0) {
                                                    while ($category_row = mysqli_fetch_assoc($category_result)) {
                                                        // Use htmlspecialchars to prevent XSS
                                                        echo '<option value="' . htmlspecialchars($category_row['category']) . '">' . htmlspecialchars($category_row['category']) . '</option>';
                                                    }
                                                } else {
                                                    // No categories available
                                                    echo '<option value="">No categories available</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Date and Amount -->
                                <div class="form-group row mb-2">
                                    <div class="col">
                                        <label for="editDate">Proposed Date</label>
                                        <input type="date" class="form-control" id="editDate" name="edit_date">
                                    </div>
                                    <div class="col">
                                        <label for="editAmount">Amount</label>
                                        <input type="number" class="form-control" id="editAmount" name="edit_amount" min="0" step="0.01" required>
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



            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Archive Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <!-- Alerts -->
                            <div id="successMessage3" class="alert alert-success d-none text-center" role="alert" style="padding: 10px; margin: 0 auto;">
                                Plan deleted successfully!
                            </div>
                            <div id="errorMessage3" class="alert alert-danger d-none text-center" role="alert" style="padding: 10px; margin: 0 auto;">
                                <ul id="errorList3"></ul> <!-- List for showing validation errors -->
                            </div>
                        <div class="modal-body">
                            Are you sure you want to delete this plan?
                            <input type="hidden" id="deletePlanId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    <!-- BackEnd -->
    <script src="js/financial_plan.js"></script>
</body>

</html>

<?php
$conn->close();
?>