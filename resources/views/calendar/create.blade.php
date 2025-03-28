@extends('layouts.app')

@section('title', 'Create Booking')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <button id="authorize_button" onclick="handleAuthClick()">Authorize</button>
                <button id="signout_button" onclick="handleSignoutClick()">Sign Out</button>
                <div class="card-header">
                    <h2>Create Booking</h2>
                </div>
                <div class="card-body">
                    <div id="form-container">
                        <div class="mb-3">
                            <label for="summary" class="form-label">Summary:</label>
                            <input type="text" id="summary" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Branch:</label>
                            <select id="location" name="location" class="form-select" required>
                                <option value="">--Select Branch--</option>
                                @foreach($branches as $branch)
                                <option value="{{ $branch->branch_name }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="teamName" class="form-label">Team:</label>
                            <select id="teamName" name="team" class="form-select" required>
                                <option value="">--Select a Team--</option>
                                @foreach($teams as $team)
                                <option value="{{ $team->team_name }}">{{ $team->team_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="point_of_contact" class="form-label">Point of Contact:</label>
                            <input type="text" id="point_of_contact" name="point_of_contact" class="form-control" />
                        </div>



                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <input type="text" id="description" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label for="start" class="form-label">Start Time:</label>
                            <input type="datetime-local" id="start" class="form-control" required onclick="this.showPicker();" />
                        </div>

                        <div class="mb-3">
                            <label for="end" class="form-label">End Time:</label>
                            <input type="datetime-local" id="end" class="form-control" required onclick="this.showPicker();" />
                        </div>

                        <div class="mb-3">
                            <label for="room_type" class="form-label">Room Type:</label>
                            <select id="room_type" class="form-select" required>
                                <option value="meeting">Meeting Room</option>
                                <option value="huddle">Huddle Room</option>
                                <option value="Event_Hall">Event Hall</option>
                            </select>
                        </div>



                        <div class="d-grid gap-2">
                            <button id="create_booking_button" class="btn btn-primary">Save Booking</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOM fully loaded");

        // CSRF token for AJAX requests
        // const CSRF_TOKEN = 'eyJpdiI6Ik9zQy9PdUhrLzh0MmI5ak9QN1JYdnc9PSIsInZhbHVlIjoibVJLME54Nmt1N2UwazErYjFDZWh1Ri8xM0xSMnZDMVZqbkQ5cUE0VDgzOEdYSlYvd1BaQXpVUHdJampKKzJBTldwYUc1dkVLejdsL1pBeVpYZTZPSXFBc04wQWptMEhlYjZPNEt6MGs0SlVzaTFNNldTWlNOOWdYSytWOU5jM08iLCJtYWMiOiIxZjJjYmY5YzllNzViMTIyYjY4MzUwYjc2ZGNkYjcwZTExYjcyMWUyYTljOWNjM2E2NmUxYzA1Y2FkNWVlNWQ2IiwidGFnIjoiIn0%3D';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Branch select element
        const branchSelect = document.getElementById("location");
        // Team select element
        const teamSelect = document.getElementById("teamName");
        // Point of contact input
        const pointOfContactInput = document.getElementById("point_of_contact");

        // google calendar api start









        // Load teams based on selected branch
        branchSelect.addEventListener("change", async () => {
            const selectedBranch = branchSelect.value;

            teamSelect.innerHTML = ""; // Clear existing options

            // Add default option
            const defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.textContent = "--Select a Team--";
            teamSelect.appendChild(defaultOption);

            if (selectedBranch) {
                try {
                    console.log("Loading teams for branch:", selectedBranch);

                    // Use the actual URL path instead of the route helper
                    const response = await fetch(`/branch-teams?branch=${encodeURIComponent(selectedBranch)}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error("Response error:", errorText);
                        throw new Error(`Network response was not ok (${response.status})`);
                    }

                    const teams = await response.json();
                    console.log("Teams loaded:", teams);

                    // Add team options
                    teams.forEach((team) => {
                        const option = document.createElement("option");
                        option.value = team.team_name;
                        option.textContent = team.team_name;
                        teamSelect.appendChild(option);
                    });
                } catch (err) {
                    console.error("Error loading teams:", err);
                    alert("Error loading teams: " + err.message);
                }
            }

            // Clear point of contact when branch changes
            pointOfContactInput.value = '';
        });

        // Setup team selection to automatically populate point of contact
        teamSelect.addEventListener('change', async function() {
            const selectedTeam = teamSelect.value;

            if (selectedTeam) {
                try {
                    // Use the actual URL path instead of the route helper
                    const response = await fetch(`/team-contact?team=${encodeURIComponent(selectedTeam)}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }

                    const data = await response.json();
                    pointOfContactInput.value = data.point_of_contact || '';
                } catch (err) {
                    console.error("Error fetching team contact:", err);
                    pointOfContactInput.value = '';
                }
            } else {
                pointOfContactInput.value = '';
            }
        });

        // Get button and attach event listener
        const bookingButton = document.getElementById("create_booking_button");
        if (bookingButton) {
            bookingButton.addEventListener("click", createBooking);
            console.log("Event listener attached to booking button");
        } else {
            console.error("Button not found: create_booking_button");
        }

        async function createBooking() {
            console.log("Creating booking...");

            // Get form values
            const summary = document.getElementById("summary").value;
            const teamName = document.getElementById("teamName").value;
            const pointOfContact = document.getElementById("point_of_contact").value;
            const location = document.getElementById("location").value;
            const description = document.getElementById("description").value;
            const start = document.getElementById("start").value;
            const end = document.getElementById("end").value;
            const roomType = document.getElementById("room_type").value;

            // Validate form inputs
            if (!summary || !teamName || !description || !start || !end || !roomType) {
                alert("Please fill in all required fields.");
                return;
            }

            try {
                // Create the event object first
                const event = {
                    summary: summary,
                    location: location,
                    description: description + '\nTeam: ' + teamName + '\nPoint of Contact: ' + pointOfContact + '\nRoom Type: ' + roomType,
                    start: {
                        dateTime: new Date(start).toISOString(),
                        timeZone: 'Asia/Karachi'
                    },
                    end: {
                        dateTime: new Date(end).toISOString(),
                        timeZone: 'Asia/Karachi'
                    }
                };

                // First, create the event in Google Calendar to get the real eventId
                let eventId = null;

                try {
                    // Make sure the API client is initialized
                    if (!gapi.client) {
                        throw new Error("Google API client not initialized");
                    }

                    const response = await gapi.client.calendar.events.insert({
                        calendarId: 'primary',
                        resource: event,
                    });

                    // Get the event ID returned by Google Calendar
                    eventId = response.result.id;
                    console.log("Event created with ID: ", eventId);
                } catch (err) {
                    console.error('Error creating event in Google Calendar: ', err);
                    alert('Failed to create event in Google Calendar: ' + err.message);
                    return; // Exit the function if Google Calendar creation fails
                }

                // Only proceed if we have a valid event ID
                if (!eventId) {
                    alert("Failed to get event ID from Google Calendar");
                    return;
                }

                // Now prepare the booking data with the real Google Calendar event ID
                const bookingData = {
                    summary: summary,
                    eventId: eventId, // Use the ID returned by Google
                    teamName: teamName,
                    pointOfContact: pointOfContact,
                    location: location || "pwd",
                    description: description,
                    startTime: new Date(start).toLocaleString('en-US', {
                        timeZone: 'Asia/Karachi'
                    }),
                    endTime: new Date(end).toLocaleString('en-US', {
                        timeZone: 'Asia/Karachi'
                    }),
                    roomType: roomType,
                };

                console.log("Saving to database with eventId:", eventId);
                console.log("Booking data:", bookingData);

                // Save to database
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const saveResponse = await fetch('/save-booking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(bookingData)
                });

                if (!saveResponse.ok) {
                    const errorData = await saveResponse.json();
                    throw new Error(errorData.message || "Failed to save booking to the database");
                }

                const saveData = await saveResponse.json();
                alert("Booking saved successfully!");

                // Reset form
                document.getElementById("summary").value = '';
                document.getElementById("teamName").value = '';
                document.getElementById("point_of_contact").value = '';
                document.getElementById("location").value = '';
                document.getElementById("description").value = '';
                document.getElementById("start").value = '';
                document.getElementById("end").value = '';
                document.getElementById("room_type").value = 'meeting';

                // Redirect to calendar index page
                window.location.href = '/bookings';
            } catch (err) {
                console.error("Error saving booking: ", err);
                alert("Error saving booking: " + err.message);
            }
        }


    });


    const CLIENT_ID = "269162590647-alh83bvusko86o4svfge4lsl5abn1c08.apps.googleusercontent.com";
    const API_KEY = "AIzaSyCciXrg_icHlFR-hn-ROqWp9KP4QW0Z5eE";
    const DISCOVERY_DOC = "https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest";
    const SCOPES = "https://www.googleapis.com/auth/calendar";

    let tokenClient;
    let gapiInited = false;
    let gisInited = false;

    // Initialize Google API Client
    function gapiLoaded() {
        gapi.load('client', initializeGapiClient);
    }

    async function initializeGapiClient() {
        await gapi.client.init({
            apiKey: API_KEY,
            discoveryDocs: [DISCOVERY_DOC],
        });
        gapiInited = true;
        maybeEnableButtons();
    }

    function gisLoaded() {
        tokenClient = google.accounts.oauth2.initTokenClient({
            client_id: CLIENT_ID,
            scope: SCOPES,
            callback: '',
        });
        gisInited = true;
        maybeEnableButtons();
    }

    function maybeEnableButtons() {
        const token = sessionStorage.getItem('google_token');
        if (gapi.client && token) {
            gapi.client.setToken({
                access_token: token
            });
            document.getElementById('signout_button').style.visibility = 'visible';
            document.getElementById('authorize_button').innerText = 'Refresh';
            document.getElementById('form-container').style.display = 'block';
            listUpcomingEvents(); // List existing events
        } else if (gapiInited && gisInited) {
            document.getElementById('authorize_button').style.visibility = 'visible';
        }
    }

    // Authentication functions
    function handleAuthClick() {
        tokenClient.callback = async (resp) => {
            if (resp.error !== undefined) {
                throw (resp);
            }
            sessionStorage.setItem('google_token', resp.access_token);
            document.getElementById('signout_button').style.visibility = 'visible';
            document.getElementById('authorize_button').innerText = 'Refresh';
            document.getElementById('form-container').style.display = 'block';
            listUpcomingEvents();
        };

        if (gapi.client.getToken() === null) {
            tokenClient.requestAccessToken({
                prompt: 'consent'
            });
        } else {
            tokenClient.requestAccessToken({
                prompt: ''
            });
        }
    }

    function handleSignoutClick() {
        const token = gapi.client.getToken();
        if (token !== null) {
            google.accounts.oauth2.revoke(token.access_token);
            gapi.client.setToken('');
            sessionStorage.removeItem('google_token');
            document.getElementById('content').innerText = '';
            document.getElementById('authorize_button').innerText = 'Authorize';
            document.getElementById('signout_button').style.visibility = 'hidden';
        }
    }

    // Insert event into Google Calendar
    async function createEvent() {
        const summary = document.getElementById('summary').value;
        const description = document.getElementById('description').value;
        const location = document.getElementById('branch_id').value;
        const teamName = document.getElementById('teamName').value;
        const pointOfContact = document.getElementById('point_of_contact').value;
        const startDateTime = new Date(document.getElementById('start').value).toISOString();
        const endDateTime = new Date(document.getElementById('end').value).toISOString();
        const roomType = document.getElementById('room_type').value;

        const event = {
            summary: summary,
            location: location,
            description: description + '\nTeam: ' + teamName + '\nPoint of Contact: ' + pointOfContact + '\nRoom Type: ' + roomType,
            start: {
                dateTime: startDateTime,
                timeZone: 'Asia/Karachi'
            },
            end: {
                dateTime: endDateTime,
                timeZone: 'Asia/Karachi'
            }
        };

        try {
            // Make sure the API client is initialized
            if (!gapi.client) {
                throw new Error("Google API client not initialized");
            }

            const response = await gapi.client.calendar.events.insert({
                calendarId: 'primary',
                resource: event,
            });

            const eventId = response.result.id;

            // Now send the event details to your back-end (PHP) for saving
            const responsess = await fetch('save_booking.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    eventId: eventId, // Pass event ID to the back-end
                    summary: summary,
                    description: description,
                    location: location,
                    startTime: startDateTime,
                    endTime: endDateTime,
                    roomType: roomType,
                    teamName: teamName,
                    pointOfContact: pointOfContact
                })
            });

            return {
                success: true,
                eventId: eventId
            };
        } catch (err) {
            console.error('Error creating event: ', err);
            return {
                success: false,
                error: err.message
            };
        }
    }



    // google calendar api end
</script>
<script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
<script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>