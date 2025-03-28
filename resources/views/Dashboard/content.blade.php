<!-- resources/views/dashboard/content.blade.php -->
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
                            @if(isset($branches) && $branches->count() > 0)
                            @foreach($branches as $branch)
                            <tr>
                                <td>{{ $branch->branch_name }}</td>
                                <td>{{ $branch->branch_id }}</td>
                                <!-- Add any other branch properties you want to display -->
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center">No branches found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Metrics Card -->
                <div class="stats-card metrics-container">
                    <div class="border_bar ">
                        <h3 class="metric-label ">Total Employees</h3>
                        <div class="metric-value ">125</div>
                    </div>
                    <div>
                        <h3 class="metric-label">Active Bookings</h3>
                        
                        <div class="metric-value"><strong>2</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Section -->
        <!-- <div class="calendar-card">
            <h5 class="mb-4">Upcoming Events</h5>
            <div id="calendar"></div> 
        </div> -->
        <div class="widget calendar calendar-card">
            <h2>Upcoming Events</h2>
            <iframe class="calendar_iframe" src="https://calendar.google.com/calendar/embed?src=cowork24management%40gmail.com&ctz=Asia/Karachi" frameborder="0"></iframe>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [{
                    title: 'Team Meeting',
                    start: '2025-01-10',
                    color: '#ff8802'
                },
                {
                    title: 'Client Workshop',
                    start: '2025-01-15',
                    end: '2025-01-17',
                    color: '#088395'
                },
                {
                    title: 'Training Session',
                    start: '2025-01-20',
                    color: '#464646'
                },
                {
                    title: 'Project Review',
                    start: '2025-01-25',
                    color: '#2E2E2E'
                }
            ],
            initialDate: '2025-01-01',
            height: 'auto',
            selectable: true,
            eventClick: function(info) {
                showEventDetails(info.event);
            }
        });
        calendar.render();
    });

    function showEventDetails(event) {
        alert('Event: ' + event.title);
    }
</script>
@endpush