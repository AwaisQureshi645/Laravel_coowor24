<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\BranchDetails;
use App\Models\IndividualCoworker;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    /**
     * Display the seating management view.
     */
    public function index()
    {
        $branches = BranchDetails::all();
        return view('seats.index', compact('branches'));
    }

    /**
     * Fetch seats dynamically based on branch selection.
     */
    public function fetchSeats(Request $request)
    {
        $branchId = $request->get('branch_id');

        $seats = Seat::with(['branch', 'coworker'])
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })
            ->get();

        return response()->json($seats);
    }

    /**
     * Add a new seat.
     */
    public function addSeat(Request $request)
    {
        $validated = $request->validate([
            'seat_count' => 'required|integer|min:1', // Number of seats to add
            'branch_id' => 'required|exists:branch_details,branch_id',
            'assign_coworker_name' => 'nullable|string|max:255',
        ]);
    
        $seats = [];
        for ($i = 0; $i < $validated['seat_count']; $i++) {
            $seats[] = [
                'seat_number' => 'S-' . uniqid(), // Generate unique seat number
                'branch_id' => $validated['branch_id'],
                'status' => 'available',
                'assign_coworker_name' => $validated['assign_coworker_name'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        Seat::insert($seats); // Insert multiple rows
    
        return response()->json(['success' => true, 'message' => 'Seats added successfully!']);
    }
    

    /**
     * Delete a seat by its ID.
     */
    public function deleteSeat(Request $request)
    {
        $validated = $request->validate([
            'seat_id' => 'required|exists:seats,seat_id',
        ]);

        $seat = Seat::findOrFail($validated['seat_id']);
        $seat->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Update seat details.
     */
    public function updateSeat(Request $request)
    {
        $validated = $request->validate([
            'seat_id' => 'required|exists:seats,seat_id',
            'branch_id' => 'required|exists:branch_details,branch_id',
            'coworker_id' => 'nullable|exists:individual_coworkers,coworker_id',
        ]);
    
        $seat = Seat::findOrFail($validated['seat_id']);
        $seat->update([
            'branch_id' => $validated['branch_id'],
            'coworker_id' => $validated['coworker_id'],
            'status' => $validated['coworker_id'] ? 'occupied' : 'available',
        ]);
    
        return response()->json(['success' => true, 'message' => 'Seat updated successfully!']);
    }
    
    /**
     * Fetch all branches.
     */
    public function fetchBranches()
    {
        $branches = BranchDetails::all();
        return response()->json($branches);
    }

    /**
     * Fetch all coworkers.
     */
    public function fetchCoworkers()
    {
        $coworkers = IndividualCoworker::all();
        return response()->json($coworkers);
    }
}
