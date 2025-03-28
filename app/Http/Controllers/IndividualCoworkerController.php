<?php
namespace App\Http\Controllers;
use App\Models\IndividualCoworker;
use App\Models\BranchDetails as Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndividualCoworkerController extends Controller
{
    public function create()
    {
        $branches = Branch::orderBy('branch_name')->get();
        return view('addCoworker.addIndividual', compact('branches'));
    }
    public function index(Request $request)
    {
        // Get the selected branch ID from the request
        $branchId = $request->branch_id;
        
        // Start with a base query
        $coworkersQuery = IndividualCoworker::with('branch');
        
        // Apply branch filter if selected
        if ($branchId) {
            $coworkersQuery->where('branch_id', $branchId);
        }
        
        // Execute the query with pagination
        $coworkers = $coworkersQuery->paginate(10);
        
        // Get all branches for the dropdown
        $branches = Branch::orderBy('branch_name')->get();
        
        return view('addCoworker.display', compact('coworkers', 'branches', 'branchId'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'branch_id' => 'required|exists:branch_details,branch_id',
            'seat_type' => 'required|in:dedicated_seat,private_office',
            'private_office_size' => 'nullable|in:8_person,16_person,22_person,40_person',
            'no_of_seats' => 'nullable|integer',
            'joining_date' => 'nullable|date',
            'contract_copy' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
        ]);

        if ($request->hasFile('contract_copy')) {
            $filePath = $request->file('contract_copy')->store('contracts', 'public');
            $validated['contract_copy'] = $filePath;
        }

        IndividualCoworker::create($validated);

        return redirect()->route('addCoworker.display')->with('success', 'Coworker added successfully.');
    }
    public function edit($coworker_id)
    {
        $coworker = IndividualCoworker::findOrFail($coworker_id); // Fetch the coworker to edit
        $branches = Branch::orderBy('branch_name')->get(); // Fetch branches for dropdown

        return view('addcoworker.edit', compact('coworker', 'branches')); // Return edit view
    }

    public function update(Request $request, $coworker_id)
    {
        try {
            $coworker = IndividualCoworker::findOrFail($coworker_id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'contact_info' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'branch_id' => 'required|exists:branch_details,branch_id',
                'seat_type' => 'required|in:dedicated_seat,private_office',
                'private_office_size' => 'nullable|in:8_person,16_person,22_person,40_person',
                'no_of_seats' => 'nullable|integer',
                'joining_date' => 'nullable|date',
                'contract_copy' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            ]);

            if ($request->hasFile('contract_copy')) {
                // Delete old file if it exists
                if ($coworker->contract_copy) {
                    Storage::disk('public')->delete($coworker->contract_copy);
                }

                // Store new file
                $filePath = $request->file('contract_copy')->store('contracts', 'public');
                $validated['contract_copy'] = $filePath;
            }

            // Update coworker
            $coworker->update($validated);

            return redirect()->route('addCoworker.display')->with('success', 'Coworker updated successfully.');
        } catch (\Exception $e) {
            // Log::error('Update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the coworker: ' . $e->getMessage());
        }
    }


    public function destroy($coworker_id)
    {
        $coworker = IndividualCoworker::findOrFail($coworker_id);

        if ($coworker->contract_copy) {
            Storage::disk('public')->delete($coworker->contract_copy);
        }

        $coworker->delete();

        return redirect()->route('addCoworker.display')->with('success', 'Coworker deleted successfully.');
    }
}
