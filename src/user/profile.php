<?php
include 'connection.php';
include '../session_check.php'; 
include '../user_query.php';
include '../organization_query.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon_sikat.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <!--Custom CSS for Sidebar-->
    <link rel="stylesheet" href="../html/sidebar.css" />
    <!--Custom CSS for Profile-->
    <link rel="stylesheet" href="profile.css" />
    <!--Boxicon-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Lordicon (for animated icons) -->
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <!--Calendar JS-->
    <script src="path/to/calendar.js"></script>
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

    <script>
        function toggleEditMode() {
            // Toggle between read-only and edit mode
            document.getElementById('profile-info').classList.toggle('hidden');
            document.getElementById('edit-profile-form').classList.toggle('hidden');
        }
    </script>
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

            <!-- Profile Content -->
            <div class="profile-content">
                <div class="edit-section">
                    <h2>Profile Information</h2>
                    
                    <!-- Display Profile Information -->
                    <div id="profile-info">
                        <div style="text-align: center;">
                        <img src="<?php echo !empty($profile_picture) ? htmlspecialchars($profile_picture) : 'uploads/default.png'; ?>" 
                            alt="Profile Image" 
                             
                            class="profile-img">
                        </div>
                        <div class="info-text">
                            <div class="info-label">Full Name</div>
                            <div><?php echo htmlspecialchars($fullname); ?></div>
                        </div>
                        <div class="info-text">
                            <div class="info-label">Email</div>
                            <div><?php echo htmlspecialchars($email); ?></div>
                        </div>
                        <div class="info-text">
                            <div class="info-label">Organization</div>
                            <div>20241111</div>
                        </div>
                        <div class="info-text">
                            <div class="info-label">Role</div>
                            <div><?php echo htmlspecialchars($role); ?></div>
                        </div>
                        
                        
                        <div class="edit-btn">
                            <button onclick="toggleEditMode()">Edit Profile</button>
                        </div>
                    </div>

                    <!-- Edit Profile Form -->
<!-- Edit Profile Form -->
<form id="edit-profile-form" class="hidden" enctype="multipart/form-data">
    <div class="profile-upload">
        <img src="<?php echo !empty($profile_picture) ? htmlspecialchars($profile_picture) : 'uploads/default.png'; ?>" 
            alt="Profile Image" 
            id="profilePreview" 
            class="profile-img">
        <label for="profile_picture" class="upload-icon">+</label>
        <input type="file" id="profile_picture" name="profile_picture" class="hidden"
            onchange="document.getElementById('profilePreview').src = window.URL.createObjectURL(this.files[0])">
    </div>
    <div class="info-text">
        <div class="info-label">First Name</div>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($firstname); ?>">
    </div>
    <div class="info-text">
        <div class="info-label">Last Name</div>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($lastname); ?>">
    </div>
    <div class="info-text">
        <div class="info-label">Email</div>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
    </div>
    <div class="info-text">
        <div class="info-label">Password</div>
        <input type="password" name="password" required>
    </div>
    <div class="info-text">
        <div class="info-label">Confirm Password</div>
        <input type="password" name="confirm_password" required>
    </div>
    
    <div class="save-delete">
        <div class="delete-btn">
            <button type="button" onclick="confirmDelete()">Delete Account</button>
        </div>
        <div class="save-btn">
            <button type="submit">Save Changes</button>
        </div>
    </div>
</form>

<!-- Confirmation Modal -->
<div id="confirmationModal" style="display:none; position:fixed; top:30%; left:50%; transform:translate(-50%, -50%); background-color: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 5px; z-index: 1000; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <p>Do you want to save?</p>
    <button id="confirmYes">Yes</button>
    <button id="confirmNo">No</button>
</div>

<!-- Notification Area -->
<div id="notification" style="display:none; position:fixed; top:10px; left:50%; transform:translateX(-50%); background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px; z-index: 1000;">
    Save Successfully
</div>

<style>
    #confirmationModal {
        font-family: Arial, sans-serif;
    }
    #confirmationModal button {
        margin: 5px;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        background-color: #4CAF50; /* Green */
        color: white;
        cursor: pointer;
    }
    #confirmationModal button:hover {
        background-color: #45a049; /* Darker green */
    }
    #notification {
        font-family: Arial, sans-serif;
        font-size: 16px;
        text-align: center;
    }
</style>

<script>
    function confirmDelete() {
        const confirmation = confirm("Are you sure you want to delete your account? This action cannot be undone.");
        if (confirmation) {
            window.location.href = 'delete_account.php'; // replace with your delete action URL
        }
    }

    $(document).ready(function () {
        $("#edit-profile-form").on("submit", function (event) {
            event.preventDefault();
            $("#confirmationModal").show(); // Show the custom confirmation modal

            $("#confirmYes").off('click').on('click', function () {
                $("#confirmationModal").hide(); // Hide the confirmation modal
                var formData = new FormData($("#edit-profile-form")[0]);

                $.ajax({
                    url: "update_profile.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        try {
                            response = JSON.parse(response);
                            console.log(response);

                            if (response.success) {
                                // Show notification
                                $("#notification").fadeIn().delay(2000).fadeOut(function() {
                                    // Redirect after notification
                                    window.location.href = 'profile_info.php'; // Change this to your desired redirect URL
                                });
                            } else {
                                // Handle errors
                                let errorHtml = "";
                                for (let field in response.errors) {
                                    errorHtml += `<li>${response.errors[field]}</li>`;
                                }
                                $("#editErrorList").html(errorHtml);
                            }
                        } catch (error) {
                            console.error("Error parsing JSON:", error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error updating organization:", error);
                        console.log(xhr.responseText);
                    },
                });
            });

            $("#confirmNo").off('click').on('click', function () {
                $("#confirmationModal").hide(); // Hide the modal if "No" is clicked
            });
        });
    });
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