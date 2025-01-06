<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COWORK24 Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet' />
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Helvetica;
        }

        /* Layout */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .dashboard-content {
            padding: 10px;
            background-color: #e2e1e1;
        }
        /* .dashboard-contents{

        } */

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #464646;
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .logo-container {
            background-color: #ff8802;
            text-align: center;
        }

        .logo {
            max-width: 180px;
        }

        /* Navigation Styles */
        .nav-item {
            border-bottom: 1px solid #2E2E2E;
            cursor: pointer;
        }

        .nav-link {
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .nav-link i {
            width: 20px;
        }

        .nav-link:hover {
            background-color: #555;
        }

        .submenu {
            background-color: #088395;
            display: none;
            padding: 10px 0;
        }

        .submenu a {
            color: white;
            padding: 8px 30px;
            display: block;
            text-decoration: none;
            font-size: 14px;
        }

        .submenu a:hover {
            background-color: #066673;
        }

        .nav-item.active .submenu {
            display: block;
        }

        .dropdown-icon {
            margin-left: auto;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 250px;
            flex: 1;
            background-color: #f4f5f3;
        }

        /* Top Header */
        .top-header {
            background-color: #f4f5f3;
            height: 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header_username {
            color: black;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        /* Statistics Layout */
        .stats-row {
            display: flex;
            gap: 10px;

        }

        .table-container {
            flex: 1.5;
        }

        .metrics-container {
            flex: 1;
        }

        /* Cards Styling */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .card-title {
            color: #333;
            font-size: 20px;
            margin-bottom: 20px;
            font-weight: 500;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        /* Table Styles */
        .stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .stats-table th {
            background-color: #464646;
            color: white;
            padding: 12px 20px;
            text-align: center;
            font-weight: 500;
        }

        .stats-table th:first-child {
            border-top-left-radius: 4px;
        }

        .stats-table th:last-child {
            border-top-right-radius: 4px;
        }

        .stats-table td {
            padding: 12px 20px;
            text-align: center;
        }

        /* Seat Status Indicators */
        .available-seats {
            background-color: #e8f5e9;
            padding: 8px 15px;
            border-radius: 8px;
            color: #2e7d32;
            display: inline-block;
            min-width: 60px;
            border: 1px solid #c8e6c9;
        }

        .occupied-seats {
            background-color: #ffebee;
            padding: 8px 15px;
            border-radius: 8px;
            color: #c62828;
            display: inline-block;
            min-width: 60px;
            border: 1px solid #ffcdd2;
        }

        /* Metrics Typography */
        .metric-value {
            font-size: 30px;
            color: #333;
            margin: 10px 0;
            font-weight: 500;
        }

        .metric-label {
            font-size: 20px;
            color: #333;
            margin: 20px 0 10px 0;
            font-weight: 500;
        }

        /* Calendar Card */
        .calendar-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">


            <nav>
                <!-- Dashboard -->

                <div class="nav-item">
                    <div class="logo-container">
                        <img src="{{ asset('images/cowork24.png') }}" alt="COWORK24" class="logo">
                    </div>
                    </a>

                    <div class="nav-item">


                        <a href="#" class="nav-link" onclick="navigateTo('welcome.php')">
                            <i class="fa-brands fa-dashcube"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>


                    <!-- Visits -->
                    <div class="nav-item">

                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-file"></i>
                            <span>Visits</span>
                            <i class="fas fa-caret-down dropdown-icon"></i>
                        </a>
                        <div class="submenu">
                            <a href="#" onclick="navigateTo('bookaVisit.php')">Book a Visit</a>
                            <a href="#" onclick="navigateTo('visits.php')">Visitor Info</a>
                        </div>
                    </div>

                    <!-- Memberships -->
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-user"></i>
                            <span>Memberships</span>
                            <i class="fas fa-caret-down dropdown-icon"></i>
                        </a>
                        <div class="submenu">
                            <a href="#" onclick="navigateTo('add_coworker.php')">Add a Coworker</a>
                            <a href="#" onclick="navigateTo('view_coworker.php')">List of coworker</a>
                            <a href="#" onclick="navigateTo('team.php')">List of Team</a>
                        </div>
                    </div>

                    <!-- Booking -->
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-calendar-days"></i>
                            <span>Booking</span>
                            <i class="fas fa-caret-down dropdown-icon"></i>
                        </a>
                        <div class="submenu">
                            <a href="#" onclick="navigateTo('calender.php')">Huddle & Meeting</a>
                        </div>
                    </div>

                    <!-- Tickets -->
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-ticket"></i>
                            <span>Tickets</span>
                            <i class="fas fa-caret-down dropdown-icon"></i>
                        </a>
                        <div class="submenu">
                            <a href="#" onclick="navigateTo('ticket.php')">Create Ticket</a>
                            <a href="#" onclick="navigateTo('viewticket.php')">All Tickets</a>
                        </div>
                    </div>

                    <!-- Seat Management -->
                    <div class="nav-item">
                        <a href="#" class="nav-link" onclick="navigateTo('seat.php')">
                            <i class="fa-solid fa-chair"></i>
                            <span>Seat Management</span>
                        </a>
                    </div>

                    <!-- Cowork Space Management -->
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-sitemap"></i>
                            <span>Cowork Space Management</span>
                            <i class="fas fa-caret-down dropdown-icon"></i>
                        </a>
                        <div class="submenu">
                            <a href="#" onclick="navigateTo('office.php')">Office</a>
                            <a href="#" onclick="navigateTo('meetingRoom.php')">Meeting Room</a>
                            <a href="#" onclick="navigateTo('huddleRoom.php')">Huddle Room</a>
                        </div>
                    </div>

                    <!-- Branches -->
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-sharp fa-solid fa-code-branch"></i>
                            <span>Branches</span>
                            <i class="fas fa-caret-down dropdown-icon"></i>
                        </a>
                        <div class="submenu">
                            <a href="#" onclick="navigateTo('newBranch.php')">Add New Branch</a>
                            <a href="#" onclick="navigateTo('branch.php')">Branches Data</a>
                        </div>
                    </div>

                    <!-- Users -->
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-sharp fa-solid fa-users"></i>
                            <span>Users</span>
                            <i class="fas fa-caret-down dropdown-icon"></i>
                        </a>
                        <div class="submenu">
                            <a href="#" onclick="navigateTo('create_user.php')">Create New user</a>
                            <a href="#" onclick="navigateTo('view_all_user.php')">View All Users</a>
                        </div>
                    </div>

                    <!-- Employee Management -->
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-sharp fa-solid fa-users"></i>
                            <span>Employee Management</span>
                            <i class="fas fa-caret-down dropdown-icon"></i>
                        </a>
                        <div class="submenu">
                            <a href="#" onclick="navigateTo('employeeData.php')">Employee Data</a>
                            <a href="#" onclick="navigateTo('view_leaves.php')">Leave of Employees</a>
                        </div>
                    </div>

                    <!-- Finance -->
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-coins"></i>
                            <span>Finance</span>
                            <i class="fas fa-caret-down dropdown-icon"></i>
                        </a>
                        <div class="submenu">
                            <a href="#" onclick="navigateTo('pettyCash.php')">Petty Cash</a>
                            <a href="#" onclick="navigateTo('financedisplay.php')">Rents</a>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <div class="logout_btn_dashboard">
                        <a href="logout.php" class="logout-button">Logout</a>
                    </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div></div>
                <div class="user-info">
                    <span class="header_username">sir Arslan</span>
                    <img src="{{ asset('images/user.png') }}" alt="User" class="user-avatar">
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <div class="row">
                    <!-- Seat Statistics Table -->
                    <div class="dashboard-content">
                        <div class="stats-row">
                            <!-- Seat Statistics Card -->
                            <div class="stats-card table-container">
                                <h3 class="card-title">Seat Statistics Per Branch</h3>
                                <table class="stats-table">
                                    <thead>
                                        <tr>
                                            <th>Branch Name</th>
                                            <th>Total Seats</th>
                                            <th>Available Seats</th>
                                            <th>Occupied Seats</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>I-10</td>
                                            <td>2</td>
                                            <td>
                                                <div class="available-seats">1</div>
                                            </td>
                                            <td>
                                                <div class="occupied-seats">1</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Metrics Card -->
                            <div class="stats-card metrics-container">
                                <div>
                                    <h3 class="metric-label">Total Employees</h3>
                                    <div class="metric-value">0</div>
                                </div>
                                <div>
                                    <h3 class="metric-label">Active Bookings</h3>
                                    <div class="metric-value">0</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Section -->
                    <div class="calendar-card">
                        <h5 class="mb-4">Upcoming Events</h5>
                        <div id="calendar"></div>
                    </div>
                </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize FullCalendar
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialDate: '2025-01-01',
                height: 'auto',
                selectable: true
            });
            calendar.render();

            // Toggle submenu
            document.querySelectorAll('.nav-link').forEach(item => {
                item.addEventListener('click', event => {
                    const navItem = event.currentTarget.parentElement;
                    const wasActive = navItem.classList.contains('active');

                    // Remove active class from all items
                    document.querySelectorAll('.nav-item').forEach(item => {
                        item.classList.remove('active');
                    });

                    // Toggle active class on clicked item
                    if (!wasActive && navItem.querySelector('.submenu')) {
                        navItem.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>

</html>