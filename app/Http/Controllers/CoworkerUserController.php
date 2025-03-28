<?php

namespace App\Http\Controllers;

use App\Models\CoworkerUser;
use App\Models\BranchDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CoworkerUserController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected branch ID from the request
        $branchId = $request->branch_id;
        
        // Start with a base query
        $usersQuery = CoworkerUser::with('branch')->orderBy('created_at', 'desc');
        
        // Apply branch filter if selected
        if ($branchId) {
            $usersQuery->where('branch_id', $branchId);
        }
        
        // Execute the query with pagination (10 items per page)
        $users = $usersQuery->paginate(10);
        
        // Get all branches for the dropdown
        $branches = BranchDetails::orderBy('branch_name')->get();
        
        return view('coworkerusers.index', compact('users', 'branches', 'branchId'));
    }

    public function create()
    {
        $branches = BranchDetails::orderBy('branch_name')->get();
        return view('coworkerusers.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string',
            'phonenumber' => 'required|string',
            'role' => 'required|string|max:50',
            'branch_id' => 'required|exists:branch_details,branch_id',
            'cnic' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'cnic_pic' => 'nullable|image|max:2048', // Optional image upload
        ]);
    
        $path = $request->file('cnic_pic') ? $request->file('cnic_pic')->store('uploads/cnic', 'public') : null;
    
        CoworkerUser::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Store password without hashing
            'phonenumber' => $validated['phonenumber'],
            'role' => $validated['role'],
            'branch_id' => $validated['branch_id'],
            'cnic' => $validated['cnic'],
            'address' => $validated['address'],
            'cnic_pic' => $path,
        ]);
    
        return redirect()->route('coworkerusers.index')->with('success', 'User created successfully.');
    }

    public function edit($coworker_users_id)
    {
        $user = CoworkerUser::findOrFail($coworker_users_id);
        $branches = BranchDetails::orderBy('branch_name')->get();
        return view('coworkerusers.edit', compact('user', 'branches'));
    }

    public function update(Request $request, $coworker_users_id)
    {
        // Find the user based on the primary key (coworker_users_id)
        $user = CoworkerUser::findOrFail($coworker_users_id);
    
        // Validate the incoming data
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'phonenumber' => 'required|string|max:15',
            'role' => 'required|string|max:50',
            'branch_id' => 'required|exists:branch_details,branch_id',
            'cnic' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'cnic_pic' => 'nullable|image|max:1024', // Optional image upload
        ]);
    
        // Handle CNIC image upload if present
        if ($request->hasFile('cnic_pic')) {
            $path = $request->file('cnic_pic')->store('uploads/cnic', 'public');
            $user->cnic_pic = $path;
        }
    
        // Update the user's attributes
        $user->update($validated);
    
        // Redirect back with success message
        return redirect()->route('coworkerusers.index')->with('success', 'User updated successfully.');
    }
    

    public function destroy($coworker_users_id)
    {
        $user = CoworkerUser::findOrFail($coworker_users_id);
        $user->delete();

        return redirect()->route('coworkerusers.index')->with('success', 'User deleted successfully.');
    }
}
