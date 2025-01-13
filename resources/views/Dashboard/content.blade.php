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
                            <tr>
                                <td>I-10 Branch</td>
                                <td>50</td>
                                <td>
                                    <div class="available-seats">30</div>
                                </td>
                                <td>
                                    <div class="occupied-seats">20</div>
                                </td>
                            </tr>
                            <tr>
                                <td>F-10 Branch</td>
                                <td>40</td>
                                <td>
                                    <div class="available-seats">25</div>
                                </td>
                                <td>
                                    <div class="occupied-seats">15</div>
                                </td>
                            </tr>
                            <tr>
                                <td>G-11 Branch</td>
                                <td>60</td>
                                <td>
                                    <div class="available-seats">35</div>
                                </td>
                                <td>
                                    <div class="occupied-seats">25</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Metrics Card -->
                <div class="stats-card metrics-container">
                    <div>
                        <h3 class="metric-label">Total Employees</h3>
                        <div class="metric-value">125</div>
                    </div>
                    <div>
                        <h3 class="metric-label">Active Bookings</h3>
                        <div class="metric-value">45</div>
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
        events: [
            {
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