<?php

namespace App\Http\Controllers;

use App\Models\TeamBooking;
use App\Models\BranchDetails as Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamBookingController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected branch ID from the request
        $branchId = $request->branch_id;
        
        // Start with a base query
        $teamBookingsQuery = TeamBooking::with('branch')->orderBy('created_at', 'desc');
        
        // Apply branch filter if selected
        if ($branchId) {
            $teamBookingsQuery->where('branch_id', $branchId);
        }
        
        // Execute the query with pagination (10 items per page)
        $teamBookings = $teamBookingsQuery->paginate(10);
        
        // Get all branches for the dropdown
        $branches = Branch::orderBy('branch_name')->get();
        
        return view('teamBookings.index', compact('teamBookings', 'branches', 'branchId'));
    }

    public function create()
    {
        $branches = Branch::orderBy('branch_name')->get();
    return view('teamBookings.create', compact('branches'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'team_name' => 'required|string|max:255',
                'joining_date' => 'required|date',
                'ending_date' => 'required|date|after:joining_date',
                'security_amount' => 'required|numeric',
                'point_of_contact' => 'required|string',
                'num_members' => 'required|integer',
                'branch_id' => 'required|exists:branch_details,branch_id',
                'reference' => 'nullable|string|max:255',
                'contract_copy' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            ]);
    
            if ($request->hasFile('contract_copy')) {
                $filePath = $request->file('contract_copy')->store('contracts', 'public');
                $validated['contract_copy'] = $filePath;
            }
    
            TeamBooking::create($validated);
    
            // Redirect with success message
            return redirect()->route('teamBookings.index')->with('success', 'Team booking added successfully.');
        } catch (\Exception $e) {
            // Redirect back with error message
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
    
    
    public function edit($id)
    {
        $teamBooking = TeamBooking::findOrFail($id); // Fetch the booking record
        $branches = Branch::orderBy('branch_name')->get(); // Fetch branches for the dropdown
        return view('teamBookings.edit', compact('teamBooking', 'branches')); // Return the edit view
    }
    
    public function update(Request $request, $id)
    {
        $teamBooking = TeamBooking::findOrFail($id); // Find the booking record
    
        $validated = $request->validate([
            'team_name' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'ending_date' => 'required|date|after:joining_date',
            'security_amount' => 'required|numeric',
            'point_of_contact' => 'required|string',
            'num_members' => 'required|integer',
            'branch_id' => 'required|exists:branch_details,branch_id',
            'reference' => 'nullable|string|max:255',
            'contract_copy' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
        ]);
    
        // Handle contract copy upload
        if ($request->hasFile('contract_copy')) {
            if ($teamBooking->contract_copy) {
                Storage::disk('public')->delete($teamBooking->contract_copy);
            }
            $filePath = $request->file('contract_copy')->store('contracts', 'public');
            $validated['contract_copy'] = $filePath;
        }
    
        // Update the booking record
        $teamBooking->update($validated);
    
        return redirect()->route('teamBookings.index')->with('success', 'Team booking updated successfully.');
    }
    

    public function destroy($id)
    {
        $teamBooking = TeamBooking::findOrFail($id);

        if ($teamBooking->contract_copy) {
            Storage::disk('public')->delete($teamBooking->contract_copy);
        }

        $teamBooking->delete();

        return redirect()->route('teamBookings.index')->with('success', 'Team booking deleted successfully.');
    }
}
