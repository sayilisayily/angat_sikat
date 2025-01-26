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
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/angatsikat.png" />
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
                            <div class="info-label">Role</div>
                            <div><?php echo htmlspecialchars($role); ?></div>
                        </div>
                        
                        
                        <div class="edit-btn">
                            <button onclick="toggleEditMode()">Edit Profile</button>
                        </div>
                    </div>

                    <!-- Edit Profile Form -->
                    <form id="edit-profile-form" class="hidden"
                        enctype="multipart/form-data">
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
                        <h6> Enter password to confirm changes:</h6>
                        <div class="info-text">
                            <div class="info-label">Password</div>
                            <input type="password" name="password" required>

                        </div>
                        <div class="info-text">
                            <div class="info-label">Confirm Password</div>
                            <input type="password" name="confirm_password" required>

                        </div>

                        <!-- Success Message Alert -->
                        <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
                                        Profile updated successfully!
                                    </div>
                                    <!-- Error Message Alert -->
                                    <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert">
                                        <ul id="errorList"></ul> <!-- List for showing validation errors -->
                                    </div>
                        
                        <div class="save-delete">
                            <div class="save-btn">
                                <button type="submit">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- End of Overall Body Wrapper -->

    <script>
        $(document).ready(function () {
            $("#edit-profile-form").on("submit", function (event) {
                event.preventDefault();
                var formData = new FormData(this);

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
                                $("#errorMessage").addClass("d-none");
                                $("#successMessage").removeClass("d-none");

                                setTimeout(function () {
                                    $("#edit-profile-form")[0].reset();
                                    $("#successMessage").addClass("d-none");
                                    location.reload();
                                }, 2000);
                            } else {
                                $("#successMessage").addClass("d-none");
                                $("#errorMessage").removeClass("d-none");
                                let errorHtml = "";
                                for (let field in response.errors) {
                                    errorHtml += `<li>${response.errors[field]}</li>`;
                                }
                                $("#errorList").html(errorHtml);
                            }
                        } catch (error) {
                            console.error("Error parsing JSON:", error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error updating profile:", error);
                        console.log(xhr.responseText);
                    },
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