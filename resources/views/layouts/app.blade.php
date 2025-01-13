<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COWORK24 Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet' />
    <!-- Your existing CSS here -->
    <link rel="stylesheet" href="css/app.css">
    @vite(['resources/css/app.css'])
 
</head>
<body>
    <div class="dashboard-container">
        @include('layouts.sidebar')
        
        <main class="main-content">
            @include('layouts.header')
            
            <div id="content-area">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    @vite(['resources/js/app.js'])
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // AJAX content loading
        function loadContent(url) {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('content-area').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        }

        // Handle navigation clicks
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.getAttribute('data-url')) {
                    e.preventDefault();
                    const url = this.getAttribute('data-url');
                    loadContent(url);
                    
                    // Update URL without page reload
                    history.pushState({}, '', url);
                }
                
                // Toggle submenu
                const navItem = this.parentElement;
                const wasActive = navItem.classList.contains('active');

                document.querySelectorAll('.nav-item').forEach(item => {
                    item.classList.remove('active');
                });

                if (!wasActive && navItem.querySelector('.submenu')) {
                    navItem.classList.add('active');
                }
            });
        });
    });
    </script>
</body>
</html>