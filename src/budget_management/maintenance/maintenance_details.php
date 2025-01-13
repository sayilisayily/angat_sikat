<?php
// Database connection
include '../../connection.php';
include '../../session_check.php'; 
include '../../user_query.php';

// Check if 'maintenance_id' is passed in the URL
if (isset($_GET['maintenance_id']) && !empty($_GET['maintenance_id'])) {
    $maintenance_id = intval($_GET['maintenance_id']); // Get and sanitize the maintenance_id from the URL

    // Prepare SQL query to fetch maintenance details
    $stmt = $conn->prepare("SELECT * FROM maintenance WHERE maintenance_id = ?");
    
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("i", $maintenance_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if maintenance exists
    if ($result->num_rows > 0) {
        $maintenance = $result->fetch_assoc();
    } else {
        echo "No maintenance found.";
        exit;
    }

    // Fetch the items associated with the maintenance
    $itemStmt = $conn->prepare("SELECT * FROM maintenance_items WHERE maintenance_id = ?");
    
    if ($itemStmt === false) {
        die('Prepare for items failed: ' . $conn->error);
    }

    $itemStmt->bind_param("i", $maintenance_id);
    $itemStmt->execute();
    $itemsResult = $itemStmt->get_result();

    // Store items in an array
    $items = [];
    if ($itemsResult->num_rows > 0) {
        while ($row = $itemsResult->fetch_assoc()) {
            $items[] = $row;
        }
    }

    // Close the statements
    $itemStmt->close();

    // Fetch items for Financial Summary if the maintenance is accomplished
    $summaryItems = [];
    if ($maintenance['completion_status'] == 1) { // Check accomplishment status
        $summaryStmt = $conn->prepare("SELECT * FROM maintenance_summary_items WHERE maintenance_id = ?");
        if ($summaryStmt === false) {
            die('Prepare for summary items failed: ' . $conn->error);
        }
        $summaryStmt->bind_param("i", $maintenance_id);
        $summaryStmt->execute();
        $summaryResult = $summaryStmt->get_result();
        if ($summaryResult->num_rows > 0) {
            while ($row = $summaryResult->fetch_assoc()) {
                $summaryItems[] = $row;
            }
        }
        $summaryStmt->close(); 
    }
} else {
    echo "No maintenance ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Maintenance Details</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon_sikat.png"/>
    <link rel="stylesheet" href="../../assets/css/styles.min.css" />
    <!--Custom CSS for Sidebar-->
    <link rel="stylesheet" href="../../html/sidebar.css" />
    <!--Custom CSS for Activities-->
    <link rel="stylesheet" href="../../activity_management/css/activities.css" />
    <!--Boxicon-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Lordicon (for animated icons) -->
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <!--Bootstrap Script-->
    <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/sidebarmenu.js"></script>
    <script src="../../assets/js/app.min.js"></script>
    <script src="../../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../../assets/libs/simplebar/dist/simplebar.js"></script>
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
                        <img src="../../assets/images/logos/neon_sikat.png" alt="Angat Sikat Logo" class="logo contain"
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
                            <a class="sidebar-link" href="../../dashboard/officer_dashboard.php" aria-expanded="false">
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
                                    <a href="../../budget_management/budget_overview.php">Overview</a>
                                    <a href="../../budget_management/financial_plan.php">Plan</a>
                                </div>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../../budget_management/purchases/purchases.php" aria-expanded="false">
                                    <i class="bx bxs-purchase-tag" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">Purchases</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../../budget_management/maintenance/maintenance.php" aria-expanded="false">
                                    <i class="bx bxs-cog" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">MOE</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../../activity_management/activities.php" aria-expanded="false"
                                    data-tooltip="Manage Events">
                                    <i class="bx bx-calendar-event" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">Activities</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../../activity_management/calendar.php" aria-expanded="false"
                                    data-tooltip="Manage Events">
                                    <i class="bx bx-calendar" style="color: #fff; font-size: 35px;"></i>
                                    <span class="hide-menu">Calendar</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="../../budget_management/budget_approval_table.php" aria-expanded="false"
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
                                    <a href="../../income_and_expenses/income.php" onclick="closeSubmenus()">Income</a>
                                    <a href="../../income_and_expenses/expenses.php" onclick="closeSubmenus()">Expenses</a>
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
                            <a class="sidebar-link" href="../../reports/reports.php" aria-expanded="false"
                                data-tooltip="Manage Events">
                                <i class="bx bx-bar-chart-alt-2" style="color: #fff; font-size: 35px;"></i>
                                <span class="hide-menu">Reports</span>
                            </a>
                        </li>

                        <li class="sidebar-item profile-container">
                                <a class="sidebar-link" href="../../user/profile.php" aria-expanded="false" data-tooltip="Profile" style="display: flex; align-items: center; padding: 0.5rem;">
                                <div class="profile-pic-border" style="height: 4rem; width: 4rem; display: flex; justify-content: center; align-items: center; overflow: hidden;">
                                    <img src="<?php echo !empty($profile_picture) ? '../../user/uploads/' . htmlspecialchars($profile_picture) : '../../user/uploads/default.png'; ?>"
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
                                            src="<?php echo !empty($profile_picture) ? '../../user/' . $profile_picture : '../../user/uploads/default.png'; ?>"
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

            <div class="container mt-5 p-4">
                <h2><span class="text-warning fw-bold me-2">|</span> Maintenance or Other Expense Details</h2>
                <!-- Tabs for Financial Plan and Financial Summary -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="financial-plan-tab" data-bs-toggle="tab" href="#financial-plan"
                            role="tab" aria-controls="financial-plan" aria-selected="true">Financial Plan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="financial-summary-tab" data-bs-toggle="tab" href="#financial-summary"
                            role="tab" aria-controls="financial-summary" aria-selected="false">Financial Summary</a>
                    </li>
                </ul>


                <div class="tab-content mt-4 mx-3">
                <!-- Financial Plan Tab -->
                <div class="tab-pane fade show active" id="financial-plan" role="tabpanel" aria-labelledby="financial-plan-tab">

                    <!-- Maintenance Information -->
                    <h4>Title:
                        <?php echo $maintenance['title']; ?>
                    </h4>

                    <h4>Items<?php if ($maintenance['completion_status'] === 0): ?>
                        <button class="btn btn-sm btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addItemModal"><i class="fa-solid fa-plus"></i> Add Item</button>
                    <?php endif; ?></h4>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Amount</th>
                                <th>Total Amount</th>
                                <?php if ($maintenance['completion_status'] === 0): ?>
                                    <th>Actions</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grand_total = 0; // Initialize the total amount for all items
                            if (!empty($items)) {
                                foreach ($items as $item) {
                                    $total_amount = $item['quantity'] * $item['amount'];
                                    $grand_total += $total_amount; // Add to the grand total
                                    echo "<tr>
                                            <td>{$item['description']}</td>
                                            <td>{$item['quantity']}</td>
                                            <td>{$item['unit']}</td>
                                            <td>{$item['amount']}</td>
                                            <td>{$total_amount}</td>";
                                    if ($maintenance['completion_status'] === 0) {
                                        echo "<td>
                                                <button class='btn edit-btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editItemModal' data-id='{$item['item_id']}' data-description='{$item['description']}' data-quantity='{$item['quantity']}' data-unit='{$item['unit']}' data-amount='{$item['amount']}'><i class='fa-solid fa-pen'></i> Edit</button>
                                                <button class='btn delete-btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteItemModal' data-id='{$item['item_id']}'><i class='fa-solid fa-trash'></i> Delete</button>
                                            </td>";
                                    }
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No items found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Display the grand total -->
                    <div class="mt-3">
                        <h6 class="text-end">Total Amount: <span>
                            <?php echo number_format($grand_total, 2); ?>
                        </span></h6>
                    </div>
                </div>
            </div>


                    <!-- Financial Summary Tab -->
                    <div class="tab-pane fade" id="financial-summary" role="tabpanel" aria-labelledby="financial-summary-tab">
                        <?php if ($maintenance['completion_status'] === 1): ?>
                        <!-- Maintenance Information -->
                        <h4>Title:
                            <?php echo $maintenance['title']; ?>
                        </h4>

                        <h4>Items<button class="btn btn-sm btn-primary ms-3" data-bs-toggle="modal"
                        data-bs-target="#summaryAddItemModal"><i class="fa-solid fa-plus"></i> Add Item</button></h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Amount</th>
                                    <th>Total Amount</th>
                                    <th>References</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($summaryItems)) {
                                    foreach ($summaryItems as $item) {
                                        $total_amount = $item['quantity'] * $item['amount'];
                                        echo "<tr>
                                                <td>{$item['description']}</td>
                                                <td>{$item['quantity']}</td>
                                                <td>{$item['unit']}</td>
                                                <td>{$item['amount']}</td>
                                                <td>{$total_amount}</td>
                                                <td>{$item['reference']}</td>
                                                <td>
                                                    <button class='btn summary-edit-btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#summaryEditItemModal' data-id='{$item['summary_item_id']}' data-description='{$item['description']}' data-quantity='{$item['quantity']}' data-unit='{$item['unit']}' data-amount='{$item['amount']}'><i class='fa-solid fa-pen'></i> Edit</button>
                                                    <button class='btn summary-delete-btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#summaryDeleteItemModal' data-id='{$item['summary_item_id']}'><i class='fa-solid fa-trash'></i> Delete</button>
                                                </td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center'>No summary items found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <p>This maintenance has not been completed yet. The financial summary will be available once the maintenance is marked as completed.</p>
                        <?php endif; ?>
                    </div>
                </div>
                


                <!-- Add Item Modal -->
                <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="addItemForm">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addItemModalLabel">Add Item</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <!-- Modal content for adding item -->
                                    <input type="hidden" name="maintenance_id" value="<?php echo $maintenance_id; ?>">
                                    <!-- Maintenance ID -->
                                    <div class="form-group row mb-2">
                                        <div class="col">
                                            <label for="description">Description</label>
                                            <input type="text" class="form-control" id="description" name="description"
                                                required>
                                        </div>
                                        <div class="col">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-2">
                                        <div class="col">
                                            <label for="unit">Unit</label>
                                            <input type="text" class="form-control" id="unit" name="unit" required>
                                        </div>
                                        <div class="col">
                                            <label for="amount">Amount</label>
                                            <input type="number" step="0.01" class="form-control" id="amount"
                                                name="amount" required>
                                        </div>
                                    </div>

                                    <!-- Success Message Alert -->
                                    <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
                                        Item added successfully!
                                    </div>
                                    <!-- Error Message Alert -->
                                    <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert">
                                        <ul id="errorList"></ul> <!-- List for showing validation errors -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Add Item</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Item Modal -->
                <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog"
                    aria-labelledby="editItemModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="editItemForm">
                                <div class="modal-body">
                                    <input type="hidden" id="edit_item_id" name="item_id">
                                    <input type="hidden" id="edit_event_id" name="maintenance_id"
                                        value="<?php echo $maintenance_id; ?>"> <!-- Add maintenance_id -->
                                    <div class="form-group row mb-2">
                                        <div class="col">
                                            <label for="edit_description" class="form-label">Description</label>
                                            <input type="text" class="form-control" id="edit_description"
                                                name="description" required>
                                        </div>
                                        <div class="col">
                                            <label for="edit_quantity" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" id="edit_quantity" name="quantity"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-2">
                                        <div class="col">
                                            <label for="edit_unit" class="form-label">Unit</label>
                                            <input type="text" class="form-control" id="edit_unit" name="unit" required>
                                        </div>
                                        <div class="col">
                                            <label for="edit_amount" class="form-label">Amount</label>
                                            <input type="number" step="0.01" class="form-control" id="edit_amount"
                                                name="amount" required>
                                        </div>
                                    </div>

                                    <!-- Success Message Alert -->
                                    <div id="successMessage2" class="alert alert-success d-none mt-3" role="alert">
                                        Item updated successfully!
                                    </div>
                                    <!-- Error Message Alert -->
                                    <div id="errorMessage2" class="alert alert-danger d-none mt-3" role="alert">
                                        <ul id="errorList2"></ul> <!-- List for showing validation errors -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Delete Item Modal -->
                <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this item?</p>

                                <!-- Hidden form for item and Maintenance IDs -->
                                <form id="deleteItemForm">
                                    <input type="hidden" name="item_id" id="delete_item_id"> <!-- Item ID -->
                                    <input type="hidden" name="maintenance_id" id="delete_event_id" value="<?php echo $maintenance_id; ?>"> <!-- Maintenance ID -->
                                </form>

                                <!-- Success message -->
                                <div id="successMessage3" class="alert alert-success d-none"></div>
                                
                                <!-- Error message -->
                                <div id="errorMessage3" class="alert alert-danger d-none">
                                    <ul id="errorList3"></ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Item Modal for Summary Tab -->
                <div class="modal fade" id="summaryAddItemModal" tabindex="-1"
                    aria-labelledby="summaryAddItemModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="summaryAddItemForm" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="summaryAddItemModalLabel">Add Item</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="maintenance_id" value="<?php echo $maintenance_id; ?>">
                                    <!-- Dropdown to select an Maintenance -->
                                    <div class="form-group mb-2">
                                        <label for="item_selector">Select Item</label>
                                        <select class="form-control" id="item_selector" name="selected_item">
                                            <option value="">Select Item</option>
                                            <?php
                                            // Fetch events from the database

                                            foreach ($items as $item) {
                                                echo '<option value="' . htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') . '">'
                                                    . htmlspecialchars($item['description']) . '</option>';
                                            }

                                            $stmt->close();
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group row mb-2">
                                        <div class="col">
                                            <label for="summary_description">Description</label>
                                            <input type="text" class="form-control" id="summary_description"
                                                name="description" required>
                                        </div>
                                        <div class="col">
                                            <label for="summary_quantity">Quantity</label>
                                            <input type="number" class="form-control" id="summary_quantity"
                                                name="quantity" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-2">
                                        <div class="col">
                                            <label for="summary_unit">Unit</label>
                                            <input type="text" class="form-control" id="summary_unit" name="unit"
                                                required>
                                        </div>
                                        <div class="col">
                                            <label for="summary_amount">Amount</label>
                                            <input type="number" step="0.01" class="form-control" id="summary_amount"
                                                name="amount" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <label for="reference">Reference</label>
                                            <input type="file" class="form-control" id="reference" name="reference" required>
                                    </div>
                                    <div id="successMessage4" class="alert alert-success d-none mt-3"
                                        role="alert">Item added successfully!</div>
                                    <div id="errorMessage4" class="alert alert-danger d-none mt-3" role="alert">
                                        <ul id="errorList4"></ul>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Add Item</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Item Modal for Summary Tab -->
                <div class="modal fade" id="summaryEditItemModal" tabindex="-1"
                    aria-labelledby="summaryEditItemModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="summaryEditItemForm" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="summaryEditItemModalLabel">Edit Item</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="summary_edit_item_id" name="summary_item_id">
                                    <input type="hidden" id="summary_edit_event_id" name="maintenance_id"
                                        value="<?php echo $maintenance_id; ?>">
                                    <div class="form-group row mb-2">
                                        <div class="col">
                                            <label for="summary_edit_description">Description</label>
                                            <input type="text" class="form-control" id="summary_edit_description"
                                                name="description" required>
                                        </div>
                                        <div class="col">
                                            <label for="summary_edit_quantity">Quantity</label>
                                            <input type="number" class="form-control" id="summary_edit_quantity"
                                                name="quantity" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-2">
                                        <div class="col">
                                            <label for="summary_edit_unit">Unit</label>
                                            <input type="text" class="form-control" id="summary_edit_unit" name="unit"
                                                required>
                                        </div>
                                        <div class="col">
                                            <label for="summary_edit_amount">Amount</label>
                                            <input type="number" step="0.01" class="form-control"
                                                id="summary_edit_amount" name="amount" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <label for="reference">Reference</label>
                                            <input type="file" class="form-control" id="edit_reference" name="reference">
                                            <div id="currentAttachment" class="mt-2"></div>
                                    </div>
                                    <div id="successMessage5" class="alert alert-success d-none mt-3"
                                        role="alert">Item updated successfully!</div>
                                    <div id="errorMessage5" class="alert alert-danger d-none mt-3"
                                        role="alert">
                                        <ul id="editErrorList5"></ul>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Item Modal for Summary -->
                <div class="modal fade" id="summaryDeleteItemModal" tabindex="-1" aria-labelledby="summaryDeleteItemModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this item?</p>

                                <!-- Hidden form for item and Maintenance IDs -->
                                <form id="summaryDeleteItemForm">
                                    <input type="hidden" name="item_id" id="summary_delete_item_id"> <!-- Item ID -->
                                    <input type="hidden" name="maintenance_id" id="summary_delete_event_id" value="<?php echo $maintenance_id; ?>"> <!-- Maintenance ID -->
                                </form>

                                <!-- Success message -->
                                <div id="successMessage6" class="alert alert-success d-none"></div>
                                
                                <!-- Error message -->
                                <div id="errorMessage6" class="alert alert-danger d-none">
                                    <ul id="errorList6"></ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger" id="summaryConfirmDeleteBtn">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
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
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <script src="../js/maintenance_details.js"></script>
</body>

</html>