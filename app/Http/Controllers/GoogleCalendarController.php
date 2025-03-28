<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TeamBooking as Team;
use App\Models\MeetingRoom as Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\BranchDetails as Branch;

class GoogleCalendarController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('admin');
    }
// Remove this method from the controller as it belongs in the Booking model

// Then in your controller

// In your controller
public function index(Request $request)
{
    $branchId = $request->branch_id;
    $teams = Team::all(['team_name', 'point_of_contact']);
    $bookingsQuery = Booking::orderBy('booking_id', 'desc');
    
    if ($branchId) {
        // Instead of using whereHas with an invalid column, filter by location
        $branch = Branch::find($branchId);
        if ($branch) {
            $bookingsQuery->where('location', $branch->branch_name); // Adjust as needed
        }
    }
    
    $bookings = $bookingsQuery->paginate(10);
    $branches = Branch::orderBy('branch_name')->get();
    
    return view('calendar.index', compact('teams', 'bookings', 'branches', 'branchId'));
}
    public function getRooms(Request $request)
    {
        $type = $request->query('type', 'meeting');
        $rooms = Room::where('type', $type)->get();

        return response()->json($rooms);
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'roomId' => 'required',
            'startTime' => 'required|date',
            'endTime' => 'required|date|after:startTime',
            'roomType' => 'required|string'
        ]);

        $roomId = $request->roomId;
        $startTime = $request->startTime;
        $endTime = $request->endTime;
        $roomType = $request->roomType;

        // Check if room is already booked during the requested time
        $existingBooking = Booking::where('room_id', $roomId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })->first();

        if ($existingBooking) {
            // Room is not available, find alternatives
            $alternativeRooms = Room::where('type', $roomType)
                ->where('id', '!=', $roomId)
                ->whereNotIn('id', function ($query) use ($startTime, $endTime) {
                    $query->select('room_id')
                        ->from('bookings')
                        ->where(function ($q) use ($startTime, $endTime) {
                            $q->whereBetween('start_time', [$startTime, $endTime])
                                ->orWhereBetween('end_time', [$startTime, $endTime])
                                ->orWhere(function ($innerQ) use ($startTime, $endTime) {
                                    $innerQ->where('start_time', '<=', $startTime)
                                        ->where('end_time', '>=', $endTime);
                                });
                        });
                })->get();

            return response()->json([
                'available' => false,
                'alternatives' => $alternativeRooms
            ]);
        }

        return response()->json([
            'available' => true
        ]);
    }

    public function saveBooking(Request $request)
    {
        $request->validate([
            'summary' => 'required|string',
            'eventId' => 'required|string',

            'roomType' => 'required|string',
            'teamName' => 'required|string',
            'pointOfContact' => 'required|string',
            'location' => 'required|string',
            'startTime' => 'required|date',
            'endTime' => 'required|date|after:startTime',
            'description' => 'nullable|string'
        ]);

        try {
            $booking = Booking::create([
                'event_id' => $request->eventId,
                'team_name' => $request->teamName,
                'point_of_contact' => $request->pointOfContact,
                'location' => $request->location,
                'description' => $request->description,
                'start_time' => $request->startTime,
                'end_time' => $request->endTime,
                'room_type' => $request->roomType,

                'summary' => $request->summary,
            ]);

            return response()->json([
                'success' => true,
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving booking: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error saving booking: ' . $e->getMessage()
            ], 500);
        }
    }

    // CONTROLLER METHOD
    public function deleteBooking(Request $request)
    {
        $request->validate([
            'booking_id' => '|string'
        ]);

        try {
            // Find the booking by its ID
            $booking = Booking::find($request->booking_id);

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found'
                ], 404);
            }

            // Delete from database
            $booking->delete();

            return response()->json([
                'success' => true,
                'message' => 'Booking deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting booking: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error deleting booking: ' . $e->getMessage()
            ], 500);
        }
    }

    // edit booking form
    public function editBooking(Booking $booking)
    {
        // Load required data for the edit form
        $branches = Branch::all();
        $teams = Team::all();

        return view('calendar.edit', compact('booking', 'branches', 'teams'));
    }
    // Update booking  table
    public function updateBooking(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,booking_id', // Validate that the booking exists
            'summary' => 'required|string',
            'team_name' => 'required|string',
            'point_of_contact' => 'required|string',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'room_type' => 'required|string',
            'event_id' => 'nullable|string'
        ]);

        try {
            // Find the booking by ID
            $booking = Booking::where('booking_id', $request->booking_id)->first();

            if (!$booking) {
                return response()->json(['error' => 'Booking not found'], 404);
            }

            // Update the booking
            $booking->update([
                'summary' => $request->summary,
                'team_name' => $request->team_name,
                'point_of_contact' => $request->point_of_contact,
                'location' => $request->location,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'room_type' => $request->room_type,
                'event_id' => $request->event_id
            ]);

            return response()->json(['message' => 'Booking updated successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating booking: ' . $e->getMessage());
            return response()->json(['error' => 'Error updating booking: ' . $e->getMessage()], 500);
        }
    }


    // get team by branch filter
    public function getTeamsByBranch(Request $request)
    {
        try {
            // Get branch name from request
            $branchName = $request->query('branch', '');

            // Find the branch ID from branch_details table using the branch name
            $branch = Branch::where('branch_name', $branchName)->first();

            if (!$branch) {
                return response()->json([], 404); // Return empty array if branch not found
            }

            // Use the branch ID to find associated teams
            $teams = Team::where('branch_id', $branch->branch_id)->get(['team_name', 'point_of_contact']);

            return response()->json($teams);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // get point of contact by team filter
    public function getTeamContact(Request $request)
    {
        $teamName = $request->query('team', '');
        $team = Team::where('team_name', $teamName)->first();

        return response()->json([
            'point_of_contact' => $team ? $team->point_of_contact : ''
        ]);
    }



    public function createEventForm()
    {
        $teams = \App\Models\TeamBooking::all(['team_name', 'point_of_contact']);
        $bookings = \App\Models\Booking::all(); // You can remove this if not needed for the form
        $branches = \App\Models\BranchDetails::all();
        return view('calendar.create', compact('teams', 'bookings', 'branches')); // Add semicolon here
    }
}
