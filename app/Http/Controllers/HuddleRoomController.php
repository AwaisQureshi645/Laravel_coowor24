<?php

namespace App\Http\Controllers;

use App\Models\HuddleRoom;
use App\Models\BranchDetails as Branch;
use Illuminate\Http\Request;

class HuddleRoomController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected branch ID from the request
        $branchId = $request->branch_id;
        
        // Start with a base query
        $huddleRoomsQuery = HuddleRoom::with('branch')->orderBy('created_at', 'desc');
        
        // Apply branch filter if selected
        if ($branchId) {
            $huddleRoomsQuery->where('branch_id', $branchId);
        }
        
        // Execute the query with pagination (10 items per page)
        $huddleRooms = $huddleRoomsQuery->paginate(10);
        
        // Get all branches for the dropdown
        $branches = Branch::orderBy('branch_name')->get();
        
        return view('huddle_rooms.index', compact('huddleRooms', 'branches', 'branchId'));
    }

    public function create()
    {
        $branches = Branch::orderBy('branch_name')->get();
        return view('huddle_rooms.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'branch_id' => 'required|exists:branch_details,branch_id',
        ]);

        HuddleRoom::create($request->all());

        return redirect()->route('huddle_rooms.index')->with('success', 'Huddle Room added successfully.');
    }

    public function edit($id)
    {
        $huddleRoom = HuddleRoom::findOrFail($id);
        $branches = Branch::orderBy('branch_name')->get();
        return view('huddle_rooms.edit', compact('huddleRoom', 'branches'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'branch_id' => 'required|exists:branch_details,branch_id',
        ]);

        $huddleRoom = HuddleRoom::findOrFail($id);
        $huddleRoom->update($request->all());

        return redirect()->route('huddle_rooms.index')->with('success', 'Huddle Room updated successfully.');
    }

    public function destroy($id)
    {
        $huddleRoom = HuddleRoom::findOrFail($id);
        $huddleRoom->delete();

        return redirect()->route('huddle_rooms.index')->with('success', 'Huddle Room deleted successfully.');
    }
}
