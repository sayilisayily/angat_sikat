<?php
    // Include the database connection file
    include 'connection.php';
    include '../session_check.php';
    include '../user_query.php';

    // Check if user is logged in and has officer role
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'officer') {
        header("Location: ../user/login.html");
        exit();
    }
    // Fetch organization data
    
    $query = "SELECT 
                beginning_balance,
                cash_on_bank,
                cash_on_hand,
                balance
            FROM 
                organizations 
            WHERE 
                organization_id = $organization_id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);

    $beginning_balance = $row['beginning_balance'];
    $cash_on_bank = $row['cash_on_bank'];
    $cash_on_hand = $row['cash_on_hand'];
    $balance = $row['balance']; 
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Budget Management</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon_sikat.png"/>
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <!--Custom CSS for Budget Overview-->
    <link rel="stylesheet" href="../budget_management/css/budget.css" />
    <!--Boxicon-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Lordicon (for animated icons) -->
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!--Bootstrap JS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

            <div class="container mt-5">

                <h2 class="mb-3"><span class="text-warning fw-bold me-2">|</span> Budget Management </h2>
                <!-- Balance Card -->
                <div class="row">
                    <div class="col-12 col-md">
                        <div class="card text-white gradient-card mb-3 py-4">
                            <div class="card-header">Balance</div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <span class="balance-value" style="display: none;">₱
                                        <?php echo number_format($balance, 2); ?>
                                    </span>
                                    <span class="balance-placeholder">****</span> <!-- Placeholder text when hidden -->
                                    <i class="fa-solid fa-eye toggle-eye" style="cursor: pointer;"></i>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <!-- Beginning Balance Card -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card gradient-card-2 text-white mb-3 py-4">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <span class="balance-value" style="display: none;">₱<?php echo number_format($beginning_balance, 2); ?></span>
                                    <span class="balance-placeholder">****</span>
                                    <i class="fa-solid fa-eye toggle-eye" style="cursor: pointer;"></i>
                                </h5>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <span>Beginning Balance</span>
                                <button class="btn btn-light edit-balance-btn" data-bs-toggle="modal" data-bs-target="#editBeginningBalanceModal" data-id="<?php echo $organization_id; ?>"><i class="fa-solid fa-pen"></i> Edit</button>
                            </div>
                        </div>
                    </div>

                    <!-- Cash on Bank Card -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card text-white gradient-card-3 mb-3 py-4">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <span class="balance-value" style="display: none;">₱<?php echo number_format($cash_on_bank, 2); ?></span>
                                    <span class="balance-placeholder">****</span>
                                    <i class="fa-solid fa-eye toggle-eye" style="cursor: pointer;"></i>
                                </h5>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <span>Cash on Bank</span>
                                <button class="btn btn-light edit-balance-btn" data-bs-toggle="modal" data-bs-target="#editCashOnBankModal" data-id="<?php echo $organization_id; ?>"><i class="fa-solid fa-pen"></i> Edit</button>
                            </div>
                        </div>
                    </div>

                    <!-- Cash on Hand Card -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card text-white gradient-card-1 mb-3 py-4">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <span class="balance-value" style="display: none;">₱<?php echo number_format($cash_on_hand, 2); ?></span>
                                    <span class="balance-placeholder">****</span>
                                    <i class="fa-solid fa-eye toggle-eye" style="cursor: pointer;"></i>
                                </h5>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <span>Cash on Hand</span>
                                <button class="btn btn-light edit-balance-btn" data-bs-toggle="modal" data-bs-target="#editCashOnHandModal" data-id="<?php echo $organization_id; ?>"><i class="fa-solid fa-pen"></i> Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pie Chart -->
                <style>
                    .chart-wrapper {
                        display: flex;
                        flex-direction: column; /* Stack title above the chart */
                        align-items: center; /* Center align contents */
                        margin: 20px; /* Space between charts */
                    }

                    .chart-title {
                        text-align: center; /* Center the title */
                        margin-bottom: 10px; /* Space between title and chart */
                    }

                    #budgetStructure, #budgetStatus {
                        margin: 0 auto; /* Center the charts */
                        max-width: 100%; /* Use full width of container */
                    }

                    .chart-container {
                        width: 100%; /* Full width */
                        max-width: 600px; /* Maximum width for larger screens */
                    }

                    @media (max-width: 768px) {
                        .chart-title {
                            font-size: 1.2em; /* Smaller title for mobile */
                        }

                        .chart-wrapper {
                            margin: 10px 0; /* Reduce margin for mobile */
                        }

                        /* Ensure the charts fit the screen width */
                        #budgetStructure, #budgetStatus {
                            max-width: 90%; /* Use more width on mobile */
                            height: auto; /* Allow height to adjust */
                        }
                    }
                </style>

                <div class="container mt-3">
                    <div class="row mt-3">
                        <div class="col text-center chart-wrapper">
                            <h4 class="chart-title">Budget Allocation</h4>
                            <div id="budgetStructure" style="height: auto;"></div>
                        </div>
                        <div class="col text-center chart-wrapper">
                            <h4 class="chart-title">Budget Status</h4>
                            <div id="budgetStatus" style="height: auto;"></div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    google.charts.load("current", { packages: ["corechart"] });
                    google.charts.setOnLoadCallback(drawCharts);

                    function drawCharts() {
                        drawBudgetStructureChart();
                        drawBudgetStatusChart();
                        window.addEventListener('resize', function () {
                            drawBudgetStructureChart();
                            drawBudgetStatusChart();
                        });
                    }

                    function drawBudgetStructureChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Category', 'Amount'],
                            <?php
                                $query = "SELECT category, allocated_budget FROM budget_allocation WHERE organization_id = $organization_id";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "['".$row['category']. "', ". (float)$row['allocated_budget']. "],";
                                }
                            ?>
                        ]);

                        var options = {
                            pieHole: 0.6,
                            colors: ['#FFDB29', '#5BD2DA', '#595FD7'],
                            pieSliceText: 'label',
                            legend: { position: 'top' },
                            height: 400, // Fixed height for better visibility
                            width: '100%' // Responsive width
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('budgetStructure'));
                        chart.draw(data, options);
                    }

                    function drawBudgetStatusChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Category', 'Amount'],
                            <?php
                                $query = "SELECT balance FROM organizations WHERE organization_id = $organization_id";
                                $result = mysqli_query($conn, $query);
                                if ($row = mysqli_fetch_assoc($result)) {
                                    echo "['Balance', ". (float)$row['balance']. "],";
                                }
                                $expenses_query = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE organization_id = $organization_id";
                                $expenses_result = mysqli_query($conn, $expenses_query);
                                if ($expenses_row = $expenses_result->fetch_assoc()) {
                                    echo "['Expense', ". (float)$expenses_row['total_expenses']. "],";
                                }
                            ?>
                        ]);

                        var options = {
                            pieHole: 0.6,
                            colors: ['#E6E6E6', '#FF7575'],
                            pieSliceText: 'label',
                            legend: { position: 'top' },
                            height: 400, // Fixed height for better visibility
                            width: '100%' // Responsive width
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('budgetStatus'));
                        chart.draw(data, options);
                    }
                </script>

                <!-- Table -->
                <style>
                    .tablecontainer {
                        padding: 1.5rem; /* Adjust padding */
                        background-color: #f8f9fa; /* Light background for contrast */
                        border-radius: 8px; /* Rounded corners */
                        box-shadow: 0 2px 10px rgba(0,0,0,0.1); /* Subtle shadow */
                    }

                    .table-responsive {
                        overflow-x: auto; /* Enable horizontal scrolling */
                        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
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
                    }
                </style>

                <div class="tablecontainer mt-3">
                    <h4 class="mb-4">
                        Budget Allocation 
                        <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addBudgetModal" style="height: 40px; width: 200px; border-radius: 8px;">
                            <i class="fa-solid fa-plus"></i> Add Budget
                        </button>
                    </h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Category</th>
                                    <th>Allocated Budget</th>
                                    <th>Total Spent</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "SELECT * FROM budget_allocation WHERE organization_id=$organization_id";
                                    $result = mysqli_query($conn, $query);

                                    if (!$result) {
                                        die("Query failed: " . mysqli_error($conn));
                                    }

                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                                        <td>₱<?php echo number_format($row['allocated_budget'], 2); ?></td>
                                        <td>₱<?php echo number_format($row['total_spent'], 2); ?></td>
                                        <td>
                                            <button class="btn btn-primary edit-btn" data-id="<?php echo $row['allocation_id']; ?>" data-bs-toggle="modal" data-bs-target="#editBudgetModal">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modals -->
            <!-- Edit Beginning Balance Modal -->
            <div class="modal fade" id="editBeginningBalanceModal" tabindex="-1" aria-labelledby="editBeginningBalanceLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Added modal-lg for larger screens -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editBeginningBalanceLabel">Edit Beginning Balance</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Success Message Alert -->
                            <div id="successMessage1" class="alert alert-success d-none position-relative mb-3" role="alert">
                                Beginning Balance updated successfully!
                            </div>
                            
                            <!-- Error Message Alert -->
                            <div id="errorMessage1" class="alert alert-danger d-none position-relative mb-3" role="alert">
                                <ul id="errorList1"></ul>
                            </div>

                            <form id="editBeginningBalanceForm">
                                <!-- Current Beginning Balance (Readonly) -->
                                <div class="mb-3">
                                    <label for="currentBeginningBalance" class="form-label">Beginning Balance</label>
                                    <input type="number" step="0.01" class="form-control" id="currentBeginningBalance" 
                                        name="current_beginning_balance" value="<?php echo $beginning_balance; ?>" readonly>
                                </div>
                                
                                <!-- Add or Subtract Amount -->
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-plus"></i></span>
                                            <input type="number" step="0.01" class="form-control" id="addAmount" name="add_amount" placeholder="Add Amount" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-minus"></i></span>
                                            <input type="number" step="0.01" class="form-control" id="subtractAmount" name="subtract_amount" placeholder="Subtract Amount" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden Organization ID -->
                                <input type="hidden" name="organization_id" value="<?php echo $organization_id; ?>">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="editBeginningBalanceForm" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Cash on Bank Modal -->
            <div class="modal fade" id="editCashOnBankModal" tabindex="-1" aria-labelledby="editCashOnBankLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Added modal-lg for larger screens -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCashOnBankLabel">Edit Cash on Bank</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Success Message Alert -->
                            <div id="successMessage2" class="alert alert-success d-none position-relative mb-3" role="alert">
                                Cash on Bank updated successfully!
                            </div>
                            <!-- Error Message Alert -->
                            <div id="errorMessage2" class="alert alert-danger d-none position-relative mb-3" role="alert">
                                <ul id="errorList2"></ul> <!-- List for showing validation errors -->
                            </div>

                            <form id="editCashOnBankForm">
                                <!-- Current Cash on Bank (Readonly) -->
                                <div class="mb-3">
                                    <label for="currentCashOnBank" class="form-label">Current Cash on Bank</label>
                                    <input type="number" step="0.01" class="form-control" id="currentCashOnBank" name="current_cash_on_bank" value="<?php echo $cash_on_bank; ?>" readonly>
                                </div>
                                <!-- Add or Subtract Amount -->
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-plus"></i></span>
                                            <input type="number" step="0.01" class="form-control" id="addCashOnBank" name="add_cash_on_bank" placeholder="Add Amount" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-minus"></i></span>
                                            <input type="number" step="0.01" class="form-control" id="subtractCashOnBank" name="subtract_cash_on_bank" placeholder="Subtract Amount" required>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="organization_id" value="<?php echo $organization_id; ?>">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="editCashOnBankForm" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Edit Cash on Hand Modal -->
            <div class="modal fade" id="editCashOnHandModal" tabindex="-1" aria-labelledby="editCashOnHandLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Added modal-lg for larger screens -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCashOnHandLabel">Edit Cash on Hand</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Success Message Alert -->
                            <div id="successMessage3" class="alert alert-success d-none position-relative mb-3" role="alert">
                                Cash on Hand updated successfully!
                            </div>
                            <!-- Error Message Alert -->
                            <div id="errorMessage3" class="alert alert-danger d-none position-relative mb-3" role="alert">
                                <ul id="errorList3"></ul> <!-- List for showing validation errors -->
                            </div>

                            <form id="editCashOnHandForm">
                                <!-- Current Cash on Hand (Readonly) -->
                                <div class="mb-3">
                                    <label for="currentCashOnHand" class="form-label">Current Cash on Hand</label>
                                    <input type="number" step="0.01" class="form-control" id="currentCashOnHand" name="current_cash_on_hand" value="<?php echo $cash_on_hand; ?>" readonly>
                                </div>
                                <!-- Add or Subtract Amount -->
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-plus"></i></span>
                                            <input type="number" step="0.01" class="form-control" id="addCashOnHand" name="add_cash_on_hand" placeholder="Add Amount" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-minus"></i></span>
                                            <input type="number" step="0.01" class="form-control" id="subtractCashOnHand" name="subtract_cash_on_hand" placeholder="Subtract Amount" required>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="organization_id" value="<?php echo $organization_id; ?>">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="editCashOnHandForm" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Budget Modal -->
            <div class="modal fade" id="addBudgetModal" tabindex="-1" aria-labelledby="addBudgetModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Added modal-lg for larger screens -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addBudgetModalLabel">Add Budget</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Success Message Alert -->
                            <div id="successMessage4" class="alert alert-success d-none position-relative mb-3" role="alert">
                                Budget allocation added successfully!
                            </div>
                            <!-- Error Message Alert -->
                            <div id="errorMessage4" class="alert alert-danger d-none position-relative mb-3" role="alert">
                                <ul id="errorList4"></ul> <!-- List for showing validation errors -->
                            </div>

                            <form id="addBudgetForm">
                                <input type="hidden" id="allocationId" name="allocation_id">
                                <!-- Hidden input for allocation ID -->
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        <?php
                                        // Fetch categories
                                        $category_query = "SELECT category_id, category FROM categories"; // Fetch both category_id and category name
                                        $category_result = mysqli_query($conn, $category_query);

                                        if (!$category_result) {
                                            // Query error
                                            echo '<option value="">Error loading categories</option>';
                                        } else {
                                            if (mysqli_num_rows($category_result) > 0) {
                                                while ($category_row = mysqli_fetch_assoc($category_result)) {
                                                    // Use category name as the value for the select option
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
                                <div class="mb-3">
                                    <label for="allocated_budget" class="form-label">Allocated Budget</label>
                                    <input type="number" class="form-control" id="allocated_budget" name="allocated_budget" required>
                                </div>
                                <input type="hidden" name="organization_id" value="<?php echo htmlspecialchars($organization_id); ?>">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="addBudgetForm" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Edit Budget Modal -->
            <div class="modal fade" id="editBudgetModal" tabindex="-1" aria-labelledby="editBudgetModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Added modal-lg for larger screens -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editBudgetModalLabel">Edit Budget</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Success Message Alert -->
                            <div id="successMessage" class="alert alert-success d-none position-relative mb-3" role="alert">
                                Budget updated successfully!
                            </div>
                            <!-- Error Message Alert -->
                            <div id="errorMessage" class="alert alert-danger d-none position-relative mb-3" role="alert">
                                <ul id="errorList"></ul> <!-- List for showing validation errors -->
                            </div>
                            
                            <form id="editBudgetForm">
                                <input type="hidden" id="edit_allocation_id" name="edit_allocation_id" required>
                                <input type="hidden" name="edit_organization_id" value="<?php echo $organization_id; ?>">
                                <!-- Hidden input for allocation ID -->
                                <div class="mb-3">
                                    <label for="edit_allocated_budget" class="form-label">Allocated Budget</label>
                                    <input type="number" class="form-control" id="edit_allocated_budget" name="edit_allocated_budget" readonly>
                                </div>
                                <!-- Add or Subtract Amount -->
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-plus"></i></span>
                                            <input type="number" step="0.01" class="form-control" id="addBudget" name="add_budget" placeholder="Add Amount" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-minus"></i></span>
                                            <input type="number" step="0.01" class="form-control" id="subtractBudget" name="subtract_budget" placeholder="Subtract Amount" required>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="editBudgetForm" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <script src="js/budget_overview.js">

            </script>
        </div>
        <!-- End of 2nd Body Wrapper -->
    </div>
    <!-- End of Overall Body Wrapper -->

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
