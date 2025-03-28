<?php
namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\BranchDetails;
use Illuminate\Http\Request;


class OfficeController extends Controller
{
    public function create()
    {
        $branches = BranchDetails::orderBy('branch_name')->get();
        return view('offices.create', compact('branches'));
    }

    public function index(Request $request)
    {
        // Get the selected branch ID from the request
        $branchId = $request->branch_id;
        
        // Start with a base query
        $officesQuery = Office::with('branch')->orderBy('created_at', 'desc');
        
        // Apply branch filter if selected
        if ($branchId) {
            $officesQuery->where('branch_id', $branchId);
        }
        
        // Execute the query with pagination (10 items per page)
        $offices = $officesQuery->paginate(10);
        
        // Get all branches for the dropdown
        $branches = BranchDetails::orderBy('branch_name')->get();
        
        return view('offices.index', compact('offices', 'branches', 'branchId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'RoomNo' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'Price' => 'required|numeric',
            'branch_id' => 'exists:branch_details,branch_id',
            'status' => 'required|in:Available,Not Available',
        ]);

        $data = $request->only(['RoomNo', 'capacity', 'Price', 'branch_id', 'status']);
        Office::create($data);

        return redirect()->route('offices.index')->with('success', 'Office added successfully.');
    }

    public function edit($id)
    {
        $office = Office::findOrFail($id);
        $branches = BranchDetails::orderBy('branch_name')->get();
        return view('offices.edit', compact('office', 'branches'));
    }

    public function update(Request $request, $id)
    {
        $office = Office::findOrFail($id);

        $request->validate([
            'RoomNo' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'Price' => 'required|numeric',
            'branch_id' => 'exists:branch_details,branch_id',
            'status' => 'required|in:Available,Not Available',
        ]);

        $office->update($request->only(['RoomNo', 'capacity', 'Price', 'branch_id', 'status']));

        return redirect()->route('offices.index')->with('success', 'Office updated successfully.');
    }

    public function destroy($id)
    {
        $office = Office::findOrFail($id);
        $office->delete();

        return redirect()->route('offices.index')->with('success', 'Office deleted successfully.');
    }
}
