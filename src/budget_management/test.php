<?php
    // Include the database connection file
    include 'connection.php';
    include '../session_check.php';

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
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/angat sikat.png" />
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

                <h2 class="mb-3"><span class="text-warning fw-bold me-2">|</span> Budget Management </h2>
                <!-- Balance Card -->
                <div class="row">
                    <div class="col-md">
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
                    <div class="col-md-4">
                        <div class="card gradient-card-2 text-white mb-3 py-4">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <span class="balance-value" style="display: none;">₱<?php echo number_format($beginning_balance, 2); ?></span>
                                    <span class="balance-placeholder">****</span> <!-- Placeholder text when hidden -->
                                    <i class="fa-solid fa-eye toggle-eye" style="cursor: pointer;"></i> <!-- Default eye icon for hidden -->
                                </h5>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <span>Beginning Balance</span>
                                <button class="btn btn-light edit-balance-btn" data-bs-toggle="modal" data-bs-target="#editBeginningBalanceModal" data-id="<?php echo $organization_id; ?>"><i class="fa-solid fa-pen"></i> Edit</button>
                            </div>
                        </div>
                    </div>

                    <!-- Cash on Bank Card -->
                    <div class="col-md-4">
                        <div class="card text-white gradient-card-3 mb-3 py-4">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <span class="balance-value" style="display: none;">₱<?php echo number_format($cash_on_bank, 2); ?></span>
                                    <span class="balance-placeholder">****</span> <!-- Placeholder text when hidden -->
                                    <i class="fa-solid fa-eye toggle-eye" style="cursor: pointer;"></i> <!-- Default eye icon for hidden -->
                                </h5>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <span>Cash on Bank</span>
                                <button class="btn btn-light edit-balance-btn" data-bs-toggle="modal" data-bs-target="#editCashOnBankModal" data-id="<?php echo $organization_id; ?>"><i class="fa-solid fa-pen"></i> Edit</button>
                            </div>
                        </div>
                    </div>

                    <!-- Cash on Hand Card -->
                    <div class="col-md-4">
                        <div class="card text-white gradient-card-1 mb-3 py-4">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <span class="balance-value" style="display: none;">₱<?php echo number_format($cash_on_hand, 2); ?></span>
                                    <span class="balance-placeholder">****</span> <!-- Placeholder text when hidden -->
                                    <i class="fa-solid fa-eye toggle-eye" style="cursor: pointer;"></i> <!-- Default eye icon for hidden -->
                                </h5>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <span>Cash on Hand</span>
                                <button class="btn btn-light edit-balance-btn" data-bs-toggle="modal" data-bs-target="#editCashOnHandModal" data-id="<?php echo $organization_id; ?>"><i class="fa-solid fa-pen"></i> Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <h4 class="col">
                        <div class="vr"></div> Budget Allocation
                    </h4>
                    <h4 class="col"> Budget Status </h4>
                </div>
                <div class="row">

                    <div id="budgetStructure" class="col" style="width: 500px; height: 350px;"></div>
                    <div id="budgetStatus" class="col" style="width: 500px; height: 350px;"></div>
                </div>

                <div class="tablecontainer mt-3 p-4">
                    <h4 class="mb-4"> Budget Allocation <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addBudgetModal"
                    style="height: 40px; width: 200px; border-radius: 8px; font-size: 12px;">
                        <i class="fa-solid fa-plus"></i> Add Budget
                    </button></h4>
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
                                    <td>
                                        <?php echo htmlspecialchars($row['category']); ?>
                                    </td>
                                    <td>₱
                                        <?php echo number_format($row['allocated_budget'], 2); ?>
                                    </td>
                                    <td>₱
                                        <?php echo number_format($row['total_spent'], 2); ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary edit-btn"
                                            data-id="<?php echo $row['allocation_id']; ?>" data-bs-toggle="modal"
                                            data-bs-target="#editBudgetModal"><i class="fa-solid fa-pen"></i> Edit</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        <script src="js/budget_overview.js">

            </script>

            <script type="text/javascript">
                google.charts.load("current", { packages: ["corechart"] });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    // Prepare the data directly from the PHP code
                    var data = google.visualization.arrayToDataTable([
                        ['Category', 'Amount'],
                        <?php

                            // Fetch budget allocation data from the database
                            $query = "SELECT category, allocated_budget FROM budget_allocation WHERE organization_id = $organization_id";
                            $result = mysqli_query($conn, $query);

                            // Loop through the results and output them as JavaScript array elements
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "['".$row['category']. "', ". (float)$row['allocated_budget']. "],";
                            }
                        ?>
                    ]);

                    var options = {
                        pieHole: 0.6,
                        colors: ['#FFDB29', '#5BD2DA', '#595FD7']
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('budgetStructure'));
                    chart.draw(data, options);
                }
            </script>

            <script type="text/javascript">
                google.charts.load("current", { packages: ["corechart"] });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    // Prepare the data directly from the PHP code
                    var data = google.visualization.arrayToDataTable([
                        ['Category', 'Amount'],
                        <?php
                            // Fetch balance and total expense data from the database
                            $query = "SELECT balance FROM organizations WHERE organization_id = $organization_id"; // Fetch only balance
                            $result = mysqli_query($conn, $query);

                            // Fetch the balance
                            if ($row = mysqli_fetch_assoc($result)) {
                                echo "['Balance', ". (float)$row['balance']. "],";
                            }

                            // Now fetch total expenses from the expenses table
                            $expenses_query = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE organization_id = $organization_id";
                            $expenses_result = mysqli_query($conn, $expenses_query);

                            // Fetch the total expenses
                            if ($expenses_row = $expenses_result -> fetch_assoc()) {
                                echo "['Expense', ". (float)$expenses_row['total_expenses']. "],";
                            }
                        ?>
                    ]);


                    var options = {
                        pieHole: 0.6,
                        colors: ['#E6E6E6', '#FF7575'],
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('budgetStatus'));
                    chart.draw(data, options);
                }
            </script>

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
