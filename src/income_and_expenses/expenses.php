<?php
include '../connection.php';
include '../session_check.php';
include '../user_query.php'; 

$sql = "SELECT * FROM expenses WHERE organization_id = $organization_id AND archived = 0"; // Adjust the organization_id as needed
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses Table</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/angatsikat.png"/>
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
                                    data-tooltip="Activities">
                                    <i class="bx bx-calendar-event" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">Activities</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../activity_management/calendar.php" aria-expanded="false"
                                    data-tooltip="Calendar">
                                    <i class="bx bx-calendar" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">Calendar</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../budget_management/budget_approval_table.php" aria-expanded="false"
                                    data-tooltip="Approval">
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

            <div class="container mt-5 p-5">
                <h2 class="mb-4">
                    <span class="text-warning fw-bold me-2">|</span> Expenses
                    <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addExpenseModal"
                        style="height: 40px; width: 200px; border-radius: 8px; font-size: 12px;">
                        <i class="fa-solid fa-plus"></i> Add Expense
                    </button>
                </h2>
                <div class="table-responsive" style="max-height: 400px;">
                    <table id="expensesTable" class="table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Reference</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['category']}</td>
                                            <td>{$row['title']}</td>
                                            <td>{$row['amount']}</td>
                                            <td>{$row['reference']}</td>
                                            <td>
                                                <button class='btn btn-primary btn-sm edit-btn' 
                                                        data-bs-toggle='modal' 
                                                        data-bs-target='#editExpenseModal' 
                                                        data-id='{$row['expense_id']}'>
                                                    <i class='fa-solid fa-pen'></i> Edit
                                                </button>
                                                <button class='btn btn-danger btn-sm archive-btn' 
                                                        data-id='{$row['expense_id']}'>
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

            <!-- Add Expense Modal -->
            <div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="addExpenseForm" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addExpenseLabel">Add New Expense</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                                <!-- Success Message Alert -->
                                <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
                                    Expense added successfully!
                                </div>

                                <!-- Error Message Alert -->
                                <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="errorList"></ul>
                                </div>
                            <div class="modal-body">
                                <!-- Title Field -->
                                <div class="form-group mt-3">
                                    <label for="title">Title <span style="color: red;">*</span> <small style="color: red; font-style: italic;">Required</small></label>
                                    <select name="title" id="title" class="form-control" required>
                                        <option value="">Select Title <span style="color: red;">*</span> <small style="color: red; font-style: italic;">Required</small></option>
                                        <?php

                                        // Fetch events
                                        $event_query = "SELECT title, summary_id, total_amount FROM events_summary WHERE type = 'Expense' AND archived = 0 AND organization_id = $organization_id";
                                        $event_result = mysqli_query($conn, $event_query);
                                        echo "<optgroup label='Events'>";
                                        while ($row = mysqli_fetch_assoc($event_result)) {
                                            echo '<option value="' . htmlspecialchars($row['title']) . '" 
                                                    data-id="' . htmlspecialchars($row['summary_id']) . '"
                                                    data-category="Activities" 
                                                    data-total-amount="' . htmlspecialchars($row['total_amount']) . '">' 
                                                    . htmlspecialchars($row['title']) . '</option>';
                                        }
                                        echo "</optgroup>";

                                        // Fetch purchases
                                        $purchase_query = "SELECT title, summary_id, total_amount FROM purchases_summary WHERE archived = 0 AND organization_id = $organization_id";
                                        $purchase_result = mysqli_query($conn, $purchase_query);
                                        echo "<optgroup label='Purchases'>";
                                        while ($row = mysqli_fetch_assoc($purchase_result)) {
                                            echo '<option value="' . htmlspecialchars($row['title']) . '" 
                                                    data-id="' . htmlspecialchars($row['summary_id']) . '"
                                                    data-category="Purchases" 
                                                    data-total-amount="' . htmlspecialchars($row['total_amount']) . '">' 
                                                    . htmlspecialchars($row['title']) . '</option>';
                                        }
                                        echo "</optgroup>";

                                        // Fetch maintenance
                                        $maintenance_query = "SELECT title, summary_id, total_amount FROM maintenance_summary WHERE archived = 0 AND organization_id = $organization_id";
                                        $maintenance_result = mysqli_query($conn, $maintenance_query);
                                        echo "<optgroup label='Maintenance and Other Expenses'>";
                                        while ($row = mysqli_fetch_assoc($maintenance_result)) {
                                            echo '<option value="' . htmlspecialchars($row['title']) . '" 
                                                    data-id="' . htmlspecialchars($row['summary_id']) . '"
                                                    data-category="Maintenance and Other Expenses" 
                                                    data-total-amount="' . htmlspecialchars($row['total_amount']) . '">' 
                                                    . htmlspecialchars($row['title']) . '</option>';
                                        }
                                        echo "</optgroup>";
                                        ?>
                                    </select>


                                </div>
                                <!-- Hidden Fields for Expense Details -->
                                 <input type="hidden" name="summary_id" id="summary_id">
                                <input type="hidden" id="expense_id" name="expense_id">
                                <input type="hidden" id="organization_id" name="organization_id" value="<?php echo $organization_id?>">

                                <!-- Category Field -->
                                <div class="form-group">
                                    <label for="category">Category <span style="color: red;">*</span> <small style="color: red; font-style: italic;">Required</small></label>
                                    <input type="text" class="form-control" id="category" name="category" readonly>
                                </div>

                                <!-- Amount Field -->
                                <div class="form-group mt-3">
                                    <label for="amount">Amount <span style="color: red;">*</span> <small style="color: red; font-style: italic;">Required</small></label>
                                    <input type="number" class="form-control" id="total_amount" name="total_amount" step="0.01"
                                        readonly>
                                </div>

                                <!-- Reference (File Upload) Field -->
                                <div class="form-group mt-3">
                                    <label for="reference">Reference <span style="color: red;">*</span> <small style="color: red; font-style: italic;">Required</small></label>
                                    <input type="file" class="form-control" id="reference" name="reference"
                                        accept=".pdf,.jpg,.png,.doc,.docx" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Expense</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Edit Expense Modal -->
            <div class="modal fade" id="editExpenseModal" tabindex="-1" role="dialog"
                aria-labelledby="editExpenseModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="editExpenseForm" action="update_expense.php" method="POST"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editExpenseModalLabel">Edit Expense</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                                <!-- Success Message Alert -->
                                <div id="editSuccessMessage" class="alert alert-success d-none mt-3" role="alert">
                                    Expense updated successfully!
                                </div>
                                <!-- Error Message Alert -->
                                <div id="editErrorMessage" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="editErrorList"></ul>
                                </div>
                            <div class="modal-body">
                                <input type="hidden" id="editExpenseId" name="expense_id">
                                
                                <div class="form-group">
                                    <label for="editTitle">Title</label>
                                    <input type="text" class="form-control" id="editTitle" name="title" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="editCategory">Category</label>
                                    <input type="text" class="form-control" id="editCategory" name="category" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="editAmount">Amount</label>
                                    <input type="number" class="form-control" id="editAmount" name="amount" step="0.01"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="editReference">Reference</label>
                                    <input type="file" class="form-control" id="editReference" name="reference">
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
    <script src="js/expenses.js">
    </script>
</body>

</html>

<?php
$conn->close();
?>