<?php
namespace App\Http\Controllers;

use App\Models\BranchDetails ;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        // Display all branches
        $branches = BranchDetails ::all();
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

        BranchDetails ::create([
            'branch_name' => $request->branch_name,
            'location' => $request->location,
            'contact_details' => $request->contact_details,
            'manager_name' => $request->manager_name,
        ]);

        return redirect()->route('branches.index')->with('success', 'Branch added successfully.');
    }
}

