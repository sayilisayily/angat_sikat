<?php
include("../connection.php");
include '../session_check.php';

// Check if user is logged in and has officer role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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
            font-size: 1.97rem;
            /* Larger font size */
            font-weight: bold;
            margin: 1px 20px 1px 3px;
            /* Adjusted left margin to 15px (top. right. bot. left)*/
            display: block;
            color: #343a40;
        }

        .title {
            font-size: 1.5rem;
            /* Larger font size */
            font-weight: bold;
            margin: 1px 20px 1px 3px;
            /* Adjusted left margin to 15px (top. right. bot. left)*/
            display: block;
            color: #343a40;
        }


        /* Organization Card Styling */
        .organization-card {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 1.5rem;
            border-radius: 0.5rem;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 90%;
            /* Expanded width to occupy more space */
            max-width: 900px;
            /* Set max-width for large screens */
            margin: 20px 20px;
            /* Reduced left margin to bring it closer to sidebar */
            margin-left: 3px;
            /* Adjusts left margin */
            margin-right: 30px;
            /* Optional right margin if needed */
            width: 725px;
            height: 195px;
            max-width: 100%;
            /* Ensures responsive layout */
        }

        .organization-logo {
            width: 165px;
            /* Increased size of logo */
            height: 165px;
            object-fit: cover;
            border-radius: 5rem;
        }

        .organization-details {
            flex-grow: 1;
        }

        .financial-card {
            width: 200px;
            height: 120px;
            margin-right: 15px;
            /* Adjusts the space between boxes */
            margin-bottom: 1px;
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

            <div class="container-fluid">
                
                <!--  Row 1 -->
                <div class="row">
                    <!-- Welcome Message with adjusted left margin -->
                    <h1 class="welcome-message h5 fw-bold mb-4">
                        <span class="text-warning fw-bold me-2">|</span>Hello,
                        <?php echo htmlspecialchars($user['first_name']); ?>!
                    </h1>
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
                    <!--Upcoming Events-->
                    <div>
                        <h3 class="title h5 fw-bold mb-4 mt-5">
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
                                                    <button class="btn btn-outline-secondary dropdown-toggle"
                                                        type="button" id="monthDropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
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
                                                    <button class="btn btn-outline-secondary dropdown-toggle"
                                                        type="button" id="yearDropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
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
                                            <div id="days" class="days"></div>
                                        </div>
                                    </div>

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

                                </div>
                            </div>
                            
                            <!--Upcoming Events end-->
                            <?php
                                $sql = "SELECT * FROM budget_approvals WHERE archived = 0 AND status='Pending'";
                                $result = $conn->query($sql);
                            ?>
                            <!-- Approvals Table -->
                            <div>
                                <h3 class="title h5 fw-bold mb-4 mt-5">
                                    <span class="text-warning fw-bold me-2">|</span>Pending Approvals
                                </h3>
                            </div>
                            <div class="container">
                                    <div id="tableContent" class="table-responsive">
                                        <!-- Added table-responsive class -->
                                        <table class="table table-bordered">
                                            <thead class="thead-light fw-bold">
                                                <tr class="fw-bold fs-4 text-dark">
                                                    <th>Organization</th> <!-- New column for organization -->
                                                    <th>Title</th>
                                                    <th>Category</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $query = "
                                                    SELECT b.*, o.organization_name 
                                                    FROM budget_approvals b 
                                                    JOIN organizations o ON b.organization_id = o.organization_id";
                                                $result = mysqli_query($conn, $query);
                                                if ($result->num_rows > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $organization = $row['organization_name'];  // Organization name
                                                        $title = $row['title'];
                                                        $category = $row['category'];
                                                        echo
                                                        "<tr>
                                                            <td>".htmlspecialchars($organization) ."</td>
                                                            <td>".htmlspecialchars($title) ."</td>
                                                            <td>". htmlspecialchars($category)."</td>
                                                        </tr>";
                                                    }
                                                } else { 
                                                    echo
                                                    "<tr>
                                                        <td colspan='3' class='text-center'>No organizations found</td> 
                                                    </tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                            <?php
                                $sql = "SELECT * FROM organizations WHERE archived = 0";
                                $result = $conn->query($sql);
                            ?>
                            <!-- Organizations Table -->
                            <div>
                                <h3 class="title h5 fw-bold mb-4 mt-5">
                                    <span class="text-warning fw-bold me-2">|</span>Organizations
                                </h3>
                            </div>
                            <div class="container">
                                    <div id="tableContent" class="table-responsive">
                                        <!-- Added table-responsive class -->
                                        <table class="table table-bordered">
                                            <thead class="thead-light fw-bold">
                                                <tr class="fw-bold fs-4 text-dark">
                                                    <th>Name</th>
                                                    <th>Acronym</th>
                                                    <th>Logo</th>
                                                    <th>Members</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($result->num_rows > 0): ?>
                                                    <?php while ($row = $result->fetch_assoc()): ?>
                                                        <?php
                                                        $organization_logo = $row['organization_logo']; // Assuming the logo is stored as the file name
                                                        // Check if logo exists and construct the path
                                                        $logo_path = !empty($organization_logo) && file_exists('../organization_management/uploads/' . $organization_logo) 
                                                                    ? '../organization_management/uploads/' . $organization_logo 
                                                                    : '../organization_management/uploads/default_logo.png';

                                                        // Get the organization color
                                                        $organization_color = !empty($row['organization_color']) ? $row['organization_color'] : '#FFFFFF'; // Default to white if no color is set
                                                        ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($row['organization_name']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['acronym']); ?></td>
                                                            <td>
                                                                <img src="<?php echo htmlspecialchars($logo_path); ?>" alt="Logo" 
                                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                            </td>
                                                            <td><?php echo htmlspecialchars($row['organization_members']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['organization_status']); ?></td>
                                                            
                                                        </tr>
                                                    <?php endwhile; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="7" class="text-center">No organizations found</td> <!-- Updated colspan to 7 -->
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>


                            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                            <script
                                src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                            <script
                                src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                            <script
                                src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

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

                        <!-- Users start -->
                        <div>
                            <h3 class="title h5 fw-bold mb-10 mt-5">
                                <span class="text-warning fw-bold me-2">|</span>Users
                            </h3>

                            <?php 
                                    $sql = "SELECT * FROM users WHERE archived = 0";
                                    $result = $conn->query($sql);
                                ?>
                            <div class="container">
                                <div id="tableContent" class="table-responsive"> <!-- Added table-responsive class -->
                                    <table class="table table-bordered">
                                        <thead class="thead-light fw-bold">
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Organization</th>
                                                <th>Position</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch users with role = 'officer' and join with organizations table to get organization name
                                            $userQuery = "SELECT users.*, organizations.organization_name 
                                                        FROM users 
                                                        JOIN organizations ON users.organization_id = organizations.organization_id 
                                                        WHERE users.role = 'officer' AND users.archived = 0";
                                            $userResult = $conn->query($userQuery);

                                            if ($userResult->num_rows > 0) {
                                                while ($userRow = $userResult->fetch_assoc()) {
                                                    echo "<tr>
                                                            <td>{$userRow['first_name']}</td>
                                                            <td>{$userRow['last_name']}</td>
                                                            <td>{$userRow['organization_name']}</td>
                                                            <td>{$userRow['position']}</td>
                                                            
                                                        </tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center'>No users found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Users end -->

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
                            // PDF download function
                            document.getElementById('pdfButton').addEventListener('click', function () {
                                const element = document.getElementById('tableContent');
                                html2pdf()
                                    .from(element)
                                    .save('transaction_report.pdf');
                            });
                        </script>
                    </div>
                    <div class="py-6 px-6 text-center d-none d-sm-block">
                        <p class="mb-0 fs-4">© Copyright 2025 - All Rights Reserved</p>
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