<?php
// Include the database connection file
include '../connection.php';
include '../session_check.php';

// Check if user is logged in and has officer role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.html");
    exit();
}

include '../user_query.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Logs</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/angatsikat.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <!--Custom CSS for Budget Overview-->
    <link rel="stylesheet" href="../budget_management/css/budget.css" />
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
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
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

    <!-- Alert Box -->
    <div id="alertBox" class="alert alert-success alert-dismissible fade show d-none" role="alert">
        <span id="alertMessage"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="container p-4" style="margin-top: 50px;">
        <h2><span class="text-warning fw-bold me-2">|</span> Beginning Balance History</h2>

        <!-- Beginning Balance History Table -->
        <div class="table-responsive">
            <table class="table mt-4" id="beginningBalanceHistoryTable">
                <thead>
                    <tr>
                        <th>Organization</th>
                        <th>Balance</th>
                        <th>Reference</th>
                        <th>Updated At</th>
                        <th>Created By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch beginning balance history from the database
                    $query = "
                        SELECT h.amount, h.updated_at, h.reference, u.first_name, u.last_name, o.organization_name
                        FROM beginning_balance_history h
                        JOIN organizations o ON h.organization_id = o.organization_id
                        JOIN users u ON h.created_by = u.user_id
                    ";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $organization = $row['organization_name'];  // Organization name
                        $beginning_balance = number_format($row['amount'], 2);  // Format balance as currency
                        $reference = $row['reference'];
                        $updated_at = date('Y-m-d H:i:s', strtotime($row['updated_at']));  // Format date
                        $created_by = $row['first_name'] . ' ' . $row['last_name'];  // Created by
                        ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($organization); ?>
                            </td>
                            <td>
                                ₱<?php echo htmlspecialchars($beginning_balance); ?>
                            </td>
                            <td>
                                <a href="../budget_management/uploads/references/<?php echo $reference; ?>"
                                        class='link-offset-2 link-underline link-underline-opacity-0' target="_blank">
                                            <?php echo $reference; ?>
                                </a>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($updated_at); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($created_by); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="container p-4" style="margin-top: 50px;">
        <h2><span class="text-warning fw-bold me-2">|</span> Cash on Hand History</h2>

        <!-- Cash on Hand History Table -->
        <div class="table-responsive">
            <table class="table mt-4" id="cashOnHandHistoryTable">
                <thead>
                    <tr>
                        <th>Organization</th>
                        <th>Amount</th>
                        <th>Reference</th>
                        <th>Updated At</th>
                        <th>Created By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch cash on hand history from the database
                    $query = "
                        SELECT h.amount, h.updated_at, h.reference, u.first_name, u.last_name, o.organization_name
                        FROM cash_on_hand_history h
                        JOIN organizations o ON h.organization_id = o.organization_id
                        JOIN users u ON h.created_by = u.user_id
                    ";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $organization = $row['organization_name'];  // Organization name
                        $amount = number_format($row['amount'], 2);  // Format amount as currency
                        $reference = $row['reference'];
                        $updated_at = date('Y-m-d H:i:s', strtotime($row['updated_at']));  // Format date
                        $created_by = $row['first_name'] . ' ' . $row['last_name'];  // User's full name
                        ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($organization); ?>
                            </td>
                            <td>
                                ₱<?php echo htmlspecialchars($amount); ?>
                            </td>
                            <td>
                                <a href="../budget_management/uploads/references/<?php echo $reference; ?>"
                                        class='link-offset-2 link-underline link-underline-opacity-0' target="_blank">
                                            <?php echo $reference; ?>
                                </a>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($updated_at); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($created_by); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container p-4" style="margin-top: 50px;">
        <h2><span class="text-warning fw-bold me-2">|</span> Cash on Bank History</h2>

        <!-- Cash on Bank History Table -->
        <div class="table-responsive">
            <table class="table mt-4" id="cashOnBankHistoryTable">
                <thead>
                    <tr>
                        <th>Organization</th>
                        <th>Amount</th>
                        <th>Reference</th>
                        <th>Updated At</th>
                        <th>Created By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch cash on bank history from the database
                    $query = "
                        SELECT h.amount, h.updated_at, h.reference, u.first_name, u.last_name, o.organization_name
                        FROM cash_on_bank_history h
                        JOIN organizations o ON h.organization_id = o.organization_id
                        JOIN users u ON h.created_by = u.user_id
                    ";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $organization = $row['organization_name'];  // Organization name
                        $amount = number_format($row['amount'], 2);  // Format amount as currency
                        $reference = $row['reference'];
                        $updated_at = date('Y-m-d H:i:s', strtotime($row['updated_at']));  // Format date
                        $created_by = $row['first_name'] . ' ' . $row['last_name'];  // User's full name
                        ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($organization); ?>
                            </td>
                            <td>
                                ₱<?php echo htmlspecialchars($amount); ?>
                            </td>
                            <td>
                                <a href="../budget_management/uploads/references/<?php echo $reference; ?>"
                                        class='link-offset-2 link-underline link-underline-opacity-0' target="_blank">
                                            <?php echo $reference; ?>
                                </a>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($updated_at); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($created_by); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/account_logs.js"></script>
</body>

</html>