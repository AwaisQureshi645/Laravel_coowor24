


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<aside class="sidebar">


<nav>
  

    <div class="nav-item">
        <div class="logo-container">
            <img src="{{ asset('images/cowork24.png') }}" alt="COWORK24" class="logo">
        </div>
        </a>

        <div class="nav-item">


            <a href="/" class="nav-link" onclick="navigateTo('welcome.php')">
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
                <a href="/visit/create" onclick="navigateTo('bookaVisit.php')">Book a Visit</a>
                <a href="/visits" >Visitor Info</a>
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
                <a href="/addcoworker" onclick="navigateTo('add_coworker.php')">Add a Coworker</a>
                <a href="addcoworker/display" onclick="navigateTo('view_coworker.php')">List of coworker</a>
                <a href="/team-bookings" onclick="navigateTo('team.php')">List of Team</a>
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
                <a href="/bookings" onclick="navigateTo('calender.php')">Huddle & Meeting</a>
                <a href="/create-event">Event create</a>
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
                <a href="/tickets/create" onclick="navigateTo('ticket.php')">Create Ticket</a>
                <a href="/tickets" onclick="navigateTo('viewticket.php')">All Tickets</a>
            </div>
        </div>

        <!-- Seat Management -->
        <div class="nav-item">
            <a href="/seats" class="nav-link" onclick="navigateTo('seat.php')">
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
                <a href="/offices/" onclick="navigateTo('office.php')">Office</a>
                <a href="/meeting-rooms" onclick="navigateTo('meetingRoom.php')">Meeting Room</a>
                <a href="/huddle-rooms/" onclick="navigateTo('huddleRoom.php')">Huddle Room</a>
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
                <a href="/branches/create" onclick="navigateTo('newBranch.php')">Add New Branch</a>
                <a href="/branches" onclick="navigateTo('branch.php')">Branches Data</a>
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
                <a href="/coworkerusers/create" onclick="navigateTo('create_user.php')">Create New user</a>
                <a href="/coworkerusers" onclick="navigateTo('view_all_user.php')">View All Users</a>
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
                <a href="/employees/create" onclick="navigateTo('employeeData.php')">Employee Data</a>
                <a href="employees" onclick="navigateTo('view_leaves.php')">Leave of Employees</a>
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
            <a href="/logout" class="logout-button"><button>
                Logout
            </button></a>
        </div>
</nav>
</aside>
</body>
</html>