<?php
include("../connection.php");
include '../session_check.php';

// Check if user is logged in and has officer role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'officer') {
    header("Location: ../user/login.html");
    exit();
}

include '../user_query.php';
include '../organization_query.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/angatsikat.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <!--Custom CSS for Activities-->
    <link rel="stylesheet" href="../activity_management/css/activities.css" />
    <!--Boxicon-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Lordicon (for animated icons) -->
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <!--Calendar JS-->
    <script src="path/to/calendar.js"></script>

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

        .welcome-section {
            padding-left: 1.5rem;
            padding-top: 1rem;
            margin-bottom: 0.5rem;
            /* Space between welcome and organization card */
        }

        .welcome-message {
            font-size: 1.95rem;
            /* Larger font size */
            font-weight: bold;
            margin: 1px 20px 1px 3px;
            /* Adjusted left margin to 15px (top. right. bot. left)*/
            display: block;
            color: #343a40;
        }

        /* For smaller screens, you can adjust the margin or spacing if needed */
        @media (max-width: 767px) {
            .financial-card {
                margin-right: 0;
                margin-bottom: 15px;
                /* Adds spacing below each card for mobile view */
            }
        }

        .bg-purple-200 {
            background-color: #e0b3ff;
            /* Light purple for Balance */
            border-radius: 10px;
        }

        .bg-pink-200 {
            background-color: #ffe0e0;
            /* Light pink for Income */
            border-radius: 10px;
        }

        .bg-blue-200 {
            background-color: #e0f7ff;
            /* Light blue for Expense */
            border-radius: 10px;
        }

        .card h6 {
            font-size: 1rem;
            color: #555;
        }

        .card h1 {
            font-size: 1.5rem;
            color: #333;
            margin-left: 2px;
            /* Added margin for alignment */
        }

        .percentage-box {
            font-size: 0.75rem;
            /* Smaller font size */
            padding: 2px 6px;
            border-radius: 5px;
        }

        .bx-trending-up {
            font-size: 3.5rem;
            /* Further increased icon size */
        }

        .text-gray-500 {
            color: #555;
        }

        /* Main Container */
        .bg-white {
            background-color: white;
        }

        .border {
            border: 1px solid #ddd;
        }

        .shadow-md {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .text-success,
        .h1-color {
            color: #004024;
        }

        .text-secondary,
        .text-gray {
            color: gray;
        }

        /* Headings */
        h1 {
            color: #004024;
        }

        h2 {
            color: #004024;
            font-weight: bold;
        }

        /* Buttons */
        button.btn-secondary {
            background-color: gray;
            color: white;
            border: none;
        }

        button.btn-secondary:hover {
            background-color: #00542f;
        }

        /* Bar Graphs */
        .bar-graph-container .bg-success {
            background-color: #00cc72;
            width: 700px;
            /* Ensure bars fill container width */
        }

        /* Typography */
        .fw-bold {
            font-weight: bold;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .fw-medium {
            font-weight: 500;
        }

        .text-sm {
            font-size: 0.875rem;
            /* Small text size */
        }

        /* Spacing Utilities */
        .p-4 {
            padding: 1.5rem;
            /* Padding */
        }

        .mt-1 {
            margin-top: 0.25rem;
            /* Margin top small */
        }

        .mt-2 {
            margin-top: 0.5rem;
            /* Margin top medium */
        }

        .mt-3 {
            margin-top: 1rem;
            /* Margin top large */
        }

        .mx-auto {
            margin-left: auto;
            /* Center horizontally */
            margin-right: auto;
            /* Center horizontally */
        }

        /* Flexbox Utilities */
        .d-flex {
            display: flex;
            /* Enable flexbox */
        }

        .gap-3 {
            gap: 1rem;
            /* Gap between flex items */
        }

        .gap-5 {
            gap: 1.5rem;
            /* Larger gap between flex items */
        }

        .justify-content-start {
            justify-content: flex-start;
            /* Align items to the start */
        }

        .flex-column-reverse {
            flex-direction: column-reverse;
            /* Reverse column direction */
        }

        .align-items-center {
            align-items: center;
            /* Center items vertically */
        }

        .text-center {
            text-align: center;
            /* Center text */
        }

        /* Balance Report Margins */
        .balance-report {
            margin-top: auto;
            /* Adjust the top margin */
            margin-bottom: auto;
            /* Adjust the bottom margin */
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
        /* General Styles for Body Wrapper Inner */
        .body-wrapper-inner {
            margin-top: 80px;
            /* Space from the top */
            margin-bottom: 30px;
            /* Space at the bottom */
            border-radius: 20px;
            /* Rounded corners */
            min-height: calc(100vh - 110px);
            /* Minimum height for full screen */
            padding: 20px;
            /* Padding around content */
            background-color: #f8f9fa;
            /* Light background for contrast */
        }

        /* Transaction Header Styles */
        .transaction-text {
            font-size: 1.5rem;
            /* Larger font size */
            font-weight: bold;
            /* Bold font weight */
            margin: 1px 20px 1px 3px;
            /* Adjusted margins */
            display: block;
            /* Block display for proper spacing */
            color: #343a40;
            /* Dark text color for better readability */
        }

        /* Card Styles */
        .card {
            border: 1px solid #dee2e6;
            /* Light border for the card */
            border-radius: 0.5rem;
            /* Rounded corners for the card */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Soft shadow for depth */
            transition: transform 0.2s;
            /* Smooth scaling on hover */
        }

        .card:hover {
            transform: scale(1.02);
            /* Slightly scale the card on hover */
        }

        /* Card Title Styles */
        .card-title {
            font-size: 1.25rem;
            /* Title font size */
            color: #555;
            /* Medium gray color */
        }

        /* Dropdown Select Styles */
        .form-select {
            width: auto;
            /* Fit the content of the select box */
            border: 1px solid #ced4da;
            /* Border color */
            border-radius: 0.25rem;
            /* Rounded corners */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .body-wrapper-inner {
                padding: 15px;
                /* Adjust padding for smaller screens */
            }

            .card {
                margin: 10px;
                /* Reduce margin for smaller screens */
            }

            .transaction-text {
                font-size: 1.5rem;
                /* Slightly larger text on mobile */
            }
        }

        /* Centered and Expanded Container */
        .login-container {
            max-width: 1000px;
            /* Increase width for a more expanded container */
            width: 90%;
            /* Adjusts to occupy most of the viewport width */
            height: auto;
            /* Allows the container height to adapt based on content */
            display: flex;
            margin: 5% auto;
            /* Centers the container vertically and horizontally */
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Login Form Styling */
        .login-form {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #ffffff;
            /* White background for the login form */
        }

        /* Image Section Styling */
        .login-image {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .login-image img {
            width: 90%;
            /* Scales down the image for an appropriate size */
            height: auto;
            object-fit: contain;
            /* Ensures the entire image is visible without cropping */
            border-radius: 10px;
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
                                <a class="sidebar-link" href="../budget_management/purchases/purchases.php"
                                    aria-expanded="false">
                                    <i class="bx bxs-purchase-tag" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">Purchases</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../budget_management/maintenance/maintenance.php"
                                    aria-expanded="false">
                                    <i class="bx bxs-cog" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">MOE</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../activity_management/activities.php"
                                    aria-expanded="false" data-tooltip="Manage Events">
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
                                <a class="sidebar-link" href="../budget_management/budget_approval_table.php"
                                    aria-expanded="false" data-tooltip="Manage Events">
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

            <!--  Row 1 -->
            <div class="row">
                <!-- Welcome Message with adjusted left margin -->
                <div class="container mt-5">
                    <div>
                        <h1 class="welcome-message h5 fw-bold mt-1">
                            <span class="text-warning fw-bold me-2">|</span>Welcome,
                            <?php echo htmlspecialchars($user['first_name']); ?>!
                        </h1>
                    </div>

                    <!-- Organization Info Box -->
                    <div class="organization-card p-4 rounded shadow-sm bg-white border mb-4 mx-2">
                        <div class="d-flex flex-column flex-md-row align-items-start">
                            <img class="organization-logo me-3 mb-3 mb-md-0"
                                src="<?= !empty($org_logo) ? '../organization_management/uploads/' . $org_logo : '../organization_management/uploads/default_logo.png' ?>"
                                alt="<?= $org_name ?> Logo" class="img-fluid" />

                            <div class="organization-details">
                                <p class="text-muted small-text mb-1" style="font-size: 0.85rem;">Name of Student
                                    Organization</p>
                                <h1 class="fw-semibold h5 mb-2" style="font-size: 1rem;">
                                    <?= htmlspecialchars($org_name) ?>
                                </h1>
                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <div>
                                        <p class="text-muted small-text mb-1" style="font-size: 0.85rem;">No. of Members
                                        </p>
                                        <h1 class="fw-semibold h6" style="font-size: 0.95rem;">
                                            <?= htmlspecialchars($org_members) ?>
                                        </h1>
                                    </div>
                                    <div>
                                        <p class="text-muted small-text mb-1" style="font-size: 0.85rem;">Status</p>
                                        <h1 class="fw-semibold h6" style="font-size: 0.95rem;">
                                            <?= htmlspecialchars($org_status) ?>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        /* Organization Card Styling */
                        .organization-card {
                            display: flex;
                            align-items: center;
                            gap: 20px;
                            padding: 1.5rem;
                            border-radius: 0.5rem;
                            background-color: #ffffff;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            width: 98%;
                            /* Full width on mobile */
                            max-width: 1200px;
                        }

                        .organization-logo {
                            width: 165px;
                            height: 165px;
                            object-fit: cover;
                            border-radius: 5rem;
                            max-width: 100%;
                        }

                        .organization-details {
                            flex-grow: 1;
                            margin-top: 30px;
                            margin-left: 50px;
                        }

                        @media (max-width: 700px) {
                            .organization-card {
                                flex-direction: column;
                                /* Stack the logo and details */
                                align-items: center;
                                /* Center the card content */
                            }

                            .organization-logo {
                                width: 135px;
                                /* Increase logo size for mobile */
                                height: auto;
                                /* Maintain aspect ratio */
                                margin: 0 auto;
                                /* Center logo */
                                margin-left: 80px;
                            }

                            .organization-details {
                                text-align: justify;
                                /* Justify align details on mobile */
                                margin-left: 0;
                                /* Reset left margin for mobile */
                                margin-top: 1rem;
                                /* Add spacing between logo and details */
                                width: 100%;
                                /* Full width for details */
                            }
                        }

                        @media (min-width: 577px) {
                            .organization-logo {
                                max-width: 200px;
                                /* Increase logo size for larger screens */
                            }
                        }
                    </style>

                    <!-- End of Organization Info Box -->
                     
                    <!-- Financial Summary Cards Row -->
                    <div class="row justify-content-center mx-1">
                        <?php
                        // Fetch balance, income, and expense directly from the organizations table
                        $query_organization = "SELECT balance, income, expense FROM organizations WHERE organization_id = ?";
                        $stmt_organization = $conn->prepare($query_organization);
                        $stmt_organization->bind_param("i", $organization_id);
                        $stmt_organization->execute();
                        $result_organization = $stmt_organization->get_result();

                        $organization_data = $result_organization->fetch_assoc();
                        $balance = $organization_data['balance'] ?? 0; // Default to 0 if null
                        $income = $organization_data['income'] ?? 0; // Default to 0 if null
                        $expense = $organization_data['expense'] ?? 0; // Default to 0 if null

                        $stmt_organization->close();

                        // Dummy calculations for percentage changes (customize logic as needed)
                        $balance_percentage_change = 0; // Example: static or calculated based on historical data
                        $income_percentage_change = 0; // Example: static or calculated based on historical data
                        $expense_percentage_change = 0; // Example: static or calculated based on historical data
                        ?>

                        <!-- Balance Card -->
                        <div class="col-md-4 mb-3">
                            <div class="card gradient-card-2 p-3 shadow-sm mx-2">
                                <h7 class="text-white text-start d-block" style="margin-left: 2px;">Balance</h7>
                                <div class="d-flex align-items-center">
                                    <h1 class="fw-bold text-white" style="margin-left: 2px;">₱
                                        <?php echo number_format($balance); ?>
                                    </h1>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="badge bg-warning text-white fw-medium percentage-box" style="font-size: 0.75rem; padding: 2px 6px;">
                                        <?php echo number_format(abs($balance_percentage_change), 1); ?>%
                                        <?php echo $balance_percentage_change >= 0 ? '▲' : '▼'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Income Card -->
                        <div class="col-md-4 mb-3">
                            <div class="card gradient-card-1 p-3 shadow-sm mx-2">
                                <h7 class="text-white text-start d-block" style="margin-left: 2px;">Income</h7>
                                <div class="d-flex align-items-center">
                                    <h1 class="fw-bold text-white" style="margin-left: 2px;">₱
                                        <?php echo number_format($income); ?>
                                    </h1>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="badge bg-warning text-white fw-medium percentage-box" style="font-size: 0.75rem; padding: 2px 6px;">
                                        <?php echo number_format(abs($income_percentage_change), 1); ?>%
                                        <?php echo $income_percentage_change >= 0 ? '▲' : '▼'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expense Card -->
                        <div class="col-md-4 mb-3">
                            <div class="card gradient-card-3 p-3 shadow-sm mx-2">
                                <h7 class="text-white text-start d-block" style="margin-left: 2px;">Expense</h7>
                                <div class="d-flex align-items-center">
                                    <h1 class="fw-bold text-white" style="margin-left: 2px;">₱
                                        <?php echo number_format($expense); ?>
                                    </h1>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="badge bg-warning text-white fw-medium percentage-box" style="font-size: 0.75rem; padding: 2px 6px;">
                                        <?php echo number_format(abs($expense_percentage_change), 1); ?>%
                                        <?php echo $expense_percentage_change >= 0 ? '▲' : '▼'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End of Financial Summary Cards Row -->

                    <!-- Balance Report Section -->
                    <?php 
                                $query = "SELECT MONTH(updated_at) AS month, YEAR(updated_at) AS year, balance 
                                        FROM balance_history 
                                        WHERE organization_id = ? 
                                        ORDER BY year ASC, month ASC";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param('i', $organization_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                $balances = [];
                                while ($row = $result->fetch_assoc()) {
                                    $balances[] = $row; // Store all rows for rendering in the graph
                                }
                                $stmt->close();

                                // Prepare data for visualization
                                $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                $monthly_balances = array_fill(1, 12, 0); // Initialize balances for all months
                                $max_balance = 0;

                                foreach ($balances as $balance) {
                                    $monthly_balances[(int)$balance['month']] = $balance['balance'];
                                    $max_balance = max($max_balance, $balance['balance']); // Determine max balance
                                }
                                ?>

                    <div class="p-4 bg-white rounded border shadow-md justify-center mx-2 ml-auto balance-report"
                        style="width: 100%;">
                        <div class="d-flex justify-content-start gap-5 flex-wrap">
                            <h2 class="text-lg fw-bold">Balance Report</h2>
                            
                        </div>

                        <style>
                            @media (max-width: 560px) {

                                /* Small screen breakpoint */
                                .balance-report .button-group {
                                    flex-direction: column;
                                    /* Stack buttons vertically */
                                    align-items: flex-start;
                                    /* Align buttons to the start */
                                }

                                .scrollable-container {
                                    overflow-x: auto;
                                    /* Enable horizontal scrolling */
                                    white-space: nowrap;
                                    /* Prevent wrapping */
                                }
                            }
                        </style>

                        <div class="mt-2">
                            <p class="fw-semibold">Average per month</p>
                            <?php
                                        if (count($balances) > 0) {
                                            $total_balance = array_sum($monthly_balances);
                                            $average_balance = $total_balance / count($balances);
                                            echo "<h1 class='fw-bold h5 text-success'>₱" . number_format($average_balance, 2) . "</h1>";
                                        } else {
                                            echo "<h1 class='fw-bold h5 text-muted'>No data available</h1>";
                                        }
                                        ?>
                        </div>

                        <div class="container mx-auto mt-3">
                            <!-- Wrapper for horizontal scrolling on small screens -->
                            <div class="scrollable-container">
                                <!-- Bar Graph Container -->
                                <div class="row g-3">
                                    <?php
                                                foreach ($months as $index => $month) {
                                                    $month_number = $index + 1;
                                                    $month_balance = $monthly_balances[$month_number];
                                                    $height = $max_balance > 0 ? ($month_balance / $max_balance) * 100 : 0; // Scale height
                                                    echo "
                                                    <div class='col-1'>
                                                        <div class='d-flex flex-column-reverse align-items-center' style='height: 100px;'>
                                                            <div class='w-100 bg-success' style='height: {$height}px;' 
                                                                data-bs-toggle='tooltip' 
                                                                title='₱" . number_format($month_balance, 2) . "'></div>
                                                        </div>
                                                        <p class='mt-1 text-sm font-medium text-center'>{$month}</p>
                                                    </div>";
                                                }
                                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Balance Report End -->

                    <style>
                        @media (max-width: 576px) {

                            /* Small screen breakpoint */
                            .scrollable-container {
                                overflow-x: auto;
                                /* Enable horizontal scrolling */
                                white-space: nowrap;
                                /* Prevent wrapping */
                            }

                            .scrollable-container .col-1 {
                                display: inline-block;
                                /* Align items in a single row */
                                min-width: 80px;
                                /* Set a minimum width for each column */
                            }
                        }
                    </style>

                    <!-- Right Column for Advisers and Financial Deadlines (Encapsulated in a Mother Div) -->
                    <div class="mx-3">
                        <!-- Parent Flex Container -->
                        <div class="row justify-content-center mt-5" style="margin-bottom: 6px;">
                            <!-- Advisers Section -->
                            <?php
                            
                            $query = "SELECT first_name, last_name, position, picture FROM advisers WHERE organization_id = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("i", $organization_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $advisers = [];
                            while ($row = $result->fetch_assoc()) {
                                $advisers[] = $row;
                            }

                            $stmt->close();
                            ?>
                            <div class="col-12 col-sm-4 d-flex justify-content-center mb-3 mb-sm-0">
                                <div class="p-4 bg-white rounded shadow-sm" style="max-width: 300px; width: 100%;">
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semibold">Advisers</p>
                                    </div>

                                    <div class="d-flex justify-content-evenly mt-3">
                                        <?php if (!empty($advisers)) : ?>
                                            <?php foreach ($advisers as $adviser) : ?>
                                                <div class="text-center">
                                                    <img class="rounded-circle mb-3 border border-dark d-block mx-auto"
                                                        src="<?= !empty($adviser['picture']) ? '../adviser_management/uploads/' . htmlspecialchars($adviser['picture']) : '../adviser_management/uploads/default.jpg'; ?>"
                                                        alt=""
                                                        style="width: 40px; height: 40px;" />
                                                    <p class="fw-semibold text-sm text-black"><?= htmlspecialchars($adviser['first_name'] . ' ' . $adviser['last_name']); ?></p>
                                                    <p class="text-xs text-gray"><?= htmlspecialchars($adviser['position']); ?></p>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <p class="text-muted">No advisers available.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- End of Advisers Section -->

                            
                            <?php
                                        // Query to fetch the first and latest balance for the current month
                                        $query = "
                                            SELECT balance, updated_at 
                                            FROM balance_history 
                                            WHERE organization_id = ? 
                                            AND MONTH(updated_at) = MONTH(CURRENT_DATE()) 
                                            AND YEAR(updated_at) = YEAR(CURRENT_DATE())
                                            ORDER BY updated_at ASC
                                        ";

                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param("i", $organization_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        $first_balance = null;
                                        $latest_balance = null;

                                        if ($result->num_rows > 0) {
                                            $rows = $result->fetch_all(MYSQLI_ASSOC);
                                            $first_balance = $rows[0]['balance']; // First balance of the month
                                            $latest_balance = $rows[count($rows) - 1]['balance']; // Latest balance of the month
                                        }

                                        // Compute the percentage change
                                        $percentage_change = ($latest_balance && $first_balance) ? 
                                            (($latest_balance - $first_balance) / $first_balance) * 100 : 0;

                                        $remaining_balance = $latest_balance ?: 0;
                                        ?>

                            <!-- Radial Progress Container -->
                            <div class="col-12 col-sm-4 d-flex justify-content-center">
                                <div class="p-4 bg-white rounded shadow-sm" style="max-width: 300px; width: 100%;">
                                    <div class="d-flex justify-evenly gap-7 p-6">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h1 class="fw-bold fs-7">Balance</h1>
                                                <p class="fw-semibold text-secondary">Total Monthly</p>
                                                <h1 class="fw-bold h6">₱
                                                    <?php echo number_format($latest_balance, 2); ?>
                                                    <span class="badge bg-warning text-white fw-medium percentage-box"
                                                        style="font-size: 0.75rem; padding: 2px 6px;">
                                                        <?php echo number_format($percentage_change, 1); ?>%
                                                    </span>
                                                </h1>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="position-relative d-flex align-items-center justify-content-center"
                                                    style="width: 120px; height: 120px;">
                                                    <!-- Circle Background -->
                                                    <div class="position-absolute w-100 h-100 rounded-circle bg-light">
                                                    </div>

                                                    <!-- Radial Progress Circle -->
                                                    <svg class="position-absolute w-100 h-100"
                                                        style="transform: rotate(-90deg);">
                                                        <circle cx="50%" cy="50%" r="45%" stroke="currentColor"
                                                            stroke-width="10" class="text-purple-500" fill="none"
                                                            stroke-dasharray="283"
                                                            stroke-dashoffset="<?php echo 283 - (283 * $percentage_change / 100); ?>">
                                                        </circle>
                                                    </svg>

                                                    <!-- Centered Text -->
                                                    <div class="position-absolute text-center">
                                                        <p class="h6 fw-bold text-dark">₱
                                                            <?php echo number_format($remaining_balance, 2); ?>
                                                        </p>
                                                        <p class="text-sm fw-semibold text-secondary">Remaining balance
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- End of Radial Progress Container -->
                            </div>
                        </div> <!-- End of Parent Flex Container -->
                    </div> <!-- End of Right Column -->
                    <?php

                    // Fetch top 5 records from income and expenses tables
                    $query = "
                        SELECT 'Income' AS type, title AS description, amount, created_at AS date
                    FROM income
                    WHERE organization_id = ?
                    UNION ALL
                    SELECT 'Expense' AS type, title AS description, amount, created_at AS date
                    FROM expenses
                    WHERE organization_id = ?
                    ORDER BY date DESC
                    LIMIT 5;
                    ";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ii", $organization_id, $organization_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $transactions = [];
                    while ($row = $result->fetch_assoc()) {
                        $transactions[] = $row;
                    }

                    $stmt->close();
                    ?>
                    <div>
                        <h3 class="welcome-message h5 fw-bold mb-4 mt-5">
                            <span class="text-warning fw-bold me-2">|</span>Recent Transactions
                        </h3>
                    </div>
                    <div class="container mt-5">
                        <div id="tableContent" class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light fw-bold">
                                    <tr class="fw-bold fs-4 text-dark">
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($transactions)): ?>
                                        <?php foreach ($transactions as $transaction): ?>
                                            <tr>
                                                <td>
                                                    <?php echo htmlspecialchars($transaction['type']); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($transaction['description']); ?>
                                                </td>
                                                <td>₱
                                                    <?php echo number_format($transaction['amount'], 2); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars(date("F j, Y", strtotime($transaction['date']))); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No transactions found for this organization.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

                <!--Recent Transaction dashboard end-->

                <?php
                    // Fetch the two nearest upcoming events
                    $query = "
                    SELECT e.title, e.event_start_date, e.event_end_date, e.event_venue, o.organization_name
                    FROM events e
                    JOIN organizations o ON e.organization_id = o.organization_id
                    WHERE e.event_start_date > CURDATE() 
                    ORDER BY e.event_start_date ASC
                    LIMIT 2
                    ";
                    $result = $conn->query($query);

                    // Check if the query was successful and fetch the events
                    if ($result->num_rows > 0) {
                    $events = $result->fetch_all(MYSQLI_ASSOC);
                    } else {
                    $events = [];
                    }
                    ?>
            </div>

            <style>
                @media (max-width: 768px) {
                    .responsive-container {
                        overflow-x: auto;
                        /* Enable horizontal scrolling */
                        width: 100%;
                        /* Full width on smaller screens */
                    }

                    .balance-report {
                        width: 725px;
                        /* Maintain original width on larger screens */
                    }
                }
            </style>


            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                        new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                });
            </script>

            <!--Upcoming Events-->
            <div>
                <h3 class="welcome-message h5 fw-bold mb-4 mt-5">
                    <span class="text-warning fw-bold me-2">|</span>Upcoming Events
                </h3>
                <div class="mx-auto">
                    <!--event boxes-->
                    <div class="container mt-5">
                        <div class="row">
                            <?php if (!empty($events)) : ?>
                            <?php foreach ($events as $event) : ?>
                            <div class="col-md-4">
                                <div class="container-white">
                                    <div class="event-box">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="event-title">
                                                <?php echo htmlspecialchars($event['organization_name']); ?>
                                            </h6>

                                            <?php
                                                    // Get today's date
                                                    $today = new DateTime();
                                                    // Event's start date
                                                    $eventStartDate = new DateTime($event['event_start_date']);
                                                    // Calculate the difference between today's date and the event start date
                                                    $interval = $today->diff($eventStartDate);
                                                    // Format the number of days left
                                                    $daysLeft = $interval->format('%r%a'); // %r gives the sign (+ or -) and %a gives the total number of days
                                                    $daysLeftText = ($daysLeft >= 0) ? $daysLeft . " Days Left" : "Event Passed"; // Show if event has passed
                                                    ?>
                                            <p class="event-duration text-sm">
                                                <?php echo $daysLeftText; ?>
                                            </p>
                                        </div>
                                        <h5>
                                            <?php echo htmlspecialchars($event['title']); ?>
                                        </h5>
                                        <div class="event-details">
                                            <p class="event-date"><i class="fa-regular fa-calendar"
                                                    aria-hidden="true"></i>
                                                <?php echo date("d M Y", strtotime($event['event_start_date'])) . ' - ' . date("d M Y", strtotime($event['event_end_date'])); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else : ?>
                            <p>No upcoming events.</p>
                            <?php endif; ?>

                            <style>
                                .container-white {
                                    background-color: white;
                                    padding: 20px;
                                    border-radius: 15px;
                                    border: 1px solid #ddd;
                                    /* Light gray border */
                                    margin-bottom: 20px;
                                    height: 250px;
                                    /* Fixed height */
                                    display: flex;
                                    flex-direction: column;
                                }

                                .event-box {
                                    color: #333;
                                    display: flex;
                                    flex-direction: column;
                                    height: 100%;
                                }

                                .event-box h6 {
                                    font-weight: bold;
                                    color: #666;
                                    margin-bottom: 30px;
                                    /* Adds spacing below h6 */
                                }

                                .event-title {
                                    font-size: 1rem;
                                    /* Adjust font size for fitting */
                                    flex: 1;
                                    /* Ensures the title takes up available space */
                                    margin: 0;
                                    /* Removes any extra margin */
                                    font-weight: bold;
                                    /* Makes text bold */
                                }

                                .event-duration {
                                    font-size: 1rem;
                                    /* Matches title size */
                                    font-weight: bold;
                                    /* Makes text bold */
                                    color: #666;
                                    margin-left: 10px;
                                    /* Adds spacing from title */
                                }

                                .event-box h5 {
                                    font-weight: bold;
                                    color: #000;
                                    margin: 5px 0 20px 0;
                                    /* Adds 25px spacing below h5 */
                                }


                                .event-details {
                                    display: flex;
                                    gap: 15px;
                                    /* Increases spacing between date and time */
                                    align-items: center;
                                    color: #2e7d32;
                                    /* Green color for icons and text */
                                    margin-bottom: 10px;
                                    /* Adds spacing below event details */
                                }

                                .event-date,
                                .event-time {
                                    font-size: 1.1rem;
                                    /* Increases font size for emphasis */
                                    font-weight: bold;
                                    /* Makes text bold */
                                    margin-top: 5px;
                                    /* Creates distance from top */
                                    display: flex;
                                    align-items: center;
                                }

                                .event-details i {
                                    margin-right: 5px;
                                }

                                .details-btn {
                                    background-color: #ffc107;
                                    /* Yellow color for button */
                                    color: #fff;
                                    border: none;
                                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                                    width: 100px;
                                }

                                .details-btn:hover {
                                    background-color: #e0a800;
                                }
                            </style>
                    

                            <!-- Calendar Box -->
                            <div class="col-md-4">
                                <div class="calendar">
                                    <div class="header">
                                        <!-- Month Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                id="monthDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-regular fa-calendar"></i> <span
                                                    id="selectedMonth">August</span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="monthDropdown">
                                                <!-- Month Options -->
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectMonth(event, 0)">January</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectMonth(event, 1)">February</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectMonth(event, 2)">March</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectMonth(event, 3)">April</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectMonth(event, 4)">May</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectMonth(event, 5)">June</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectMonth(event, 6)">July</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectMonth(event, 7)">August</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectMonth(event, 8)">September</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectMonth(event, 9)">October</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectMonth(event, 10)">November</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectMonth(event, 11)">December</a></li>
                                            </ul>
                                        </div>

                                        <!-- Year Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                id="yearDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-regular fa-calendar"></i> <span
                                                    id="selectedYear">2024</span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="yearDropdown">
                                                <!-- Year Options -->
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectYear(event, 2023)">2023</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectYear(event, 2024)">2024</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectYear(event, 2025)">2025</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="selectYear(event, 2026)">2026</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Days of the Week Headers -->
                                    <div class="days-of-week">
                                        <div class="day-header">Sun</div>
                                        <div class="day-header">Mon</div>
                                        <div class="day-header">Tue</div>
                                        <div class="day-header">Wed</div>
                                        <div class="day-header">Thu</div>
                                        <div class="day-header">Fri</div>
                                        <div class="day-header">Sat</div>
                                    </div>

                                    <!-- Days Container -->
                                    <div id="days" class="days transparent-days"></div>
                                </div>
                            </div>


<!-- JavaScript -->
<script>
    let currentDate = new Date();

    function renderCalendar() {
        const month = currentDate.getMonth();
        const year = currentDate.getFullYear();

        // Update displayed month and year in the dropdown buttons
        document.getElementById('selectedMonth').textContent = currentDate.toLocaleString('default', { month: 'long' });
        document.getElementById('selectedYear').textContent = year;

        // Clear previous days
        const daysContainer = document.getElementById('days');
        daysContainer.innerHTML = '';

        const firstDay = new Date(year, month, 1).getDay();
        const lastDay = new Date(year, month + 1, 0).getDate();

        // Blank days before the first day of the month
        for (let i = 0; i < firstDay; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'day empty';
            daysContainer.appendChild(emptyDay);
        }

        // Days of the month
        for (let i = 1; i <= lastDay; i++) {
            const day = document.createElement('div');
            day.className = 'day';
            day.textContent = i;
            day.addEventListener('click', () => selectDay(i));
            daysContainer.appendChild(day);
        }
    }

    function selectMonth(event, month) {
        event.preventDefault(); // Prevents the page from scrolling to the top
        currentDate.setMonth(month);
        renderCalendar();
    }

    function selectYear(event, year) {
        event.preventDefault(); // Prevents the page from scrolling to the top
        currentDate.setFullYear(year);
        renderCalendar();
    }

    // Initial render
    renderCalendar();
</script>

                            <!-- CSS for Scrollable Dropdown -->
                            <style>
                                .calendar {
                                    border: 1px solid #ccc;
                                    background-color: #fff;
                                    border-radius: 8px;
                                    padding: 10px;
                                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                                    height: 265px;
                                    overflow: hidden;
                                }

                                .header {
                                    display: flex;
                                    gap: 10px;
                                    justify-content: space-between;
                                    align-items: center;
                                    margin-bottom: 5px;
                                }

                                .days-of-week {
                                    display: grid;
                                    grid-template-columns: repeat(7, 1fr);
                                    margin-bottom: 5px;
                                }

                                .day-header {
                                    font-weight: bold;
                                    text-align: center;
                                    color: black;
                                }

                                .days {
                                    display: grid;
                                    grid-template-columns: repeat(7, 1fr);
                                    grid-auto-rows: 30px;
                                    overflow-y: auto;
                                    height: calc(100% - 90px);
                                }

                                .day {
                                    padding: 5px;
                                    text-align: center;
                                    border: 1px solid #ddd;
                                    transition: background-color 0.2s;
                                    cursor: pointer;
                                }

                                .day:hover {
                                    background-color: #e9ecef;
                                }

                                .dropdown-menu {
                                    max-height: 200px;
                                    overflow-y: auto;
                                    color: #00542F;
                                }

                                /* Button and icon color */
                                .btn-outline-secondary.dropdown-toggle {
                                    color: #00542F;
                                    /* Text color */
                                    border-color: #00542F;
                                    /* Border color */
                                }

                                /* Button hover state */
                                .btn-outline-secondary.dropdown-toggle:hover {
                                    background-color: #00542F;
                                    /* Background color on hover */
                                    color: #fff;
                                    /* Text color on hover */
                                }

                                /* Dropdown menu item color */
                                .dropdown-menu .dropdown-item {
                                    color: #00542F;
                                }

                                /* Dropdown menu item hover color */
                                .dropdown-menu .dropdown-item:hover {
                                    background-color: #00542F;
                                    color: #fff;
                                }
                            </style>

                            <!-- JavaScript -->
                            <script>

                                function renderCalendar() {
                                    const month = currentDate.getMonth();
                                    const year = currentDate.getFullYear();

                                    // Update displayed month and year in the dropdown buttons
                                    document.getElementById('selectedMonth').textContent = currentDate.toLocaleString('default', { month: 'long' });
                                    document.getElementById('selectedYear').textContent = year;

                                    // Clear previous days
                                    const daysContainer = document.getElementById('days');
                                    daysContainer.innerHTML = '';

                                    const firstDay = new Date(year, month, 1).getDay();
                                    const lastDay = new Date(year, month + 1, 0).getDate();

                                    // Blank days before the first day of the month
                                    for (let i = 0; i < firstDay; i++) {
                                        const emptyDay = document.createElement('div');
                                        emptyDay.className = 'day empty';
                                        daysContainer.appendChild(emptyDay);
                                    }

                                    // Days of the month
                                    for (let i = 1; i <= lastDay; i++) {
                                        const day = document.createElement('div');
                                        day.className = 'day';
                                        day.textContent = i;
                                        day.addEventListener('click', () => selectDay(i));
                                        daysContainer.appendChild(day);
                                    }
                                }

                                function selectMonth(event, month) {
                                    event.preventDefault(); // Prevents the page from scrolling to the top
                                    currentDate.setMonth(month);
                                    renderCalendar();
                                }

                                function selectYear(event, year) {
                                    event.preventDefault(); // Prevents the page from scrolling to the top
                                    currentDate.setFullYear(year);
                                    renderCalendar();
                                }
                                // Initial render
                                renderCalendar();
                            </script>

                        </div>
                    </div>
                    <!--Upcoming Events end-->

                    <!-- Activities start -->
                    <div>
                        <h3 class="welcome-message h5 fw-bold mb-10 mt-5">
                            <span class="text-warning fw-bold me-2">|</span>Activities
                        </h3>

                        <?php 
                            $sql = "SELECT * FROM events WHERE archived = 0 AND organization_id = $organization_id ORDER BY event_id DESC LIMIT 5";
                            $result = $conn->query($sql);
                        ?>
                        <div class="container">
                            <div id="tableContent" class="table-responsive"> <!-- Added table-responsive class -->
                                <table class="table table-bordered">
                                    <thead class="thead-light fw-bold">
                                        <tr>
                                            <th rowspan=2>Title</th>
                                            <th rowspan=2>Venue</th>
                                            <th colspan=2 style="text-align: center;"> Date </th>
                                            <th rowspan=2>Type</th>
                                            <th rowspan=2>Status</th>
                                            <th rowspan=2>Accomplished</th>
                                        </tr>
                                        <tr>
                                            <th>Start</th>
                                            <th>End</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $checked = $row['accomplishment_status'] ? 'checked' : '';
                            $disabled = ($row['event_status'] !== 'Approved') ? 'disabled' : '';
                            echo "<tr>
                                    <td><a class='link-offset-2 link-underline link-underline-opacity-0' href='event_details.php?event_id={$row['event_id']}'>{$row['title']}</a></td>
                                    <td>{$row['event_venue']}</td>
                                    <td>" . date('F j, Y', strtotime($row['event_start_date'])) . "</td>
                                    <td>" . date('F j, Y', strtotime($row['event_end_date'])) . "</td>
                                    <td>{$row['event_type']}</td>
                                    <td>";
                            // Handle event status with badges
                            if ($row['event_status'] == 'Pending') {
                                echo "<span class='badge rounded-pill pending'>Pending</span>";
                            } elseif ($row['event_status'] == 'Approved') {
                                echo "<span class='badge rounded-pill approved'>Approved</span>";
                            } elseif ($row['event_status'] == 'Disapproved') {
                                echo "<span class='badge rounded-pill disapproved'>Disapproved</span>";
                            }
                            echo "</td>";
                            // Render accomplishment status
                            echo "<td>";
                            echo ($row['accomplishment_status'] == 1) 
                                ? "Accomplished" 
                                : "Not Accomplished";
                            echo "</td>";
                            echo "</tr>";
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
                    <!-- Activities end -->

                    <style>
                        .custom-btn {
                            background-color: #00542F;
                            border-color: #00542F;
                            color: #ffffff;
                            /* Text color */
                        }

                        .custom-btn:hover {
                            background-color: #004026;
                            /* Darker shade for hover */
                            border-color: #004026;
                        }
                    </style>

                    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                    <script
                        src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

                    <script>
                                            
                    const notificationBtn = document.getElementById("notificationBtn");
                    const notificationDropdown = document.getElementById("notificationDropdown");
                    const notificationList = document.getElementById("notificationList");
                    const notificationCount = document.getElementById("notificationCount");
                    const noNotifications = document.getElementById("noNotifications");

                    // Toggle Dropdown Visibility
                    notificationBtn.addEventListener("click", () => {
                    const isVisible = notificationDropdown.style.display === "block";
                    notificationDropdown.style.display = isVisible ? "none" : "block";
                    });

                    // Load Notifications Dynamically
                    function loadNotifications() {
                    fetch("../get_notifications.php")
                        .then((response) => response.json())
                        .then((data) => {
                        notificationList.innerHTML = ""; // Clear existing notifications
                        if (data.length > 0) {
                            data.forEach((notification) => {
                            const notificationItem = document.createElement("div");
                            notificationItem.classList.add("notification-item");
                            notificationItem.style.padding = "10px";
                            notificationItem.style.borderBottom = "1px solid #ccc";
                            notificationItem.textContent = notification.message;

                            // Add data-id attribute for the notification ID
                            notificationItem.dataset.id = notification.id;

                            // Attach click event to mark as read
                            notificationItem.addEventListener("click", () => {
                                markAsRead(notification.id);
                                notificationItem.style.opacity = 0.5; // Visual indicator (optional)
                            });

                            notificationList.appendChild(notificationItem);
                            });

                            notificationCount.textContent = data.length;
                            notificationCount.style.display = "inline-block";
                            noNotifications.style.display = "none";
                        } else {
                            noNotifications.style.display = "block";
                            notificationCount.style.display = "none";
                        }
                        })
                        .catch((error) => {
                        console.error("Error loading notifications:", error);
                        });
                    }

                    function updateNotificationCount() {
                    const currentCount = parseInt(notificationCount.textContent, 10) || 0;
                    if (currentCount > 0) {
                        notificationCount.textContent = currentCount - 1;
                        if (currentCount - 1 === 0) {
                        notificationCount.style.display = "none";
                        noNotifications.style.display = "block";
                        }
                    }
                    }

                    // Initial Load
                    loadNotifications();

                    // Optionally, refresh notifications periodically (e.g., every 30 seconds)
                    setInterval(loadNotifications, 30000);

                    // Close dropdown if clicked outside
                    document.addEventListener("click", (e) => {
                    if (
                        !notificationBtn.contains(e.target) &&
                        !notificationDropdown.contains(e.target)
                    ) {
                        notificationDropdown.style.display = "none";
                    }
                    });

                    // Function to mark a notification as read
                    async function markAsRead(notificationId) {
                    try {
                        await fetch("../notification_read.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({ id: notificationId }),
                        });

                        // Optional: update notification count after marking as read
                        updateNotificationCount();
                    } catch (error) {
                        console.error("Error marking notification as read:", error);
                    }
                    }


                    </script>
                </div>
                <div class="py-6 px-6 text-center d-none d-sm-block">
                    <p class="mb-0 fs-4">© Copyright 2025 All Rights Reserved</p>
                </div>
            </div>
        </div>
    </div>
    </div>
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