<?php
namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\BranchDetails as Branch;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function create()
    {
        $branches = Branch::orderBy('branch_name')->get();
        return view('visits.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purpose' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'businessDetails' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:15',
            'assignedTo' => 'nullable|string|max:255',
            'branch_id' => 'required|exists:branch_details,branch_id',
            'Comments' => 'nullable|string',
            'appointment_date' => 'required|date',
        ]);

        Visit::create($validated);

        return redirect()->route('visits.index')->with('success', 'Visitor record added successfully.');
    }
    public function index(Request $request)
    {
        // Get the selected branch ID from the request
        $branchId = $request->branch_id;
        
        // Start with a base query
        $visitsQuery = Visit::with('branch')->orderBy('appointment_date', 'desc');
        
        // Apply branch filter if selected
        if ($branchId) {
            $visitsQuery->where('branch_id', $branchId);
        }
        
        // Execute the query with pagination
        $visits = $visitsQuery->paginate(10);
        
        // Get all branches for the dropdown
        $branches = Branch::orderBy('branch_name')->get();
        
        return view('visits.index', compact('visits', 'branches', 'branchId'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'purpose' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'businessDetails' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:15',
            'assignedTo' => 'nullable|string|max:255',
            'branch_id' => 'required|exists:branch_details,branch_id',
            'Comments' => 'nullable|string',
            'appointment_date' => 'required|date',
        ]);

        $visit = Visit::findOrFail($id);
        $visit->update($validated);

        return redirect()->route('visits.index')->with('success', 'Visitor record updated successfully.');
    }

    public function destroy($id)
    {
        $visit = Visit::findOrFail($id);
        $visit->delete();

        return redirect()->route('visits.index')->with('success', 'Visitor record deleted successfully.');
    }
    public function edit($id)
{
    $visit = Visit::findOrFail($id); // Fetch the visit record or fail if not found
    $branches = Branch::orderBy('branch_name')->get(); // Fetch all branches

    return view('visits.edit', compact('visit', 'branches')); // Return the edit view
}

    

}
