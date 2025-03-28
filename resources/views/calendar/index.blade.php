@extends('layouts.app')

@section('content')
<div class="container">




    <h2>Upcoming Events</h2>
    <!-- show branch filter -->
    <div class="controls filter_containers  mb-3">
        <form id="branchFilterForm" action="{{ route('calendar.index') }}" method="GET" class="">
            <label for="branch_id" class="mr-2"></label>
            <select name="branch_id" id="branch_id" class="form-control w-25 mr-2" onchange="this.form.submit()">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                <option value="{{ $branch->branch_id }}" {{ $branchId == $branch->branch_id ? 'selected' : '' }}>
                    {{ $branch->branch_name }}
                </option>
                @endforeach
            </select>
            @if($branchId)
            <!-- <a href="{{ route('visits.index') }}" class="btn btn-danger ml-2">Clear</a> -->
            @endif
        </form>
    </div>
    <!-- display the events data -->
        <div class="table-responsive ">
            <table class="table table-striped table-bordered ">
                <thead>
                    
                    <tr>

                        <th>Team Name</th>
                        <th>Room Type</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Point of Contact</th>
                        <th>Location</th>
                        <th>Summary</th>
                        <th>Description</th>


                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td>{{ $booking->team_name }}</td>
                        <td>{{ $booking->room_type }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->start_time)->format(' g:i A d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->end_time)->format(' g:i A d-m-Y') }}</td>
                        <td>{{ $booking->point_of_contact }}</td>
                        <td>{{ $booking->location }}</td>
                        <td>{{ $booking->summary }}</td>
                        <td>{{ $booking->description }}</td>

                        <td>
                            <div class='btn-group'>

                                <a class='btn btn-danger btn-sm' href="{{ route('calendar.edit', ['booking' => $booking->booking_id]) }}" role='button'>
                                    <button class="btn btn-danger btn-sm delete-booking">
                                        <i class="fa-solid fa-pen-to-square"></i>

                                    </button>
                                </a>
                                <!-- <a class='btn btn-danger btn-sm' href="/bookings{{ $booking->booking_id }}/edit" role='button'>
                                <button class="btn btn-danger btn-sm delete-booking">
                                <i class="fa-solid fa-pen-to-square"></i>

                                </button>   
                                </a> -->

                                <button type="button" class="btn btn-danger btn-sm delete-booking"
                                    data-event-id="{{ $booking->event_id }}" onclick="deleteEvent('{{ $booking->event_id }}', '{{ $booking->booking_id }}')">
                                    <i class='fa-solid fa-trash'></i>
                                </button>
                            </div>
                        </td>


                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="content" class="mt-4"></div>
</div>
@endsection


<script src="https://apis.google.com/js/api.js" onload="gapiLoaded()" async defer></script>
<script src="https://accounts.google.com/gsi/client" onload="gisLoaded()" async defer></script>
<script type="text/javascript">
    // Google Calendar API settings
    const CLIENT_ID = "269162590647-alh83bvusko86o4svfge4lsl5abn1c08.apps.googleusercontent.com";
    const API_KEY = "AIzaSyCciXrg_icHlFR-hn-ROqWp9KP4QW0Z5eE";
    const DISCOVERY_DOC = "https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest";
    const SCOPES = "https://www.googleapis.com/auth/calendar";

    let tokenClient;
    let gapiInited = false;
    let gisInited = false;
    let currentEventId = null;

    // CSRF token for AJAX requests
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Teams data passed from the controller
    const teams = "Ai"

    function gapiLoaded() {
        gapi.load("client", initializeGapiClient);
    }

    async function initializeGapiClient() {
        await gapi.client.init({
            apiKey: API_KEY,
            discoveryDocs: [DISCOVERY_DOC],
        });
        gapiInited = true;
        checkIfAuthorized();
    }

    function gisLoaded() {
        tokenClient = google.accounts.oauth2.initTokenClient({
            client_id: CLIENT_ID,
            scope: SCOPES,
            callback: handleAuthResponse,
        });
        gisInited = true;
        checkIfAuthorized();
    }

    // Check if user is already authorized
    function checkIfAuthorized() {
        const token = sessionStorage.getItem('google_token');
        if (token) {
            gapi.client.setToken({
                access_token: token
            });
            document.getElementById("form-container").style.display = "block";
            listUpcomingEvents();
            loadRooms();
        } else if (gapiInited && gisInited) {
            // If not authorized, auto-trigger the authorization
            handleAuthClick();
        }
    }

    function handleAuthResponse(resp) {
        if (resp.error !== undefined) {
            console.error("Authorization error:", resp.error);
            document.getElementById("content").innerText = `Authorization error: ${resp.error}`;
            return;
        }

        sessionStorage.setItem('google_token', resp.access_token); // Store token in sessionStorage

        document.getElementById("form-container").style.display = "block";
        listUpcomingEvents();
        loadRooms();
    }

    function handleAuthClick() {
        if (gapi.client.getToken() === null) {
            tokenClient.requestAccessToken({
                prompt: "consent"
            });
        } else {
            tokenClient.requestAccessToken({
                prompt: ""
            });
        }
    }

    function handleSignoutClick() {
        sessionStorage.removeItem('google_token');
        const token = gapi.client.getToken();
        if (token !== null) {
            google.accounts.oauth2.revoke(token.access_token);
            gapi.client.setToken("");
            document.getElementById("form-container").style.display = "none";
            alert("Signed out. You will need to authorize again.");
        }
    }

    function handleSignoutClick() {
        sessionStorage.removeItem('google_token');
        const token = gapi.client.getToken();
        if (token !== null) {
            google.accounts.oauth2.revoke(token.access_token);
            gapi.client.setToken("");
            document.getElementById("form-container").style.display = "none";
            alert("Signed out. You will need to authorize again.");
        }
    }

    async function listUpcomingEvents() {
        let response;
        try {
            const request = {
                calendarId: "primary",
                timeMin: new Date().toISOString(),
                showDeleted: false,
                singleEvents: true,
                maxResults: 50,
                orderBy: "startTime",
            };
            response = await gapi.client.calendar.events.list(request);
            console.log('API Response:', response);
        } catch (err) {
            alert(err.message);
            console.error("Error fetching events:", err);
            document.getElementById("content").innerText = `Error fetching events: ${err.message}`;
            return;
        }

        const events = response.result.items;
        if (!events || events.length === 0) {
            document.getElementById("content").innerText = "No upcoming events found.";
            return;
        }

        const contentDiv = document.getElementById("content");
        contentDiv.innerHTML = "<h2>Google Calendar Events</h2>";

        const table = document.createElement("table");
        table.className = "table table-striped table-bordered";
        const thead = document.createElement("thead");
        const tbody = document.createElement("tbody");

        thead.innerHTML = `
            <tr>
                <th>Summary</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Team Name</th>
                <th>Point of Contact</th>
                <th>Actions</th>
            </tr>
        `;

        events.forEach((event) => {
            const tr = document.createElement("tr");
            const start = event.start.dateTime || event.start.date;
            const end = event.end.dateTime || event.end.date;

            console.log(event);

            tr.innerHTML = `
                <td>${event.summary || 'N/A'}</td>
                <td>${start}</td>
                <td>${end}</td>
                <td>${event.location || 'N/A'}</td>
                <td>${event.description || 'N/A'}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editEvent('${event.id}')">Edit</button>
                  
                </td>
            `;
            tbody.appendChild(tr);
        });

        table.appendChild(thead);
        table.appendChild(tbody);
        contentDiv.appendChild(table);
    }

    async function loadRooms() {
        const roomTypeSelect = document.getElementById("room_type");
        const roomSelect = document.getElementById("room");

        roomTypeSelect.addEventListener("change", async () => {
            const roomType = roomTypeSelect.value;
            let rooms;

            try {
                const response = await fetch(`/rooms?type=${roomType}`);
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                rooms = await response.json();
            } catch (err) {
                console.error("Error loading rooms:", err);
                return;
            }

            roomSelect.innerHTML = "";

            rooms.forEach((room) => {
                const option = document.createElement("option");
                option.value = room.id;
                option.textContent = room.name;
                roomSelect.appendChild(option);
            });
        });

        roomTypeSelect.dispatchEvent(new Event("change"));
    }

    document.getElementById("create_event_button").addEventListener("click", createEvent);

    async function createEvent() {
        const summary = document.getElementById("summary").value;
        const teamNameSelect = document.getElementById("teamName");
        const teamName = teamNameSelect.value;
        const pointOfContact = document.getElementById("point_of_contact").value;
        const location = document.getElementById("location").value;
        const description = document.getElementById("description").value;
        const start = document.getElementById("start").value;
        const end = document.getElementById("end").value;
        const roomType = document.getElementById("room_type").value;
        const roomId = document.getElementById("room").value;
        const roomName = document.getElementById("room").selectedOptions[0].text;

        if (!summary || !teamName || !location || !description || !start || !end || !roomType || !roomId) {
            alert("Please fill in all fields.");
            return;
        }

        try {
            const availabilityResponse = await fetch('/check-availability', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({
                    roomId: roomId,
                    startTime: new Date(start).toISOString(),
                    endTime: new Date(end).toISOString(),
                    roomType: roomType
                })
            });

            if (!availabilityResponse.ok) {
                throw new Error("Network response was not ok");
            }

            const availabilityData = await availabilityResponse.json();
            console.log("Room availability response:", availabilityData);

            if (availabilityData.available) {
                const event = {
                    summary: summary,
                    location: location,
                    description: `${description}\nTeam: ${teamName}\nPoint of Contact: ${pointOfContact}\nRoom Type: ${roomType}\nRoom: ${roomName}`,
                    start: {
                        dateTime: new Date(start).toISOString(),
                        timeZone: "Asia/Karachi",
                    },
                    end: {
                        dateTime: new Date(end).toISOString(),
                        timeZone: "Asia/Karachi",
                    },
                };

                try {
                    const eventResponse = await gapi.client.calendar.events.insert({
                        calendarId: "primary",
                        resource: event,
                    });

                    const eventId = eventResponse.result.id;
                    console.log("Event created:", eventResponse, eventId);
                    const bookingData = {
                        summary: summary,
                        eventId: eventId,
                        roomId: roomId,
                        roomType: roomType,
                        teamName: teamName,
                        pointOfContact: pointOfContact,
                        location: location,
                        startTime: new Date(start).toISOString(),
                        endTime: new Date(end).toISOString(),
                        description: description
                    };

                    const saveResponse = await fetch('/save-booking', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        body: JSON.stringify(bookingData)
                    });

                    if (!saveResponse.ok) {
                        throw new Error("Failed to save booking to the database");
                    }

                    alert("Event created successfully!");

                    // Reset form
                    document.getElementById("summary").value = '';
                    document.getElementById("teamName").value = '';
                    document.getElementById("point_of_contact").value = '';
                    document.getElementById("location").value = '';
                    document.getElementById("description").value = '';
                    document.getElementById("start").value = '';
                    document.getElementById("end").value = '';

                    // Refresh the event list
                    window.location.reload();
                } catch (err) {
                    console.error("Error creating event:", err);
                    alert("Error creating event: " + err.message);
                }
            } else {
                let alternativeRoomsHtml = "<h3>Selected room is not available. Please choose another room:</h3><ul class='list-group'>";

                if (Array.isArray(availabilityData.alternatives) && availabilityData.alternatives.length > 0) {
                    availabilityData.alternatives.forEach(room => {
                        alternativeRoomsHtml += `<li class='list-group-item'>${room.name} (ID: ${room.id})</li>`;
                    });
                } else {
                    alternativeRoomsHtml += "<li class='list-group-item'>No alternative rooms available.</li>";
                }

                alternativeRoomsHtml += "</ul>";
                document.getElementById("content").innerHTML = alternativeRoomsHtml;
            }
        } catch (err) {
            console.error("Error checking room availability:", err);
            alert("Error checking room availability: " + err.message);
        }
    }

    function formatDateForInput(date) {
        const d = new Date(date);
        const year = d.getFullYear();
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        const hours = String(d.getHours()).padStart(2, '0');
        const minutes = String(d.getMinutes()).padStart(2, '0');
        return `${year}-${month}-${day}T${hours}:${minutes}`;
    }

    async function editEvent(eventId) {
        try {
            const response = await gapi.client.calendar.events.get({
                calendarId: "primary",
                eventId: eventId,
            });
            const event = response.result;

            document.getElementById("summary").value = event.summary || '';
            document.getElementById("location").value = event.location || '';
            document.getElementById("description").value = event.description || '';

            const startDate = formatDateForInput(event.start.dateTime || event.start.date);
            const endDate = formatDateForInput(event.end.dateTime || event.end.date);

            document.getElementById("start").value = startDate;
            document.getElementById("end").value = endDate;

            // Scroll to form
            document.getElementById("form-container").scrollIntoView({
                behavior: 'smooth'
            });

            document.getElementById("create_event_button").style.display = "none";
            document.getElementById("update_event_button").style.display = "block";
            currentEventId = eventId;

            // TODO: Set team and point of contact based on event data
        } catch (err) {
            console.error("Error fetching event for editing:", err);
            alert("Failed to load event for editing: " + err.message);
        }
    }

   
    // Setup team selection to automatically populate point of contact
    const teamSelect = document.getElementById('teamName');
    const pointOfContactInput = document.getElementById('point_of_contact');

    teamSelect.addEventListener('change', function() {
        const selectedTeam = teamSelect.value;
        const teamData = teams.find(team => team.team_name === selectedTeam);

        if (teamData) {
            pointOfContactInput.value = teamData.point_of_contact;
        } else {
            pointOfContactInput.value = '';
        }
    });




    async function deleteEvent(eventId,bookingId) {
        if (!confirm('Are you sure you want to delete this booking?')) {
            return;
        }

        try {
            // First, delete from Google Calendar
            if (gapi.client) {
                console.log('Deleting event from Google Calendar:', eventId);
                try {
                    console.log('Deleting event from Google Calendar inside the try block:', eventId);
                    await gapi.client.calendar.events.delete({
                        calendarId: 'primary',
                        eventId: eventId
                    });
                    console.log('Event deleted from Google Calendar');
                } catch (err) {
                    console.error('Error deleting from Google Calendar:', err);
                    // Continue with database deletion even if Google Calendar deletion fails
                }
            } else {
                console.warn('Google API client not initialized, only deleting from database');
            }

            // Then delete from database
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log("booking id is ", bookingId)
            const response = await fetch('/delete-booking', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                  
                    booking_id: bookingId
                })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to delete booking from the database');
            }

            alert('Booking deleted successfully!');

            // // Reload the page or update the UI
            window.location.reload();
        } catch (err) {
            console.error('Error deleting event:', err);
            alert('Error deleting booking: ' + err.message);
        }
    }




</script>
