@extends('layouts.app')

@section('title', 'Edit Booking')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <button id="authorize_button" onclick="handleAuthClick()">Authorize</button>
                <button id="signout_button" onclick="handleSignoutClick()">Sign Out</button>
                <div class="card-header">
                    <h2>Edit Booking</h2>
                </div>
                <div class="card-body">
                    <div id="form-container">
                        <input type="hidden" id="booking_id" value="{{ $booking->booking_id }}">
                        <input type="hidden" id="event_id" value="{{ $booking->event_id }}">

                        <div class="mb-3">
                            <label for="summary" class="form-label">Summary:</label>
                            <input type="text" id="summary" class="form-control" value="{{ $booking->summary }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Branch:</label>
                            <select id="location" name="location" class="form-select" required>
                                <option value="">--Select Branch--</option>
                                @foreach($branches as $branch)
                                <option value="{{ $branch->branch_name }}" {{ $booking->location == $branch->branch_name ? 'selected' : '' }}>
                                    {{ $branch->branch_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="teamName" class="form-label">Team:</label>
                            <select id="teamName" name="team" class="form-select" required>
                                <option value="">--Select a Team--</option>
                                @foreach($teams as $team)
                                <option value="{{ $team->team_name }}" {{ $booking->team_name == $team->team_name ? 'selected' : '' }}>
                                    {{ $team->team_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="point_of_contact" class="form-label">Point of Contact:</label>
                            <input type="text" id="point_of_contact" name="point_of_contact" value="{{ $booking->point_of_contact }}" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <input type="text" id="description" class="form-control" value="{{ $booking->description }}" required />
                        </div>

                        <div class="mb-3">
                            <label for="start" class="form-label">Start Time:</label>
                            <input type="datetime-local" id="start" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($booking->start_time)) }}" required onclick="this.showPicker();" />
                        </div>

                        <div class="mb-3">
                            <label for="end" class="form-label">End Time:</label>
                            <input type="datetime-local" id="end" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($booking->end_time)) }}" required onclick="this.showPicker();" />
                        </div>

                        <div class="mb-3">
                            <label for="room_type" class="form-label">Room Type:</label>
                            <select id="room_type" class="form-select" required>
                                <option value="meeting" {{ $booking->room_type == 'meeting' ? 'selected' : '' }}>Meeting Room</option>
                                <option value="huddle" {{ $booking->room_type == 'huddle' ? 'selected' : '' }}>Huddle Room</option>
                                <option value="Event_Hall" {{ $booking->room_type == 'Event_Hall' ? 'selected' : '' }}>Event Hall</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button id="update_booking_button" class="btn btn-primary">Update Booking</button>
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
        console.log("Edit form DOM fully loaded");

        // CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Branch select element
        const branchSelect = document.getElementById("location");
        // Team select element
        const teamSelect = document.getElementById("teamName");
        // Point of contact input
        const pointOfContactInput = document.getElementById("point_of_contact");

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
        const updateButton = document.getElementById("update_booking_button");
        if (updateButton) {
            updateButton.addEventListener("click", updateBooking);
            console.log("Event listener attached to update button");
        } else {
            console.error("Button not found: update_booking_button");
        }

        async function updateBooking() {
            console.log("Updating booking...");

            // Get form values
            const bookingId = document.getElementById("booking_id").value;
            let eventId = document.getElementById("event_id").value;
            const summary = document.getElementById("summary").value;
            const teamName = document.getElementById("teamName").value;
            const pointOfContact = document.getElementById("point_of_contact").value;
            const location = document.getElementById("location").value;
            const description = document.getElementById("description").value;
            const start = document.getElementById("start").value;
            const end = document.getElementById("end").value;
            const roomType = document.getElementById("room_type").value;
            console.log("Form Values:", {
                bookingId,
                eventId,
                summary,
                teamName,
                pointOfContact,
                location,
                description,
                start,
                end,
                roomType
            });
            // Validate form inputs
            if (!summary || !teamName || !description || !start || !end || !roomType) {
                alert("Please fill in all required fields.");
                return;
            }

            try {
                let calendarUpdateSuccess = false;

                // First, update Google Calendar event if authenticated
                // First, update Google Calendar event if authenticated
                if (gapi.client && gapi.client.getToken()) {
                    try {
                        // Create event object for Google Calendar
                        const event = {
                            summary: summary,
                            location: location || 'pwd islamabad',
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

                        // Log the event data being sent to Google
                        console.log("Google Calendar event data:", event);

                        // Update the Google Calendar event if we have an event ID
                        if (eventId && eventId !== "null" && eventId !== "undefined") {
                            console.log("Attempting to update Google Calendar event with ID:", eventId);

                            try {
                                // Using the proper format from the documentation
                                const request = gapi.client.calendar.events.update({
                                    calendarId: 'primary',
                                    eventId: eventId,
                                    resource: event,
                                    sendUpdates: 'all' // Sends email updates to attendees
                                });

                                // Execute the request
                                const calendarResponse = await request;

                                // Log the full response for debugging
                                console.log("Google Calendar update response:", calendarResponse);

                                if (calendarResponse && calendarResponse.status === 200) {
                                    console.log("Google Calendar event updated successfully");
                                    calendarUpdateSuccess = true;
                                } else {
                                    console.error("Google Calendar update returned non-success status:", calendarResponse.status);
                                }
                            } catch (updateErr) {
                                console.error("Failed to update Google Calendar event:", updateErr);

                                // Check for specific error types
                                if (updateErr.status === 404) {
                                    console.error("Event not found. The event ID may be invalid or the event has been deleted.");
                                } else if (updateErr.status === 403) {
                                    console.error("Permission denied. You may not have access to update this event.");
                                } else if (updateErr.status === 401) {
                                    console.error("Unauthorized. The token may have expired. Try re-authorizing.");
                                    // Prompt user to reauthorize
                                    alert("Your Google Calendar authorization has expired. Please authorize again.");
                                    document.getElementById('authorize_button').innerText = 'Authorize';
                                    document.getElementById('signout_button').style.visibility = 'hidden';
                                }

                                // Continue with database update even if calendar update fails
                            }
                        } else {
                            console.log("No valid Google Calendar event ID provided:", eventId);
                        }
                    } catch (calendarErr) {
                        console.error("Error preparing Google Calendar update:", calendarErr);
                        // Continue with database update even if calendar fails
                    }
                }

                // Prepare booking data for database update - use snake_case for backend
                const bookingData = {
                    booking_id: bookingId,
                    event_id: eventId,
                    summary: summary,
                    team_name: teamName,
                    point_of_contact: pointOfContact,
                    location: location || 'pwd islamabad',
                    description: description,
                    start_time: new Date(start).toISOString(),
                    end_time: new Date(end).toISOString(),
                    room_type: roomType,
                };

                console.log("Sending to server:", bookingData);

                // Update in database
                const updateResponse = await fetch('/update-booking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(bookingData)
                });

                if (!updateResponse.ok) {
                    const contentType = updateResponse.headers.get("content-type");
                    if (contentType && contentType.indexOf("application/json") !== -1) {
                        const errorData = await updateResponse.json();
                        if (errorData.errors) {
                            const errorMessages = Object.values(errorData.errors).flat().join(". ");
                            throw new Error(errorMessages);
                        } else if (errorData.message) {
                            throw new Error(errorData.message);
                        } else {
                            throw new Error("Failed to update booking in the database");
                        }
                    } else {
                        const textResponse = await updateResponse.text();
                        throw new Error("Server error: " + textResponse.substring(0, 100) + "...");
                    }
                }
               

                let successMessage = "Booking updated successfully!";
                if (!calendarUpdateSuccess && gapi.client && gapi.client.getToken()) {
                    successMessage += " Note: Google Calendar event could not be updated.";
                }

                alert(successMessage);

                // Redirect to calendar index page
                window.location.href = '/bookings';
            } catch (err) {
                console.error("Error updating booking:", err);
                alert("Error updating booking: " + err.message);
            }
        }
    });

    // Google Calendar API configuration and functions
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
            document.getElementById('authorize_button').innerText = 'Authorize';
            document.getElementById('signout_button').style.visibility = 'hidden';
        }
    }
</script>
<script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
<script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>