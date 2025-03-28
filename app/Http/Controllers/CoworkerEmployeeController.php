<?php

namespace App\Http\Controllers;

use App\Models\CoworkerEmployee;
use App\Models\BranchDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\CoworkerUser;
class CoworkerEmployeeController extends Controller
{
    // Display a list of all employees
    public function index()
    {
        $employees = CoworkerEmployee::with('branch')->orderBy('created_at', 'desc')->get();
        return view('employees.index', compact('employees'));
    }

    // Show the form to create a new employee
    public function create()
    {
        $branches = BranchDetails::orderBy('branch_name')->get();
        return view('employees.create', compact('branches'));
    }
   
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|unique:coworker_users,email',
                'password' => 'required|string|min:6',
                'phonenumber' => 'required|string|max:15',
                'role' => 'required|string|max:50',
                'branch_id' => 'required|exists:branch_details,branch_id',
                'cnic' => 'required|string|max:15',
                'address' => 'required|string|max:255',
                'cnic_pic' => 'nullable|image|max:1024',
            ]);
    
            $path = $request->file('cnic_pic') 
                ? $request->file('cnic_pic')->store('uploads/cnic', 'public') 
                : null;
    
            CoworkerUser::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phonenumber' => $validated['phonenumber'],
                'role' => $validated['role'],
                'branch_id' => $validated['branch_id'],
                'cnic' => $validated['cnic'],
                'address' => $validated['address'],
                'cnic_pic' => $path,
            ]);
    
            return redirect()->route('coworkerusers.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    // Show the form to edit an employee
    public function edit($coworker_employees_id)
    {
        $employee = CoworkerEmployee::findOrFail($coworker_employees_id);
        $branches = BranchDetails::orderBy('branch_name')->get();
        return view('employees.edit', compact('employee', 'branches'));
    }

    // Update an employee in the database
    public function update(Request $request, $coworker_employees_id)
    {
        $employee = CoworkerEmployee::findOrFail($coworker_employees_id);

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:coworker_employees,email,' . $coworker_employees_id . ',coworker_employees_id',
            'phonenumber' => 'required|string|max:15',
            'role' => 'required|string|max:50',
            'branch_id' => 'required|exists:branch_details,branch_id',
            'cnic' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'cnic_pic' => 'nullable|image|max:1024',
        ]);

        // Handle optional CNIC pic upload
        if ($request->hasFile('cnic_pic')) {
            $path = $request->file('cnic_pic')->store('uploads/cnic', 'public');
            $employee->cnic_pic = $path;
        }

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    // Delete an employee from the database
    public function destroy($coworker_employees_id)
    {
        $employee = CoworkerEmployee::findOrFail($coworker_employees_id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
