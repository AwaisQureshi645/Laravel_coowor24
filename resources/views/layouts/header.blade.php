<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
    <style>
        .dropdown-box {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            padding: 10px;
            min-width: 150px;
            z-index: 1000;
        }
        
        .user-info {
            position: relative;
            cursor: pointer;
        }
        
        .dropdown-button {
            display: block;
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 5px;
            border: none;
            background-color: #f3cf0b;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            color:black;
        }
        
        .dropdown-button:hover {
            background-color: #f3cf0b;
        }
    </style>
</head>
<body>
<header class="top-header">
    <div></div>
    <div class="user-info" id="userInfoDiv">
    
        <img src="{{ asset('images/user.png') }}" alt="User" class="user-avatar">
        
        <!-- Dropdown box that will appear on click -->
        <div class="dropdown-box" id="userDropdown">
            <!-- <button class="dropdown-button">Profile</button>
            <button class="dropdown-button">Settings</button> -->
            <button class="dropdown-button">
            <a href="{{ route('logout') }}" class="dropdown-button">Logout</a>
            </button>
        </div>
    </div>
</header>

<script>
    // JavaScript to toggle the dropdown
    document.addEventListener('DOMContentLoaded', function() {
        const userInfoDiv = document.getElementById('userInfoDiv');
        const userDropdown = document.getElementById('userDropdown');
        
        // Toggle dropdown when user info div is clicked
        userInfoDiv.addEventListener('click', function(e) {
            if (userDropdown.style.display === 'block') {
                userDropdown.style.display = 'none';
            } else {
                userDropdown.style.display = 'block';
            }
            e.stopPropagation();
        });
        
        // Close dropdown when clicking elsewhere on the page
        document.addEventListener('click', function(e) {
            if (e.target !== userInfoDiv && !userInfoDiv.contains(e.target)) {
                userDropdown.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>