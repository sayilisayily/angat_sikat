<?php
    // Include the database connection file
    include '../connection.php';
    include '../session_check.php';
    include '../user_query.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports</title>
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
                                <a class="sidebar-link" href="../user/profile.php" aria-expanded="false" data-tooltip="Profile" style="display: flex; align-items: center; padding: 0.5rem;">
                                <div class="profile-pic-border" style="height: 4rem; width: 4rem; display: flex; justify-content: center; align-items: center; overflow: hidden;">
                                    <img src="<?php echo !empty($profile_picture) ? '../user/' . htmlspecialchars($profile_picture) : '../user/uploads/default.png'; ?>"
                                        alt="Profile Picture" class="profile-pic" style="max-height: 100%; max-width: 100%; object-fit: cover;" />
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
                                            alt="Profile" style="width: 40px; height: 40px; margin-left: 10px;">
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
            <h2 class="mb-3"><span class="text-warning fw-bold me-2">|</span> Reports Management</h2>

            <!-- Report Type Cards -->
            <div class="row mb-4">
                <!-- Budget Request Card -->
                <div class="col-md">
                    <div 
                        class="card text-white gradient-card-1 mb-3 py-4" 
                        data-bs-toggle="modal" 
                        data-bs-target="#budgetRequestModal"
                        style="cursor: pointer;">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-file-invoice fa-2x mb-2"></i>
                            <h5 class="card-title">Budget Request</h5>
                        </div>
                    </div>
                </div>

                <!-- Project Proposal Card -->
                <div class="col-md">
                    <div class="card text-white gradient-card-2 mb-3 py-4"
                        data-bs-toggle="modal" 
                        data-bs-target="#projectProposalModal">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-lightbulb fa-2x mb-2"></i>
                            <h5 class="card-title">Project Proposal</h5>
                        </div>
                    </div>
                </div>

                <!-- Permit to Withdraw Card -->
                <div class="col-md">
                    <div class="card text-white gradient-card-1 mb-3 py-4"
                        data-bs-toggle="modal" 
                        data-bs-target="#permitModal">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-coins fa-2x mb-2"></i>
                            <h5 class="card-title">Permit to Withdraw</h5>
                        </div>
                    </div>
                </div>

                <!-- Liquidation Card -->
                <div class="col-md">
                    <div class="card text-white gradient-card-2 mb-3 py-4"
                        data-bs-toggle="modal" 
                        data-bs-target="#liquidationModal">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-file-circle-check fa-2x mb-2"></i>
                            <h5 class="card-title">Liquidation Report</h5>
                        </div>
                    </div>
                </div>

                <!-- Accomplishment Card -->
                <div class="col-md">
                    <div class="card text-white gradient-card-1 mb-3 py-4"
                        data-bs-toggle="modal" 
                        data-bs-target="#statementModal">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-receipt fa-2x mb-2"></i>
                            <h5 class="card-title">Financial Statement</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Table -->
            <div class="tablecontainer mt-3 p-4">
                <h4 class="mb-4">Reports
                    <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addReportModal"
                        style="height: 40px; width: 200px; border-radius: 8px; font-size: 12px;">
                        <i class="fa-solid fa-plus"></i> Add Report
                    </button>
                </h4>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Report Name</th>
                            <th>Report Type</th>
                            <th>Uploaded On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM reports WHERE organization_id=$organization_id";
                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            die("Query failed: " . mysqli_error($conn));
                        }

                        while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['file_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['report_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <button class="btn btn-secondary"><i class="fa-solid fa-file-export"></i> Export</button>
                                <button class="btn btn-primary"><i class="fa-solid fa-print"></i> Print</button>
                                <button class="btn btn-danger"><i class="fa-solid fa-archive"></i> Archive</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

            <!-- Budget Request Modal -->
            <div class="modal fade" id="budgetRequestModal" tabindex="-1" role="dialog" aria-labelledby="budgetRequestLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="budgetRequestForm" action="generate_request.php" method="POST" target="_blank">
                            <div class="modal-header">
                                <h5 class="modal-title" id="budgetRequestLabel">Generate Budget Request Report</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form fields -->
                                    <!-- Organization Name -->
                                    <?php
                                    // Fetch organization name associated with the current user's organization_id
                                    $org_query = "SELECT organization_name FROM organizations WHERE organization_id = $organization_id";
                                    $org_result = mysqli_query($conn, $org_query);

                                    if ($org_result && mysqli_num_rows($org_result) > 0) {
                                        $org_row = mysqli_fetch_assoc($org_result);
                                        $organization_name = $org_row['organization_name'];
                                    } else {
                                        $organization_name = "Unknown Organization"; // Fallback if no name is found
                                    }
                                    ?>

                                    
                                    
                                <div class="form-group row mb-2">
                                    <!-- Event Title -->
                                    <div class="col-12">
                                        <label for="event_title">Event Title</label>
                                        <select class="form-control" id="event_title" name="event_title" required>
                                            <option value="">Select Event Title</option>
                                            <?php
                                            // Fetch event titles with event_type 'expense' and accomplishment_status = 0
                                            $event_query = "SELECT title, event_id, event_start_date FROM events 
                                                            WHERE event_type = 'expense' 
                                                            AND accomplishment_status = 0 AND event_status != 'Approved'
                                                            AND organization_id = $organization_id";
                                            $result = mysqli_query($conn, $event_query);

                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . htmlspecialchars($row['title']) . '" 
                                                        data-event-id="' . htmlspecialchars($row['event_id']) . '" 
                                                        data-start-date="' . htmlspecialchars($row['event_start_date']) . '">' 
                                                        . htmlspecialchars($row['title']) . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No events available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Hidden input fields-->
                                <input type="hidden" class="form-control" id="organization_name" name="organization_name" 
                                    value="<?php echo htmlspecialchars($organization_name); ?>" readonly>
                                <input type="hidden" class="form-control" id="event_id" name="event_id">

                                <!-- Success Message Alert -->
                                <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
                                    Budget request report generated successfully!
                                </div>
                                <!-- Error Message Alert -->
                                <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="errorList"></ul> <!-- List for showing validation errors -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="">Generate Report</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Project Proposal Modal -->
            <div class="modal fade" id="projectProposalModal" tabindex="-1" role="dialog" aria-labelledby="projectProposalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="projectProposalForm" action="generate_proposal.php" method="POST" target="_blank">
                            <div class="modal-header">
                                <h5 class="modal-title" id="projectProposalLabel">Generate Project Proposal Report</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Event Title -->
                                <div class="form-group">
                                    <label for="proposal_title" class="form-label">Event Title</label>
                                    <select class="form-control" id="proposal_title" name="event_title" required>
                                        <option value="">Select Event Title</option>
                                        <?php
                                        // Fetch event titles with event_type 'expense' and accomplishment_status = 0
                                        $proposal_query = "SELECT title, event_id FROM events 
                                                        WHERE accomplishment_status = 0 AND event_status != 'Approved'
                                                        AND organization_id = $organization_id";
                                        $proposal_result = mysqli_query($conn, $proposal_query);

                                        if ($proposal_result && mysqli_num_rows($proposal_result) > 0) {
                                            while ($proposal = mysqli_fetch_assoc($proposal_result)) {
                                                echo '<option value="' . htmlspecialchars($proposal['title']) . '" 
                                                    data-event-id="' . htmlspecialchars($proposal['event_id']) . '">' 
                                                    . htmlspecialchars($proposal['title']) . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No events available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <input type="hidden" class="form-control" id="proposal_id" name="event_id">

                                <!-- Collaborators -->
                                <div class="form-group mb-3">
                                    <label for="collaborators" class="form-label">Collaborator(s)</label>
                                    <div id="collaborators" class="form-check">
                                        <!-- Add an N/A option -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="collaborator_na" name="collaborators[]" value="0">
                                            <label class="form-check-label" for="collaborator_na">None</label>
                                        </div>
                                        <?php
                                        // Fetch organization names
                                        $org_query = "SELECT organization_name, organization_id FROM organizations";
                                        $org_result = mysqli_query($conn, $org_query);

                                        if ($org_result && mysqli_num_rows($org_result) > 0) {
                                            while ($org = mysqli_fetch_assoc($org_result)) {
                                                $org_id = htmlspecialchars($org['organization_id']);
                                                $org_name = htmlspecialchars($org['organization_name']);
                                                echo '<div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="collaborator_' . $org_id . '" name="collaborators[]" value="' . $org_id . '">
                                                        <label class="form-check-label" for="collaborator_' . $org_id . '">' . $org_name . '</label>
                                                    </div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>



                                <!-- Agenda -->
                                <div class="form-group mb-3">
                                    <label for="agenda" class="form-label">Agenda (Select SDG Goals)</label>
                                    <div class="form-check">
                                        <?php
                                        $sdg_goals = [
                                            "SDG1- No Poverty",
                                            "SDG2- Zero Hunger",
                                            "SDG3- Good Health and Well-being",
                                            "SDG4- Quality Education",
                                            "SDG5- Gender Equality",
                                            "SDG6- Clean Water and Sanitation",
                                            "SDG7- Affordable and Clean Energy",
                                            "SDG8- Decent Work and Economic Growth",
                                            "SDG9- Industry, Innovation and Infrastructure",
                                            "SDG10- Reduced Inequalities",
                                            "SDG11- Sustainable Cities and Communities",
                                            "SDG12- Responsible Consumption and Production",
                                            "SDG13- Climate Action",
                                            "SDG14- Life Below Water",
                                            "SDG15- Life On Land",
                                            "SDG16- Peace, Justice and Strong Institutions",
                                            "SDG17- Partnership for the Goals"
                                        ];
                                        foreach ($sdg_goals as $goal) {
                                            echo '<div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="agenda[]" value="' . $goal . '" id="' . $goal . '">
                                                    <label class="form-check-label" for="' . $goal . '">' . $goal . '</label>
                                                </div>';
                                        }
                                        ?>
                                    </div>
                                </div>

                                <!-- Rationale -->
                                <div class="form-group mb-3">
                                    <label for="rationale" class="form-label">Rationale</label>
                                    <textarea class="form-control" id="rationale" name="rationale" rows="3" placeholder="Provide short rationale about your activity, focusing on who are the proponents and why this activity will be conducted." required></textarea>
                                </div>

                                <!-- Description -->
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe the event, focusing on when and where it will happen." required></textarea>
                                </div>

                                <!-- Objectives -->
                                <div class="form-group mb-3">
                                    <label for="general_objective" class="form-label">General Objective</label>
                                    <textarea class="form-control" id="general_objective" name="general_objective" rows="2" required></textarea>
                                </div>
                                <div id="specificObjectivesContainer" class="form-group">
                                    <label class="form-label">Specific Objectives</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="specific_objectives[]" placeholder="Specific Objective">
                                        <button type="button" class="btn btn-outline-secondary" onclick="addSpecificObjective()">+</button>
                                    </div>
                                </div>

                                <!-- Implementation Plan -->
                                <div id="implementationPlanContainer" class="form-group mb-3">
                                    <label class="form-label">Implementation Plan</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="activities[]" placeholder="Activity">
                                        <input type="date" class="form-control" name="target_dates[]">
                                        <button type="button" class="btn btn-outline-secondary" onclick="addImplementationPlan()">+</button>
                                    </div>
                                </div>

                                <!-- Implementing Guidelines -->
                                <div id="implementingGuidelinesContainer" class="form-group mb-3">
                                    <label class="form-label">Implementing Guidelines</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="guidelines[]" placeholder="Guideline">
                                        <button type="button" class="btn btn-outline-secondary" onclick="addGuideline()">+</button>
                                    </div>
                                </div>

                                <!-- Funding Source -->
                                <div class="form-group mb-3">
                                    <label for="funding_source" class="form-label">Funding Source</label>
                                    <textarea class="form-control" id="funding_source" name="funding_source" rows="2" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Generate Report</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Permit to Withdraw Modal -->
            <div class="modal fade" id="permitModal" tabindex="-1" role="dialog" aria-labelledby="permitLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="permitForm" action="generate_permit.php" method="POST" target="_blank">
                            <div class="modal-header">
                                <h5 class="modal-title" id="permitLabel">Generate Permit to Withdraw</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form fields -->
                                    
                                <div class="form-group row mb-2">
                                    <!-- Event Title -->
                                    <div class="col-12">
                                        <label for="permit_title">Event Title</label>
                                        <select class="form-control" id="permit_title" name="event_title" required>
                                            <option value="">Select Event Title</option>
                                            <?php
                                            // Fetch event titles with event_type 'expense' and accomplishment_status = 0
                                            $permit_query = "SELECT title, event_id, total_amount FROM events 
                                                            WHERE accomplishment_status = 0 AND event_status = 'Approved'
                                                            AND organization_id = $organization_id";
                                            $permit_result = mysqli_query($conn, $permit_query);

                                            if ($permit_result && mysqli_num_rows($permit_result) > 0) {
                                                while ($permit = mysqli_fetch_assoc($permit_result)) {
                                                    echo '<option value="' . htmlspecialchars($permit['title']) . '" 
                                                        data-event-id="' . htmlspecialchars($permit['event_id']) . '" 
                                                        data-amount="' . htmlspecialchars($permit['total_amount']) . '">' 
                                                        . htmlspecialchars($permit['title']) . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No events available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                        <input type="hidden" class="form-control" id="total_amount" name="total_amount" readonly>
                                       
                                <!-- Hidden input fields-->
                                <input type="hidden" class="form-control" id="permit_name" name="organization_name" 
                                    value="<?php echo htmlspecialchars($organization_name); ?>" readonly>
                                <input type="hidden" class="form-control" id="permit_id" name="event_id">
                                

                                <!-- Success Message Alert -->
                                <div id="successMessage3" class="alert alert-success d-none mt-3" role="alert">
                                    Permit to Withdraw generated successfully!
                                </div>
                                <!-- Error Message Alert -->
                                <div id="errorMessage3" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="errorList3"></ul> <!-- List for showing validation errors -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Generate Report</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Liquidation Report Modal -->
            <div class="modal fade" id="liquidationModal" tabindex="-1" role="dialog" aria-labelledby="liquidationLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="liquidationForm" action="generate_liquidation.php" method="POST" target="_blank">
                            <div class="modal-header">
                                <h5 class="modal-title" id="liquidationLabel">Generate Liquidation Report</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form fields -->
                                    
                                <div class="form-group row mb-2">
                                    <!-- Event Title -->
                                    <div class="col-12">
                                        <label for="liquidation_title">Event Title</label>
                                        <select class="form-control" id="liquidation_title" name="event_title" required>
                                            <option value="">Select Event Title</option>
                                            <?php
                                            // Fetch event titles with event_type 'expense' and accomplishment_status = 0
                                            $liquidation_query = "SELECT title, event_id, total_amount FROM events_summary
                                                            WHERE type='Expense' AND organization_id = $organization_id AND archived=0";
                                            $liquidation_result = mysqli_query($conn, $liquidation_query);

                                            if ($liquidation_result && mysqli_num_rows($liquidation_result) > 0) {
                                                while ($liquidation = mysqli_fetch_assoc($liquidation_result)) {
                                                    echo '<option value="' . htmlspecialchars($liquidation['title']) . '" 
                                                        data-event-id="' . htmlspecialchars($liquidation['event_id']) . '" 
                                                        data-amount="' . htmlspecialchars($liquidation['total_amount']) . '">' 
                                                        . htmlspecialchars($liquidation['title']) . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No events available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                        <input type="hidden" class="form-control" id="liquidation_amount" name="total_amount" readonly>
                                        
                                        
                                <div class="form-group row mb-2">
                                    <!-- Event Start Date -->
                                    <div class="col-12">
                                        <label for="cash_received">Cash Received</label>
                                        <input type="number" class="form-control" id="cash_received" name="cash_received" required>
                                        </div>
                                </div>
                                <!-- Hidden input fields-->
                                <input type="hidden" class="form-control" id="liquidation_name" name="organization_name" 
                                    value="<?php echo htmlspecialchars($organization_name); ?>" readonly>
                                <input type="hidden" class="form-control" id="liquidation_id" name="event_id">
                                

                                <!-- Success Message Alert -->
                                <div id="successMessage4" class="alert alert-success d-none mt-3" role="alert">
                                    Liquidation Report generated successfully!
                                </div>
                                <!-- Error Message Alert -->
                                <div id="errorMessage4" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="errorList4"></ul> <!-- List for showing validation errors -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Generate Report</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Financial Statement Modal -->
            <div class="modal fade" id="statementModal" tabindex="-1" role="dialog" aria-labelledby="statementLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="statementForm" action="generate_statement.php" method="POST" target="_blank">
                            <div class="modal-header">
                                <h5 class="modal-title" id="statementLabel">Generate Financial Statement</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form fields -->
                                    
                                <div class="form-group">
                                    <label for="organization_name">Organization</label>
                                    <input type="text" class="form-control" id="organization_name" name="organization_name" 
                                    value="<?php echo htmlspecialchars($organization_name); ?>" readonly>
                                </div>
                                
                                <!-- Success Message Alert -->
                                <div id="successMessage4" class="alert alert-success d-none mt-3" role="alert">
                                    Financial Statement generated successfully!
                                </div>
                                <!-- Error Message Alert -->
                                <div id="errorMessage4" class="alert alert-danger d-none mt-3" role="alert">
                                    <ul id="errorList4"></ul> <!-- List for showing validation errors -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Generate Report</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script src="js/reports.js">

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
