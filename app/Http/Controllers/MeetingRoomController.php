<?php
namespace App\Http\Controllers;

use App\Models\MeetingRoom;
use App\Models\BranchDetails as Branch;
use Illuminate\Http\Request;

class MeetingRoomController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected branch ID from the request
        $branchId = $request->branch_id;
        
        // Start with a base query
        $meetingRoomsQuery = MeetingRoom::with('branch')->orderBy('created_at', 'desc');
        
        // Apply branch filter if selected
        if ($branchId) {
            $meetingRoomsQuery->where('branch_id', $branchId);
        }
        
        // Execute the query with pagination (10 items per page)
        $meetingRooms = $meetingRoomsQuery->paginate(10);
        
        // Get all branches for the dropdown
        $branches = Branch::orderBy('branch_name')->get();
        
        return view('meeting_rooms.index', compact('meetingRooms', 'branches', 'branchId'));
    }

    public function create()
    {
        $branches = Branch::orderBy('branch_name')->get();
        return view('meeting_rooms.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'branch_id' => 'required|exists:branch_details,branch_id',
        ]);

        MeetingRoom::create($request->all());

        return redirect()->route('meeting_rooms.index')->with('success', 'Meeting Room added successfully.');
    }

    public function edit($id)
    {
        $room = MeetingRoom::findOrFail($id);
        $branches = Branch::orderBy('branch_name')->get();
        return view('meeting_rooms.edit', compact('room', 'branches'));
    }

    public function update(Request $request, $id)
    {
        $room = MeetingRoom::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'branch_id' => 'required|exists:branch_details,branch_id',
        ]);

        $room->update($request->all());

        return redirect()->route('meeting_rooms.index')->with('success', 'Meeting Room updated successfully.');
    }

    public function destroy($id)
    {
        $room = MeetingRoom::findOrFail($id);
        $room->delete();

        return redirect()->route('meeting_rooms.index')->with('success', 'Meeting Room deleted successfully.');
    }
}
