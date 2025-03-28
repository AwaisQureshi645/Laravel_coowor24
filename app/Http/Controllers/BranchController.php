<?php

namespace App\Http\Controllers;

use App\Models\BranchDetails;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        // Paginate branches (10 per page) and order by latest entries
        $branches = BranchDetails::orderBy('branch_id', 'desc')->paginate(10);
        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        // Show the form to create a branch
        return view('branches.create');
    }

    public function store(Request $request)
    {
        // Validate and save branch data
        $request->validate([
        
            'branch_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_details' => 'required|string|max:255',
            'manager_name' => 'required|string|max:255',
        ]);

        BranchDetails::create([
            'branch_id' => $request->branch_id,
            'branch_name' => $request->branch_name,
            'location' => $request->location,
            'contact_details' => $request->contact_details,
            'manager_name' => $request->manager_name,
        ]);

        return redirect()->route('branches.index')->with('success', 'Branch added successfully.');
    }

    public function edit(BranchDetails $branch)
    {
        // Show the edit form for the branch
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, BranchDetails $branch)
    {
        // Validate and update branch data
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_details' => 'required|string|max:255',
            'manager_name' => 'required|string|max:255',
        ]);

        $branch->update([
            'branch_name' => $request->branch_name,
            'location' => $request->location,
            'contact_details' => $request->contact_details,
            'manager_name' => $request->manager_name,
        ]);

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    public function destroy(BranchDetails $branch)
    {
        // Delete the branch
        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');
    }
}
