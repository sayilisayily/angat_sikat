<?php
session_start();
include("../connection.php");

// Check if user is logged in and has officer role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'officer') {
    header("Location: ../authentication-login.html");
    exit();
}

// Fetch officer data if needed
$user_id = $_SESSION['user_id'];
$query = "SELECT username, first_name, last_name, email FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "Error fetching user data: " . mysqli_error($conn);
    exit(); // Stop further execution if there is an error
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            background-color: #1b5e20;
            color: white;
            padding-top: 20px;
            transition: width 0.3s;
        }

        .sidebar.collapsed {
            width: 0;
            overflow: hidden;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 15px;
        }

        .sidebar a:hover {
            background-color: #144d15;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #ffffff;
            padding: 0 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand {
            color: #1b5e20;
            font-weight: bold;
        }

        .navbar .profile-info {
            display: flex;
            align-items: center;
        }

        .navbar .profile-info img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .navbar .profile-info .dropdown-menu a {
            color: #333;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h3 class="text-center">ANGAT SIKAT</h3>
        <a href="officer_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="manage_events.php"><i class="fas fa-calendar-alt"></i> Manage Events</a>
        <a href="budget_requests.php"><i class="fas fa-money-bill-wave"></i> Budget Requests</a>
        <a href="reports.php"><i class="fas fa-chart-line"></i> Reports</a>
    </div>

    <!-- Main content area -->
    <div class="content">

        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg">
            
            <button class="navbar-toggler" type="button" id="sidebarToggle">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <button class="btn btn-outline-primary me-2" id="notificationBtn">
                    <i class="fas fa-bell"></i>
                </button>
                <div class="profile-info">
                    <img src="../images/default_user_icon.png" alt="Profile" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden"><?php echo htmlspecialchars($user['username']); ?></span> <!-- Visually hide username -->
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="edit_profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a></li>
                                    <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                </ul>
                            </div>
                    <div class="me-5">
                        <h5 class="fw-semibold mb-0"><?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?></h1>
                        <p class="text-secondary mb-0"><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    
                </div>
                
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div class="container-fluid mt-4">
            <h2>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h2>
            <p>This is your dashboard where you can manage events, submit budget requests, and view reports.</p>
            <!-- Add more dashboard content here -->
             

        <div class="d-md-flex justify-content-evenly">
            <!-- First Container -->
            <div class="h-100 p-1 w-50">
            <div class="d-flex justify-content-start mt-4 mb-4">
                <h1 class="h5 fw-black fs-10">
                <span class="text-warning fw-bold me-2 fs-10">|</span>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!
                </h1>
            </div>

            <!-- Organization Info Box -->
            <div class="p-4 bg-white rounded shadow-sm d-flex flex-column mt-4 mb-6 border">
                <img
                class="h-40 w-40 object-cover me-3"
                src="..images/beacon.jpg"
                alt="beacon"
                />
                <div class="flex-column">
                <p class="text-secondary font-normal">Name of Student Organization</p>
                <h1 class="fw-semibold h6">Beacon Of Youth Technology Enthusiasts</h1>
                <div class="d-flex gap-3">
                    <div>
                    <p class="text-secondary font-normal">No. of Members</p>
                    <h1 class="fw-semibold h6">557</h1>
                    </div>
                    <div>
                    <p class="text-secondary font-normal">Status</p>
                    <h1 class="fw-semibold h6">Level 1</h1>
                    </div>
                </div>
                </div>
            </div>

            <!-- Grid Boxes -->
            <div class="row g-3">
                <!-- Box 1 -->
                <div class="col-12 col-md-4 shadow-sm border">
                <div class="p-4 bg-purple-200 rounded shadow-md d-flex flex-column">
                    <h1 class="text-black fw-bold fs-7">Balance</h1>
                    <div class="d-flex justify-content-between align-items-center">
                    <h1 class="fw-bold h5">₱58,690</h1>
                    <i class="bx bx-trending-up text-4xl text-success"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                    <p class="fw-bold">Monthly</p>
                    <p class="bg-warning rounded h-25 px-2 text-white fw-medium d-flex align-items-center justify-content-center">
                        13.4% *
                    </p>
                    </div>
                </div>
                </div>

                <!-- Box 2 -->
                <div class="col-12 col-md-4 shadow-sm border">
                <div class="p-4 bg-blue-200 rounded shadow-md d-flex flex-column">
                    <h1 class="text-black fw-bold fs-7">Balance</h1>
                    <div class="d-flex justify-content-between align-items-center">
                    <h1 class="fw-bold h5">₱59,690</h1>
                    <i class="bx bx-trending-up text-4xl text-success"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                    <p class="fw-bold">Quarterly</p>
                    <p class="bg-warning rounded h-25 px-2 text-white fw-medium d-flex align-items-center justify-content-center">
                        13.4% *
                    </p>
                    </div>
                </div>
                </div>

                <!-- Box 3 -->
                <div class="col-12 col-md-4 shadow-sm border">
                <div class="p-4 bg-pink-200 rounded shadow-md d-flex flex-column">
                    <h1 class="text-black fw-bold fs-7">Balance</h1>
                    <div class="d-flex justify-content-between align-items-center">
                    <h1 class="fw-bold h5">₱60,690</h1>
                    <i class="bx bx-trending-up text-4xl text-success"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                    <p class="fw-bold">Yearly</p>
                    <p class="bg-warning rounded h-25 px-2 text-white fw-medium d-flex align-items-center justify-content-center">
                        13.4% *
                    </p>
                    </div>
                </div>
                </div>
            </div>

            <!-- Balance Report Section -->
            <div class="p-4 bg-white mx-auto rounded border shadow-md justify-center mt-3 d-none d-sm-block">
                <div class="d-flex justify-content-start gap-5">
                <h2 class="text-lg fw-bold">Balance Report</h2>
                <div class="d-flex gap-3">
                    <button class="btn btn-secondary btn-sm">Monthly</button>
                    <button class="btn btn-secondary btn-sm">Quarterly</button>
                    <button class="btn btn-secondary btn-sm">Yearly</button>
                </div>
                </div>
                <div class="mt-2">
                <p class="fw-semibold">Average per month</p>
                <h1 class="fw-bold h5 text-success">₱5,500</h1>
                <p class="fw-medium mt-1 text-secondary">Median ₱45,000</p>
                </div>

                <div class="container mx-auto mt-3">
                <!-- Bar Graph Container -->
                <div class="row g-3">
                    <!-- Bar for January -->
                    <div class="col-1">
                    <div class="d-flex flex-column-reverse align-items-center" style="height: 100px;">
                        <div class="w-100 bg-success" style="height: 90px;"></div>
                    </div>
                    <p class="mt-1 text-sm font-medium text-center">Jan</p>
                    </div>
                
                    <!-- Bar for February -->
                    <div class="col-1">
                    <div class="d-flex flex-column-reverse align-items-center" style="height: 100px;">
                        <div class="w-100 bg-success" style="height: 70px;"></div>
                    </div>
                    <p class="mt-1 text-sm font-medium text-center">Feb</p>
                    </div>
                
                    <!-- Bar for March -->
                    <div class="col-1">
                    <div class="d-flex flex-column-reverse align-items-center" style="height: 100px;">
                        <div class="w-100 bg-success" style="height: 50px;"></div>
                    </div>
                    <p class="mt-1 text-sm font-medium text-center">Mar</p>
                    </div>
                
                    <!-- Bar for April -->
                    <div class="col-1">
                    <div class="d-flex flex-column-reverse align-items-center" style="height: 100px;">
                        <div class="w-100 bg-success" style="height: 30px;"></div>
                    </div>
                    <p class="mt-1 text-sm font-medium text-center">Apr</p>
                    </div>
                
                    <!-- Bar for May -->
                    <div class="col-1">
                    <div class="d-flex flex-column-reverse align-items-center" style="height: 100px;">
                        <div class="w-100 bg-success" style="height: 10px;"></div>
                    </div>
                    <p class="mt-1 text-sm font-medium text-center">May</p>
                    </div>
                
                    <!-- Bar for June -->
                    <div class="col-1">
                    <div class="d-flex flex-column-reverse align-items-center" style="height: 100px;">
                        <div class="w-100 bg-success" style="height: 20px;"></div>
                    </div>
                    <p class="mt-1 text-sm font-medium text-center">Jun</p>
                    </div>
                
                    <!-- Bar for July -->
                    <div class="col-1">
                    <div class="d-flex flex-column-reverse align-items-center" style="height: 100px;">
                        <div class="w-100 bg-success" style="height: 40px;"></div>
                    </div>
                    <p class="mt-1 text-sm font-medium text-center">Jul</p>
                    </div>
                
                    <!-- Bar for August -->
                    <div class="col-1">
                    <div class="d-flex flex-column-reverse align-items-center" style="height: 100px;">
                        <div class="w-100 bg-success" style="height: 30px;"></div>
                    </div>
                    <p class="mt-1 text-sm font-medium text-center">Aug</p>
                    </div>
                
                    <!-- Bar for September -->
                    <div class="col-1">
                    <div class="d-flex flex-column-reverse align-items-center" style="height: 100px;">
                        <div class="w-100 bg-success" style="height: 40px;"></div>
                    </div>
                    <p class="mt-1 text-sm font-medium text-center">Sep</p>
                    </div>
                
                    <!-- Bar for October -->
                    <div class="col-1">
                    <div class="d-flex flex-column-reverse align-items-center" style="height: 100px;">
                        <div class="w-100 bg-success" style="height: 50px;"></div>
                    </div>
                    <p class="mt-1 text-sm font-medium text-center">Oct</p>
                    </div>
                
                    <!-- Bar for November -->
                    <div class="col-1">
                    <div class="d-flex flex-column-reverse align-items-center" style="height: 100px;">
                        <div class="w-100 bg-success" style="height: 60px;"></div>
                    </div>
                    <p class="mt-1 text-sm font-medium text-center">Nov</p>
                    </div>
                
                    <!-- Bar for December -->
                    <div class="col-1">
                    <div class="d-flex flex-column-reverse align-items-center" style="height: 100px;">
                        <div class="w-100 bg-success" style="height: 70px;"></div>
                    </div>
                    <p class="mt-1 text-sm font-medium text-center">Dec</p>
                    </div>
                </div>
                </div>
                
                
            </div>
            </div>

            <!-- Third Container -->
            <div class="col-12 col-md-4">
            <div class="mx-3">
                <div class="p-4 bg-white rounded shadow-sm mt-5">
                <div class="d-flex justify-content-between">
                    <p class="fw-semibold">Advisers</p>
                    <a href="#"><p class="fw-semibold text-success">See All</p></a>
                </div>

                <div class="d-flex justify-content-evenly mt-3">
                    <div class="text-center">
                    <img
                        class="rounded-circle border border-dark h-20"
                        src="../images/renato.jpg"
                        alt=""
                        style="width: 40px; height: 40px;"
                    />
                    <p class="fw-semibold text-sm">Renato Bautista</p>
                    <p class="text-xs text-secondary">Instructor, DCS</p>
                    </div>

                    <div class="text-center">
                    <img
                        class="rounded-circle border border-dark h-20"
                        src="../images/janessa.jpg"
                        alt=""
                        style="width: 40px; height: 40px;"
                    />
                    <p class="fw-semibold text-sm">Janessa Dela Cruz</p>
                    <p class="text-xs text-secondary">Instructor, DCS</p>
                    </div>
                </div>
                </div>

                <!-- Fourth Container -->
                <div class="p-4 bg-white rounded mt-4 shadow-sm">
                <div class="d-flex align-items-center">
                    <lord-icon
                    src="https://cdn.lordicon.com/ysqeagpz.json"
                    trigger="loop"
                    colors="primary:#6acbff"
                    style="width:40px;height:40px;transform: rotate(360deg);">
                    </lord-icon>
                    <h1 class="text-secondary fw-bold h5 ms-2">Financial Deadlines</h1>
                </div>

                <div class="ms-2 mt-3">
                    <div class="mt-1">
                    <h1 class="fw-bold text-xs fs-5">Office Supplies</h1>
                    <p class="text-secondary fw-semibold text-xs">October 12, 2024</p>
                    </div>

                    <div class="mt-1">
                    <h1 class="fw-bold text-xs fs-5">Transportation</h1>
                    <p class="text-secondary fw-semibold text-xs">L-300</p>
                    </div>

                    <div class="mt-1">
                    <h1 class="fw-bold text-xs fs-5">Speakers</h1>
                    <p class="text-secondary fw-semibold text-xs">November 11, 2024</p>
                    </div>
                </div>  
                </div>

                <!-- Radial Progress -->
                <div class="d-flex justify-evenly gap-5 p-4 bg-white rounded mt-4 shadow-sm">
                <div class="d-flex align-items-center">
                    <div>
                    <h1 class="fw-bold fs-7">Balance</h1>
                    <p class="fw-semibold text-secondary">Total Monthly</p>
                    <h1 class="fw-bold h6">₱ 50,000 <span class="bg-warning text-white rounded-pill mx-auto px-3 py-1">73.4%</span></h1>
                    </div>
                </div>

                <div>
                    <div class="d-flex flex-column align-items-center">
                    <div class="position-relative d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                        <!-- Circle Background -->
                        <div class="position-absolute w-100 h-100 rounded-circle bg-light"></div>
                        
                        <!-- Radial Progress Circle -->
                        <svg class="position-absolute w-100 h-100" style="transform: rotate(-90deg);">
                        <circle cx="50%" cy="50%" r="45%" stroke="currentColor" stroke-width="8" class="text-purple-500" fill="none" stroke-dasharray="283" stroke-dashoffset="85"></circle>
                        </svg>

                        <!-- Centered Text -->
                        <div class="position-absolute text-center">
                        <p class="h6 fw-bold text-dark">₱27,500</p>
                        <p class="text-sm fw-semibold text-secondary">Remaining balance</p>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>

        <!--Transactions-->
        <div class="flex justify-center">
            <div class="d-flex justify-content-start mt-5 mb-4">
            <h1 class="h5 fw-black fs-10 ps-5 mx-xs-5">
                <span class="text-warning fw-bold me-2 fs-10">|</span>Transaction
            </h1>
            </div>
            <div class="body-wrapper-inner d-flex justify-center mx-sm-5 mt-5">
            <div class="container-fluid">
                <!-- Row 1 -->
                <div class="row">
                <div class="col-lg-12 d-flex align-items-stretch">
                    <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Sales Profit</h5>
                        </div>
                        <div>
                            <select class="form-select">
                            <option value="1">March 2024</option>
                            <option value="2">April 2024</option>
                            <option value="3">May 2024</option>
                            <option value="4">June 2024</option>
                            </select>
                        </div>
                        </div>
                        <div id="sales-profit" style="height: 400px;"></div> <!-- Set height for the graph -->
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>

            
        <!--Recent Transaction dashboard-->
        <div>
        <div class="h5 fw-black fs-10 ps-5 mx-xs-5">
            <h1 class="mr-5"><span class="text-warning fw-bold me-2 fs-10">|</span>Recent Transactions</h1>
        </div>
        <div class="container mt-5">
            <button id="printButton" class="btn btn-primary mb-3">Print</button>
            <button id="pdfButton" class="btn btn-success mb-3">Download PDF</button>
            
            <div id="tableContent">
                <table class="table table-bordered">
                    <thead class="thead-light fw-bold">
                        <tr class="fw-bold fs-4 text-dark">
                            <th>Type</th>
                            <th>Due Date</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Payer</th>
                            <th>Reference</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Invoice</td>
                            <td>2023-10-20</td>
                            <td>Payment for services rendered</td>
                            <td>$1,000.00</td>
                            <td>Company A</td>
                            <td>INV-001</td>
                            <td>Paid</td>
                        </tr>
                        <tr>
                            <td>Expense</td>
                            <td>2023-10-22</td>
                            <td>Office supplies purchase</td>
                            <td>$250.00</td>
                            <td>Tom</td>
                            <td>EXP-002</td>
                            <td>Pending</td>
                        </tr>
                        <tr>
                            <td>Invoice</td>
                            <td>2023-10-25</td>
                            <td>Consultation services</td>
                            <td>$500.00</td>
                            <td>Company B</td>
                            <td>INV-003</td>
                            <td>Paid</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

        <script>
            // Print function
            document.getElementById('printButton').addEventListener('click', function() {
                window.print();
            });

            // PDF download function
            document.getElementById('pdfButton').addEventListener('click', function() {
                const element = document.getElementById('tableContent');
                html2pdf()
                    .from(element)
                    .save('transaction_report.pdf');
            });
        </script>
        </div>

            <div>
            <div class="h5 fw-black fs-10 ps-5 mx-xs-5 mt-5">
                <h1><span class="text-warning fw-bold me-2 fs-10">|</span>Upcoming Events</h1>
            </div>
            <div class="mx-auto">
                <!--event boxes-->
                <div class="container mt-5">
            <div class="row">
                <!-- Event Box 1 -->
                <div class="col-md-4">
                    <div class="event-box">
                        <h5>Name of the Org</h5>
                        <p>Allotted Time: 2 hours</p>
                        <h6>Title Of the Event</h6>
                        <p>Date: October 20, 2023</p>
                        <p>Time Start: 10:00 AM</p>
                        <button class="btn btn-info">Details</button>
                    </div>
                </div>

                <!-- Event Box 2 -->
                <div class="col-md-4">
                    <div class="event-box">
                        <h5>Name of the Org</h5>
                        <p>Allotted Time: 1 hour</p>
                        <h6>Title Of the Event</h6>
                        <p>Date: October 21, 2023</p>
                        <p>Time Start: 2:00 PM</p>
                        <button class="btn btn-info">Details</button>
                    </div>
                </div>

                <!-- Calendar Box -->
                <div class="col-md-4">
                <div class="calendar">
                    <div class="header">
                        <button id="prev" class="btn btn-link">&lt;</button>
                        <span id="monthYear"></span>
                        <button id="next" class="btn btn-link">&gt;</button>
                    </div>
                    <div class="days-of-week">
                        <div class="day-header">Sun</div>
                        <div class="day-header">Mon</div>
                        <div class="day-header">Tue</div>
                        <div class="day-header">Wed</div>
                        <div class="day-header">Thu</div>
                        <div class="day-header">Fri</div>
                        <div class="day-header">Sat</div>
                    </div>
                    <div id="days" class="days"></div>
                </div>
            </div>
            
            <style>
                .calendar {
                    border: 1px solid #ccc;
                    background-color: #fff;
                    border-radius: 8px;
                    padding: 5px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    height: 250px; /* Set a fixed height */
                    overflow: hidden; /* Prevent contents from leaking out */
                }
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 5px;
                }
                .header button {
                    background: none;
                    border: none;
                    font-size: 20px;
                    cursor: pointer;
                }
                .days-of-week {
                    display: grid;
                    grid-template-columns: repeat(7, 1fr);
                    margin-bottom: 5px;
                }
                .day-header {
                    font-weight: bold;
                    text-align: center;
                    color: #007bff;
                }
                .days {
                    display: grid;
                    grid-template-columns: repeat(7, 1fr);
                    grid-auto-rows: 30px; /* Set height for each day */
                    overflow-y: auto; /* Allow scrolling if content overflows */
                    height: calc(100% - 90px); /* Adjust height for days */
                }
                .day {
                    padding: 5px;
                    text-align: center;
                    border: 1px solid #ddd;
                    transition: background-color 0.2s;
                }
                .day:hover {
                    background-color: #e9ecef;
                }
            </style>
            
            <script>
                const monthYear = document.getElementById('monthYear');
                const daysContainer = document.getElementById('days');
                let currentDate = new Date();
            
                function renderCalendar() {
                    const month = currentDate.getMonth();
                    const year = currentDate.getFullYear();
                    monthYear.textContent = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });
                    
                    daysContainer.innerHTML = '';
            
                    const firstDay = new Date(year, month, 1);
                    const lastDay = new Date(year, month + 1, 0);
                    const daysInMonth = lastDay.getDate();
                    const startDay = firstDay.getDay();
            
                    for (let i = 0; i < startDay; i++) {
                        const emptyDay = document.createElement('div');
                        emptyDay.className = 'day';
                        daysContainer.appendChild(emptyDay);
                    }
            
                    for (let i = 1; i <= daysInMonth; i++) {
                        const day = document.createElement('div');
                        day.className = 'day';
                        day.textContent = i;
                        daysContainer.appendChild(day);
                    }
                }
            
                document.getElementById('prev').addEventListener('click', () => {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    renderCalendar();
                });
            
                document.getElementById('next').addEventListener('click', () => {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    renderCalendar();
                });
            
                renderCalendar();
            </script>
            
            </div>
        </div>

        <div>
        <div class="container mt-5">
            <div class="row align-items-center">
                <div class="col-md-8 h5 fw-black fs-10 ps-5">
                    <h1 class="mr-5"><span class="text-warning fw-bold me-2 fs-10">|</span>Activities</h1>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <button class="btn btn-primary mx-2">Beacon of Youth Technology Enthusia</button>
                </div>
            </div>
        </div>

        <div class="container pt-5 mx-auto">
        <div id="tableContent">
            <table class="table table-bordered">
                <thead class="thead-light fw-bold">
                    <tr class="fw-bold fs-4 text-dark">
                        <th>Title</th>
                        <th>from</th>
                        <th>to</th>
                        <th>Type</th>
                        <th>Venue</th>
                        <th>Status</th>
                        <th>Accomplishment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>TechFest</td>
                        <td>03-21</td>
                        <td>03-22</td>
                        <td>Co-Curricular</td>
                        <td>Court 1</td>
                        <td>Approved</td>
                        <td>Accomplished</td>
                    </tr>
                    <tr>
                    <td>TechFest</td>
                    <td>03-21</td>
                    <td>03-22</td>
                    <td>Co-Curricular</td>
                    <td>Court 1</td>
                    <td>Approved</td>
                    <td>Accomplished</td>
                </tr>
                <tr>
                    <td>TechFest</td>
                    <td>03-21</td>
                    <td>03-22</td>
                    <td>Co-Curricular</td>
                    <td>Court 1</td>
                    <td>Approved</td>
                    <td>Accomplished</td>
                </tr>
                </tbody>
            </table>
        </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

        <script>
        // Print function
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });

        // PDF download function
        document.getElementById('pdfButton').addEventListener('click', function() {
            const element = document.getElementById('tableContent');
            html2pdf()
                .from(element)
                .save('transaction_report.pdf');
        });
        </script>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

            </div>
            </div>
            
        </div>

            
            <script>
            const ctx = document.getElementById('sales-profit').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line', // Use 'line' type for line graph
                data: {
                    labels: ['January', 'February', 'March', 'April'],
                    datasets: [{
                        label: 'Sales Profit',
                        data: [12, 19, 3, 5],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: true // Optional: fill under the line
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            </script>

        
        
        
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
        </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar visibility
        $(document).ready(function () {
            $('#sidebarToggle').on('click', function () {
                $('#sidebar').toggleClass('collapsed');
            });

            // Notifications button action (you can customize this further)
            $('#notificationBtn').on('click', function () {
                alert('You have no new notifications.'); // Replace with actual notification logic
            });
        });
    </script>
</body>

</html>
